<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
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
                'app', 'bootstrap', 'config', 'database', 'public', 'resources', 'routes', 'storage', 'tests', '.github'
            ];
            if ($includeAll) {
                $includeDirs[] = 'vendor';
                $includeDirs[] = 'node_modules';
            }

            $excludeDirs = ['.git', 'storage/framework/cache', 'storage/framework/sessions', 'storage/logs'];
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
                    if (! in_array($basename, $includeFiles, true)) {
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
            }

            if (file_exists($dbBackupPath)) {
                @unlink($dbBackupPath);
            }

            return $zipPath;
        } catch (\Throwable $e) {
            Log::error('BackupService::createFullBackup failed', ['zipPath' => $zipPath, 'exception' => $e]);
            if ($opened) {
                $zip->close();
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
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($projectRoot) + 1);

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
            $excludeDirs = ['.git', 'storage/framework/cache', 'storage/framework/sessions', 'storage/logs'];
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

        if ($this->commandExists('mysqldump')) {
            $process = new Process([
                'mysqldump',
                '--host=' . ($config['host'] ?? '127.0.0.1'),
                '--port=' . ($config['port'] ?? 3306),
                '--user=' . ($config['username'] ?? ''),
                '--password=' . ($config['password'] ?? ''),
                '--single-transaction',
                '--routines',
                '--triggers',
                '--databases',
                $config['database'] ?? '',
            ]);

            $process->setTimeout(3600);
            $process->run();

            if (! $process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            file_put_contents($targetPath, $process->getOutput());
            return;
        }

        $this->createMysqlBackupFromQuery($targetPath);
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

    /**
     * Determine whether a backup file is a full archive (zip or tar.gz/tgz).
     */
    public function isFullArchive(string $path): bool
    {
        $lower = strtolower($path);
        return str_ends_with($lower, '.zip') || str_ends_with($lower, '.tar.gz') || str_ends_with($lower, '.tgz') || str_ends_with($lower, '.tar');
    }

    /**
     * Extract an archive to a temporary directory and return that directory path.
     */
    public function extractArchiveToTemp(string $archivePath): string
    {
        if (! file_exists($archivePath)) {
            throw new \RuntimeException('Archive not found: ' . $archivePath);
        }

        $tempDir = Storage::disk('local')->path($this->backupDir) . DIRECTORY_SEPARATOR . 'restore_tmp_' . now()->format('Ymd_His') . '_' . uniqid();
        if (! @mkdir($tempDir, 0755, true) && ! is_dir($tempDir)) {
            throw new \RuntimeException('Unable to create temp extraction directory: ' . $tempDir);
        }

        $lower = strtolower($archivePath);

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
        $options = array_merge(['overwrite_env' => false], $options);

        if (! $this->isFullArchive($archivePath)) {
            throw new \RuntimeException('Not a recognized full archive: ' . $archivePath);
        }

        // Create a pre-restore full backup to allow rollback
        $preName = 'pre_restore_' . now()->format('Ymd_His') . '.zip';
        $prePath = $this->getBackupPath($preName);
        try {
            $this->createFullBackup($prePath, true);
        } catch (\Throwable $e) {
            Log::warning('Pre-restore backup failed; continuing with restore but cannot auto-rollback.', ['exception' => $e]);
        }

        // Extract archive to temp
        $tempDir = $this->extractArchiveToTemp($archivePath);

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
}
