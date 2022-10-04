<?php

namespace MicroweberPackages\Install\Schema;

class Droptienda
{
    public function get()
    {
        return [
            'wishlist_sessions' => [
                'user_id' => 'integer',
                'name' => 'string',
                'updated_at' => 'dateTime',
                'created_at' => 'dateTime',
            ],

            'wishlist_session_products' => [
                'updated_at' => 'dateTime',
                'created_at' => 'dateTime',
                'user_id' => 'integer',
                'wishlist_id' => 'integer',
                'product_id' => 'integer',

            ],

            'dynamic_banners' => [
                'user_id' => 'integer',
                'media_id' => 'integer',
                'coords' => 'string',
                'product_id' => 'integer',
                'updated_at' => 'dateTime',
                'created_at' => 'dateTime',
            ],

            'wishlist_link' => [
                'updated_at' => 'dateTime',
                'created_at' => 'dateTime',
                'user_id' => 'integer',
                'products_id' => 'string',
                'slug' => 'string',
            ],

            'quick_checkout' => [
                'updated_at' => 'dateTime',
                'created_at' => 'dateTime',
                'user_id' => 'integer',
                'products_id' => 'integer',
                'slug' => 'string',
                'is_deliver' => 'string',

            ],

            'legals' => [
                'updated_at' => 'dateTime',
                'created_at' => 'dateTime',
                'term_name' => 'string',
                'description' => 'longText',
                'counter' => 'string',

            ],

            'sync_history' => [
                'sync_type' => 'string',
                'sync_event' => 'string',
                'model_id' => 'integer',
                'synced_at' => 'dateTime',
                'drm_ref_id' => 'integer',
                'tries' => array('type' => 'tinyInteger', 'default' => 0),
                'exception' => 'text',
                'response' => 'text',
                'created_at' => 'dateTime',
                'updated_at' => 'dateTime',
                'deleted_at' => 'dateTime',
            ],

            'tokenurl' => [
                'token' => 'string',
                'url' => 'string',
            ],

            'header_show_hides' => [
                'page_id' => 'integer',
            ],

            'product_upselling' => [
                'serviceName' => 'string',
                'servicePrice' => 'string',
            ],

            'product_upselling_item' => [
                'product_id' => 'integer',
                'item_id' => 'integer',
                'selected' => 'integer',
            ],

            'selected_product_upselling_item' => [
                'product_id' => 'integer',
                'service_id' => 'integer',
                'service_price' => 'string',
                'user_id' => 'integer',
            ],

            'order_with_upselling' => [
                'product_id' => 'integer',
                'service_id' => 'integer',
                'user_id' => 'integer',
                'order_id' => 'integer',
            ],

            'checkout_bumbs' => [
                'product_id' => 'integer',
                'show_cart' => 'integer',
                'show_checkout' => 'integer',
            ],

            'thank_you_pages' => [
                'template_name' => 'integer',
                'product_id' => 'integer',
                'is_active' => 'integer',
            ],

            'iconImage' => [
                'name' => 'string',
                'iid' => 'integer',
            ],

            'delete_product_info' => [
                'product_url' => 'string',
                'category_url' => 'string',
            ],

            'variants' => [
                'rel_id' => 'string',
                'title' => 'string',
                'price' => 'string',
                'uvp' => 'string',
                'ean' => 'string',
                'sku' => 'string',
                'color' => 'string',
                'size' => 'string',
                'materials' => 'string',
                'drm_ref_id' => 'string',
                'description' => 'string',
                'stock' => 'string',
            ],

            'product_variants' => [
                'user_id' => 'string',
                'variant_id' => 'string',
                'content_id' => 'string',
                'varianted_price' => 'string',
            ],

            'tax_rates' => [
                'country' => 'string',
                'country_de' => 'string',
                'country_code' => 'string',
                'charge' => 'string',
                'created_at' => 'string',
                'updated_at' => 'string',
                'lang_kod' => 'string',
                'alpha_three' => 'string',
                'is_default' => 'string',
                'drm_ref_id' => 'string',
                'reduced_charge' => 'string',
            ],

            'admin_shop_menu' => [
                'shortcut' => 'string',
                'position' => 'integer',
                'name' => 'string',
                'sub_name' => 'string',
                'link' => 'string',
                'mw_link' => 'string',
                'dt_link' => 'string',
                'dt_temp_link' => 'string',
                'icon' => 'string',
                'img' => 'string',
                'active_name' => 'string',
                'module_name' => 'string',
                'data_link' => 'string',
                'data_title' => 'string',
            ],

            'admin_website_menu' => [
                'shortcut' => 'string',
                'position' => 'integer',
                'name' => 'string',
                'sub_name' => 'string',
                'link' => 'string',
                'mw_link' => 'string',
                'dt_link' => 'string',
                'dt_temp_link' => 'string',
                'icon' => 'string',
                'img' => 'string',
                'active_name' => 'string',
                'module_name' => 'string',
                'data_link' => 'string',
                'data_title' => 'string',
                'onclick' => 'string',
            ],

            'image_optimize' => [
                'status' => 'string',
                'compress' => 'string',
                'minimum_size' => 'string',
                'thumbnail_width' => 'string',
                'thumbnail_height' => 'string',
                'original_width' => 'string',
                'original_height' => 'string',
                'live_edit_compress' => 'string',
                'live_edit_minimum_size' => 'string',
            ],

            'subscription_items' => [
                'sub_interval' => 'string',
                'created_at' => 'dateTime',
                'updated_at' => 'dateTime',
                'status' => 'string',
            ],

            'subscription_status' => [
                'sub_id' => 'string',
                'product_id' => 'string',
                'created_at' => 'dateTime',
                'updated_at' => 'dateTime',
            ],

            'subscription_order_status' => [
                'product_id' => 'string',
                'subscription_id' => 'string',
                'cycles' => 'string',
                'order_price' => 'string',
                'order_id' => 'string',
                'order_status' => 'string',
                'user_id' => 'string',
                'session_id' => 'string',
                'order_count' => 'string',
                'order_type' => 'string',
                'old_order_id' => 'string',
                'tax_amount' => 'string',
                'agreement_id' => 'string',
                'sub_order_id' => 'string',
                'created_at' => 'dateTime',
                'updated_at' => 'dateTime',
            ],

            'subscriptionorders' => [
                'user_id' => 'integer',
                'product_id' => 'integer',
                'product_quantity' => 'integer',
                'subscription_product_price' => 'string',
                'order_id' => 'integer',
                'plan_id' => 'string',
                'agreement_id' => 'string',
                'email' => 'string',
                'next_billing_date' => 'dateTime',
                'cycle_completed' => 'integer',
                'cycle_remaining' => 'integer',
                'total_cycle' => 'integer',
                'failed_payment_count' => 'integer',
                'start_date' => 'dateTime',
                'end_date' => 'dateTime',
                'state' => 'string',
                'payment_method' => 'string',
                'created_at' => 'dateTime',
                'updated_at' => 'dateTime',
            ],

            'webhook_data' => [
                'data' => 'string',
            ],


            'handling_time' => [
                'data' => 'integer',
                'text' => 'string',
            ],

            'quantity_status' => [
                'isShow' => 'string',
                'value' => 'string',
            ],

            'instagram_feed' => [
                'media_id' => 'string',
                'instagram_id' => 'string',
                'insta_img_description' => 'string',
                'insta_username' => 'string',
                'insta_post_date' => 'string',
            ],

            'product_details' => [
                'rel_id' => 'string',
                'suplier' => 'string',
                'tax_rate' => 'string',
                'tax_type' => 'string',
                'digital_opt' => 'string',
                'd_P_download_link' => 'string',
                'download_limit' => 'string',
                'offer_options' => 'string',
                'offer_options' => 'longText',
                'basic_price' => 'string',
            ],

            'single_checkout_products' => [
                'module_id' => 'string',
                'product_id' => 'string',
            ],

            'bundles' => [
                'title' => 'string',
                'discount' => 'string',
                'discount_type' => 'string',
                'bundle_option' => 'string',
                'tag_name' => 'string',
            ],

            'bundle_products' => [
                'product_id' => 'string',
                'product_qty' => 'string',
                'bundle_id' => 'string',
                'minimum_p' => array('type' => 'integer', 'default' => 1),
            ],

            'products' => [
                'content_id' => 'string',
                'title' => 'string',
                'url' => 'string',
                'image' => 'string',
                'price' => 'string',
                'tax_type' => 'string',
                'quantity' => 'string',
                'category_hide' => array('type' => 'integer', 'default' => 1),
            ],

            'blogs' => [
                'content_id' => 'string',
                'title' => 'string',
                'content' => 'longText',
                'link' => 'string',
                'image' => 'string',
                'is_rss' => array('type' => 'integer', 'default' => 0),
                'rss_link' => 'string',
                'rss_image' => 'string',
                'created_at' => 'dateTime',
                'updated_at' => 'dateTime'
            ],

        ];
    }
}
