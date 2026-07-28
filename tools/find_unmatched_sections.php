<?php
$dir = __DIR__ . '/../resources/views';
$rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$problems = [];
foreach ($rii as $file) {
    if ($file->isDir()) continue;
    if (substr($file->getFilename(), -10) !== '.blade.php') continue;
    $content = file_get_contents($file->getPathname());
    $end = substr_count($content, '@endsection');
    $sec = substr_count($content, '@section');
    if ($end > $sec) {
        $problems[] = [$file->getPathname(), $end, $sec];
    }
}
if (empty($problems)) {
    echo "No unmatched @endsection found.\n";
    exit(0);
}
foreach ($problems as [$path, $end, $sec]) {
    echo "$path : end=$end section=$sec\n";
}
exit(0);
