<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sync_processing_history_v2 extends Model
{
    use HasFactory;
    protected $table = 'sync_processing_history_v2';
    protected $fillable = ['source', 'sync_id', 'count', 'success_count', 'error_count', 'sync_status'];
}
