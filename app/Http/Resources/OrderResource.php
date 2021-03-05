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
            'OrderID' => $this->id,
            'Ordered Products:' => json_decode($this->products),
            'Total Price' => $this->total_price,
            'name' => $this->name,
            'address' => $this->address,
            'transactionID' => $this->transaction_id,
        ];
    }
}
