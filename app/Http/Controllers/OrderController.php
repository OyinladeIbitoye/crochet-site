<?php

namespace App\Http\Controllers;

use App\Mail\OrderSent;
use App\Models\Order;
use App\Notifications\OrderShipped;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    public function index()
    {
        return Order::all();
    }

    public function store(Request $request)
    {
        $sections = $request->validate([
            'name' => 'required|max:255',
            'prize' => 'required'
        ]);

        $order = $request->user()->orders()->create($sections);
        Notification::route('mail', $request->user()->email)->notify(new OrderShipped($order));

        // Mail::to($request->user()->email)->send(new OrderSent($order));
 
        return $order;
    }

    public function show(Order $order)
    {
        return $order;
    }

    public function update(Request $request, Order $order)
    {
        Gate::authorize('modify', $order);
        
        $sections = $request->validate([
            'name' => 'required|max:255',
            'prize' => 'required'
        ]);

        $order->update($sections);

        return $order;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        Gate::authorize('modify', $order);

        $order->delete();

        return ['message' => 'Your Order have been Delected successfully'];
    }
}
