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
    protected $signature = 'backup:full {--exclude-heavy : Exclude vendor and node_modules (default is to include them)} {--type=automatic : Backup record type: automatic or manual}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a full project backup (includes DB). By default includes vendor and node_modules.';

    public function handle(): int
    {
        try {
            $this->info('Starting full backup...');
            $service = new BackupService();
            $record = $service->runRecordedBackup(
                (string) $this->option('type'),
                null,
                ! (bool) $this->option('exclude-heavy')
            );
            $this->info('Backup created: ' . $record->filename);
            return 0;
        } catch (\Throwable $e) {
            $this->error('Backup failed: ' . $e->getMessage());
            Log::error('backup:full failed', ['exception' => $e]);
            return 1;
        }
    }
}
