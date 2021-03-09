<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
       $userOrders = Order::where('user_id', auth('api')->id())->get();
       return new OrderCollection($userOrders);
    }

    public function show(Order $order)
    {
        if($order->user_id == auth()->id()){
            return new OrderResource($order);
        }else{
            return response()->json([
                'message' => 'الطلب الذي ترغب في الحصول عليه ليس لك'], 403);
        }
    }
}
