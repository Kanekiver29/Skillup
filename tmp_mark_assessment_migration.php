<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$db = $app->make('db');
$migration = '2025_02_22_000010_create_assessments_table';
if ($db->table('migrations')->where('migration', $migration)->exists()) {
    echo "Migration already recorded.\n";
    exit(0);
}
$batch = $db->table('migrations')->max('batch') ?? 1;
$db->table('migrations')->insert([
    'migration' => $migration,
    'batch' => $batch,
]);
echo "Inserted migration record for {$migration} with batch {$batch}.\n";