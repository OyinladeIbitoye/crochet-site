<?php

namespace App\Providers;

use App\Events\UserRegister;
use App\Listeners\SendRegisterNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
<<<<<<< HEAD
        Event::listen(
            UserRegister::class,
            SendRegisterNotification::class,
        );
=======
        // 
>>>>>>> d3de740403f14eb3cddbf56b07b4704cd8fae1df
    }
}
