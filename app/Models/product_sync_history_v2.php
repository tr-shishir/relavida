<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_sync_history_v2 extends Model
{
    use HasFactory;
    protected $table = 'product_sync_history_v2';
    protected $fillable = [
        'data',
        'type',
        'count',
        'action',
        'sync_id',
        'status',
        'drm_status',
        'old_sync_id',
        'data_type',
    ];
}
