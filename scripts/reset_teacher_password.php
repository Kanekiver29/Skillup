<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$em = 'staff.teacher@skillup.com';
$user = App\Models\User::where('email', $em)->first();
if (!$user) {
    echo "User not found: $em\n";
    exit(1);
}

$user->password = Illuminate\Support\Facades\Hash::make('staff1234');
$user->save();

echo "Password for {$user->email} reset to 'staff1234'\n";
