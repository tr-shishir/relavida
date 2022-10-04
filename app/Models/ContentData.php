<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContentData extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "content_data";
    protected $guarded = ['id'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Content::class, 'id', 'rel_id');
    }
}
