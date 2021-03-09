<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiGeneralTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddProductsRequest as CartAddProductsRequest;
use App\Http\Requests\Cart\CartKeyRequest as CartCartKeyRequest;
use App\Http\Requests\Cart\CheckoutRequest;
use App\Http\Resources\Cart\CreateNewCartResource;
use App\Http\Resources\Cart\ShowCartResource;
use App\Http\Resources\CartItemCollection;
use App\Http\Resources\Order\OrderResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class CartController extends Controller
{
    use ApiGeneralTrait;
    public function store()
    {
        $cart = Cart::create([
            'id' =>  uniqid('CART_', false),
            'key' => uniqid('KEY_', false),
            'user_id' => auth('api')->user()->id,
        ]);
        return new CreateNewCartResource($cart);
    }

    public function show(Cart $cart, CartCartKeyRequest $request)
    {
        $cartKey = $request->input('cartKey');
        if ($cart->key == $cartKey) {
            return new ShowCartResource($cart);
        } else {
            return $this->returnError(404, 'رمز السلة غير مطابق');
        }
    }

    public function addProducts(Cart $cart, CartAddProductsRequest $request)
    {
        $cartKey = $request->input('cartKey');
        $productID = $request->input('productID');
        $quantity = $request->input('quantity');

        //Check if the CarKey is Valid
        if ($cart->key == $cartKey) {
            //Check if the proudct exist or return 404 not found.
            try {  
                Product::findOrFail($productID);
            } catch (ModelNotFoundException $e) {
                return $this->returnError(404, 'المنتج الذي تحاول إضافته غير موجود');
            }
            //check if the the same product is already in the Cart, if true update the quantity, if not create a new one.
            $cartItem = CartItem::where(['cart_id' => $cart->getKey(), 'product_id' => $productID])->first();
            if ($cartItem) {
                $cartItem->quantity = $quantity;
                CartItem::where(['cart_id' => $cart->getKey(), 'product_id' => $productID])->update(['quantity' => $quantity]);
            } else {
                CartItem::create(['cart_id' => $cart->getKey(), 'product_id' => $productID, 'quantity' => $quantity]);
            }
            return $this->returnSuccessMessage('تم تحديث السلة بنجاح');
        } else {
            return $this->returnError(404, 'مفتاح السلة المدخل غير مطابق لهذه السلة');
        }

    }

    public function checkout(Cart $cart, CheckoutRequest $request)
    {
        $cartKey = $request->input('cartKey');
        if ($cart->key == $cartKey) {
            $name = $request->input('name');
            $creditCardNumber = $request->input('credit_card_number');
            $TotalPrice = 0.0;
            $items = $cart->items;

            foreach ($items as $item) {

                $product = Product::find($item->product_id);
                $price = $product->price;
                $inStock = $product->inStock;
                if ($inStock >= $item->quantity) {
                    $TotalPrice = $TotalPrice + ($price * $item->quantity);
                    $product->inStock = $product->inStock - $item->quantity;
                    $product->save();
                } else {
                    return $this->returnError(400, 'الكمية المطلوبة غير متوفرة حاليا');
                }
            }

            /**
             * Credit Card information should be sent to a payment gateway for processing and validation,
             * the response should be dealt with here, but since this is a dummy project we'll
             * just assume that the information is sent and the payment process was done succefully,
             */

            $PaymentGatewayResponse = true;
            $transactionID =  uniqid('TRANSACTION_', false);

            if ($PaymentGatewayResponse) {
                $order = Order::create([
                    'id' => uniqid('ORDER_', false),
                    'products' => json_encode(new CartItemCollection($items)),
                    'total_price' => $TotalPrice,
                    'name' => $name,
                    'user_id' => auth('api')->user()->id,
                    'transaction_id' => $transactionID,
                ]);
                $cart->delete();
                $cart->items()->delete();
                return new OrderResource($order);
            }
        } else {
            return $this->returnError(400, 'مفتاح السلة المدخل غير مطابق لهذه السلة');
        }

    }



}
