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
use App\Models\Backup;
use App\Models\RecoveryLog;
use Illuminate\Support\Facades\Log;

class BackupController extends Controller
{
    protected string $backupDir = 'backups';

    public function index(Request $request)
    {
        $this->authorizeAdmin($request);
        $this->ensureBackupDirectory();

        $backups = Backup::latest()->paginate(20)->withQueryString();
        $lastSuccessfulBackup = Backup::where('status', 'success')->latest('completed_at')->first();
        $recentRecoveryLogs = RecoveryLog::with('user')->latest()->limit(10)->get();

        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
        $databaseName = config("database.connections.{$connection}.database") ?: 'N/A';

        // Diagnostics for admin UI
        $backupDirPath = Storage::disk('local')->path($this->backupDir);
        $backupDirExists = is_dir($backupDirPath);
        $backupDirWritable = $backupDirExists ? is_writable($backupDirPath) : is_writable(dirname($backupDirPath));

        $logPath = storage_path('logs/laravel.log');
        $logSummary = null;
        if (file_exists($logPath)) {
            $lines = @file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if (is_array($lines)) {
                foreach (array_reverse($lines) as $line) {
                    if (preg_match('/^\[[^]]+\]\s+\w+\.(ERROR|CRITICAL|ALERT|EMERGENCY):\s*(.+)$/i', $line, $matches)) {
                        $logSummary = trim($matches[2]);
                        if (strlen($logSummary) > 240) {
                            $logSummary = substr($logSummary, 0, 237) . '...';
                        }
                        break;
                    }
                }
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
            'log_summary' => $logSummary,
        ];

        $view = 'Admin.backup';

        return view($view, compact('backups', 'lastSuccessfulBackup', 'recentRecoveryLogs', 'connection', 'driver', 'databaseName', 'diagnostics'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin($request);
        try {
            $record = (new BackupService())->runRecordedBackup('manual', $request->user()->id, false);
            return redirect()->back()->with('success', "Backup created successfully: {$record->filename}");
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Backup failed: ' . $exception->getMessage());
        }
    }

    public function fullBackup(Request $request)
    {
        $this->authorizeAdmin($request);
        try {
            $record = (new BackupService())->runRecordedBackup('manual', $request->user()->id, (bool) $request->input('include_all'));
            return redirect()->back()->with('success', "Full backup created successfully: {$record->filename}");
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', 'Full backup failed: ' . $e->getMessage());
        }
    }

    public function upload(Request $request)
    {
        $this->authorizeAdmin($request);
        $validated = $request->validate([
            'backup' => ['required', 'file', 'max:512000', 'mimes:zip,7z,tar,gz,tgz'],
        ]);

        $this->ensureBackupDirectory();
        $file = $validated['backup'];
        $filename = 'uploaded_' . now()->format('Ymd_His') . '_' . bin2hex(random_bytes(6)) . '.' . strtolower($file->getClientOriginalExtension());
        $stored = $file->storeAs($this->backupDir, $filename, 'local');
        $path = Storage::disk('local')->path($stored);
        $record = Backup::create([
            'filename' => $filename,
            'path' => $stored,
            'size' => filesize($path) ?: 0,
            'checksum' => hash_file('sha256', $path),
            'type' => 'uploaded',
            'status' => 'success',
            'message' => 'Backup uploaded and ready for verification.',
            'completed_at' => now(),
            'created_by' => $request->user()->id,
        ]);

        RecoveryLog::create([
            'user_id' => $request->user()->id,
            'backup_id' => $record->id,
            'action' => 'upload',
            'filename' => $filename,
            'ip_address' => $request->ip(),
            'status' => 'success',
        ]);

        return redirect()->back()->with('success', 'Backup uploaded. Verify its password before restoring.');
    }

    public function delete(Request $request, Backup $backup)
    {
        $this->authorizeAdmin($request);
        $path = $this->getBackupPath(basename($backup->filename));
        if (is_file($path)) {
            @unlink($path);
        }

        $backup->delete();
        RecoveryLog::create([
            'user_id' => $request->user()->id,
            'action' => 'delete',
            'filename' => $backup->filename,
            'ip_address' => $request->ip(),
            'status' => 'success',
        ]);

        return redirect()->back()->with('success', 'Backup deleted.');
    }

    public function wholeSystemBackup(Request $request)
    {
        $this->authorizeAdmin($request);

        $service = new BackupService();
        $service->ensureBackupDirectory();

        $timestamp = now()->format('Ymd_His');
        $filename = "whole_laravel_backup_{$timestamp}.zip";
        $destination = $service->getBackupPath($filename);
        $databaseDump = $service->getBackupPath("database_whole_laravel_{$timestamp}.sql");
        $temporaryArchive = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $filename;

        try {
            $service->createMysqlBackup($databaseDump);

            $process = new Process([
                'tar',
                '-a',
                '-c',
                '-f',
                $temporaryArchive,
                '--exclude=storage/app/private/backups/*.zip',
                '.',
            ], base_path());
            $process->setTimeout(3600);
            $process->run();

            if (! $process->isSuccessful() || ! file_exists($temporaryArchive)) {
                throw new \RuntimeException('Whole-system archive failed: ' . trim($process->getErrorOutput()));
            }

            if (! @copy($temporaryArchive, $destination)) {
                throw new \RuntimeException('The completed archive could not be copied into the backup directory.');
            }

            @unlink($temporaryArchive);

            return redirect()->route('sias.admin.backup-restore')
                ->with('success', "Whole Laravel system backup created successfully: {$filename}");
        } catch (\Throwable $exception) {
            @unlink($temporaryArchive);
            Log::error('Whole Laravel system backup failed', ['exception' => $exception]);

            return redirect()->route('sias.admin.backup-restore')
                ->with('error', 'Whole-system backup failed: ' . $exception->getMessage());
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
            'backup_file' => ['required', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'max:512'],
            'confirm' => ['accepted'],
        ]);

        $filename = basename($request->input('backup_file'));
        $backupPath = $this->getBackupPath($filename);
        $backup = Backup::where('filename', $filename)->first();

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
                $result = $service->restoreFullBackup($backupPath, [
                    'overwrite_env' => false,
                    'password' => $request->input('password'),
                ]);
                $msg = "Full restore completed. Files copied: {$result['copied']}, skipped: {$result['skipped']}";
                if (! empty($result['pre_backup'])) {
                    $msg .= ". Pre-restore snapshot saved: " . basename($result['pre_backup']);
                }
                RecoveryLog::create([
                    'user_id' => $request->user()->id,
                    'backup_id' => $backup?->id,
                    'action' => 'restore',
                    'filename' => $filename,
                    'ip_address' => $request->ip(),
                    'status' => 'success',
                    'metadata' => ['copied' => $result['copied'], 'skipped' => $result['skipped']],
                ]);
                return redirect()->back()->with('success', $msg);
            }

            // Otherwise treat it as a database-only backup through the shared service.
            $service->restoreDatabaseBackup($backupPath);

            RecoveryLog::create([
                'user_id' => $request->user()->id,
                'backup_id' => $backup?->id,
                'action' => 'restore',
                'filename' => $filename,
                'ip_address' => $request->ip(),
                'status' => 'success',
            ]);
            return redirect()->back()->with('success', "Recovery completed from: {$filename}");
        } catch (\Throwable $exception) {
            Log::error('Restore failed', ['file' => $backupPath, 'exception' => $exception]);
            RecoveryLog::create([
                'user_id' => $request->user()->id,
                'backup_id' => $backup?->id,
                'action' => 'restore',
                'filename' => $filename,
                'ip_address' => $request->ip(),
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Recovery failed: ' . $exception->getMessage());
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

    protected function authorizeAdmin(Request $request): void
    {
        $user = $request->user();
        if (! $user || ! $user->isAdmin()) {
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
