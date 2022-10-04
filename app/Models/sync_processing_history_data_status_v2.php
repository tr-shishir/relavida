<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sync_processing_history_data_status_v2 extends Model
{
    use HasFactory;
    protected $table = 'sync_processing_data_status_v2';
    protected $fillable = ['processing_id', 'content_id', 'drm_ref_id', 'msg', 'is_success'];
}
