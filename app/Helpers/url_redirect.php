<?php


if (!function_exists('dt_url_redirect_redirectUrl')) {
    function dt_url_redirect_redirectUrl(){
        $path = url_path();
        $url =  url_segment();
        $last_url =  end($url);
        $deletedUrl = DB::table('delete_product_info')->where('product_url',$path)->first();
        if(!isset($deletedUrl) and empty($deletedUrl)) {
            $content_url = DB::table('content')->where('url',$last_url)->first();
            $cat_url = DB::table('categories')->where('url',$last_url)->first();
            if(!$content_url && !$cat_url){
                if((int)substr($path,-4)){
                    header("Location: ".site_url());
                    exit();
                }
            }
            if($path == 'shop/'.$last_url){
                if(!$cat_url){
                    header("Location: ".site_url());
                    exit();
                }
            }
        }
        else {
            $category = DB::table('categories')->where('url',$deletedUrl->category_url)->first();
            if(isset($category) and !empty($category)) {
                $has_product = DB::table('categories_items')->where('parent_id', $category->id)->get();
                if(isset($has_product) and !empty($has_product)){
                    // $has_data = DB::table('content')->where('url',$path)->get();
                    if(count($has_product) > 1 ){
                        header("Location: ".site_url()."shop/".$deletedUrl->category_url);
                        exit();
                    }else{
                        header("Location: ".site_url());
                        exit();
                    }
                    // if(count($has_product) == 2){
                    //     if(isset($has_data)){
                    //         header("Location: ".site_url());
                    //         exit();
                    //     }
                    // }
                    //  else {
                        // header("Location: ".site_url()."shop/".$item->category_url);
                        // exit();
                    // }
                }

            }else{
                header("Location: ".site_url());
                exit();
            }
        }
    }
}