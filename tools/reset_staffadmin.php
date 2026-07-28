<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$email = 'staffadmin@skillup.test';
$new = 'staffadmin1234?';

$u = User::where('email', $email)->first();
if ($u) {
    $u->password = Hash::make($new);
    $u->save();
    echo "updated\n";
    exit(0);
}

// If not found, create the user
$u = User::create([
    'name' => 'Staff Admin',
    'email' => $email,
    'password' => Hash::make($new),
    'is_admin' => true,
    'staff_type' => 'content_manager',
]);

if ($u) {
    echo "created\n";
    exit(0);
}

echo "failed\n";
exit(1);
