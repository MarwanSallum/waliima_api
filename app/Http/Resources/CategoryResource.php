<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'image' => $this->image,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
        
    }
}