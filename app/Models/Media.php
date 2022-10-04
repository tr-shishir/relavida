<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "media";

    public function product(): BelongsTo
    {
        return $this->belongsTo(Content::class, 'id', 'rel_id');
    }

    public function getFilenameAttribute($value)
    {
        return str_replace("{SITE_URL}", site_url(), $value);
    }

    public function getImagesAttribute()
    {
        return $this->getOriginal('filename');
    }
}
