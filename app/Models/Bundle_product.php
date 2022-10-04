<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bundle_product extends Model
{
    use HasFactory;
    protected $table = 'bundle_products';

    public function content()
    {
        return $this->hasOne(Content::class, 'id', 'product_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'rel_id', 'product_id');
    }

    public function contentData()
    {
        return $this->hasMany(ContentData::class, 'rel_id', 'product_id');
    }
}
