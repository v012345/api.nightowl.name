<?php

namespace App\Providers;

use App\Models\Reply;
use App\Models\Topic;
use App\Models\User;
use App\Observers\ReplyObserver;
use App\Observers\TopicObserver;
use App\Observers\UserObserver;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Overtrue\EasySms\EasySms;
use Test;
use Test1;
use Test2;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        
        $this->app->when(Test1::class)->needs('$b')->give(100);
        $this->app->when(Test2::class)->needs('$b')->give(50);
        $this->app->tag([Test1::class, Test2::class], 'reports');
        $this->app->when(Test::class)->needs('$reports')->giveTagged('reports');
        $this->app->singleton(EasySms::class, function ($app) {
            return new EasySms(config('easysms'));
        });
        $this->app->alias(EasySms::class, "easysms");

        Topic::observe(TopicObserver::class);
        Reply::observe(ReplyObserver::class);
        User::observe(UserObserver::class);
        JsonResource::withoutWrapping();
    }
}
