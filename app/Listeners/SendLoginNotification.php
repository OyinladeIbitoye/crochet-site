<?php

namespace App\Listeners;

use App\Events\UserLogin;
use App\Notifications\UserLoginNotification;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;


class SendLoginNotification
{

    /**
     * Handle the event.
     */
    public function handle(UserLogin $event): void
    {
        $event->user->notify(new UserLoginNotification($event->user));
    }
}
