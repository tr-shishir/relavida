<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CategoryItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "categories_items";
    protected $guarded = ['id'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Content::class, 'id', 'rel_id');
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function parent(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }
}
