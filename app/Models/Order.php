<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['products', 'total_price', 'user_id','transaction_id','name','address'];
}
