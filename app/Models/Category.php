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

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
