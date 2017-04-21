<?php

namespace App\Providers;

use App\Services\SocialService;
use Illuminate\Support\ServiceProvider;

class SocialProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Contracts\SocialContract::class, function(){
            return new SocialService();
        });
    }
}
