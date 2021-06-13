<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use JonathanTorres\MediumSdk\Medium;

class MediumServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */

    //here we register these things in MediumServiceProvider's container
    //.. which register in config/app.php while laravel booting 
    public function register()
    {
        //we bind 'medium-php-sdk' with the the function: 
        //.. we acutally use called 'medium-php-sdk' in the routers
        $this->app->bind('medium-php-sdk', function(){
            return new Medium(config('medium')); // the $creds we will make a config file for it called medium
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //here we register a new route, after the booting: 
        $this->app->make('router')->get('medium', function(){
            return 'medium home';
        });

        // you can do anything else, sending email or anything
    }
}
