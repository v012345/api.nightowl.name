<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class SyncUserActivedAt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nightowl:lucky_stars:sync_user_actived_at';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync user\'s actived_at field in database from cache in redis';

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

        $hash = "nightowl_active_users_at_" . Carbon::yesterday()->toDateString();
        foreach (Redis::hGetAll($hash) as $user_id => $last_actived_at) {
            if ($user = User::find($user_id)) {
                $user->last_actived_at = $last_actived_at;
                $user->save();
            }
        }
        Redis::del($hash);
        return 0;
    }
}
