<?php

namespace App\Listeners;

use App\Events\UserRegister;
use App\Notifications\UserRegisterNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendRegisterNotification
{
    public function handle(UserRegister $event): void
    {
        $event->user->notify(new UserRegisterNotification($event->user));
    }
}
