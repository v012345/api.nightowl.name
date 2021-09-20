<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class Token extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get a token';

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
     * @return int
     */
    public function handle()
    {
        $userId = $this->ask("Input a user id");
        $user = User::find($userId);
        if(!$user){
            return $this->error("User doesn't exist");
        }
        $ttl = 365*24*60;
        $this->info(auth("api")->setTTL($ttl)->login($user));
        return 0;
    }
}
