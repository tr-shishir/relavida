<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "categories";
    protected $guarded = ['id'];

    protected $fillable = [
        'title',
        'created_by',
        'edited_by',
        'url',
        'parent_id',
        'rel_type',
        'rel_id',
        'position',
        'category_subtype',
        'users_can_create_content',
        'data_type',
        'drm_ref_id',
        'is_hidden',
    ];

    public function categoryItem(): BelongsTo
    {
        return $this->belongsTo(CategoryItem::class, 'parent_id', 'id');
    }
}


