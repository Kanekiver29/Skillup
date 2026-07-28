<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$db = $app->make('db');

$schema = $db->connection()->getSchemaBuilder();
$database = $db->connection()->getDatabaseName();

if (! $schema->hasTable('user_badges')) {
    echo "user_badges table does not exist\n";
    exit(1);
}

if (! $schema->hasTable('badges')) {
    echo "badges table does not exist\n";
    exit(1);
}

$exists = $db->selectOne(
    'SELECT COUNT(*) AS cnt FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND CONSTRAINT_NAME = ? AND REFERENCED_TABLE_NAME = ?',
    [$database, 'user_badges', 'user_badges_badge_id_foreign', 'badges']
);

if (! $exists->cnt) {
    $db->statement('ALTER TABLE `user_badges` ADD CONSTRAINT `user_badges_badge_id_foreign` FOREIGN KEY (`badge_id`) REFERENCES `badges` (`id`) ON DELETE CASCADE');
    echo "Added badge_id foreign key constraint\n";
} else {
    echo "Badge foreign key already exists\n";
}

if (! $db->table('migrations')->where('migration', '2025_03_19_000001_create_user_badges_table')->exists()) {
    $batch = (int) ($db->table('migrations')->max('batch') ?? 0) + 1;
    $db->table('migrations')->insert([
        'migration' => '2025_03_19_000001_create_user_badges_table',
        'batch' => $batch,
    ]);
    echo "Inserted user_badges migration record with batch {$batch}\n";
} else {
    echo "Migration record already exists\n";
}
