<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiFunctionController extends Controller
{

    public function blogs_transfer(Request $request){
        $blogs_from_content_table = DB::table('content')->where('content_type','post')->where('is_active',1)->where('is_deleted',0)->get();
        foreach($blogs_from_content_table as $single_blog){
            $blog_image_link = get_first_position_image_from_media($single_blog->id);
            DB::table('blogs')->updateOrInsert(
                ['content_id' => $single_blog->id],
                [
                    'title' => $single_blog->title,
                    'content' => $single_blog->content,
                    'link' => '{SITE_URL}'.$single_blog->url,
                    'image' => $blog_image_link,
                    'is_rss' => $single_blog->is_rss,
                    'rss_link' => $single_blog->rss_link,
                    'rss_image' => $single_blog->rss_image,
                    'created_at' => $single_blog->created_at,
                    'updated_at' => $single_blog->updated_at,
                ]
            );
        }
        dump('successfully transfer the blogs from content table to blogs table');
    }

    public function create_vacation(){
        $data = [
            "content_type"=> "page",
            "subtype"=> "static",
            "url"=> "vacation",
            "title"=> "Vacation",
            "parent"=> "0",
            "position"=> "0",
            "is_active"=> "1",
            "active_site_template"=> "default",
            "layout_file"=> "vacation.php",
            "is_home"=> "0",
            "is_pinged"=> "0",
            "is_shop"=> "0",
            "is_deleted"=> "0",
            "require_login"=> "0",
            "session_id"=> "1gFG82M8KcqrOAyLuluwfX0QvLrj3r9BMXe2jVlw",
            "updated_at"=> "2022-05-30 11:07:27",
            "created_at"=> "2022-05-30 11:07:27",
            "created_by"=> "1",
            "edited_by"=> "1",
            "posted_at"=> "2022-05-30 11:07:27",
        ];
        $status = DB::table('content')->updateOrInsert(
                                            ['url' => 'vacation'],
                                            $data);
        return response()->json(['success' => true, 'message' => 'Vacation page added successfully' ],200);
    }

    public function drmUserNameUpdated(){
        $userToken = Config('microweber.userToken');
        $passToken = Config('microweber.userPassToken');


        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://159.65.124.158/api/dt-channel-user/information',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'userPassToken: '.$passToken,
            'userToken: '.$userToken
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $data = json_decode($response, true);
        $data = $data['data'];


        Config::set('microweber.userName', $data['name']);
        Config::save(array('microweber'));
        dump("Username Added Successfully!");
    }


    public function convert_images_to_shop(){
        $images = DB::table('media')->where('rel_type', 'content')->whereNotNull('image_id')->get()->toArray();
        if(isset($images)){
            foreach($images as $image){
                image_set_to_server($image);
            }
            dump("All images convert successfully");
        }
    }

    public function category_status(){
        $categories= DB::table('categories')
                ->where('is_deleted',0)
                ->whereNotNull('title')
                ->where('parent_id', 0)
                ->where('rel_type', 'content')
                ->where('rel_id', 2)
                ->orderBy('position', 'asc')
                ->get();
        $html=generate_shop_categories_api($categories,2,false);
        return $html;
    }

    public function update_blogs_url(){
        $blogs = DB::table('blogs')->where('link','not like','%{SITE_URL}%')->where('is_rss', 0)->get();
        if($blogs){
            foreach($blogs as $blog){
                DB::table('blogs')->updateOrInsert(
                    ['id' => $blog->id],
                    [
                        'link' => '{SITE_URL}'.$blog->link
                    ]
                );
            }
            dump("Blogs url updated successfully");
        }
    }

    public function create_default_group(){
        $hasDefault = DB::table('customer_groups')->where('id', 1)->first();
        if(!isset($hasDefault) and empty($hasDefault)){
            DB::table('customer_groups')
                        ->insert([
                            "id" => "1",
                            "group_name" => "Deafult Group",
                            "payment_method" => "payment_gw_shop/payments/gateways/paypal,payment_gw_shop/payments/gateways/bank_transfer,payment_gw_shop/payments/gateways/paypal_pro,payment_gw_shop/payments/gateways/pay_on_delivery,payment_gw_shop/payments/gateways/omnipay_authorize_aim,payment_gw_shop/payments/gateways/easy_payment,payment_gw_shop/payments/gateways/omnipay_stripe,payment_gw_shop/payments/gateways/omnipay_przelewy24,payment_gw_shop/payments/gateways/omnipay_mollie,payment_gw_shop/payments/gateways/voguepay",
                            "shipping_cost" => "0",
                            "discount_type" => "",
                            "discount" => "0",
                            "has_net_price" => "19.00"
                        ]);
            $productArray = [];
            $categoryArray = [];
            $getProduct = DB::table('products')->pluck('content_id')->toArray();
            $total = count($getProduct);
            for($i = 0; $i < $total;$i++){
                $productArray[] = [
                    'product_id' => $getProduct[$i],
                    'group_id' => 1
                ];
            }
            $getCategory = DB::table('categories')->where('parent_id', 0)->where('rel_id', 2)->pluck('id')->toArray();
            $total = count($getCategory);
            for($i = 0; $i < $total;$i++){
                $categoryArray[] = [
                    'category_id' => $getCategory[$i],
                    'group_id' => 1
                ];
            }
            DB::table('group_product')->insert($productArray);
            DB::table('group_category')->insert($categoryArray);
            dump("Default group data inserted successfully");
        }else{
            dump("Already created");
        }
    }

    public function clear_all_cache(){
        $folder_path = \Config::get('app.manifest').'/cache';
        if(isset($folder_path)){
            if (function_exists('dt_delete_deleteAnyFolder')) {
                dt_delete_deleteAnyFolder($folder_path);
            }
        }

        // exec('php artisan cache:clear');

        // if (function_exists('mw_post_update')) {
        //     mw_post_update();
        // }

        // if (function_exists('clearcache')) {
        //     clearcache();
        // }

        // if (function_exists('mw_reload_modules')) {
        //     mw_reload_modules();
        // }
    }

    public function addSearchbarMenus(){
        $exist = DB::table('menus')->where('title', "searchbar menu")->first();
        if(empty($exist)){
            $hasItem = DB::table('menus')->where('id', 14)->first();
            if(empty($hasItem)){
                $data = [
                    "id"=> 14,
                    "title"=> "searchbar menu",
                    "item_type"=> "menu",
                    "is_active"=> 1
                ];
            }else{
                $data = [
                    "title"=> "searchbar menu",
                    "item_type"=> "menu",
                    "is_active"=> 1
                ];
            }

            DB::table('menus')->insert($data);
            return true;
        }
    }

    public function create_guest_default_group(){
        $hasDefault = DB::table('customer_groups')->where('id', 1)->first();
        if(!isset($hasDefault) and empty($hasDefault)){
            $hasGuest = DB::table('customer_groups')->where('id', 10)->first();
            if(!isset($hasGuest) and empty($hasGuest)){
                DB::table('customer_groups')
                            ->insert([
                                "id" => "10",
                                "group_name" => "Default Guest Group",
                                "payment_method" => "payment_gw_shop/payments/gateways/paypal,payment_gw_shop/payments/gateways/bank_transfer,payment_gw_shop/payments/gateways/paypal_pro,payment_gw_shop/payments/gateways/pay_on_delivery,payment_gw_shop/payments/gateways/omnipay_authorize_aim,payment_gw_shop/payments/gateways/easy_payment,payment_gw_shop/payments/gateways/omnipay_stripe,payment_gw_shop/payments/gateways/omnipay_przelewy24,payment_gw_shop/payments/gateways/omnipay_mollie,payment_gw_shop/payments/gateways/voguepay",
                                "shipping_cost" => "0",
                                "discount_type" => "",
                                "discount" => "0",
                                "has_net_price" => "19.00"
                            ]);
                $productArray = [];
                $categoryArray = [];
                $getProduct = DB::table('products')->pluck('content_id')->toArray();
                $total = count($getProduct);
                for($i = 0; $i < $total;$i++){
                    $productArray[] = [
                        'product_id' => $getProduct[$i],
                        'group_id' => 10
                    ];
                }
                $getCategory = DB::table('categories')->where('parent_id', 0)->where('rel_id', 2)->pluck('id')->toArray();
                $total = count($getCategory);
                for($i = 0; $i < $total;$i++){
                    $categoryArray[] = [
                        'category_id' => $getCategory[$i],
                        'group_id' => 10
                    ];
                }
                DB::table('group_product')->insert($productArray);
                DB::table('group_category')->insert($categoryArray);
                dump("Default guest group data inserted successfully");
            }else{
                dump("Already craeted");
            }
        }else{
            $hasGuest = DB::table('customer_groups')->where('id', 10)->first();
            if(!isset($hasGuest) and empty($hasGuest)){
                DB::table('customer_groups')
                            ->insert([
                                "id" => "10",
                                "group_name" => "Default Guest Group",
                                "payment_method" => "payment_gw_shop/payments/gateways/paypal,payment_gw_shop/payments/gateways/bank_transfer,payment_gw_shop/payments/gateways/paypal_pro,payment_gw_shop/payments/gateways/pay_on_delivery,payment_gw_shop/payments/gateways/omnipay_authorize_aim,payment_gw_shop/payments/gateways/easy_payment,payment_gw_shop/payments/gateways/omnipay_stripe,payment_gw_shop/payments/gateways/omnipay_przelewy24,payment_gw_shop/payments/gateways/omnipay_mollie,payment_gw_shop/payments/gateways/voguepay",
                                "shipping_cost" => "0",
                                "discount_type" => "",
                                "discount" => "0",
                                "has_net_price" => "19.00"
                            ]);
                $productArray = [];
                $categoryArray = [];
                $getProduct = DB::table('group_product')->where('group_id', 1)->pluck('product_id')->toArray();
                $total = count($getProduct);
                for($i = 0; $i < $total;$i++){
                    $productArray[] = [
                        'product_id' => $getProduct[$i],
                        'group_id' => 10
                    ];
                }
                $getCategory = DB::table('group_category')->where('group_id', 1)->pluck('category_id')->toArray();
                $total = count($getCategory);
                for($i = 0; $i < $total;$i++){
                    $categoryArray[] = [
                        'category_id' => $getCategory[$i],
                        'group_id' => 10
                    ];
                }
                DB::table('group_product')->insert($productArray);
                DB::table('group_category')->insert($categoryArray);
                dump("Default guest group data inserted successfully from deafult group");
            }else{
                dump("Already craeted");
            }
        }
    }

    public function update_default_group_name(){
        DB::table('customer_groups')->where('id', 1)->update(['group_name' => 'Default Group']);
    }

    public function refreshGroupData(){
        DB::table('group_product')->where('group_id', 1)->orWhere('group_id', 10)->delete();
        DB::table('group_category')->where('group_id', 1)->orWhere('group_id', 10)->delete();
        $productArray = $categoryArray = $categoryArray1 = [];
        $getProduct = DB::table('products')->pluck('content_id')->toArray();
        $total = count($getProduct);
        for($i = 0; $i < $total;$i++){
            $productArray[] = [
                'product_id' => $getProduct[$i],
                'group_id' => 1
            ];
            $productArray[] = [
                'product_id' => $getProduct[$i],
                'group_id' => 10
            ];
        }
        $getCategory = DB::table('categories')->where('parent_id', 0)->where('rel_id', 2)->pluck('id')->toArray();
        $total = count($getCategory);
        for($i = 0; $i < $total;$i++){
            $categoryArray[] = [
                'category_id' => $getCategory[$i],
                'group_id' => 1,
                'parent_id' => 0
            ];
            $categoryArray[] = [
                'category_id' => $getCategory[$i],
                'group_id' => 10,
                'parent_id' => 0
            ];
            $childCategories = app()->category_manager->get_category_childrens($getCategory[$i]);
            foreach($childCategories as $childCategory){
                $categoryArray1[] = [
                    'category_id'=> $childCategory['id'],
                    'group_id'=> 1,
                ];
                $categoryArray1[] = [
                    'category_id'=> $childCategory['id'],
                    'group_id'=> 10,
                ];
            }
        }
        if(!empty($productArray)){
            $productArray = array_chunk($productArray,10000);
            $count = count($productArray);
            for($i=0;$i<$count;$i++){
                DB::table('group_product')->insert($productArray[$i]);
            }
        }
        if(!empty($categoryArray)){
            $categoryArray = array_chunk($categoryArray,10000);
            $count = count($categoryArray);
            for($i=0;$i<$count;$i++){
                DB::table('group_category')->insert($categoryArray[$i]);
            }
        }
        if(!empty($categoryArray1)){
            $categoryArray1 = array_chunk($categoryArray1,10000);
            $count = count($categoryArray1);
            for($i=0;$i<$count;$i++){
                DB::table('group_category')->insert($categoryArray1[$i]);
            }
        }
        dump("Default group data product and category refreshed successfully");
    }

    public function refreshGroupPaymentData(){
        $payment_modules = DB::table('options')->where('option_value',1)->where('option_group','payments')->where('option_key', 'not like', '%test_payment%')->select('option_key')->pluck('option_key')->toArray();
        $active_method = join(',', $payment_modules);
        DB::table('customer_groups')->update(['payment_method' => $active_method]);
        dump("Payment method updated");
    }

    public function create_global_file_fonts(){
        $font_css = '';

        if(File::exists('userfiles/css/googlefonts/all.css')){
            $font_css = file_get_contents('userfiles/css/googlefonts/all.css');
            $font_css = str_replace('{SITE_URL}/',site_url(),$font_css);
            File::put('userfiles/css/googlefonts/all.css', $font_css);
        }

    }

    public function pricingTitleDescription($params){

        $table_limit_quantity = get_option($params,'pricing_table_limit_quantity');
        $fainalData = array();
        $titleDescription = array();

        for($i=1; $i <=$table_limit_quantity; $i++){
            $table_row_limit_quantity = get_option('table_'.$i.'_'.$params,'pricing_table_row_limit_quantity');

            if($i){
                $dataSerial = DB::table('pricing_table_serial')->where('table_serial',$i)->where('table_layouts',$params)->first();

                $tr_serial_array=[];
                if($dataSerial != null){
                    $dataSerial = json_decode($dataSerial->table_data);
                    foreach($dataSerial as $data){
                        $tr_serial = explode("_",$data);
                        $tr_serial_array[] = (int)$tr_serial[1];
                    }
                }

                $total_row = range(1, $table_row_limit_quantity);
                uksort($total_row,function ($a, $b) use ($tr_serial_array) {
                foreach($tr_serial_array as $key => $value){
                    if($a==$value){
                        return 0;
                        break;
                    }
                    if($b==$value){
                          return 1;
                          break;
                        }
                    }
                });
            }

            foreach($total_row  as $key =>$value) {
                $j=$key;
                $title = DB::table('content_fields')
                            ->where('field', 'table_row_heading_'.$i.$j.'_'.$params)
                            ->first('value');
                $title = trim(strip_tags($title->value));
                $titleDescription['title'] = $title;

                $description = DB::table('options')
                                    ->where('option_key','row_description')
                                    ->where('option_group','row_description_'.$i.$j.'_'.$params)
                                    ->first('option_value');
                if($description){
                    $description = trim(strip_tags($description->option_value));
                }

                $titleDescription['description'] = $description;

                $fainalData[] = $titleDescription;
            };

        }

        return response()->json(['data' => $fainalData], 200);
    }
    function setDefaultTimezone(){
        Config::set('app.timezone', "Europe/Berlin");
        Config::save(array('app'));
    }

}
