<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
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
        return ($val !== null) ? asset('assets/' . $val) : "";

    }

    public function advertiser(){
        return $this ->belongsTo(User::class, 'user_id', 'id');
    }

    public function category(){
        return $this ->belongsTo(Category::class, 'category_id','id');
    }

}
