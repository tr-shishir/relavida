<?php
/*
 * This file is part of the Dropienda framework.
 *
 * (c) Dropienda CMS LTD
 *
 * For full license information see
 * https://github.com/microweber/microweber/blob/master/LICENSE
 *
 */

namespace MicroweberPackages\Cart;

use MicroweberPackages\Content\Content;
use MicroweberPackages\Database\Crud;
use Illuminate\Support\Facades\DB;

class CartManager extends Crud
{
    /** @var \MicroweberPackages\App\LaravelApplication */
    public $app;

    public $table = 'cart';

    public function __construct($app = null)
    {
        if (is_object($app)) {
            $this->app = $app;
        } else {
            $this->app = mw();
        }
    }

    /**
     * @param bool $return_amount
     *
     * @return array|false|float|int|mixed
     */
    public function sum($return_amount = true,$checkouttax = null)
    {
        // dump($temp);
        if(!empty($checkouttax)){
            $taxrate = $checkouttax;
        }else{
            $taxrate = taxRate();
        }
        $sid = $this->app->user_manager->session_id();
        $different_items = 0;
        $amount = floatval(0.00);
        $get_params = array();
        $get_params['order_completed'] = 0;
        $get_params['session_id'] = $sid;
        //$get_params['no_cache'] = true;
        $key1 = json_encode($get_params);
        $key1 = sha1($this->table . "_" . $key1);
        if(array_key_exists($key1, $GLOBALS)){
            $sumq = $GLOBALS[$key1];
        }else{
            $sumq = $this->app->database_manager->get($this->table, $get_params);
            $GLOBALS = array_merge($GLOBALS, array(
                $key1 => $sumq
            ));
        }

        $get_id=null;
        if (is_array($sumq)) {
            $tax_data=collect($sumq);

            $tax_rels = $tax_data->pluck('rel_id');
            //$tx[] = collect($data)->pluck('rel_id');
            $default_tax = null;
            if(count($sumq)){
                $default_tax = single_tax($tax_rels);
                $taxrate = $default_tax;
            }
            foreach ($sumq as $value) {
                if(session_id() == ''){
                    session_start();
                }
                $u_session = session_id();
                $u_id = user_id();
                $key2 = sha1($value['rel_id'] . "_" . $u_id . "_" . $u_session . "_subscription");
                if(array_key_exists($key2, $GLOBALS)){
                    $get_id = $GLOBALS[$key2];
                }else{
                    $get_id = DB::table('subscription_order_status')->where('order_id',null)->where('product_id',$value['rel_id'])->where('user_id', $u_id)->where('session_id', $u_session)->first();
                    $GLOBALS = array_merge($GLOBALS, array(
                        $key2 => $get_id
                    ));
                }
                $key3 = sha1($value['rel_id'] . "_" . $u_id . "_" . $u_session . "_upselling");
                if(array_key_exists($key3, $GLOBALS)){
                    $selectedUpselling = $GLOBALS[$key3];
                }else{
                    $selectedUpselling = DB::table("selected_product_upselling_item")->where('product_id', $value['rel_id'] )->where('user_id',user_id())->get();
                    $GLOBALS = array_merge($GLOBALS, array(
                        $key3 => $selectedUpselling
                    ));
                }
                // $get_id=DB::table('subscription_order_status')->where('order_id',null)->where('product_id',$value['rel_id'])->where('user_id', $u_id)->where('session_id', $u_session)->first();
                // $selectedUpselling = DB::table("selected_product_upselling_item")->where('product_id', $value['rel_id'] )->where('user_id',user_id())->get();
                $sprice = 0;
                if($selectedUpselling->count()){
                    foreach($selectedUpselling as $selectValue){
                        $sprice = $sprice + $selectValue->service_price;
                    }
                    $different_items = $different_items + $value['qty'];
                    $value['price'] = $value['price'] + (($value['price']*$taxrate)/100);
                    $totalValue = roundPrice($value['price']) + ($sprice + (($sprice*$taxrate)/100));
                    $amount = $amount + (intval($value['qty']) *  $totalValue );
                    if($get_id != null){
                        $amount1 =  (intval($value['qty']) * $totalValue);
                    }
                }
                else{
                    $different_items = $different_items + $value['qty'];
                    $value['price'] = $value['price'] + (($value['price']*$taxrate)/100);
                    $amount = $amount + (intval($value['qty']) * roundPrice($value['price']));
                    if($get_id != null){
                        $amount1 =  (intval($value['qty']) * roundPrice($value['price']));
                    }
                }
            }
        }

        $modify_amount = $this->app->event_manager->trigger('mw.cart.sum', $amount);
        if ($modify_amount !== null and $modify_amount !== false) {
            if (is_array($modify_amount)) {
                $pop = array_pop($modify_amount);
                if ($pop != false) {
                    $amount = $pop;
                }
            } else {
                $amount = $modify_amount;
            }
        }

        if ($return_amount == false) {
            return $different_items;
        }
        if(isset($amount1)){
            $amount = $amount1;
            return $amount;
        }
        // dd($amount);
        return $amount;
    }

    public function totals($return = 'all',$country_name=null,$product_id=null,$tax_d=null)
    {
        $all_totals = array('subtotal', 'shipping', 'tax', 'discount', 'total');


        $tax = $shipping = $discount_sum = 0;

        $shipping_sess = $this->app->user_manager->session_get('shipping_cost');
        if ($shipping_sess) {
            $shipping = floatval($shipping_sess);
        }

        // Coupon code discount
        $discount_value = $this->get_discount_value();
        $discount_type = $this->get_discount_type();
        if(!empty(mw()->user_manager->session_get('bundle_product_checkout')[0])) {
            $discount_value = 0;

            $discount_for_bundle = mw()->user_manager->session_get('bundle_product_checkout')[0];
            $discount_for_bundles = mw()->user_manager->session_get('bundle_product_checkout');
            $discount_type = 'fixed_amount';
            foreach($discount_for_bundles as $bundle){
                if(@$bundle['offer_discount']){
                    $discount_value = $discount_value+$bundle['offer_discount']; //$discount_for_bundle['offer_discount'];
                }else{
                    if (isset($bundle['discount_type'])) {
                        if ($bundle['discount_type'] == "percentage") {
                            $discount_type = 'percentage';
                            $discount_value = $bundle['discount'];
                        } else {
                            $discount_type = 'fixed_amount';
                            $discount_value = $bundle['discount'];
                        }
                    }
                }
            }
        }

        if(isset($country_name) && !empty($country_name)) {
            $tax_rate = taxRateCountry($country_name,$product_id);
        }
        if($tax_d){
            $tax_rate = $tax_d;
        }
        if(@$tax_rate && !empty($tax_rate)){
            $sum = $subtotal = $this->sum(true,$tax_rate);
        }else{
            $sum = $subtotal = $this->sum();
        }
        if ($discount_type == 'precentage' or $discount_type == 'percentage') {
            // Discount with precentage
            $discount_sum = ($sum * ($discount_value / 100));
            $sum = $sum - $discount_sum;
        } else if ($discount_type == 'fixed_amount') {
            // Discount with amount
            $discount_sum = $discount_value;
            $sum = $sum - $discount_value;
        }


        $total = $sum + $shipping;

        if (get_option('enable_taxes', 'shop') == 1) {
            if ($total > 0) {

                $tax= mw()->tax_manager->get();
                if(isset($tax_rate) && !empty($tax_rate)){
                    $taxam = $tax_rate;
                }else{
                    $taxam = $tax['0']['rate'];
                }

                $taxrate = (float)$taxam;

                $tax = ($total/(100+$taxrate))*$taxrate;
                $subtotal = ($subtotal/(100+$taxrate))*100;


            }
        }


        $totals = array();
        foreach ($all_totals as $total_key) {
            switch ($total_key) {
                case 'subtotal':
                    $totals[$total_key] = array(
                        'label' => _e("Subtotal", true),
                        'value' => $subtotal,
                        'amount' => currency_format($subtotal)
                    );
                    break;
                case 'tax':
                    if ($tax) {
                        $totals[$total_key] = array(
                            'label' => _e("Tax", true),
                            'value' => $tax,
                            'amount' => currency_format($tax),
                            'rate' => $taxrate
                        );
                    }
                    break;


                case 'discount':
                    if ($discount_sum and $discount_sum > 0) {
                        mw()->user_manager->session_set('discount_value',$discount_sum);
                        $totals[$total_key] = array(
                            'label' => _e("Discount", true),
                            'value' => $discount_sum,
                            'amount' => currency_format($discount_sum)
                        );
                    }
                    break;

                case 'shipping':
                    if ($shipping and $shipping > 0) {
                        $totals[$total_key] = array(
                            'label' => _e("Shipping", true),
                            'value' => $shipping,
                            'amount' => currency_format($shipping)
                        );
                    }
                    break;
                case 'total':
                    $totals[$total_key] = array(
                        'label' => _e("Total", true),
                        'value' => $total,
                        'amount' => currency_format($total)
                    );
                    break;
            }
        }

        if (isset($return) and $return != 'all') {
            if (isset($totals[$return])) {
                return $totals[$return];
            }
        } else {
            return $totals;
        }

    }

    public function total()
    {
        $total = $this->totals('total');

        if (isset($total['value'])) {
            return $total['value'];
        }

//
//        $sum = $this->sum();
//
//        // Coupon code discount
//        $discount_value = $this->get_discount_value();
//        $discount_type = $this->get_discount_type();
//
//        if ($discount_type == 'precentage' or $discount_type == 'percentage') {
//            // Discount with precentage
//            $sum = $sum - ($sum * ($discount_value / 100));
//        } else if ($discount_type == 'fixed_amount') {
//            // Discount with amount
//            $sum = $sum - $discount_value;
//        }
//
//
//        $shipping = floatval($this->app->user_manager->session_get('shipping_cost'));
//        $total = $sum + $shipping;
//
//        if (get_option('enable_taxes', 'shop') == 1) {
//            if ($total > 0) {
//                $tax = $this->app->tax_manager->calculate($sum);
//                $total = $total + $tax;
//            }
//        }
//
//
//        return $total;
    }


    public function get_tax()
    {
        $different_items = 0;
        $amount = floatval(0.00);
        $sid = mw()->user_manager->session_id();
        $get_params = array();
        $get_params['order_completed'] = 0;
        $get_params['session_id'] = $sid;
        //$get_params['no_cache'] = true;
        $sumq = $this->app->database_manager->get($this->table, $get_params);

        foreach ($sumq as $sum) {


            $different_items = $different_items + $sum['qty'];
            $amount = $amount + (intval($sum['qty']) * $sum['price']);


        }

        $tax = round(floatval(taxPrice($amount)),2);

        return $tax;
    }

    public function get_discount()
    {
        return $this->get_discount_value();
    }

    public function get_discount_type()
    {
        return $this->app->user_manager->session_get('discount_type');
    }

    public function get_discount_value()
    {
        $discount_value = $this->app->user_manager->session_get('discount_value');

        if (empty($discount_value)) {
            return false;
        }

        return floatval($discount_value);
    }

    public function get_discount_text()
    {
        if ($this->get_discount_type() == "percentage" or $this->get_discount_type() == "precentage") {
            return $this->get_discount_value() . "%";
        } else {
            return currency_format($this->get_discount_value());
        }
    }

    public function get($params = false)
    {
        $time = time();
//        $clear_carts_cache = $this->app->cache_manager->get('clear_cache', 'cart');
//
//        if ($clear_carts_cache == false or ($clear_carts_cache < ($time - 600))) {
//            // clears cache for old carts
//            $this->app->cache_manager->delete('cart');
//            $this->app->cache_manager->save($time, 'clear_cache', 'cart');
//        }

        $params2 = array();

        if (is_string($params)) {
            $params = parse_str($params, $params2);
            $params = $params2;
        }
        $table = $this->table;
        $params['table'] = $table;
        $skip_sid = false;
        if (!defined('MW_API_CALL')) {
            if (isset($params['order_id'])) {
                $skip_sid = 1;
            }
        }
        if ($skip_sid == false) {
            if (!defined('MW_ORDERS_SKIP_SID')) {
                if ($this->app->user_manager->is_admin() == false) {
                    $params['session_id'] = mw()->user_manager->session_id();
                } else {
                    if (isset($params['session_id']) and $this->app->user_manager->is_admin() == true) {
                    } else {
                        $params['session_id'] = mw()->user_manager->session_id();
                    }
                }
                if (isset($params['no_session_id']) and $this->app->user_manager->is_admin() == true) {
                    unset($params['session_id']);
                }
            }
        }
        if (!isset($params['rel']) and isset($params['for'])) {
            $params['rel_type'] = $params['for'];
        } elseif (isset($params['rel']) and !isset($params['rel_type'])) {
            $params['rel_type'] = $params['rel'];
        }
        if (!isset($params['rel_id']) and isset($params['for_id'])) {
            $params['rel_id'] = $params['for_id'];
        }

        $params['limit'] = 10000;
        if (!isset($params['order_completed'])) {
            if (!isset($params['order_id'])) {
                $params['order_completed'] = 0;
            }
        } elseif (isset($params['order_completed']) and $params['order_completed'] === 'any') {
            unset($params['order_completed']);
        }
        // $params['no_cache'] = 1;

        $get = $this->app->database_manager->get($params);
        if (isset($params['count']) and $params['count'] != false) {
            return $get;
        }
        $return = array();
        if (is_array($get)) {
            foreach ($get as $k => $item) {
                if (is_array($item)) {
                    if (isset($item['rel_id']) and isset($item['rel_type']) and $item['rel_type'] == 'content') {
                        $item['content_data'] = $this->app->content_manager->data($item['rel_id']);
                        $item['url'] = $this->app->content_manager->link($item['rel_id']);
                        $item['picture'] = $this->app->media_manager->get_picture($item['rel_id']);
                    }
                    if (isset($item['custom_fields_data']) and $item['custom_fields_data'] != '') {
                        $item = $this->app->format->render_item_custom_fields_data($item);
                    }
                    if(isset($item['drm_ref_id']) && !empty($item['drm_ref_id'])) {
                        $new_title = DB::table('variants')->where('drm_ref_id', $item['drm_ref_id'])->first()->title;
                        if (isset($new_title)) {
                            $item['title'] = html_entity_decode($new_title);
                            $item['title'] = strip_tags($new_title);
                            $item['title'] = $this->app->format->clean_html($new_title);
                            $item['title'] = htmlspecialchars_decode($new_title);
                        }
                    }else{
                        if (isset($item['title'])) {
                            $item['title'] = html_entity_decode($item['title']);
                            $item['title'] = strip_tags($item['title']);
                            $item['title'] = $this->app->format->clean_html($item['title']);
                            $item['title'] = htmlspecialchars_decode($item['title']);
                        }
                    }

                    if (!isset($item['url'])) {
                        $item['url'] = '';
                    }
                    if (!isset($item['picture'])) {
                        $item['picture'] = '';
                    }
                }

                $return[$k] = $item;
            }
        } else {
            $return = $get;
        }

        return $return;
    }

    public function get_by_order_id($order_id = false)
    {
        $order_id = intval($order_id);
        if ($order_id == false) {
            return;
        }
        $params = array();
        $table = $this->table;
        $params['table'] = $table;
        $params['order_id'] = $order_id;
        $get = $this->app->database_manager->get($params);

        if (!empty($get)) {
            foreach ($get as $k => $item) {

                if (is_array($item) and isset($item['custom_fields_data']) and $item['custom_fields_data'] != '') {
                    $item = $this->app->format->render_item_custom_fields_data($item);
                }

                if (!isset($item['item_image']) and is_array($item) and isset($item['rel_id']) and isset($item['rel_type']) and $item['rel_type'] == 'content') {
                    $item['item_image'] = get_picture($item['rel_id']);
                }

                if (!isset($item['item_image'])) {
                    $item['item_image'] = false;
                }

                $get[$k] = $item;
            }
        }

        return $get;
    }

    public function remove_item($data)
    {
        if (!is_array($data)) {
            $id = intval($data);
            $data = array('id' => $id);
        }

        if (!isset($data['id']) or $data['id'] == 0) {
            return false;
        }

        $cart = array();
        $cart['id'] = intval($data['id']);
        if ($this->app->user_manager->is_admin() == false) {
            $cart['session_id'] = mw()->user_manager->session_id();
        }
        $cart['order_completed'] = 0;
        $cart['one'] = 1;
        $cart['limit'] = 1;
        $check_cart = $this->get($cart);
        if ($check_cart != false and is_array($check_cart)) {
            $table = $this->table;
            $this->app->database_manager->delete_by_id($table, $id = $cart['id'], $field_name = 'id');

            $cart_return = $check_cart;

            $cart_sum = $this->sum(true);
            $cart_qty = $this->sum(false);
            if(user_id()){
                DB::table('product_variants')->where('content_id', content_id())->where('user_id',user_id())->delete();
            }else{
                DB::table('product_variants')->where('content_id', content_id())->where('user_id',0)->delete();
            }
            return array('success' => 'Item quantity changed', 'product' => $cart_return, 'cart_sum' => $cart_sum, 'cart_items_quantity' => $cart_qty);


            return array('success' => 'Item removed from cart');
        } else {
            return array('error' => 'Item not removed from cart');

        }

    }

    public function update_item_qty($data)
    {
        if (!isset($data['id'])) {
            return array('error' => 'Invalid data');
        }
        if (!isset($data['qty'])) {
            return array('error' => 'Invalid data');
        }
        $data_fields = false;

        $cart = array();
        $cart['id'] = intval($data['id']);


        $cart['session_id'] = mw()->user_manager->session_id();

        $cart['order_completed'] = 0;
        $cart['one'] = 1;
        $cart['limit'] = 1;
        $check_cart = $this->get($cart);
        if(isset($check_cart['qty'])){
            if( $check_cart['qty'] == 0 ){
                return false;
            }
        }
        if (isset($check_cart['rel_type']) and isset($check_cart['rel_id']) and $check_cart['rel_type'] == 'content') {
            $data_fields = $this->app->content_manager->data($check_cart['rel_id'], 1);
            if (isset($check_cart['qty']) and isset($data_fields['qty']) and $data_fields['qty'] != 'nolimit') {
                $old_qty = intval($data_fields['qty']);
                if (intval($data['qty']) > $old_qty) {
                    return false;
                }
            }
        }

        if ($check_cart != false and is_array($check_cart)) {
            $cart['qty'] = intval($data['qty']);
            if ($cart['qty'] < 0) {
                $cart['qty'] = 0;
            }


            if (isset($data_fields['max_qty_per_order']) and intval($data_fields['max_qty_per_order']) != 0) {

                if ($cart['qty'] > intval($data_fields['max_qty_per_order'])) {
                    $cart['qty'] = intval($data_fields['max_qty_per_order']);
                }
            }


            $cart_return = $check_cart;


            $table = $this->table;
            $cart_data_to_save = array();
            $cart_data_to_save['qty'] = $cart['qty'];
            $cart_data_to_save['id'] = $cart['id'];
            $cart_saved_id = $this->app->database_manager->save($table, $cart_data_to_save);

            $cart_sum = $this->sum(true);
            $cart_qty = $this->sum(false);
            return array('success' => 'Item quantity changed', 'product' => $cart_return, 'cart_sum' => $cart_sum, 'cart_items_quantity' => $cart_qty);


        }
    }


    public function empty_cart()
    {
        $sid = mw()->user_manager->session_id();
        $cart_table = $this->table;

        Cart::where('order_completed', 0)->where('session_id', $sid)->delete();
        $this->no_cache = true;
        $this->app->cache_manager->delete('cart');
        $this->app->cache_manager->delete('cart_orders');

        $cart_sum = $this->sum(true);
        $cart_qty = $this->sum(false);
        return array('success' => 'Cart is emptied', 'cart_sum' => $cart_sum, 'cart_items_quantity' => $cart_qty);

    }

    public function delete_cart($params)
    {
        if (is_string($params)) {
            $params = parse_params($params);
        }
        if (isset($params['session_id'])) {
            $id = $params['session_id'];
            Cart::where('session_id', $id)->delete();
        }
        if (isset($params['order_id'])) {
            $id = $params['order_id'];
            Cart::where('order_id', $id)->delete();
        }
        $this->app->cache_manager->delete('cart');
        $this->app->cache_manager->delete('cart_orders');
    }

    public function update_cart($data)
    {
        abandoned_shopping_carts();
        if (!isset($data['for']) and isset($data['rel_type'])) {
            $data['for'] = $data['rel_type'];
        }
        if (!isset($data['for_id']) and isset($data['rel_id'])) {
            $data['for_id'] = $data['rel_id'];
        }
        if (!isset($data['for']) and !isset($data['rel_type'])) {
            $data['for'] = 'content';
        }

        if (isset($data['content_id'])) {
            $data['for'] = 'content';
            $for_id = $data['for_id'] = $data['content_id'];
        }
        $override = $this->app->event_manager->trigger('mw.shop.update_cart', $data);
        if (is_array($override)) {
            foreach ($override as $resp) {
                if (is_array($resp) and !empty($resp)) {
                    $data = array_merge($data, $resp);
                }
            }
        }


        $update_qty = 0;
        $update_qty_new = 0;

        if (isset($data['qty'])) {
            $update_qty_new = $update_qty = intval($data['qty']);
            unset($data['qty']);
        }
        if (!isset($data['for']) or !isset($data['for_id'])) {
            if (!isset($data['id'])) {

            } else {
                $cart = array();
                $cart['id'] = intval($data['id']);
                $cart['limit'] = 1;
                $data_existing = $this->get($cart);
                if (is_array($data_existing) and is_array($data_existing[0])) {
                    $data = array_merge($data, $data_existing[0]);
                }
            }
        }


        if (!isset($data['for']) and !isset($data['for_id'])) {
            return array('error' => 'Invalid for and for_id params');
        }

        $data['for'] = $this->app->database_manager->assoc_table_name($data['for']);
        $for = $data['for'];
        $for_id = intval($data['for_id']);
        if ($for_id == 0) {
            return array('error' => 'Invalid data for_id');
        }
        $cont_data = false;

        if ($update_qty > 0) {
            $data['qty'] = $update_qty;
        }

        if ($data['for'] == 'content') {
            $cont = $this->app->content_manager->get_by_id($for_id);
            $cont_data = $this->app->content_manager->data($for_id);

            if ($cont == false) {
                return array('error' => 'Invalid product?');
            } else {
                if (is_array($cont) and isset($cont['title'])) {
                    $data['title'] = $cont['title'];
                }
            }
        }

        if (isset($data['title']) and is_string($data['title'])) {
            $data['title'] = (strip_tags($data['title']));
        }

        $found_price = false;
        $add = array();

        if (isset($data['custom_fields_data']) and is_array($data['custom_fields_data'])) {
            $add = $data['custom_fields_data'];
        }

        $prices = array();

        $skip_keys = array();

        $content_custom_fields = array();
        $content_custom_fields = $this->app->fields_manager->get($for, $for_id, 1);

        $product_prices = array();
        if ($for == 'content') {
            $prices_data = mw()->shop_manager->get_product_prices($for_id, true);
            if ($prices_data) {
                foreach ($prices_data as $price_data) {
                    if (isset($price_data['name'])) {
                        $product_prices[$price_data['name']] = $price_data['value'];
                        if(isset($price_data['custom_value_data']['is_active']) && $price_data['custom_value_data']['is_active']==0){
                            $product_prices[$price_data['name']]=$price_data['original_value'];
                        }
                    }
                }
            }
        }

        if ($content_custom_fields == false) {
            $content_custom_fields = $data;
            if (isset($data['price'])) {
                $found_price = $data['price'];
            }
        } elseif (is_array($content_custom_fields)) {
            foreach ($content_custom_fields as $cf) {
                if (isset($cf['type']) and $cf['type'] == 'price') {
                    if (isset($product_prices[$cf['name']])) {
                        $prices[$cf['name']] = $product_prices[$cf['name']];
                    } else {
                        $prices[$cf['name']] = $cf['value'];
                    }
                }
            }
        }

        foreach ($data as $k => $item) {
            if ($k != 'for' and $k != 'for_id' and $k != 'title') {
                $found = false;
                foreach ($content_custom_fields as $cf) {
                    if (isset($cf['type']) and isset($cf['name']) and $cf['type'] != 'price') {
                        $key1 = str_replace('_', ' ', $cf['name']);
                        $key2 = str_replace('_', ' ', $k);
                        if (isset($cf['name']) and ($cf['name'] == $k or $key1 == $key2)) {
                            $k = str_replace('_', ' ', $k);
                            $found = true;
                            if (is_array($cf['values'])) {
                                if (in_array($item, $cf['values'])) {
                                    $found = true;
                                }
                            }
                            if ($found == false and $cf['value'] != $item) {
                                unset($item);
                            }
                        }
                    } elseif (isset($cf['type']) and $cf['type'] == 'price') {
                        if ($cf['value'] != '') {
                            if (isset($product_prices[$cf['name']])) {
                                $prices[$cf['name']] = $product_prices[$cf['name']];
                            } else {
                                $prices[$cf['name']] = $cf['value'];
                            }
                        }
                    }
                }
                if ($found == false) {
                    $skip_keys[] = $k;
                }

                if (is_array($prices)) {
                    foreach ($prices as $price_key => $price) {
                        if (isset($data['price'])) {
                            if ($price == $data['price']) {
                                $found = true;
                                $found_price = $price;
                            }
                        } elseif (isset($item) and $price == $item) {
                            $found = true;
                            if ($found_price == false) {
                                $found_price = $item;
                            }
                        }
                    }
                    if ($found_price == false) {
                        $found_price = array_pop($prices);
                    } else {
                        if (count($prices) > 1) {
                            foreach ($prices as $pk => $pv) {
                                if ($pv == $found_price) {
                                    $add[$pk] = $this->app->shop_manager->currency_format($pv);
                                }
                            }
                        }
                    }
                }
                if (isset($item)) {
                    if ($found == true) {
                        if ($k != 'price' and !in_array($k, $skip_keys)) {
                            $add[$k] = $this->app->format->clean_html($item);
                        }
                    }
                }
            }
        }

        if ($found_price == false and is_array($prices)) {
            $found_price = array_pop($prices);
        }
        if ($found_price == false) {
            $found_price = 0;
        }

        if (is_array($prices)) {
            ksort($add);
            asort($add);
            $add = mw()->format->clean_xss($add);
            $table = $this->table;
            $cart = array();
            $cart['rel_type'] = trim($data['for']);
            $cart['rel_id'] = intval($data['for_id']);
            $cart['session_id'] = mw()->user_manager->session_id();
            $cart['no_cache'] = 1;
            $cart['disable_triggers'] = 1;

            // $cart['price'] = doubleval($found_price);
            //  $cart_check_db =  \DB::table('cart')->where($cart)->first();


//            $cart_check = $cart;
//            $cart_return = $cart;
//            $check_cart = [];
//
//            if($cart_check_db){
//                $check_cart = (array) $cart_check_db;
//
//            }

            //  $check_cart = $this->app->database_manager->get('cart',$cart_check);
            //     d($cart_check);

//  d($check_cart);
            //  d($cart_check);
            $cart_check_q = $cart;
            $cart_check_q['order_completed']=0;
            $check_cart = $this->app->database_manager->get('cart', $cart_check_q);


            $cart['custom_fields_data'] = $this->app->format->array_to_base64($add);
            $cart['custom_fields_json'] = json_encode($add);
            $cart['allow_html'] = 1;
            $cart['price'] = doubleval($found_price);
            $cart['limit'] = 1;

            $cart['title'] = mw()->format->clean_html($data['title']);

            $cart['order_completed'] = 0;
            $cart_return['custom_fields_data'] = $add;
            $cart_return['price'] = $cart['price'];


            if ($found_price and $check_cart != false and is_array($check_cart) and isset($check_cart[0])) {

                foreach ($check_cart as $cart_item) {
                    $drm_ref_id = DB::table('cart')->where('rel_id',$cart_item['rel_id'])->where('drm_ref_id',$cart_item['drm_ref_id'])->select('drm_ref_id','title')->first();
                    //dd($cart_item);
                    if ($cart_item and isset($cart_item['price']) and (doubleval($cart_item['price']) == doubleval($found_price))) {
                        $cart['id'] = $cart_item['id'];
                        if ($update_qty > 0) {
                            $cart['qty'] = $cart_item['qty'] + $update_qty;
                        } elseif ($update_qty_new > 0) {
                            $cart['qty'] = $update_qty_new;
                        } else {
                            $cart['qty'] = $cart_item['qty'] + 1;
                        }
                    }elseif($cart_item and isset($cart_item['price']) and $cart_item['title'] == $drm_ref_id->title){
                        $cart['id'] = $cart_item['id'];
                        if ($update_qty > 0) {
                            $cart['qty'] = $cart_item['qty'] + $update_qty;
                        } elseif ($update_qty_new > 0) {
                            $cart['qty'] = $update_qty_new;
                        } else {
                            $cart['qty'] = $cart_item['qty'] + 1;
                        }
                    }
                }
            } else {
                if ($update_qty > 0) {
                    $cart['qty'] = $update_qty;
                } else {
                    $cart['qty'] = 1;
                }
            }

            if (isset($cont_data['qty']) and trim($cont_data['qty']) != 'nolimit') {
                if (intval($cont_data['qty']) < intval($cart['qty'])) {
                    $cart['qty'] = $cont_data['qty'];
                }
            }


            if (isset($cont_data['max_qty_per_order']) and intval($cont_data['max_qty_per_order']) != 0) {
                if ($cart['qty'] > intval($cont_data['max_qty_per_order'])) {
                    $cart['qty'] = intval($cont_data['max_qty_per_order']);
                }
            }


            if (isset($data['other_info']) and is_string($data['other_info'])) {
                $cart['other_info'] = strip_tags($data['other_info']);
            }

            if (isset($data['description']) and is_string($data['description'])) {
                $cart_return['description'] = $cart['description'] = $this->app->format->clean_html($data['description']);
            }
            if (isset($data['image']) and is_string($data['image'])) {
                $cart_return['item_image'] = $cart['item_image'] = $this->app->format->clean_html($data['image']);
            }
            if (isset($data['item_image']) and is_string($data['item_image'])) {
                $cart_return['item_image'] = $cart['item_image'] = $this->app->format->clean_html($data['item_image']);
            }
            if (isset($data['link']) and is_string($data['link'])) {
                $cart_return['link'] = $cart['link'] = $this->app->format->clean_html($data['link']);
            }

            if (isset($data['currency']) and is_string($data['currency'])) {
                $cart_return['currency'] = $cart['currency'] = $this->app->format->clean_html($data['link']);
            }
            if(isset($data['varianted_price'])){
                $var_de = DB::table('variants')->where('rel_id',$cart['rel_id'])->where('drm_ref_id',$_REQUEST['drm_variant_id'])->first();
                if(isset($var_de)){
                    $cart['title'] = $var_de->title;
                    $cart['price'] = $var_de->price;
                }
            }

            if(isset($cart['rel_id'])){
                $cart['tax_rate'] = taxRate($cart['rel_id']);
            }


            if(isset($cart['price']) && (int)$cart['price'] == 0){
                return false;
            }


            $cart_saved_id = $this->app->database_manager->save($table, $cart);
            if(isset($cart['rel_id'])){
                $digital_product_download_limit = DB::table('product_details')->where('rel_id',$cart['rel_id'])->where('digital_opt',  1)->first();
                if(!empty($digital_product_download_limit)){
                    Cart::where('id',$cart_saved_id)->update(['download_limit' => $digital_product_download_limit->download_limit, 'digital_product' => 1]);
                }
            }
            if(isset($data['tax_rate'])){
                Cart::where('id',$cart_saved_id)->update(['tax_rate' => $data['tax_rate']]);
            }


            $user_id = user_id();
            // varianted insert code
            if(isset($data['varianted_price'])){
                Cart::where('id',$cart_saved_id)->update(['drm_ref_id' => $_REQUEST['drm_variant_id']]);
                DB::table('product_variants')->insert([
                    'user_id'         => $user_id,
                    'variant_id'  => $data['drm_variant_id'],
                    'content_id'      => $data['for_id'],
                    'varianted_price' =>floatval($data['varianted_price']),
                ]);
            }
            $this->app->cache_manager->delete('cart');
            $this->app->cache_manager->delete('cart_orders');

            if (isset($cart['rel_type']) and isset($cart['rel_id']) and $cart['rel_type'] == 'content') {
                $cart_return['image'] = $this->app->media_manager->get_picture($cart['rel_id']);
                $cart_return['product_link'] = $this->app->content_manager->link($cart['rel_id']);
            }
            $cart_sum = $this->sum(true);
            $cart_qty = $this->sum(false);
            return array('success' => 'Item added to cart', 'product' => $cart_return, 'cart_sum' => $cart_sum, 'cart_items_quantity' => $cart_qty);
        } else {
            return array('error' => 'Invalid cart items');
        }
    }

    public function recover_cart($sid = false, $ord_id = false)
    {
        if ($sid == false) {
            return;
        }
        $cur_sid = mw()->user_manager->session_id();
        if ($cur_sid == false) {
            return;
        } else {
            if ($cur_sid != false) {
                $c_id = $sid;
                $table = $this->table;
                $params = array();
                $params['order_completed'] = 0;
                $params['session_id'] = $c_id;
                $params['table'] = $table;
                if ($ord_id != false) {
                    unset($params['order_completed']);
                    $params['order_id'] = intval($ord_id);
                }

                $will_add = true;
                $res = $this->app->database_manager->get($params);

                if (!empty($res)) {
                    foreach ($res as $item) {
                        if (isset($item['id'])) {
                            $data = $item;
                            unset($data['id']);
                            if (isset($item['order_id'])) {
                                unset($data['order_id']);
                            }
                            if (isset($item['created_by'])) {
                                unset($data['created_by']);
                            }
                            if (isset($item['updated_at'])) {
                                unset($data['updated_at']);
                            }
                            if (isset($item['rel_type']) and isset($item['rel_id'])) {
                                $is_ex_params = array();
                                $is_ex_params['order_completed'] = 0;
                                $is_ex_params['session_id'] = $cur_sid;
                                $is_ex_params['table'] = $table;
                                $is_ex_params['rel_type'] = $item['rel_type'];
                                $is_ex_params['rel_id'] = $item['rel_id'];
                                $is_ex_params['count'] = 1;

                                $is_ex = $this->app->database_manager->get($is_ex_params);

                                if ($is_ex != false) {
                                    $will_add = false;
                                }
                            }
                            $data['order_completed'] = 0;
                            $data['session_id'] = $cur_sid;
                            if ($will_add == true) {
                                $s = $this->app->database_manager->save($table, $data);
                            }
                        }
                    }
                }
                if ($will_add == true) {
                    $this->app->cache_manager->delete('cart');

                    $this->app->cache_manager->delete('cart_orders');
                }
            }
        }
    }

    public function table_name()
    {
        return $this->table;
    }


}
