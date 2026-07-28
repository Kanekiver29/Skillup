<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use ZipArchive;
use App\Services\BackupService;
use Illuminate\Support\Facades\Log;

class BackupController extends Controller
{
    protected string $backupDir = 'backups';

    public function index(Request $request)
    {
        $this->authorizeAdmin($request);
        $this->ensureBackupDirectory();

        $backupFiles = collect(Storage::disk('local')->files($this->backupDir))
            ->filter(fn ($file) => in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['sql', 'sqlite', 'dump', 'gz', 'zip', 'tar', 'tgz']))
            ->map(function ($file) {
                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $type = in_array($extension, ['zip', 'gz', 'tgz', 'tar']) ? 'Full Backup' : 'Database';
                
                return [
                    'name' => basename($file),
                    'path' => $file,
                    'size' => Storage::disk('local')->size($file),
                    'modified' => Storage::disk('local')->lastModified($file),
                    'type' => $type,
                    'extension' => $extension,
                ];
            })
            ->sortByDesc('modified')
            ->values();

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
        $databaseName = config("database.connections.{$connection}.database") ?: 'N/A';

        // Diagnostics for admin UI
        $backupDirPath = Storage::disk('local')->path($this->backupDir);
        $backupDirExists = is_dir($backupDirPath);
        $backupDirWritable = $backupDirExists ? is_writable($backupDirPath) : is_writable(dirname($backupDirPath));

        $logPath = storage_path('logs/laravel.log');
        $logTail = null;
        if (file_exists($logPath)) {
            $lines = @file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if (is_array($lines)) {
                $tail = array_slice($lines, -40);
                $logTail = implode("\n", $tail);
            }
        }

        $diagnostics = [
            'zip' => extension_loaded('zip'),
            'phar' => class_exists('PharData'),
            'phar_readonly' => ini_get('phar.readonly') ?: 'not set',
            'temp_dir' => sys_get_temp_dir(),
            'open_basedir' => ini_get('open_basedir') ?: 'not set',
            'backup_dir' => $backupDirPath,
            'backup_dir_exists' => $backupDirExists,
            'backup_dir_writable' => $backupDirWritable,
            'log_tail' => $logTail,
        ];

        return view('Admin.backup', compact('backupFiles', 'connection', 'driver', 'databaseName', 'diagnostics'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin($request);
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
        $timestamp = now()->format('Ymd_His');
        $filename = "backup_{$timestamp}_{$connection}." . ($driver === 'sqlite' ? 'sqlite' : 'sql');
        $this->ensureBackupDirectory();
        $targetPath = $this->getBackupPath($filename);

        try {
            if ($driver === 'mysql') {
                $this->createMysqlBackup($targetPath);
            } elseif ($driver === 'sqlite') {
                $sqlitePath = config('database.connections.sqlite.database');
                if (!$sqlitePath || $sqlitePath === ':memory:' || ! file_exists($sqlitePath)) {
                    throw new \RuntimeException('SQLite database file is not available for backup.');
                }
                copy($sqlitePath, $targetPath);
            } else {
                throw new \RuntimeException('Backup is only supported for MySQL and SQLite drivers in this environment.');
            }

            return redirect()->route('admin.backup.index')->with('success', "Backup created successfully: {$filename}");
        } catch (\Throwable $exception) {
            return redirect()->route('admin.backup.index')->with('error', 'Backup failed: ' . $exception->getMessage());
        }
    }

    public function fullBackup(Request $request)
    {
        $this->authorizeAdmin($request);
        $timestamp = now()->format('Ymd_His');
        $this->ensureBackupDirectory();

        // Prefer ZipArchive when available
        if (extension_loaded('zip')) {
            // Quick smoke test for ZipArchive functionality (some systems have ext-zip but broken bindings)
            $zipTestPath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'sk_backup_test_' . uniqid() . '.zip';
            $zipOk = false;
            try {
                $z = new ZipArchive();
                $res = $z->open($zipTestPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
                if ($res === true) {
                    $z->addFromString('sk_test.txt', 'ok');
                    $z->close();
                    $zipOk = true;
                } else {
                    Log::warning('ZipArchive smoke test failed to open', ['res' => $res]);
                }
            } catch (\Throwable $t) {
                Log::warning('ZipArchive smoke test exception', ['exception' => $t]);
            } finally {
                if (file_exists($zipTestPath)) {
                    @unlink($zipTestPath);
                }
            }

            if ($zipOk) {
                $filename = "full_backup_{$timestamp}.zip";
                $zipPath = $this->getBackupPath($filename);
                try {
                    $includeAll = (bool) $request->input('include_all');
                    $service = new BackupService();
                    $service->ensureBackupDirectory();
                    $service->createFullBackup($zipPath, $includeAll);
                    return redirect()->route('admin.backup.index')->with('success', "Full backup created successfully: {$filename}");
                } catch (\Throwable $exception) {
                    Log::error('Full backup (zip) failed', ['zipPath' => $zipPath, 'exception' => $exception]);
                    // fall through to Phar fallback or DB-only fallback below
                }
            } else {
                Log::warning('ZipArchive appears unusable; falling back to Phar or DB-only backup.');
            }
        }

        // Fallback to PharData (.tar.gz) if available and writable
        if (class_exists('PharData') && ini_get('phar.readonly') != '1') {
            $tarName = "full_backup_{$timestamp}.tar";
            $tarPath = $this->getBackupPath($tarName);
            try {
                $includeAll = (bool) $request->input('include_all');
                $compressed = $this->createFullBackupPhar($tarPath, $includeAll);
                $basename = basename($compressed);
                return redirect()->route('admin.backup.index')->with('success', "Full backup created successfully: {$basename}");
            } catch (\Throwable $e) {
                Log::error('Full backup (phar) failed', ['tarPath' => $tarPath, 'exception' => $e]);
                return redirect()->route('admin.backup.index')->with('error', 'Full backup failed (phar): ' . $e->getMessage());
            }
        }

        // Last resort: create database-only backup and inform the user
        try {
            $connection = config('database.default');
            $driver = config("database.connections.{$connection}.driver");
            $filename = "backup_{$timestamp}_{$connection}." . ($driver === 'sqlite' ? 'sqlite' : 'sql');
            $targetPath = $this->getBackupPath($filename);
            if ($driver === 'mysql') {
                $this->createMysqlBackup($targetPath);
            } elseif ($driver === 'sqlite') {
                $sqlitePath = config('database.connections.sqlite.database');
                if ($sqlitePath && $sqlitePath !== ':memory:' && file_exists($sqlitePath)) {
                    copy($sqlitePath, $targetPath);
                }
            }
            return redirect()->route('admin.backup.index')->with('success', "ZIP not available; created DB-only backup: {$filename}");
        } catch (\Throwable $e) {
            Log::error('Full backup fallback DB-only failed', ['exception' => $e]);
            return redirect()->route('admin.backup.index')->with('error', 'Full backup unavailable and DB backup failed: ' . $e->getMessage());
        }
    }

    public function download($file)
    {
        $this->authorizeAdmin(request());
        $filename = basename($file);
        $path = $this->getBackupPath($filename);

        if (! file_exists($path)) {
            abort(404, 'Backup file not found.');
        }

        return response()->download($path, $filename, [
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function restore(Request $request)
    {
        $this->authorizeAdmin($request);
        $request->validate([
            'backup_file' => ['required', 'string'],
        ]);

        $filename = basename($request->input('backup_file'));
        $backupPath = $this->getBackupPath($filename);

        if (! file_exists($backupPath)) {
            return redirect()->route('admin.backup.index')->with('error', 'Selected backup file does not exist.');
        }

        // If this is a full archive (zip or tar.gz), perform full restore (files + DB)
        $service = new BackupService();
        try {
            if ($service->isFullArchive($backupPath)) {
                // require explicit confirmation from UI to avoid accidental overwrites
                if (! $request->has('confirm') || $request->input('confirm') !== 'yes') {
                    return redirect()->route('admin.backup.index')->with('error', 'Restore aborted: confirmation required to perform full restore.');
                }

                $overwriteEnv = (bool) $request->input('overwrite_env', false);
                $result = $service->restoreFullBackup($backupPath, ['overwrite_env' => $overwriteEnv]);
                $msg = "Full restore completed. Files copied: {$result['copied']}, skipped: {$result['skipped']}";
                if (! empty($result['pre_backup'])) {
                    $msg .= ". Pre-restore snapshot saved: " . basename($result['pre_backup']);
                }
                return redirect()->route('admin.backup.index')->with('success', $msg);
            }

            // Otherwise treat as DB-only backup
            $connection = config('database.default');
            $driver = config("database.connections.{$connection}.driver");

            if ($driver === 'mysql') {
                $this->restoreMysqlBackup($backupPath);
            } elseif ($driver === 'sqlite') {
                $sqlitePath = config('database.connections.sqlite.database');
                if (! $sqlitePath || $sqlitePath === ':memory:' || ! file_exists($sqlitePath)) {
                    throw new \RuntimeException('SQLite database destination is not available for restore.');
                }
                copy($backupPath, $sqlitePath);
            } else {
                throw new \RuntimeException('Recovery is only supported for MySQL and SQLite drivers in this environment.');
            }

            return redirect()->route('admin.backup.index')->with('success', "Recovery completed from: {$filename}");
        } catch (\Throwable $exception) {
            Log::error('Restore failed', ['file' => $backupPath, 'exception' => $exception]);
            return redirect()->route('admin.backup.index')->with('error', 'Recovery failed: ' . $exception->getMessage());
        }
    }

    protected function ensureBackupDirectory(): void
    {
        if (! Storage::disk('local')->exists($this->backupDir)) {
            if (! Storage::disk('local')->makeDirectory($this->backupDir, 0755, true)) {
                $root = Storage::disk('local')->path('');
                $backupPath = $root . DIRECTORY_SEPARATOR . $this->backupDir;
                throw new \RuntimeException("Unable to create backup directory: {$backupPath}");
            }
        }
    }

    protected function getBackupPath(string $filename): string
    {
        return Storage::disk('local')->path($this->backupDir . '/' . $filename);
    }

    protected function createMysqlBackup(string $targetPath): void
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

        if (! $database) {
            throw new \RuntimeException('Unable to determine the current MySQL database.');
        }

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
            if (! isset($row['Create Table'])) {
                continue;
            }

            $output[] = "DROP TABLE IF EXISTS `{$table}`;";
            $output[] = $row['Create Table'] . ';';
            $output[] = '';

            $stmt = $pdo->query("SELECT * FROM `{$table}`", \PDO::FETCH_ASSOC);
            $rows = $stmt->fetchAll();

            if (empty($rows)) {
                continue;
            }

            $columns = array_map(fn ($column) => "`{$column}`", array_keys($rows[0]));
            $columnList = implode(', ', $columns);
            $insertChunks = [];

            foreach ($rows as $rowData) {
                $values = array_map(function ($value) use ($pdo) {
                    if ($value === null) {
                        return 'NULL';
                    }
                    if (is_bool($value)) {
                        return $value ? '1' : '0';
                    }
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

    protected function restoreMysqlBackup(string $backupPath): void
    {
        $config = config('database.connections.mysql');
        if (! $config) {
            throw new \RuntimeException('MySQL configuration is missing.');
        }

        $sql = file_get_contents($backupPath);
        if ($sql === false) {
            throw new \RuntimeException('Unable to read backup file for recovery.');
        }

        if ($this->commandExists('mysql')) {
            $process = new Process([
                'mysql',
                '--host=' . ($config['host'] ?? '127.0.0.1'),
                '--port=' . ($config['port'] ?? 3306),
                '--user=' . ($config['username'] ?? ''),
                '--password=' . ($config['password'] ?? ''),
                $config['database'] ?? '',
            ]);
            $process->setInput($sql);
            $process->setTimeout(3600);
            $process->run();

            if (! $process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            return;
        }

        DB::unprepared($sql);
    }

    protected function commandExists(string $command): bool
    {
        $check = PHP_OS_FAMILY === 'Windows'
            ? ['where', $command]
            : ['command', '-v', $command];

        $process = new Process($check);
        $process->run();

        return $process->isSuccessful();
    }

    protected function authorizeAdmin(Request $request): void
    {
        $user = $request->user();
        if (! $user || (! $user->is_admin && ($user->role ?? '') !== 'admin')) {
            abort(403, 'Unauthorized. Admins only.');
        }
    }

    protected function createFullBackup(string $zipPath, bool $includeAll = false): void
    {
        $service = new BackupService();
        $service->ensureBackupDirectory();
        $service->createFullBackup($zipPath, $includeAll);
    }

    protected function createFullBackupPhar(string $tarPath, bool $includeAll = false): string
    {
        $service = new BackupService();
        $service->ensureBackupDirectory();
        return $service->createFullBackupPhar($tarPath, $includeAll);
    }
}
