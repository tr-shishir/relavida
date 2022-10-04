<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use App\Models\CategoryItem;
use App\Models\Content;
use App\Models\ContentData;
use App\Models\CustomField;
use App\Models\CustomFieldValue;
use App\Models\Media;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Product\ProductService;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use MicroweberPackages\Offer\Models\Offer;
use \Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    private $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {

        $data = $this->service->all($request->all())->toArray();

        return response()->json($data);
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {
        $data = $this->service->getById($id);

        return response()->json($data);
    }

    public function store(Request $request)
    {

        try {
            $position = @Content::orderBy('position', 'desc')->first() ?? 0;
            $newposition = $position->position+1;
            $product = $this->service->store(array_merge(
                    $request->only([
                        'title',
                        'drm_ref_id',
                        'content_body',
                        'description',
                        'ean',
                        'content_type',
                        'subtype',
                        'is_active',
                        'ek_price',
                    ]),
                    ['url' => mw()->url_manager->slug($request->get('title')).'-'.rand()],
                    ['description' => $request->get('description')],
                    ['content_meta_keywords' => @$request->tags],
                    ['position' => $newposition]
                )
            );
            $this->updateContentData($request, $product);

            app()->log_manager->save('is_system=y');
            update_product_table($product->id);
            return response()->json($product);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function update($id, Request $request)
    {
        $contentCheck = Content::where('drm_ref_id' , $id)->first();
        $check = DB::table('variants')->where('drm_ref_id',$id)->first();
        if($check && !$contentCheck){
            try{
                $variant_update = DB::table('variants')->where('drm_ref_id',$id)->update([
                    'title' => $request->title,
                    'price' => @$request->price ?? 0,
                    'uvp' => $request->uvp,
                    'ean' => $request->ean,
                    'sku' => $request->sku,
                    'color' => $request->color,
                    'size' => $request->size,
                    'materials' => $request->materials,
                    'stock' => $request->qty,

                ]);
                return response()->json($variant_update);
            }catch (\Exception $e){
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
        }else{
            if(isset($contentCheck->url)){
                $url = $contentCheck->url;
            }else{
                $url = mw()->url_manager->slug($request->get('title')).'-'.rand();
            }
            try {
                $data = $this->service->update($id, array_merge(
                        $request->only([
                            'title',
                            'drm_ref_id',
                            'content_body',
                            'description',
                            'ean',
                            'content_type',
                            'subtype',
                            'parent',
                            'is_active',
                            'ek_price',
                        ]),
                        ['description' => $request->get('description')],
                        ['url' => $url]
        //                    ['url' => mw()->url_manager->slug($request->get('url'))]
                    )
                );
                DB::table('variants')->where('drm_ref_id',$id)->update([
                    'title' => $request->title,
                    'price' => @$request->price ?? 0,
                    'uvp' => $request->uvp,
                    'ean' => $request->ean,
                    'sku' => $request->sku,
                    'color' => $request->color,
                    'size' => $request->size,
                    'materials' => $request->materials,
                    'stock' => $request->qty,

                ]);

                $this->updateContentData($request, $data);

                app()->log_manager->save('is_system=y');
                update_product_table($data->id);
                return response()->json($data);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
            }
        }


    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
            $product_id_get = DB::table('content')->where('drm_ref_id',$id)->first();
            if($product_id_get){
                DB::table('categories_items')->where('rel_id',$product_id_get->id)->delete();
            }
            $this->service->destroy($id);
            cat_reset_logic();

            app()->log_manager->save('is_system=y');
            return response()->json(['success' => true, 'message' => 'Product deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    public function updateContentData($request, $product)
    {

        DB::table('content')->where('id',$product->id)->update([

            'brand' => @$request->brand,
            'delivery_days' => @$request->handling_time['min'],
            'item_size' => @$request->size,
            'item_weight' => @$request->weight,
            'item_color' => @$request->color,
            'materials' => @$request->materials,
            'production_year' => @$request->production_year,
            'gender' => @$request->gender,
            'note' => @$request->note,
            'status' => @$request->status,

        ]);
        DB::table('product_details')->updateOrInsert(
            ['rel_id' => $product->id],
            [
                'suplier' => @$request['delivery_company_id'],
                'tax_type' => @$request['tax_type'],
                'offer_options' => @$request['offer_options'],
            ]
        );
        /* Store Tags */
        $tags = array_filter(explode(',', $request->get('tags', '')));
        DB::table('tagging_tagged')->where([
            'taggable_id' => $product->id,
            'taggable_type' => 'content',
        ])->delete();
        foreach($tags as $tag){
            DB::table('tagging_tags')->updateOrInsert(['slug' => Str::slug($tag), 'name' =>$tag], ['count' => 1]);

            DB::table('tagging_tagged')->insert([
                'taggable_id' => $product->id,
                'taggable_type' => 'content',
                'tag_name' => $tag,
                'tag_slug' => Str::slug($tag)
            ]);
        }



        /* Store Qty */
        ContentData::updateOrCreate(
            [
                'field_name' => 'qty',
                'rel_type' => 'content',
                'content_id' => $product->id,
                'rel_id' => $product->id,
            ],
            ['field_value' => $request->get('qty', 'nolimit')]
        );

        /* Store SKU */
        ContentData::updateOrCreate(
            [
                'field_name' => 'sku',
                'rel_type' => 'content',
                'content_id' => $product->id,
                'rel_id' => $product->id,
            ],
            ['field_value' => $request->get('sku')]
        );

        // saving content custom fields - price
        $priceField = CustomField::updateOrCreate(
            [
                'rel_type' => 'content',
                'rel_id' => $product->id,
                'type' => 'price',
            ],
            ['name' => 'price', 'name_key' => 'price', 'is_active' => 1]
        );
        CustomFieldValue::updateOrCreate(['custom_field_id' => $priceField->id], ['value' => @$request->get('price', 0)??0, 'position' => 0]);

        // saving category
        CategoryItem::where(['rel_type' => 'content', 'rel_id' => $product->id])->delete();
        if (!empty($request->categories) && is_array($request->categories)) {
            foreach ($request->categories as $catId) {
                $category = DB::table('categories')->where('drm_ref_id', $catId)->first();
                $check_cat = CategoryItem::where(['rel_type' => 'content', 'parent_id' => $category->id])->first();
                if (!$check_cat){
                    Category::where('id' , $category->id)
                        ->update(['is_hidden' => 1]);
                }
                if ($category) {
        //                    DB::table('categories_items')->insert([
        //                        'parent_id' => $category->id,
        //                        'rel_type' => 'content',
        //                        'rel_id' => $product->id,
        //                    ]);
                    $arr = [];
                    $categoriees = \MicroweberPackages\Category\Models\Category::where('id', $category->id)->with('parent')->get()->toArray()[0];
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
                        DB::table('categories_items')->updateOrInsert([
                            'parent_id' => $ar['id'],
                            'rel_type' => 'content',
                            'rel_id' => $product->id,
                        ]);
                        Category::where('id' , $ar['id'])
                            ->update(['is_hidden' => 0]);
                    }
                }
            }
        }
        $main_price = $request->price+taxPrice($request->price,null,$product->id,null);
        if(isset($request->uvp) && $request->uvp > $main_price) {
            $getId = DB::table('custom_fields')->where('rel_id', '=', $product->id)->where('name', '=', 'price')->first();
            CustomFieldValue::where('custom_field_id' , $getId->id)->update([
                'value' => $request->uvp,
            ]);
            DB::table("offers")->insert([
                'product_id' => $product->id,
                'price_id' => $getId->id,
                'offer_price' => @$request->price??0,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'expires_at' => "0000-00-00 00:00:00",
                'created_by' => 1,
                'edited_by' => 1,
                'is_active' => 1
            ]);
        }else{
            $getId = DB::table('custom_fields')->where('rel_id', '=', $product->id)->where('name', '=', 'price')->first();
            $offer = Offer::where('product_id' , $product->id)->first();
            if(isset($offer) && !empty($offer)){
                $offer->delete();
                CustomFieldValue::where('custom_field_id' , $getId->id)->update([
                    'value' => @$request->price??0,
                ]);
            }
        }

                    /* Store Media */
                    DB::table('media')->where([
                        'rel_type' => 'content',
                        'media_type' => 'picture',
                        'rel_id' => $product->id,
                    ])->delete();
                    if (!empty($request->images) && is_array($request->images)) {
                        $optimize_data = DB::table('image_optimize')->whereIn('status',[1,2,3])->select('compress','minimum_size','thumbnail_width', 'status')->orderBy('status', 'ASC')->get()->keyBy('status')->toArray();
                        $compress_size   = $optimize_data[1]->compress ?? 0;
                        $minimum_size    = $optimize_data[2]->minimum_size ?? 0;
                        $thumbnail_width = $optimize_data[3]->thumbnail_width ?? 0;
                        try{
                            foreach ($request->images as $key => $image) {
                                if(remote_file_exists($image)){
                                    $image = str_replace('\/', '/', $image);
                                    DB::table('media')->insert([
                                        'rel_type' => 'content',
                                        'media_type' => 'picture',
                                        'rel_id' => $product->id,
                                        'filename' => $image,
                                        'image_id' => $request->drm_ref_id
                                    ]);
                                    // Start product image resize code
                                    if($thumbnail_width != null){
                                        $thumbnail_width = $thumbnail_width;
                                    }else{
                                        $thumbnail_width = Image::make($image)->width();
                                    }
                                    $main_image_path = $image;
                                    // get image size
                                    $ch = curl_init($main_image_path);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                                    curl_setopt($ch, CURLOPT_HEADER, TRUE);
                                    curl_setopt($ch, CURLOPT_NOBODY, TRUE);
                                    $msr = curl_exec($ch);
                                    $file_byte_size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
                                    $file_kb_size = round($file_byte_size / 1024,4);
                                    $product->key = $key;
                                    $resized_image = resize_image($image,$thumbnail_width,$file_kb_size,$minimum_size,$product);
                                    $webp_image = Image::make($image)->encode('webp', 90);
                                    @$webp_image->save($resized_image['webp_save_path'].$resized_image['only_image_name'].'.webp',$compress_size ? $compress_size : 100);

                                    insert_resized_image($product->id, $image,$resized_image,$thumbnail_width,$file_kb_size,$minimum_size);
                                }else{
                                    continue;
                                }

                            }
                        }catch(Exception $e){

                        }

                    }

        // saving variants
        $variants = $request->get('variants', []);



        if (!empty($variants)) {
            foreach ($variants as $variant){
                $variant = (object)$variant;

                // save serialized data in a text file

                $check = DB::table('variants')->where('drm_ref_id',$variant->drm_ref_id)->first();
                if($check){
                    DB::table('variants')->where('drm_ref_id',$variant->drm_ref_id)->update([
                        'rel_id' => $product->id,
                        'title' => $variant->title,
                        'price' => @$variant->price??0,
                        'uvp' => $variant->uvp,
                        'ean' => $variant->ean,
                        'sku' => $variant->sku,
                        'color' => $variant->color,
                        'size' => $variant->size,
                        'materials' => $variant->materials,
                        'description' => $variant->description,
                        'stock' => $variant->qty,

                    ]);
                    if (!empty($variant->images) && is_array($variant->images)) {
                        foreach ($variant->images as $image) {
                            DB::table('media')->insert([
                                'rel_type' => 'content',
                                'media_type' => 'picture',
                                'rel_id' => $product->id,
                                'filename' => $image,
                                'image_id' => $variant->drm_ref_id
                            ]);
                        }
                    }
                }else{
                    DB::table('variants')->insert([
                        'rel_id' => $product->id,
                        'title' => $variant->title,
                        'price' => @$variant->price??0,
                        'uvp' => $variant->uvp,
                        'ean' => $variant->ean,
                        'sku' => $variant->sku,
                        'color' => $variant->color,
                        'size' => $variant->size,
                        'materials' => $variant->materials,
                        'drm_ref_id' => $variant->drm_ref_id,
                        'description' => $variant->description,
                        'stock' => $variant->qty,

                    ]);

                    if (!empty($variant->images) && is_array($variant->images)) {
                        foreach ($variant->images as $image) {
                            DB::table('media')->insert([
                                'rel_type' => 'content',
                                'media_type' => 'picture',
                                'rel_id' => $product->id,
                                'filename' => $image,
                                'image_id' => $variant->drm_ref_id
                            ]);
                        }
                    }
                }
            }
        }



        //        $colors = $request->get('colors', []);
        //        if (!empty($colors)) {
        //            if(count($colors)==1){
        //                $colorField = CustomField::updateOrCreate(
        //                    [
        //                        'rel_type' => 'content',
        //                        'rel_id' => $product->id,
        //                        'type' => 'text',
        //                        'name_key' => 'color',
        //                    ],
        //                    [
        //                        'name' => 'Color',
        //                        'is_active' => 1,
        //                        'show_label' => 1,
        //                        'options' => json_encode([
        //                            'field_type' => 'text',
        //                            'field_size' => '8',
        //                        ])
        //                    ]
        //                );
        //            }else{
        //                $colorField = CustomField::updateOrCreate(
        //                    [
        //                        'rel_type' => 'content',
        //                        'rel_id' => $product->id,
        //                        'type' => 'dropdown',
        //                        'name_key' => 'color',
        //                    ],
        //                    [
        //                        'name' => 'Color',
        //                        'is_active' => 1,
        //                        'show_label' => 1,
        //                        'options' => json_encode([
        //                            'field_type' => 'dropdown',
        //                            'field_size' => '8',
        //                        ])
        //                    ]
        //                );
        //            }
        //
        //            CustomFieldValue::where('custom_field_id', $colorField->id)->delete();
        //            $count = 0;
        //            foreach($colors as $color) {
        //                CustomFieldValue::create([
        //                    'custom_field_id' => $colorField->id,
        //                    'value' => trim($color),
        //                    'position' => $count++,
        //                ]);
        //            }
        //        }
        //
        //        $sizes = $request->get('sizes', []);
        //        if (!empty($sizes)) {
        //            if(count($sizes)==1){
        //                $sizeField = CustomField::updateOrCreate(
        //                    [
        //                        'rel_type' => 'content',
        //                        'rel_id' => $product->id,
        //                        'type' => 'text',
        //                        'name_key' => 'size',
        //                    ],
        //                    [
        //                        'name' => 'Size',
        //                        'is_active' => 1,
        //                        'show_label' => 1,
        //                        'options' => json_encode([
        //                            'field_type' => 'text',
        //                            'field_size' => '8',
        //                        ])
        //                    ]
        //                );
        //            }else{
        //                $sizeField = CustomField::updateOrCreate(
        //                    [
        //                        'rel_type' => 'content',
        //                        'rel_id' => $product->id,
        //                        'type' => 'dropdown',
        //                        'name_key' => 'size',
        //                    ],
        //                    [
        //                        'name' => 'Size',
        //                        'is_active' => 1,
        //                        'show_label' => 1,
        //                        'options' => json_encode([
        //                            'field_type' => 'dropdown',
        //                            'field_size' => '8',
        //                        ])
        //                    ]
        //                );
        //            }
        //
        //            CustomFieldValue::where('custom_field_id', $sizeField->id)->delete();
        //            $count = 0;
        //            foreach($sizes as $size) {
        //                CustomFieldValue::create([
        //                    'custom_field_id' => $sizeField->id,
        //                    'value' => trim($size),
        //                    'position' => $count++,
        //                ]);
        //            }
        //        }
        //        $materials = $request->get('materials', []);
        //        if (!empty($materials)) {
        //            if(count($materials)==1){
        //                $materialField = CustomField::updateOrCreate(
        //                    [
        //                        'rel_type' => 'content',
        //                        'rel_id' => $product->id,
        //                        'type' => 'text',
        //                        'name_key' => 'material',
        //                    ],
        //                    [
        //                        'name' => 'Materials',
        //                        'is_active' => 1,
        //                        'show_label' => 1,
        //                        'options' => json_encode([
        //                            'field_type' => 'text',
        //                            'field_size' => '8',
        //                        ])
        //                    ]
        //                );
        //            }else{
        //                $materialField = CustomField::updateOrCreate(
        //                    [
        //                        'rel_type' => 'content',
        //                        'rel_id' => $product->id,
        //                        'type' => 'dropdown',
        //                        'name_key' => 'material',
        //                    ],
        //                    [
        //                        'name' => 'Materials',
        //                        'is_active' => 1,
        //                        'show_label' => 1,
        //                        'options' => json_encode([
        //                            'field_type' => 'dropdown',
        //                            'field_size' => '8',
        //                        ])
        //                    ]
        //                );
        //            }
        //
        //            CustomFieldValue::where('custom_field_id', $materialField->id)->delete();
        //            $count = 0;
        //            foreach($materials as $material) {
        //                CustomFieldValue::create([
        //                    'custom_field_id' => $materialField->id,
        //                    'value' => trim($material),
        //                    'position' => $count++,
        //                ]);
        //            }
        //        }

        //        $categories = get_categories('rel_type=content');
        //        $cat_manager = app()->category_manager;
        //        if(!empty($categories)) {
        //            foreach ($categories as $category) {
        //                $check_cat = CategoryItem::where(['rel_type' => 'content', 'parent_id' => $category['id']])->first();
        //                if (!$check_cat){
        //                    Category::where('id' , $category['id'])
        //                        ->update(['is_hidden' => 1]);
        //                }
        //
        //            }
        //
        //        }
        //
        //
        //        mw()->update->post_update();
        //        clearcache();

        //        if(isset($request->uvp) && $request->uvp>0 ) {
        //            $getId = DB::table('custom_fields')->where('rel_id', '=', $product->id)->where('name', '=', 'price')->first();
        //            DB::table("offers")->insert([
        //                'product_id' => $product->id,
        //                'price_id' => $getId->id,
        //                'offer_price' => $request->uvp,
        //                'created_at' => \Carbon\Carbon::now(),
        //                'updated_at' => \Carbon\Carbon::now(),
        //                'expires_at' => "0000-00-00 00:00:00",
        //                'created_by' => 1,
        //                'edited_by' => 1,
        //                'is_active' => 1
        //            ]);
        //        }

    }

    public function guestCheckout($id)
    {
        $product = \App\Models\Content::where('drm_ref_id', $id)->first();

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found!'], 422);
        }
        $randomString = uniqid();

        $ins_array = array(
            'products_id' => $product->id,
            'user_id' => 1,
            'slug' => $randomString,
        );

        DB::table('quick_checkout')->insert($ins_array);
        $url = site_url() . 'checkout?slug=' . $randomString;

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => ['url' => $url, 'slug' => $randomString, 'id' => $product->id]
        ]);
    }

    public function __destruct()
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
    }


    public function products_transfer(Request $request){

        $products_ids = array();

        if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
            $products = Content::with(['media', 'contentData', 'customField', 'taggingTagged', 'categoryItem',])->where('id',$_REQUEST['id'])->where('is_deleted',0)->get();
            if(isset($products) && !empty($products)){
                foreach($products as $key => $product){
                    $medias = $product->media()->where(function($q) {
                        $q->where('position', 0)
                          ->orWhere('position', NULL)
                          ->orWhere('position',9999999);
                    })->first();
                    $price = $product->customField->where('name_key', 'price')->where('type', 'price')->first();
                    if ($price) {
                        $price = $price->customFieldValue->first() ? $price->customFieldValue->first()->value : 0;
                    }else{
                        $price = 0;
                    }
                    $tax_type = DB::table('product_details')->where('rel_id',$product->id)->first();
                    $quantity = $product->contentData->where('field_name', 'qty')->first()->field_value;
                    $new_product = DB::table('products')->updateOrInsert(
                        ['content_id' => $product->id],
                        [
                            'title' => @$product->title,
                            'url' => @$product->url,
                            'image' => @$medias->webp_image ?? $medias->filename ?? '',
                            'price' => @$price,
                            // 'offer_price' => @$product->offer_price,
                            'quantity' => @$quantity,
                            'tax_type' => @$tax_type->tax_type ?? 1,
                        ]
                    );
                    $product->update([
                        'synced' => 1
                    ]);
                    $products_ids[$key] = array(
                        'content_id' => $product->id,
                    );
                }
            }
            return response()->json([
                'success' => true,
            ]);
        }else{
            $products = Content::with(['media', 'contentData', 'customField', 'taggingTagged', 'categoryItem',])->where('content_type','product')->where('synced',0)->where('is_deleted',0)->get();
            if(isset($products) && !empty($products)){
                foreach($products as $key => $product){
                    $medias = $product->media()->where(function($q) {
                        $q->where('position', 0)
                          ->orWhere('position', NULL)
                          ->orWhere('position',9999999);
                    })->first();
                    $price = $product->customField->where('name_key', 'price')->where('type', 'price')->first();
                    if ($price) {
                        $price = $price->customFieldValue->first() ? $price->customFieldValue->first()->value : 0;
                    }else{
                        $price = 0;
                    }
                    $quantity = $product->contentData->where('field_name', 'qty')->first()->field_value;
                    $tax_type = DB::table('product_details')->where('rel_id',$product->id)->first();
                    $new_product = DB::table('products')->updateOrInsert(
                        ['content_id' => $product->id],
                        [
                            'title' => @$product->title,
                            'url' => @$product->url,
                            'image' => @$medias->webp_image ?? $medias->filename ?? '',
                            'price' => @$price,
                            'content_id' => $product->id,
                            // 'offer_price' => @$product->offer_price,
                            'quantity' => @$quantity,
                            'tax_type' => @$tax_type->tax_type ?? 1,
                        ]
                    );
                    $product->update([
                        'synced' => 1
                    ]);
                    $products_ids[$key] = array(
                        'content_id' => $product->id,
                    );
                }
                return response()->json([
                    'success' => true,
                ]);
            }else{

                return response()->json([
                    'success' => true,
                ]);
            }
        }

    }



    public function products_transfer_update(Request $request){

        $products_ids = array();
            $products = Content::with(['media', 'contentData', 'customField', 'taggingTagged', 'categoryItem',])->where('content_type','product')->where('is_deleted',0)->get();
            if(isset($products) && !empty($products)){
                foreach($products as $key => $product){
                    $medias = $product->media()->where(function($q) {
                        $q->where('position', 0)
                          ->orWhere('position', NULL)
                          ->orWhere('position',9999999);
                    })->first();
                    $price = $product->customField->where('name_key', 'price')->where('type', 'price')->first();
                    if ($price) {
                        $price = $price->customFieldValue->first() ? $price->customFieldValue->first()->value : 0;
                    }else{
                        $price = 0;
                    }
                    $quantity = $product->contentData->where('field_name', 'qty')->first()->field_value;
                    $tax_type = DB::table('product_details')->where('rel_id',$product->id)->first();
                    $new_product = DB::table('products')->updateOrInsert(
                        ['content_id' => $product->id],
                        [
                            'title' => @$product->title,
                            'url' => @$product->url,
                            'image' => @$medias->webp_image ?? $medias->filename ?? '',
                            'price' => @$price,
                            'content_id' => $product->id,
                            // 'offer_price' => @$product->offer_price,
                            'quantity' => @$quantity,
                            'tax_type' => @$tax_type->tax_type ?? 1,
                        ]
                    );
                    $product->update([
                        'synced' => 1
                    ]);
                    $products_ids[$key] = array(
                        'content_id' => $product->id,
                    );
                }
                return response()->json([
                    'success' => true,
                ]);
            }else{

                return response()->json([
                    'success' => true,
                ]);
            }
        }



}
