<?php

namespace App\Services\Product;

use App\Models\CategoryItem;
use App\Models\Content;
use App\Models\CustomField;
use App\Models\CustomFieldValue;
use App\Models\Media;
use App\Services\BaseService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Services\DrmSyncService;
use App\Enums\SyncEvent;

class ProductService extends BaseService
{
    public function all(array $filters = [])
    {
        $query = Content::product();

        if (!empty($filters['q'])) {
            $query->where(DB::raw('LOWER(title)'), 'LIKE', '%' . strtolower($filters['q']) . '%');
        }

        $limit = Arr::get($filters, 'limit', 20);

        return $limit != '-1' ? $query->paginate($limit) : $query->get();
    }

    public function getById($id)
    {
        return Content::product()->where('drm_ref_id', $id)->first();
    }

    public function store(array $data)
    {
        return $this->saveProduct($data, data_get($data, 'drm_ref_id'));
    }

    public function update($id, array $data)
    {
        return $this->saveProduct($data, $id);
    }

    public function destroy($id)
    {
        DB::table('products')
            ->join('content' , 'products.content_id' , '=' , 'content.id')
            ->where('content.drm_ref_id',$id)
            ->delete();
        return Content::product()->where('drm_ref_id', $id)->delete();
    }

    private function saveProduct($data, $id = null)
    {
        // save to content table
        $shop = Content::where([
            'content_type' => 'page',
            'subtype' => 'dynamic',
            'url' => 'shop',
        ])->first();
        if($shop) {
            $data['parent'] = $shop->id;
        }
        $data['created_by'] = (get_users("is_admin=1")[0]['id'] == user_id()) ? (int) user_id() : (int) get_users("is_admin=1")[0]['id'];

        $product = Content::firstOrNew(['drm_ref_id' => $id]);
        $product->fill($data);
        $product->save();

        return $product;
    }

    public function getFormData($id)
    {
        $data = [];
        $product = Content::with(['media', 'contentData', 'customField', 'taggingTagged', 'categoryItem',])->find($id);
        $price = $product->customField->where('name_key', 'price')->where('type', 'price')->first();
        if ($price) {
            $price = $price->customFieldValue->first() ? $price->customFieldValue->first()->value : 0;
        }
        $product_details = \DB::table('product_details')->select('suplier')->where('rel_id',$id)->first();

        $contentDetail = $product->contentData->pluck('field_value', 'field_name')->toArray();

        $data['title'] = $product->title;
        $data['url'] = $product->url;
        $data['description'] = $product->content_body;
        $data['short_description'] = $product->description;
        $data['channel'] = 10;

        $images = $product->media->pluck('images')->toArray();

        $drm_base_url = config('global.drm_base_url');

        $data['images'] = array_map(function ($img) use ($drm_base_url) {
            return str_replace('{SITE_URL}', url('/'), $img);
        }, $images);

        $data['categories'] = CategoryItem::select('categories.title', 'categories.drm_ref_id' )
            ->join('categories', 'categories_items.parent_id', '=', 'categories.id')
            ->where('categories_items.rel_id', $id)
            ->where('categories.drm_ref_id', '>', 0)
            ->pluck('drm_ref_id')
            ->toArray();

        $data['ean'] = $product->ean;
        $data['ek_price'] = $product->ek_price;
        $data['vk_price'] = $price;
        $data['stock'] = Arr::get($contentDetail, 'qty') == 'nolimit' ? 10000 : (int)Arr::get($contentDetail, 'qty');
        $data['item_number'] = Arr::get($contentDetail, 'sku');
        // $data['item_weight'] = Arr::get($contentDetail, 'shipping_weight');
        // $data['item_size'] = Arr::get($contentDetail, 'shipping_height');
        $data['status'] = $product->is_active;
        $data['tags'] = implode(",", $product->taggingTagged->pluck('tag_name')->toArray());
        $data['brand']  = $product->brand;
        $data['delivery_days']  = $product->delivery_days;
        $data['item_size']  = $product->item_size;
        $data['item_weight']  = $product->item_weight;
        $data['item_color']  = $product->item_color;
        $data['materials']  = $product->materials;
        $data['production_year']  = $product->production_year;
        $data['delivery_company_id']  = $product_details->suplier;
        $data['gender']  = $product->gender;
        $data['note']  = $product->note;
        $data['status']  = $product->status;
        $data['is_connected']  = 1;
        // $data['drm_product_id'] = 0;

        return $data;
    }

    public function syncProductToDrm($syncHistory)
    {
        switch ($syncHistory->sync_event) {
            case SyncEvent::CREATE:
                $product = Content::find($syncHistory->model_id);
                try {
                    if ($product) {
                        $response = app(DrmSyncService::class)->storeProduct($this->getFormData($syncHistory->model_id));
                        if (!empty($response['id'])) {
                            $product->update(['drm_ref_id' => $response['id']]);
                            $syncHistory->update([
                                'response' => json_encode($response),
                                'synced_at' => date('Y-m-d H:i:s'),
                            ]);
                        }
                    }
                    $syncHistory->increment('tries');
                } catch (\Exception $e) {
                    $syncHistory->update([
                        'exception' => json_encode($e->getMessage()),
                        'tries' => $syncHistory->tries + 1
                    ]);
                }
                break;
            case SyncEvent::UPDATE:
                $product = Content::find($syncHistory->model_id);
                try {
                    if ($product && $product->drm_ref_id) {
                        $response = app(DrmSyncService::class)->updateProduct($product->drm_ref_id, $this->getFormData($syncHistory->model_id));
                        if ($response) {
                            $syncHistory->update([
                                'response' => json_encode($response),
                                'synced_at' => date('Y-m-d H:i:s')
                            ]);
                        }
                    }
                    $syncHistory->increment('tries');
                } catch (\Exception $e) {
                    $syncHistory->update([
                        'exception' => json_encode($e->getMessage()),
                        'tries' => $syncHistory->tries + 1
                    ]);
                }
                break;
            case SyncEvent::DELETE:
                try {
                    if ($syncHistory->fresh()->drm_ref_id) {
                        $response = app(DrmSyncService::class)->deleteProduct($syncHistory->drm_ref_id);
                        $syncHistory->update([
                            'response' => json_encode($response),
                            'synced_at' => date('Y-m-d H:i:s')
                        ]);
                    }
                    $syncHistory->increment('tries');
                } catch (\Exception $e) {
                    $syncHistory->update([
                        'exception' => json_encode($e->getMessage()),
                        'tries' => $syncHistory->tries + 1
                    ]);
                }
                break;
        }

        return $syncHistory;
    }
}
