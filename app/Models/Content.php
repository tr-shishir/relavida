<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

class Content extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "content";

    protected $guarded = ['id'];

    public function media(): HasMany
    {
        return $this->hasMany(Media::class, 'rel_id', 'id');
    }

    public function contentData(): HasMany
    {
        return $this->hasMany(ContentData::class, 'rel_id', 'id');
    }

    public function customField(): HasMany
    {
        return $this->hasMany(CustomField::class, 'rel_id', 'id');
    }

    public function taggingTagged(): HasMany
    {
        return $this->hasMany(TaggingTagged::class, 'taggable_id', 'id');
    }
    public function tagged(): HasMany
    {
        return $this->hasMany(TaggingTagged::class, 'taggable_id', 'id');
    }

    public function categoryItem(): HasMany
    {
        return $this->hasMany(CategoryItem::class, 'rel_id', 'id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(CategoryItem::class, 'rel_id', 'id')->with('category');
    }

    public function scopeProduct($query)
    {
        return $query->where('content_type', '=', 'product');
    }

    public function parent ()
    {
//        return $this->belongsTo(App\Models\Content::class, );
    }

    public function cart(){
        return $this->belongsTo('App\Models\Cart', 'rel_id');
    }
    public function wishListProducts()
    {
        return $this->hasMany('App\Models\WishlistSessionProduct','product_id','id');
    }

}
