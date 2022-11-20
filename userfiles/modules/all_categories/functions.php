<?php

/*
	@Category CRUD api
*/

use App\Models\CategoryItem;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Microweber\App\Providers\Illuminate\Support\Facades\Hash;
use MicroweberPackages\Category\Models\Category;
use QueryPath\Exception;
use Symfony\Component\HttpFoundation\Response;

/** @noinspection SpellCheckingInspection */
api_expose('all_categorie');
api_expose('insert_category');
api_expose('categories');
api_expose('edit_category');
api_expose('category_delete');
api_expose('get_wishlist_sessions');
api_expose('delete_wishlist_sessions');
api_expose('guest_checkout');
api_expose('set_wishlist_sessions');
api_expose('edit_wishlist_sessions');
api_expose('add_wishlist_sessions');
api_expose('remove_wishlist_sessions');
api_expose('store_update_products');
api_expose('filter_wishlist');
api_expose('share_wishlist');
api_expose('sdk_text');
api_expose('custom_api', function () {
    app()->log_manager->save('');
});
//api_expose('update_product_drm');
//start Round Prices
api_expose('activeRoundprice');
function activeRoundprice($data){
    if (isset($data['round_price'])) {
        Config::set('custom.round_amount', $data['round_price']);
        Config::save(array('custom'));

    }

}

api_expose('deactiveRoundprice');
function deactiveRoundprice(){
    Config::set('custom.round_amount', 0);
    Config::save(array('custom'));
}




//end Round Prices

api_expose('variantWithUpselling');
function variantWithUpselling($data){
    $itemus = DB::table("selected_product_upselling_item")->where('product_id', $data['product_id'] )->where('user_id',user_id())->get('service_price');
    if (isset($itemus) && $itemus->count() > 0) {
        $totoalp = 0;
        foreach($itemus as $itemp){
            $totoalp =  $totoalp + ($itemp->service_price + taxPrice($itemp->service_price));
        }
        return response()->json(["message" =>  $totoalp], 200);
    }else{
        return response()->json(["message" =>  "not found"], 404);
    }

}

//start search hits
api_expose('searchHits');
function searchHits($data){
    Config::set('custom.search_hits', $data['n']);
    Config::save(array('custom'));
}

//end search hits

// start checkout bumbs


api_expose('checkoutBumbsInsert');
function checkoutBumbsInsert($data){
    if (isset($data['product_id'])) {
        $active =  DB::table('checkout_bumbs')->get();
        if($active->count()){
            DB::table('checkout_bumbs')->update(['product_id' => $data['product_id']]);
        }
        else{
            DB::table('checkout_bumbs')->insert(array('product_id' => $data['product_id'],'show_cart' =>$data['show_cart'],'show_checkout' => $data['show_checkout']));
        }

    }

}


api_expose('checkoutBumbsDelete');
function checkoutBumbsDelete($data){


    $modulesValue = DB::table("checkout_bumbs")->where('product_id',$data['product_id'])->get();

    if($modulesValue->count()){
        $modulesValue = DB::table("checkout_bumbs")->where('product_id',$data['product_id'])->delete();
    }
}

api_expose('activeBumbs');
function activeBumbs($data){
    if (isset($data['show_cart']) or isset($data['show_checkout'])) {
        DB::table('checkout_bumbs')->update(['show_cart' => $data['show_cart'],'show_checkout' => $data['show_checkout']]);
    }

}


// end checkout bumbs



//thank you pages start

api_expose('thankyouPrice');
function thankyouPrice($data){
    if($data > 0){
        return response()->json(["message" => currency_format($data['totalPrice']) ], 200);
    }
    else{
        return response()->json(["message" =>  "error"], 404);
    }

}


api_expose('activeTemplate');
function activeTemplate($data){
    if (isset($data['template_name'])) {
        DB::table('thank_you_pages')->where('template_name', $data['template_name'])->update(['is_active' => '1']);
        $activePage =  DB::table('thank_you_pages')->where('template_name', $data['template_name'])->where('is_active', '1')->get();
        $activePageProduct =  DB::table('content')->where('id', $activePage[0]->product_id)->get();
        return response()->json(["message" => $activePageProduct[0]->title], 200);
    }

}

api_expose('deactiveTemplate');
function deactiveTemplate($data){
    if (isset($data['template_name'])) {
        DB::table('thank_you_pages')->where('template_name', $data['template_name'])->update(['is_active' => '0']);
    }

}



api_expose('productModulesInsert');
function productModulesInsert($data){
    if (isset($data['template_name'])) {
        $active =  DB::table('thank_you_pages')->where('template_name', $data['template_name'])->get();
        if($active->count()){
            DB::table('thank_you_pages')->where('template_name', $data['template_name'])
                ->update(['product_id' => $data['product_id']]);
        }
        else{
            DB::table('thank_you_pages')->insert(array('template_name' => $data['template_name'],'product_id' => $data['product_id']));
        }

    }

}


api_expose('productModulesDelete');
function productModulesDelete($data){


    $modulesValue = DB::table("thank_you_pages")->where('template_name',$data['template_name'])->where('product_id',$data['product_id'])->get();

    if($modulesValue->count()){
        $modulesValue = DB::table("thank_you_pages")->where('template_name',$data['template_name'])->where('product_id',$data['product_id'])->delete();
    }
}
//thank you pages end





//start product upselling


api_expose('clearUpsellingItem');
function clearUpsellingItem($data){
    DB::table("selected_product_upselling_item")->where('user_id',user_id())->delete();
}

api_expose('addproductUpselling');
function addproductUpselling($data){
    //   dd($data['product_id']);

    $selectupsellingValue = DB::table("selected_product_upselling_item")->where('service_id',$data['service_id'])->where('product_id',$data['product_id'])->where('user_id',user_id())->get();

    if($selectupsellingValue->count()){

    }
    else{
        DB::table('selected_product_upselling_item')->insert(array('product_id' => $data['product_id'], "service_id" => $data['service_id'],'service_price' => $data['service_price'], "user_id" => user_id()));
    }

    if($data['total']){
        $taxam = 0; $tax= mw()->tax_manager->get();
        !empty($tax) ? $taxam = $tax['0']['rate'] : $taxam = 0 ;
        $v = roundPrice(floatval($data['productPrice'])) + (float)$data['total'] + ($taxam*(float)$data['total'])/100;
        // var_dump($v);
        // die;
        return response()->json(["message" => currency_format($v) ], 200);
    }
}

api_expose('deleteproductUpselling');
function deleteproductUpselling($data){
    $selectupsellingValue = DB::table("selected_product_upselling_item")->where('service_id',$data['service_id'])->where('product_id',$data['product_id'])->where('user_id',user_id())->get();

    if($selectupsellingValue->count()){
        DB::table("selected_product_upselling_item")->where('service_id',$data['service_id'])->where('product_id',$data['product_id'])->where('user_id',user_id())->delete();
    }
    if($data['total']){
        $taxam = 0; $tax= mw()->tax_manager->get();
        !empty($tax) ? $taxam = $tax['0']['rate'] : $taxam = 0 ;
        // var_dump((float)$data['total'] + ($taxam*(float)$data['total'])/100,floatval($data['productPrice']));
        // die;
        $v = floatval($data['productPrice']) + ((float)$data['total'] + ($taxam*(float)$data['total'])/100);
        return response()->json(["message" => currency_format($v) ], 200);
    }
    else{

        return response()->json(["message" => currency_format(roundPrice(floatval($data['productPrice']))) ], 200);
    }
}


api_expose('productUpsellingItemInsert');
function productUpsellingItemInsert($data){

    $upsellingValue = DB::table("product_upselling_item")->where('item_id',$data['item_id'])->where('product_id',$data['product_id'])->get();

    if($upsellingValue->count()){

    }
    else{
        DB::table('product_upselling_item')->insert(array('product_id' => $data['product_id'], "item_id" => $data['item_id']));
    }
}


api_expose('productUpsellingItemDelete');
function productUpsellingItemDelete($data){

    $upsellingValue = DB::table("product_upselling_item")->where('item_id',$data['item_id'])->where('product_id',$data['product_id'])->get();

    if($upsellingValue->count()){
        $upsellingValue = DB::table("product_upselling_item")->where('item_id',$data['item_id'])->where('product_id',$data['product_id'])->delete();
    }
}

api_expose('productUpsellingInsert');
function productUpsellingInsert($data){
    if (isset($data['serviceName']) && isset($data['servicePrice']) ) {
        DB::table('product_upselling')->insert(array('serviceName' => $data['serviceName'], "servicePrice" => $data['servicePrice']));
    }
    return back();
}

api_expose('productUpsellingUpdate');
function productUpsellingUpdate($data){

    if (isset($data['serviceName']) && isset($data['servicePrice']) ) {
        DB::table('product_upselling')
            ->where('id', $data['id'])
            ->update(['serviceName' => $data['serviceName'],'servicePrice' => $data['servicePrice']]);

    }
    $url = admin_url();

    header("Location: ".admin_url().'view:shop/action:productUpselling', TRUE, 301);
    exit();
}

api_expose('productUpsellingDelete');
function productUpsellingDelete($data){
    if (isset($data['delete'])) {
        DB::table('product_upselling')->where('id', $data['delete'])->delete();
        DB::table('product_upselling_item')->where('item_id', $data['delete'])->delete();
    }
    $url = admin_url();

    header("Location: ".admin_url().'view:shop/action:productUpselling', TRUE, 301);
    exit();
}

//end product upselling





//start header show/hide function

api_expose('headerShow');
function headerShow($data){

    if($data){
        DB::table('header_show_hides')->insert(array('page_id' => $data['id']));
    }

}


api_expose('headerHide');
function headerHide($data){

    if($data){
        DB::table("header_show_hides")->where('page_id', $data['id'])->delete();
    }

}

//end header show/hide function



//start Clone Page
api_expose('clonePage');
function clonePage($data){

    $pageValue = DB::table("content")->find($data);
    // var_dump($pageValue->url);
    // die;

    if($pageValue){
        $pageinfo = array(
            "content_type" => $pageValue->content_type,
            "subtype"=> $pageValue->subtype,
            "url"=> $pageValue->url."-copy",
            "title"=> $pageValue->title." Copy",
            "parent"=> $pageValue->parent,
            "description"=> $pageValue->description,
            "position"=> $pageValue->position,
            "content"=> $pageValue->content,
            "content_body"=> $pageValue->content_body,
            "is_active"=> $pageValue->is_active,
            "subtype_value"=> $pageValue->subtype_value,
            "custom_type"=> $pageValue->custom_type,
            "custom_type_value"=> $pageValue->custom_type_value,
            "active_site_template"=> $pageValue->active_site_template,
            "layout_file"=> $pageValue->layout_file,
            "layout_name"=> $pageValue->layout_name,
            "layout_style"=>$pageValue->layout_style,
            "content_filename"=>$pageValue->content_filename,
            "original_link"=>$pageValue->original_link,
            "is_home"=>$pageValue->is_home,
            "is_pinged"=>$pageValue->is_pinged,
            "is_shop"=>$pageValue->is_shop,
            "is_deleted"=>$pageValue->is_deleted,
            "require_login"=>$pageValue->require_login,
            "status"=>$pageValue->status,
            "content_meta_title"=>$pageValue->content_meta_title,
            "content_meta_keywords"=>$pageValue->content_meta_keywords,
            "session_id"=>$pageValue->session_id,
            "updated_at"=>$pageValue->updated_at,
            "created_at"=>$pageValue->created_at,
            "expires_at"=>$pageValue->expires_at,
            "created_by"=>$pageValue->created_by,
            "edited_by"=>$pageValue->edited_by,
            "posted_at"=>$pageValue->posted_at,
            "draft_of"=>$pageValue->draft_of,
            "copy_of"=>$pageValue->copy_of,
            "ean"=>$pageValue->ean,
            "drm_ref_id"=>$pageValue->drm_ref_id,
        );

        if(DB::table('content')->insert($pageinfo)){
            $t = DB::table('content')->get()->last();
            $menuValue = DB::table("menus")->where('content_id',$pageValue->id)->get();
            $contentpageid = array(
                "newPageId" => $t->id,
                "oldPageId" => $pageValue->id
            );
            if(!empty($menuValue->count())){
                $menuInfo =  array(
                    "title" => $menuValue[0]->title ,
                    "item_type" => $menuValue[0]->item_type ,
                    "parent_id" => $menuValue[0]->parent_id ,
                    "content_id" => $t->id ,
                    "categories_id" => $menuValue[0]->categories_id ,
                    "position" => $menuValue[0]->position ,
                    "updated_at" => $menuValue[0]->updated_at ,
                    "created_at" => $menuValue[0]->created_at ,
                    "is_active" => $menuValue[0]->is_active ,
                    "auto_populate" => $menuValue[0]->auto_populate ,
                    "description" => $menuValue[0]->description ,
                    "url"=> $menuValue[0]->url_target ,
                    "url_target" => $menuValue[0]->url_target ,
                    "size" => $menuValue[0]->size ,
                    "default_image" => $menuValue[0]->default_image ,
                    "rollover_image" => $menuValue[0]->rollover_image
                );
                DB::table('menus')->insert($menuInfo);
                return response()->json(["message" =>  $contentpageid ], 200);
            }else{
                return response()->json(["message" =>  $contentpageid ], 200);
            }
        }else{
            return response()->json(["message" => "do not create a page" ], 404);
        }
    }else{
        return response()->json(["message" => "do not create a page" ], 404);
    }
}




api_expose('clonePageContentSave');

if (!function_exists('clonePageContentSave')) {
    function clonePageContentSave($data){
        $page_field_names =  dt_clone_getParentFieldName($data['oldPageId']);
        if($page_field_names){
            foreach($page_field_names as $page_field_name){
                $oldcontent = DB::table('content_fields')->where('rel_id',$data['oldPageId'])->where('field',$page_field_name)->get()->last();
                // dd($oldcontent);
                if($oldcontent){
                    $newvalue = dt_clone_clonePageWithAllLayouts($oldcontent->value,$data['newPageId'],$data['oldPageId']);
                    $newvalue['new_string'] = dtCloneClonelSingleLayoutsModules($newvalue['new_string'],null,null,$data['newPageId']);
                    $newpagecontent = array(
                        "created_by" => user_id(),
                        "edited_by" => user_id(),
                        "rel_type" => $oldcontent->rel_type,
                        "rel_id" => $data['newPageId'],
                        "field" => $oldcontent->field,
                        "value" =>  $newvalue['new_string']
                    );
                    if(DB::table('content_fields')->insert($newpagecontent)){
                        // dd($new_layout_field_id);
                        for($i =0 ; $i < count($newvalue['old_layout_field_id']); $i++){
                            $fieldvalue = DB::table('content_fields')->where('field', $newvalue['old_layout_field_id'][$i])->first();
                            if(!empty($fieldvalue)){
                                $layout_string = dt_clone_clonelLayoutsModules($fieldvalue->value,$data['newPageId'],$data['oldPageId']);
                                $layout_string = dtCloneClonelSingleLayoutsModules($layout_string,$newvalue['old_layout_field_id'][$i],$newvalue['new_layout_field_id'][$i]);
                                $fieldcontent = array(
                                    "created_by" => user_id(),
                                    "edited_by" => user_id(),
                                    "rel_type" => $fieldvalue->rel_type,
                                    "rel_id" => 0,
                                    "field" =>  $newvalue['new_layout_field_id'][$i],
                                    "value" =>   $layout_string
                                );
                                // dd($new_layout_field_id);
                                DB::table('content_fields')->insert($fieldcontent);
                            }
                        }
                    }
                }
            }
            return response()->json(["message" =>  $data['newPageId']], 200);
        }else{
            return response()->json(["message" =>  $data['newPageId']], 200);
        }
    }
}



//end Clone Page



function downloadTheme($url,$zipFileName){

    return file_put_contents($zipFileName, file_get_contents($url));


// copy($url, $zipFileName);

// $ch = curl_init();
// curl_setopt($ch, CURLOPT_POST, 0);
// curl_setopt($ch,CURLOPT_URL,$url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// $file_content = curl_exec($ch);
// curl_close($ch);

// $downloaded_file = fopen($zipFileName, 'w');
// fwrite($downloaded_file, $file_content);
// fclose($downloaded_file);
}

function extractTheme($zipFileName){
    $zip = new ZipArchive;
    $zip->open($zipFileName);
    $zip->extractTo('./');
    $zip->close();
    unlink(base_path($zipFileName));
}



function is_connected()
{
    $connected = @fsockopen("www.google.com", 80);
    if ($connected){
        $is_conn = true; //action when connected
        fclose($connected);
    }else{
        throw new \Exception('Internet Connection Error...');
        $is_conn = false; //action in connection failure
    }
    return $is_conn;

}


//start admin panel update function
api_expose('updateAdmintheme');
function updateAdmintheme($data){
    try{

        is_connected();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://packages.droptienda-templates.com/api/admin_update");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);

        curl_close($ch);
        $link = json_decode($response, true);

        $download_url = $link['data']['download_url'];


        if($response){
            $zipFileName = 'update.zip';
            downloadTheme($download_url,$zipFileName);
            extractTheme($zipFileName);
            exec('php artisan migrate --force');
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
                CURLOPT_POSTFIELDS => array('version_name' => $data['update_version']),
                CURLOPT_HTTPHEADER => array(
                    'userToken: '.$usertokenDrm,
                    'userPassToken: '.$userpasstokenDrm
                ),
                ));

                $responses = curl_exec($curl);

                curl_close($curl);
            }catch(Exception $e){
                dump($e);
            }

            return response()->json(["message" =>  "successfully Update"], 200);

        }
        else{
            // unlink(base_path('userfiles/templates/electron/.git/config'));
            // exec("rmdir /s /q userfiles/templates/electron/.git");
            return response()->json(["message" =>  "error"], 404);
        }

    }
    catch (Exception $e) {
        return response()->json(["message" =>  $e->getMessage()], 404);
    }
}
//end admin panel update function


// delete theme

// api_expose('deleteTheme');
// function deleteTheme($data){
//     $dirname = base_path('userfiles/templates/'.$data['dir']);
//     if(delete_directory($dirname)){

//     }else{

//     }
// }


// function delete_directory($dirname) {
//         if (is_dir($dirname))
//         $dir_handle = opendir($dirname);
//         if (!$dir_handle)
//             return false;
//         while($file = readdir($dir_handle)) {
//             if ($file != "." && $file != "..") {
//                 if (!is_dir($dirname."/".$file))
//                         unlink($dirname."/".$file);
//                 else
//                         delete_directory($dirname.'/'.$file);
//             }
//         }
//         closedir($dir_handle);
//         rmdir($dirname);
//         return true;
//     }



// start template update function


// api_expose('themeupdateinfo');
// function themeupdateinfo($data){
//     try{

//         is_connected();

//         $ch = curl_init();

//         curl_setopt($ch, CURLOPT_URL,"https://packages.droptienda-templates.com/api/template_verison");

//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

//         $response = curl_exec($ch);

//         curl_close($ch);
//         $link = json_decode($response, true);

//         $info = $link['data']['info'];

//         if($response){
//             return response()->json(["message" =>  $info], 200);
//         }
//         else{
//             return response()->json(["message" =>  "error"], 404);
//         }

//     }
//     catch (Exception $e) {
//         return response()->json(["message" =>  $e->getMessage()], 404);
//     }

// }


//start check purchase

api_expose('checkParchase');
function checkParchase($data){
    if(Config::get('template.'.$data['name']) == 0){
        return response()->json(["message" =>  "success"], 200);
    }else{
        $templink = "https://drm.software/admin/template-store?template=".Config::get('template.'.$data['name']);
        return response()->json(["message" =>   $templink ], 404);
    }
}


//end check purchase


api_expose('install_theme');
function install_theme($data){

// $output=null;
// $retval=null;




    try{

        is_connected();

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"https://packages.droptienda-templates.com/api/template_verison");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);

        curl_close($ch);
        $link = json_decode($response, true);

        $download_url = $link['data']['download_url'];

        if($response){
            $zipFileName = 'update.zip';
            downloadTheme($download_url,$zipFileName);
            extractTheme($zipFileName);
            Config::set('template.'.$data['name'], 0);
            Config::save(array('template'));
            return response()->json(["message" =>  "successfully"], 200);

        }
        else{
            // unlink(base_path('userfiles/templates/electron/.git/config'));
            // exec("rmdir /s /q userfiles/templates/electron/.git");
            return response()->json(["message" =>  "error"], 404);
        }

    }
    catch (Exception $e) {
        return response()->json(["message" =>  $e->getMessage()], 404);
    }

}

//end template update function

event_bind('mw.user.after_register', function () {
    /** @noinspection PhpUndefinedVariableInspection */
    $id = $data['id'];
    /** @noinspection SpellCheckingInspection */
    $ch4 = curl_init(config('global.drm_base_url') . 'api/dorptinda-new-customer-notify?type=customer&id=' . $id);
    // Returns the data/output as a string instead of raw data
    curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch4, CURLOPT_CUSTOMREQUEST, "GET");
    curl_exec($ch4);
    // get info about the request
    curl_getinfo($ch4);
    // close curl resource to free up system resources
    curl_close($ch4);
    // dd($data);
    // die();
});

api_expose('all_categories_dt');
/** @noinspection PhpUndefinedMethodInspection */
function all_categories_dt()
{
    $all_categories_dt = DB::table('categories');
    if (isset($_GET['category_id']))
        $all_categories_dt = $all_categories_dt->where('id', $_GET['category_id'])->get();
    else
        $all_categories_dt = $all_categories_dt->get();

    $all_categories_dt = json_decode($all_categories_dt);

    DB::beginTransaction();
    try {
        $client = new Client();
        foreach ($all_categories_dt as $category) {
            try {
                $client->request('POST', 'http://165.227.134.199/api/v1/catalogs/categories', [
                    'headers' => [
                        'content-type' => 'application/json',
                        'Authorization' => 'Bearer ' . config('global.token_dp'),
                    ],
                    'query' => [
                        'category_name_de' => $category->title,
                        'country_id' => 1
                    ],
                ]);
            } catch (\Exception $e) {
                dump($e->getMessage());
            }
        }
        DB::commit(); // all good
    } catch (\Exception $e) {
        DB::rollback(); // something went wrong
        $e->getMessage();
    }
}


api_expose('token_save');
function token_save($data){
    dd($data);
}


function sdk_text(){
    $setting_client_id		= 'droptiendapost';	// #### insert your own shared secret 'client id' (which you received from IT-Recht Kanzlei)
    $setting_client_secret	= 'DVRq2AgoYQ9a8WomNKuuFFRqhBFe';	// #### insert your own shared secret 'client secret' (which you received from IT-Recht Kanzlei)

    // $setting_download_PDF	= true;	// #### set true or false whether or not you want to download the legal text PDF provided. The PDF can be used for later attaching it to order confirmation emails (recommendation in Q1/2019 for legal reasons: attach 'agb' and 'widerruf', please consult a lawyer regarding the current requirements).
    $shop_url = url('/');



    $LTI = new ITRechtKanzlei\LegalTextInterface();
    $selected_multishop_id = $LTI->is_MULTISHOP(array('1' => $shop_url));


    // read token from legal text transmission
    $token = $LTI->get_AUTH_Token();

    $token_number= DB::table('tokenurl')->first();
    if($token_number->token == $token){

        $retval_token_ok = true;

    }else{

        $retval_token_ok = false;

    }
    // report OK if shop was found / token is valid, or report that the lookup had no valid result
    if( $retval_token_ok === true ){ $LTI->send_AUTH_ok(); } else { $LTI->send_AUTH_failed(); }


    // read more values from current legal text (LT) transmission
    // #### use these values as required by your endpoint application or shop/CMS system
    $LT_Language	= $LTI->get_LT_Language();	// ISO 639-1 (lowercase, e.g. 'de' for German / Deutsch)
    $LT_Country		= $LTI->get_LT_Country();	// ISO 3166-1-alpha-2 (uppercase, e.g. 'DE' for Germany/Deutschland)
    $LT_Title		= $LTI->get_LT_Title();		// can be used e.g. as a title for a CMS page
    $LT_Text		= $LTI->get_LT_Text();		// the legal text in text form
    $LT_HTML		= $LTI->get_LT_HTML();		// the legal text in HTML form
    $LT_Type		= $LTI->get_LT_Type();		// holds the legal text type ('agb','','widerruf','impressum')



    // $data=$LT_Text;

    $pathToFile = 'mylogname.log';

    // Log the data to your file using file_put_contents;
    // file_put_contents($pathToFile, $data, FILE_APPEND);

    $retval_savetodatabase_ok=true;
    if($LT_Type=='agb'){

        $agb = DB::table('legals')->where('term_name','agb')->get()->toArray();
        // return (!empty($agb));
        if(!empty($agb)){
            DB::table('legals')->where('term_name','agb')->update(['description' => $LT_HTML]);
            $retval_savetodatabase_ok=true;
        }else{
            DB::table('legals')->insert(['term_name' => 'agb','description' => $LT_HTML]);
            $retval_savetodatabase_ok=true;
        }

    }else if($LT_Type=='widerruf'){

        $Widerruf = DB::table('legals')->where('term_name','cancle')->get()->toArray();
        if(!empty($Widerruf)){
            DB::table('legals')->where('term_name','cancle')->update(['description' => $LT_HTML]);
            $retval_savetodatabase_ok=true;
        }else{
            DB::table('legals')->insert(['term_name' => 'cancle','description' => $LT_HTML]);
            $retval_savetodatabase_ok=true;
        }

    }else if($LT_Type=='impressum'){

        $impressum = DB::table('legals')->where('term_name','imprint')->get()->toArray();
        if(!empty($impressum)){
            DB::table('legals')->where('term_name','imprint')->update(['description' => $LT_HTML]);
            $retval_savetodatabase_ok=true;
        }else{
            DB::table('legals')->insert(['term_name' => 'imprint','description' => $LT_HTML]);
            $retval_savetodatabase_ok=true;
        }

    }else if($LT_Type=='datenschutz'){

        $datenschutz = DB::table('legals')->where('term_name','pp')->get()->toArray();
        if(!empty($datenschutz)){
            DB::table('legals')->where('term_name','pp')->update(['description' => $LT_HTML]);
            $retval_savetodatabase_ok=true;
        }else{
            DB::table('legals')->insert(['term_name' => 'pp','description' => $LT_HTML]);
            $retval_savetodatabase_ok=true;
        }

    }

    if( $retval_savetodatabase_ok === true ){ $LTI->send_SUCCESS(); } else { $LTI->send_ERROR('Fehler beim Speichern des Rechtstextes'); }



    // $data=$LT_Text;


    // return $_REQUEST;


}

api_expose('update_categories_dt');
function update_categories_dt($params)
{
    dd($params);

}

/** @noinspection PhpUndefinedMethodInspection */
function categories()
{
    $all_categories = DB::table('categories');
    if (isset($_GET['category_id'])) {
        $all_categories = $all_categories->where('id', $_GET['category_id'])->get();
    } else {
        $all_categories = $all_categories->get();
    }
    return $all_categories;
}


// function insert_category()
// {
//     $data_save = array();
//     if (isset($_POST['title'])) {
//         $data_save['title'] = $_POST['title'];
//         $category_id = save_category($data_save);
//     } else {
//         $data_save['title'] = 'Category title is required';
//         return json_encode($data_save);
//     }
// }

/** @noinspection PhpUndefinedMethodInspection */
function insert_category()
{
    $new_cat = array();
    // $old_cat = $update_data->where('title',$_REQUEST['title'])->get();
    if (isset($_REQUEST['title'])) {
        $unique_check = DB::table('categories')->where('title', $_REQUEST['title'])->get()->first();
        if ($unique_check) {
            return response()->json(["message" => "title is already exists."], 422);
        } else {
            $currentTime = Carbon\Carbon::now();
            $new_cat['title'] = $_REQUEST['title'];
            $new_cat['created_by'] = 1;
            $new_cat['edited_by'] = 1;
            $new_cat['url'] = slugify($_REQUEST["title"]);
            $new_cat['parent_id'] = 0;
            $new_cat['rel_type'] = 'content';
            $new_cat['rel_id'] = 8;
            $new_cat['position'] = 0;
            $new_cat['category_subtype'] = 'default';
            $new_cat['users_can_create_content'] = 0;
            $new_cat['data_type'] = 'category';
            $new_cat["updated_at"] = $currentTime->toDateTimeString();
            $new_cat["created_at"] = $currentTime->toDateTimeString();

            DB::table("categories")->insertGetId($new_cat);
            return response()->json(["message" => "Category added successfully"], 200);
        }
    } else {
        return response()->json(["message" => "title is required"], 404);
    }
}

/** @noinspection PhpUndefinedMethodInspection */
function category_delete()
{
    if (isset($_POST['category_id'])) {
        DB::table('categories')->where('id', $_POST['category_id'])->delete();
        return response()->json(["message" => "deleted"], 204);
    } else {
        return response()->json(["message" => "category_id ie required"], 422);
    }
}

/** @noinspection PhpUndefinedMethodInspection */
function edit_category()
{
    $currentTime = Carbon\Carbon::now();
    // $old_cat = $update_data->where('title',$_REQUEST['title'])->get();
    if (isset($_REQUEST['old_title']) && isset($_REQUEST['new_title'])) {
        $unique_check = DB::table('categories')->where('title', $_REQUEST['new_title'])->get()->first();
        if ($unique_check) {
            return response()->json(["message" => "New title is already exists."], 422);
        }
        $old_cat = DB::table('categories')->where('title', $_REQUEST['old_title'])->get()->first();
        if ($old_cat) {
            DB::table('categories')->where('id', $old_cat->id)->update([
                "title" => $_REQUEST['new_title'], "url" => slugify($_REQUEST["new_title"]),
                "updated_at" => $currentTime->toDateTimeString()
            ]);
            return response()->json(["message" => "Update successful"], 200);
        } else {
            return response()->json(["message" => "Old category not found"], 404);
        }
    } else {
        $update_data = 'old_title and new_title ie required';
        return json_encode($update_data);
    }
}


/** @noinspection PhpUndefinedMethodInspection */
function get_wishlist_sessions()
{
    $is_logged = is_logged();

    if ($is_logged == true) {
        $user_id = user_id();

        $wishLists = DB::table("wishlist_sessions")->where("user_id", $user_id)->get();

        // if (count($wishLists) === 0) {
        //     DB::table('wishlist_sessions')->insert(array('user_id' => $user_id, "name" => "Meine Wunschliste"));
        //     $wishLists = DB::table("wishlist_sessions")->where("user_id", $user_id)->get();
        // } else{
        //     foreach ($wishLists as $wishList)
        //         $wishList->products = DB::table('wishlist_session_products')->select('product_id')->where("user_id", $user_id)->where("wishlist_id", $wishList->id)->get();

        //     return response()->json($wishLists, 200);
        // }
        if(count($wishLists) != 0){
            foreach ($wishLists as $wishList)
                $wishList->products = DB::table('wishlist_session_products')->select('product_id')->where("user_id", $user_id)->where("wishlist_id", $wishList->id)->get();

            return response()->json($wishLists, 200);
        }
    }
    return false;
}


/** @noinspection PhpUndefinedMethodInspection */
function edit_wishlist_sessions($data)
{
    $is_logged = is_logged();

    if (isset($data['title']) && strlen($data['title']) > 0 && $is_logged == true) {
        $user_id = user_id();
        DB::table('wishlist_sessions')
            ->where('user_id', $user_id)
            ->where('name' , $data['titlehide'])
            ->update(['name' => $data['title']]);
        // DB::table('wishlist_sessions')->insert(array('user_id' => $user_id, "name" => $data['title']));
        return DB::table('wishlist_sessions')->where('user_id', $user_id)->get();
    }
    return false;
}

/** @noinspection PhpUndefinedMethodInspection */
function delete_wishlist_sessions($data)
{

    // dd($data);
    $is_logged = is_logged();

    if (isset($data['name']) && strlen($data['name']) > 0 && $is_logged == true) {
        $user_id = user_id();

        $id=DB::table('wishlist_sessions')
            ->where('user_id', $user_id)
            ->where('name' , $data['name'])
            ->first()->id;

        DB::table('wishlist_session_products')
            ->where('wishlist_id','=',$id)
            ->delete();


        DB::table('wishlist_sessions')
            ->where('user_id', $user_id)
            ->where('name' , $data['name'])
            ->delete();

        // DB::table('wishlist_sessions')->insert(array('user_id' => $user_id, "name" => $data['title']));
        return DB::table('wishlist_sessions')->where('user_id', $user_id)->get();
    }
    return false;
}

function guest_checkout($dataa)
{

    $product_ids = $dataa['iid'];
    $user_id = user_id();
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 24; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    $ins_array = array(
        'products_id' => $product_ids,
        'user_id' => $user_id,
        'slug' => $randomString,
    );



    DB::table('quick_checkout')->insert($ins_array);

//    if (url_segment(0) == 'shop') {
    $url = site_url() . 'checkout?slug=' . $randomString;
//    } else {

//        $url = site_url() .$dataa['lang']. '/checkout?slug=' . $randomString;
//    }



    return [
        'success' => true,
        'url' => $url
    ];
}

/** @noinspection PhpUndefinedMethodInspection */
function set_wishlist_sessions($data)
{
    $is_logged = is_logged();

    if (isset($data['title']) && strlen($data['title']) > 0 && $is_logged == true) {
        $user_id = user_id();
        DB::table('wishlist_sessions')->insert(array('user_id' => $user_id, "name" => $data['title']));
        return DB::table('wishlist_sessions')->where('user_id', $user_id)->get();
    }
    return false;
}

/** @noinspection PhpUndefinedMethodInspection */
function add_wishlist_sessions($data)
{
//    dd($data);
    $is_logged = is_logged();
    if ($is_logged == true) {
        $productId = $data['productId'];
        $sessionId = $data['sessionId'];
        $user_id = user_id();

        try {
            DB::table("wishlist_session_products")->updateOrInsert(["user_id" => $user_id, "product_id" => $productId, "wishlist_id" => $sessionId]);
            $wishLists = DB::table("wishlist_sessions")->where("user_id", $user_id)->get();
            foreach ($wishLists as $wishList)
                $wishList->products = DB::table('wishlist_session_products')->select('product_id')->where("user_id", $user_id)->where("wishlist_id", $wishList->id)->get();
        } catch (\Exception $exception) {
            $wishLists = DB::table("wishlist_sessions")->where("user_id", $user_id)->get();
            foreach ($wishLists as $wishList)
                $wishList->products = DB::table('wishlist_session_products')->select('product_id')->where("user_id", $user_id)->where("wishlist_id", $wishList->id)->get();
        }
        new_wishlists();
        return response()->json($wishLists, 200);
    }

    return response()->json([], 401);
}

function share_wishlist($data){
    $product_ids = implode(',',$data['products']);
    $user_id = $data['user_id'];

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 24; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    $ins_array=array(
        'products_id'=>$product_ids,
        'user_id'=>$user_id,
        'slug'=>$randomString,
    );

    DB::table('wishlist_link')->insert($ins_array);


    return [
        'success' => true,
        'url' => site_url().'shop?slug='.$randomString
    ];
}

/** @noinspection PhpUndefinedMethodInspection */
function remove_wishlist_sessions($data)
{
//    dd($data);
    if($data){
        $is_logged = is_logged();
        if ($is_logged == true) {
            $productId = $data['productId'];
            $sessionId = $data['sessionId'];
            $user_id = user_id();

            if($sessionId == 'all'){
                DB::table("wishlist_session_products")->where("user_id", $user_id)->where("product_id", $productId)->delete();

            }

            DB::table("wishlist_session_products")->where("user_id", $user_id)->where("product_id", $productId)->where("wishlist_id", $sessionId)->delete();

            $wishLists = DB::table("wishlist_sessions")->where("user_id", $user_id)->get();
            foreach ($wishLists as $wishList)
                $wishList->products = DB::table('wishlist_session_products')->select('product_id')->where("user_id", $user_id)->where("wishlist_id", $wishList->id)->get();

            return response()->json($wishLists, 200);
        }

        return response()->json([], 401);
    }
}

/** @noinspection PhpUndefinedMethodInspection
 * @noinspection PhpUnusedParameterInspection
 * @param $request
 * @return false|string|Response
 */
function store_update_products($request)
{
    $responseData = array();
    $headers = apache_request_headers();
    $user = null;
    foreach ($headers as $header => $value) {
        if ($header == "Authorization") {
            $token = explode(" ", $value);
            $originalToken = explode(":", base64_decode($token[1]));
            $username = $originalToken[0];
            $password = $originalToken[1];

            $user = DB::table("users")->where("email", $username)->first();

            if ($user == null || !Hash::check($password, $user->password)) return response(array(["message" => "Invalid user"]), 401);
        }
    }

    $request = json_decode(file_get_contents("php://input"), true);

    $responseData["request"] = $request;

    if ($user !== null) {
        $message = array();

        if (!isset($request["title"]) || strlen(trim($request["title"])) < 1) $message["title"] = "title is required";
        if (!isset($request["qty"]) || strlen(trim($request["qty"])) < 1) $message["qty"] = "qty is required";
        else if (!strlen(trim($request["qty"])) > 0 || !is_numeric(trim($request["qty"]))) $message["qty"] = "qty is numeric";
        if (!isset($request["ean"]) || strlen(trim($request["ean"])) < 1) $message["ean"] = "ean is required";
        else if (!strlen(trim($request["ean"])) > 0 || !is_numeric(trim($request["ean"]))) $message["ean"] = "ean is numeric";
        if (!isset($request["is_free_shipping"]) || strlen(trim($request["is_free_shipping"])) < 1) $message["is_free_shipping"] = "is_free_shipping is required";
        else if (!strlen(trim($request["is_free_shipping"])) > 0 || !(trim($request["is_free_shipping"]) === "y" || trim($request["is_free_shipping"]) === "n")) $message["is_free_shipping"] = "is_free_shipping must be enum (\"y\", \"n\")";
        if (isset($request["additional_shipping_cost"]) && (!strlen(trim($request["additional_shipping_cost"])) > 0 || !is_numeric(trim($request["additional_shipping_cost"])))) $message["additional_shipping_cost"] = "additional_shipping_cost is numeric";
        if (isset($request["shipping_depth"]) && (!strlen(trim($request["shipping_depth"])) > 0 || !is_numeric(trim($request["shipping_depth"])))) $message["shipping_depth"] = "shipping_depth is numeric";
        if (isset($request["shipping_weight"]) && (!strlen(trim($request["shipping_weight"])) > 0 || !is_numeric(trim($request["shipping_weight"])))) $message["shipping_weight"] = "shipping_weight is numeric";
        if (isset($request["shipping_height"]) && (!strlen(trim($request["shipping_height"])) > 0 || !is_numeric(trim($request["shipping_height"])))) $message["shipping_height"] = "shipping_height is numeric";
        if (isset($request["shipping_width"]) && (!strlen(trim($request["shipping_width"])) > 0 || !is_numeric(trim($request["shipping_width"])))) $message["shipping_width"] = "shipping_width is numeric";
        if (isset($request["max_qty_per_order"]) && (!strlen(trim($request["max_qty_per_order"])) > 0 || !is_numeric(trim($request["max_qty_per_order"])))) $message["max_qty_per_order"] = "max_qty_per_order is numeric";
        if (isset($request["sku"]) && (!strlen(trim($request["sku"])) > 0 || !is_numeric(trim($request["sku"])))) $message["sku"] = "sku is numeric";

        if (count($message) > 0) return response()->json($message, 422);

        $product = DB::table("content")->where("created_by", $user->id)->where("ean", $request["ean"])->first();

        $responseData["product"] = $product;

        if ($product == null) {
            $shopId = DB::table("content")->select("id")->where("is_shop", 1)->first()->id;
            $maxPosition = DB::table("content")->where("content_type", "product")->where("subtype", "product")->max("position");

            $currentTime = Carbon\Carbon::now();

            try {
                DB::table("content")->insert(["content_type" => "product", "subtype" => "product", "url" => slugify($request["title"]), "title" => $request["title"], "parent" => $shopId ?? 8, "description" => $request["description"] ?? "", "position" => $maxPosition ? intval($maxPosition) + 1 : 0, "content" => $request["title"], "content_body" => $request["description"] ?? "", "content_meta_title" => $request["content_meta_title"] ?? "", "updated_at" => $currentTime->toDateTimeString(), "created_at" => $currentTime->toDateTimeString(), "created_by" => $user->id, "edited_by" => $user->id, "posted_at" => $currentTime->toDateTimeString(), "ean" => intval($request["ean"])]);
                $product = DB::table("content")->where("created_by", $user->id)->where("ean", $request["ean"])->get()->first();
                $responseData["product"] = $product;
            } catch (Exception $exception) {
                $responseData["product"] = $exception->getMessage();
            }
        } else {
            $currentTime = Carbon\Carbon::now();
            DB::table("content")->where('id', $product->id)->update(["url" => slugify($request["title"]), "title" => $request["title"], "parent" => $shopId ?? 8, "description" => $request["description"] ?? "", "content" => $request["title"], "content_body" => $request["description"] ?? "", "content_meta_title" => $request["content_meta_title"] ?? "", "updated_at" => $currentTime->toDateTimeString(), "edited_by" => $user->id,]);
            $product = DB::table("content")->where("created_by", $user->id)->where("ean", $request["ean"])->get()->first();
            $responseData["product"] = $product;
        }

        /*
//        if (isset($request["categories"])) {
//            $categories = $request["categories"];
//            if (count($categories) > 0) {
//                DB::table("categories_items")->where("rel_id", $responseData['product']->id)->delete();
//                $shopId = DB::table("content")->select("id")->where("is_shop", 1)->first()->id;
//                foreach ($categories as $category) {
//                    $existingCategory = DB::table("categories")->where("rel_id", $shopId)->where("data_type", "category")->where("title", $category)->get()->first();
//                    if ($existingCategory == null) {
////                        save_category(array("id" => "0", "rel" => "content", "rel_id" => $shopId, "data_type" => "category", "parent_id" => "0", "title" => $category, "category" => "parent-selector: ${shopId}", "description" => $category, "users_can_create_content" => "0", "category_subtype" => "default"));
//                        $currentTime = Carbon\Carbon::now();
//                        DB::table("categories")->insert(["updated_at" => $currentTime->toDateTimeString(), "created_at" => $currentTime->toDateTimeString(), "created_by" => $user->id, "edited_by" => $user->id, "data_type" => "category", "title" => $category, "url" => slugify($category), "parent_id" => 0, "rel_type" => "content", "rel_id" => $shopId, "position" => 0, "users_can_create_content" => 0, "category_subtype" => "default"]);
//                        $existingCategory = DB::table("categories")->where("rel_id", $shopId)->where("data_type", "category")->where("title", $category)->get()->first();
//                        DB::table("categories_items")->insert(["parent_id" => $existingCategory->id, "rel_type" => "content", "rel_id" => $responseData['product']->id]);
//                    } else {
//                        DB::table("categories_items")->insert(["parent_id" => $existingCategory->id, "rel_type" => "content", "rel_id" => $responseData['product']->id]);
//                    }
//                }
//                $responseData["categories"] = DB::table("categories_items")->where("rel_id", $responseData['product']->id)->get();
//            }
//        }
        */

        if (isset($request["categories"])) {
            $requestedCategories = $request["categories"];
            DB::table("categories_items")->where("rel_id", $responseData['product']->id)->delete();
            $shopId = DB::table("content")->select("id")->where("is_shop", 1)->first()->id;
            foreach ($requestedCategories as $requestedCategory) {
                if (strpos($requestedCategory, '>') !== false) {
                    $hiddenArray = explode('>', $requestedCategory);

                    $categoryId = createOrUpdateCategory($user->id, trim($hiddenArray[0]), $shopId);
                    createOrUpdateCategoryItem($categoryId, $responseData['product']->id);
                    $categoryId = createOrUpdateCategory($user->id, trim($hiddenArray[1]), $categoryId);
                    createOrUpdateCategoryItem($categoryId, $responseData['product']->id);
                } else if (strpos($requestedCategory, ' - ') !== false) {
                    $hiddenArray = explode(' - ', $requestedCategory);

                    $categoryId = createOrUpdateCategory($user->id, trim($hiddenArray[0]), $shopId);
                    createOrUpdateCategoryItem($categoryId, $responseData['product']->id);
                    $categoryId = createOrUpdateCategory($user->id, trim($hiddenArray[1]), $categoryId);
                    createOrUpdateCategoryItem($categoryId, $responseData['product']->id);
                } else {
                    $categoryId = createOrUpdateCategory($user->id, trim($requestedCategory), $shopId);
                    createOrUpdateCategoryItem($categoryId, $responseData['product']->id);
                }
            }

            $responseData["categories"] = DB::table("categories_items")->where("rel_type", "content")->where("rel_id", $responseData['product']->id)->get();
        }


        if (isset($request["filename"])) {
            $files = explode(",", $request["filename"]);
            DB::table("media")->where("created_by", $user->id)->where("rel_type", "content")->where("rel_id", intval($responseData["product"]->id))->where("media_type", "picture")->delete();
            foreach ($files as $file) {
                DB::table("media")->insert(["updated_at" => $currentTime->toDateTimeString(), "created_at" => $currentTime->toDateTimeString(), "edited_by" => $user->id, "created_by" => $user->id, "rel_type" => "content", "rel_id" => intval($responseData["product"]->id), "media_type" => "picture", "position" => 9999999, "filename" => $file,]);
            }
            $responseData["media"] = DB::table("media")->where("created_by", $user->id)->where("rel_type", "content")->where("rel_id", intval($responseData["product"]->id))->where("media_type", "picture")->get();
        }

        if (isset($request["qty"])) {
            $prev = DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "qty")->get()->first();
            if ($prev == null) {
                DB::table("content_data")->insert(["content_id" => intval($responseData["product"]->id), "field_name" => "qty", "field_value" => $request["qty"], "created_by" => $user->id, "edited_by" => $user->id, "rel_type" => "content", "rel_id" => intval($responseData["product"]->id)]);
            } else {
                DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "qty")->update(["field_value" => $request["qty"], "edited_by" => $user->id]);
            }
            $responseData["qty"] = DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "qty")->get()->first();
        }
        if (isset($request["sku"])) {
            $prev = DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "sku")->get()->first();
            if ($prev == null) {
                DB::table("content_data")->insert(["content_id" => intval($responseData["product"]->id), "field_name" => "sku", "field_value" => $request["sku"], "created_by" => $user->id, "edited_by" => $user->id, "rel_type" => "content", "rel_id" => intval($responseData["product"]->id)]);
            } else {
                DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "sku")->update(["field_value" => $request["sku"], "edited_by" => $user->id]);
            }
            $responseData["sku"] = DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "sku")->get()->first();
        }
        if (isset($request["shipping_weight"])) {
            $prev = DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "shipping_weight")->get()->first();
            if ($prev == null) {
                DB::table("content_data")->insert(["content_id" => intval($responseData["product"]->id), "field_name" => "shipping_weight", "field_value" => $request["shipping_weight"], "created_by" => $user->id, "edited_by" => $user->id, "rel_type" => "content", "rel_id" => intval($responseData["product"]->id)]);
            } else {
                DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "shipping_weight")->update(["field_value" => $request["shipping_weight"], "edited_by" => $user->id]);
            }
            $responseData["shipping_weight"] = DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "shipping_weight")->get()->first();
        }
        if (isset($request["shipping_width"])) {
            $prev = DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "shipping_width")->get()->first();
            if ($prev == null) {
                DB::table("content_data")->insert(["content_id" => intval($responseData["product"]->id), "field_name" => "shipping_width", "field_value" => $request["shipping_width"], "created_by" => $user->id, "edited_by" => $user->id, "rel_type" => "content", "rel_id" => intval(intval($responseData["product"]->id))]);
            } else {
                DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "shipping_width")->update(["field_value" => $request["shipping_width"], "edited_by" => $user->id]);
            }
            $responseData["shipping_width"] = DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "shipping_width")->get()->first();
        }
        if (isset($request["shipping_height"])) {
            $prev = DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "shipping_height")->get()->first();
            if ($prev == null) {
                DB::table("content_data")->insert(["content_id" => intval($responseData["product"]->id), "field_name" => "shipping_height", "field_value" => $request["shipping_height"], "created_by" => $user->id, "edited_by" => $user->id, "rel_type" => "content", "rel_id" => intval($responseData["product"]->id)]);
            } else {
                DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "shipping_height")->update(["field_value" => $request["shipping_height"], "edited_by" => $user->id]);
            }
            $responseData["shipping_height"] = DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "shipping_height")->get()->first();
        }
        if (isset($request["shipping_depth"])) {
            DB::table("content_data")->updateOrInsert(["content_id" => intval($responseData["product"]->id), "field_name" => "shipping_depth"], ["content_id" => intval($responseData["product"]->id), "field_name" => "shipping_depth", "field_value" => $request["shipping_depth"], "created_by" => $user->id, "edited_by" => $user->id, "rel_type" => "content", "rel_id" => intval($responseData["product"]->id)]);
//            $prev = DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "shipping_depth")->get()->first();
//            if ($prev == null) {
//                DB::table("content_data")->insert(["content_id" => intval($responseData["product"]->id), "field_name" => "shipping_depth", "field_value" => $request["shipping_depth"], "created_by" => $user->id, "edited_by" => $user->id, "rel_type" => "content", "rel_id" => intval($responseData["product"]->id)]);
//            } else {
//                DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "shipping_depth")->update(["field_value" => $request["shipping_depth"], "edited_by" => $user->id]);
//            }
            $responseData["shipping_depth"] = DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "shipping_depth")->get()->first();
        }
        if (isset($request["is_free_shipping"])) {
            $prev = DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "is_free_shipping")->get()->first();
            if ($prev == null) {
                DB::table("content_data")->insert(["content_id" => intval($responseData["product"]->id), "field_name" => "is_free_shipping", "field_value" => $request["is_free_shipping"], "created_by" => $user->id, "edited_by" => $user->id, "rel_type" => "content", "rel_id" => intval($responseData["product"]->id)]);
            } else {
                DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "is_free_shipping")->update(["field_value" => $request["is_free_shipping"], "edited_by" => $user->id]);
            }
            $responseData["is_free_shipping"] = DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "is_free_shipping")->get()->first();
        }
        if (isset($request["additional_shipping_cost"])) {
            $prev = DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "additional_shipping_cost")->get()->first();
            if ($prev == null) {
                DB::table("content_data")->insert(["content_id" => intval($responseData["product"]->id), "field_name" => "additional_shipping_cost", "field_value" => $request["additional_shipping_cost"], "created_by" => $user->id, "edited_by" => $user->id, "rel_type" => "content", "rel_id" => intval($responseData["product"]->id)]);
            } else {
                DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "additional_shipping_cost")->update(["field_value" => $request["additional_shipping_cost"], "edited_by" => $user->id]);
            }
            $responseData["additional_shipping_cost"] = DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "additional_shipping_cost")->get()->first();
        }
        if (isset($request["max_qty_per_order"])) {
            $prev = DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "max_qty_per_order")->get()->first();
            if ($prev == null) {
                DB::table("content_data")->insert(["content_id" => intval($responseData["product"]->id), "field_name" => "max_qty_per_order", "field_value" => $request["max_qty_per_order"], "created_by" => $user->id, "edited_by" => $user->id, "rel_type" => "content", "rel_id" => intval($responseData["product"]->id)]);
            } else {
                DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "max_qty_per_order")->update(["field_value" => $request["max_qty_per_order"], "edited_by" => $user->id]);
            }
            $responseData["max_qty_per_order"] = DB::table("content_data")->where("content_id", intval($responseData["product"]->id))->where("field_name", "max_qty_per_order")->get()->first();
        }

        if (isset($request["price"])) {
            $existingCustomFields = DB::table("custom_fields")->where("rel_type", "content")->where("rel_id", intval($responseData["product"]->id))->where("type", "price")->where("name", "price")->where("name_key", "price")->get()->first();
            if ($existingCustomFields == null) {
                DB::table("custom_fields")->insert(["rel_type" => "content", "rel_id" => intval($responseData["product"]->id), "type" => "price", "name" => "price", "name_key" => "price", "created_by" => $user->id, "edited_by" => $user->id, "is_active" => 1]);
            }
            $existingCustomFields = DB::table("custom_fields")->where("rel_type", "content")->where("rel_id", intval($responseData["product"]->id))->where("type", "price")->where("name", "price")->where("name_key", "price")->get()->first();
            $existingCustomFieldsValues = DB::table("custom_fields_values")->where("custom_field_id", $existingCustomFields->id)->get()->first();
            if ($existingCustomFieldsValues == null) {
                DB::table("custom_fields_values")->insert(["custom_field_id" => $existingCustomFields->id, "value" => $request['price'], "position" => 0]);
            } else {
                DB::table("custom_fields_values")->where("custom_field_id", $existingCustomFields->id)->update(["value" => $request['price']]);
            }
            $responseData["price"] = DB::table("custom_fields_values")->where("custom_field_id", $existingCustomFields->id)->get()->first();
        }

        if (isset($request["tags"])) {
            $requestTags = explode(",", $request["tags"]);
            $allPrevTags = DB::table("tagging_tagged")->where("taggable_type", "Content")->where("taggable_id", intval($responseData["product"]->id))->get();
            if (count($allPrevTags) > 0) {
                foreach ($allPrevTags as $allPrevTag) {
                    $suggestibleTag = DB::table('tagging_tags')->where('name', $allPrevTag->tag_name)->get()->first();
                    if ($suggestibleTag != null) {
                        DB::table('tagging_tags')->where('name', $allPrevTag->tag_name)->update(["count" => intval($suggestibleTag->count) - 1]);
                    }
                }
                DB::table("tagging_tagged")->where("taggable_type", "Content")->where("taggable_id", intval($responseData["product"]->id))->delete();
            }

            if (count($requestTags) > 0) {
                foreach ($requestTags as $requestTag) {
                    if ($requestTag[0] == '#') $requestTag = substr($requestTag, 1, strlen($requestTag) - 1);
                    $suggestibleTag = DB::table('tagging_tags')->where('name', $requestTag)->get()->first();
                    if ($suggestibleTag != null) {
                        DB::table('tagging_tags')->where('name', $requestTag)->update(["count" => intval($suggestibleTag->count) + 1]);
                    } else {
                        DB::table('tagging_tags')->insert(["slug" => slugify($requestTag), "name" => $requestTag, "description" => null, "suggest" => 0, "count" => 1]);
                    }
                    DB::table("tagging_tagged")->insert(["taggable_id" => intval($responseData["product"]->id), "taggable_type" => "Content", "tag_name" => $requestTag, "tag_slug" => slugify($requestTag), "tag_description" => null]);
                }
            }

            $responseData["tags"] = DB::table("tagging_tagged")->where("taggable_type", "Content")->where("taggable_id", intval($responseData["product"]->id))->get();
        }

        app()->log_manager->save('');

        return response()->json($responseData);
    } else {
        return response(array(["message" => "Invalid user"]), 401);
    }
}

/**
 * @param $userId integer
 * @param $title string
 * @param $relId integer
 * @return integer
 * @noinspection PhpUndefinedMethodInspection
 */
function createOrUpdateCategory(int $userId, string $title, int $relId)
{
    $existingCategory = DB::table("categories")->where("rel_id", $relId)->where("data_type", "category")->where("title", $title)->get()->first();
    if ($existingCategory) {
        return $existingCategory->id;
    } else {
        $currentTime = Carbon\Carbon::now();
        return DB::table("categories")->insertGetId(["created_by" => $userId, "edited_by" => $userId, "title" => $title, "url" => slugify($title), "rel_id" => $relId, "parent_id" => 0, "rel_type" => "content", "position" => 0, "users_can_create_content" => 0, "category_subtype" => "default", "updated_at" => $currentTime->toDateTimeString(), "created_at" => $currentTime->toDateTimeString(), "data_type" => "category"]);
    }
}

/**
 * @param $categoryId integer
 * @param $productId integer
 * @return void
 * @noinspection PhpUndefinedMethodInspection
 */
function createOrUpdateCategoryItem(int $categoryId, int $productId)
{
    $existingCategoryItem = DB::table("categories_items")->where("parent_id", $categoryId)->where("rel_type", "content")->where("rel_id", $productId)->get()->first();
    if (!$existingCategoryItem) {
        return DB::table("categories_items")->insert(["parent_id" => $categoryId, "rel_type" => "content", "rel_id" => $productId]);
    }
    return;
}

/** @noinspection SpellCheckingInspection */
function slugify($text)
{
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    if (empty($text)) return 'n-a';
    return $text;
}

/**
 * @param $params
 *
 * @return void
 * @noinspection PhpUndefinedMethodInspection
 */
function update_product_drm($params)
{
    $productId = $params['id'];
    $conditionalUpdate = array();

    $content = DB::table("content")->where("id", intval($productId))->get()->first();

    $conditionalUpdate["title"] = $content->title;
    $conditionalUpdate["description"] = $content->content_body;
    $conditionalUpdate["status"] = $content->is_active;

    $images = DB::table("media")->select("filename")->where("rel_id", $productId)->get();
    if (count($images) > 0) {
        $imagesArray = array();
        foreach ($images as $item) {
            $site_url = site_url();
            $array = [str_replace("{SITE_URL}", $site_url, $item->filename)];
            array_push($imagesArray, $array[0]);
        }
        $conditionalUpdate["image"] = $imagesArray;
    }

    $priceField = DB::table("custom_fields")->where("rel_id", $productId)->where("type", "price")->select('id')->get()->first();
    if ($priceField->id > 0) {
        $priceFieldValue = DB::table("custom_fields_values")->where("custom_field_id", $priceField->id)->select("value")->get()->first();
        $conditionalUpdate["vk_price"] = $priceFieldValue->value;
    }

    $tagged = DB::table('tagging_tagged')->where("taggable_id", $productId)->get();
    if (count($tagged) > 0) {
        $tags = array();
        foreach ($tagged as $item) {
            $array = [$item->tag_name];
            array_push($tags, $array[0]);
        }
        $conditionalUpdate["tags"] = implode(",", $tags);
    }

    $contentData = DB::table("content_data")->where("content_id", $productId)->get();

    if (count($contentData) > 0) {
        $size = array();
        foreach ($contentData as $contentDatum) {
            if ($contentDatum->field_name == 'qty') $conditionalUpdate["stock"] = $contentDatum->field_value;
            if ($contentDatum->field_name == 'sku') $conditionalUpdate["sku"] = $contentDatum->field_value;
            if ($contentDatum->field_name == 'shipping_weight') $conditionalUpdate["item_weight"] = $contentDatum->field_value;
            if ($contentDatum->field_name == 'shipping_height') array_push($size, $contentDatum->field_value);
            if ($contentDatum->field_name == 'shipping_width') array_push($size, $contentDatum->field_value);
            if ($contentDatum->field_name == 'shipping_depth') array_push($size, $contentDatum->field_value);
            if ($contentDatum->field_name == 'label-color') $conditionalUpdate["item_color"] = $contentDatum->field_value;
        }

        $conditionalUpdate["item_size"] = implode("x", $size);
    }

    if (count($conditionalUpdate) > 0 && $content->ean) {
        $client = new Client();
        $client->request("PUT", "http://165.227.134.199/api/v1/catalogs/products/" . $content->ean . "/update?country=1", [
            "headers" => [
                "content-type" => "application/json",
                "Authorization" => "Bearer " . config("global.token_dp"),
            ],
            "json" => $conditionalUpdate,
        ]);
    }
}

function filter_wishlist(){
    dd($_REQUEST);
}
api_expose("config_set_drm");
function config_set_drm($data){

    Config::set('microweber.userToken', $data['userToken']);
    Config::set('microweber.userPassToken', $data['userPassToken']);
    Config::set('microweber.userName', $data['userName']);
    Config::save(array('microweber'));
}

api_expose("insert_info");
function insert_info(){
    $content = DB::table('content')->insertGetId([
        'content_type' => 'page',
        'subtype' => 'static',
        'url' => 'thank-you',

        'title' => 'Thank you',
        'parent' => '0',
        'description' => null,
        'position' => null,
        'content' => null,
        'content_body' => null,
        'is_active' => '1',
        'subtype_value' => null,
        'custom_type' => null,
        'custom_type_value' => null,
        'active_site_template' => 'default',
        'layout_file' => 'layouts__thank_you.php',
        'layout_name' => null,
        'layout_style' => null,
        'content_filename' => null,
        'original_link' => null,

        'is_home' => 0,
        'is_pinged' => 0,
        'is_shop' => 0,
        'is_deleted' => 0,

        'require_login' => 0,
        'status' => null,
        'content_meta_title' => null,
        'content_meta_keywords' => null,

        'session_id' => 'cOocZcbzbSIlEh7fyIiX0R2R8RKcS5tUm7u9caR4',
        'updated_at' => null,
        'created_at' => null,
        'expires_at' => null,

        'created_by' => '1',

        'edited_by' => '1',
        'posted_at' => 'dateTime',
        'draft_of' => null,
        'copy_of' => null,

        'ean' => null,
        'drm_ref_id' => null]);

    $upselling = DB::table('product_upselling')->insert([
        'serviceName' => 'Demo-Service',
        'servicePrice' => '5'
    ]);
    mw()->update->post_update();


    dd($content,$upselling);

}

api_expose("upselling_p");
function upselling_p(){
    $upselling = DB::table('product_upselling')->insert([
        'serviceName' => 'Beispiel: Geschenkverpackung',
        'servicePrice' => '5'
    ]);
    mw()->update->post_update();
}

api_expose("dt_drm");
function dt_drm(){
    if(isset($_POST['dt_drm'])) {
        $usertokenDrm = Config::get('microweber.userToken');
        $userpasstokenDrm = Config::get('microweber.userPassToken');

        dd($usertokenDrm, $userpasstokenDrm);
    }
}

api_expose("dt_database");
function dt_database(){
    if(isset($_POST['dt_database'])){
        $dt_db = Config::get('database.connections');
        dd($dt_db);
    }

}


api_expose('delete_dt_template');

function delete_dt_template($data){
    if(isset($data['dir'])){
        $dirname = base_path().'/'.$data['dir'];
        delete_dt_directory($dirname);
    }

}

function delete_dt_directory($dirname) {

    if (is_dir($dirname))
        $dir_handle = opendir($dirname);
    if (!$dir_handle)
        return false;
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
            else
                delete_dt_directory($dirname.'/'.$file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}


api_expose('delete_product_info');
function delete_product_info($id){
    // dd($id);
    $productInfo = DB::table('content')->where('id',$id['id'])->first();
    if(isset($productInfo) and isset($productInfo->content_type) and $productInfo->content_type=="product")  {
        $pId = DB::table('categories_items')->where('rel_id',$productInfo->id)->first();
        if($pId!= null) {
            $category = DB::table('categories')->where('id',$pId->parent_id)->first();
            // dd($productInfo->url);
            DB::table('delete_product_info')->insert([
                'product_url' => $productInfo->url,
                'category_url' => $category->url
            ]);
        } else {
            DB::table('delete_product_info')->insert([
                'product_url' => $productInfo->url,
                'category_url' => "null"
            ]);
        }
    }
}

api_expose('delete_products_info');
function delete_products_info($id){
    $total = count($id['id']);
    for ($i=0; $i < $total; $i++) {
        $productInfo = DB::table('content')->where('id',$id['id'][$i])->first();
        if(isset($productInfo->content_type) and $productInfo->content_type=="product")  {
            $pId = DB::table('categories_items')->where('rel_id',$productInfo->id)->first();
            if($pId!= null) {
                $category = DB::table('categories')->where('id',$pId->parent_id)->first();
                // dd($productInfo->url);
                DB::table('delete_product_info')->insert([
                    'product_url' => $productInfo->url,
                    'category_url' => $category->url
                ]);
            } else {
                DB::table('delete_product_info')->insert([
                    'product_url' => $productInfo->url,
                    'category_url' => "null"
                ]);
            }
        }
    }
}


api_expose('remove_delete_product_info');
function remove_delete_product_info($id){
    $url = DB::table('content')->where('id', $id['id'])->first();
    DB::table("delete_product_info")->where('product_url', $url->url)->delete();
}

api_expose('remove_delete_products_info');
function remove_delete_products_info($id){
    $total = count($id['id']);
    for ($i=0; $i < $total; $i++) {
        $url = DB::table('content')->where('id', $id['id'][$i])->first();
        DB::table("delete_product_info")->where('product_url', $url->url)->delete();
    }

}


//start legals modules function


api_expose('upimprint');
function upimprint($data){

    $inaray= array(
        'term_name' => 'imprint',
        'description' => $data['imprint'],

    );
    DB::table('legals')->where('term_name','imprint')->update(
        array(
            'description' => $data['imprint']
        )
    );
    return back();




}

api_expose('uppp');
function uppp($data){


    $inaray1= array(
        'term_name' => 'pp',
        'description' => $data['pp'],

    );
    DB::table('legals')->where('term_name','pp')->update(
        array(
            'description' => $data['pp']
        )
    );
    return back();




}
api_expose('upagb');
function upagb($data){


    $inaray2= array(
        'term_name' => 'agb',
        'description' => $data['agb'],

    );
    DB::table('legals')->where('term_name','agb')->update(
        array(
            'description' => $data['agb']
        )
    );
    return back();



}
api_expose('upcancle');
function upcancle($data){


    $inaray3= array(
        'term_name' => 'cancle',
        'description' => $data['cancle'],

    );
    DB::table('legals')->where('term_name','cancle')->update(
        array(
            'description' => $data['cancle']
        )
    );
    return back();




}
api_expose('uppayment');
function uppayment($data){


    $inaray4= array(
        'term_name' => 'payment',
        'description' => $data['payment'],

    );
    DB::table('legals')->where('term_name','payment')->update(
        array(
            'description' => $data['payment']
        )
    );
    return back();



}
api_expose('upshipping');
function upshipping($data){


    $inaray7= array(
        'term_name' => 'shipping',
        'description' => $data['shipping'],

    );
    DB::table('legals')->where('term_name','shipping')->update(
        array(
            'description' => $data['shipping']
        )
    );
    \Cache::forget('legals_shipping');
    return back();




}
api_expose('upinfoo');
function upinfoo($data){


    $inaray5= array(
        'term_name' => 'info',
        'description' => $data['infoo'],

    );
    DB::table('legals')->where('term_name','info')->update(
        array(
            'description' => $data['info']
        )
    );
    return back();




}
api_expose('upnote');
function upnote($data){


    $inaray6= array(
        'term_name' => 'note',
        'description' => $data['note'],

    );
    DB::table('legals')->where('term_name','note')->update(
        array(
            'description' => $data['note']
        )
    );
    return back();




}



api_expose('imprint');
function imprint($data){


    $inaray= array(
        'term_name' => 'imprint',
        'description' => $data['imprint'],

    );
    DB::table('legals')->insert($inaray);
    return back();




}

api_expose('pp');
function pp($data){


    $inaray1= array(
        'term_name' => 'pp',
        'description' => $data['pp'],

    );
    DB::table('legals')->insert($inaray1);
    return back();




}
api_expose('agb');
function agb($data){


    $inaray2= array(
        'term_name' => 'agb',
        'description' => $data['agb'],

    );
    DB::table('legals')->insert($inaray2);
    return back();




}
api_expose('cancle');
function cancle($data){


    $inaray3= array(
        'term_name' => 'cancle',
        'description' => $data['cancle'],

    );
    DB::table('legals')->insert($inaray3);
    return back();




}
api_expose('payment');
function payment($data){


    $inaray4= array(
        'term_name' => 'payment',
        'description' => $data['payment'],

    );
    DB::table('legals')->insert($inaray4);
    return back();




}
api_expose('shipping');
function shipping($data){


    $inaray7= array(
        'term_name' => 'shipping',
        'description' => $data['shipping'],

    );
    DB::table('legals')->insert($inaray7);
    return back();




}
api_expose('infoo');
function infoo($data){


    $inaray5= array(
        'term_name' => 'info',
        'description' => $data['infoo'],

    );
    DB::table('legals')->insert($inaray5);
    return back();




}
api_expose('note');
function note($data){


    $inaray6= array(
        'term_name' => 'note',
        'description' => $data['note'],

    );
    DB::table('legals')->insert($inaray6);
    return back();

}

//end legals modules function


//Product quantity show or hide

api_expose('store_quantity_status');
function store_quantity_status($data){
    Config::set('custom.isShow', $data['isShow']);
    Config::set('custom.value', $data['value']);
    Config::save(array('custom'));
    // DB::table('quantity_status')->insert($data);
}

api_expose('remove_quantity_status');
function remove_quantity_status(){
    Config::set('custom.isShow', 'null');
    Config::save(array('custom'));
}

api_expose('update_quantity_status');
function update_quantity_status($data){
    // dd($data['value']);
    Config::set('custom.value', $data['value']);
    Config::save(array('custom'));
    // DB::table('quantity_status')->update($data);
}

api_expose('update_quantity_status_value');
function update_quantity_status_value($data){
    // dd($data['value']);
    Config::set('custom.value', $data['value']);
    Config::save(array('custom'));
    // DB::table('quantity_status')->update($data);
}

api_expose('cat_reset');
function cat_reset(){
    cat_reset_logic();
}

//End Product quantity show or hide

//tax rate crud

api_expose('save_taxs');
function save_taxs($data){
    DB::table('tax_rates')->insert($data);
}

api_expose('update_tax');
function update_tax($data){
    $has_data =  DB::table('tax_rates')->where('id', $data['id'])->get();
    if(count($has_data) > 0) {
        DB::table('tax_rates')->where('id', $data['id'])->update($data);
    }
}

api_expose('delete_tax');
function delete_tax($data){
    $has_data =  DB::table('tax_rates')->where('id', $data['id'])->get();
    if(count($has_data) > 0) {
        DB::table('tax_rates')->where('id', $data['id'])->delete();
    }
}

//Ecommerce tracking function call from shop.js
api_expose('ecommerce_tracking_add_cart');
function ecommerce_tracking_add_cart($data){
    $url_string = url()->previous();
    if(strpos($url_string, "thank-you") !== false){
        $product_rel = <<<EOD
        item_list_id: "Thank-You Page Upsell",
        item_list_name: "Thank-You Page Upsell",
        EOD;
    } elseif($url_string == site_url()){
        Config::set('custom.item_list', 'Homepage-products');
        Config::save(array('custom'));
        $product_rel = <<<EOD
        item_list_id: "Homepage-products",
        item_list_name: "Homepage Products",
        EOD;
    } else{
        Config::set('custom.item_list', null);
        Config::save(array('custom'));
        $product_rel = <<<EOD
        item_list_id: "related-products",
        item_list_name: "Related Products",
        EOD;
    }
    if(isset($data['id']['content_id'])){
        $id = $data['id']['content_id'];
    } else {
        $id = $data['id']['for_id'];
    }
    if(isset($id)){
        $item = DB::table('cart')->where('rel_id', $id)->where('order_completed', 0)->orderBy('id', 'desc')->first();
    }
    if($item){
        $param = array("id"=>$item->rel_id);
        $det = get_content($param);
        $price =  taxPrice($item->price);
        $price = $price + $item->price;
        $brand = $det[0]['brand'] ?? "";
        $weight = $det[0]['single_size'] ?? "";
        $coupon = "";
        $discount = "";
        $hasCoupon = DB::table('cart_coupons')->first();
        if($hasCoupon){
            $coupon =<<<EOD
            coupon: "{$hasCoupon->coupon_name}",
            EOD;
            $discount =<<<EOD
            discount: {$hasCoupon->discount_value},
            EOD;
        }
        $category = "";
        $cat = DB::table('categories_items')->where('rel_id', $id)->first();
        if($cat){
            $cat_details = DB::table('categories')->where('id', $cat->parent_id)->first();
            if($cat_details){
                $category = $cat_details->title;
            }
        }
        $item_data = <<<EOD
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('event', 'add_to_cart', {
            currency: "EUR",
            value: {$price},
            items: [
            {
                item_id: "{$item->rel_id}",
                item_name: "{$item->title}",
                affiliation: "Google Store",
                {$coupon}
                currency: "EUR",
                {$discount}
                index: {$item->rel_id},
                item_brand: "{$brand}",
                item_category: "{$category}",
                {$product_rel}
                item_variant: "{$weight}",
                price: {$price},
                quantity: {$item->qty}
            }
        ]
        });
        </script>
        EOD;
        // dd($item_data);
        return response()->json(['success' => true, 'message' => $item_data]);
    }

}




// start admin sortable menu function

api_expose('update_sortable_shop_menu');
function update_sortable_shop_menu($data){
    $positions = !empty($data['positions'])? $data['positions'] : [];
    $menu = $data['menutype'];

    foreach($positions as $key => $position) {
        DB::table('admin_shop_menu')->where('id', $position)->update(array('position' => $key, 'shortcut' => $menu));
    }
    return true;
}


api_expose('admin_shop_menu_update');
function admin_shop_menu_update(){
    if (Schema::hasTable('admin_shop_menu')) {
        $all_shop_menu_config = Config::get('admin_shop_menu');
        $admin_shop_menu_infos = DB::table('admin_shop_menu')->get();
        $menu_name_list = $admin_shop_menu_infos->pluck('name')->toArray();
        foreach($all_shop_menu_config as $shop_menu){
            $update_menu = array(
                'name' => $shop_menu['name'],
                'sub_name' => $shop_menu['sub_name'],
                'link' => $shop_menu['link'],
                'mw_link' => $shop_menu['mw_link'],
                'dt_link' => $shop_menu['dt_link'],
                'dt_temp_link' => $shop_menu['dt_temp_link'],
                'icon' =>$shop_menu['icon'],
                'img' => $shop_menu['img'],
                'active_name' => $shop_menu['active_name'],
                'module_name' => $shop_menu['module_name'],
                'data_link' => $shop_menu['data_link'],
                'data_title' => $shop_menu['data_title']
            );
            $new_menu = array(
                'shortcut' =>  $shop_menu['shortcut'],
                'position' =>  $shop_menu['position'],
                'name' => $shop_menu['name'],
                'sub_name' => $shop_menu['sub_name'],
                'link' => $shop_menu['link'],
                'mw_link' => $shop_menu['mw_link'],
                'dt_link' => $shop_menu['dt_link'],
                'dt_temp_link' => $shop_menu['dt_temp_link'],
                'icon' =>$shop_menu['icon'],
                'img' => $shop_menu['img'],
                'active_name' => $shop_menu['active_name'],
                'module_name' => $shop_menu['module_name'],
                'data_link' => $shop_menu['data_link'],
                'data_title' => $shop_menu['data_title']
            );
            // dd($shop_menu['name']);
            if(in_array($shop_menu['name'],$menu_name_list)){
                DB::table('admin_shop_menu')->where('name', $shop_menu['name'])->update($update_menu);
            }else{
                DB::table('admin_shop_menu')->insert($new_menu);
            }
        }
        $all_shop_menu_store = collect($all_shop_menu_config);
        foreach($admin_shop_menu_infos as $shop_menu_db){
            if(!$all_shop_menu_store->contains('name', $shop_menu_db->name)){
                DB::table("admin_shop_menu")->where('name',$shop_menu_db->name)->delete();
            }
        }
    }
}



api_expose('update_sortable_website_menu');
function update_sortable_website_menu($data){
    $positions = !empty($data['positions'])? $data['positions'] : [];
    $menu = $data['menutype'];

    foreach($positions as $key => $position) {
        DB::table('admin_website_menu')->where('id', $position)->update(array('position' => $key, 'shortcut' => $menu));
    }
    return true;
}

api_expose('admin_website_menu_update');
function admin_website_menu_update(){
    if (Schema::hasTable('admin_website_menu')) {
        $all_website_menu_config = Config::get('admin_website_menu');
        $admin_website_menu_infos = DB::table('admin_website_menu')->get();
        $menu_name_list = $admin_website_menu_infos->pluck('name')->toArray();
        foreach($all_website_menu_config as $website_menu){
            $update_menu = array(
                'name' => $website_menu['name'],
                'sub_name' => $website_menu['sub_name'],
                'link' => $website_menu['link'],
                'mw_link' => $website_menu['mw_link'],
                'dt_link' => $website_menu['dt_link'],
                'dt_temp_link' => $website_menu['dt_temp_link'],
                'icon' =>$website_menu['icon'],
                'img' => $website_menu['img'],
                'active_name' => $website_menu['active_name'],
                'module_name' => $website_menu['module_name'],
                'data_link' => $website_menu['data_link'],
                'data_title' => $website_menu['data_title'],
                'onclick' => $website_menu['onclick'],
            );
            $new_menu = array(
                'shortcut' =>  $website_menu['shortcut'],
                'position' =>  $website_menu['position'],
                'name' => $website_menu['name'],
                'sub_name' => $website_menu['sub_name'],
                'link' => $website_menu['link'],
                'mw_link' => $website_menu['mw_link'],
                'dt_link' => $website_menu['dt_link'],
                'dt_temp_link' => $website_menu['dt_temp_link'],
                'icon' =>$website_menu['icon'],
                'img' => $website_menu['img'],
                'active_name' => $website_menu['active_name'],
                'module_name' => $website_menu['module_name'],
                'data_link' => $website_menu['data_link'],
                'data_title' => $website_menu['data_title'],
                'onclick' => $website_menu['onclick'],
            );

            if(in_array($website_menu['name'],$menu_name_list)){
                DB::table('admin_website_menu')->where('name', $website_menu['name'])->update($update_menu);
            }else{
                DB::table('admin_website_menu')->insert($new_menu);
            }
        }
        $all_website_menu_store = collect($all_website_menu_config);
        foreach($admin_website_menu_infos as $website_menu_db){
            if(!$all_website_menu_store->contains('name', $website_menu_db->name)){
                DB::table("admin_website_menu")->where('name',$website_menu_db->name)->delete();
            }
        }
    }
}




//Start Google index Enable/Disable
api_expose("disableGoggleIndex_check");
function disableGoggleIndex_check($data){
    Config::set('custom.disableGoggleIndex',$data['check_index']);
    Config::save(array('custom'));
}

//End Google index Enable/Disable

api_expose('rss_link_option');
function rss_link_option($data)
{
    $option = array();
    $option['option_value'] = $data['option'];
    $option['option_key'] = 'rss_option';
    $option['option_group'] = 'rss_data';
    save_option($option);
}

api_expose('rss_xml_key');
function rss_xml_key($data)
{
    $rss_xml_Array = $data['rss_xml_Array'];
    $rss_key = array_keys($rss_xml_Array);
    return $rss_key;
}

api_expose('rss_xml_nested_key');
function rss_xml_nested_key($data)
{
    $type = $data['type'];
    $option = $data['option'];

    $rssArray = $data['rss_xml_Array'];
    $rss_key = false;

    if ($type == "image") {
        $rss_image_data = '';
        if ($data['rss_image_data'] == "") {
            $rss_image_data = $rssArray[$option];
            if (is_array($rss_image_data)) {
                $rss_key = array_keys($rss_image_data);
            }
        } else {
            $rss_image_data = $data['rss_image_data'][$option];
            if (is_array($rss_image_data)) {
                $rss_key = array_keys($rss_image_data);
            }
        }
        return [$rss_key, $rss_image_data];
    } elseif ($type == "desc") {
        $rss_desc_data = '';
        if ($data['rss_desc_data'] == "") {
            $rss_desc_data = $rssArray[$option];
            if (is_array($rss_desc_data)) {
                $rss_key = array_keys($rss_desc_data);
            }
        } else {
            $rss_desc_data = $data['rss_desc_data'][$option];
            if (is_array($rss_desc_data)) {
                $rss_key = array_keys($rss_desc_data);
            }
        }
        return [$rss_key, $rss_desc_data];
    } elseif ($type == "title") {
        $rss_title_data = '';
        if ($data['rss_title_data'] == "") {
            $rss_title_data = $rssArray[$option];
            if (is_array($rss_title_data)) {
                $rss_key = array_keys($rss_title_data);
            }
        } else {
            $rss_title_data = $data['rss_title_data'][$option];
            if (is_array($rss_title_data)) {
                $rss_key = array_keys($rss_title_data);
            }
        }
        return [$rss_key, $rss_title_data];
    } elseif ($type == "link") {
        $rss_link_data = '';
        if ($data['rss_link_data'] == "") {
            $rss_link_data = $rssArray[$option];
            if (is_array($rss_link_data)) {
                $rss_key = array_keys($rss_link_data);
            }
        } else {
            $rss_link_data = $data['rss_link_data'][$option];
            if (is_array($rss_link_data)) {
                $rss_key = array_keys($rss_link_data);
            }
        }
        return [$rss_key, $rss_link_data];
    }
}

api_expose('rss_xml_save');
function rss_xml_save($data)
{
    $image = $data['image'];
    $title = $data['title'];
    $desc = $data['desc'];
    $link = $data['link'];

    DB::table('content')->insert([
        'content_type' => 'post',
        'subtype' => 'post',
        'title' => $title,
        'content' => '<div class="element"><p align="justify" class="element" id="element_1566830896676">' . $desc . '</p></div>',
        'is_rss' => 1,
        'rss_image' => $image,
        'rss_link' => $link,
    ]);
    //start rss blog post save in blogs table
    $last_rss_post = DB::table('content')->where('content_type','post')->get()->last();
    $blog_information = array(
        'content_id' => $last_rss_post->id,
        'title' => $title,
        'content' => '<div class="element"><p align="justify" class="element" id="element_1566830896676">' . $desc . '</p></div>',
        'is_rss' => 1,
        'rss_link' => $link,
        'rss_image' => $image,
        'created_at' => $last_rss_post->created_at
    );
    insert_blog_information($blog_information);
    //end rss blog post save in blogs table
    return true;
}

api_expose('rss_xml_filter');
function rss_xml_filter($data)
{
    $blog_filter_option = $data['option'];
    $option = array();
    $option['option_value'] = $blog_filter_option;
    $option['option_key'] = 'blog_filter';
    $option['option_group'] = 'blog_filter_option';
    save_option($option);

    return true;
}


api_expose('insert_rss_xml_blog');
function insert_rss_xml_blog($data)
{

    $link = $data['rss_link'];
    $rssArray = [];

    try {
        $status = 2;
        $message = "URL does not match RSS 2.0. You need to map blogs.";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $xmlstr = curl_exec($ch);
        curl_close($ch);

        $xml = simplexml_load_string($xmlstr) ?? false;
        $json = json_encode($xml);
        $rssArray = json_decode($json, TRUE);

        $rssItem = $rssArray['channel']['item'] ?? null;
        if (isset($rssItem)) {
            foreach ($rssItem as $item) {
                $title = $item['title'] ?? '';
                if (is_array($title)) {
                    $title = '';
                }

                $content = $item['description'] ?? '';
                if (is_array($content)) {
                    $content = '';
                }

                $rss_link = $item['link'] ?? '';
                if (is_array($rss_link)) {
                    $rss_link = '';
                }

                $rss_image = $item['image'] ?? '';
                if (is_array($rss_image)) {
                    $rss_image = '';
                }

                $created_at = $item['pubDate'] ?? date('Y-m-d H:i:s');
                if (is_array($created_at)) {
                    $created_at = '';
                }

                DB::table('content')->insert([
                    'content_type' => 'post',
                    'subtype' => 'post',
                    'title' => $title,
                    'content' => '<div class="element"><p align="justify" class="element" id="element_1566830896676">' . $content . '</p></div>',
                    'created_at' => date("Y-m-d H:i:s", strtotime($created_at)),
                    'rss_link' => $rss_link,
                    'rss_image' => $rss_image,
                    'is_rss' => 1
                ]);
                //start rss blog post save in blogs table
                $last_rss_post = DB::table('content')->where('content_type','post')->get()->last();
                $blog_information = array(
                    'content_id' => $last_rss_post->id,
                    'title' => $title,
                    'content' => '<div class="element"><p align="justify" class="element" id="element_1566830896676">' . $content . '</p></div>',
                    'is_rss' => 1,
                    'rss_link' => $rss_link,
                    'rss_image' => $rss_image,
                    'created_at' => date("Y-m-d H:i:s", strtotime($created_at))
                );
                insert_blog_information($blog_information);
                //end rss blog post save in blogs table
            }
            $status = 1;
            $message = "RSS 2.0 blogs are inserted successfully.";
        }
        return [$status, $message, $rssArray];
    } catch (Exception $e) {
        $rssArray = [];
        $status = 3;
        $message = "This is not a valid RSS or XML URL";
        return [$status, $message, $rssArray];
    }
}

//generate_page_screenshot

api_expose("generate_page_screenshot");
function generate_page_screenshot($data){
    $page_info = db_get('table=content&id='.$data['Page_id'].'&single=true');
    if($page_info){
        $page_url = site_url().$page_info['url'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://drm.software/url2image?token=xvamc4s3wesses4f&height=1200&width=1000&target_url='.$page_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        if($response){
            $screenshot_path = 'userfiles/media/templates.microweber.com/live_screenshot-'.$data['Page_id'].'.jpg';
            // dd(file_get_contents($response));
            @file_put_contents($screenshot_path, file_get_contents($response));
            if(file_exists($screenshot_path)){
                $page_picture_info =array(
                    'rel_type' => 'content',
                    'rel_id' => 0,
                    'media_type' => 'picture',
                    'filename' => '{SITE_URL}'.$screenshot_path,
                    'title' => 'live_screenshot-'.$data['Page_id']
                );
                $page_picture_info_check_in_db = DB::table('media')->where('rel_id',0)->where('title','live_screenshot-'.$data['Page_id'])->first();
                if($page_picture_info_check_in_db){
                    $page_picture_info['id'] =  $page_picture_info_check_in_db->id;
                    db_save('media', $page_picture_info);
                }else{
                    db_save('media', $page_picture_info);
                }
            }
        }
    }
}

//content publish and unpublish

api_expose("unpublished");
function unpublished($data){
    DB::table('content')->where('id', $data['id'])->update(['is_active' => 0]);
    //start permanently delete the blog from blogs table
    delete_blog_information($data['id']);
    //end permanently delete the blog from blogs table
}

api_expose("published");
function published($data){
    DB::table('content')->where('id', $data['id'])->update(['is_active' => 1]);
    //start restore the blog from content table to blogs table
    $blog_from_content_table = DB::table('content')->where('id',$data['id'])->first();
    if($blog_from_content_table){
        $blog_image_link = get_first_position_image_from_media($data['id']);
        $blog_information = array(
            'title' => $blog_from_content_table->title,
            'content' => $blog_from_content_table->content,
            'link' => $blog_from_content_table->url,
            'image' => $blog_image_link,
            'is_rss' => $blog_from_content_table->is_rss,
            'rss_link' => $blog_from_content_table->rss_link,
            'rss_image' => $blog_from_content_table->rss_image,
            'created_at' => $blog_from_content_table->created_at,
            'updated_at' => $blog_from_content_table->updated_at
        );
        update_or_insert_blog_information($blog_from_content_table->id,$blog_information);
        //end restore the blog from content table to blogs table
    }
}



api_expose("unpublishedPage");
function unpublishedPage($data){
    $page_detail = DB::table('content')->where('id', $data['id'])->first();
    if($page_detail){
        DB::table('content')->where('id', $data['id'])->update(['is_active' => 0]);
        DB::table('menus')
        ->where('content_id', $data['id'])
        ->orWhere('title', $page_detail->title)
        ->orWhere('url' , "{SITE_URL}".$page_detail->url)
        ->update([
            'is_active' => 0
        ]);
    }
}


api_expose("publishedPage");
function publishedPage($data){

    $page_detail = DB::table('content')->where('id', $data['id'])->first();
    if($page_detail){
        DB::table('content')->where('id', $data['id'])->update(['is_active' => 1]);
        DB::table('menus')
        ->where('content_id', $data['id'])
        ->orWhere('title', $page_detail->title)
        ->orWhere('url' , "{SITE_URL}".$page_detail->url)
        ->update([
            'is_active' => 1
        ]);
    }
}


//end content publish and unpublish


api_expose('image_performance_on');
function image_performance_on(){
    $option = array();
    $option['option_value'] = 1;
    $option['option_key'] = 'img_compressor';
    $option['option_group'] = 'compressor';
    save_option($option);
}

api_expose('image_performance_off');
function image_performance_off(){
    $option = array();
    $option['option_value'] = 0;
    $option['option_key'] = 'img_compressor';
    $option['option_group'] = 'compressor';
    save_option($option);
}


// Subscription Product start from here

api_expose('save_subscription');
function save_subscription($data)
{
    DB::table('subscription_items')->insert($data);
}

api_expose('subscriptionDelete');
function subscriptionDelete($id)
{
    if(isset($id['delete']))
    {
        DB::table('subscription_items')->where('id',$id['delete'])->delete();
        return redirect()->back();
    }
    return redirect()->back();
}

api_expose('add_subscription_status');
function add_subscription_status($data)
{
    DB::table('subscription_status')->insert($data);
}

api_expose('delete_subscription_status');
function delete_subscription_status($id)
{
    // dd($id);
    DB::table('subscription_status')->where('sub_id',$id['sub_id'])->delete();
}

api_expose('delete_subscription_statuses');
function delete_subscription_statuses($id)
{
    // dd($id);
    DB::table('subscription_status')->where('product_id',$id['product_id'])->delete();
}

api_expose('save_sub_cart');
function save_sub_cart($data)
{
    $u_id = user_id();
    if(session_id() == ''){
        session_start();
     }
    $data['session_id'] = session_id();
    // dd($data);
	$option = array();
    $option['option_value'] = $data['session_id'];
    $option['option_key'] = 'session_id';
    $option['option_group'] = 'user_session';
    save_option($option);
	$date = date("Y-m-d h:i:s");
    $data['created_at'] = $date;
    $data['updated_at'] = $date;
    $status=DB::table('subscription_order_status')->where('order_id', null)->where('user_id', $u_id)->get()->all();
    if(count($status)>0){
        foreach ($status as $value) {
            if ($value->product_id == $data['product_id']) {
                DB::table('subscription_order_status')->where('order_id', null)->where('product_id', $data['product_id'])->delete();

            }
        }
        DB::table('subscription_order_status')->insert($data);

    }
    else{
        DB::table('subscription_order_status')->insert($data);
    }
}

api_expose('delete_sub_cart');
function delete_sub_cart($data)
{
    $pro_id = DB::table('cart')->where('id', $data['id'])->first();
    $rel_id = $pro_id->rel_id ?? null;
    if(isset($rel_id)){
        $sub_id = DB::table('subscription_order_status')->where('product_id', $pro_id->rel_id)->where('order_id', null)->first() ?? null;
        if ($sub_id != null) {
            DB::table('subscription_order_status')->where('id',$sub_id->id)->delete();
        }
    }

}

api_expose('update_subscription_order');
function update_subscription_order($data){
    DB::table('subscription_order_status')->where('id', $data['id'])->update(['subscription_id' => $data['sub_id']]);
}

api_expose('delete_sub_session');
function delete_sub_session(){
    $option = array();
    $option['option_value'] = null;
    $option['option_key'] = 'session_id';
    $option['option_group'] = 'user_session';
    save_option($option);
}

//  End subscription product code

//Paypal Subscription paymet data
api_expose('addClientIdPaypalSubscription');
function addClientIdPaypalSubscription($data){
    $option = array();
    $option['option_value'] = $data['id'];
    $option['option_key'] = 'client_id';
    $option['option_group'] = 'paypal_subscription_payment';
    save_option($option);
}


api_expose('addClientSecretPaypalSubscription');
function addClientSecretPaypalSubscription($data){
    $option = array();
    $option['option_value'] = $data['id'];
    $option['option_key'] = 'client_secret';
    $option['option_group'] = 'paypal_subscription_payment';
    save_option($option);
}


api_expose('testModeOn');
function testModeOn(){
    $option = array();
    $option['option_value'] = 'yes';
    $option['option_key'] = 'test_mode';
    $option['option_group'] = 'paypal_subscription_payment_mode';
    save_option($option);
}

api_expose('testModeOff');
function testModeOff(){
    $option = array();
    $option['option_value'] = 'no';
    $option['option_key'] = 'test_mode';
    $option['option_group'] = 'paypal_subscription_payment_mode';
    save_option($option);
}

api_expose('subscription_payment_on');
function subscription_payment_on(){
    $option = array();
    $option['option_value'] = 'on';
    $option['option_key'] = 'subscription_payment';
    $option['option_group'] = 'paypal_subscription_switch';
    save_option($option);
}

api_expose('subscription_payment_off');
function subscription_payment_off(){
    $option = array();
    $option['option_value'] = 'off';
    $option['option_key'] = 'subscription_payment';
    $option['option_group'] = 'paypal_subscription_switch';
    save_option($option);
}

//End paypal data stored



api_expose('enableClassicProductLayout');
function enableClassicProductLayout($data){
    $option = array();
    $option['option_value'] = $data['layoutStatus'];
    $option['option_key'] = 'classic_layout';
    $option['option_group'] = 'product_classic_layout';
    save_option($option);
}


api_expose('enableProductReadmore');
function enableProductReadmore($data){
    $option = array();
    $option['option_value'] = $data['productReadmoreStatus'];
    $option['option_key'] = 'readMoreOption';
    $option['option_group'] = 'product_readmore_layout';
    save_option($option);
}


api_expose('pdescriptionWordLimit');
function pdescriptionWordLimit($data){
    $option = array();
    $option['option_value'] = $data['pdLimitStatus'];
    $option['option_key'] = 'readMoreLimit';
    $option['option_group'] = 'product_readmore_limit';
    save_option($option);
}



//order modal informtaion
api_expose('showShippingInfo');
function showShippingInfo($data){
    $get_data = DB::table('cart_orders')->where('id', $data['id'])->first();
    return json_encode($get_data);
}

//end order modal informtaion


//thank ypu page tag check

// api_expose('thank_you_tag_check');
// function thank_you_tag_check(){
//     $last_order_information = DB::table('cart_orders')->where('order_completed',1)->get('id')->last();
//     if(isset($last_order_information)){
//         $last_ordered_all_product = DB::table('cart')->where('order_id', $last_order_information->id)->get('rel_id');
//     }
//     $tag_check = null;
//     $tag_page_url_link = null;
//     // $active_page_id = get_option('active_thank_you_tags_page_id', 'active_thank_you_tags_page_id') ?? null;

//     $tag_page_urls = DB::table('content')->where([
//         ['layout_file', '=', 'layouts__thank_you.php'],
//         ['is_active', '=', '1'],
//         ['is_deleted', '=', '0'],
//         ['url', '<>', 'thank-you'],
//     ])->get();


//     foreach($tag_page_urls as $tag_page_url){
//         if($tag_page_url_link){
//             break;
//         }
//         $thank_you_page_all_tag =  content_tags($tag_page_url->id, false);
//         if($thank_you_page_all_tag){
//             foreach($last_ordered_all_product as $last_ordered_product){
//                 $product_tag = content_tags($last_ordered_product->rel_id, false);
//                 if($product_tag){
//                     $all_tags = array_intersect($product_tag , $thank_you_page_all_tag);
//                     if($all_tags){
//                         $tag_check = $all_tags;
//                         $tag_page_url_link = $tag_page_url->url;
//                         break;
//                     }
//                 }
//             }
//         }
//     }


//     $active_page_check = DB::table("thank_you_pages")->where('is_active',1)->orderBy('template_name','asc')->get();
//     if($active_page_check->count() >0){
//         $return_to = url('/') . '/thank-you?temp=1';
//     }else{
//         if($tag_check && $tag_page_url_link){
//             $return_to = url('/') . '/'.$tag_page_url_link;
//         }else{
//             $return_to = url('/') . '/thank-you?temp=1';
//         }
//     }

//     return response()->json(["message" =>   $return_to], 200);
// }

api_expose('thank_you_page_check');
function thank_you_page_check($data){
    $total_thank_you_page = DB::table('content')->where('layout_file','layouts__thank_you.php')->where('is_deleted', 0)->get();
    $thank_you_page = DB::table('content')->where('id',$data['page_id'])->where('is_deleted', 0)->get();
    // dd($thank_you_page[0]->url);
    if($thank_you_page[0]->url == 'thank-you'){
        if($total_thank_you_page->count() < 2){
            return response()->json([ "message" =>   true ], 200);
        }else{
            return response()->json([ "message" =>   false ], 200);
        }
    }else{
        return response()->json([ "message" =>   true ], 200);
    }
}

api_expose('thank_you_page_tags_save');
function thank_you_page_tags_save($data){
    $tags_lower = array_map('strtolower',explode(',', $data['all_tags']));
    $tags = array_map(function($word) { return ucfirst($word); }, $tags_lower);
    DB::table('tagging_tagged')->where([
        'taggable_id' => $data['new_page_id'],
        'taggable_type' => 'content',
    ])->delete();
    foreach($tags as $tag){
        DB::table('tagging_tags')->updateOrInsert(['slug' => Str::slug($tag), 'name' =>$tag], ['count' => 1]);

        DB::table('tagging_tagged')->insert([
            'taggable_id' => $data['new_page_id'],
            'taggable_type' => 'content',
            'tag_name' => $tag,
            'tag_slug' => Str::slug($tag)
        ]);
    }
}

api_expose('thank_you_save_tag_check');
function thank_you_save_tag_check($data){
    // dd($data);= array_map('strtolower',$myArray);
    $tags_lower = array_map('strtolower',explode(',', $data['all_tags']));
    $tags=array_map(function($word) { return ucfirst($word); }, $tags_lower);
    // dd($tags);
    $thank_you_pages = DB::table('content')->where('layout_file','layouts__thank_you.php')->where('is_deleted', 0)->pluck('id')->toArray();
    $all_thank_you_page_tags = DB::table('tagging_tagged')->whereIn('taggable_id', $thank_you_pages)->pluck('tag_slug')->toArray();
    $common_tags = array_intersect($tags_lower, $all_thank_you_page_tags);
    // $all_thank_you_page_tags = DB::table('tagging_tagged')->whereRaw('taggable_id', $thank_you_page)->get('tag_name');
    return response()->json(['message' =>  $common_tags], 200);
}


api_expose('active_thank_you_tags_page');
function active_thank_you_tags_page($data){
   if($data){
    $option = array();
    $option['option_key'] = 'active_thank_you_tags_page_id';
    $option['option_value'] = $data['page_id'];
    $option['option_group'] = 'active_thank_you_tags_page_id';
    save_option($option);
   }
}

//price on request

api_expose('price_on_request_offer_html');
function price_on_request_offer_html($data){
    $product_detail = DB::table('product_details')->where('rel_id', $data['product_id'])->first();
    if(isset($product_detail->offer_options)){
        $offers = json_decode($product_detail->offer_options);
        if(isset($offers->type)){
            switch ($offers->type) {
                case "color":
                    $html = '<label>Bitte Variante wählen *</label>' . "\n";
                    $html .= '<input class="variant-type" type="hidden" value="'.$offers->type.'" />' . "\n";
                    $html .= '<div class="form-group">' . "\n";
                    if(isset($offers->options)){
                        $html .= '<select name="variant[]" class="selectpicker js-search-by-selector form-control" id="variant"  data-live-search="true" data-width="100%" data-style="btn-sm" tabindex="-98" aria-label="product variants" required >' . "\n";
                        $html .= '<option value="">Variante auswählen</option>' . "\n";
                        foreach ($offers->options as $key => $opt_group){
                            $html .= '<option value="'.$opt_group->name.'" style="background: '.$opt_group->color.'; color: #fff;">'.$opt_group->name.'</option>';
                        }
                        $html .= '</select>' . "\n";
                    }
                    $html .= '</div>' . "\n";
                    break;
                case "single":
                    $html = '<label>Bitte Variante wählen *</label>' . "\n";
                    $html .= '<input class="variant-type" type="hidden" value="'.$offers->type.'" />' . "\n";
                    $html .= '<div class="form-group">' . "\n";
                    if(isset($offers->options)){
                        $html .= '<select name="variant[]" class="selectpicker js-search-by-selector form-control" id="variant"  data-live-search="true" data-width="100%" data-style="btn-sm" tabindex="-98" aria-label="product variants" required >' . "\n";
                        $html .= '<option value="">Variante auswählen</option>' . "\n";
                        foreach ($offers->options as $key => $opt_group){
                            $html .= '<option value="'.$opt_group->title.'" data-content="';
                            $html .="<img style='"."height: 30px; width: 30px;'"." class='"."variant-image'"." src='".$opt_group->image."'><span>".$opt_group->title.'</span>"></option>' . "\n";
                        }
                        $html .= '</select>' . "\n";
                    }
                    $html .= '</div>' . "\n";
                    break;
                case "multiple":
                    $html = '<label>Bitte Variante wählen *</label>' . "\n";
                    $html .= '<input class="variant-type" type="hidden" value="'.$offers->type.'" />' . "\n";
                    if(isset($offers->options)){
                        foreach ($offers->options as $key => $opt_group){
                            $html .= '<div class="form-group">' . "\n";
                            $html .= '<label>'. $opt_group->option.'</label>' . "\n";
                            $html .= '<select name="variant[]" class="selectpicker js-search-by-selector form-control" id="variant"  data-live-search="true" data-width="100%" data-style="btn-sm" tabindex="-98" aria-label="product variants" required >' . "\n";
                            $html .= '<option value="">Variante auswählen</option>' . "\n";
                            foreach ($opt_group->data as $key => $opt){
                                $html .= '<option value="'.$opt_group->option.':--:'.$opt->name.'" data-content="';
                                $html .= "<img style='height: 30px; width: 30px;' class='variant-image' src='".$opt->img."'><span>".$opt->name.'</span>"></option>' . "\n";
                            }
                            $html .= '</select>' . "\n";
                            $html .= '</div>' . "\n";
                        }
                    }
                    break;
                default:
                    $html="";
            }
            return response()->json(['html' => $html], 200);
        }
    }
}

api_expose('price_on_request_info');
function price_on_request_info($data){
    $offer_option=[];
    if(isset($data['variant_type'])){
        switch ($data['variant_type']) {
            case "color":
                if(isset($data['product_variants'])){
                    if(!empty($data['product_variants'][0])){
                        $offer_option['type'] = $data['variant_type'];
                        $offer_option['data']=$data['product_variants'][0];
                    }
                }
                break;
            case "single":
                if(isset($data['product_variants'])){
                    if(!empty($data['product_variants'][0])){
                        $offer_option['type'] = $data['variant_type'];
                        $offer_option['data']=$data['product_variants'][0];
                    }
                }
                break;
            case "multiple":
                if(isset($data['product_variants'])){
                    $offer_option['type'] = $data['variant_type'];
                    foreach($data['product_variants'] as $offer){
                        if(!empty($offer)){
                            $offer = explode(':--:',$offer);
                            $offer_option['data'][]=[$offer[0]=>$offer[1]];
                        }
                    }
                }
                break;
            default:
        }
    }
    $request_product = get_products('id='.$data['price_on_request_product_id']);
    $country_tax_rate = DB::table('tax_rates')->where('country',$data['country'])->first();
    if(isset($country_tax_rate->charge)){
        $tax_rate_send = $country_tax_rate->charge;
    }else{
        $tax_rate_send = null;
    }
    // dd($request_product);
    $product_info = array(
        'name' => $data['first_name'].' '.$data['last_name'],
        'email' => $data['email'],
        'address' => $data['city'],
        'zip_code' => $data['zip_code'],
        'street' => $data['street'],
        'state' => $data['state'],
        'phone' => $data['phone_number'],
        'country' => $data['country'],
        'product_info[product_name]' => $request_product[0]['title'],
        'product_info[description]' => $request_product[0]['description'],
        'product_info[qty]' => 1,
        'product_info[rate]' => null,
        'product_info[ean]' => $request_product[0]['ean'],
        'offer_options' => json_encode($offer_option),
        'tax_rate' => $tax_rate_send,
    );

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://drm.software/api/droptienda/offer/create',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>  $product_info,
    CURLOPT_HTTPHEADER => array(
        'userToken: '.Config::get('microweber.userToken'),
        'userPassToken: '.Config::get('microweber.userPassToken')
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    $response = json_decode($response, true);
    // echo $response;
    // dd($response);

    return response()->json(['message' => $response], 200);
}

//handling time function

api_expose('handlingtimehideorshow');
function handlingtimehideorshow($data){
    $option = array();
    $option['option_value'] = $data['id'];
    $option['option_key'] = 'handlingtime';
    $option['option_group'] = 'handlingtime_show_hide';
    save_option($option);
}

api_expose('add_handlingtime');
function add_handlingtime($data){
    $id = $data['data'];
    $check = DB::table('handling_time')->where('data', $id)->get();
    if(count($check) > 0){
        return "This data already added";
    } else {
        DB::table('handling_time')->insert($data);
        return "Data added successfully";
    }
}

api_expose('delete_handlingtime');
function delete_handlingtime($data){
    DB::table('handling_time')->where('id', $data['id'])->delete();
}

api_expose('update_handlingtime');
function update_handlingtime($data){
    DB::table('handling_time')->where('id', $data['id'])->update(['text' => $data['text']]);
}

//End handling time function

//start legal text option selected value save
api_expose('active_legal_option_save');
function active_legal_option_save($data){
    if($data){
        $option = array();
        $option['option_key'] = 'active_legal_option_name';
        $option['option_value'] = $data['data'];
        $option['option_group'] = 'active_legal_option_name';
        save_option($option);
        return response()->json(['message' => 'success'], 200);
    }
}

api_expose('producted_shop_legal_document');
function producted_shop_legal_document($data){
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://eu-dropshipping.com/api/v1/protected-shop',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'userToken: '.Config::get('microweber.userToken'),
        'userPassToken: '.Config::get('microweber.userPassToken'),
        'Cookie: SameSite=None'
    ),
    ));
    $response = curl_exec($curl);
    $response = json_decode($response, true);
    curl_close($curl);
    if($response['success']){
        $option = array();
        $option['option_key'] = 'active_legal_option_name';
        $option['option_value'] = $data['data'];
        $option['option_group'] = 'active_legal_option_name';
        save_option($option);
        return response()->json(['message' => 'success'], 200);
        // $file_path = 'protected_shop.pdf';
        // dump($response['message']['file_path']);
        // @file_put_contents($file_path, file_get_contents($response['message']['file_path']));
        // if(file_exists($file_path)){
        //     // dump('test');
        //     $option = array();
        //     $option['option_key'] = 'active_legal_option_name';
        //     $option['option_value'] = $data['data'];
        //     $option['option_group'] = 'active_legal_option_name';
        //     save_option($option);
        //     return response()->json(['message' => 'success'], 200);
        // }else{
        //     $option = array();
        //     $option['option_key'] = 'active_legal_option_name';
        //     $option['option_value'] = null;
        //     $option['option_group'] = 'active_legal_option_name';
        //     save_option($option);
        //     return response()->json(['message' => 'error'], 200);
        // }
    }else{
        $option = array();
        $option['option_key'] = 'active_legal_option_name';
        $option['option_value'] = null;
        $option['option_group'] = 'active_legal_option_name';
        save_option($option);
        return response()->json(['message' => 'error'], 200);
    }
}
//end legal text option selected value save


api_expose('vacation_mode_end_date_save');
function vacation_mode_end_date_save($data){
    if($data){
        $option = array();
        $option['option_key'] = 'vacation_mode_start_date';
        $option['option_value'] = date("Y-m-d");
        $option['option_group'] = 'vacation_mode_date';
        save_option($option);
        $option = array();
        $option['option_key'] = 'vacation_mode_end_date';
        $option['option_value'] = $data['vacation_end_date'];
        $option['option_group'] = 'vacation_mode_date';
        save_option($option);
    }
}

api_expose('vacation_mode_date_stop');
function vacation_mode_date_stop(){
    $option = array();
    $option['option_key'] = 'vacation_mode_start_date';
    $option['option_value'] = null;
    $option['option_group'] = 'vacation_mode_date';
    save_option($option);
    $option = array();
    $option['option_key'] = 'vacation_mode_end_date';
    $option['option_value'] = null;
    $option['option_group'] = 'vacation_mode_date';
    save_option($option);
    return response()->json(['message' => 'success'], 200);
}

//licence_drm
api_expose('licence_drm_connect');
function licence_drm_connect(){
    try {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://eu-dropshipping.com/api/v1/dt-license-check',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'userToken: '.Config::get('microweber.userToken'),
                'userPassToken: '.Config::get('microweber.userPassToken'),
                'Cookie: SameSite=None'
            ),
        ));
        $response = json_decode(curl_exec($curl));
    }catch (Exception $e){
        return false;
    }
    // dump($response);
    if(isset($response->success) && $response->success != false){
        return response()->json(['message' => 'success'], 200);
    }
}


//save_base_unit_limit
api_expose('save_base_unit_limit');
function save_base_unit_limit($data){
    if($data){
        $option = array();
        $option['option_key'] = $data['base_unit'];
        $option['option_value'] = $data['base_unit_limit'];
        $option['option_group'] = 'save_base_unit_limit';
        save_option($option);
        return response()->json(['message' => 'success'], 200);
    }else{
        return response()->json(['message' => 'error'], 200);
    }
}

api_expose('delete_base_unit_limit');
function delete_base_unit_limit($data){
    if($data){
        DB::table('options')->where('option_group','save_base_unit_limit')->where('option_key',$data['base_unit'])->delete();
        return response()->json(['message' => 'success'], 200);
    }else{
        return response()->json(['message' => 'error'], 200);
    }
}
//ticker text
api_expose('save_ticker_text');
function save_ticker_text($data){
    if($data){
        $option = array();
        $option['option_key'] = $data['ticker_text_position'];
        $option['option_value'] = $data['ticker_text'];
        $option['option_group'] = $data['module_id'];
        save_option($option);
        return response()->json(['message' => 'success'], 200);
    }else{
        return response()->json(['message' => 'error'], 200);
    }
}

api_expose('show_ticker_test');
function show_ticker_test($data){
    if($data){
        $base_unit_lists = DB::table('options')->where('option_group',$data['module_id'])->pluck('option_value')->toArray();
        // dump($base_unit_lists);
        return response()->json(['message' => $base_unit_lists], 200);
    }else{
        return response()->json(['message' => 'error'], 200);
    }
}

api_expose('delete_ticker_text');
function delete_ticker_text($data){
    if($data){
        DB::table('options')->where('option_group',$data['module_id'])->where('option_key',$data['text_position'])->delete();
        return response()->json(['message' => 'success'], 200);
    }else{
        return response()->json(['message' => 'error'], 200);
    }
}
//subpage_search_information
api_expose('save_subpage_search_information');
function save_subpage_search_information($data){
    if($data){
        $option = array();
        $option['option_key'] = $data['subpage_name'];
        $option['option_value'] = $data['subpage_link'];
        $option['option_group'] = $data['module_id'];
        save_option($option);
        return response()->json(['message' => 'success'], 200);
    }else{
        return response()->json(['message' => 'error'], 200);
    }
}

api_expose('delete_subpage_search_information');
function delete_subpage_search_information($data){
    if($data){
        DB::table('options')->where('option_group',$data['module_id'])->where('option_key',$data['subpage_name'])->delete();
        return response()->json(['message' => 'success'], 200);
    }else{
        return response()->json(['message' => 'error'], 200);
    }
}

// single product checkout start
api_expose('product_id_store');
function product_id_store($data)
{
    $product = DB::table('single_checkout_products')->updateOrInsert(
        ['module_id' => $data['module_id']],
        ['product_id' => $data['product_id']]
    );
    $message = 'Store successfully';
    return $message;
}

api_expose('single_product_id');
function single_product_id($data)
{
    $single_product = DB::table('single_checkout_products')
        ->join('content', 'single_checkout_products.product_id', '=', 'content.id')
        ->where('single_checkout_products.module_id', $data['module_id'])
        ->select('content.id')
        ->first();

    $message = "please insert or update valid product";
    $status = false;
    $product_id = "";
    if ($single_product) {
        $message = "sucessfully product id return";
        $status = true;
        $product_id = $single_product->id;
    }
    return ['status' => $status, 'product_id' => $product_id, 'message' => $message];
}
// single product checkout end

// wishlist enable start
api_expose('set_wishlist_option');
function set_wishlist_option($data)
{
    $data = $data['wishlist'];
    $option = array();
    $option['option_key'] = 'enable_wishlist';
    $option['option_value'] = $data;
    $option['option_group'] = 'shop';
    save_option($option);

    $message = "Wishlist disable successfully";
    if ($data) {
        $message = "Wishlist enable successfully";
    }
    return $message;
}
// wishlist enable end
//sidebar navigation
api_expose("save_module_name_for_sidebar_nav");
function save_module_name_for_sidebar_nav($data){
    if($data){
        $option = array();
        $option['option_key'] = $data['current_module_id'];
        $option['option_value'] = $data['module_name'];
        $option['option_value2'] = $data['module_icon'];
        $option['option_group'] = 'sidebar-nav-module-list-'.$data['current_page_id'];
        save_option($option);
        return response()->json(['message' => 'success'], 200);
    }else{
        return response()->json(['message' => 'error'], 200);
    }
}
api_expose("get_module_info_for_edit");
function get_module_info_for_edit($data){
    if($data){
        $edit_module_information =  DB::table('options')->where('option_group','sidebar-nav-module-list-'.$data['current_page_id'])->where('option_key',$data['active_module_id'])->get();
        if(isset($edit_module_information[0])){
            return response()->json(['message' => $edit_module_information], 200);
        }else{
            return response()->json(['message' => 'error'], 200);
        }
    }else{
        return response()->json(['message' => 'error'], 200);
    }
}



// digital product start
api_expose('set_product_opt');
function set_product_opt($data)
{
    $option = $data['option'];
    $id = $data['product_id'];

    $product = DB::table('product_details')->updateOrInsert(
        ['rel_id' => $id],
        ['digital_opt' => $option]
    );

    $message = "Successfully change";
    return $message;
}
// digital product end

api_expose('store_bundle_product');
function store_bundle_product($data)
{
    $bundle = DB::table('bundles')->where('title', $data['title'])->first();
    $message = 'This bundle title already exist, please give a different title ';
    $status = false;
    if(!$bundle){
        if(isset($data['product_ids']) && !empty($data['product_ids']) && $data['tag']==""){
            $bundle_id = DB::table('bundles')->insertGetId(array('title' => $data['title'], 'discount' => $data['discount'], 'discount_type' => $data['discount_type'], 'bundle_option' => $data['bundle_option']));
            $product_id_and_qty = array_map(null, $data['product_ids'], $data['qty'], $data['minimum_p']);

            $id_and_qty = [];
            foreach($product_id_and_qty as $item){
                if($item[0]){
                    $item[1] = !empty($item[1]) ? $item[1] : "1";
                    $item[2] = !empty($item[2]) ? $item[2] : "1";
                    if(!empty($id_and_qty)){
                        $count = count($id_and_qty);
                        $status = true;
                        for($i = 0; $i < $count; $i++){
                            if($id_and_qty[$i]['product_id'] == $item[0]){
                                $id_and_qty[$i]['product_qty'] += $item[1];
                                $id_and_qty[$i]['minimum_p'] += $item[2];
                                $status = false;
                            }
                        }
                        if($status){
                            $id_and_qty[]=['product_id' => $item[0], 'product_qty' => $item[1], 'minimum_p' => $item[2], 'bundle_id' => $bundle_id];
                        }
                    }else{
                        $id_and_qty[]=['product_id' => $item[0], 'product_qty' => $item[1], 'minimum_p' => $item[2], 'bundle_id' => $bundle_id];
                    }
                }
            }

            if($id_and_qty){
                DB::table('bundle_products')->insert($id_and_qty);
            }
        }else{
            $bundle_id = DB::table('bundles')->insertGetId(array('title' => $data['title'], 'discount' => $data['discount'], 'discount_type' => $data['discount_type'], 'bundle_option' => $data['bundle_option'], 'tag_name' => $data['tag']));
            $products = get_products('all_tags='.$data['tag']);
            $ids = collect($products)->pluck('id')->toArray();
            $products = App\Models\Content::with(['media', 'contentData', 'customField', 'taggingTagged', 'categoryItem',])
            ->where('content_type', 'product')
            ->where('is_deleted', 0)
            ->whereIn('id',$ids)
            ->get();
            foreach($products as $product){
                $price = $product->customField->where('name_key', 'price')->where('type', 'price')->first();
                if ($price) {
                    $price = $price->customFieldValue->first() ? $price->customFieldValue->first()->value : 0;
                }
                if($price == 0){
                    continue;
                }
                DB::table('bundle_products')->insert([
                    'product_id' => $product->id, 'product_qty' => 1, 'bundle_id' => $bundle_id
                ]);
            }
        }

        $message = 'Your bundle is saved successfully';
        $status = true;
    }
    return [$status,$message];
}

api_expose('update_product_qty_from_bundle');
function update_product_qty_from_bundle($data)
{
    DB::table('bundle_products')->where('product_id',$data['product_id'])->where('bundle_id',$data['bundle_id'])->where('product_qty', $data['previous_qty'])->update(array('product_qty' => $data['updated_qty']));
    $message = 'Your product Quantity updated successfully';
    return $message;
}

api_expose('update_m_product_qty_from_bundle');
function update_m_product_qty_from_bundle($data)
{
    DB::table('bundle_products')->where('product_id',$data['product_id'])->where('bundle_id',$data['bundle_id'])->update(array('minimum_p' => $data['updated_m_qty']));
    $message = 'Your product Quantity updated successfully';
    return $message;
}

api_expose('delete_product_from_bundle');
function delete_product_from_bundle($data)
{
    DB::table('bundle_products')->where('product_id',$data['product_id'])->where('bundle_id',$data['bundle_id'])->where('product_qty', $data['product_qty'])->delete();
    $message = 'Your product delete successfully from this bundle';
    $product_div ='previous-'.$data['product_id'].'-'.$data['product_qty'];
    return [$message, $product_div];
}

api_expose('update_bundle_product');
function update_bundle_product($data)
{
    $bundle_product_checkout = mw()->user_manager->session_get('bundle_product_checkout');
    if(isset($bundle_product_checkout) && !empty($bundle_product_checkout)){
        $new_session = collect($bundle_product_checkout);
        $new_session = $new_session->map(function($q) use ($data){
            if($q['id'] != $data['bundle_id']){
                return $q;
            }
        })->reject(function ($item) {
            return is_null($item);
        })->toArray();
        mw()->user_manager->session_set('bundle_product_checkout',$new_session);
    }
    if(isset($data['product_ids']) && !empty($data['product_ids']) && $data['tag']==""){
        DB::table('bundles')->where('id', $data['bundle_id'])->update(array('title' => $data['title'], 'discount' => $data['discount'], 'discount_type' => $data['discount_type'], 'bundle_option' => $data['bundle_option']));
        $product_id_and_qty = array_map(null, $data['product_ids'], $data['qty'], $data['minimum_p']);

        $id_and_qty = [];
        foreach($product_id_and_qty as $item){
            if($item[0]){
                $hasProduct = DB::table('bundle_products')->where('bundle_id', $data['bundle_id'])->where('product_id', $item[0])->first();
                $item[1] = !empty($item[1]) ? $item[1] : "1";
                $item[2] = !empty($item[2]) ? $item[2] : "1";
                $hasProduct = collect($hasProduct)->toArray();
                if(isset($hasProduct) && !empty($hasProduct)){
                    $hasProduct = collect($hasProduct)->toArray();
                    DB::table('bundle_products')
                        ->where('bundle_id', $data['bundle_id'])
                        ->where('product_id', $item[0])
                        ->update([
                            'product_qty' => ($hasProduct['product_qty'] + $item[1]),
                            'minimum_p' => ($hasProduct['minimum_p'] + $item[2])
                        ]);
                } else{
                    $id_and_qty[]=['product_id' => $item[0], 'product_qty' => $item[1], 'minimum_p' => $item[2], 'bundle_id' => $data['bundle_id']];

                }
            }
        }
        if($id_and_qty){
            DB::table('bundle_products')->insert($id_and_qty);
        }
    }else{
        DB::table('bundles')->where('id', $data['bundle_id'])->update(array('title' => $data['title'], 'discount' => $data['discount'],'tag_name' => $data['tag']));
        $products = get_products('all_tags='.$data['tag']);
        foreach($products as $product){
            DB::table('bundle_products')->insert([
                'product_id' => $product['id'], 'product_qty' => 1, 'bundle_id' => $data['bundle_id']
            ]);
        }
    }

    $message = 'Your bundle is updated successfully';
    return $message;
}

api_expose('update_bundle_discount_condition');
function update_bundle_discount_condition($data)
{
    DB::table('bundles')->where('id', $data['bundle_id'])->update(array('bundle_option' => $data['bundle_option']));
    $new_session = mw()->user_manager->session_get('bundle_product_checkout');
    if(@$new_session){
        $new_session = collect($new_session)->map(function($q, $key) use ($data){
            if($q['id'] == $data['bundle_id']){
                $q['bundle_option'] = $data['bundle_option'];
            }
            return $q;
        })->toArray();
        mw()->user_manager->session_set('bundle_product_checkout',$new_session);
    }

    $message = 'Your bundle update successfully';
    return $message;
}

api_expose('update_global_bundle_discount_condition');
function update_global_bundle_discount_condition($data)
{
    save_option('update_global_bundle_discount_condition', $data['bundle_setting_option'], 'update_global_bundle_discount_condition');

    $message = 'Your bundle update successfully';
    return $message;
}


api_expose('edit_bundle_product');
function edit_bundle_product($data)
{
    $bundle_id = $data['bundle_id'];
    $bundles = \App\Models\Bundle::with('bundle_products')->where('id', $bundle_id)->first();

    $bundle_title = $bundles->title;

    $products = \App\Models\Content::with('customField')->where('content_type', 'product')->where('is_deleted', 0)->get();
    $symbol = mw()->shop_manager->currency_symbol();
    $product_html = '';
    if(isset($bundles->tag_name) && !empty($bundles->tag_name)){
        $bundles_tag=str_replace("#","",$bundles->tag_name);
        $product_html .='<label>Produkte mit dem Tag #' .$bundles_tag . "</label>\n";
    }
    else{
        $product_html .='<label> Produkte </label>'  . "\n";
    }
    $i  = 1;
    foreach ($bundles->bundle_products as $bundle_product) {
        $product = $products->where('id',$bundle_product->product_id)->first();
        if($product){
            $price = $product->customField->where('name_key', 'price')->where('type', 'price')->first();
            if ($price) {
                $price = $price->customFieldValue->first() ? $price->customFieldValue->first()->value : 0;
            }
            $pro = $product->title . ' | Preis : ' . $symbol . ' ' . $price;

            $product_html .= '<div class="form-group previous-'.$product->id.'-'.$bundle_product->product_qty.'">' . "\n";
            $product_html .= '<input type="Text" class="form-control" id="product-title-and-price" value="' . $pro . '" disabled>' . "\n";
            $product_html .= '<div class="form-group">' . "\n";
            $product_html .= '<label for="" class="mqtylabel">Angebotsmenge</label><input type="Text" class="form-control" name="product_qty[]" id="product_quantity_edit_'.$i.'" onchange="update_product_qty_from_bundle('.$product->id.','.$bundle_id . ',' . $bundle_product->product_qty.',this.value)" value="' . $bundle_product->product_qty . '" placeholder="Angebotsmenge">' . "\n";
            $product_html .= '</div>' . "\n";
            $product_html .= '<div class="form-group">' . "\n";
            $product_html .= '<label for="" class="qty-label">Mindestbestellmenge</label><input type="Text" class="form-control" name="minimum_p[]" id="minimum_p_edit_'.$i.'" onchange="update_m_product_qty_from_bundle('.$product->id.','.$bundle_id . ',' . $bundle_product->minimum_p.',this.value, this.id)" value="' . $bundle_product->minimum_p . '" placeholder="Mindestbestellmenge">' . "\n";
            $product_html .= '</div>' . "\n";
            $product_html .= '<button type="button" class="btn btn-danger delete-bundle-btn" value="'.$bundle_id.'" onclick="delete_product_from_bundle('.$product->id.',' . $bundle_product->product_qty.', this.value)"><i class="fa fa-trash" aria-hidden="true"></i></button>' . "\n";
            $product_html .= '</div>' . "\n";
        }
        $i++;
    }

    $discount_type = $bundles->discount_type;
    $discount = $bundles->discount;
    $bundle_option = $bundles->bundle_option;

    return [$bundle_title, $product_html, $discount_type, $discount, $bundle_option, $bundle_id];
}

api_expose('delete_bundle_product');
function delete_bundle_product($data)
{
    DB::table('bundles')->where('id', $data['bundle_id'])->delete();
    DB::table('bundle_products')->where('bundle_id', $data['bundle_id'])->delete();
    $message = 'your bundle successfully deleted';
    return $message;
}

api_expose('module_based_bundle_store');
function module_based_bundle_store($data)
{
    $option = array();
    $option['option_value'] = $data['bundle_id'];
    $option['option_key'] = 'bundle_id';
    $option['option_group'] = $data['module_id'];
    save_option($option);
    return 'bundle successfully saved';
}


api_expose('cart_update_for_bundle_product');
function cart_update_for_bundle_product($data)
{
    // $products_id = $data['product_id'];
    $bundle_id = $data['bundle_id'];
    $discount_apply = $data['discount_apply'];
    $bundles = array();
    $bundles = @mw()->user_manager->session_get("bundle_product_checkout")??[];

    if ($discount_apply) {
        $bundle = \App\Models\Bundle::with('bundle_products')->where('id', $bundle_id)->get()->toArray();

        $price_total = 0;
        foreach($bundle[0]['bundle_products'] as $b){
            $priceData = get_product_prices($b['product_id'], false);
            $price = !empty($priceData['price']) ? $priceData['price'] : null;
            $price = $price + taxPrice($price, user_country(),$b['product_id']);
            $price_total = $price_total + $price * $b['product_qty'];

        }
        if($bundle[0]['discount_type']) {
            $discount_for_bundle = $bundle[0];
            if (isset($discount_for_bundle)) {
                if ($discount_for_bundle['discount_type'] == "percentage") {
                    $discount_sum = ($price_total * ($discount_for_bundle['discount'] / 100));
                } else {
                    $discount_sum = (int)$discount_for_bundle['discount'];
                }
            }
        }
        if($discount_sum){
            $bundle[0]['offer_discount'] = $discount_sum;
        }
        foreach($bundles as $key => $b){

            if($b == $bundle[0]){
                $bundles[$key]['offer_discount'] = $b['offer_discount'] + $bundle[0]['offer_discount'];
                $bundle = array();
            }

        }

        $bundles = array_merge_recursive($bundles,$bundle);
        mw()->user_manager->session_set("bundle_product_checkout" , $bundles);
    }else{
        mw()->user_manager->session_del('bundle_product_checkout');
    }

    return response()->json(['data' => $bundles ], 200);
}

api_expose('pricing_card_details_table_show_hide');
function pricing_card_details_table_show_hide($data){
    $option = array();
    $option['option_value'] = $data['check_value'];
    $option['option_key'] = $data['module_id'];
    $option['option_group'] = 'pricing_card_details_table_show_hide';
    save_option($option);
    return response()->json(['message' => 'success'], 200);
}

api_expose('get_pricing_card_details_table_show_hide_info');
function get_pricing_card_details_table_show_hide_info($data){
    if(isset($data['module_id'])){
        $table_show_hide_info = get_option($data['module_id'],'pricing_card_details_table_show_hide');
        return response()->json(['message' => $table_show_hide_info], 200);
    }
}

api_expose('pricing_card_limit_quantity_save');
function pricing_card_limit_quantity_save($data){
    $option = array();
    $option['option_value'] = $data['limit'];
    $option['option_key'] = $data['module_id'];
    $option['option_group'] = 'pricing_card_limit_quantity';
    save_option($option);
    return response()->json(['message' => 'success'], 200);
}
api_expose('pricing_table_limit_quantity_save');
function pricing_table_limit_quantity_save($data){
    $option = array();
    $option['option_value'] = $data['limit'];
    $option['option_key'] = $data['module_id'];
    $option['option_group'] = 'pricing_table_limit_quantity';
    save_option($option);
    return response()->json(['message' => 'success'], 200);
}

api_expose('pricing_table_row_limit_quantity_save');
function pricing_table_row_limit_quantity_save($data){
    $option = array();
    $option['option_value'] = $data['limit'];
    $option['option_key'] = 'table_'.$data['table_number'].'_'.$data['module_id'];
    $option['option_group'] = 'pricing_table_row_limit_quantity';
    save_option($option);
    return response()->json(['message' => 'success'], 200);
}
api_expose('pricing_table_readmore_row_limit_save');
function pricing_table_readmore_row_limit_save($data){
    $option = array();
    $option['option_value'] = $data['limit'];
    $option['option_key'] = 'table_readmore_'.$data['module_id'];
    $option['option_group'] = 'pricing_table_readmore_row_limit';
    save_option($option);
    return response()->json(['message' => 'success'], 200);
}

api_expose('pricing_card_active_save');
function pricing_card_active_save($data){
    $option = array();
    $option['option_value'] = $data['limit'];
    $option['option_key'] = $data['module_id'];
    $option['option_group'] = 'pricing_card_active';
    save_option($option);
    return response()->json(['message' => 'success'], 200);
}

api_expose('pricing_card_table_row_description_show_hide');
function pricing_card_table_row_description_show_hide($data){
    if($data['row_on_off'] == 'on'){
        $option = array();
        $option['option_value'] = $data['row_on_off'];
        $option['option_key'] = 'row_popup_on_off';
        $option['option_group'] = $data['row_description_id'];
        save_option($option);
        return response()->json(['message' => 'success'], 200);
    }else{
        DB::table('options')->where('option_group',$data['row_description_id'])->delete();
        mw_post_update();
        return response()->json(['message' => 'success'], 200);
    }
}

api_expose('pricing_card_table_row_description_save');
function pricing_card_table_row_description_save($data){
    $option = array();
    $option['option_value'] = $data['row_description'];
    $option['option_key'] = 'row_description';
    $option['option_group'] = $data['row_description_id'];
    save_option($option);
    return response()->json(['message' => 'success'], 200);
}

api_expose('pricing_card_table_row_description_value');
function pricing_card_table_row_description_value($data){
    $descripttion_popup = array();
    $descripttion_popup['on_off'] = get_option('row_popup_on_off',$data['row_description_id']);
    $descripttion_popup['value'] = get_option('row_description',$data['row_description_id']);
    return response()->json(['message' => $descripttion_popup], 200);
}
api_expose('pricing_card_initial_intervel_show_hide');
function pricing_card_initial_intervel_show_hide($data){
    $option = array();
    $option['option_value'] = $data['check_value'];
    $option['option_key'] = 'initial_intervel_on_off';
    $option['option_group'] = 'pricing_interval_'.$data['module_id'];
    save_option($option);
    return response()->json(['messgae' => 'success'], 200);
}
api_expose('interval_information_save');
function interval_information_save($data){
    $check_interval_information = DB::table('options')->where('option_group','pricing_interval_info_'.$data['module_id'])->where('option_key',$data['interval_position'])->first();
    if($check_interval_information){
        return response()->json(['message' => 'error'], 200);
    }else{
        $option = array();
        $option['option_value'] = $data['interval_title'];
        $option['option_value2'] = $data['interval_percentage'];
        $option['option_key'] = $data['interval_position'];
        $option['option_group'] = 'pricing_interval_info_'.$data['module_id'];
        save_option($option);
        return response()->json(['message' => 'success'], 200);
    }
}

api_expose('interval_information_delete');
function interval_information_delete($data){
    DB::table('options')->where('option_group','pricing_interval_info_'.$data['module_id'])->where('option_key',$data['interval_position'])->delete();
    return response()->json(['message' => 'success'], 200);
}

api_expose('interval_information_edit');
function interval_information_edit($data){
    $interval_information = DB::table('options')->where('option_group','pricing_interval_info_'.$data['module_id'])->where('option_key',$data['interval_position'])->first();
    return response()->json(['data' => $interval_information], 200);
}
api_expose('interval_information_update');
function interval_information_update($data){
    $new_interval_information = DB::table('options')->where('option_group','pricing_interval_info_'.$data['module_id'])->where('option_key',$data['interval_position'])->first();
    if($new_interval_information){
        $old_interval_information = DB::table('options')->where('id',$data['interval_id'])->first();
        if($new_interval_information->option_key == $old_interval_information->option_key){
            DB::table('options')->where('id',$data['interval_id'])->update(['option_value' => $data['interval_title'],'option_value2' => $data['interval_percentage'],'option_key' => $data['interval_position']]);
            return response()->json(['message' => 'success'], 200);
        }else{
            return response()->json(['message' => 'error'], 200);
        }
    }else{
        DB::table('options')->where('id',$data['interval_id'])->update(['option_value' => $data['interval_title'],'option_value2' => $data['interval_percentage'],'option_key' => $data['interval_position']]);
        return response()->json(['message' => 'success'], 200);
    }
}

api_expose('payment_option_select');
function payment_option_select($data)
{
    $payment_id = $data['payment_id'];
    setcookie('selected_payment_id', $payment_id, time() + (3600*5), '/');

}
api_expose('cards_module_shadow_set');
function cards_module_shadow_set($data){
    $option = array();
    $option['option_value'] = $data['shadow_type'];
    $option['option_key'] = $data['module_name'];
    $option['option_group'] = 'cards_module_shadow';
    save_option($option);
    return response()->json(['message' => 'success'], 200);
}

api_expose('categories_hide');
function categories_hide($data){

    $cat_ids = category_hide($data);
    return response()->json(['data' => $cat_ids], 200);
}

api_expose('delete_subscription_product_if_has');
function delete_subscription_product_if_has($data){
    $id = $data['id'];
    $sub_items = DB::table('subscription_order_status')->where('product_id', $id)->where('order_status', 'active')->where('order_type', 'new')->get();
    if(isset($sub_items)){
        foreach($sub_items as $item){

            // cancel subscription functinality
            $url_curl = site_url("subscribe/cancel?id={$item->agreement_id}&status=admin");
            $ch = curl_init($url_curl);
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_exec($ch);
            curl_close($ch);


            // send email to customer
            $user_infos = get_user_by_id($item->user_id);
            $mail_data = [];
            $mail_data['user_mail'] = $user_infos['email'];
            $mail_data['username'] = $user_infos['first_name']." ".$user_infos['last_name'];
            $mail_data['agreement_id'] = $item->agreement_id;
            $url_curl_mail = "https://drm.team/api/droptienda/cancelMail/subscription";
            $ch = curl_init();
            curl_setopt_array($ch, array(
            CURLOPT_URL => $url_curl_mail,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>  $mail_data,
            CURLOPT_HTTPHEADER => array(
                'userToken: '.Config::get('microweber.userToken'),
                'userPassToken: '.Config::get('microweber.userPassToken')
            ),
            ));
            curl_exec($ch);
            curl_close($ch);


        }
    }
}



api_expose('update_password');
function update_password($data){
    $new_pass = Illuminate\Support\Facades\Hash::make($data['new_pass']);
    $user_info = get_user_by_id(user_id());
    $user_pass['password'] = $data['old_pass'];
    $user_pass['email'] = $user_info['email'];
    if(Illuminate\Support\Facades\Hash::check($data['old_pass'], $user_info['password'])){
        DB::table('users')->where('id', $user_info['id'])->update(['password' => $new_pass]);
        return true;
    } else{
        return false;
    }
}

api_expose('update_admin_profile_data');
function update_admin_profile_data($data){
    if($data){
        $user_id = user_id();
        $option = array();
        $option['option_value'] = json_encode($data);
        $option['option_key'] = 'admin_profile_data_'.$user_id;
        $option['option_group'] = 'admin_profile_data';
        save_option($option);

        // api for DRM
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://eu-dropshipping.com/api/v1/sync/store/cms_user_info',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array(
            'userToken: '.Config::get('microweber.userToken'),
            'userPassToken: '.Config::get('microweber.userPassToken')
        ),
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data,
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);
        curl_close($curl);
        if($response > 0){
            return redirect(admin_url()."view:profile/action:profile")->with('success_status', 'Your information updated successfully.');
        } else{
            return redirect(admin_url()."view:profile/action:profile");
        }

    }
    return redirect(admin_url()."view:profile/action:profile");
}

api_expose('dependency_function_for_delete_product');
function dependency_function_for_delete_product($datas, $params){
    if(!empty($datas)){

        //delete subcription product if has function
        if($params == 'subscription'){
            foreach($datas as $data){
                $sub_items = DB::table('subscription_order_status')->where('product_id', $data)->where('order_status', 'active')->where('order_type', 'new')->get();
                if(isset($sub_items)){
                    foreach($sub_items as $item){

                        // cancel subscription functinality
                        $url_curl = site_url("subscribe/cancel?id={$item->agreement_id}&status=admin");
                        $ch = curl_init($url_curl);
                        curl_setopt($ch, CURLOPT_POST, 0);
                        curl_exec($ch);
                        curl_close($ch);


                        // send email to customer
                        $user_infos = get_user_by_id($item->user_id);
                        $mail_data = [];
                        $mail_data['user_mail'] = $user_infos['email'];
                        $mail_data['username'] = $user_infos['first_name']." ".$user_infos['last_name'];
                        $mail_data['agreement_id'] = $item->agreement_id;
                        $url_curl_mail = "https://drm.team/api/droptienda/cancelMail/subscription";
                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                        CURLOPT_URL => $url_curl_mail,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS =>  $mail_data,
                        CURLOPT_HTTPHEADER => array(
                            'userToken: '.Config::get('microweber.userToken'),
                            'userPassToken: '.Config::get('microweber.userPassToken')
                        ),
                        ));
                        curl_exec($ch);
                        curl_close($ch);


                    }
                }
            }
        }


        // delete product info function
        if($params == 'category'){
            $insert_array_create = [];
            foreach($datas as $data){
                $productInfo = DB::table('content')->where('id',$data)->first();
                $pId = DB::table('categories_items')->where('rel_id',$productInfo->id)->first();
                if($pId!= null) {
                    $category = DB::table('categories')->where('id',$pId->parent_id)->first();
                    // dd($productInfo->url);
                    $insert_array_create[] = [
                        'product_url' => $productInfo->url,
                        'category_url' => $category->url
                    ];
                } else {
                    $insert_array_create[] = [
                        'product_url' => $productInfo->url,
                        'category_url' => null
                    ];
                }
            }
            if(!empty($insert_array_create)){
                DB::table('delete_product_info')->insert($insert_array_create);
            }
        }
    }

}

api_expose('get_product_stock_by_id');
function get_product_stock_by_id($datas){
    $stock = DB::table('products')
            ->join('cart', 'cart.rel_id', '=', 'products.content_id')
            ->where('cart.id', $datas['id'])
            ->pluck('products.quantity')
            ->toArray();

    if(!empty($stock) and isset($stock[0])){
        if($stock[0] >= $datas['qty']) return 1;
        else return 0;
    }
}


api_expose('child_category_for_parent');
function child_category_for_parent($data){
    $categories= DB::table('categories')
                ->where('is_deleted',0)
                ->whereNotNull('title')
                ->where('parent_id', $data['id'])
                ->orderBy('position', 'asc')
                ->get();

    $html=generate_shop_categories_admin($categories,site_url('shop'),false,$data['id'],0,true);
    return $html;
}

api_expose('setShippingCountryToSession');
function setShippingCountryToSession($data){
    if(!empty(mw()->app->user_manager->session_get('shipping_country'))){
        mw()->app->user_manager->session_set('shipping_country', $data['data']);
        return true;
    }
}