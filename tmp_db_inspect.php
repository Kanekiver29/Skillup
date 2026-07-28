<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$db = $app->make('db');

echo 'has_modules=' . ($db->connection()->getSchemaBuilder()->hasTable('modules') ? '1' : '0') . PHP_EOL;
echo 'has_assessments=' . ($db->connection()->getSchemaBuilder()->hasTable('assessments') ? '1' : '0') . PHP_EOL;
echo 'migration_record=' . ($db->table('migrations')->where('migration', '2025_02_22_000010_create_assessments_table')->exists() ? '1' : '0') . PHP_EOL;
$rows = $db->select("SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE, COLUMN_DEFAULT, COLUMN_KEY FROM information_schema.columns WHERE table_schema = ? AND table_name = ? ORDER BY ordinal_position", [$db->connection()->getDatabaseName(), 'assessments']);
foreach ($rows as $row) {
    echo "{$row->COLUMN_NAME}: {$row->COLUMN_TYPE} {$row->IS_NULLABLE} " . var_export($row->COLUMN_DEFAULT, true) . " {$row->COLUMN_KEY}" . PHP_EOL;
}
