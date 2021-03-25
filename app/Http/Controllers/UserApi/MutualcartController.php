<?php

namespace App\Http\Controllers\UserApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemCollection;
use App\Models\CartItem;
use App\Models\MutualCart;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MutualcartController extends Controller
{
    public function store()
    {
        $mutualCart = MutualCart::create([
            'id' => 'MC-'.md5(uniqid(rand(),true)),
            'key' => md5(uniqid(rand(),true)),
            'advertisor_id' => auth('api')->user()->id,
            'city' => auth('api')->user()->city,
        ]);

        return response()->json([
            'Message' => 'تم إنشاء عربة تسوق تشاركية جديدة',
            'cartToken' => $mutualCart->id,
            'cartKey' => $mutualCart->key,
        ], 201);
    }

    public function show(MutualCart $mutualCart, Request $request)
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
        if ($mutualCart->key == $cartKey) {
            return response()->json([
                'cart' => $mutualCart->id,
                'Items in Cart' => new CartItemCollection($mutualCart->items),
            ], 200);
        } else {

            return response()->json([
                'message' => 'The CarKey you provided does not match the Cart Key for this Cart.',
            ], 400);
        }
    }

    public function addProducts(MutualCart $mutualCart, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required',
            'productID' => 'required',
            'quantity' => 'required|numeric|min:1|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $cartKey = $request->input('cartKey');
        $productID = $request->input('productID');
        $quantity = $request->input('quantity');

        //Check if the CarKey is Valid
        if ($mutualCart->key == $cartKey) {
            //Check if the proudct exist or return 404 not found.
            try {  Product::findOrFail($productID);} catch (ModelNotFoundException $e) {
                return response()->json([
                    'message' => 'The Product you\'re trying to add does not exist.',
                ], 404);
            }

            //check if the the same product is already in the Cart, if true update the quantity, if not create a new one.
            $cartItem = CartItem::where(['cart_id' => $mutualCart->getKey(), 'product_id' => $productID])->first();
            if ($cartItem) {
                $cartItem->quantity = $quantity;
                CartItem::where(['cart_id' => $mutualCart->getKey(), 'product_id' => $productID])->update(['quantity' => $quantity]);
            } else {
                CartItem::create(['cart_id' => $mutualCart->getKey(), 'product_id' => $productID, 'quantity' => $quantity]);
            }
            return response()->json(['message' => 'The Cart was updated with the given product information successfully'], 200);

        } else {

            return response()->json([
                'message' => 'The CarKey you provided does not match the Cart Key for this Cart.',
            ], 400);
        }

    }

    public function findCart()
    {
        $mutualCart = MutualCart::where('city', auth('api')->user()->city)
        ->where('advertisor_id', '!=',auth('api')->user()->id)
        ->first();
        return response()->json([
            'cartToken' => $mutualCart->id,
            'cartKey' => $mutualCart->key,
        ], 201);

    }

    public function joinToCart(MutualCart $mutualCart, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $mutualCart = MutualCart::where(['id'=> $mutualCart->getKey(), 'key' => $mutualCart->key])->first();
        if($mutualCart){
            $mutualCart->update(['acceptor_id' => auth('api')->user()->id]);
        }
        return response()->json(['message' => 'The Cart was updated with the given product information successfully'], 200);




    }
}
