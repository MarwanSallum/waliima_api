<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemCollection;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
   public function store()
   {
    // if(Auth::guard('api')->check()){
    //     $userID = auth('api')->user();
    // }
    $cart = Cart::create([
        'id' =>md5(uniqid(rand(),true)),
        'key' => md5(uniqid(rand(),true)),
        'user_id' => auth('api')->user()->id,
    ]);

    return response()->json([
        'Message' => 'تم إنشاء عربة تسوق جديدة',
        'cartToken' => $cart->id,
        'cartKey' => $cart->key,
    ],201);
   }

   public function show(Cart $cart, Request $request)
   {
       $validator = Validator::make($request->all(), [
           'cartKey' => 'required',
       ]);

       if ($validator->fails()) {
           return response()->json([
               'errors' => $validator->errors(),
           ], 400);
       }

       $cartKey = $request->input('cartKey');
       if ($cart->key == $cartKey) {
           return response()->json([
               'cart' => $cart->id,
               'Items in Cart' => new CartItemCollection($cart->items),
           ], 200);

       } else {

           return response()->json([
               'message' => 'The CarKey you provided does not match the Cart Key for this Cart.',
           ], 400);
       }

   }
}
