<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Resource path: " . app('path.resources') . "\n";
echo "Exists check: " . (app('view')->exists('admin.news._form') ? 'YES' : 'NO') . "\n";

$paths = app('view')->getFinder()->getPaths();
echo "View paths: " . implode(', ', $paths) . "\n";

// Try to find the actual file
try {
    $file = app('view')->getFinder()->find('admin.news._form');
    echo "Found file: " . $file . "\n";
} catch (InvalidArgumentException $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
