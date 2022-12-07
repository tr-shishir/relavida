<?php

use App\Models\Order;
use App\Models\Content;
use App\Models\SyncHistory;
use Illuminate\Http\Request;
use App\Services\DrmSyncService;
use Illuminate\Support\Facades\DB;
use MicroweberPackages\Tax\TaxType;
use App\Services\Order\OrderService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Services\Product\ProductService;
use App\Services\Customer\CustomerService;
use MicroweberPackages\Category\Models\Category;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$is_installed = mw_is_installed();
if ($is_installed) {
    $user_country_name = user_country(user_id());
    if(!$user_country_name){
       $tax= mw()->tax_manager->get();
       $user_country_name = $tax['0']['name'];
    }
    $GLOBALS['all_options'] =  DB::table('options')->get()->map(function($item){
        return (array)$item;
    })->keyBy(function($item) {
        return $item['option_group'].'--'.$item['option_key'];
    })->toArray();
    $GLOBALS = array_merge($GLOBALS, array(
        'all_tax' => TaxType::all(),
        'tax' => DB::table('tax_rates')->where('country','LIKE','%'.$user_country_name.'%')->first(),
        'all_tax_rates' => DB::table('tax_rates')->get(),
        'user_country_tax' => DB::table('users')
            ->select('tax_rates.charge', 'users.country')
            ->join('tax_rates', 'tax_rates.country', '=', 'users.country')
            ->where('users.id', user_id())->first(),
        'shop_data' => get_content('is_shop=1') ?? get_content('layout_file=layouts__shop.php') ?? get_content('layout_file=index.php'),
        'blog_data' => get_content('url=blog') ?? get_content('layout_file=layouts__blog.php') ?? get_content('layout_file=index.php'),
        'custom_shop_category_header' => get_option('custom_shop_category_header','category_customization'),
        'custom_blog_category_header' => get_option('custom_blog_category_header','category_customization'),
        'custom_blog_category_header_ignore' => get_option('custom_blog_category_header_ignore','category_customization'),
        'custom_shop_category_header_ignore' => get_option('custom_shop_category_header_ignore','category_customization'),
        'custom_active_category' => get_option('custom_active_category','category_customization'),
        'custom_sidebar' => get_option('custom_sidebar','category_customization'),
        'custom_header' => get_option('custom_header','category_customization'),
        'total_product' => DB::table('content')->select('id')->where('content_type','product')->where('is_active',1)->where('is_deleted',0)->count() ?? 0,
        'total_post' => DB::table('content')->select('id')->where('content_type','post')->where('is_active',1)->where('is_deleted',0)->count() ?? 0,

    ));
    if (Schema::hasColumn('tax_rates','reduced_charge')) {
        $GLOBALS['user_country_tax'] = DB::table('users')
            ->select('tax_rates.charge', 'users.country','tax_rates.reduced_charge')
            ->join('tax_rates', 'tax_rates.country', '=', 'users.country')
            ->where('users.id', user_id())->first();
    }

}

Route::apiResource('products', 'ProductController');
Route::apiResource('categories', 'CategoryController');
Route::apiResource('orders', 'OrderController');
Route::apiResource('customer', 'CustomerController');

Route::get('drm-guest-checkout/{id}', 'ProductController@guestCheckout');

Route::get('test-order-sync-to-drm', function () {

    $syncService = new DrmSyncService("http://165.22.24.129");
    $order = Order::with('carts')->with('carts.content:id,ean,drm_ref_id')->find(93)->toArray();

    if ($order) {
        $response = $syncService->storeOrder($order);
        dd($response);
    }
});


Route::get('sync-to-drm', function () {
    $syncHistories = SyncHistory::whereNull('synced_at')
        ->where('tries', '<', 3)
        ->limit(10)
        ->get();

    $synced = [];
    foreach($syncHistories as $syncHistory) {
        switch($syncHistory->sync_type) {
            case \App\Enums\SyncType::CATEGORY:
                $updatedData = app(\App\Services\Category\CategoryService::class)->syncCategoryToDrm($syncHistory);
                if (!empty($updatedData->synced_at)) {
                    $synced[] = [
                        'dt_ref_id' => $updatedData->id,
                        'synced_at' => $updatedData->synced_at,
                    ];
                }
                break;

            case \App\Enums\SyncType::CUSTOMER:
                $updatedData = app(CustomerService::class)->syncCustomerToDrm($syncHistory);
                if (!empty($updatedData->synced_at)) {
                    $synced[] = [
                        'dt_ref_id' => $updatedData->id,
                        'synced_at' => $updatedData->synced_at,
                    ];
                }
                break;

            case \App\Enums\SyncType::PRODUCT:
                $updatedData = app(ProductService::class)->syncProductToDrm($syncHistory);
                if (!empty($updatedData->synced_at)) {
                    $synced[] = [
                        'dt_ref_id' => $updatedData->id,
                        'synced_at' => $updatedData->synced_at,
                    ];
                }
                break;

            case \App\Enums\SyncType::ORDER:
                $updatedData = app(OrderService::class)->syncOrderToDrm($syncHistory);
                if (!empty($updatedData->synced_at)) {
                    $synced[] = [
                        'dt_ref_id' => $updatedData->id,
                        'synced_at' => $updatedData->synced_at,
                    ];
                }
                break;
        }
    }

    return response()->json(['success' => true, 'message' => 'Synced successfully.', 'data' => $synced]);
});

Route::get('product/{code}', function ($code){
    $product = \App\Models\Content::where('drm_ref_id', $code)->first();

    if(!$product) {
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

    return redirect('checkout?slug=' . $randomString);
});

Route::get('validate-droptienda-shop', function (Request $request) {
    $userToken = $request->input('userToken');
    $userPassToken = $request->input('userPassToken');

    if(!empty($userToken) && $userToken == config('microweber.userToken') && !empty($userPassToken) && $userPassToken == config('microweber.userPassToken')) {
        return response()->json(['success' => true, 'message' => 'Droptienda Shop verified successfully.'], 200);
    }

    return response()->json(['success' => false, 'message' => 'Droptienda Shop verification failed.'], 401);
});

Route::post('drm_token_get',function(){
    try {

        if(isset($_REQUEST['is_register'])){
            $register = $_REQUEST['is_register'];
            $payLoad = [
                'name' => $_REQUEST['name'],
                'email'=> $_REQUEST['installUserName'],
                'password'=> $_REQUEST['installUserPass'],
                'url' => $_REQUEST['url'],
                'is_register' => $register,
                'version' => Config::get('app.adminTemplateVersion')
            ];
        }else{

            $payLoad = [
                'email'=> $_REQUEST['installUserName'],
                'password'=> $_REQUEST['installUserPass'],
                'url' => $_REQUEST['url'],
                'version' => Config::get('app.adminTemplateVersion')
            ];
        }

        // curl request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://eu-dropshipping.com/api/v1/droptienda-new-activation");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payLoad));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $server = curl_exec($ch);
        curl_close($ch);

        return response()->json(json_decode($server));
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Unable to connect to DRM']);
    }

});

Route::get('test', function() {
    return mw()->cache_manager->delete('categories');
    clearcache();
    //$query = Order::whereHas('carts')->with('carts.content:id,ean,drm_ref_id')->get()->toArray();
//    return json_encode($query);
    //dd($query);
    $syncHistory = SyncHistory::find(5);
    //app(OrderService::class)->syncOrderToDrm($syncHistory);
});

Route::post('iconImage',function (  ){

    $checkedd= DB::table('iconImage')->where('name',$_REQUEST['name'])->first();

    if(isset($checkedd)){
        $ins = DB::table('iconImage')->where('name',$_REQUEST['name'])->update([
            'iid'=>$_REQUEST['id']
        ]);
    }else{
        $ins = DB::table('iconImage')->insert([
            'name'=>$_REQUEST['name'],
            'iid'=>$_REQUEST['id']
        ]);
    }
    return response()->json(['success' => true, 'message' => 'Unable to connect to DRM']);
});


Route::get('dt_debug',function (){
//    dd('tr');

    $debug = Config::get('app.debug');
    if($debug == true){
        Config::set('app.debug',false);
        Config::save(array('app'));
    }else{
        Config::set('app.debug',true);
        Config::save(array('app'));
    }

    dd(Config::get('app.debug'));
});

Route::post('counter',function (  ){

    Config::set('custom.counter',$_REQUEST['id']);
    Config::save(array('custom'));

    return response()->json(['success' => true, 'message' => 'Unable to connect to DRM']);
});

Route::post('change_to_default',function (){
    if(Config::get('template.'.template_name()) != 0){
        DB::table('options')
            ->where('option_key', 'current_template')
            ->update(['option_value' => 'BambooBasic']);

        mw()->update->post_update();

    }
    return response()->json(['success' => true, 'message' => 'Change the template to Default']);
});

Route::post('wishlist_check',function (){
    $wishList = DB::table('wishlist_session_products')
        ->where("user_id", user_id())
        ->where("wishlist_id", $_REQUEST['id'])
        ->first();
    if (!empty($wishList)) {
        return response()->json(['success' => true]);
    }else{
        return response()->json(['success' => false]);
    }
});


Route::group(['middleware' => ['auth.ApiRequest']], function() {

    Route::post('/wishlists-products', function() {

        try {

            $userToken = Config::get('microweber.userToken');
            $userPassToken = Config::get('microweber.userPassToken');

            $wishLists['userToken'] = $userToken;
            $wishLists['userPassToken'] = $userPassToken;

            $wishLists['results'] = \App\Models\WishlistSession::with(['user:id,username,email,first_name,middle_name,last_name,phone,role','wlproducts:id,wishlist_id,product_id','wlproducts.product:id,content_type,subtype,url,title,parent,description'])->get(['id','user_id','name']);

            if (count($wishLists['results']) > 0) {
                return response()->json(['success' => true, 'message' => 'Wishlists with respective user and products', 'wishlists' => $wishLists],200);
            }else{
                return response()->json(['success' => true, 'message' => 'Empty wishlists!', 'wishlists' => $wishLists],200);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => false, 'message' => 'Ops! API returns with response error!'],500);
        }

    });


    Route::post('/cancelled-shopping-carts', function() {

        try {
            $userToken = Config::get('microweber.userToken');
            $userPassToken = Config::get('microweber.userPassToken');

            $abandoned_carts['userToken'] = $userToken;
            $abandoned_carts['userPassToken'] = $userPassToken;

            $abandoned_carts['results'] = \App\Models\Cart::with(['creator:id,username,email,first_name,middle_name,last_name,phone,role','content:id,content_type,subtype,url,title,parent,description'])->where('order_completed','0')->get(['id','title','rel_id','rel_type','price','session_id','qty','order_completed','created_by']);

            if (count($abandoned_carts['results']) > 0) {
                return response()->json(['success' => true, 'message' => 'Cancelled shopping carts with respective creator and contents', 'abandonedCarts' => $abandoned_carts],200);
            }else{
                return response()->json(['success' => true, 'message' => 'Empty Cancelled shopping cart!', 'abandonedCarts' => $abandoned_carts],200);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => false, 'message' => 'Ops! API returns with response error!'],500);
        }

    });

});


Route::get('directory',function (){

    if(isset($_GET['dir'])){
        $files1 = scandir(base_path().'/'.$_GET['dir']);
        if($files1){
            dd($files1);
        }else{
            dd(base_path());
        }
    }
});

Route::post('change_category_parent',function (){
    try {
        if($_REQUEST['new_parent_id'] == 0){
            $categories = DB::table('categories')
                ->where("id", $_REQUEST['id'])
                ->update(["parent_id" => 0 , "rel_id" => 2]);
        }else{
            $categories = DB::table('categories')
                ->where("id", $_REQUEST['id'])
                ->update(["parent_id" => $_REQUEST['new_parent_id'] , "rel_id" => 0]);
        }
        mw()->update->post_update();
        return response()->json(json_decode($categories));
    }catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Category not found']);
    }
});

// tax rate and round amount api
Route::post('tax_and_round_amount',function (){

    try {
        $userToken = Config::get('microweber.userToken');
        $userPassToken = Config::get('microweber.userPassToken');
        if($userToken == $_REQUEST['userToken'] && $userPassToken == $_REQUEST['userPassToken']){
            $tax_round_amount = [];
            $tax_round_amount['tax'] = mw()->tax_manager->get()[0];
            $tax_round_amount['rount_amount'] = Config::get('custom.round_amount') ?? 0;
            return response()->json(['success' => true, 'data' => $tax_round_amount],200);
        }
    }catch (\Exception $e) {
        return response()->json(['error' => 'Api unauthorized, Wrong userToken or userPassToken.'], 401);
    }
});


//limit change
Route::post('post_limit',function (){
    if(isset($_REQUEST['postlimit'])){
        Config::set('custom.blog_limit', $_REQUEST['postlimit']);
        Config::save(array('custom'));
    }elseif (isset($_REQUEST['poststatus'])){
        ($_REQUEST['poststatus'] == 1) ? $_REQUEST['poststatus'] = 0 : $_REQUEST['poststatus'] = 1;
        Config::set('custom.blog_status', $_REQUEST['poststatus']);
        Config::save(array('custom'));
    }

    return response()->json(['success' => true]);
});


Route::post('blog_menu',function (){
    if ($_REQUEST['blog_menu'] == 'header'){
//        Config::set('custom.header', $_REQUEST['blog_menu']);
        save_option('custom_header', $_REQUEST['blog_menu'], 'category_customization');
        save_option('custom_sidebar', 'null', 'category_customization');

//        Config::set('custom.sidebar', 'null');
//        Config::save(array('custom'));
    }elseif ($_REQUEST['blog_menu'] == 'sidebar'){
//        Config::set('custom.sidebar', $_REQUEST['blog_menu']);
        save_option('custom_header', 'null', 'category_customization');
        save_option('custom_sidebar', $_REQUEST['blog_menu'], 'category_customization');

//        Config::set('custom.header', 'null');
//        Config::save(array('custom'));
    }


    return response()->json(['success' => true]);
});

Route::post('cart_totals',function (){
    if(isset($_REQUEST['data']) && isset($_REQUEST['product'])){
        // dd($_REQUEST,$_REQUEST['taxr'] ?? taxRateCountry($_REQUEST['data'],$_REQUEST['product']));
        $taxr = $_REQUEST['taxr'] ?? taxRateCountry($_REQUEST['data'],$_REQUEST['product']);
        $cart_totals = mw()->cart_manager->totals($return = 'all',$_REQUEST['data'],$_REQUEST['product'],$taxr);
        $cart_totals['tax_rate']['amount'] = $taxr;
        $cart_totals['subtotal']['amount'] = $cart_totals['total']['amount'];
        $cart_totals['total']['amount'] = currency_format((float)$cart_totals['total']['value']-(float)@$cart_totals['shipping']['value']);
        $cart_totals['netto']['amount'] = currency_format((float)round($cart_totals['total']['value'],2)-(float)round(@$cart_totals['tax']['value']??0 , 2));

        return response()->json(['success' => true,  'cart_totals' => $cart_totals],200);
    }
});

Route::post('default_tax',function (){
    if(@$_REQUEST['value'] == 0 || @$_REQUEST['value'] == ''){
        $previous = DB::table('tax_rates')->where('is_default',1)->first();
        DB::table('tax_rates')->where('is_default',1)->update(['is_default' => 0]);
        DB::table('tax_rates')->where('id',$_REQUEST['data'])->update([ 'is_default' => 1]);
        $tax = DB::table('tax_rates')->where('id',$_REQUEST['data'])->first();
        $new_t = DB::table('tax_types')
            ->first();
        DB::table('tax_types')->where('id',$new_t->id)->update([
            'name' => $tax->country,
            'type' => 'percent',
            'rate' => $tax->charge,
        ]);

        return response()->json(['success' => true,  'previous' => $previous->id],200);
    }
});


Route::post('product_url',function (){

    try {
        $userToken = Config::get('microweber.userToken');
        $userPassToken = Config::get('microweber.userPassToken');
        if($userToken == $_REQUEST['userToken'] && $userPassToken == $_REQUEST['userPassToken']){
            $product_url = DB::table('content')->where('drm_ref_id',$_REQUEST['drm_id'])->first();
            return response()->json(['success' => true, 'data' => $product_url],200);
        }
    }catch (\Exception $e) {
        return response()->json(['error' => 'Api unauthorized, Wrong userToken or userPassToken.'], 401);
    }
});


Route::post('deleteable_page',function (){
    if(isset($_REQUEST['rel_id'])){
        $delete = Config::get('custom.deleteable') ?? [];


        if(!in_array($_REQUEST['rel_id'],$delete)){
            array_push($delete,$_REQUEST['rel_id']);
            Config::set('custom.deleteable',$delete);
            Config::save('custom');
        }
        $delete = Config::get('custom.deleteable');

        return $delete;
    }
});


Route::post('checkout_contents',function (){
    if(isset($_REQUEST['all_info'])){
        mw()->user_manager->session_set("first_name" , $_REQUEST['all_info']['first_name'] );
        mw()->user_manager->session_set("last_name", $_REQUEST['all_info']['last_name'] );
        mw()->user_manager->session_set("email", $_REQUEST['all_info']['email'] );
        mw()->user_manager->session_set("phone", $_REQUEST['all_info']['phone'] );
        mw()->user_manager->session_set("country" , $_REQUEST['all_info']['country'] );
        mw()->user_manager->session_set("zip", $_REQUEST['all_info']['zip'] );
        mw()->user_manager->session_set("city", $_REQUEST['all_info']['city'] );
        if(isset($_REQUEST['all_info']['state'])){
            mw()->user_manager->session_set("state", $_REQUEST['all_info']['state'] );
        }else{
            mw()->user_manager->session_set("state", null);
        }
        mw()->user_manager->session_set("address", $_REQUEST['all_info']['address'] );
        if(!is_logged()){
            return response()->json(['success' => true, 'data' => true],200);
        }
    }
});

Route::post('single_layout_copy', function(){
    $single_layout_copy_page_id = $_REQUEST['single_layout_copy_page_id'];
    $layout_info = array(
        'paste_position' => $_REQUEST['paste_position'],
        'single_layout_copy_page_id'  => $_REQUEST['single_layout_copy_page_id'],
        'single_layout_copy_module_id' => $_REQUEST['single_layout_copy_module_id'],
        'single_layout_copy_field_name' => $_REQUEST['single_layout_copy_field_name'],
        'single_layout_paste_page_id'  => $_REQUEST['single_layout_paste_page_id'],
        'single_layout_paste_module_id' => $_REQUEST['single_layout_paste_module_id'],
        'single_layout_paste_field_name' => $_REQUEST['single_layout_paste_field_name']
    );
    // dd($layout_info);

    $module_position = dt_clone_setModulePosition($layout_info);
    // dd($module_position);
    if(!empty($module_position['new_string'])){
        $update_position = DB::table('content_fields')->where('rel_id',$_REQUEST['single_layout_paste_page_id'])->where('field', $_REQUEST['single_layout_paste_field_name'])->update(['value' => $module_position['new_string']]);
        if($update_position){
            dt_clone_setModuleContent($module_position);
            return response()->json(["message" =>  'success' ], 200);
        }
    }
});

Route::post('clone_color_module', function(){
    $html = $_REQUEST['html'];
    $new = dtCloneClonelSingleLayoutsModules($html);
    return response()->json(["html" =>  $new ], 200);

});

Route::post('/menu-edit', function (Request $request) {
    DB::table('menus')->where('id',$request->id)->update([
        'title'=> $request->menu_title,
    ]);
    mw()->cache_manager->delete('menus');
    return back();
});

Route::post('set_single_header_cat',function (){
    if(isset($GLOBALS['custom_header']) == true){
//        \Config::set('custom.active_category' , $_REQUEST['confirm']);
        save_option('custom_active_category' , $_REQUEST['confirm'],'category_customization');
//        \Config::save('custom');
    }
    if(!isset($GLOBALS['custom_header']) || $GLOBALS['custom_header'] == NULL){
//        Config::set('custom.header' , 'header');
        save_option('custom_header' ,'header','category_customization');
        save_option('custom_active_category' ,$_REQUEST['confirm'],'category_customization');
//        Config::set('custom.active_category' , $_REQUEST['confirm']);
//        Config::save('custom');
    }
    if($_REQUEST['confirm'] != 0){
        return response()->json(['success' => true, 'data' => true],200);
    }else{
        return response()->json(['success' => false, 'data' => true],200);
    }
});

Route::post('save_page_for_cat_header' , function (){
    $shop_cat = $GLOBALS['shop_data'][0]['id'];
//    $active_head_cat = Config::get('custom.active_category') ?? $shop_cat;
    $active_head_cat = intval($GLOBALS['custom_active_category']) ?? $shop_cat;
    $cat_array = [];
    if(@$_REQUEST){
        if($shop_cat == $active_head_cat  && @$_REQUEST['shop_id']){
            $cat_array = (array)json_decode($GLOBALS['custom_shop_category_header']) ?? [];
        }else{
            $cat_array = (array)json_decode($GLOBALS['custom_blog_category_header']) ?? [];
        }
        if($active_head_cat == $shop_cat && @$_REQUEST['shop_id']){
            if(in_array($_REQUEST['shop_id'],$cat_array) == false){
                array_push($cat_array,$_REQUEST['shop_id']);
//                Config::set('custom.shop_category_header',$cat_array);
                save_option('custom_shop_category_header',json_encode($cat_array),'category_customization');

            }
        }else{
            if(isset($_REQUEST['blog_id'])){
                if(in_array(@$_REQUEST['blog_id'],$cat_array) == false){
                    array_push($cat_array,@$_REQUEST['blog_id']);
//                    Config::set('custom.blog_category_header',$cat_array);
                    save_option('custom_blog_category_header',json_encode($cat_array),'category_customization');

                }
            }
        }


    }
    mw()->cache_manager->delete('all');
});

Route::post('clear_page_for_cat_header' , function (){
    $shop_cat = $GLOBALS['shop_data'][0]['id'];
//    $active_head_cat = Config::get('custom.active_category') ?? $shop_cat;
    $active_head_cat = $GLOBALS['custom_active_category'] ?? $shop_cat;
    $cat_array = [];
    if(@$_REQUEST){
        if($shop_cat == $active_head_cat  && @$_REQUEST['shop_id']){
            $cat_array = (array)json_decode($GLOBALS['custom_shop_category_header']) ?? [];
        }else{
            $cat_array = (array)json_decode($GLOBALS['custom_blog_category_header']) ?? [];
        }
        if($active_head_cat == $shop_cat && @$_REQUEST['shop_id']) {
            if (@$cat_array && $cat_array != null) {
                foreach ($cat_array as $key => $cat) {
                    if ($cat == $_REQUEST['shop_id']) {
                        unset($cat_array[$key]);
                    }
                }
//                Config::set('custom.shop_category_header',$cat_array);
                save_option('custom_shop_category_header',json_encode($cat_array),'category_customization');
//                Config::save('custom');
                return response()->json(['success' => true, 'data' => true],200);

            }
        }else{
            if (@$cat_array && $cat_array != null) {
                foreach ($cat_array as $key => $cat) {
                    if ($cat == @$_REQUEST['blog_id']) {
                        unset($cat_array[$key]);
                    }
                }
//                Config::set('custom.blog_category_header',$cat_array);
//                Config::save('custom');
                save_option('custom_blog_category_header',json_encode($cat_array),'category_customization');
                return response()->json(['success' => true, 'data' => true],200);

            }
        }
    }
    mw()->cache_manager->delete('all');

});

Route::post('not_show' , function (){
    $shop_cat = $GLOBALS['shop_data'][0]['id'];
    $active_head_cat = (array)json_decode($GLOBALS['custom_shop_category_header_ignore']) ?? $shop_cat;
    $cat_array = [];
    if(@$_REQUEST){
        if($shop_cat == $active_head_cat && @$_REQUEST['shop_cat']){
            $cat_array = (array)json_decode($GLOBALS['custom_shop_category_header_ignore']) ?? [];
        }else{
            $cat_array = (array)json_decode($GLOBALS['custom_blog_category_header_ignore']) ?? [];
        }
        if(@$_REQUEST['shop_cat']){
            if(in_array($_REQUEST['shop_cat'],$cat_array) == false){
                array_push($cat_array,$_REQUEST['shop_cat']);
//                Config::set('custom.shop_category_header_ignore',$cat_array);
//                Config::save('custom');
                save_option('custom_shop_category_header_ignore',json_encode($cat_array),'category_customization');

            }
        }elseif(@$_REQUEST['blog_cat']){
            if(in_array(@$_REQUEST['blog_cat'],$cat_array) == false){
                array_push($cat_array,$_REQUEST['blog_cat']);
//                Config::set('custom.blog_category_header_ignore',$cat_array);
//                Config::save('custom');
                save_option('custom_blog_category_header_ignore',json_encode($cat_array),'category_customization');

            }
        }

        if(isset($_REQUEST['shop_cat']) && $_REQUEST['shop_cat'] == 0){
            if(in_array(@$_REQUEST['shop_cat'],$cat_array) == false){
                foreach ($cat_array as $key => $cat) {
                    if ($cat == $_REQUEST['page_id']) {
                        unset($cat_array[$key]);
                    }
                }
//                Config::set('custom.shop_category_header_ignore',$cat_array);
//                Config::save('custom');
                save_option('custom_shop_category_header_ignore',json_encode($cat_array),'category_customization');

            }
        }elseif(isset($_REQUEST['blog_cat']) && $_REQUEST['blog_cat'] == 0){

            if(in_array(@$_REQUEST['blog_cat'],$cat_array) == false){
                foreach ($cat_array as $key => $cat) {
                    if ($cat == $_REQUEST['page_id']) {
                        unset($cat_array[$key]);
                    }
                }
//                Config::set('custom.blog_category_header_ignore',$cat_array);
//                Config::save('custom');
                save_option('custom_blog_category_header_ignore',json_encode($cat_array),'category_customization');

            }
        }


    }
    mw()->cache_manager->delete('categories');

});


Route::get('clear_all_cache', 'ApiFunctionController@clear_all_cache');

Route::get('auto_clear_all_server_cache',function(){
    //rename all cache folder dalete
    $folders = scandir(public_path('storage/framework'));
    foreach($folders as $folder){

        if(str_starts_with($folder, 'cache_')){
            $dirPath = public_path('storage/framework/'.$folder);
            try{
                deleteDir($dirPath);
            }catch(Exception $e){

            }
        }

    }
    //cache folder delete
    $folder_path = Config::get('app.manifest').'/cache';
    if(isset($folder_path)){
        if (function_exists('dt_delete_deleteAnyFolder')) {
            dt_delete_deleteAnyFolder($folder_path);
        }
    }
});

Route::post('rss_paging',function (){
    save_option('rss_page' , $_REQUEST['page'],'rss_page');
});


Route::post('index_prevent',function (){
    $data = $_REQUEST;
    if (!empty($data)) {
        $option = array();
        $option['option_value'] = json_encode($data['filename'], true);
        $option['option_key'] = 'disallowedImage';
        $option['option_group'] = 'googleIndexed';
        save_option($option);

        return $data['filename'];
    } else {
        $option = array();
        $option['option_value'] = [];
        $option['option_key'] = 'disallowedImage';
        $option['option_group'] = 'googleIndexed';
        save_option($option);

        return [];
    }
});

Route::post('getindex_prevent',function (){
    $data = get_option('disallowedImage', 'googleIndexed');
    if (!empty($data)) {
        $data = json_decode($data, true);


        $prefixed_imgdatas = preg_filter('/^/', 'Disallow: \\userfiles\\media\\default\\', $data);
        $path = base_path('public/robots.txt');
        $fp = fopen($path, "w");
        fwrite($fp, "# disallow the directories" . PHP_EOL);
        fwrite($fp, "User-agent: Googlebot-Image" . PHP_EOL);

        foreach ($prefixed_imgdatas as $prefixed_imgdata) {
            fwrite($fp, $prefixed_imgdata . PHP_EOL);
        }
        fclose($fp);

        return $data;
    } else {
        return [];
    }
});

Route::post('url_compress',function (){
    return 'https://bamboo.droptienda.rocks/userfiles/media/default/tn-9e8c7a8d6ca6bfcad496056da73cacc0_1.jpg';
});


Route::get('drm_is_active', function(){
    $timestamp = Carbon::now()->timestamp;
    save_option('last_active' , $timestamp, 'shop_online_status');
});

Route::post('get_chat',function (){
    $userToken = Config::get('microweber.userToken');
    $userPassToken = Config::get('microweber.userPassToken');
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://eu-dropshipping.com/api/v1/dt-chat-fetch/'.$_REQUEST['id'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'userToken: '.$userToken,
            'userPassToken: '.$userPassToken,
            'Cookie: SameSite=None; SameSite=None'
        ),
    ));
    $response = curl_exec($curl);

    curl_close($curl);

    $data = @json_decode($response,true)['data'] ?? [];

    $last_active = get_option('last_active', 'shop_online_status');
    $data['online'] = (Carbon::now()->timestamp - $last_active) / 60;

    return response()->json(['success' => true, 'data' => $data],200);
});

Route::post('send_chat',function (){
    $userToken = Config::get('microweber.userToken');
    $userPassToken = Config::get('microweber.userPassToken');
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://eu-dropshipping.com/api/v1/dt-chat-send/'.$_REQUEST['id'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('message' => $_REQUEST['data'],'sender_name' => user_name(),'sender_email' => user_email()),
        CURLOPT_HTTPHEADER => array(
            'userToken: '.$userToken,
            'userPassToken: '.$userPassToken,
            'Cookie: SameSite=None; SameSite=None'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $data = @json_decode($response,true)['data'] ?? [];

    return response()->json(['success' => true, 'data' => $data],200);


});

Route::post('unseen',function (){
    $userToken = Config::get('microweber.userToken');
    $userPassToken = Config::get('microweber.userPassToken');
    $all_orders = DB::table('cart_orders')->pluck('id')->toArray();

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://eu-dropshipping.com/api/v1/unseen',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{"orders": '.json_encode($all_orders).'}',
        CURLOPT_HTTPHEADER => array(
            'userToken: '.$userToken,
            'userPassToken: '.$userPassToken,
            'Content-Type: application/json',
            'Cookie: SameSite=None'
        ),
    ));


    $response = curl_exec($curl);
    curl_close($curl);
    if(json_decode($response,true)['success']){
        return response()->json(['success' => true, 'data' => json_decode($response,true)['data']],200);

    }else{
        return response()->json(['success' => false, 'data' => false],200);
    }
});

Route::post('seen_chat',function (){
    $userToken = Config::get('microweber.userToken');
    $userPassToken = Config::get('microweber.userPassToken');
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://eu-dropshipping.com/api/v1/dt-chat-read/'.$_REQUEST['id'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'userToken: '.$userToken,
            'userPassToken: '.$userPassToken,
            'Cookie: SameSite=None; SameSite=None'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

});




Route::post("send_mail_in_stockout",function (){

    $userToken = Config::get('microweber.userToken');
    $userPassToken = Config::get('microweber.userPassToken');
    $curl = curl_init();

    $data = [
        'customer' => [
            'name' => user_name(),
            'email' => $_REQUEST["email"]??user_email()

        ],
        'product' => [
            'name' => $_REQUEST["title"],
            'ean' => $_REQUEST["ean"],
            'id' => $_REQUEST["id"],
            'url' => $_REQUEST["url"],
        ]


    ];

    /*
        '{
        "customer": {
            "name" : "'.user_name().'",
            "email" : "'.$_REQUEST["email"]??user_email().'"
        },
        "product" : {
            "name" : "'.$_REQUEST["title"].'",
            "ean" : "'.$_REQUEST["ean"].'",
            "id" : "'.$_REQUEST["id"].'",
            "url" : "'.$_REQUEST["url"].'"
        }
    }',
        */


    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://eu-dropshipping.com/api/v1/dt-product-stock-request',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'userToken: '.$userToken,
            'userPassToken: '.$userPassToken,
            'Content-Type: application/json',
            'Cookie: SameSite=None'
        ),
    ));

    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);


    $res = json_decode($response,true);
    $message = $httpcode == 200? $res['message'] : "Something went wrong!";
    $success = $httpcode == 200? $res['success'] : false;
    return response()->json(['success' => $success, 'message' => $message],200);

});
Route::post('compress_url',function (){
    $activate_compressor = get_option('img_compressor' , 'compressor');
    if(@$activate_compressor == 1 && $activate_compressor != false){
        $resize_image = live_editor_image_compressed($_REQUEST['url']);
    }else{
        $resize_image = $_REQUEST['url'];
    }
    return response()->json(["success" => true , "url" => $resize_image ], 200);
});
Route::get('webp-image-null' , function (){
    $all_images = DB::table('media')->where('media_type','picture')->update([
        'resize_image'=> NULL,
        'webp_image'=> NULL,
    ]);
});
Route::get('exixting-image-compress',function (){
    $all_images = DB::table('media')->where('media_type','picture')->where('resize_image',NULL)->get();
    $optimize_data = DB::table('image_optimize')->whereIn('status',[1,2,3])->select('compress','minimum_size','thumbnail_width', 'status')->orderBy('status', 'ASC')->get()->keyBy('status')->toArray();
    $compress_size   = $optimize_data[1]->compress ?? 0;
    $minimum_size    = $optimize_data[2]->minimum_size ?? 0;
    $thumbnail_width = $optimize_data[3]->thumbnail_width ?? 0;

    $savePath= public_path('userfiles/media/default/thumbnails');
    if (!file_exists($savePath)) {
        mkdir($savePath, 0777, true);
    }
    foreach($all_images as $key => $all_image){
        try{
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

            $img_resize = exixting_image_compressed($image_path,$compress_size,$thumbnail_width,$minimum_size,$file_kb_size);

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
            dump($key);
        }catch (Exception $e){
            continue;
        }
    }
});


Route::get('get_folder_image' , function (){
    $directory = $_REQUEST['url']."/*.*";
    $images = glob($directory);

    foreach($images as $image)
    {
        $path = explode("/",$image);
        $image = end($path);
        $explode_image_name = explode(".",$image);
        if(count($explode_image_name) > 2){
            $remove = array_pop($explode_image_name);
            $explode_image_name = implode(".",$explode_image_name);
        }
        $only_image_name = @array_shift($explode_image_name) ?? $explode_image_name;
        if(file_exists($_REQUEST['url'].'/'.$only_image_name.'.webp')){
            continue;
        }
        $result = $image;
        try{
            $result = live_editor_image_compressed($_REQUEST['url'].'/'.$image);
        }catch(Exception $e){
            dump($e);
        }

        dump($result);
    }
});

Route::post('dt_tax_add', function (Request $request) {
    $ref_id = $request->input('drm_ref_id');
    $u_token = Config::get('microweber.userToken');
    $u_pass = Config::get('microweber.userPassToken');
    if($u_token == $request->input('userToken') and $u_pass == $request->input('userPassToken')){
        $data = [];
        $data['country'] = $request->input('country');
        $data['country_de'] = $request->input('country_de');
        $data['country_code'] = $request->input('country_code');
        $data['charge'] = $request->input('charge');
        $data['lang_kod'] = $request->input('lang_kod');
        $data['alpha_three'] = $request->input('alpha_three');
        $data['drm_ref_id'] = $request->input('drm_ref_id');
        $con = [];
        $con['drm_ref_id'] = $data['drm_ref_id'];
        DB::table('tax_rates')->updateOrInsert($con, $data);
        dump('Tax Information added succesfully.');

        // $hasTax = DB::table('tax_rates')->where('drm_ref_id', $ref_id)->get();
        // if(isset($hasTax) and count($hasTax) > 0){
        //     DB::table('tax_rates')->where('drm_ref_id', $ref_id)->update($data);
        //     dump('Tax Information updated succesfully.');
        //     dump($data);
        // } else{
        //     DB::table('tax_rates')->insert($data);
        //     dump("Taxes information saved successfully");
        //     dump($data);
        // }
    } else {
        dump("Sorry user token and pass token didn't matched!");
    }
});

Route::post('faq_data',function(){
    try {

        $userToken = Config::get('microweber.userToken');
        $userPassToken = Config::get('microweber.userPassToken');

        if($_REQUEST['userToken'] == $userToken && $_REQUEST['userPassToken'] == $userPassToken){
            $faqs = array();
            $datas = DB::table('options')->Where('option_group', 'like', '%faq%')->get()->pluck('option_value');
            $data = array();
            foreach($datas as $d){
                if(json_decode($d)){
                    $data = array_merge($data , json_decode($d));
                }
            }
            return response()->json(['success' => true, 'data' => json_encode($data)],200);
        }else{
            return response()->json(['success' => false, 'message' => 'Usertoken and Password not matched!'],200);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => false, 'message' => 'Ops! API returns with response error!'],500);
    }
});



// Handling time data insert route
Route::get('handling_time_insert', function(){
    for($i=1; $i<=14; $i++){
        DB::table('handling_time')->insert(['data' => $i]);
    }
    dump("1 to 14 days handling time insert successfully.");
});

// End handling time route

// specific admin and template update api

Route::get('latest_admin_template_update',function(){
    $current_template_name = get_option('current_template');
    if(isset($_REQUEST['admin']) && isset($_REQUEST['template'])){
        $admin_file_link = $_REQUEST['admin'];
        $template_file_link = $_REQUEST['template'];
    }else{
        $admin_file_link = 'http://sisdemo.club/droptienda_latest_update/admin.zip';
        $template_file_link = 'http://sisdemo.club/droptienda_latest_update/'. $current_template_name. '.zip' ;
    }

    $download_urls = [$admin_file_link,$template_file_link];
    // dd($download_urls);

    try {
        foreach ($download_urls as $download_url){
            $zipFileName = 'update.zip';
            $zip_file = file_put_contents($zipFileName, @file_get_contents($download_url));
            if($zip_file){
                $zip = new ZipArchive;
                $zip->open($zipFileName);
                $zip->extractTo('./');
                $zip->close();
                @unlink(base_path($zipFileName));
                dump('successfully updated');
            }else{
                dump('file not exist');
            }
            exec('php artisan migrate --path=/database/migrations --force');
        }
    }catch (Exception $e){
        dump($e);
    }
});

Route::get('shop_version',function (){
    try {
        $userToken = Config::get('microweber.userToken');
        $userPassToken = Config::get('microweber.userPassToken');

        if($_GET['userToken'] = $userToken && $_GET['userPassToken'] = $userPassToken){
            $data = Config::get('app.adminTemplateVersion');
            return response()->json(['success' => true, 'version' => $data],200);
        }else{
            return response()->json(['success' => false, 'message' => 'Usertoken and Password not matched!'],200);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => false, 'message' => 'Ops! API returns with response error!'],500);
    }
});


Route::get('call_artisan', function () {
    $call=$_GET['call'];
    \Artisan::call($call);
    dd("Cache is cleared");
});

//instagram apis
Route::post('instagram_feed',function (Request $request){
    try{
        $insta_credentials = json_decode(get_option('insta_credentials','instagram'));
        $clientID = $insta_credentials->app_id ?? 621241628890627;
        $clientSecret = $insta_credentials->app_secret ?? '17cbd26948a161da810bbe4f11666c75';
        $url = $insta_credentials->input_text ?? "https://test.droptienda.rocks/api/v1/instagram_feed";
        $date = new DateTime();
        $current_date = $date->getTimestamp();
        require_once('instagram.php');
        $igAPI = new Instagram\Instagram($clientID, $clientSecret, $url);

        $igAPI->set_scope('user_media,user_profile');
        $token = json_decode(get_option('instagram_token' , 'instagram')) ?? null;
//        $expire = $token->expires_in;
//        if(isset($token) && $current_date <= $token->expires_in){
//            delete_option('instagram_token' , 'instagram');
//            return response()->json(['success' => false, 'data' => $url],200);
//        }
        if((!$token && !isset($token))){
            if(!isset($_REQUEST['code'])){
                $authURL = $igAPI->get_authorize_url();
                return redirect($authURL);
            }
            $token = $igAPI->get_access_token($_REQUEST['code']);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.instagram.com/access_token?grant_type=ig_exchange_token&client_secret='.$clientSecret.'&access_token='.$token->access_token,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            curl_close($curl);
//    dump($response);
            $response = json_decode($response);
//    $long_lived_token = $response->access_token;
            $response->user_id = $token->user_id;
            $response->sort_token = $token->access_token;
            $date->add(new DateInterval('PT'.$response->expires_in.'S'));

            save_option('instagram_token' ,json_encode($response), 'instagram');
            $token = $response;
        }

        if(isset($token->access_token)){
            $igAPI->access_token = $token->access_token;
        }
        $instagramUserId = $token->user_id; // a valid Instagram user id, this is returned along with the token when fetching token
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.instagram.com/v12.0/'.$instagramUserId.'/media?access_token='.$token->access_token.'&limit=100&fields=caption,media_type,media_url,permalink,thumbnail_url,timestamp,username,children{media_url,thumbnail_url}',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => array(
                'access_token' => $token->access_token,
                'fields' => 'caption,media_type,media_url,permalink,thumbnail_url,timestamp,username,children{media_url,thumbnail_url}',
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return response()->json(['success' => true, 'data' => $response ],200);
    }catch (Exception $e){
        return response()->json(['success' => false, 'data' => $e ],200);

    }
});

Route::get('instagram_feed',function (Request $request){
    try{
        $insta_credentials = json_decode(get_option('insta_credentials','instagram'));
        $clientID = $insta_credentials->app_id ?? 621241628890627;
        $clientSecret = $insta_credentials->app_secret ?? '17cbd26948a161da810bbe4f11666c75';
        $url = url()->current() ?? $insta_credentials->input_text ?? "https://test.droptienda.rocks/api/v1/instagram_feed";
        $date = new DateTime();
        $current_date = $date->getTimestamp();
        require_once('instagram.php');
        $igAPI = new Instagram\Instagram($clientID, $clientSecret, $url);

        $igAPI->set_scope('user_media,user_profile');
        $token = json_decode(get_option('instagram_token' , 'instagram')) ?? null;
//        $expire = $token->expires_in;
//        if(isset($token) && $current_date <= $token->expires_in){
//            delete_option('instagram_token' , 'instagram');
//            return response()->json(['success' => false, 'data' => $url],200);
//        }
        if((!$token && !isset($token))){
            if(!isset($_REQUEST['code'])){
                $authURL = $igAPI->get_authorize_url();
                return redirect($authURL);
            }
            $token = $igAPI->get_access_token($_REQUEST['code']);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://graph.instagram.com/access_token?grant_type=ig_exchange_token&client_secret='.$clientSecret.'&access_token='.$token->access_token,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            curl_close($curl);
//    dump($response);
            $response = json_decode($response);
//    $long_lived_token = $response->access_token;
            $response->user_id = $token->user_id;
            $response->sort_token = $token->access_token;
            $date->add(new DateInterval('PT'.$response->expires_in.'S'));

            save_option('instagram_token' ,json_encode($response), 'instagram');
            $token = $response;
        }

        if(isset($token->access_token)){
            $igAPI->access_token = $token->access_token;
        }
        $instagramUserId = $token->user_id; // a valid Instagram user id, this is returned along with the token when fetching token
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://graph.instagram.com/v12.0/'.$instagramUserId.'/media?access_token='.$token->access_token.'&limit=100&fields=caption,media_type,media_url,permalink,thumbnail_url,timestamp,username,children{media_url,thumbnail_url}',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS => array(
                'access_token' => $token->access_token,
                'fields' => 'caption,media_type,media_url,permalink,thumbnail_url,timestamp,username,children{media_url,thumbnail_url}',
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return response()->json(['success' => true, 'data' => $response],200);
    }catch (Exception $e){
        return response()->json(['success' => false, 'data' => $e ],200);

    }
});

Route::post('insta_next' , function (){
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $_REQUEST['data'].'&fields=caption,media_type,media_url,permalink,thumbnail_url,timestamp,username,children{media_url,thumbnail_url}',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS => array(),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    return response()->json(['success' => true, 'data' => $response],200);
});

Route::post('insta_connection', function (Request $request){
    try {
        $clientID = $_REQUEST['app_id'];
        $clientSecret = $_REQUEST['app_secret'];
        $url = $_REQUEST['input_text'];
        $date = new DateTime();
        $current_date = $date->getTimestamp();
        require_once('instagram.php');
        $igAPI = new Instagram\Instagram($clientID, $clientSecret, $url);

        $igAPI->set_scope('user_media,user_profile');
        $authURL = $igAPI->get_authorize_url();
        save_option('insta_credentials',json_encode($_REQUEST),'instagram');
        return response()->json(['success' => true, 'url' => $authURL],200);

    }catch (Exception $e){
        return $e;
    }
});

Route::post('insta_details',function (){
    try{
        $insert = array(
            'media_id' => $_REQUEST['media_id'],
            'insta_img_description' => $_REQUEST['insta_img_description'],
        );
        DB::table('instagram_feed')->insert($insert);
        return response()->json(['success' => true],200);
    }catch (Exception $e){
        return response()->json(['success' => false, 'message' => $e],200);

        return $e;
    }
});

// start active_legal_text_option_name send from DT to DRM
Route::get('active_legal_text_option_name',function(){
    $userToken = Config::get('microweber.userToken');
    $userPassToken = Config::get('microweber.userPassToken');
    if($_GET['userToken'] = $userToken && $_GET['userPassToken'] = $userPassToken){
        $active_legal_option = get_option('active_legal_option_name', 'active_legal_option_name') ?? null;
        if($active_legal_option){
            return response()->json(['success' => true, 'type' => $active_legal_option],200);
        }else{
            return response()->json(['success' => false, 'message' => 'Legal text option not active.'],200);
        }
    }else{
        return response()->json(['success' => false, 'message' => 'Usertoken and Password not matched!'],200);
    }
});
// end active_legal_text_option_name send from DT to DRM


// DRM suplier api
Route::post("supliers_details",function (){

    $userToken = Config::get('microweber.userToken');
    $userPassToken = Config::get('microweber.userPassToken');
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://eu-dropshipping.com/api/v1/dt-suppliers',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_HTTPHEADER => array(
        'userToken: ' . $userToken,
        'userPassToken: ' . $userPassToken,
        'Cookie: SameSite=None'
      ),
    ));

    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);


    $res = json_decode($response,true);
    $message = $httpcode == 200? $res['data'] : "Something went wrong!";
    $success = $httpcode == 200? $res['success'] : false;
    return response()->json(['success' => $success, 'data' => $message],200);

});

// DRM Tax api
Route::post("drm_tax_get",function (){

    $userToken = Config::get('microweber.userToken');
    $userPassToken = Config::get('microweber.userPassToken');
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://eu-dropshipping.com/api/v1/dt-tax-list',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_HTTPHEADER => array(
        'userToken: ' . $userToken,
        'userPassToken: ' . $userPassToken,
        'Cookie: SameSite=None'
      ),
    ));

    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);


    $res = json_decode($response,true);
//    dd($res);
    $data = $res['data'];
    foreach($data as $tax_details){
        $con = array();
        $con['drm_ref_id'] = $tax_details['id'];
//        dd($con);
        $inserted = DB::table('tax_rates')->updateOrInsert( ['drm_ref_id' => $tax_details['id']] ,$tax_details);
        dump($inserted);
    }
    $message = $httpcode == 200? $res['data'] : "Something went wrong!";
    $success = $httpcode == 200? $res['success'] : false;
    return response()->json(['success' => $success, 'data' => $message],200);

});

// upload digital product
Route::post("upload_digital_product", function (Request $request) {


    if ($request->hasFile('file')) {
        $message = "Please upload your digital content";
        $file = $request->file('file');
        $basename = basename($file->getClientOriginalName(), '.' . $file->getClientOriginalExtension());
        $filename = 'digital_content/'  . $basename . time() . '.' . $file->getClientOriginalExtension();
        $savefile = Storage::disk('local')->put($filename, (string) file_get_contents($file));

        if ($savefile) {
            DB::table('product_details')->updateOrInsert(
                ['rel_id' => $request->product_id],
                ['d_P_download_link' => $filename]
            );
            $message = "Sucessfully File uploaded";
        }
        return $message;
    }
});

Route::post("order-limit-check",function (){

    $userToken = Config::get('microweber.userToken');
    $userPassToken = Config::get('microweber.userPassToken');
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://eu-dropshipping.com/api/v1/test-order-limit',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'userToken: '.$userToken,
            'userPassToken: '.$userPassToken,
            'Cookie: SameSite=None'
        ),
    ));

    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);


    $res = json_decode($response,true);
    $limit = false;

    $data = $res['data'];
    if($data['limit'] > $data['orders']){
        $limit = true;
    }
    $success = $httpcode == 200? $res['success'] : false;
    return response()->json(['success' => $success, 'data' => $limit],200);

});


Route::get("get_category_for_search",function (){
    $categoriesShowHide = get_option('categoriesShowHide', 'searchbar_menu_category');
    if($categoriesShowHide and $categoriesShowHide == 2){
        $categories_list = '<option value="all" id="cat_all">Alle Kategorien</option>';
        // $categories_list = '<option value="all" id="cat_all">Alle Kategorien</option><option value="ean" id="ean">EAN</option><option value="sku" id="sku">Artikelnummer</option>';
        return response()->json(['success' => true, 'data' => $categories_list],200);
    }else{
        $categories = DB::table('categories')
        ->select('id','title')
        ->where('is_deleted',0)
        ->where('is_hidden',0)
        ->where('parent_id',0)
        ->whereNotNull('title')
        // ->orderBy('title', 'asc')
        ->orderBy('title', 'asc')
        ->get();
        // $categories_list = '<option value="all" id="cat_all">Alle Kategorien</option><option value="ean" id="ean">EAN</option><option value="sku" id="sku">Artikelnummer</option><option value="" id="" disabled class="optiondivider">-----------------------------------------</option><option value="" id="" disabled class="optiontitle">Kategorien</option><option value="" id="" disabled class="optiondivider">-----------------------------------------</option>';
        $categories_list = '<option value="all" id="cat_all">Alle Kategorien</option>';
        if(isset($categories) && !empty($categories)){
            foreach($categories as $category){
                $categories_list .= '<option value="'.$category->id.'" id="cat_'.$category->id.'">'.$category->title.'</option>';
            }
        }
        return response()->json(['success' => true, 'data' => $categories_list],200);
    }
});

Route::post("get_content_by_category",function (){
    $category_id = $_REQUEST['cat_id'];

    if(isset($category_id) && $category_id != 'all'){
        if($category_id == 'sku' || $category_id == 'ean'){
            $content = [];
        }else{
            $content = DB::table('content')
            ->join('categories_items' ,'content.id', '=', 'categories_items.rel_id')
            ->where('categories_items.parent_id', '=', $category_id)
            ->where('content_type','product')
            ->where('is_deleted',0)
            ->where('is_active',1)
            ->whereNotNull('title')
            ->select('title')
            ->get()
            ->toArray();
        }
    }else{
        $content = DB::table('content')
        ->join('products', 'products.content_id','content.id')
        ->whereIn('content.content_type',['post','product'])
        ->where('content.is_deleted',0)
        ->where('content.is_active',1)
        ->where('products.category_hide',0)
        ->whereNotNull('content.title')
        ->select('content.title')
        ->get()
        ->toArray();

    }
    if(isset($content) && !empty($content)){
        $content_title = collect($content)->whereNotNull('title')->pluck('title');
        $content_title = $content_title->toArray();
    }else{
        $content_title = [];
    }
    return response()->json(['success' => true, 'data' => $content_title],200);
});


Route::post("remove_session",function (){
    $all_bundle_details = mw()->user_manager->session_get($_REQUEST['key']);
    if($all_bundle_details){
        if(count($all_bundle_details) > 1){
            foreach($all_bundle_details as $key => $bundle_details){
                if(isset($bundle_details['id']) and $bundle_details['id'] == (int)$_REQUEST['key1']){
                    $session_data_bundle = mw()->user_manager->session_get('bundle_product_checkout');
                    unset($session_data_bundle[$key]);
                    mw()->user_manager->session_set('bundle_product_checkout',$session_data_bundle);
                }
            }
        } else{
            mw()->user_manager->session_del($_REQUEST['key']);
        }
    }
    // if(mw()->user_manager->session_get($_REQUEST['key'])){
    //     mw()->user_manager->session_del($_REQUEST['key']);
    // }
    return response()->json(['success' => true,'data' => true],200);

});

// product transfer
Route::post("products_transfer",'ProductController@products_transfer');
Route::post("products_transfer_update",'ProductController@products_transfer_update');

Route::post("blogs_transfer", 'ApiFunctionController@blogs_transfer');

Route::post("get_gateway",function(Request $request){
    if (($request->header('userToken') == Config('microweber.userToken')) && ($request->header('userPassToken') == Config('microweber.userPassToken'))) {
        return response()->json(['success' => true, 'message' => 'Dev User verified successfully.', 'credentials' => [
            'dev' => str_random(2).Config('microweber.userToken').str_random(2),
            'secret' => str_random(2).Config('microweber.userPassToken').str_random(2),
        ]], 200);
    }
    return response()->json(['success' => false, 'message' => 'Droptienda Shop verification failed.'], 401);
});


Route::post('delete_faq_sidebar',function(){

    $page_field_names =  dt_clone_getParentFieldName($_REQUEST['page_id']);
    $layout_id_names = array();
    $module_templates = module_templates('layouts/admin');
    foreach($page_field_names as $page_field_name){

        $oldcontent = DB::table('content_fields')->where('rel_id',PAGE_ID)->where('field',$page_field_name)->get()->last();

        if($oldcontent){
            $html =   $oldcontent->value;
        }else{
            $html = null;
        }
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $nodes = array();
        $nodes = $dom->getElementsByTagName("module");
        $rename_ids = array();
        $new_element = array();

        for($i=0; $i < count($nodes) ; $i++){
            $data_mw_title = $nodes->item($i)->getAttribute("data-mw-title");
            $data_type=$nodes->item($i)->getAttribute("data-type");
            $module_template = $nodes->item($i)->getAttribute("template");
            $module_id = $nodes->item($i)->getAttribute("id");
            if($module_id == $_REQUEST['m_id']){
                $nodes->item($i)->parentNode->removeChild($nodes->item($i));
            }
            $save_html = $dom->saveHTML();
            $extra_tag_remove = array(
                'tag-1' =>  '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">',
                'tag-2' => '<html><body>',
                'tag-3' => '</body></html>'
            );
            $new_string = str_replace($extra_tag_remove,'', $save_html);
            DB::table('content_fields')->where('rel_id',PAGE_ID)->where('field',$page_field_name)->update([
                'value' => $new_string
            ]);

        }
    }
    return response()->json(['success' => true, 'message' => 'Successfully Removed'], 200);
});

Route::post("save-header-faq-sidebar" , function(){
    $ids = @$_REQUEST['ids'];
    $headers = @$_REQUEST['headers'];
    $page_id = @$_REQUEST['page_id'];
    if(isset($ids) && isset($headers)){
        foreach($ids as $key => $m_id){
            DB::table('options')->updateOrinsert(
                ['option_key' => $m_id],
                [
                'option_group' => 'sidebar-nav-module-list-'.$page_id,
                'option_key' => $m_id,
                'option_value' => $headers[$key],
            ]);
        }
    }

});

Route::post("faq-count" , function(){
    $ids = @$_REQUEST['ids'];

    if(isset($ids)){
        foreach($ids as $key => $m_id){
            $faq_all_questions = get_option('settings',$m_id);
            $faq_question_count = 0;
            if($faq_all_questions){
                $faq_module_questions = array_filter(json_decode($faq_all_questions), function ($faq_question) use ($m_id) {
                    if($faq_question->page_id == PAGE_ID && $faq_question->module_id == $m_id){
                        return true;
                    }
                });
                $faq_question_count = count($faq_module_questions);
            }
            $r_value[$m_id] = $faq_question_count;
        }
    }
    return response()->json(['success' => true, 'data' => $r_value], 200);

});


Route::post('insert_faq_page', function(){

    $content_id =  DB::table('content')->where([
        "content_type" => "page",
        "url" => "faq",
        "title" => "FAQ"])->first()->id;
        if(!isset($content_id)){
            $content = array(
                "content_type" => "page",
                "subtype" => "static",
                "url" => "faq",
                "title" => "FAQ",
                "parent" => "0",
                "is_active" => "1",
                "active_site_template" => "default",
                "layout_file" => "layouts__sidebar_navigation.php",
                "is_home" => "0",
                "is_pinged" => "0",
                "is_shop" => "0",
                "is_deleted" => "0",
                "require_login" => "0",
                "session_id" => "1gFG82M8KcqrOAyLuluwfX0QvLrj3r9BMXe2jVlw",
                "updated_at" => "2021-04-29 09:10:27",
                "created_at" => "2021-04-29 08:44:54",
                "created_by" => "1",
                "edited_by" => "1",
                "posted_at" => "2021-04-29 08:44:54",
            );
            $content_id = DB::table('content')->insertGetId($content);
        }

    $module_id = 'faq-20220217105845';
    $faq_all_questions = (get_option('settings',$module_id)) ? get_option('settings',$module_id) : get_option('settings','faq');
    $json = json_decode($faq_all_questions??[]);

    $newd = "[{\"question\":\"Hier kannst du deine 1. Frage eingeben\",\"answer\":\"Hier kannst du deine 2. Antwort eingeben\",\"page_id\":\"$content_id\",\"module_id\":\"faq-20220217105845\"},{\"question\":\"Hier kannst du deine 2. Frage eingeben\",\"answer\":\"Hier kannst du deine 2. Anttwort eingeben\",\"page_id\":\"$content_id\",\"module_id\":\"faq-20220217105845\"},{\"question\":\"Hier kannst du deine 3. Frage eingeben\",\"answer\":\"Hier kannst du deine 3. Antwort eingeben\",\"page_id\":\"$content_id\",\"module_id\":\"faq-20220217105845\"}]";
    $new_data = json_decode($newd);

    $json = array_merge($json,$new_data);

    $options = array(
        [
            "option_key" => "settings",
            "option_value" => $json,
            "option_group" => "faq",
            "module" => "faq-20220217105845",
        ],
        [
            "option_key" => "layouts-20220217105837",
            "option_value" => "HIER KANNST DU EINEN TITEL (PASSEND ZUM THEMA EINGEBEN)",
            "option_group" => "sidebar-nav-module-list-".$content_id,
            "module" => "",

        ]
    );

    DB::table('options')->insert($options);


    $content_field = array(
        [
            "updated_at" => "2019-08-27 07:54:31",
            "created_at" => "2019-08-27 07:54:31",
            "created_by" => "1",
            "edited_by" => "1",
            "rel_type" => "content",
            "rel_id" => $content_id,
            "field" => "sidebar_navigation_page",
            "value" => "\r\n<module class=\"-layout module module-layouts\" data-mw-title=\"Layouts\" template=\"faq-heading.php\" data-type=\"layouts\" id=\"layouts-20220217105837\" parent-module=\"layouts\" parent-module-id=\"layouts-20220217105837\"></module>\r\n        \r\n"
        ],
        [
            "updated_at" => "2019-08-27 07:54:31",
            "created_at" => "2019-08-27 07:54:31",
            "created_by" => "1",
            "edited_by" => "1",
            "rel_type" => "module",
            "rel_id" => "0",
            "field" => "layout-faq-heading-layouts-20220217105837",
            "value" => "\r\n<div class=\"container element\" id=\"element_1645095503376\">\r\n        <div class=\"row\">\r\n            <div class=\"col-md-12\">\r\n                <div class=\"faq-heading-wrapper element\" id=\"element_1645095503379\">\r\n                    <div class=\"faq-heading-header element\" id=\"element_1645095503404\">\r\n                        <h3 class=\"element\" id=\"dlp-item-1645095503432\">HIER KANNST DU EINEN TITEL (PASSEND ZUM THEMA EINGEBEN)</h3>\r\n                    </div>\r\n                    <div class=\"faq-heading-image element\" id=\"element_1645095503338\">\r\n                        <img src=\"{SITE_URL}userfiles/elements/images/faq-heading.jpg\" alt=\"\">\r\n</div>\r\n                </div>\r\n                <div class=\"faq-heading-content element\" id=\"element_1645095503454\">\r\n                    <p class=\"element\" id=\"dlp-item-1645095503448\">Hier kannst du noch eine passende Beschreibung eingeben.</p>\r\n<p class=\"element\" id=\"dlp-item-1645095503449\">Diese kannst du auch oben im Werkzeugkasten bearbeiten.</p>\r\n<module class=\"module module-faq\" data-mw-title=\"FAQ\" data-type=\"faq\" id=\"faq-20220217105845\" parent-module=\"faq\" parent-module-id=\"faq-20220217105845\"></module>\r\n</div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n"
        ],
        [
            "updated_at" => "2019-08-27 07:54:31",
            "created_at" => "2019-08-27 07:54:31",
            "created_by" => "1",
            "edited_by" => "1",
            "rel_type" => "module-faq-20220217105845",
            "rel_id" => $content_id,
            "field" => "title-content",
            "value" => "\r\n                    <h3 class=\"element\" id=\"dlp-item-1645095503474\">Hier kannst du einen Subtitel eingeben</h3>\r\n"
        ]
    );

    DB::table('content_fields')->insert($content_field);


});
Route::post("reorder_position",function(){

    $product_id = (int)$_REQUEST['product_id'];
    $replace_data = explode(',',$_REQUEST['replace_with']);

    $old_position_holder_id = $replace_data[0];
    $new_position = $replace_data[1];
    $new_index = $replace_data[2];

    $positions = DB::table('content')->select('position','id')->where('content_type','product')->orderBy('position','desc')->pluck('id')->toArray();

    if (($key = array_search($product_id, $positions)) !== false) {
        unset($positions[$key]);
    }
    array_splice( $positions, $new_index, 0, $product_id ); // splice in at position 3

    $data['ids'] = $positions;

    $new_possition_array = mw()->content_manager->reorder($data);

    return response()->json(['success' => true, 'data' => $new_possition_array], 200);


});


Route::post("reorder_position_product",function(){

    $product_id = (int)$_REQUEST['product_id'];
    $replace_data = explode(',',$_REQUEST['replace_with']);

    $old_position_holder_id = $replace_data[0];
    $new_position = $replace_data[1];
    $new_index = $replace_data[2];

    $positions = DB::table('product')->select('position','id')->where('content_type','product')->orderBy('position','desc')->pluck('id')->toArray();

    if (($key = array_search($product_id, $positions)) !== false) {
        unset($positions[$key]);
    }
    array_splice( $positions, $new_index, 0, $product_id ); // splice in at position 3

    $data['ids'] = $positions;

    $ids = $data['ids'];
    if (empty($ids)) {
        $ids = $_POST[0];
    }
    if (empty($ids)) {
        return false;
    }
    $ids = array_unique($ids);
    $ids = array_map('intval', $ids);
    $ids_implode = implode(',', $ids);
    $table = mw()->database_manager->real_table_name('product');
    $maxpos = 0;
    $get_max_pos = "SELECT max(position) AS maxpos FROM $table  WHERE id IN ($ids_implode) ";
    $get_max_pos = mw()->database_manager->query($get_max_pos);
    if (is_array($get_max_pos) and isset($get_max_pos[0]['maxpos'])) {
        $maxpos = intval($get_max_pos[0]['maxpos']) + 1;
    }

    $i = 1;
    foreach ($ids as $id) {
        $id = intval($id);
        mw()->cache_manager->delete('content/' . $id);

        $pox = $maxpos - $i;

        DB::table('product')->whereId($id)->update(['position' => $pox]);
        ++$i;
    }

    mw()->cache_manager->delete('content');
    mw()->cache_manager->delete('categories');

    $new_possition_array = true;

    return response()->json(['success' => true, 'data' => $new_possition_array], 200);


});

Route::post("reorder_existing_position",function(){

    reorder_existing_position();

});

Route::post('module_content_limit',function (){
    save_option('content_limit_for_live_edit_module' , $_REQUEST['limit'],'content_limit_for_live_edit_module');
    mw()->update->post_update();
    return response()->json(['success' => true, 'data' => true], 200);
});

Route::post('module_setting_save',function (){
    DB::table('product_module_setting')->updateOrInsert(['module_id' => $_REQUEST['module_id'],'key' => $_REQUEST['key']],$_REQUEST);
    return response()->json(['success' => true, 'data' => true], 200);
});

Route::post("clear_product_table",function (){
    DB::table('products')->delete();
    DB::table('content')->where('synced',1)->update(
        [
            'synced' => 0,
        ]
    );
});


Route::get('hidden_cat', function (){
    $status = DB::table('categories')->where('status' , 0)->pluck('id')->toArray();
    $cat_ids = [];
    if(isset($status) && !empty($status)){
        $cat_ids = $status;
    }
    return response()->json(['success' => true, 'data' => $cat_ids], 200);

});



Route::get('category_load_on_scroll',function(){
    $params = $_REQUEST['data'];
    $categoryTree= DB::table('categories')
        ->where('is_deleted',0)
        ->whereNotNull('title')
        // ->orderBy('title', 'asc')
        ->orderBy('position', 'asc')
        ->limit($_REQUEST['limit'])
        ->get();



            if(isset($categoryTree) && !empty($categoryTree->toArray())){
                if(url_param('action', 'false') == 'shop_categories'){
                    $html=generate_categories_admin($categoryTree,site_url('shop'),$params['rel_id'],false,0,true);
                }else{
                    $html=generate_categories_admin($categoryTree,site_url('shop'),$params['rel_id'],false,0,false);
                }
                return response()->json(['success' => true, 'data' => $html ],200);

            }


    return response()->json(['success' => false, 'data' => false ],200);
});

Route::post('category_order', function (){
    $categories = Category::where("parent_id",0)->get();
    $position = 0;
    foreach($categories as $cat){
        $c_cats = collect(mw()->category_manager->get_category_children_recursive($cat['id']))->pluck('id');
        Category::where("id",$cat['id'])->update([
            'position' => $position
        ]);
        $position = $position+1 ;
        foreach($c_cats as $c_c){
            Category::where("id",$c_c)->update([
                'position' => $position
            ]);
            $position = $position+1;
        }
    }
});

Route::post('order_status', function (){
    $order_id = $_REQUEST['order_id'];
    $order_status = $_REQUEST['order_status'];
    if(isset($order_id) && isset($order_status)){
        DB::table('cart_orders')->where('id',$order_id)->update([
            'order_status' => $order_status
        ]);
    }

    $order = DB::table('cart_orders')->where('id',$order_id)->first();

    return response()->json(['success' => true, 'data' => $order ],200);

});
Route::get('rename_cache', function (){
    rename(public_path('storage/framework/cache'), public_path('storage/framework/cache_'.time()));
    return response()->json(['success' => true, 'message' => 'Cache Folder Rename successfully' ],200);
});


Route::get('create_vacation', 'ApiFunctionController@create_vacation');
Route::post('category_reset', function (){
    $categories = DB::table('categories')->pluck('id')->toArray();
    $contents = DB::table('content')->pluck('id')->toArray();
    DB::table('categories_items')->whereNotIn('parent_id',$categories)->delete();
    DB::table('categories_items')->whereNotIn('rel_id',$contents)->delete();
    cat_reset_logic();
});

// prodct sync api for DRM
use App\Models\product_sync_history_v2;
use App\Services\ExportV2\ExportProcessV2;
use League\Csv\Reader;
Route::post('product_sync_drm__v2', function(Request $request){
    $sync_id = "sync_".date('YmdHis');
    $status = [];
    if (($request->header('userToken') == Config('microweber.userToken')) && ($request->header('userPassToken') == Config('microweber.userPassToken'))) {
        if($request->input('type') == 'ids'){
            if(count(json_decode($request->input('data'), true)) == json_decode($request->input('count'), true)[0]) {
                $msg = "Deletion are in progress";
                $status_type = 'pending';
                $res = 200;
                $status['status'] = 200;
            } else{
                $msg = "Data count didn't matched";
                $status_type = 'failed';
                $res = 203;
                $status['status'] = 203;
            }
            $status['message'] = $msg;
            $status['sync_id'] = $sync_id;
            $response = json_encode($status);
            $delete_from = $request->input('delete_from') ?? 'shop';
        } else if($request->input('type') == 'url'){
            $msg = "";
            $csv_url = json_decode($request->input('data'), true);
            $csv_count = json_decode($request->input('count'), true);
            $csv = count($csv_url);
            for($i= 0; $i<$csv; $i++){
                $reader = Reader::createFromString(file_get_contents($csv_url[$i]));
                $reader->setDelimiter('|');
                $data = $reader->setHeaderOffset(0);
                $records = $data->getRecords();
                $per_csv_count = iterator_count($records);
                if($per_csv_count != $csv_count[$i]){
                    $msg .= "The total number of data didn't matched for {$i} number csv";
                    $status_type = "failed";
                    $res = 203;
                    $status['status'] = 203;
                }
            }
            if(!isset($status_type)) $status_type = "pending";
            if(empty($msg)) {
                $msg = "Insertion data in processing";
                $res = 200;
                $status['status'] = 200;
            }
            $status['message'] = $msg;
            $status['sync_id'] = $sync_id;
            $response = json_encode($status);
            $delete_from = $request->input('delete_from') ?? '';
        } else if($request->input('type') == 'json'){
            $status_type = "pending";
            $msg = "Insertion data in processing";
            $res = 200;
            $status['status'] = 200;
            $status['message'] = $msg;
            $status['sync_id'] = $sync_id;
            $response = json_encode($status);
            $delete_from = $request->input('delete_from') ?? '';
        }

    } else{
        $msg = "Authentication failed";
        $status['message'] = $msg;
        $status['sync_id'] = $sync_id;
        $status['status'] = $res = 401;
        $status_type = "failed";
        $response = json_encode($status);
        $delete_from = $request->input('delete_from') ?? '';
    }
    $product_sync = new product_sync_history_v2();
    $product_sync->data = $request->input('data');
    $product_sync->type = $request->input('type');
    $product_sync->count = $request->input('count');
    $product_sync->action = $request->input('action');
    $product_sync->sync_id = $sync_id;
    $product_sync->status = $status_type;
    $product_sync->drm_status = $response;
    $product_sync->old_sync_id = ($request->input('old_sync_id') != null) ? $request->input('old_sync_id') : 0;
    $product_sync->data_type = $request->input('data_type') ?? 'products';
    $product_sync->delete_from = $delete_from;
    $product_sync->save();
    return response($response)->setStatusCode($res);
});


Route::post('/clear-sync-process-data-table', function(Request $request){
    if (($request->header('userToken') == Config('microweber.userToken')) && ($request->header('userPassToken') == Config('microweber.userPassToken'))) {
        DB::table('sync_processing_data_status_v2')->delete();
        dump("Data deleted successfully");
    }else {
        dump("Authentication failed!");
    }
});

Route::get('/product_sync_drm__v2', function(){
    $get_headers = apache_request_headers();
    if((isset($get_headers['userToken']) or isset($get_headers['Usertoken'])) and (isset($get_headers['userPassToken']) or isset($get_headers['Userpasstoken']))){
        $data = [
            'userToken' => $get_headers['userToken'] ?? $get_headers['Usertoken'],
            'userPassToken' => $get_headers['userPassToken'] ?? $get_headers['Userpasstoken']
        ];
    } else {
        $data = [
                'userToken' => null,
                'userPassToken' => null
            ];
    }
    $sync_id = isset($_GET['sync_id']) ? $_GET['sync_id'] : 0;
    $old_sync_id = isset($_GET['old_sync_id']) ? $_GET['old_sync_id'] : 0;
    $x = new ExportProcessV2($data, $sync_id, $old_sync_id);
    $x->index();
});




Route::get('resolve',function(){
    $syncId = $_REQUEST['sync_id'];
    $processingId = $_REQUEST['proccessing_id'];
    $clear = $_REQUEST['clear'] ?? false;
    $id = $_REQUEST['id'];
    $userToken = Config('microweber.userToken');
    $passToken = Config('microweber.userPassToken');


    if(isset($clear) && $clear == true){
        $dataSet = DB::table('content')->where('drm_ref_id',$id)->first();
        if(isset($dataSet) && !empty($dataSet)){
            DB::table('sync_processing_data_status_v2')->where('processing_id',$processingId)->where('drm_ref_id',$id)->delete();
        }else{
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://159.65.124.158/api/dt-channel-products/get-body',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('ids' => $id),
            CURLOPT_HTTPHEADER => array(
                'userPassToken: '.$passToken,
                'userToken: '.$userToken
            ),
            ));
            $response = json_decode(curl_exec($curl));
            curl_close($curl);
        }
    }elseif(isset($syncId) && isset($processingId) && isset($id)){

        $dataSet = DB::table('content')->where('drm_ref_id',$id)->first();
        if(isset($dataSet) && !empty($dataSet)){
            $drmIdsStr = json_encode([$id]);
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://159.65.124.158/api/dt-channel-products/status/update',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('ids' => $drmIdsStr,'type' => 'INSERT'),
            CURLOPT_HTTPHEADER => array(
                'userPassToken: '.$passToken,
                'userToken: '.$userToken
            ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            DB::table('sync_processing_data_status_v2')->where('processing_id',$processingId)->where('drm_ref_id',$id)->delete();

            return redirect()->back();

        }else{
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://159.65.124.158/api/dt-channel-products/get-body',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('ids' => $id),
            CURLOPT_HTTPHEADER => array(
                'userPassToken: '.$passToken,
                'userToken: '.$userToken
            ),
            ));
            $response = json_decode(curl_exec($curl));
            curl_close($curl);
        }

    }
    $dataSet = (array)$response->data;
    $data = (object)[
        "sync_id" => $syncId,
        "type" => 'resolve',
        "data" => json_encode($dataSet),
        "proccessing_id" => $processingId
    ];
    $export = new ExportProcessV2((array)$data, $syncId, false);
    $export->insert_product_process($data);
    return redirect()->back();
});

Route::get('get-table-data', function(){
    $get_headers = apache_request_headers();
    if((isset($get_headers['userToken']) or isset($get_headers['Usertoken'])) and (isset($get_headers['userPassToken']) or isset($get_headers['Userpasstoken']))){
        $userToken = $get_headers['userToken'] ?? $get_headers['Usertoken'];
        $userPassToken = $get_headers['userPassToken'] ?? $get_headers['Userpasstoken'];
        if (($userToken == Config('microweber.userToken')) && ($userPassToken == Config('microweber.userPassToken'))) {
            $table = $_GET['table'];
            $is_delete = $_GET['delete'] ?? null;
            $is_update = $_GET['update'] ?? null;
            $query = DB::table($table);
            for($i=0;$i<=10;$i++){
                $field = $_GET['field'.$i] ?? null;
                $value = $_GET['value'.$i] ?? null;
                if($field != null)
                $query->where($field, $value);

            }
            if($is_delete != null and $is_delete){
                $data = $query->delete();
                dump("Value deleted from this table {$table}");
            } else if($is_update != null and $is_update){
                $updateArray = [];
                for($i=1;$i<=10;$i++){
                    $field = $_GET['updateField'.$i] ?? null;
                    $value = $_GET['updateValue'.$i] ?? null;
                    if($field == null) break;
                    $updateArray[$field] = $value;
                }
                $data = $query->update($updateArray);
                dump("Value updated from this table {$table}");
            } else{
                if(isset($_GET['drm']) and $_GET['drm']){
                    $paginate = $_GET['paginate'] ?? 10;
                    $data = $query->orderBy('id', 'desc')->paginate($paginate);
                    if(count($data) > 0){
                        foreach($data as $item){
                            $arraySet = [];
                            $arraySet['item_id'] = $item->drm_ref_id;
                            $arraySet['status'] = $item->is_success;
                            $arraySet['finished'] = $item->created_at;
                            $arraySet['process_id'] = $item->processing_id;
                            $sync_data = DB::table('product_sync_history_v2')
                                    ->join('sync_processing_history_v2', 'product_sync_history_v2.sync_id', '=', 'sync_processing_history_v2.sync_id')
                                    ->where('sync_processing_history_v2.id', $item->processing_id)
                                    ->first();
                            $arraySet['item_type'] = isset($sync_data->data_type) ? $sync_data->data_type : null;
                            $arraySet['event'] = isset($sync_data->action) ? $sync_data->action : null;
                            $arraySet['trigered'] = isset($sync_data->created_at) ? $sync_data->created_at : null;
                            $arraySet['sync_id'] = isset($sync_data->sync_id) ? $sync_data->sync_id : null;
                            $item->data = $arraySet;
                        }
                    }
                    return json_encode($data);
                }else{
                    if(isset($_GET['orderBy'])){
                        $orderField = $_GET['orderBy'] ?? 'id';
                        $orderValue = $_GET['ordering'] ?? 'desc';
                        $query->orderBy($orderField, $orderValue);
                    }
                    $data = $query->get();
                    dump($data->toArray());
                }
            }
        }
        else{
            dump("Authentication falied");
        }
    }
});


Route::get('sync_1_29_data', 'ApiFunctionController@drmUserNameUpdated');

Route::get('get-export-data', function(){
    $get_headers = apache_request_headers();
    if((isset($get_headers['userToken']) or isset($get_headers['Usertoken'])) and (isset($get_headers['userPassToken']) or isset($get_headers['Userpasstoken']))){
        $userToken = $get_headers['userToken'] ?? $get_headers['Usertoken'];
        $userPassToken = $get_headers['userPassToken'] ?? $get_headers['Userpasstoken'];
        if (($userToken == Config('microweber.userToken')) && ($userPassToken == Config('microweber.userPassToken'))) {
            $sync_data = DB::table('product_sync_history_v2')
                            ->join('sync_processing_history_v2', 'product_sync_history_v2.sync_id', '=', 'sync_processing_history_v2.sync_id')
                            ->get();
            $data_set = [];
            if(count($sync_data) > 0){
                foreach($sync_data as $item){
                    $arraySet = [];
                    $arraySet['item_id'] = $item->sync_id;
                    $arraySet['status'] = $item->sync_status;
                    $arraySet['finished'] = $item->updated_at;
                    $arraySet['process_id'] = $item->id;
                    $arraySet['item_type'] = $item->data_type;
                    $arraySet['event'] = $item->action;
                    $arraySet['trigered'] = $item->created_at;
                    $data_set[] = $arraySet;
                }
                // dump($data_set);
                return json_encode($data_set);
            }
        }

    }
});

Route::get('refresh-shop-version', function(){

    try{
        $currentVersionOfAdmin = Config::get('app.adminTemplateVersion');
        $usertokenDrm = Config::get('microweber.userToken');
        $userpasstokenDrm = Config::get('microweber.userPassToken');
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://drm.software/api/droptienda/version/update',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('version_name' => $currentVersionOfAdmin),
        CURLOPT_HTTPHEADER => array(
            'userToken: '.$usertokenDrm,
            'userPassToken: '.$userpasstokenDrm
        ),
        ));

        $responses = curl_exec($curl);

        curl_close($curl);
    }catch(Exception $e){
        return response()->json(["message" => $e->getMessage()], 422);
    }

    return response()->json(["message" =>  "successfully Update"], 200);

});


Route::post('shop-control', function(Request $request){

        $userToken = Config::get('microweber.userToken');
        $userPassToken = Config::get('microweber.userPassToken');
        if($userToken == $request->header('userToken') && $userPassToken == $request->header('userPassToken')){
            if(isset($_REQUEST['isLocked']) && $_REQUEST['isLocked'] == 'true'){
                delete_option('login','website');
                delete_option('vacation_mode','website');
                save_option('login', 'false', 'website');
                save_option('vacation_mode', 'yes', 'website');
                session()->flush();
                Session::flush();
            }else{
                delete_option('login','website');
                delete_option('vacation_mode','website');
            }
        }

    return response()->json(["message" =>  "successfully Update"], 200);

});

Route::get('refresh-connected-products', function(){
    $products = DB::table('content')->where('content_type','product')->pluck('drm_ref_id')->toArray();
    $user_token = Config('microweber.userToken');
    $pass_token = Config('microweber.userPassToken');
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://159.65.124.158/api/dt-channel-products/status/update',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array('ids' => $products,'type' => 'CHECK'),
    CURLOPT_HTTPHEADER => array(
        'userPassToken: '.$pass_token,
        'userToken: '.$user_token
    ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    return response($response);
});

Route::get('get-product-images/{ur}', function($url){
    $hasProduct = DB::table('content')->where('url', $url)->pluck('id')->first();
    if($hasProduct){
        $images = DB::table('media')->where('rel_id', $hasProduct)->get()->toArray();
        if(isset($images)){
            $images_data = [];
            foreach($images as $image){
                if(isset($image->webp_image)){
                    $images_data[] = str_replace('{SITE_URL}', site_url(), $image->webp_image);
                } elseif(isset($image->resize_image)){
                    $images_data[] = str_replace('{SITE_URL}', site_url(), $image->resize_image);
                } else{
                    $images_data[] = image_set_to_server($image);
                }
            }
            $response = ['status'=>200, 'images'=> json_encode($images_data)];
            return response(json_encode($response))->setStatusCode(200);
        }
    }
    return false;
});

Route::post('get-all-product-images', function(Request $request){
    if (($request->header('userToken') == Config('microweber.userToken')) && ($request->header('userPassToken') == Config('microweber.userPassToken'))) {
        $drm_ids = json_decode($request->input('ids'), true);
        if(!empty($drm_ids) and isset($drm_ids)){
            $images = DB::table('content')
                        ->join('media','content.id', 'media.rel_id')
                        ->whereIn('content.drm_ref_id', $drm_ids)
                        ->select('content.drm_ref_id', 'media.id', 'media.webp_image', 'media.resize_image', 'media.filename', 'media.rel_id')
                        ->get();
            if(isset($images) and !empty($images)){
                $full_images_data = [];
                foreach($images as $image){
                    if(isset($image->webp_image)){
                        $full_images_data[$image->drm_ref_id][] = str_replace('{SITE_URL}', site_url(), $image->webp_image);
                    } elseif(isset($image->resize_image)){
                        $full_images_data[$image->drm_ref_id][] = str_replace('{SITE_URL}', site_url(), $image->resize_image);
                    } else{
                        $full_images_data[$image->drm_ref_id][] = image_set_to_server($image);
                    }
                }
                $response = ['status'=>200, 'images'=> json_encode($full_images_data)];
                return response(json_encode($response))->setStatusCode(200);
            }
        }
        return false;
    }
});

Route::post('convert-images-to-shop', 'ApiFunctionController@convert_images_to_shop');

Route::get('get-images-to-product-table', function(){
    $needUpdatedImages = DB::table('products')->where('image', 'not like', '%{SITE_URL}%')->pluck('content_id')->toArray();
    if(!empty($needUpdatedImages)){
        foreach($needUpdatedImages as $content){
            $getImage = DB::table('media')->where('rel_id', $content)->first();
            DB::table('products')->where('content_id', $content)->update(['image' => $getImage->filename]);
        }
    }
});

Route::get('get-category-status', 'ApiFunctionController@category_status');

Route::get('update-blogs-url', 'ApiFunctionController@update_blogs_url');

Route::post('update-showmore',function(){
    $posts_limit = get_option('data-limit', $_POST['param']);
    if($posts_limit != 'false' && $posts_limit != '') {
        $posts_limit = (int)$posts_limit;
    }else{
        if((int)$_POST['count'] % 3 == 0)  {
                $posts_limit = 6;
        }else{
                $posts_limit = 8;
        }
    }
    $show = (int)$_POST['count'] ?? $posts_limit ?? 6;

    $show = $show+$posts_limit;
    Cache::put('abc'.$_POST['param'],$show,5);
    return response()->json(["message" =>  "successfully Update"], 200);
});


Route::get('rm-showmore',function(){
    Cache::flush();
    return true;
});

Route::get('add-searchbar-menus', 'ApiFunctionController@addSearchbarMenus');

Route::post('refresh-group-data', 'ApiFunctionController@refreshGroupData');

Route::post('refresh-group-payment-data', 'ApiFunctionController@refreshGroupPaymentData');

Route::get('create_global_fonts_file', 'ApiFunctionController@create_global_file_fonts');

Route::get('get-pricing-title-description/{params}', 'ApiFunctionController@pricingTitleDescription');
