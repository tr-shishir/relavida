<?php

/**
 * Created by Visual Studio Code.
 * User: Zunaid Miah
 * Date: 10/25/2021
 * Time: 11:14 AM
 */
function handling_time($data){
    $has = DB::table('handling_time')->where('data', $data)->first();
    if($has == null or $has->text == null){
        if($data == 1){
            return "lieferbar - innerhalb 24 Stunden bei Ihnen";
        }
        elseif($data % 7 == 0){
            $division = $data/7;
            return "lieferbar in {$division} Wochen";
        } else{
            $data1 = ($data-1);
            return "lieferbar - innerhalb {$data1}-{$data} Werktagen bei Ihnen";
        }
    } else{
        return $has->text;
    }
}

function image_set_to_server($image){
    if(strpos($image->filename, '{SITE_URL}') !== false){
        DB::table('products')->where('content_id', $image->rel_id)->where('image', 'not like', '%{SITE_URL}%')->update(['image' => $image->filename]);
        return str_replace('{SITE_URL}', site_url(), $image->filename);
    } else{
        $dateByDay = date('Ymd');
        $folder = public_path('userfiles/media/templates.microweber.com/default/'.$dateByDay.'/');
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        $filename = basename($image->filename);
        $savePath = public_path('userfiles/media/templates.microweber.com/default/'.$dateByDay.'/'.$filename);
        try {
            $new_image = Image::make($image->filename)->save($savePath);
            $image_name = '{SITE_URL}userfiles/media/templates.microweber.com/default/'.$dateByDay.'/'.$new_image->basename;
            DB::table('media')->where('id', $image->id)->update(['filename' => $image_name]);
            DB::table('products')->where('content_id', $image->rel_id)->where('image', 'not like', '%{SITE_URL}%')->update(['image' => $image_name]);
            
            return str_replace('{SITE_URL}', site_url(), $image_name);
        }catch(Exception $e){
            return false;
        }

    }
}

function generate_shop_categories_api($categories, $rel_id = false,  $parent_id = false, $hidden = false, $dept = 0){
    if ($rel_id) {
        $html = '<!doctype html>
        <html lang="en">
          <head>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
            <title>Category Status - Droptienda</title>
            <style>
                .category-list-with-nesting {
                    position: relative;
                }

                ul.clwn-list {
                    position: relative;
                    padding: 0px;
                    list-style-type: none;
                    border: 1px solid #000;
                    border-radius: 5px;
                    padding: 10px;
                    background-color: #f0f9ff;
                }

                ul.clwn-list li {
                    position: relative;
                    display: block;
                    width: 100%;
                    overflow: hidden;
                    
                }
                ul.clwn-list li ul {
                    padding-left: 20px;
                }
                ul.clwn-list li>span:first-child {
                    width: 10%;
                    position: relative;
                }

                ul.clwn-list li>span:nth-child(2) {
                    width: 40%;
                    position: relative;
                }

                ul.clwn-list li>span:nth-child(3) {
                    width: 10%;
                }

                ul.clwn-list li>span:nth-child(4) {
                    width: 10%;
                }

                ul.clwn-list li>span:nth-child(5) {
                    width: 15%;
                }

                ul.clwn-list li>span:nth-child(6) {
                    width: 15%;
                }

                ul.clwn-list li>span {
                    display: inline-block;
                    background-color: #e5e5e5;
                    position: relative;
                    margin-bottom: 3px;
                    padding: 5px 20px !important;
                    float: left;
                }
                ul.clwn-list li:nth-child(odd)>span {
                    background-color: hsl(206deg 100% 74%);
                }

                ul.clwn-list li:nth-child(even)>span {
                    background-color: hsl(206deg 100% 74%);
                }
                .list-label>span{
                    font-weight: 700;
                    font-size:16px;
                }
                </style>
          </head>
          <body style="background-color: #7ed2e4;">
          <div class="container">
          <div class="category-list-with-nesting">
          <ul class="clwn-list">
          <li class="list-label">
            <span>ID</span>
            <span>Title</span> 
            <span>Parent</span>
            <span>Hidden</span>
            <span>Product Count</span>
            <span>Show Front</span>
        </li>';
        foreach ($categories as $category) {
            $dept = 0;
            if ($category->rel_id != $rel_id) {
                continue;
            }
            $print = '<span class="badge badge-success">Show</span>';
            $value = 0;
            if($category->status == 0){
                $print = '<span class="badge badge-danger">Hidden</span>';
                $value = 1;
            }
            $front = '<span class="badge badge-danger">No</span>';
            $count = DB::table('categories_items')
                        ->where('parent_id', $category->id)
                        ->count('parent_id');
            if(isset($count) and $count >= 1 and $value == 0){
                $front = '<span class="badge badge-success">Yes</span>';
            }
            
            $html .= '<li><span class="category-id">'. $category->id .'</span><span class="category-title">'. $category->title .'</span><span class="category-parent">0</span><span class="category-is-hidden">'. $print .'</span><span class="category-product-count">'. $count .'</span><span class="category-show-front">'. $front .'</span>';
          $has_child = DB::table('categories')
                        ->where('is_deleted',0)
                        ->whereNotNull('title')
                        ->where('parent_id', $category->id)
                        ->first();
            if(isset($has_child)){
                $childCategories= DB::table('categories')
                    ->where('is_deleted',0)
                    ->whereNotNull('title')
                    ->where('parent_id', $category->id)
                    ->where('rel_type', 'content')
                    ->orderBy('position', 'asc')
                    ->get();
                $html .= generate_shop_categories_api($childCategories,false, $category->id , $value);
            }
            $html .= '</li>';
        }
        $html .= '</ul></div>
                        </div>
                        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
                        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
                    </body>
                    </html>';
    }
    elseif ($parent_id) {
        // $html = '<ul data-category-id="' . $parent_id . '" class=" depth-'.$dept.' category-item-' . $parent_id . '">';
        $html = '<ul>';
        foreach ($categories as $category) {
            if ($category->parent_id != $parent_id) {
                continue;
            }
            $print = '<span class="badge badge-success">Show</span>';
            $value = 0;
            if($category->status == 0 or $hidden == 1){
                $print = '<span class="badge badge-danger">Hidden</span>';
                $value = 1;
            }
            $front = '<span class="badge badge-danger">No</span>';
            $count = DB::table('categories_items')
                        ->where('parent_id', $category->id)
                        ->count('parent_id');
            if(isset($count) and $count >= 1 and $value == 0){
                $front = '<span class="badge badge-success">Yes</span>';
            }
            $html .= '<li><span class="category-id">'. $category->id .'</span><span class="category-title">'. $category->title .'</span><span class="category-parent">'. $parent_id .'</span><span class="category-is-hidden">'. $print .'</span> <span class="category-product-count">'. $count .'</span><span class="category-show-front">'. $front .'</span>';
          $has_child = DB::table('categories')
                        ->where('is_deleted',0)
                        ->whereNotNull('title')
                        ->where('parent_id', $category->id)
                        ->first();
            if(isset($has_child)){
                $childCategories= DB::table('categories')
                    ->where('is_deleted',0)
                    ->whereNotNull('title')
                    ->where('parent_id', $category->id)
                    ->where('rel_type', 'content')
                    ->orderBy('position', 'asc')
                    ->get();
                $html .= generate_shop_categories_api($childCategories,false, $category->id , $hidden);
            }
            $html .= '</li>';
        }
        $html .= '</ul>';
    }
    return ($html);
}

function user_can_access_item($modules = null){
    $user = Cache::remember('previlege_access_role'.user_id(), 20, function () {
        return DB::table('users')->where('id', user_id())->first();
    });
    // $user = DB::table('users')->where('id', user_id())->first();
    if (!$user) {
        return false;
    }
    if ($user->is_admin == 1) {
        return true;
    }
    if($modules == null and $user->previllege_id != 0){
        return true;
    }
    $accessDataSet = '';
    if(isset($user->previlege_access) and $user->previlege_access != null){
        $accessDataSet = json_decode($user->previlege_access, true);
    }else{
        $accessDataSet = create_user_access_set($user->previllege_id, true);
        $accessDataSet = json_decode($accessDataSet, true);
    }
    if(empty($accessDataSet)){
        return false;
    }
    if(array_key_exists($modules, $accessDataSet)){
        if($accessDataSet[$modules] == 1){
            return true;
        }
    }
    return false;

}

function create_user_access_set($id, $status = false){
    $previllegeData =  DB::table('admin_previllege_roles')
                        ->join('admin_role_accesses', 'admin_previllege_roles.id', '=', 'admin_role_accesses.role_id')
                        ->where('admin_previllege_roles.id', $id)
                        ->get()
                        ->toArray();
    $dataSet = [];
    foreach($previllegeData as $data){
        $key = "module.{$data->modules}";
        if(isset($data->is_live_edit)){
            $dataSet[$key.".liveEdit"] = $data->is_live_edit;
        }
        if(isset($data->is_only_own)){
            $dataSet[$key.".onlyOwn"] = $data->is_only_own;
        }
        if(isset($data->is_view)){
            $dataSet[$key.".view"] = $data->is_view;
        }
        if(isset($data->is_create)){
            $dataSet[$key.".create"] = $data->is_create;
        }
        if(isset($data->is_update)){
            $dataSet[$key.".edit"] = $data->is_update;
        }
        if(isset($data->is_delete)){
            $dataSet[$key.".destroy"] = $data->is_delete;
        }
    }
    if(!$status){
        DB::table('users')->where('previllege_id', $id)
                        ->update(['previlege_access' => json_encode($dataSet)]);
    }
    else{
        return json_encode($dataSet);
    }
}

function hasDashboardAccess(){
    $user = Cache::remember('previlege_access_role'.user_id(), 20, function () {
        return DB::table('users')->where('id', user_id())->first();
    });
    $accessDataSet = '';
    if(isset($user->previlege_access) and $user->previlege_access != null){
        $accessDataSet = json_decode($user->previlege_access, true);
    }else{
        $accessDataSet = create_user_access_set($user->previllege_id, true);
        $accessDataSet = json_decode($accessDataSet, true);
    }
    if(empty($accessDataSet)){
        return false;
    }
    if(array_key_exists('module.posts.edit', $accessDataSet) and $accessDataSet['module.posts.edit'] == 1){
        return admin_url('view:content/action:posts');
    }
    if(array_key_exists('module.posts.create', $accessDataSet) and $accessDataSet['module.posts.create'] == 1){
        return admin_url('view:content/action:posts');
    }
    if(array_key_exists('module.pages.edit', $accessDataSet) and $accessDataSet['module.pages.edit'] == 1){
        return admin_url('view:content/action:pages');
    }
    if(array_key_exists('module.pages.create', $accessDataSet) and $accessDataSet['module.pages.create'] == 1){
        return admin_url('view:content/action:pages');
    }
    if(array_key_exists('module.products.edit', $accessDataSet) and $accessDataSet['module.products.edit'] == 1){
        return admin_url('view:shop/action:products');
    }
    if(array_key_exists('module.products.create', $accessDataSet) and $accessDataSet['module.products.create'] == 1){
        return admin_url('view:shop/action:products');
    }
}

function product_add_at_user_group($p_id, $g_id, $status = false){
    if($status){
        DB::table('group_product')->where('product_id',$p_id)->delete();
    }
    $dataset = array();
    foreach($g_id as $groupID){
        $dataset[]=[
            'product_id'=>$p_id,
            'group_id'=>$groupID
        ];
    }
    DB::table('group_product')->insert($dataset);
}

function productHasGroup($id){
    $group_id = user_group_id();
    $hasAccess = DB::table('group_product')->where('product_id', $id)->where('group_id', $group_id)->first();
    if(isset($hasAccess) and !empty($hasAccess)) return true;
    else return false;
}