<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'image' => $this->image,
            'is_active' => $this->is_active = 0 ? 'NOT Active' : 'Active',
            'email' => $this->email,
            'mobile' => $this->mobile,
            'amount' => $this->amount,
            'advertis_from' => $this->advertis_from,
            'advertis_to' => $this->advertis_to
            
        ]; 
    }
}
