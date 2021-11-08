<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use App\Extensions\BladeExtensions;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Cashier;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('subscribed',function($user){
            return $user->subscribed('monthly') || $user->subscribed('yearly');
        });

        Blade::if('notsubscribed', function($user){
            return !($user->subscribed('monthly') || $user->subscribed('yearly'));
        });

        Blade::if('subscribedToPlan',function($user,$id,$name){
            return $user->subscribedToPlan($id,$name);
            // return $user;
        });
    }
}
