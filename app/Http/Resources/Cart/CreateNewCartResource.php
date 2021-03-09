<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Resources\Json\JsonResource;

class CreateNewCartResource extends JsonResource
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
            'message' => 'تم إنشاء عربة تسوق جديدة',
            'cartToken' => $this->id,
            'cartKey' => $this->key,
        ];
    }
}
