<?php

namespace MicroweberPackages\App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use MicroweberPackages\Content\Content;
use Illuminate\Support\Facades\DB;

class RssController extends Controller
{
    public function __construct()
    {
        View::addNamespace('rss', __DIR__ . '/../../resources/views/rss');
    }

    public function index(Request $request)
    {
        if (mw_is_installed()) {
            //TODO event_trigger('mw_cron');
        }

        $contentData = [];

        if ($request->lang && $this->isMutilangOn() && is_lang_supported($request->lang)) {
            change_language_by_locale($request->lang);
        }

        $cont = get_content('is_active=1&is_deleted=0&limit=2500&orderby=updated_at desc');

        $siteTitle = app()->option_manager->get('website_title', 'website');
        $siteDesc = app()->option_manager->get('website_description', 'website');

        if (!empty($cont)) {
            foreach ($cont as $k => $item) {
                $tmp = [];
                $tmp['url'] = $item['url'];
                $tmp['title'] = $item['title'];
                $tmp['description'] = content_description($item['id']);

                if ($request->images == 1) {
                    $imgUrl = get_picture($item['id']);
                    if (!empty($imgUrl)) {
                        $imgData = $this->getFileData($imgUrl);

                        $tmp['image_url'] = $imgUrl;
                        $tmp['image_size'] = $imgData['size'];
                        $tmp['image_type'] = $imgData['type'];
                    }
                }
                $contentData[] = $tmp;
            }
        }

        $data = [
            'siteTitle' => $siteTitle,
            'siteDescription' => $siteDesc,
            'siteUrl' => mw()->url_manager->hostname(),
            'rssData' => $contentData,
        ];

        return response()
            ->view('rss::index', $data)
            ->header('Content-Type', 'text/xml');
    }

    public function products(Request $request)
    {
        $contentData = [];

        if ($request->lang && $this->isMutilangOn() && is_lang_supported($request->lang)) {
            change_language_by_locale($request->lang);
        }

        $siteTitle = app()->option_manager->get('website_title', 'website');
        $siteDesc = app()->option_manager->get('website_description', 'website');

        $products = get_content('is_active=1&is_deleted=0&subtype=product&limit=2500&orderby=updated_at desc');

        if (!empty($products)) {
            foreach ($products as $product) {
                $tmp = [];

                $picture = get_picture($product['id']);
                $priceData = get_product_prices($product['id'], false);
                $price = !empty($priceData['price']) ? $priceData['price'] : null;

                $tmp['title'] = $product['title'];
                $tmp['description'] = $product['description'];
                $tmp['url'] = $product['url'];
                $tmp['image'] = $picture;
                $tmp['price'] = $price;

                $contentData[] = $tmp;
            }
        }

        $data = [
            'siteTitle' => $siteTitle,
            'siteDescription' => $siteDesc,
            'siteUrl' => mw()->url_manager->hostname(),
            'rssData' => $contentData,
        ];

        return response()
            ->view('rss::products', $data)
            ->header('Content-Type', 'text/xml');
    }

    public function blogs(Request $request)
    {
        $contentData = [];

        if ($request->lang && $this->isMutilangOn() && is_lang_supported($request->lang)) {
            change_language_by_locale($request->lang);
        }

        $siteTitle = app()->option_manager->get('website_title', 'website');
        $siteDesc = app()->option_manager->get('website_description', 'website');

        $posts = get_content('is_active=1&is_deleted=0&subtype=post&limit=2500&orderby=updated_at desc');

        // dd($posts);

        if (!empty($posts)) {
            foreach ($posts as $post) {
                if ($post['is_rss'] == 0) {
                $category = "";
                $cat = DB::table('categories_items')->where('rel_id', $post['id'])->get();
                if (count($cat) > 0) {
                    foreach ($cat as $c) {
                        $cat_details = DB::table('categories')->where('id', $c->parent_id)->first();
                        if ($cat_details) {
                            $category .= $cat_details->title . ", ";
                        }
                    }
                }
                $tmp = [];

                $url = $post['url'];
                $url = explode("/", $url);
                $tmp['slug'] = array_pop($url);


                $picture = get_picture($post['id']);

                $status = \Config::get('custom.blog_status');

                if(@$status == 1 or $post['require_login'] == 1) {
                    $limit = blog_word_limit();
                    $make_the_limit = last_word_check(limitTextWords($post['content'],$limit,true,true));
                    $make_the_limit['text'] = $post['content'];
                    $get_content_with_html = random_word_check($make_the_limit) ?? $post['content'];
                    $post['content'] = $get_content_with_html.'<br><span style="overflow: hidden;position: relative;display: block;"><a target="_blank" href="'.url("/").'#loginModal" class="dtModalBtn" style="float: right;background-color: #4592ff;color: #fff;padding: 15px 35px;border-radius: 5px;display: inline-block;text-decoration: none;">Einloggen und Bericht in voller L???nge kostenfrei lesen</a></span>';
                }else{
                    $post['content'];
                }

                $tmp['id'] = $post['id'];
                $tmp['title'] = $post['title'];
                $tmp['subtype'] = $post['subtype'];
                $tmp['parent'] = $post['parent'];
                $tmp['description'] = $post['content'];
                $tmp['url'] = $post['url'];
                $tmp['image'] = $picture;
                $tmp['category'] = $category;
                $tmp['created_at'] = date('Y-m-d', strtotime($post['created_at']));
                $tmp['author'] = user_name($post['created_by'], $mode = 'full');

                $contentData[] = $tmp;
                }
            }
        }
        $data = [
            'siteTitle' => $siteTitle,
            'siteDescription' => $siteDesc,
            'siteUrl' => mw()->url_manager->hostname(),
            'rssData' => $contentData,
        ];
        return response()
            ->view('rss::blog', $data)
            ->header('Content-Type', 'text/xml');
    }

    private function getFileData($urlPath)
    {
        $size = null;
        $type = '';
        $data = get_headers($urlPath, 1);

        if (isset($data['Content-Length'])) {
            $size = $data['Content-Length'];
        }

        if (isset($data['Content-Type'])) {
            $type = $data['Content-Type'];
        }

        $res = [
            'size' => $size,
            'type' => $type
        ];

        return $res;
    }

    private function isMutilangOn()
    {
        if (
            is_module('multilanguage')
            && get_option('is_active', 'multilanguage_settings') === 'y'
            && function_exists('multilanguage_get_all_category_links')
        ) {
            $res = true;
        } else {
            $res = false;
        }

        return $res;
    }
}
