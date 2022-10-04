<?php


namespace App\Services\Category;


use App\Enums\SyncEvent;
use App\Enums\SyncType;
use App\Models\Category;
use App\Models\SyncHistory;
use App\Services\DrmSyncService;
use App\Services\BaseService;
use Illuminate\Support\Arr;

use DB;

class CategoryService extends BaseService
{
    public function all(array $filters = [])
    {
        $event = Arr::get($filters, 'sync_event', 'create');

        $query = Category::query()
            ->join('sync_history', 'categories.id', '=', 'sync_history.model_id')
            ->where('sync_type', '=', SyncType::CATEGORY)
            ->where('sync_event', '=', $event)
            ->where([
                'rel_id' => 8,
                'data_type' => 'category',
            ]);

        $limit = Arr::get($filters, 'limit', 20);

        return $limit != '-1' ? $query->paginate($limit) : $query->get();
    }

    public function getById($id)
    {
        return Category::where('drm_ref_id', $id)->first();
    }

    public function store(array $data)
    {
        return $this->saveCategory($data, Arr::get($data, 'drm_ref_id'));
    }

    public function update($id, array $data)
    {
        return $this->saveCategory($data, $id);
    }

    public function destroy($id)
    {
        return Category::where('drm_ref_id', $id)->delete();
    }

    private function saveCategory($data, $id = null)
    {
        $product = Category::firstOrNew(['drm_ref_id' => $id]);
        $product->fill($data);
        $product->save();

        return $product;
    }

    public function syncCategoryToDrm(SyncHistory $syncHistory)
    {
        $syncHistory = $syncHistory->fresh();
        switch ($syncHistory->sync_event) {
            case SyncEvent::CREATE:
                $drm_cat_id = 0;
                $category = Category::find($syncHistory->model_id);
                if($category->parent_id != 0){
                    $category_drm = Category::find($category->parent_id);
                    $drm_cat_id = $category_drm->drm_ref_id;
                }

                try{
                    if ($category) {
                        $response = app(DrmSyncService::class)->storeCategory(['category_name' => $category->title , 'parent' => $drm_cat_id , 'shop_category_id' => $category->id]);
                        if (!empty($response['id'])) {
                            DB::table('categories')->where('id', $syncHistory->model_id)->update([
                                'drm_ref_id' => $response['id']
                            ]);
                            $syncHistory->update([
                                'synced_at' => date('Y-m-d H:i:s'),
                                'response'  => json_encode($response),
                            ]);
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

                $drm_cat_id = 0;
                $category = Category::find($syncHistory->model_id);
                if($category->parent_id != 0){
                    $category_drm = Category::find($category->parent_id);
                    $drm_cat_id = $category_drm->drm_ref_id;
                }

                try{
                    if ($category) {
                        if ( $category->drm_ref_id ) {
                            $response = app(DrmSyncService::class)->updateCategory($category->drm_ref_id, ['category_name' => $category->title , 'parent' => $drm_cat_id]);
                        } else {
                            $response = app(DrmSyncService::class)->storeCategory(['category_name' => $category->title , 'drm_ref_id' => $drm_cat_id]);
                        }
                        $syncHistory->update([
                            'synced_at' => date('Y-m-d H:i:s'),
                            'response'  => json_encode($response),
                        ]);
                        DB::table('categories')
                            ->where('id', $syncHistory->model_id)
                            ->update([
                                'drm_ref_id' => $response['id']
                            ]);
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
                    if ($syncHistory->drm_ref_id) {
                        $response = app(DrmSyncService::class)->deleteCategory($syncHistory->drm_ref_id);
                        $syncHistory->update([
                            'synced_at' => date('Y-m-d H:i:s'),
                            'response'  => json_encode($response),
                        ]);
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
