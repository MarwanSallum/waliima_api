<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use function GuzzleHttp\json_decode;

class OrderResource extends JsonResource
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
            'order_id' => $this->id,
            'ordered_products' => json_decode($this->products),
            'total_price' => $this->total_price,
            'name' => $this->name,
            'address' => $this->address,
            'transaction_id' => $this->transaction_id,
        ];
    }
}
