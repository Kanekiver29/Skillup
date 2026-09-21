<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Backup;

class PruneOldBackups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:prune {--days= : Delete backups older than this many days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete backup files older than the configured retention period.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $days = max(1, (int) ($this->option('days') ?: env('BACKUP_RETENTION_DAYS', 30)));
        $cutoff = now()->subDays($days)->getTimestamp();
        $backupDir = 'backups';

        if (! Storage::disk('local')->exists($backupDir)) {
            $this->info('No backup directory found. Nothing to prune.');

            return self::SUCCESS;
        }

        $files = Storage::disk('local')->files($backupDir);
        $deleted = 0;

        foreach ($files as $file) {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (! in_array($extension, ['sql', 'sqlite', 'dump', 'gz', 'zip', '7z', 'tar', 'tgz'], true)) {
                continue;
            }

            $fullPath = Storage::disk('local')->path($file);
            if (! file_exists($fullPath)) {
                continue;
            }

            if (filemtime($fullPath) <= $cutoff) {
                Storage::disk('local')->delete($file);
                Backup::where('path', $file)->orWhere('filename', basename($file))->delete();
                $deleted++;
                Log::info('Pruned old backup file', ['file' => $file, 'days' => $days]);
            }
        }

        $this->info("Deleted {$deleted} backup file(s) older than {$days} day(s).");

        return self::SUCCESS;
    }
}
