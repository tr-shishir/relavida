<?php


namespace App\Services\Customer;


use App\Services\BaseService;
use Illuminate\Support\Arr;
use App\Services\DrmSyncService;
use App\Enums\SyncEvent;
use App\Enums\SyncType;

use DB;
use MicroweberPackages\User\Models\User;

class CustomerService extends BaseService
{
    public function all(array $filters = [])
    {
        $query = User::customer();

        $limit = Arr::get($filters, 'limit', 20);

        return $limit != '-1' ? $query->paginate($limit) : $query->get();
    }

    public function getById($id)
    {
        return User::customer()->find($id);
    }

    public function store(array $data)
    {
        return $this->saveCustomer($data);
    }

    public function update($id, array $data)
    {
        return $this->saveCustomer($data, $id);
    }

    public function destroy($id)
    {
        return User::customer()->where('drm_ref_id', $id)->delete();
    }

    private function saveCustomer($data, $id = null)
    {
        $product = User::firstOrNew(['drm_ref_id' => $id]);
        $product->fill($data);
        $product->save();

        return $product;
    }

    public function syncCustomerToDrm ($syncHistory)
    {
        switch ($syncHistory->sync_event) {
            case SyncEvent::CREATE:
                $customer = User::find($syncHistory->model_id);
                try{
                    if ($customer) {
                        $response = app(DrmSyncService::class)->storeCustomer([
                            'full_name' => $customer->first_name.' '.$customer->last_name,
                            'email'     => $customer->email,
                        ]);
                        if (!empty($response['id'])) {
                            DB::table('users')->update([
                                'drm_ref_id' => $response['id'],
                            ]);
                            $syncHistory->update(['synced_at' => date('Y-m-d H:i:s')]);
                        }
                    }
                    $syncHistory->increment('tries');
                } catch (\Exception $e) {
                    $syncHistory->update([
                        'exception'=>json_encode($e->getMessage()),
                        'tries' => $syncHistory->tries + 1
                    ]);
                }
                break;

            case SyncEvent::UPDATE:
                $customer = User::find($syncHistory->model_id);
                try{
                    if ($customer && $customer->drm_ref_id) {
                        $response = app(DrmSyncService::class)->updateCustomer($customer->drm_ref_id, [
                            'full_name' => $customer->first_name.' '.$customer->last_name,
                            'email'     => $customer->email,
                        ]);
                        $syncHistory->update(['synced_at' => date('Y-m-d H:i:s')]);
                    }
                    $syncHistory->increment('tries');
                } catch (\Exception $e) {
                    $syncHistory->update([
                        'exception'=>json_encode($e->getMessage()),
                        'tries' => $syncHistory->tries + 1
                    ]);
                }
                break;

            case SyncEvent::DELETE:
                try{
                    if ( $syncHistory->drm_ref_id) {
                        app(DrmSyncService::class)->deleteCustomer($syncHistory->drm_ref_id);
                    }
                    $syncHistory->increment('tries');
                } catch (\Exception $e) {
                    $syncHistory->update([
                        'exception'=>json_encode($e->getMessage()),
                        'tries' => $syncHistory->tries + 1
                    ]);
                }
                break;
        }

        return $syncHistory;
    }
}
