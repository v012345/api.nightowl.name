<?php

namespace App\Console\Commands;

use App\Models\User;
use Faker\Generator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class LuckyStars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nightowl:lucky_stars';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Select the luky users and cache them';

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
        $this->info("------  generating lucky stars!!!  ------");
        $luckyStars = Cache::remember('lucky_meteor', 600, function () {
            $max = User::count();
            if ($max < 100) {
                // $luckyStars = range(1,$max);
                return null;
            }
            $luckyStars = collect();
            while ($luckyStars->unique()->count() < 10) {
                $luckyStars->push(random_int(1, $max));
            }

            $luckyStars = User::find($luckyStars)->toArray();

            return $luckyStars;
        });
        Cache::put('lucky_stars', $luckyStars, 7200);
        $this->info(var_dump($luckyStars));
        $this->info("------  successfully!!  ------");
        return 0;
    }
}
