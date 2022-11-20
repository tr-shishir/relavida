<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;

class Products extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "product";

    protected $guarded = ['id'];

    public function media(): HasMany
    {
        return $this->hasMany(Media::class, 'rel_id', 'id')->where('media.rel_type', 'product');
    }

    public function categoryItem(): HasMany
    {
        return $this->hasMany(CategoryItem::class, 'rel_id', 'content_id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(CategoryItem::class, 'rel_id', 'id')->where('categories_items.rel_type', 'product')->with('category','parent');
    }

    public function taggingTagged(): HasMany
    {
        return $this->hasMany(TaggingTagged::class, 'taggable_id', 'id');
    }
    public function tagged(): HasMany
    {
        return $this->hasMany(TaggingTagged::class, 'taggable_id', 'id');
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
        return $this->hasMany('App\Models\WishlistSessionProduct','product_id','content_id');
    }

    public function scopeContentType($query, $value){
        $query->whereHas('content',function($q) use ($value){
            $q->where('content_type',$value);
        });
    }
    public function scopeContentOrder($query, $value){
        $query->whereHas('content',function($q) use ($value){
            $order = explode(' ',$value);
            $q->orderBy($order[0],$order[1]);
        });
    }
    public function scopeContentRss($query, $value){
        $query->whereHas('content',function($q) use ($value){
            $q->where('is_rss',$value);
        });
    }

}
