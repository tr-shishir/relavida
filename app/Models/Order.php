<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'cart_orders';

    public function carts(){
    	return $this->hasMany('App\Models\Cart', 'order_id', 'id');
    }
}
