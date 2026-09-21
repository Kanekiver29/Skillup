<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\Backup;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use ZipArchive;

class BackupService
{
    protected string $backupDir = 'backups';

    public function ensureBackupDirectory(): void
    {
        if (! Storage::disk('local')->exists($this->backupDir)) {
            if (! Storage::disk('local')->makeDirectory($this->backupDir, 0755, true)) {
                $root = Storage::disk('local')->path('');
                $backupPath = $root . DIRECTORY_SEPARATOR . $this->backupDir;
                throw new \RuntimeException("Unable to create backup directory: {$backupPath}");
            }
        }
    }

    public function getBackupPath(string $filename): string
    {
        return Storage::disk('local')->path($this->backupDir . '/' . $filename);
    }

    public function buildBackupFilename(string $prefix = 'skillup_backup'): string
    {
        return sprintf('%s_%s.zip', $prefix, now()->format('Y-m-d_H-i')); 
    }

    public function resolveBackupPassword(?string $password = null): ?string
    {
        $value = $password ?? config('backup.password');

        if (is_string($value)) {
            $trimmed = trim($value);
            if ($trimmed !== '') {
                return $trimmed;
            }
        }

        return null;
    }

    public function encryptArchiveIfNeeded(string $archivePath, ?string $password = null): string
    {
        $resolvedPassword = $this->resolveBackupPassword($password);
        if ($resolvedPassword === null || $resolvedPassword === '') {
            return $archivePath;
        }

        if (file_exists($archivePath) === false) {
            throw new \RuntimeException('Archive not found for encryption: ' . $archivePath);
        }

        $encryptedPath = preg_replace('/\.(zip|tar|gz)$/i', '_encrypted.7z', $archivePath);
        $binary = $this->resolveCommand('7z', ['7z', '7zz', '7za']);

        if ($binary === null) {
            throw new \RuntimeException('7-Zip is required for encrypted backups. Install 7-Zip and add its installation directory to PATH.');
        }

        $commands = [
            [$binary, 'a', '-t7z', '-mhe=on', '-p' . $resolvedPassword, $encryptedPath, basename($archivePath)],
        ];

        foreach ($commands as $command) {
            $binary = $command[0];
            $process = new Process($command, dirname($archivePath));
            $process->setTimeout(3600);
            $process->run();

            if (! $process->isSuccessful()) {
                throw new \RuntimeException('Failed to encrypt backup with 7-Zip.');
            }

            @unlink($archivePath);
            return $encryptedPath;
        }

        throw new \RuntimeException('Unable to encrypt backup archive.');
    }

    /**
     * Run one complete backup while holding a distributed lock and recording its result.
     */
    public function runRecordedBackup(string $type = 'manual', ?int $userId = null, bool $includeAll = false): Backup
    {
        $lock = Cache::lock('skillup:backup:run', 7200);
        if (! $lock->get()) {
            throw new \RuntimeException('Another backup is already running. Please try again later.');
        }

        $record = Backup::create([
            'filename' => 'pending',
            'path' => $this->backupDir,
            'type' => $type,
            'status' => 'pending',
            'created_by' => $userId,
            'started_at' => now(),
        ]);

        try {
            $this->ensureBackupDirectory();
            $filename = $this->buildBackupFilename('skillup_backup');
            $path = $this->getBackupPath($filename);
            $temporaryPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filename . '.part';
            @unlink($temporaryPath);
            $this->createFullBackup($temporaryPath, $includeAll);
            if (! @rename($temporaryPath, $path)) {
                if (! @copy($temporaryPath, $path)) {
                    throw new \RuntimeException('The completed backup archive could not be moved into the backup directory.');
                }
                @unlink($temporaryPath);
            }
            $finalPath = $this->encryptArchiveIfNeeded($path);

            $record->update([
                'filename' => basename($finalPath),
                'path' => $this->backupDir . '/' . basename($finalPath),
                'size' => filesize($finalPath) ?: 0,
                'checksum' => hash_file('sha256', $finalPath),
                'status' => 'success',
                'message' => 'Backup completed successfully.',
                'completed_at' => now(),
            ]);

            return $record->fresh();
        } catch (\Throwable $exception) {
            $record->update([
                'status' => 'failed',
                'message' => $exception->getMessage(),
                'completed_at' => now(),
            ]);
            throw $exception;
        } finally {
            optional($lock)->release();
        }
    }

    public function createFullBackup(string $zipPath, bool $includeAll = true): string
    {
        if (function_exists('set_time_limit')) {
            @set_time_limit(0);
        }
        @ignore_user_abort(true);

        $zip = new ZipArchive();
        $opened = false;

        $backupDirPath = dirname($zipPath);
        if (! is_dir($backupDirPath)) {
            if (! @mkdir($backupDirPath, 0755, true) && ! is_dir($backupDirPath)) {
                throw new \RuntimeException('Backup directory is not creatable: ' . $backupDirPath);
            }
        }
        if (! is_writable($backupDirPath)) {
            throw new \RuntimeException('Backup directory is not writable: ' . $backupDirPath . '. Adjust filesystem permissions.');
        }

        $testFile = $backupDirPath . DIRECTORY_SEPARATOR . '.backup_write_test';
        try {
            file_put_contents($testFile, 'ok');
            @unlink($testFile);
        } catch (\Throwable $e) {
            throw new \RuntimeException('Backup directory write test failed: ' . $e->getMessage());
        }

        $prevHandler = set_error_handler(function ($severity, $message, $file, $line) {
            throw new \ErrorException($message, 0, $severity, $file, $line);
        });

        try {
            $res = $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
            if ($res !== true) {
                throw new \RuntimeException('Unable to create ZIP archive. ZipArchive::open returned: ' . (int) $res);
            }
            $opened = true;

            $projectRoot = base_path();
            $connection = config('database.default');
            $driver = config("database.connections.{$connection}.driver");
            $dbBackupName = 'database_' . now()->format('Ymd_His') . '.' . ($driver === 'sqlite' ? 'sqlite' : 'sql');
            $dbBackupPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $dbBackupName;

            if ($driver === 'mysql') {
                $this->createMysqlBackup($dbBackupPath);
            } elseif ($driver === 'sqlite') {
                $sqlitePath = config('database.connections.sqlite.database');
                if ($sqlitePath && $sqlitePath !== ':memory:' && file_exists($sqlitePath)) {
                    copy($sqlitePath, $dbBackupPath);
                }
            }

            if (file_exists($dbBackupPath)) {
                $added = $zip->addFile($dbBackupPath, 'database/' . $dbBackupName);
                if ($added === false) {
                    throw new \RuntimeException('Failed to add database backup to ZIP: ' . $dbBackupPath);
                }
            }

            $includeDirs = [
                'app', 'bootstrap', 'config', 'database', 'resources', 'routes', 'storage/app/public',
                'public/uploads', 'public/images', 'public/image', 'public/presentations', 'public/video'
            ];
            if ($includeAll) {
                $includeDirs[] = 'vendor';
                $includeDirs[] = 'node_modules';
            }

            $excludeDirs = [
                '.git',
                'storage/framework/cache',
                'storage/framework/sessions',
                'storage/logs',
                'storage/app/private/backups',
                'storage/app/backups',
                '.env',
            ];
            if (! $includeAll) {
                $excludeDirs[] = 'node_modules';
                $excludeDirs[] = 'vendor';
            }

            $includeFiles = ['artisan', 'composer.json', 'composer.lock', 'package.json', 'package-lock.json', 'vite.config.js', '.env.example', 'README.md', '.gitignore', '.htaccess', 'phpunit.xml'];

            // Also include any top-level root files, such as .env, hidden files, and additional config files.
            $rootFiles = new \FilesystemIterator(base_path(), \FilesystemIterator::SKIP_DOTS);
            foreach ($rootFiles as $rootFile) {
                if ($rootFile->isFile()) {
                    $basename = $rootFile->getFilename();
                    if (! in_array($basename, $includeFiles, true) && $basename !== '.env') {
                        $includeFiles[] = $basename;
                    }
                }
            }

            foreach ($includeFiles as $file) {
                $filePath = $projectRoot . DIRECTORY_SEPARATOR . $file;
                if (file_exists($filePath) && is_file($filePath)) {
                    $added = $zip->addFile($filePath, $file);
                    if ($added === false) {
                        throw new \RuntimeException('Failed to add file to ZIP: ' . $filePath);
                    }
                }
            }

            foreach ($includeDirs as $dir) {
                $dirPath = $projectRoot . DIRECTORY_SEPARATOR . $dir;
                if (is_dir($dirPath)) {
                    $this->addDirToZip($dirPath, $zip, $projectRoot, $excludeDirs);
                }
            }

            if ($opened) {
                $zip->close();
                $opened = false;
            }

            if (file_exists($dbBackupPath)) {
                @unlink($dbBackupPath);
            }

            return $zipPath;
        } catch (\Throwable $e) {
            Log::error('BackupService::createFullBackup failed', ['zipPath' => $zipPath, 'exception' => $e]);
            if ($opened) {
                try {
                    $zip->close();
                } catch (\Throwable $closeException) {
                    Log::warning('Backup ZIP could not be closed after failure.', ['exception' => $closeException]);
                }
            }
            if (file_exists($dbBackupPath)) {
                @unlink($dbBackupPath);
            }
            throw $e;
        } finally {
            if (isset($prevHandler) && $prevHandler !== null) {
                set_error_handler($prevHandler);
            } else {
                restore_error_handler();
            }
        }
    }

    protected function addDirToZip(string $dirPath, ZipArchive $zip, string $projectRoot, array $excludeDirs): void
    {
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dirPath), \RecursiveIteratorIterator::LEAVES_ONLY);

        foreach ($files as $file) {
            if ($file->isDir()) continue;
            if ($file->isLink()) continue;
            $rawPath = str_replace('\\', '/', $file->getPathname());
            $publicStoragePath = str_replace('\\', '/', $projectRoot . DIRECTORY_SEPARATOR . 'public/storage');
            if (str_starts_with($rawPath, $publicStoragePath . '/')) continue;
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($projectRoot) + 1);
            if (str_starts_with(str_replace('\\', '/', $relativePath), 'public/storage/')) continue;

            $skip = false;
            foreach ($excludeDirs as $excludeDir) {
                if (strpos(str_replace('\\', '/', $relativePath), str_replace('\\', '/', $excludeDir)) === 0) {
                    $skip = true; break;
                }
            }

            if (! $skip) {
                $added = $zip->addFile($filePath, str_replace('\\', '/', $relativePath));
                if ($added === false) {
                    throw new \RuntimeException('Failed to add file to ZIP: ' . $filePath . ' (relative: ' . $relativePath . ')');
                }
            }
        }
    }

    public function createFullBackupPhar(string $tarPath, bool $includeAll = true): string
    {
        if (function_exists('set_time_limit')) {
            @set_time_limit(0);
        }
        @ignore_user_abort(true);

        if (! class_exists('PharData')) {
            throw new \RuntimeException('PharData not available.');
        }
        if (ini_get('phar.readonly') == '1') {
            throw new \RuntimeException('phar.readonly is enabled; cannot write Phar archives.');
        }

        $projectRoot = base_path();
        $dbBackupName = 'database_' . now()->format('Ymd_His') . '.sql';
        $dbBackupPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $dbBackupName;

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'mysql') {
            $this->createMysqlBackup($dbBackupPath);
        } elseif ($driver === 'sqlite') {
            $sqlitePath = config('database.connections.sqlite.database');
            if ($sqlitePath && $sqlitePath !== ':memory:' && file_exists($sqlitePath)) {
                copy($sqlitePath, $dbBackupPath);
            }
        }

        try {
            if (file_exists($tarPath)) @unlink($tarPath);
            $phar = new \PharData($tarPath);

            if (file_exists($dbBackupPath)) {
                $phar->addFile($dbBackupPath, 'database/' . $dbBackupName);
            }

            $includeDirs = [ 'app', 'bootstrap', 'config', 'database', 'public', 'resources', 'routes', 'storage', 'tests', '.github' ];
            if ($includeAll) { $includeDirs[] = 'vendor'; $includeDirs[] = 'node_modules'; }
            $excludeDirs = [
                '.git',
                'storage/framework/cache',
                'storage/framework/sessions',
                'storage/logs',
                'storage/app/private/backups',
                'storage/app/backups',
            ];
            if (! $includeAll) { $excludeDirs[] = 'node_modules'; $excludeDirs[] = 'vendor'; }
            $includeFiles = ['artisan', 'composer.json', 'composer.lock', 'package.json', 'package-lock.json', 'vite.config.js', '.env.example', 'README.md', '.gitignore', '.htaccess', 'phpunit.xml'];
            $rootFiles = new \FilesystemIterator(base_path(), \FilesystemIterator::SKIP_DOTS);
            foreach ($rootFiles as $rootFile) {
                if ($rootFile->isFile()) {
                    $basename = $rootFile->getFilename();
                    if (! in_array($basename, $includeFiles, true)) {
                        $includeFiles[] = $basename;
                    }
                }
            }

            foreach ($includeFiles as $file) {
                $filePath = $projectRoot . DIRECTORY_SEPARATOR . $file;
                if (file_exists($filePath) && is_file($filePath)) {
                    $phar->addFile($filePath, $file);
                }
            }

            foreach ($includeDirs as $dir) {
                $dirPath = $projectRoot . DIRECTORY_SEPARATOR . $dir;
                if (! is_dir($dirPath)) continue;
                $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dirPath));
                foreach ($it as $f) {
                    if ($f->isDir()) continue;
                    $filePath = $f->getRealPath();
                    $relative = substr($filePath, strlen($projectRoot) + 1);
                    $skip = false;
                    foreach ($excludeDirs as $exclude) {
                        if (strpos(str_replace('\\','/',$relative), str_replace('\\','/',$exclude)) === 0) { $skip = true; break; }
                    }
                    if ($skip) continue;
                    $phar->addFile($filePath, str_replace('\\','/',$relative));
                }
            }

            $compressed = $tarPath . '.gz';
            if (file_exists($compressed)) @unlink($compressed);
            $phar->compress(\Phar::GZ);
            if (file_exists($tarPath)) @unlink($tarPath);

            if (file_exists($dbBackupPath)) @unlink($dbBackupPath);

            return $compressed;
        } catch (\Throwable $e) {
            Log::error('BackupService::createFullBackupPhar failed', ['tarPath' => $tarPath, 'exception' => $e]);
            if (file_exists($tarPath)) @unlink($tarPath);
            if (file_exists($dbBackupPath)) @unlink($dbBackupPath);
            throw $e;
        }
    }

    public function createMysqlBackup(string $targetPath): void
    {
        $config = config('database.connections.mysql');
        if (! $config) {
            throw new \RuntimeException('MySQL configuration is missing.');
        }

        $mysqldump = $this->resolveCommand('mysqldump', ['mysqldump']);
        if ($mysqldump !== null) {
            $defaultsFile = $this->createMysqlDefaultsFile($config);
            $attempts = 3;
            $lastException = null;

            try {
                for ($attempt = 1; $attempt <= $attempts; $attempt++) {
                    $process = new Process([
                        $mysqldump,
                        '--defaults-extra-file=' . $defaultsFile,
                        '--host=' . ($config['host'] ?? '127.0.0.1'),
                        '--port=' . ($config['port'] ?? 3306),
                        '--protocol=TCP',
                        '--single-transaction',
                        '--routines',
                        '--triggers',
                        '--databases',
                        $config['database'] ?? '',
                    ]);

                    $process->setTimeout(3600);
                    $process->run();

                    if ($process->isSuccessful()) {
                        file_put_contents($targetPath, $process->getOutput());
                        return;
                    }

                    $lastException = new ProcessFailedException($process);

                    if ($attempt < $attempts && $this->isTransientMysqlDumpFailure($process)) {
                        usleep(750000);
                        continue;
                    }

                    break;
                }

                throw $lastException ?? new \RuntimeException('MySQL dump failed without a captured error.');
            } catch (\Throwable $e) {
                $this->createMysqlBackupFromQuery($targetPath);
                return;
            } finally {
                @unlink($defaultsFile);
            }
        }

        $this->createMysqlBackupFromQuery($targetPath);
    }

    protected function isTransientMysqlDumpFailure(Process $process): bool
    {
        $output = strtolower($process->getErrorOutput() . PHP_EOL . $process->getOutput());

        return str_contains($output, 'can\'t create tcp/ip socket')
            || str_contains($output, 'can\'t connect to mysql')
            || str_contains($output, 'connection refused')
            || str_contains($output, 'error 2004')
            || str_contains($output, 'temporary failure')
            || str_contains($output, 'timed out');
    }

    protected function createMysqlBackupFromQuery(string $targetPath): void
    {
        $pdo = DB::connection('mysql')->getPdo();
        $database = $pdo->query('select database()')->fetchColumn();
        if (! $database) throw new \RuntimeException('Unable to determine the current MySQL database.');

        $output = [];
        $output[] = '-- PHP generated MySQL backup';
        $output[] = 'SET FOREIGN_KEY_CHECKS = 0;';
        $output[] = 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";';
        $output[] = 'SET AUTOCOMMIT = 0;';
        $output[] = 'START TRANSACTION;';
        $output[] = "USE `{$database}`;";
        $output[] = '';

        $tables = $pdo->query('SHOW FULL TABLES WHERE Table_Type = "BASE TABLE"')->fetchAll(\PDO::FETCH_COLUMN);
        foreach ($tables as $table) {
            $row = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(\PDO::FETCH_ASSOC);
            if (! isset($row['Create Table'])) continue;
            $output[] = "DROP TABLE IF EXISTS `{$table}`;";
            $output[] = $row['Create Table'] . ';';
            $output[] = '';

            $stmt = $pdo->query("SELECT * FROM `{$table}`", \PDO::FETCH_ASSOC);
            $rows = $stmt->fetchAll();
            if (empty($rows)) continue;

            $columns = array_map(fn($column) => "`{$column}`", array_keys($rows[0]));
            $columnList = implode(', ', $columns);
            $insertChunks = [];
            foreach ($rows as $rowData) {
                $values = array_map(function ($value) use ($pdo) {
                    if ($value === null) return 'NULL';
                    if (is_bool($value)) return $value ? '1' : '0';
                    return $pdo->quote((string) $value);
                }, array_values($rowData));
                $insertChunks[] = '(' . implode(', ', $values) . ')';
            }

            foreach (array_chunk($insertChunks, 100) as $chunk) {
                $output[] = 'INSERT INTO `' . $table . '` (' . $columnList . ') VALUES ' . implode(', ', $chunk) . ';';
            }

            $output[] = '';
        }

        $output[] = 'COMMIT;';
        $output[] = 'SET FOREIGN_KEY_CHECKS = 1;';

        $content = implode("\n", $output) . "\n";
        file_put_contents($targetPath, $content);
    }

    protected function commandExists(string $command): bool
    {
        $check = PHP_OS_FAMILY === 'Windows' ? ['where', $command] : ['command', '-v', $command];
        $process = new Process($check);
        $process->run();
        return $process->isSuccessful();
    }

    protected function resolveCommand(string $environmentKey, array $commands): ?string
    {
        $configKey = $environmentKey === '7z' ? 'seven_zip_path' : strtolower($environmentKey) . '_path';
        $configured = config('backup.' . $configKey);
        if (is_string($configured) && $configured !== '' && is_file($configured)) {
            return $configured;
        }

        if ($environmentKey === '7z') {
            $candidates = array_merge($commands, [
                'C:\\Program Files\\7-Zip\\7z.exe',
                'C:\\Program Files (x86)\\7-Zip\\7z.exe',
            ]);
        } elseif ($environmentKey === 'mysqldump') {
            $candidates = array_merge($commands, [
                'C:\\xampp\\mysql\\bin\\mysqldump.exe',
            ]);
        } elseif ($environmentKey === 'mysql') {
            $candidates = array_merge($commands, [
                'C:\\xampp\\mysql\\bin\\mysql.exe',
            ]);
        } else {
            $candidates = $commands;
        }

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                return $candidate;
            }
            if (! str_contains($candidate, DIRECTORY_SEPARATOR) && $this->commandExists($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    protected function createMysqlDefaultsFile(array $config): string
    {
        $path = tempnam(sys_get_temp_dir(), 'skillup_mysql_');
        if ($path === false) {
            throw new \RuntimeException('Unable to create a temporary MySQL credential file.');
        }

        $contents = "[client]\n"
            . 'host=' . ($config['host'] ?? '127.0.0.1') . "\n"
            . 'port=' . ($config['port'] ?? 3306) . "\n"
            . 'user=' . ($config['username'] ?? '') . "\n"
            . 'password=' . ($config['password'] ?? '') . "\n";
        file_put_contents($path, $contents, LOCK_EX);

        return $path;
    }

    protected function restoreMysqlBackup(string $backupPath): void
    {
        $config = config('database.connections.mysql');
        $mysql = $this->resolveCommand('mysql', ['mysql']);
        if (! $config || $mysql === null) {
            throw new \RuntimeException('MySQL client is unavailable. Configure MYSQL_PATH or add XAMPP MySQL bin to PATH.');
        }

        $defaultsFile = $this->createMysqlDefaultsFile($config);
        try {
            $process = new Process([
                $mysql,
                '--defaults-extra-file=' . $defaultsFile,
                $config['database'] ?? '',
            ]);
            $process->setInput(file_get_contents($backupPath) ?: '');
            $process->setTimeout(3600);
            $process->run();
            if (! $process->isSuccessful()) {
                throw new \RuntimeException('MySQL restore failed.');
            }
        } finally {
            @unlink($defaultsFile);
        }
    }

    /**
     * Determine whether a backup file is a full archive (zip or tar.gz/tgz).
     */
    public function isFullArchive(string $path): bool
    {
        $lower = strtolower($path);
        return str_ends_with($lower, '.zip') || str_ends_with($lower, '.7z') || str_ends_with($lower, '.tar.gz') || str_ends_with($lower, '.tgz') || str_ends_with($lower, '.tar');
    }

    /**
     * Extract an archive to a temporary directory and return that directory path.
     */
    public function extractArchiveToTemp(string $archivePath, ?string $password = null): string
    {
        if (! file_exists($archivePath)) {
            throw new \RuntimeException('Archive not found: ' . $archivePath);
        }

        $tempDir = Storage::disk('local')->path($this->backupDir) . DIRECTORY_SEPARATOR . 'restore_tmp_' . now()->format('Ymd_His') . '_' . uniqid();
        if (! @mkdir($tempDir, 0755, true) && ! is_dir($tempDir)) {
            throw new \RuntimeException('Unable to create temp extraction directory: ' . $tempDir);
        }

        $lower = strtolower($archivePath);

        if (str_ends_with($lower, '.7z')) {
            $binary = collect(['7z', '7zz', '7za'])->first(fn (string $candidate) => $this->commandExists($candidate));
            if ($binary === null) {
                throw new \RuntimeException('7-Zip is required to restore encrypted backups.');
            }

            $command = [$binary, 'x', '-y', '-o' . $tempDir];
            if ($password !== null && $password !== '') {
                $command[] = '-p' . $password;
            }
            $command[] = $archivePath;
            $process = new Process($command);
            $process->setTimeout(3600);
            $process->run();
            if (! $process->isSuccessful()) {
                throw new \RuntimeException('Unable to decrypt or extract the backup archive. The password may be incorrect or the archive may be corrupted.');
            }

            $nestedArchives = glob($tempDir . DIRECTORY_SEPARATOR . '*.zip') ?: [];
            if (count($nestedArchives) === 1) {
                $nested = new ZipArchive();
                if ($nested->open($nestedArchives[0]) !== true || ! $nested->extractTo($tempDir . DIRECTORY_SEPARATOR . 'payload')) {
                    throw new \RuntimeException('The encrypted backup payload is corrupted.');
                }
                $nested->close();
                @unlink($nestedArchives[0]);
                rename($tempDir . DIRECTORY_SEPARATOR . 'payload', $tempDir . DIRECTORY_SEPARATOR . 'payload_extracted');
                $this->moveExtractedPayload($tempDir . DIRECTORY_SEPARATOR . 'payload_extracted', $tempDir);
            }

            return $tempDir;
        }

        if (str_ends_with($lower, '.zip')) {
            $zip = new ZipArchive();
            $res = $zip->open($archivePath);
            if ($res !== true) {
                throw new \RuntimeException('Unable to open ZIP archive for extraction. Code: ' . (int) $res);
            }
            $zip->extractTo($tempDir);
            $zip->close();
            return $tempDir;
        }

        if (class_exists('PharData')) {
            try {
                // Handle .tar.gz and .tgz by decompressing to .tar first
                if (str_ends_with($lower, '.tar.gz') || str_ends_with($lower, '.tgz')) {
                    $phar = new \PharData($archivePath);
                    $tarPath = preg_replace('/\.gz$/', '', $archivePath);
                    if (! file_exists($tarPath)) {
                        $phar->decompress();
                    }
                    $pharTar = new \PharData($tarPath);
                    $pharTar->extractTo($tempDir);
                    @unlink($tarPath);
                    return $tempDir;
                }

                // plain .tar
                if (str_ends_with($lower, '.tar')) {
                    $phar = new \PharData($archivePath);
                    $phar->extractTo($tempDir);
                    return $tempDir;
                }
            } catch (\Throwable $e) {
                throw new \RuntimeException('Phar extraction failed: ' . $e->getMessage());
            }
        }

        throw new \RuntimeException('Unsupported archive format or required PHP extensions are missing.');
    }

    /**
     * Restore a full backup archive (files + database). Returns an array summary.
     * Options:
     *  - overwrite_env: bool (default false) — whether to overwrite .env
     */
    public function restoreFullBackup(string $archivePath, array $options = []): array
    {
        $options = array_merge(['overwrite_env' => false, 'password' => null], $options);
        $lock = Cache::lock('skillup:backup:restore', 7200);
        if (! $lock->get()) {
            throw new \RuntimeException('Another restore or backup operation is already running.');
        }

        try {
            if (! $this->isFullArchive($archivePath)) {
                throw new \RuntimeException('Not a recognized full archive: ' . $archivePath);
            }

            // Verify and extract before creating the safety snapshot or touching the live system.
            $tempDir = $this->extractArchiveToTemp($archivePath, $options['password']);

            // Create an encrypted pre-restore snapshot to allow rollback.
            $preName = 'pre_restore_' . now()->format('Ymd_His') . '.zip';
            $prePath = $this->getBackupPath($preName);
            try {
                $this->createFullBackup($prePath, false);
                $prePath = $this->encryptArchiveIfNeeded($prePath);
            } catch (\Throwable $e) {
                Log::warning('Pre-restore backup failed; continuing with restore but cannot auto-rollback.', ['exception' => $e]);
            }

        $projectRoot = base_path();
        $copied = 0;
        $skipped = 0;

        $dbBackupPath = $this->findDatabaseBackupFile($tempDir);
        if ($dbBackupPath !== null) {
            $this->restoreDatabaseFromBackup($dbBackupPath);
        }

        // Copy files from tempDir to project root
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($tempDir, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST);
        foreach ($it as $item) {
            $relPath = str_replace('\\', '/', substr($item->getRealPath(), strlen($tempDir) + 1));
            // Skip backup storage inside the archive
            if (strpos($relPath, $this->backupDir) === 0) { $skipped++; continue; }
            // Skip the database dump file copied as backup metadata
            if ($dbBackupPath !== null && str_replace('\\', '/', $item->getRealPath()) === str_replace('\\', '/', $dbBackupPath)) { $skipped++; continue; }
            // Skip .env unless overwrite_env true
            if (! $options['overwrite_env'] && basename($relPath) === '.env') { $skipped++; continue; }
            // Skip extracted .tar/.zip tempfile if it exists
            if (in_array(strtolower(pathinfo($relPath, PATHINFO_EXTENSION)), ['zip', 'tar', 'gz', 'tgz'])) { $skipped++; continue; }

            $dest = $projectRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relPath);

            if ($item->isDir()) {
                if (! is_dir($dest)) {
                    @mkdir($dest, 0755, true);
                }
            } else {
                $destDir = dirname($dest);
                if (! is_dir($destDir)) {
                    @mkdir($destDir, 0755, true);
                }
                if (! @copy($item->getRealPath(), $dest)) {
                    throw new \RuntimeException('Failed to copy during restore from ' . $item->getRealPath() . ' to ' . $dest);
                }
                $copied++;
            }
        }

        // Clean up temp dir
        $this->deleteDirectory($tempDir);

            return ['pre_backup' => $prePath, 'copied' => $copied, 'skipped' => $skipped];
        } finally {
            if (isset($tempDir) && is_dir($tempDir)) {
                $this->deleteDirectory($tempDir);
            }
            $lock->release();
        }
    }

    protected function moveExtractedPayload(string $payloadDir, string $targetDir): void
    {
        $iterator = new \FilesystemIterator($payloadDir, \FilesystemIterator::SKIP_DOTS);
        foreach ($iterator as $item) {
            $destination = $targetDir . DIRECTORY_SEPARATOR . $item->getFilename();
            if ($item->isDir()) {
                rename($item->getPathname(), $destination);
            } else {
                rename($item->getPathname(), $destination);
            }
        }
        @rmdir($payloadDir);
    }

    protected function deleteDirectory(string $dir): void
    {
        if (! is_dir($dir)) return;
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($it as $file) {
            if ($file->isDir()) {
                @rmdir($file->getRealPath());
            } else {
                @unlink($file->getRealPath());
            }
        }
        @rmdir($dir);
    }

    protected function findDatabaseBackupFile(string $dir): ?string
    {
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS));
        foreach ($files as $file) {
            if ($file->isFile()) {
                $ext = strtolower(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
                if (in_array($ext, ['sql', 'sqlite', 'dump'], true)) {
                    return $file->getRealPath();
                }
            }
        }
        return null;
    }

    protected function restoreDatabaseFromBackup(string $backupPath): void
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");

        if ($driver === 'mysql') {
            $this->restoreMysqlBackup($backupPath);
            return;
        }

        if ($driver === 'sqlite') {
            $sqlitePath = config('database.connections.sqlite.database');
            if (! $sqlitePath || $sqlitePath === ':memory:' || ! file_exists($sqlitePath)) {
                throw new \RuntimeException('SQLite database destination is not available for restore.');
            }
            copy($backupPath, $sqlitePath);
            return;
        }

        throw new \RuntimeException('Recovery is only supported for MySQL and SQLite drivers in this environment.');
    }

    public function restoreDatabaseBackup(string $backupPath): void
    {
        $this->restoreDatabaseFromBackup($backupPath);
    }
}
