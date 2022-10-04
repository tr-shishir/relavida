<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishlistSessionProduct extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('MicroweberPackages\User\Models\User','user_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Content','product_id','id');
    }

    public function wishlist()
    {
        return $this->belongsTo('App\Models\WishlistSession','id','wishlist_id');
    }
}
