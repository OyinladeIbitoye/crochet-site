<?php

use App\Mail\OrderSent;
use App\Models\Order;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::call(function () {
    $order = Order::latest()->first();
    Mail::to('oyin@gmail.com')->send(new OrderSent($order));
})->everyMinute();
