<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FindBadPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'find:bad-passwords';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List users whose password column does not contain a bcrypt or argon hash';

    public function handle()
    {
        $rows = DB::table('users')
            ->select('id','email','password')
            ->whereRaw("password NOT LIKE '$2y$%'")
            ->whereRaw("password NOT LIKE '$2a$%'")
            ->whereRaw("password NOT LIKE '$2b$%'")
            ->whereRaw("password NOT LIKE '\$argon2%'")
            ->get();

        if ($rows->isEmpty()) {
            $this->info('No users found with non-bcrypt/argon passwords.');
            return 0;
        }

        $this->table(['id','email','password'], $rows->map(function($r){
            return [(string)$r->id, $r->email, $r->password];
        })->toArray());

        return 0;
    }
}
