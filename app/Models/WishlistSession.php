<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishlistSession extends Model
{
    protected $guarded = [];

    public function products()
    {
        return $this->hasManyThrough('App\Models\WishlistSessionProduct', 'App\Models\WishlistSession');
    }

    public function user()
    {
        return $this->belongsTo('MicroweberPackages\User\Models\User','user_id');
    }

    public function wlproducts()
    {
        return $this->hasMany('App\Models\WishlistSessionProduct','wishlist_id','id');
    }
}
