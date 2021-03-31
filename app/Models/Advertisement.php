<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $guarded =[];
    protected $hidden = [
     'created_at','updated_at',
    ];

    
    public function getImageAttribute($val)
    {
        return ($val !== null) ? asset($val) : "";

    }

    public function scopeActive($query){
        return $query -> where('is_active',1) ;
    }
}
