<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomFieldValue extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "custom_fields_values";
    protected $guarded = ['id'];
    public $timestamps = false;

    public function customField(): BelongsTo
    {
        return $this->belongsTo(CustomField::class, 'id', 'custom_field_id');
    }
}
