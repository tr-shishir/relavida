<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\DrmSyncService;

class DrmSyncController extends Controller
{
    private $service;

    public function __construct(DrmSyncService $service)
    {
        $this->service = $service;
    }

    public function syncWithDrm ()
    {
        $syncAble = SyncHistory::find(1);
        $syncEvent = $syncAble->sync_event;

        $category_response = '';

        dd();

        if ( !empty($category_response['id']) ) {
            $syncAble->update([
                'synced_at' => date('Y-m-d h:i:s'),
            ]);
            $category->update([
                'drm_ref_id' => $category_response['id'],
            ]);
            dd('Done !');
        }
    }
}
