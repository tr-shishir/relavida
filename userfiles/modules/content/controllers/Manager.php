<?php


namespace content\controllers;

use App\Models\Content;
use App\Models\Products;
use MicroweberPackages\View\View;

class Manager
{
    public $app = null;
    public $views_dir = 'views';
    public $provider = null;
    public $category_provider = null;
    public $event_manager = null;

    function __construct($app = null)
    {
        if (!is_object($this->app)) {
            if (is_object($app)) {
                $this->app = $app;
            } else {
                $this->app = mw();
            }
        }
        $this->views_dir = dirname(__DIR__) . DS . 'views' . DS;
        $this->provider = $this->app->content_manager;
        $this->category_provider = $this->app->category_manager;
        $this->event_manager = $this->app->event_manager;
    }

    function index($params)
    {
        if (!user_can_access('module.content.index')) {
            return;
        }

        if (isset($params['manage_categories'])) {
            print load_module('categories/manage', $params);
            return;
        }

        if (isset($params['is_shop']) and $params['is_shop'] == 'y') {
            $params['is_shop'] = 1;
        } else if (isset($params['is_shop']) and $params['is_shop'] == 'n') {
            $params['is_shop'] = 0;
        }


        $no_page_edit = false;
        $posts_mod = array();
        $posts_mod = array();
        // $posts_mod['type'] = 'content/admin_posts_list';
        if (isset($params['data-page-id'])) {
            $posts_mod['page-id'] = $params['data-page-id'];
        }

        if (isset($params['no_page_edit'])) {
            $no_page_edit = $params['no_page_edit'];
        }
        if (isset($params['keyword'])) {
            $posts_mod['search_by_keyword'] = $params['keyword'];
        }
        if (isset($params['brand'])) {
            $posts_mod['search_by_brand'] = $params['brand'];
        }
        if (isset($params['ean'])) {
            $posts_mod['search_by_ean'] = $params['ean'];
        }
        if (isset($params['sku'])) {
            $posts_mod['search_by_sku'] = $params['sku'];
        }
        if (isset($params['content_type']) and $params['content_type'] != false) {
            $posts_mod['content_type'] = $params['content_type'];
        }
        if (isset($params['subtype']) and $params['subtype'] != false) {
            $posts_mod['subtype'] = $params['subtype'];
        }
        if (isset($params['is_shop']) and $params['is_shop'] == 1) {
            $posts_mod['content_type'] = 'product';
        } else if (isset($params['is_shop']) and $params['is_shop'] == 0) {
            //  $posts_mod['subtype'] = 'post';
            $posts_mod['content_type'] = 'post';
        }

        if (isset($params['content_type']) and $params['content_type'] == 'product') {
            $posts_mod['content_type'] = 'product';
            // $posts_mod['content_type'] = 'post';
        }

        if (isset($params['content_type']) and $params['content_type'] == 'post') {
            if (!isset($params['subtype']) or $params['subtype'] == false) {
                //	$posts_mod['subtype'] = 'post';
            }
        }


        if (isset($params['content_type_filter']) and $params['content_type_filter'] != '') {
            $posts_mod['content_type'] = $params['content_type_filter'];
        }
        if (isset($params['subtype_filter']) and $params['subtype_filter'] != '') {
            $posts_mod['subtype'] = $params['subtype_filter'];
        }


        if (!isset($params['category-id']) and isset($params['page-id']) and $params['page-id'] != 'global') {
            $check_if_exist = $this->provider->get_by_id($params['page-id']);
            if (is_array($check_if_exist)) {
                if (isset($check_if_exist['is_shop']) and trim($check_if_exist['is_shop']) == 1) {
                    //  $posts_mod['subtype'] = 'product';
                }
            }
        }
        $page_info = false;
        if (isset($params['page-id'])) {
            if ($params['page-id'] == 'global') {
                if (isset($params['is_shop']) and $params['is_shop'] == 1) {
                    $page_info = $this->provider->get('limit=1&one=1&content_type=page&is_shop=0');
                }
            } else {
                $page_info = $this->provider->get_by_id($params['page-id']);
                if (isset($page_info['is_shop']) and trim($page_info['is_shop']) == 1) {
                    //  $posts_mod['subtype'] = 'product';
                }
            }
        }


        if (isset($params['category-id']) and $params['category-id'] != 'global') {
            $check_if_exist = $this->category_provider->get_page($params['category-id']);

            if (is_array($check_if_exist)) {
                $page_info = $check_if_exist;
                if (isset($check_if_exist['is_shop']) and trim($check_if_exist['is_shop']) == 1) {
                    $posts_mod['content_type'] = 'product';
                } else {
                    // $posts_mod['subtype'] = $check_if_exist['subtype'];
                }
            }
        }
        $posts_mod['paging_param'] = 'pg';


        $posts_mod['orderby'] = 'position desc';
        if (isset($params['data-order'])) {
            $posts_mod['orderby'] = $params['data-order'];
        }

        if (isset($posts_mod['page-id'])) {
            $posts_mod['parent'] = $posts_mod['page-id'];
        }

        if (isset($params['pg'])) {
            $posts_mod['pg'] = $params['pg'];
        }
        if (isset($params['tags'])) {
            $posts_mod['tags'] = $params['tags'];
        }

        if (isset($params['data-category-id'])) {
            $posts_mod['category'] = $params['data-category-id'];
        } else if (isset($params['parent-category-id'])) {
            $posts_mod['category'] = $params['parent-category-id'];
        } elseif (isset($params['category-id'])) {
            $posts_mod['category'] = $params['category-id'];
        }

        if (isset($params[$posts_mod['paging_param']])) {
            $posts_mod['page'] = $params[$posts_mod['paging_param']];
        }

        $keyword = false;
        if (isset($posts_mod['search_by_keyword'])) {
            $keyword = strip_tags($posts_mod['search_by_keyword']);
        }
        $brand = false;
        if (isset($posts_mod['search_by_brand'])) {
            $brand = strip_tags($posts_mod['search_by_brand']);
        }
        $sku = false;
        if (isset($posts_mod['search_by_sku'])) {
            $sku = strip_tags($posts_mod['search_by_sku']);
        }
        $ean = false;
        if (isset($posts_mod['search_by_ean'])) {
            $ean = strip_tags($posts_mod['search_by_ean']);
        }

        if (isset($params['parent-page-id'])) {

            $posts_mod['parent'] = intval($params['parent-page-id']);

        }



        if (!empty($params['filter'])) {
            $posts_mod['filter'] = $params['filter'];

        }

        $posts_mod['no_cache'] = 1;

//        filter add in product live edit popup

        $params['exclude_shorthand'] = 'keyword, data-keyword';

        $current_page = $current_page = 1;
        $post_params = $params;
        $tag_param = 'tags';
        $option = get_option('content_limit_for_live_edit_module','content_limit_for_live_edit_module');

        $reorder_existing_position = get_option('reorder_existing_position','reorder_existing_position');

        if($reorder_existing_position ==  false){
            reorder_existing_position();
            save_option('reorder_existing_position','true','reorder_existing_position');

        }
        if($params['data-id'] == "mw_posts_manage_live_edit"){
            // $pages = get_content('content_type=product&limit=1000') ?? [];
            $posts_mod['limit'] = 15;
            $post_params['limit'] = ($option != false) ? $option : 50;
        }else{
            $posts_mod['limit'] = 15;
            $post_params['limit'] = ($option != false) ? $option : 50;
        }
        if (isset($post_params['id'])) {
            $paging_param = 'current_page' . crc32($post_params['id']);
            unset($post_params['id']);
        }
        if (isset($params['data-tags-param'])) {
            $tag_param = $params['data-tags-param'];
        }

        $cat_from_url = get_category_id_from_url();
        $posts_parent_related = false;
        $posts_list_show_sub_pages = false;

        $related_category_ids = false;
        $exclude_category_ids = false;

        $is_search_global = false;

        $tags_val = false;

        if (isset($params[$tag_param])) {
            $tags_val = $params[$tag_param];
        }
        if (isset($params['data-tags'])) {
            $tags_val = $params['data-tags'];
        }

        if (!$tags_val) {
            $current_tags_from_url = url_param($tag_param);
            if ($current_tags_from_url != false) {
                $tags_val = $current_tags_from_url;
            }

        }
        if (!$tags_val) {
            $tags_val = get_option('data-tags', $params['id']);
        }


        if ($tags_val and is_string($tags_val)) {
            $tags_val = explode(',', $tags_val);
            $tags_val = array_trim($tags_val);
            $tags_val = array_filter($tags_val);
            $tags_val = array_unique($tags_val);
            $tags_val = implode(',', $tags_val);
        }
        if ($tags_val) {
            $post_params['tags'] = $tags_val;
        }

        $show_fields = false;
        if (isset($post_params['data-show'])) {
            $show_fields = $post_params['data-show'];
        }
        if (isset($post_params['show'])) {
            $show_fields = $post_params['show'];
        }


        $set_content_type_from_opt = get_option('data-content-type', $params['id']);

        $show_fields1 = get_option('data-show', $params['id']);
        if ($show_fields1 != false and is_string($show_fields1) and trim($show_fields1) != '') {
            $show_fields = $show_fields1;
        }
        if ($show_fields != false and is_string($show_fields)) {
            $show_fields = explode(',', $show_fields);
        }

        if (!empty($params['filter'])) {
            $post_params['filter'] = $params['filter'];
        }


        if (isset($post_params['most_ordered'])) {
            $str0 = 'table=cart&limit=30&rel_type=content&fields=rel_id&order_by=id desc';
            $orders = db_get($str0);
            if (!empty($orders)) {
                $ids = array();
                foreach ($orders as $order) {
                    $ids[] = $order['rel_id'];
                }
                $post_params['ids'] = $ids;
            }
        }
        if (isset($post_params['recently_viewed'])) {
            if (defined("MAIN_PAGE_ID") and defined("CONTENT_ID")) {
                $str0 = 'table=stats_pageviews&limit=30&main_page_id=' . MAIN_PAGE_ID . '&page_id=[neq]' . CONTENT_ID . '&fields=page_id&order_by=id desc&no_cache=true';
                $orders = db_get($str0);
                if (!empty($orders)) {
                    $ids = array();
                    foreach ($orders as $order) {
                        $ids[] = $order['page_id'];
                    }
                    $post_params['ids'] = $ids;
                }
            }
        }

        if (!isset($params['order_by']) and isset($params['order-by'])) {
            $params['orderby'] = $post_params['orderby'] = $params['order-by'];
        }


        if (isset($params['subtype_value'])) {
            $post_params['subtype_value'] = $params['subtype_value'];
        }

        $schema_org_item_type = false;
        $schema_org_item_type_tag = false;


        if (isset($post_params['content_type']) and $post_params['content_type'] == 'page') {
            $schema_org_item_type = 'WebPage';

        } else if (isset($post_params['content_type']) and $post_params['content_type'] == 'post') {
            if (isset($post_params['subtype']) and $post_params['subtype'] != $post_params['content_type']) {
                $schema_org_item_type = $post_params['subtype'];

            } else {
                $schema_org_item_type = 'Article';
            }
        } else if (isset($post_params['content_type']) and $post_params['content_type'] == 'product') {
            if (isset($post_params['subtype']) and $post_params['subtype'] != $post_params['content_type']) {
                $schema_org_item_type = $post_params['subtype'];

            } else {
                $schema_org_item_type = 'Product';
            }
        }


        if ($schema_org_item_type != false) {
            $schema_org_item_type = ucfirst($schema_org_item_type);
            $schema_org_item_type_tag = ' itemtype="http://schema.org/' . $schema_org_item_type . '" ';
            $schema_org_item_type_tag = 'http://schema.org/' . $schema_org_item_type;
        }

        $ord_by = get_option('data-order-by', $params['id']);
        $cfg_data_hide_paging = get_option('data-hide-paging', $params['id']);
        $cfg_show_only_in_stock= get_option('filter-only-in-stock', $params['id']);


        if ($ord_by != false and trim($ord_by) != '') {
            $post_params['orderby'] = $ord_by;
        }

        $date_format = get_option('date_format', 'website');
        if ($date_format == false) {
            $date_format = "Y-m-d H:i:s";
        }

        if (isset($params['title'])) {

            unset($post_params['title']);
        }

        $post_params['is_active'] = 1;
        $post_params['is_deleted'] = 0;

        if($cfg_show_only_in_stock){
            $post_params['filter-only-in-stock'] = true;
        }

        if (((!isset($post_params['parent']) and !isset($post_params['category'])
                or isset($post_params['category']) and empty($post_params['category']))
            and $cat_from_url != false and trim($cat_from_url) != '')
        ) {
            $post_params['category'] = ($cat_from_url);
        }

        if (isset($params['content_type']) and $params['content_type'] == 'all') {
            unset($post_params['content_type']);
            unset($post_params['subtype']);
        }


        if (isset($params['search-parent'])) {
            $sub_content = get_content_children($params['search-parent']);
            if (!empty($sub_content)) {
                $post_params['ids'] = $sub_content;
                unset($post_params['parent']);
            }
        }
        if (isset($params['data-id'])) {
            unset($post_params['data-id']);
        }

        if ($posts_parent_related == false) {
            if (isset($post_params['category']) and is_string($post_params['category'])) {
                $sub_categories = array();
                $sub_categories[] = $post_params['category'];
                $more = get_category_children($post_params['category']);
                if ($more != false and is_array($more)) {
                    foreach ($more as $item_more_subcat) {
                        $sub_categories[] = $item_more_subcat;
                    }
                }
                //$post_params['category']
                $post_params['category'] = $sub_categories;
                //$post_params['category'] = $post_params['category'];
            } else if (isset($post_params['category']) and is_array($post_params['category']) and empty($post_params['category']) and isset($post_params['related']) and $post_params['related'] != false) {
                if (defined('CATEGORY_ID') and CATEGORY_ID > 0) {

                    $post_params['category'] = CATEGORY_ID;


                }

            }
        }

        if (!isset($post_params['exclude_ids'])) {
            if (defined('POST_ID') and isset($posts_parent_category) and $posts_parent_category != false or isset($post_params['related'])) {
                $post_params['exclude_ids'] = POST_ID;
            }
        }

        if (!isset($params['order_by'])) {
//            if(isset($post_params['content_type']) and $post_params['content_type'] == 'page'){
//                $post_params['order_by'] = 'position asc';
//            } else {
//
//            }
            $post_params['order_by'] = 'position desc';
        }

        if (isset($params['search_in_fields']) and $params['search_in_fields'] != false) {
            $post_params['search_in_fields'] = $params['search_in_fields'];
        }


        if (isset($params['strict_categories']) and $params['strict_categories'] != false) {
            $post_params['strict_categories'] = $params['strict_categories'];
        }

        $is_brand = url_param('brand', 1);
        $is_search = url_param('search');
        // dd($_GET);
        if ($is_search and isset($_GET['search_params'])) {
            $search_params = $_GET['search_params'];
            if ($search_params) {

                //   DB::enableQueryLog();


                $post_params['no_cache'] = $search_params;

                $post_params['search_params'] = $search_params;

            }

        }
        if ($posts_list_show_sub_pages) {
            $post_params['content_type'] = 'page';
            $post_params['parent'] = PAGE_ID;
        }

        //  d($post_params);
        //  d($params);
        // dump($post_params);
        if ($is_search_global and isset($post_params['category'])) {
            unset($post_params['category']);
        }

        $url_action = url_param('action', 1) ?? '';
        if(isset($url_action) && $url_action =='products'){

            if($brand){
                $post_params['brand'] = $params['brand'];
                $posts_mod['brand'] = $params['brand'];
            }
            if($ean){
                $post_params['ean'] = $params['ean'];
                $posts_mod['ean'] = $params['ean'];
            }
            if($sku){
                $post_params['sku'] = $params['sku'];
                $posts_mod['sku'] = $params['sku'];
            }
            // dd($post_params);
        }

        if(isset($url_action) && $url_action =='posts'){
            $blog_post_options = get_option('blog_filter', 'blog_filter_option');
            if (isset($blog_post_options) && !empty($blog_post_options)) {
                if ($blog_post_options == 2) {
                    $post_params = array_merge($post_params, ['is_rss' => 0]);
                } elseif ($blog_post_options == 1 || $blog_post_options == false) {
                    $post_params = $post_params;
                } elseif ($blog_post_options == 3) {
                    $post_params = array_merge($post_params, ['is_rss' => 1]);
                }
            }
        }

        // $data = $this->provider->get($post_params);
//        end
        if(!isset($params['data-no_toolbar'])){
            if(isset($url_action) && $url_action =='posts'){
                $blog_post_options = get_option('blog_filter', 'blog_filter_option');
                if (isset($blog_post_options) && !empty($blog_post_options)) {
                    if ($blog_post_options == 2) {
                        $posts_mod = array_merge($posts_mod, ['is_rss' => 0]);
                    } elseif ($blog_post_options == 1 || $blog_post_options == false) {
                        $posts_mod = $posts_mod;
                    } elseif ($blog_post_options == 3) {
                        $posts_mod = array_merge($posts_mod, ['is_rss' => 1]);
                    }
                }
            }

            // $data = $this->provider->get($posts_mod);
            if(!isset($post_params['keyword']) && !isset($post_params['ean']) && !isset($post_params['brand']) && !isset($post_params['sku']) && !isset($post_params['tags'])){
                $current_page_from_url = (isset($post_params['pg']))?$post_params['pg']:$this->app->url_manager->param($posts_mod['paging_param']);
                $data = Content::with(['media', 'tagged', 'categories'])
                ->where('is_deleted',0);
                if(isset($posts_mod['content_type']) && $posts_mod['content_type'] == "product"){
                    $data = Products::with(['content', 'media', 'tagged', 'categories'])
                            ->contentType($posts_mod['content_type'])
                            ->leftJoin('content', 'content.id','products.content_id');
                }
                if(isset($posts_mod['content_type']) && $posts_mod['content_type'] == "page"){
                    $data = $data->where('content_type',"page");
                }

                if(isset($posts_mod['content_type']) && $posts_mod['content_type'] == "post"){
                    $data = $data->where('content_type',"post");
                    if (isset($blog_post_options) && !empty($blog_post_options)) {
                        if ($blog_post_options == 2) {
                            $data = $data->where('is_rss',0);
                        } elseif ($blog_post_options == 1 || $blog_post_options == false) {

                        } elseif ($blog_post_options == 3) {
                            $data = $data->where('is_rss',1);
                        }
                    }
                }
                if(isset($posts_mod['content_type']) && $posts_mod['content_type'] == "product"){
                    if(isset($post_params['order'])){
                        $order = explode(' ',$post_params['order']);
                        $data = $data->orderBy('content.'.$order[0],$order[1]);
                    }else{
                        $order = explode(' ',$posts_mod['orderby']);
                        $data = $data->orderBy('content.'.$order[0],$order[1]);
                    }
                }elseif(isset($posts_mod['content_type']) && in_array($posts_mod['content_type'],["page","post"])){
                    if(isset($post_params['order'])){
                        $data = $data->orderByRaw($post_params['order']);
                    }else{
                        $data = $data->orderByRaw($posts_mod['orderby']);
                    }
                }
                $data = $data->paginate($posts_mod['limit'], ['*'], 'page', $current_page_from_url)
                ->toArray();

                $newData = collect($data['data'])
                ->map(function($item){
                    $item['url'] = url('/'.$item['url']);
                    $item['content_type'] = $item['content']['content_type']??$item['content_type'];
                    $item['is_rss'] = $item['content']['is_rss']??$item['is_rss'];
                    $item['created_by'] = $item['content']['created_by']??$item['created_by'];
                    if($item['categories']){
                        $newCategory = array_map(function($c_item){
                            return $c_item['category'];
                        },$item['categories']);
                        $item['categories'] = $newCategory;
                    }
                    if($item['media']){
                        $newMedia = collect($item['media'])->where('position',0)->first();
                        $newMedia = ($newMedia) ? $newMedia['filename'] : collect($item['media'])->first()['filename'];
                        $item['media'] = $newMedia;
                    }
                    $item['product'] = true;
                    return $item;
                })
                ->toArray();
                $data = $newData;
            }else{
                $data = $this->provider->get($posts_mod);
            }

        }else{
            if(isset($params['module_id']) && $params['module_id'] != false){
                $category_id = get_option('data-category-id', $params['module_id']);
                if(isset($category_id) && $category_id > 0){
                    $post_params['category'] = $category_id;
                }
                    $tags_val = get_option('data-tags', $params['module_id']);
                if ($tags_val) {

                    if ($tags_val and is_string($tags_val)) {
                        $tags_val = explode(',', $tags_val);
                        $tags_val = array_trim($tags_val);
                        $tags_val = array_filter($tags_val);
                        $tags_val = array_unique($tags_val);
                        $tags_val = implode(',', $tags_val);
                    }
                }

                if ($tags_val) {
                    $post_params['tags'] = $tags_val;
                }
            }
            $data = $this->provider->get($post_params);
            // dd($data);
            if($post_params['content_type'] === "product"){
                $dataIds = collect($data)->pluck('id')->toArray();
                $newData = collect($data)->keyBy('id')->toArray();
                // $dataNew = \DB::table('products')
                // ->whereIn('content_id',$dataIds)
                // ->orderByRaw(\DB::raw('FIELD(content_id, '.implode(', ', $dataIds).')'))
                // ->get()
                // ->map(function($item) use($newData){
                //     $item->content_type = "product";
                //     $item->id = $item->content_id;
                //     $item->is_rss = 0;
                //     $item->rss_link = null;
                //     $item->rss_image = null;
                //     $item->item_unit = null;
                //     $item->created_by = $newData[$item->id]['created_by'];
                //     $item->position = $newData[$item->id]['position'];
                //     $item = (array)$item;
                //     return $item;
                // })->toArray();
            }

        }

        if (empty($data) and isset($posts_mod['page'])) {
            if (isset($posts_mod['paging_param'])) {
                $posts_mod[$posts_mod['paging_param']] = 1;
            }
            unset($posts_mod['page']);


            $data = $this->provider->get($posts_mod);
        }

        $post_params_paging = $posts_mod;
        $post_params_paging['page_count'] = true;


        $pages = $this->provider->get($post_params_paging);


        $this->event_manager->trigger('module.content.manager', $posts_mod);

        $post_toolbar_view = $this->views_dir . 'toolbar.php';

        $toolbar = new View($post_toolbar_view);
        $toolbar->assign('page_info', $page_info);
        $toolbar->assign('keyword', $keyword);
        $toolbar->assign('params', $params);
        $toolbar->assign('pages', $pages);

        if(isset($params['show_only_content'])){
            $post_list_view = $this->views_dir . 'manager_content.php';

        } else {
            $post_list_view = $this->views_dir . 'manager.php';

        }


        if ($no_page_edit == false) {
            if ($data == false) {
                if (isset($posts_mod['category-id']) and isset($page_info['content_type']) and $page_info['content_type'] == 'page' and ($page_info['subtype'] != 'static')) {

                    if (isset($posts_mod['category-id']) and $posts_mod['category-id'] != 0) {

                    } else {

                        $manager = new Edit();
                        $params['quick_edit'] = true;
                        return $manager->index($params);
                    }


                } elseif (isset($page_info['content_type']) and $page_info['content_type'] == 'page' and isset($page_info['subtype'])
                    and isset($page_info['id'])
                ) {


                    if ($page_info['subtype'] != 'dynamic') {
                        $params['quick_edit'] = true;
                        $manager = new Edit();
                        return $manager->index($params);
                    }


                }
            }
        }
        // dd($data);


        $view = new View($post_list_view);
        $view->assign('params', $params);
        $view->assign('page_info', $page_info);
        $view->assign('toolbar', $toolbar);
        $view->assign('data', $data);
        $view->assign('pages', $pages);
        $view->assign('keyword', $keyword);
        $view->assign('post_params', $posts_mod);
        $view->assign('paging_param', $posts_mod['paging_param']);

        return $view->display();
    }
}
