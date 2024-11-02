<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    public function modify(User $user, Order $order): Response
    {
        return $user->id === $order->user_id
            ? Response::allow()
            : Response::deny('You do own this order');
    }
}
