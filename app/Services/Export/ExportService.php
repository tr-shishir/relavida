<?php

namespace App\Services\Export;

use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use \Intervention\Image\ImageManagerStatic as Image;

class ExportService extends BaseService
{

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $header, $key, $count, $processing_id, $syncedId, $params, $url=false)
    {
        $this->data = $data;
        $this->key = $key;
        $this->header = $header;
        $this->count = $count;
        $this->processing_id = $processing_id;
        $this->syncedId = $syncedId;
        $this->params = $params;
        $this->url = $url;
    }

    public function executeProcess(){
        ini_set('memory_limit', '-1');


        $info = array();
        $errorContentDataSet=array();
        $contentDataSet = array();
        $contentDataSetIds = array();
        $productDetailsDataSet = array();
        $tagsDataSet = array();
        $taggedDataSet = array();
        $contentQtyDataSet = array();
        $contentSkuDataSet = array();
        $contentPriceDataSet = array();
        $priceValueDataSet = array();
        $tagFullDataSet = array();
        $categoryDataSet = array();
        $categoryFullDataSet = array();
        $offerDataSet = array();
        $offerNewDataSet = array();
        $variantDataSet = array();
        $variantImageDataSet = array();
        $newVariantFullDataSet = array();
        $newVariantImageFullDataSet = array();
        $mediaDataSet = array();
        $mediaDataSetMetadata = array();
        $mediaImageFullDataSet = array();
        $productDataSet = array();
        $errorLogData = array();
        $successLogData = array();
        $newPriceValueDataSet = array();
        $drmIds = array();
        $categoryStatus = array();
        $errorCount = 0;
        $successCount = 0;


        $sessionId = $this->key.date("U");
        $currentTime = \Carbon\Carbon::now();
        $newPositionData = DB::table('content')->select('position')->orderBy('position', 'desc')->first() ?? 0;
        if(isset($newPositionData->position)){
            $newposition = $newPositionData->position+1;
        }else{
            $newposition = 0;
        }
        foreach ($this->data as $value)
        {
            $forceValidated = false;
            $dataSet = array_combine($this->header,$value);

            $info[] = $dataSet;
            if($this->params){
                DB::table('sync_processing_data_status_v2')->where('processing_id', $this->processing_id)->where('drm_ref_id', $dataSet['drm_ref_id'])->delete();
            }
            $validatedData = Validator::make($dataSet, [
                'title' => 'required',
                'drm_ref_id' => 'required|unique:content,drm_ref_id',
                'ek_price' => 'required|numeric',
                'price' => 'numeric',
                'ean' => 'required|unique:content,ean',
                'images' => 'required',
                'categories' => 'required|string',
                'delivery_company_id' => 'required',
                'tax_type' => 'required',
            ]);



            if($validatedData->fails()){
                $isEan = $validatedData->messages()->messages() ?? [];
                if(array_key_exists('ean',$isEan) or array_key_exists('drm_ref_id',$isEan)){
                    if(function_exists('deleteAllContentDetails')){
                        deleteAllContentDetails($dataSet['drm_ref_id']);
                    }
                    $forceValidated = true;
                } else{
                    $errorCount++;
                    $errorLogData[] = [
                        'processing_id' => $this->processing_id,
                        'msg' => json_encode($validatedData->messages()),
                        'drm_ref_id' => $dataSet['drm_ref_id']
                    ];
                    continue;
                }

            }

            if($forceValidated or $validatedData->validated()){
                $url =  mw()->url_manager->slug($dataSet['title']).'-'.rand();
                $newposition++;

                $categories = json_decode($dataSet['categories']) ?? array_filter(explode(',', $dataSet['categories']));
                if(isset($categories) && !empty($categories)){
                    $returnBack = false;
                    $categoryData = \MicroweberPackages\Category\Models\Category::whereIn('drm_ref_id', array_values((array)$categories))->with('parent')->get()->keyBy('drm_ref_id')->toArray();
                    foreach($categories as $keyId => $category){
                        // $categoryData = \MicroweberPackages\Category\Models\Category::where('drm_ref_id', $category)->select('id','drm_ref_id','is_hidden')->with('parent')->get()->toArray();
                        if(isset($categoryData[$category]) && !empty($categoryData[$category])){
                            $arr = [];
                            $categoriees = $categoryData[$category];
                            $arr[] = $categoriees;
                            for (; ;) {
                                if (is_array($categoriees['parent'])) {
                                    $arr[] = $categoriees['parent'];
                                    $categoriees = $categoriees['parent'];
                                } else {
                                    break;
                                }
                            }
                            foreach ($arr as $ar) {
                                $categoryDataSet[$dataSet['drm_ref_id']][] = [
                                    'parent_id' => $ar['id'],
                                    'rel_type' => 'content',
                                ];
                                if($ar['is_hidden'] == 1){
                                    $categoryStatus[] = $ar['drm_ref_id'];
                                }
                            }
                        }else{
                            $errorCount++;
                            $errorLogData[] = [
                                'processing_id' => $this->processing_id,
                                'msg' => json_encode(['category' => 'category not found']),
                                'drm_ref_id' => $dataSet['drm_ref_id']
                            ];
                            $returnBack = true;
                            continue;
                        }

                    }
                    if($returnBack === true){
                        continue;
                    }

                }

                $contentDataSetIds[] = $dataSet['drm_ref_id'];
                $successCount++;

                $contentDataSet[$dataSet['drm_ref_id']] = array_merge(collect($dataSet)->only(
                    [
                        'title',
                        'drm_ref_id',
                        'content_body',
                        'description',
                        'ean',
                        'content_type',
                        'subtype',
                        'is_active',
                        'ek_price',
                        'brand',
                        'materials',
                        'production_year',
                        'gender',
                        'note',
                        'status',
                        'item_unit',
                    ]
                    )->toArray(),
                    ['url' => $url],
                    ['content_meta_keywords' => $dataSet['tags']],
                    ['position' => $newposition],
                    ['item_size' => $dataSet['size']],
                    ['item_weight' => $dataSet['weight']],
                    ['session_id' => $sessionId],
                    ['item_color' => $dataSet['color']],
                    ['parent' => $GLOBALS['shop_data'][0]['id']??2],
                );
                $main_price = $dataSet['price']+product_tax_amount($dataSet['price'],$dataSet['tax_rate']);
                if(isset($dataSet['uvp']) && $dataSet['uvp'] > $main_price) {
                    $offerDataSet[$dataSet['drm_ref_id']]= [
                        'offer_price' => $dataSet['price']??0,
                        'created_at' => $currentTime,
                        'created_by' => 1,
                        'edited_by' => 1,
                        'is_active' => 1
                    ];
                    $dataSet['price'] = $dataSet['uvp'];
                }

                $priceValueDataSet[$dataSet['drm_ref_id']] =array_merge(
                    ['value' => $dataSet['price']??0],
                    ['position' => 0]
                );
                $priceForProduct = $dataSet['price'];

                if($dataSet['price_on_request'] == 1){
                    $priceForProduct = 0;
                }
                $productDataSet[$dataSet['drm_ref_id']] = array_merge(collect($dataSet)->only(
                    [
                        'title',
                    ]
                    )->toArray(),
                    ['url' => $url],
                    ['price' => $priceForProduct],
                    ['quantity' => $dataSet['qty'] ?? 'nolimit'],
                    ['tax_type' => $dataSet['tax_type'] ?? 1],

                );

                $productDetailsDataSet[$dataSet['drm_ref_id']] =array_merge(collect($dataSet)->only(
                    [
                        'tax_type',
                        'offer_options',
                        'basic_price',
                    ]
                    )->toArray(),
                    ['suplier' => $dataSet['delivery_company_id']],
                );

                $tags = @json_decode($dataSet['tags']) ?? array_filter(explode(',', $dataSet['tags']));
                if(isset($tags) && !empty($tags)){
                    $tagData = DB::table('tagging_tags')->whereIn('name',$tags)->pluck('name')->toArray();
                    foreach($tags as $tag){
                        if(isset($tag) && $tag != ""){
                            if(!in_array($tag,$tagData)){
                                $tagsDataSet[$dataSet['drm_ref_id']][] = array_merge(['slug' => Str::slug($tag), 'name' =>$tag], ['count' => 1]);
                            }
                            $taggedDataSet[$dataSet['drm_ref_id']][] = array(
                                'taggable_type' => 'content',
                                'tag_name' => $tag,
                                'tag_slug' => Str::slug($tag)
                            );
                        }
                    }
                    if(isset($tagsDataSet[$dataSet['drm_ref_id']]) || isset($taggedDataSet[$dataSet['drm_ref_id']])){
                        $tagFullDataSet[$dataSet['drm_ref_id']] = array(
                            $tagsDataSet[$dataSet['drm_ref_id']]??[],$taggedDataSet[$dataSet['drm_ref_id']]??[]
                        );
                    }
                }


                $contentQtyDataSet[$dataSet['drm_ref_id']] =array_merge(
                    ['field_value' => $dataSet['qty'] ?? 'nolimit'],
                    [
                        'field_name' => 'qty',
                        'rel_type' => 'content',
                    ]
                );

                $contentSkuDataSet[$dataSet['drm_ref_id']] =array_merge(
                    ['field_value' => $dataSet['qty'] ?? 'nolimit'],
                    [
                        'field_name' => 'sku',
                        'rel_type' => 'content',
                    ]
                );

                $contentPriceDataSet[$dataSet['drm_ref_id']] =array_merge(
                    [
                        'rel_type' => 'content',
                        'type' => 'price',
                    ],
                    ['name' => 'price', 'name_key' => 'price', 'is_active' => 1]
                );

                $images = json_decode($dataSet['images']) ?? array_filter(explode(',', $dataSet['images']));
                if(isset($images) && !empty($images)){
                    foreach ($images as $key => $image) {

                        $mediaDataSet[$dataSet['drm_ref_id']][] = [
                            'rel_type' => 'content',
                            'media_type' => 'picture',
                            'filename' => $image,
                            'image_id' => $dataSet['drm_ref_id']
                        ];
                        if(!isset($productDataSet[$dataSet['drm_ref_id']]['image']) && empty($productDataSet[$dataSet['drm_ref_id']]['image'])){
                            $productDataSet[$dataSet['drm_ref_id']] = array_merge($productDataSet[$dataSet['drm_ref_id']],
                                [
                                    'image' => $image
                                ]
                            );

                        }

                    }
                }

                $variants = json_decode($dataSet['variants']) ?? array_filter(explode(',', $dataSet['variants']));

                if(isset($variants) && !empty($variants)){
                    foreach ($variants as $variant){

                        // $variant = collect($variant);
                        // dd($variant);
                        DB::table('variants')->where('drm_ref_id',$variant->drm_ref_id)->delete();

                        $variantDataSet[$dataSet['drm_ref_id']][] = [
                            'title' => $variant->title,
                            'price' => $variant->price ?? 0,
                            'uvp' => $variant->uvp ?? 0,
                            'ean' => $variant->ean,
                            'sku' => $variant->sku,
                            'color' => $variant->color,
                            'size' => $variant->size,
                            'materials' => $variant->materials,
                            'drm_ref_id' => $variant->drm_ref_id,
                            'description' => $variant->description,
                            'stock' => $variant->qty,

                        ];

                        if (!empty($variant->images) && is_array($variant->images)) {
                            foreach ($variant->images as $image) {
                                $variantImageDataSet[$dataSet['drm_ref_id']][] = [
                                    'rel_type' => 'content',
                                    'media_type' => 'picture',
                                    'filename' => $image,
                                    'image_id' => $variant->drm_ref_id
                                ];
                            }
                        }

                    }
                }
                $successLogData[$dataSet['drm_ref_id']] = [
                    'processing_id' => $this->processing_id,
                    'msg' => json_encode(collect($dataSet)->only(['title',
                        'drm_ref_id',
                        'ean',
                        'content_type',
                        'subtype',
                        'is_active',
                        'ek_price'])->toArray()),
                    'drm_ref_id' => $dataSet['drm_ref_id'],
                    'is_success' => 1
                ];



            }

        }
        if(isset($errorLogData) && !empty($errorLogData)){
            DB::table('sync_processing_data_status_v2')->insert($errorLogData);
        }
        if(isset($contentDataSet) && !empty($contentDataSet)){

            DB::table('content')->insert($contentDataSet);

            $productDetails = DB::table('content')->select('id','drm_ref_id','url')->where('session_id',$sessionId)->get();

            $productIds = $productDetails->pluck('id')->toArray();

            $this->executeQuery($productIds,$productDetails,$productDetailsDataSet,$contentQtyDataSet,$contentSkuDataSet,$contentPriceDataSet,$priceValueDataSet,$tagFullDataSet,$categoryDataSet,$categoryFullDataSet,$offerDataSet,$offerNewDataSet,$variantDataSet,$variantImageDataSet,$newVariantFullDataSet,$newVariantImageFullDataSet,$mediaDataSet,$mediaImageFullDataSet,$productDataSet,$errorLogData,$successLogData,$newPriceValueDataSet,$drmIds,$categoryStatus);

        }
        if($successCount != 0) DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->where('id', $this->processing_id)->increment('success_count', $successCount);
        if($errorCount != 0) DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->where('id', $this->processing_id)->increment('error_count', $errorCount);
        if(($this->key+1) == $this->count){
            if($this->params){
                DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->where('id', $this->processing_id)->decrement('error_count', $successCount);
            }else{
                $total_count = DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->select('count', 'success_count', 'error_count')->orderBy('id', 'DESC')->first();
                if(isset($total_count) and $total_count->count == ($total_count->success_count + $total_count->error_count)){
                    DB::table('product_sync_history_v2')->where('sync_id', $this->syncedId)->update(['status' => "success"]);
                    DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->update(['sync_status' => "success"]);
                } else{
                    DB::table('product_sync_history_v2')->where('sync_id', $this->syncedId)->update(['status' => "failed"]);
                    DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->update(['sync_status' => "failed"]);
                }
            }
            $optimize_data = DB::table('image_optimize')->whereIn('status',[1,2,3])->select('compress','minimum_size','thumbnail_width', 'status')->orderBy('status', 'ASC')->get()->keyBy('status')->toArray();
            DB::table('media')
            ->select('rel_id','filename','image_id')
            ->where('rel_type','content')
            ->whereNull('resize_image')
            ->whereNotNull('image_id')
            ->whereNull('webp_image')
            ->orderBy('rel_id')
            ->chunk(50, function ($medias) use($optimize_data) {
               \App\Jobs\ImageCompressJob::dispatch($medias,$optimize_data,$this->url)->onQueue("low");
            });
        }
    }

    public function executeUpdateProcess(){
        ini_set('memory_limit', '-1');


        $info = array();
        $errorContentDataSet=array();
        $contentDataSet = array();
        $contentDataSetIds = array();
        $productDetailsDataSet = array();
        $tagsDataSet = array();
        $taggedDataSet = array();
        $contentQtyDataSet = array();
        $contentSkuDataSet = array();
        $contentPriceDataSet = array();
        $priceValueDataSet = array();
        $tagFullDataSet = array();
        $categoryDataSet = array();
        $categoryFullDataSet = array();
        $offerDataSet = array();
        $offerNewDataSet = array();
        $variantDataSet = array();
        $variantImageDataSet = array();
        $newVariantFullDataSet = array();
        $newVariantImageFullDataSet = array();
        $mediaDataSet = array();
        $mediaDataSetMetadata = array();
        $mediaImageFullDataSet = array();
        $productDataSet = array();
        $errorLogData = array();
        $successLogData = array();
        $newPriceValueDataSet = array();
        $drmIds = array();
        $categoryStatus = array();
        $errorCount = 0;
        $successCount = 0;


        $sessionId = $this->key.date("U");
        $currentTime = \Carbon\Carbon::now();

        foreach ($this->data as $value)
        {
            $forceValidated = false;
            $dataSet = array_combine($this->header,$value);

            $info[] = $dataSet;
            if($this->params){
                DB::table('sync_processing_data_status_v2')->where('processing_id', $this->processing_id)->where('drm_ref_id', $dataSet['drm_ref_id'])->delete();
            }
            if(isset($dataSet['drm_ref_id'])){
                $contentData = DB::table('content')->where('drm_ref_id',$dataSet['drm_ref_id'])->first();
            }

            if(isset($contentData) && !empty($contentData)){
                $url =  $contentData->url;
                $newposition = $contentData->position;

                $categories = json_decode($dataSet['categories']) ?? array_filter(explode(',', $dataSet['categories']));
                if(isset($categories) && !empty($categories)){
                    $returnBack = false;
                    $categoryData = \MicroweberPackages\Category\Models\Category::whereIn('drm_ref_id', array_values((array)$categories))->with('parent')->get()->keyBy('drm_ref_id')->toArray();
                    foreach($categories as $keyId => $category){
                        // $categoryData = \MicroweberPackages\Category\Models\Category::where('drm_ref_id', $category)->select('id','drm_ref_id','is_hidden')->with('parent')->get()->toArray();
                        if(isset($categoryData[$category]) && !empty($categoryData[$category])){
                            $arr = [];
                            $categoriees = $categoryData[$category];
                            $arr[] = $categoriees;
                            for (; ;) {
                                if (is_array($categoriees['parent'])) {
                                    $arr[] = $categoriees['parent'];
                                    $categoriees = $categoriees['parent'];
                                } else {
                                    break;
                                }
                            }
                            foreach ($arr as $ar) {
                                $categoryDataSet[$dataSet['drm_ref_id']][] = [
                                    'parent_id' => $ar['id'],
                                    'rel_type' => 'content',
                                ];
                                if($ar['is_hidden'] == 1){
                                    $categoryStatus[] = $ar['drm_ref_id'];
                                }
                            }
                        }else{
                            $errorCount++;
                            $errorLogData[] = [
                                'processing_id' => $this->processing_id,
                                'msg' => json_encode(['category' => 'category not found']),
                                'drm_ref_id' => $dataSet['drm_ref_id']
                            ];
                            $returnBack = true;
                            continue;
                        }

                    }
                    if($returnBack === true){
                        continue;
                    }

                }

                $contentDataSetIds[] = $dataSet['drm_ref_id'];
                $successCount++;

                $contentDataSet[$dataSet['drm_ref_id']] = array_merge(collect($dataSet)->only(
                    [
                        'title',
                        'drm_ref_id',
                        'content_body',
                        'description',
                        'ean',
                        'content_type',
                        'subtype',
                        'is_active',
                        'ek_price',
                        'brand',
                        'materials',
                        'production_year',
                        'gender',
                        'note',
                        'status',
                        'item_unit',
                    ]
                    )->toArray(),
                    ['url' => $url],
                    ['content_meta_keywords' => $dataSet['tags']],
                    ['position' => $newposition],
                    ['item_size' => $dataSet['size']],
                    ['item_weight' => $dataSet['weight']],
                    ['session_id' => $sessionId],
                    ['item_color' => $dataSet['color']],
                    ['parent' => $GLOBALS['shop_data'][0]['id']??2],

                );
                $main_price = $dataSet['price']+product_tax_amount($dataSet['price'],$dataSet['tax_rate']);
                if(isset($dataSet['uvp']) && $dataSet['uvp'] > $main_price) {
                    $offerDataSet[$dataSet['drm_ref_id']]= [
                        'offer_price' => $dataSet['price']??0,
                        'created_at' => $currentTime,
                        'created_by' => 1,
                        'edited_by' => 1,
                        'is_active' => 1
                    ];
                    $dataSet['price'] = $dataSet['uvp'];
                }

                $priceValueDataSet[$dataSet['drm_ref_id']] =array_merge(
                    ['value' => $dataSet['price']??0],
                    ['position' => 0]
                );
                $priceForProduct = $dataSet['price'];

                if($dataSet['price_on_request'] == 1){
                    $priceForProduct = 0;
                }
                $productDataSet[$dataSet['drm_ref_id']] = array_merge(collect($dataSet)->only(
                    [
                        'title',
                    ]
                    )->toArray(),
                    ['url' => $url],
                    ['price' => $priceForProduct],
                    ['quantity' => $dataSet['qty'] ?? 'nolimit'],
                    ['tax_type' => $dataSet['tax_type'] ?? 1],

                );

                $productDetailsDataSet[$dataSet['drm_ref_id']] =array_merge(collect($dataSet)->only(
                    [
                        'tax_type',
                        'offer_options',
                        'basic_price',
                    ]
                    )->toArray(),
                    ['suplier' => $dataSet['delivery_company_id']],
                );

                $tags = @json_decode($dataSet['tags']) ?? array_filter(explode(',', $dataSet['tags']));
                if(isset($tags) && !empty($tags)){
                    $tagData = DB::table('tagging_tags')->whereIn('name',$tags)->pluck('name')->toArray();
                    foreach($tags as $tag){
                        if(isset($tag) && $tag != ""){
                            if(!in_array($tag,$tagData)){
                                $tagsDataSet[$dataSet['drm_ref_id']][] = array_merge(['slug' => Str::slug($tag), 'name' =>$tag], ['count' => 1]);
                            }
                            $taggedDataSet[$dataSet['drm_ref_id']][] = array(
                                'taggable_type' => 'content',
                                'tag_name' => $tag,
                                'tag_slug' => Str::slug($tag)
                            );
                        }
                    }
                    if(isset($tagsDataSet[$dataSet['drm_ref_id']]) || isset($taggedDataSet[$dataSet['drm_ref_id']])){
                        $tagFullDataSet[$dataSet['drm_ref_id']] = array(
                            $tagsDataSet[$dataSet['drm_ref_id']]??[],$taggedDataSet[$dataSet['drm_ref_id']]??[]
                        );
                    }
                }


                $contentQtyDataSet[$dataSet['drm_ref_id']] =array_merge(
                    ['field_value' => $dataSet['qty'] ?? 'nolimit'],
                    [
                        'field_name' => 'qty',
                        'rel_type' => 'content',
                    ]
                );

                $contentSkuDataSet[$dataSet['drm_ref_id']] =array_merge(
                    ['field_value' => $dataSet['qty'] ?? 'nolimit'],
                    [
                        'field_name' => 'sku',
                        'rel_type' => 'content',
                    ]
                );

                $contentPriceDataSet[$dataSet['drm_ref_id']] =array_merge(
                    [
                        'rel_type' => 'content',
                        'type' => 'price',
                    ],
                    ['name' => 'price', 'name_key' => 'price', 'is_active' => 1]
                );

                $images = json_decode($dataSet['images']) ?? array_filter(explode(',', $dataSet['images']));
                if(isset($images) && !empty($images)){
                    foreach ($images as $key => $image) {

                        $mediaDataSet[$dataSet['drm_ref_id']][] = [
                            'rel_type' => 'content',
                            'media_type' => 'picture',
                            'filename' => $image,
                            'image_id' => $dataSet['drm_ref_id']
                        ];
                        if(!isset($productDataSet[$dataSet['drm_ref_id']]['image']) && empty($productDataSet[$dataSet['drm_ref_id']]['image'])){
                            $productDataSet[$dataSet['drm_ref_id']] = array_merge($productDataSet[$dataSet['drm_ref_id']],
                                [
                                    'image' => $image
                                ]
                            );

                        }

                    }
                }

                $variants = json_decode($dataSet['variants']) ?? array_filter(explode(',', $dataSet['variants']));

                if(isset($variants) && !empty($variants)){
                    foreach ($variants as $variant){

                        // $variant = collect($variant);
                        // dd($variant);
                        DB::table('variants')->where('drm_ref_id',$variant->drm_ref_id)->delete();

                        $variantDataSet[$dataSet['drm_ref_id']][] = [
                            'title' => $variant->title,
                            'price' => $variant->price ?? 0,
                            'uvp' => $variant->uvp ?? 0,
                            'ean' => $variant->ean,
                            'sku' => $variant->sku,
                            'color' => $variant->color,
                            'size' => $variant->size,
                            'materials' => $variant->materials,
                            'drm_ref_id' => $variant->drm_ref_id,
                            'description' => $variant->description,
                            'stock' => $variant->qty,

                        ];

                        if (!empty($variant->images) && is_array($variant->images)) {
                            foreach ($variant->images as $image) {
                                $variantImageDataSet[$dataSet['drm_ref_id']][] = [
                                    'rel_type' => 'content',
                                    'media_type' => 'picture',
                                    'filename' => $image,
                                    'image_id' => $variant->drm_ref_id
                                ];
                            }
                        }

                    }
                }
                $successLogData[$dataSet['drm_ref_id']] = [
                    'processing_id' => $this->processing_id,
                    'msg' => json_encode(collect($dataSet)->only(['title',
                        'drm_ref_id',
                        'ean',
                        'content_type',
                        'subtype',
                        'is_active',
                        'ek_price'])->toArray()),
                    'drm_ref_id' => $dataSet['drm_ref_id'],
                    'is_success' => 1
                ];

                DB::table('content')->where('id',$contentData->id)->update($contentDataSet[$dataSet['drm_ref_id']]);

            }

        }
        if(isset($errorLogData) && !empty($errorLogData)){
            DB::table('sync_processing_data_status_v2')->insert($errorLogData);
        }
        if(isset($contentDataSet) && !empty($contentDataSet)){

            $productDetails = DB::table('content')->select('id','drm_ref_id','url')->where('session_id',$sessionId)->get();

            $productIds = $productDetails->pluck('id')->toArray();

            $dt_shop_ids = $productIds;
            DB::table('offers')->whereIn('product_id', $dt_shop_ids)->delete();
            DB::table('bundle_products')->whereIn('product_id', $dt_shop_ids)->delete();
            DB::table('categories_items')->whereIn('rel_id', $dt_shop_ids)->delete();
            DB::table('tagging_tagged')->whereIn('taggable_id', $dt_shop_ids)->delete();
            DB::table('product_upselling_item')->whereIn('product_id', $dt_shop_ids)->delete();
            DB::table('product_details')->whereIn('rel_id', $dt_shop_ids)->delete();
            DB::table('products')->whereIn('content_id', $dt_shop_ids)->delete();
            DB::table('media')->whereIn('rel_id', $dt_shop_ids)->where('rel_type', 'content')->delete();
            DB::table('content_data')->whereIn('rel_id', $dt_shop_ids)->where('rel_type', 'content')->delete();
            $custom_value_id = DB::table('custom_fields')->whereIn('rel_id', $dt_shop_ids)->where('rel_type', 'content')->pluck('id')->toArray();
            if(isset($custom_value_id) and !empty($custom_value_id)){
                DB::table('custom_fields')->whereIn('id', $custom_value_id)->delete();
                DB::table('custom_fields_values')->whereIn('custom_field_id', $custom_value_id)->delete();
            }

            $this->executeQuery($productIds,$productDetails,$productDetailsDataSet,$contentQtyDataSet,$contentSkuDataSet,$contentPriceDataSet,$priceValueDataSet,$tagFullDataSet,$categoryDataSet,$categoryFullDataSet,$offerDataSet,$offerNewDataSet,$variantDataSet,$variantImageDataSet,$newVariantFullDataSet,$newVariantImageFullDataSet,$mediaDataSet,$mediaImageFullDataSet,$productDataSet,$errorLogData,$successLogData,$newPriceValueDataSet,$drmIds,$categoryStatus);
            $optimize_data = DB::table('image_optimize')->whereIn('status',[1,2,3])->select('compress','minimum_size','thumbnail_width', 'status')->orderBy('status', 'ASC')->get()->keyBy('status')->toArray();

            DB::table('media')
            ->select('rel_id','filename','image_id')
            ->where('rel_type','content')
            ->whereNull('resize_image')
            ->whereNotNull('image_id')
            ->whereNull('webp_image')
            ->whereIn('rel_id',$productIds)
            ->orderBy('rel_id')
            ->chunk(50, function ($medias) use($optimize_data) {
               \App\Jobs\ImageCompressJob::dispatch($medias,$optimize_data,$this->url)->onQueue("low");
            });
        }
        if($successCount != 0) DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->where('id', $this->processing_id)->increment('success_count', $successCount);
        if($errorCount != 0) DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->where('id', $this->processing_id)->increment('error_count', $errorCount);
        if(($this->key+1) == $this->count){
            if($this->params){
                DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->where('id', $this->processing_id)->decrement('error_count', $successCount);
            }else{
                $total_count = DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->select('count', 'success_count', 'error_count')->orderBy('id', 'DESC')->first();
                if(isset($total_count) and $total_count->count == ($total_count->success_count + $total_count->error_count)){
                    DB::table('product_sync_history_v2')->where('sync_id', $this->syncedId)->update(['status' => "success"]);
                    DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->update(['sync_status' => "success"]);
                } else{
                    DB::table('product_sync_history_v2')->where('sync_id', $this->syncedId)->update(['status' => "failed"]);
                    DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->update(['sync_status' => "failed"]);
                }
            }
        }
    }


    public function executeQuery($productIds,$productDetails,$productDetailsDataSet,$contentQtyDataSet,$contentSkuDataSet,$contentPriceDataSet,$priceValueDataSet,$tagFullDataSet,$categoryDataSet,$categoryFullDataSet,$offerDataSet,$offerNewDataSet,$variantDataSet,$variantImageDataSet,$newVariantFullDataSet,$newVariantImageFullDataSet,$mediaDataSet,$mediaImageFullDataSet,$productDataSet,$errorLogData,$successLogData,$newPriceValueDataSet,$drmIds,$categoryStatus){
        try{
            foreach($productDetails as $ids){
                $pId = $ids->id;
                $drmIds[] = $ids->drm_ref_id;
                if(isset($mediaDataSet[$ids->drm_ref_id])){
                    $mediaImages = $mediaDataSet[$ids->drm_ref_id];
                    foreach($mediaImages as $newMediImages){

                        $mediaImageFullDataSet[] = array_merge($newMediImages,['rel_id' => $pId]);

                    }
                }

                if(isset($productDetailsDataSet[$ids->drm_ref_id])){
                    $productDetailsDataSet[$ids->drm_ref_id] = array_merge($productDetailsDataSet[$ids->drm_ref_id],['rel_id' => $ids->id]);
                }
                if(isset($tagFullDataSet[$ids->drm_ref_id])){
                    $setNewTags = $tagFullDataSet[$ids->drm_ref_id][1];
                    $setNewTags = collect($setNewTags)->map(function($item) use ($pId){
                        $item['taggable_id'] = $pId;
                        return $item;
                    })->toArray();
                    $tagFullDataSet[$ids->drm_ref_id][1] = $setNewTags;
                    $taggingTags = array_merge($taggingTags??[],$tagFullDataSet[$ids->drm_ref_id][0]);
                    $taggingTagged = array_merge($taggingTagged??[],$tagFullDataSet[$ids->drm_ref_id][1]);

                }

                if(isset($categoryDataSet[$ids->drm_ref_id])){
                    $setNewCategory = $categoryDataSet[$ids->drm_ref_id];
                    foreach($setNewCategory as $newCat){

                        $categoryFullDataSet[] = array_merge($newCat,['rel_id' => $pId]);

                    }
                }

                if(isset($variantDataSet[$ids->drm_ref_id])){
                    $variants = $variantDataSet[$ids->drm_ref_id];
                    foreach($variants as $newVariant){

                        $newVariantFullDataSet[] = array_merge($newVariant,['rel_id' => $pId]);

                    }
                }

                if(isset($variantImageDataSet[$ids->drm_ref_id])){
                    $variantsImages = $variantImageDataSet[$ids->drm_ref_id];
                    foreach($variantsImages as $newVariantImages){

                        $newVariantImageFullDataSet[] = array_merge($newVariantImages,['rel_id' => $pId]);

                    }
                }

                if(isset($offerDataSet[$ids->drm_ref_id])){
                    $offerDataSet[$ids->id] = array_merge($offerDataSet[$ids->drm_ref_id],['product_id' => $ids->id]);
                }

                if(isset($productDataSet[$ids->drm_ref_id])){
                    $productDataSet[$ids->drm_ref_id] = array_merge($productDataSet[$ids->drm_ref_id],['content_id' => $ids->id]);
                }

                if(isset($contentQtyDataSet[$ids->drm_ref_id])){
                    $contentQtyDataSet[$ids->drm_ref_id] = array_merge($contentQtyDataSet[$ids->drm_ref_id],['content_id' => $ids->id,'rel_id' => $ids->id]);
                }

                if(isset($contentSkuDataSet[$ids->drm_ref_id])){
                    $contentSkuDataSet[$ids->drm_ref_id] = array_merge($contentSkuDataSet[$ids->drm_ref_id],['content_id' => $ids->id,'rel_id' => $ids->id]);
                }

                if(isset($contentPriceDataSet[$ids->drm_ref_id])){
                    $contentPriceDataSet[$ids->drm_ref_id] = array_merge($contentPriceDataSet[$ids->drm_ref_id],['rel_id' => $ids->id]);
                }

                if(isset($priceValueDataSet[$ids->drm_ref_id])){
                    $newPriceValueDataSet[$ids->id] = $priceValueDataSet[$ids->drm_ref_id];
                }

                if(isset($successLogData[$ids->drm_ref_id])){
                    $successLogData[$ids->drm_ref_id] = array_merge($successLogData[$ids->drm_ref_id],['content_id' => $ids->id]);
                }


            }
            if(isset($mediaImageFullDataSet) && isset($mediaImageFullDataSet)){
                DB::table('media')->insert($mediaImageFullDataSet);
            }
            DB::table('product_details')->insert($productDetailsDataSet);
            if(isset($taggingTags)){
                DB::table('tagging_tags')->insert($taggingTags);
            }
            if(isset($taggingTagged)){
                DB::table('tagging_tagged')->insert($taggingTagged);
            }
            DB::table('content_data')->insert($contentQtyDataSet);
            DB::table('content_data')->insert($contentSkuDataSet);
            DB::table('custom_fields')->insert($contentPriceDataSet);
            $customFields = DB::table('custom_fields')->select('id','rel_id')->whereIn('rel_id',$productIds)->get();
            foreach($customFields as $ids){
                if(isset($newPriceValueDataSet[$ids->rel_id])){
                    $newPriceValueDataSet[$ids->rel_id] = array_merge($newPriceValueDataSet[$ids->rel_id],['custom_field_id' => $ids->id]);
                    if(isset($offerDataSet[$ids->rel_id])){
                        $offerNewDataSet[] = array_merge($offerDataSet[$ids->rel_id],['price_id' => $ids->id]);
                    }
                }
            }
            DB::table('custom_fields_values')->insert($newPriceValueDataSet);
            DB::table('categories_items')->insert(array_values($categoryFullDataSet));
            if(isset($categoryStatus) && !empty($categoryStatus)){
                DB::table('categories')->whereIn('drm_ref_id', array_unique($categoryStatus))->update(['is_hidden' => 0]);
            }
            if(isset($offerDataSet) && !empty($offerDataSet)){
                DB::table("offers")->insert($offerNewDataSet);
            }
            if(isset($newVariantFullDataSet) && !empty($newVariantFullDataSet)){
                DB::table('variants')->insert($newVariantFullDataSet);
            }
            if(isset($newVariantImageFullDataSet) && !empty($newVariantImageFullDataSet)){
                DB::table('media')->insert($newVariantImageFullDataSet);
            }
            if(isset($productDataSet) && !empty($productDataSet)){
                DB::table('products')->insert($productDataSet);
            }
            // products_transfer_from_content();
            if(isset($successLogData) && !empty($successLogData)){
                DB::table('sync_processing_data_status_v2')->insert($successLogData);
            }

            //curl init
            if(!empty($drmIds)){
                $drmIdsStr = json_encode($drmIds);
                $user_token = Config('microweber.userToken');
                $pass_token = Config('microweber.userPassToken');
                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://159.65.124.158/api/dt-channel-products/status/update',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('ids' => $drmIdsStr,'type' => 'INSERT'),
                CURLOPT_HTTPHEADER => array(
                    'userPassToken: '.$pass_token,
                    'userToken: '.$user_token
                ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);

                \App\Jobs\MetadataUpdate::dispatch($productDetails)->onQueue("low");
            }



        }catch(Exception $e){
            deleteAllContentDetails($productIds , true);
            echo($e->getLine());
        }
    }


    public function statusUpdate($successCount,$errorCount){
        if($successCount != 0) DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->where('id', $this->processing_id)->increment('success_count', $successCount);
        if($errorCount != 0) DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->where('id', $this->processing_id)->increment('error_count', $errorCount);
        if(($this->key+1) == $this->count){
            if($this->params){
                DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->where('id', $this->processing_id)->decrement('error_count', $successCount);
            }else{
                $total_count = DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->select('count', 'success_count', 'error_count')->orderBy('id', 'DESC')->first();
                if(isset($total_count) and $total_count->count == ($total_count->success_count + $total_count->error_count)){
                    DB::table('product_sync_history_v2')->where('sync_id', $this->syncedId)->update(['status' => "success"]);
                    DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->update(['sync_status' => "success"]);
                } else{
                    DB::table('product_sync_history_v2')->where('sync_id', $this->syncedId)->update(['status' => "failed"]);
                    DB::table('sync_processing_history_v2')->where('sync_id', $this->syncedId)->update(['sync_status' => "failed"]);
                }
            }

            $optimize_data = DB::table('image_optimize')->whereIn('status',[1,2,3])->select('compress','minimum_size','thumbnail_width', 'status')->orderBy('status', 'ASC')->get()->keyBy('status')->toArray();

            DB::table('media')
            ->select('rel_id','filename','image_id')
            ->where('rel_type','content')
            ->whereNull('resize_image')
            ->whereNotNull('image_id')
            ->whereNull('webp_image')
            ->orderBy('rel_id')
            ->chunk(50, function ($medias) use($optimize_data) {
                \App\Jobs\ImageCompressJob::dispatch($medias,$optimize_data,$this->url)->onQueue("low");
            });
        }
    }

    public function get(){
        return $this->data;
    }

    public function getContentDataSet($url,$newposition){
        $contentDataSet = array_merge(collect($this->dataSet)->only(
            [
                'title',
                'drm_ref_id',
                'content_body',
                'description',
                'ean',
                'content_type',
                'subtype',
                'is_active',
                'ek_price',
                'brand',
                'materials',
                'production_year',
                'gender',
                'note',
                'status',
            ]
            )->toArray(),
            ['url' => $url],
            ['content_meta_keywords' => @$this->dataSet['tags']],
            ['position' => $newposition],
            ['item_size' => $this->dataSet['size']],
            ['item_weight' => $this->dataSet['weight']],
            ['item_color' => $this->dataSet['color']],
        );
        return $contentDataSet;
    }

    public function getProductDetailsDataSet(){
        $contentDataSet = array_merge(collect($this->dataSet)->only(
            [
                'tax_type',
                'offer_options',
                'basic_price',
            ]
            )->toArray(),
            ['suplier' => $this->dataSet['delivery_company_id']],
            );
        return $contentDataSet;
    }

    public function getContentQtyDataSet(){
        $contentDataSet = array_merge(
            ['field_value' => $this->dataSet['qty'] ?? 'nolimit'],
            [
                'field_name' => 'qty',
                'rel_type' => 'content',
            ]
        );
        return $contentDataSet;
    }

    public function getContentSkuDataSet(){
        $contentDataSet = array_merge(
            ['field_value' => $this->dataSet['sku'] ?? 'nolimit'],
            [
                'field_name' => 'sku',
                'rel_type' => 'content',
            ]
        );
        return $contentDataSet;
    }

    public function getContentPriceDataSet(){
        $contentDataSet = array_merge(
            [
                'rel_type' => 'content',
                'type' => 'price',
            ],
            ['name' => 'price', 'name_key' => 'price', 'is_active' => 1]
        );
        return $contentDataSet;
    }

    public function getPriceValueDataSet(){
        $contentDataSet = array_merge(
                    ['value' => @$this->dataSet['price']??0, 'position' => 0],
                    []
                );
        return $contentDataSet;
    }
}
