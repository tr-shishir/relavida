<?php

namespace App\Jobs;

use App\Models\SyncHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\Category\CategoryService;
use App\Services\Customer\CustomerService;
use App\Services\Order\OrderService;
use App\Services\Product\ProductService;

class DrmSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120;
    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $syncHistories = SyncHistory::whereNull('synced_at')
            ->where('tries', '<', 3)
            ->limit(env('SYNC_ITEM_LIMIT', 50))
            ->get();

        foreach($syncHistories as $syncHistory) {
            switch($syncHistory->sync_type) {
                case \App\Enums\SyncType::CATEGORY:
                    app(CategoryService::class)->syncCategoryToDrm($syncHistory);
                    break;

                case \App\Enums\SyncType::CUSTOMER:
                    app(CustomerService::class)->syncCustomerToDrm($syncHistory);
                    break;

                case \App\Enums\SyncType::PRODUCT:
                    app(ProductService::class)->syncProductToDrm($syncHistory);
                    break;

                case \App\Enums\SyncType::ORDER:
                    app(OrderService::class)->syncOrderToDrm($syncHistory);
                    break;
            }
        }
    }
}
