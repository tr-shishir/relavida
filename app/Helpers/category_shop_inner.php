<?php
if (!function_exists('category_shop_inner_show')) {
    function category_shop_inner_show($id){
        $para = $id;
        $categories = DB::table('categories_items')->where('rel_id', $para)->get();
        $data ='';
        $count = count($categories);
        if($count > 0){
            $i = 0;
            $itemAdd = [];
            $data = sprintf("<span><b>Kategorie</b>: ");
            foreach($categories as $category){
                if($i < 3){
                    $item = get_category_by_id($category->parent_id);
                    if($item){
                        $url = site_url()."shop/".$item['url'];
                        $url = site_url()."shop/".$item['url'];
                        if(!in_array($item['title'], $itemAdd)){
                            $data .= sprintf("<a class='shop-inner-cat' href='%s'>%s</a>  ", $url, $item['title']);
                            $i++;
                            if($i < 3){
                                $data .= sprintf(", ");
                            }
                        }
                        array_push($itemAdd, $item['title']);
                    }
                } else{
                    break;
                }
            }
            if($i<3){
                $len = strlen($data);
                $data = substr($data, 0, ($len-2));
            }
            $data .= sprintf("</span><br>");
        } else{
            $data = sprintf("<span><b>Kategorie</b>: This product have no category</span><br>");
        }
        $sku = DB::table('content_data')->where('content_id', $id)->where('field_name', "sku")->first();
        if(empty($sku->field_value) or !isset($sku->field_value)){
            $data .= sprintf("<span><b>SKU Number</b>: </span>");
        }
        return $data;
    }
}

if (!function_exists('category_is_hide_for_bundle')) {
    function category_is_hide_for_bundle($id)
    {
        $categorie = DB::table('categories')
            ->join('categories_items', 'categories_items.parent_id', '=', 'categories.id')
            ->where('categories_items.rel_id', $id)
            ->get('is_hidden');
        $is_hide = collect($categorie)->where('is_hidden', '1')->toArray();
        if (isset($is_hide) && !empty($is_hide)) {
            return false;
        }
        return true;
    }
}