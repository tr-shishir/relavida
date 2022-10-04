<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bundle_product;

class Bundle extends Model
{
    use HasFactory;

    protected $table = 'bundles';

    public function bundle_products()
    {
        return $this->hasMany(Bundle_product::class, 'bundle_id', 'id');
    }
}
