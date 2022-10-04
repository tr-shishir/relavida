<?php

namespace App\Models;

use App\Jobs\DrmSyncJob;
use App\Services\DrmSyncService;
use Illuminate\Database\Eloquent\Model;

class SyncHistory extends Model
{
    protected $table = 'sync_history';

    protected $fillable = [
        'sync_type',
        'sync_event',
        'model_id',
        'synced_at',
        'drm_ref_id',
        'tries',
        'exception',
        'response',
    ];


    static function boot ()
    {
    	parent::boot();

    	static::created(function($item) {
            try {
                $response = app(DrmSyncService::class)->requestForSyncFromDT([
                    'dt_ref_id' => $item->id,
                ]);
            } catch (\Exception $e) {
                $item->update([
                    'exception'=>json_encode($e->getMessage()),
                ]);
            }
        });
    }
}
