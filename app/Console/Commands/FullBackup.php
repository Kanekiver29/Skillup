<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Services\BackupService;
use Illuminate\Support\Facades\Log;

class FullBackup extends Command
{
    /**
     * The name and signature of the console command.
     * Default behavior: include heavy directories (vendor and node_modules).
     * Use --exclude-heavy to omit them.
     */
    protected $signature = 'backup:full {--exclude-heavy : Exclude vendor and node_modules (default is to include them)} {--path= : Optional full path/filename for the archive}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a full project backup (includes DB). By default includes vendor and node_modules.';

    public function handle(): int
    {
        $this->info('Starting full backup...');
        $excludeHeavy = (bool) $this->option('exclude-heavy');
        $includeAll = ! $excludeHeavy;
        $pathOption = $this->option('path');

        $service = new BackupService();
        $service->ensureBackupDirectory();

        $timestamp = now()->format('Ymd_His');
        $defaultName = "full_backup_{$timestamp}.zip";
        $filename = $pathOption ?: $defaultName;

        // If given a filename without path, place it in backup dir
        if (! str_contains($filename, DIRECTORY_SEPARATOR)) {
            $filename = $service->getBackupPath($filename);
        }

        // Try ZipArchive first
        if (extension_loaded('zip')) {
            $this->info('Zip extension available; attempting ZIP archive...');
            try {
                $service->createFullBackup($filename, $includeAll);
                $this->info('Backup created: ' . $filename);
                Log::info('backup:full created ZIP', ['path' => $filename, 'include_all' => $includeAll]);
                return 0;
            } catch (\Throwable $e) {
                $this->error('ZIP backup failed: ' . $e->getMessage());
                Log::error('backup:full zip failed', ['exception' => $e]);
            }
        } else {
            $this->warn('Zip extension not available; attempting Phar fallback.');
        }

        // Phar fallback
        if (class_exists('PharData') && ini_get('phar.readonly') != '1') {
            $this->info('Attempting Phar (tar.gz) fallback...');
            $tarName = preg_replace('/\.zip$/', '.tar', basename($filename));
            $tarPath = $service->getBackupPath($tarName);
            try {
                $compressed = $service->createFullBackupPhar($tarPath, $includeAll);
                $this->info('Backup created: ' . $compressed);
                Log::info('backup:full created Phar', ['path' => $compressed, 'include_all' => $includeAll]);
                return 0;
            } catch (\Throwable $e) {
                $this->error('Phar backup failed: ' . $e->getMessage());
                Log::error('backup:full phar failed', ['exception' => $e]);
            }
        } else {
            $this->warn('PharData not available or phar.readonly=1; skipping Phar fallback.');
        }

        // Last resort: DB-only
        $this->warn('Creating database-only backup as a fallback.');
        try {
            $connection = config('database.default');
            $driver = config("database.connections.{$connection}.driver");
            $dbName = $connection ?: 'database';
            $dbFilename = "backup_{$timestamp}_{$dbName}." . ($driver === 'sqlite' ? 'sqlite' : 'sql');
            $dbPath = $service->getBackupPath($dbFilename);
            if ($driver === 'mysql') {
                $service->createMysqlBackup($dbPath);
            } elseif ($driver === 'sqlite') {
                $sqlitePath = config('database.connections.sqlite.database');
                if ($sqlitePath && $sqlitePath !== ':memory:' && file_exists($sqlitePath)) {
                    copy($sqlitePath, $dbPath);
                }
            }
            $this->info('Database-only backup created: ' . $dbPath);
            Log::warning('backup:full created DB-only fallback', ['path' => $dbPath]);
            return 0;
        } catch (\Throwable $e) {
            $this->error('Database backup failed: ' . $e->getMessage());
            Log::error('backup:full db-only fallback failed', ['exception' => $e]);
            return 1;
        }
    }
}
