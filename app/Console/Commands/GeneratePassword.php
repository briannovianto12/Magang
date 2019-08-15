<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class GeneratePassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grosenia:add-user {username} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate username and password for new user.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //prepare username and password
        $password = $this->argument('password');
        $username = $this->argument('username');

        $hashedPassword = \Hash::make($password);

        DB::insert('insert into admin ( role_id, name, email, password, remember_token, created_at, updated_at ) 
        values (?, ?, ?, ?, ?, ?, ?)', [ 1, $username, $username, $hashedPassword,'', now(), now() ]);

    }

    protected function getArguments()
    {
        return [
            ['username', InputArgument::REQUIRED, 'An example username'],
            ['password', InputArgument::REQUIRED, 'An example password'],
        ];
    }
}
