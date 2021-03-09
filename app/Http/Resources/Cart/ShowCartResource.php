<?php

namespace App\Http\Resources\Cart;

use App\Http\Resources\CartItemCollection;
use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowCartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        return [
            'cart' => $this->id,
            'items_in_cart' => new CartItemCollection($this->items),  
            'total'  => $this->total,   
        ];
    }
}
