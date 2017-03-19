<?php

namespace App\Providers;

use App\Helpers\SocialContractImpl;
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
        $this->app->bind(\App\Helpers\SocialContract::class, function(){
            return new SocialContractImpl();
        });
    }
}
