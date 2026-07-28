<?php
$s = file('routes/web.php');
$c = 0;
foreach ($s as $i => $line) {
    $opens = substr_count($line, '{');
    $closes = substr_count($line, '}');
    if ($opens || $closes) {
        $c += $opens - $closes;
        echo ($i + 1) . ": +$opens -$closes => balance=$c => " . rtrim($line) . PHP_EOL;
    }
}
echo 'FINAL BALANCE: ' . $c . PHP_EOL;
