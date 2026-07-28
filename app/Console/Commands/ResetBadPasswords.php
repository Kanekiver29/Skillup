<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetBadPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:bad-passwords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset passwords for users with non-bcrypt/argon stored passwords and output temporary passwords.';

    public function handle()
    {
        $rows = DB::table('users')
            ->select('id','email')
            ->whereRaw("password NOT LIKE '$2y$%'")
            ->whereRaw("password NOT LIKE '$2a$%'")
            ->whereRaw("password NOT LIKE '$2b$%'")
            ->whereRaw("password NOT LIKE '\$argon2%'")
            ->get();

        if ($rows->isEmpty()) {
            $this->info('No users found with non-bcrypt/argon passwords.');
            return 0;
        }

        $output = [];

        foreach ($rows as $r) {
            $temp = $this->generateTempPassword();
            DB::table('users')->where('id', $r->id)->update(['password' => Hash::make($temp)]);
            logger()->info('Reset password for user id '.$r->id.' email '.$r->email.' (temporary password generated).');
            $output[] = [(string)$r->id, $r->email, $temp];
        }

        $this->table(['id','email','temporary_password'], $output);

        $this->info('Passwords reset. Temporary passwords shown above; do NOT store them in logs.');

        return 0;
    }

    private function generateTempPassword()
    {
        // Generate a secure temporary password with letters, numbers and a symbol
        $bytes = random_bytes(8);
        $base = substr(bin2hex($bytes), 0, 12);
        $upper = chr(random_int(65,90));
        $digit = chr(random_int(48,57));
        $symbol = '!';

        return $base.$upper.$digit.$symbol;
    }
}
