<?php
/**
 * Created by PhpStorm.
 * User: Bojidar
 * Date: 8/19/2020
 * Time: 4:09 PM
 */

namespace App\Http\Controllers;

use App\Enums\SyncEvent;
use App\Enums\SyncType;
use App\Models\Category;
use App\Models\CategoryItem;
use App\Models\SyncHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use MicroweberPackages\Product\Http\Requests\ProductRequest;
use MicroweberPackages\Product\Http\Requests\ProductCreateRequest;
use MicroweberPackages\Product\Http\Requests\ProductUpdateRequest;
use MicroweberPackages\Product\Repositories\ProductRepository;
use \Intervention\Image\ImageManagerStatic as Image;


class ProductController
{

    public $product;

    public function __construct(ProductRepository $product)
    {
        $this->product = $product;
    }


    public function index(Request $request)
    {
        return (new JsonResource(
            $this->product
                ->filter($request->all())
                ->paginate($request->get('limit', 30))
                ->appends($request->except('page'))

        ))->response();

    }

    /**
     * Store product in database
     *
     * @param ProductCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $cates = explode(',',$_REQUEST['category_ids']);
        $arr = [];
        foreach ($cates as $cat){
            if(!empty($cat)){
                $category = \MicroweberPackages\Category\Models\Category::where('id', $cat)->with('parent')->get()->toArray()[0];
                $arr[] = $category;
                for (; ;) {
                    if (is_array($category['parent'])) {
                        $arr[] = $category['parent'];
                        $category = $category['parent'];
                    } else {
                        break;
                    }
                }
            }
        }
        // if(isset($request->tag_names) && !empty($request->tag_names)){
        // }

        $data = $request->toArray();
        $data['position'] = explode(',',$data['position'])[1]+1;

        $result = $this->product->create($data);
        $all_images = DB::table('media')->where('media_type','picture')->where('rel_id',$result['id'])->get();
        $optimize_data = DB::table('image_optimize')->whereIn('status',[1,2,3])->select('compress','minimum_size','thumbnail_width', 'status')->orderBy('status', 'ASC')->get()->keyBy('status')->toArray();
        $compress_size   = $optimize_data[1]->compress ?? 0;
        $minimum_size    = $optimize_data[2]->minimum_size ?? 0;
        $thumbnail_width = $optimize_data[3]->thumbnail_width ?? 0;
        if(isset($all_images) && !empty($all_images)){
            foreach($all_images as $key => $all_image){
                try{
                    $result->key = $key;
                    $image_path = $all_image->filename;
                    $contains = str_contains($image_path, '{SITE_URL}');
                    if($contains == true){
                        $image_path = explode("{SITE_URL}",$image_path);
                        $image_path = $image_path[1];
                        $image_path = url('/').'/'.$image_path;
                    }
                    if(isset($thumbnail_width) && !empty($thumbnail_width)){
                        $thumbnail_width = $thumbnail_width;
                    }else{
                        $thumbnail_width = Image::make($image_path)->width();
                    }

                    // get image size
                    $ch = curl_init($image_path);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_HEADER, TRUE);
                    curl_setopt($ch, CURLOPT_NOBODY, TRUE);
                    $msr = curl_exec($ch);
                    $file_byte_size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
                    $file_kb_size = round($file_byte_size / 1024,4);

                    $img_resize = exixting_image_compressed($image_path,$compress_size,$thumbnail_width,$minimum_size,$file_kb_size,$result);

                    $resize_image = '{SITE_URL}userfiles/media/default/thumbnails/'.$img_resize['only_image_name'].'.webp';
                    $webp_image   = '{SITE_URL}userfiles/media/default/'.$img_resize['only_image_name'].'.webp';
                    $activate_compressor = get_option('img_compressor' , 'compressor');
                    if(@$activate_compressor == 1 && $activate_compressor != false){
                        if(!empty($minimum_size) && $minimum_size < $file_kb_size){
                            DB::table('media')->where('id',$all_image->id)->update([
                                'resize_image'=>$resize_image,
                                'webp_image'=>$webp_image,
                            ]);
                        }
                    }else{
                        DB::table('media')->where('id',$all_image->id)->update([
                            'webp_image'=>$webp_image,
                        ]);
                    }
                }catch (\Exception $e){
                    continue;
                }
            }
        }


        foreach ($arr as $ar) {

            DB::table('categories')->where('id' , $ar['id'])
                ->update(['is_hidden' => 0]);
            DB::table('categories_items')->updateOrInsert([
                'parent_id' => $ar['id'],
                'rel_type' => 'product',
                'rel_id' => $result->id,
            ]);
        }

        $tag_names = explode(',',$_REQUEST['tag_names']);
        if(isset($tag_names)){
            foreach($tag_names as $tag_name){

                $bundle = DB::table('bundles')->where('tag_name',$tag_name)->first();
                if($bundle){
                    DB::table('bundle_products')->insert([
                        'product_id' => $request['id'], 'product_qty' => 1, 'bundle_id' => $bundle->id
                    ]);
                }
            }
        }

        if ($request->content_type == 'product') {
            SyncHistory::create([
                'sync_type' => SyncType::PRODUCT,
                'sync_event' => SyncEvent::CREATE,
                'model_id' => $result->id
            ]);
            DB::table('product_details')
                ->where('rel_id', 0)
                ->update(['rel_id' => $result->id]);
        }

        // product Brand,upadate,Delivery-time insert time update
        //product upselling add in new product
        if ($request->content_type == 'product') {
            $all_upselling_item = db_get('table=product_upselling');
            if(isset($all_upselling_item) && $all_upselling_item !== false){
                foreach($all_upselling_item as $upselling_item){
                    if($request['upselling'.$upselling_item['id']]){
                        $select_item = array(
                            'product_id' => $result['id'],
                            'item_id' => $upselling_item['id']
                        );
                        db_save('product_upselling_item', $select_item);
                    }
                }
            }
        }

        //thank you page add in new product
        if ($request->content_type == 'product') {
            for($x = 1; $x <= 6; $x++){
                if($request['theme'.$x]){
                    $select_item = array(
                        'template_name' => $x,
                        'product_id' => $result['id']
                    );
                    db_save('thank_you_pages', $select_item);
                }
            }
        }

        //checkout bumbs add in new product
        if($request->content_type == 'product'){
            $select_bumbs = $request['checkBumbs'];
            if($request['bumbs'] == 'cartbumbs'){
                $cartbumbs = 1;
                $checkoutbumbs = 0;
            }else if($request['bumbs'] == 'checkoutbumbs'){
                $cartbumbs = 0;
                $checkoutbumbs = 1;
            }
            if($select_bumbs){
                if(db_get('table=checkout_bumbs&single=true')){
                    DB::table('checkout_bumbs')->update(['product_id' => $result['id'],'show_cart' => $cartbumbs,'show_checkout' => $checkoutbumbs]);
                }else{
                    db_save('checkout_bumbs',array('product_id' => $result['id'],'show_cart' => $cartbumbs, 'show_checkout' => $checkoutbumbs));
                }
            }else if($request['bumbs']){
                DB::table('checkout_bumbs')->update(['show_cart' => $cartbumbs,'show_checkout' => $checkoutbumbs]);
            }
        }

        // products_transfer_from_content();
        // cat_reset_logic();
        // cat_product_hide();

        return (new JsonResource($result))->response();
    }

    /**
     * Display the specified resource.show
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = $this->product->show($id);

        return (new JsonResource($result))->response();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  ProductRequest $request
     * @param  string $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $product)
    {
        // if(isset($request->tag_names) && !empty($request->tag_names)){
        //     $request->content_meta_keywords = $request->tag_names;
        // }
        $cates = explode(',',$_REQUEST['category_ids']);

        DB::table('categories_items')->where(['rel_type' => 'product', 'rel_id' => $_REQUEST['id']])->delete();

        $arr = [];
        foreach ($cates as $cat){
            if(!empty($cat)){
                $category = \MicroweberPackages\Category\Models\Category::where('id', $cat)->with('parent')->get()->toArray()[0];
                $arr[] = $category;
                for (; ;) {
                    if (is_array($category['parent'])) {
                        $arr[] = $category['parent'];
                        $category = $category['parent'];
                    } else {
                        break;
                    }
                }
            }
        }

        foreach ($arr as $ar) {
            DB::table('categories')->where('id' , $ar['id'])
                ->update(['is_hidden' => 0]);
            DB::table('categories_items')->insert([
                'parent_id' => $ar['id'],
                'rel_type' => 'content',
                'rel_id' => $product,
            ]);
        }

        if(isset($request->content_body) && isset($_REQUEST['content_body']) && $request->content_body != $_REQUEST['content_body'] ){
            $newContent = array('content_body'=>change_content_value($_REQUEST['content_body']));
            $request->merge($newContent);
        }

        $tag_names = explode(',',$_REQUEST['tag_names']);
        if(isset($tag_names)){
            foreach($tag_names as $tag_name){

                $bundle = DB::table('bundles')->where('tag_name',$tag_name)->first();
                if($bundle){
                    DB::table('bundle_products')->updateOrInsert(
                        ['product_id' => $request['id'], 'product_qty' => 1, 'bundle_id' => $bundle->id],
                        ['product_id' => $request['id'], 'bundle_id' => $bundle->id]
                    );
                }
            }
        }

        $bundle_tag = DB::table('bundles')->whereNotNull('tag_name')->pluck('tag_name')->toArray();
        $bundle_tag = array_diff($bundle_tag, $tag_names);
        if(!empty($bundle_tag)){
            foreach($bundle_tag as $single_tag){
                $bundle_id = DB::table('bundles')->where('tag_name', $single_tag)->value('id');
                if(isset($bundle_id)){
                    DB::table('bundle_products')->where('bundle_id', $bundle_id)->where('product_id', $_REQUEST['id'])->delete();
                }
            }
        }
        DB::table('variants')->where('rel_id',$request['id'])->update([
            'size'=> $request['size']
        ]);

        $result = $this->product->update($request->all(), $product);

        $newCats = $cates;
        $oldCats = explode(',',$_REQUEST['old_categories']);
        $refreshCats = array_values(array_diff($oldCats,$newCats));
        if(isset($refreshCats) && !empty($refreshCats))
        cat_reset_v2($refreshCats);


        // cat_reset_logic();
        // cat_product_hide();

        return (new JsonResource($result))->response();
    }

    /**
     * Destroy resources by given ids.
     *
     * @param string $ids
     * @return void
     */
    public function delete($id)
    {
        $product = $this->product->show($id);
        $data = $this->product->delete($id);
        DB::table('categories_items')->where('rel_id',$id)->delete();
        DB::table('product_details')->where('rel_id',$id)->delete();
//        if (env('SYNC_ENABLE') && $product->content_type = 'product') {
        if ($product->content_type = 'product') {
            SyncHistory::create([
                'sync_type' => SyncType::PRODUCT,
                'sync_event' => SyncEvent::DELETE,
                'model_id' => $product->id,
                'drm_ref_id'=> $product->drm_ref_id,
            ]);
        }

        return $data;
    }

    /**
     * Delete resources by given ids.
     *
     * @param string $ids
     * @return void
     */
    public function destroy($ids)
    {
        foreach ($ids as $id) {
            $product = $this->product->show($id);
            DB::table('categories_items')->where('rel_id',$id)->delete();
//            if (env('SYNC_ENABLE') && $product->content_type = 'product') {
            if ($product->content_type = 'product') {
                SyncHistory::create([
                    'sync_type' => SyncType::PRODUCT,
                    'sync_event' => SyncEvent::DELETE,
                    'model_id' => $product->id,
                    'drm_ref_id'=> $product->drm_ref_id,
                ]);
            }
        }

        return $this->product->destroy($ids);
    }
}
