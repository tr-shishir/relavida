<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';

    public function order(){
    	return $this->belongsTo('App\Models\Order', 'order_id');
    }
    public function content(){
        return $this->hasMany('App\Models\Content', 'id', 'rel_id');
    }
    public function creator()
    {
        return $this->belongsTo('MicroweberPackages\User\Models\User','created_by');
    }
}
