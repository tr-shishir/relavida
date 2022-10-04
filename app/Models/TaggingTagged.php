<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TaggingTagged extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "tagging_tagged";

    public function product(): BelongsTo
    {
        return $this->belongsTo(Content::class, 'id', 'taggable_id');
    }
}
