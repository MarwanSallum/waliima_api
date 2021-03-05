<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product = Product::find($this->product_id);
        return [
            'productID' => $this->product_id,
            'price' => $product->price,
            'title' => $product->title,
            'description' => $product->description,
            'image' => $product->image,
            'Quantity' => $this->quantity,
        ];
    }
}
