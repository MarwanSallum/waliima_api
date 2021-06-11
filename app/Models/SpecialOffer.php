<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialOffer extends Model
{
    protected $fillable = [
        'title',
        'price',
        'image',
        'status',
        'offer_begin',
        'offer_end',
    ];

    public function getImageAttribute($val)
    {
        return ($val !== null) ? asset($val) : "";

    }
}