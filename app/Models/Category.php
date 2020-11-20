<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded =[];
    public $timestamps = true;
    protected $hidden = [
     'created_at','updated_at',
    ];

    public function scopeSelection($query){
        return $query -> select('id', 'name', 'image');
    }

    public function getImageAttribute($val)
    {
        return ($val !== null) ? asset($val) : "";

    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function products(){
        return $this ->hasMany(Product::class);
    }
}
