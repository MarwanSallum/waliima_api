<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
       $userOrders = Order::where('user_id', auth('api')->id())->get();
       return new OrderCollection($userOrders);
    }
}
