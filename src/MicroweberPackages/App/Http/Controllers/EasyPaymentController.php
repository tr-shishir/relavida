<?php

namespace MicroweberPackages\App\Http\Controllers;

use App\Enums\SyncType;
use App\Enums\SyncEvent;
use App\Models\SyncHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use MicroweberPackages\Content\Content;
use MicroweberPackages\Order\OrderManager;

class EasyPaymentController extends Controller
{
    public function __construct()
    {
        View::addNamespace('checkout', __DIR__ . '/../../resources/views/checkout');
    }

    public function easyPayment(){
        $paymentId = $_REQUEST['paymentId'];
        return response()->view('checkout::checkout', $_REQUEST);
    }

    public function easyPaymentSuccess(){
            $order_manager = new OrderManager();

            $orderId = $_REQUEST['ref'];

            $place_order = mw()->user_manager->session_get($orderId);
            mw()->user_manager->session_del($orderId);
            // delete_option('order'.$orderId, 'orders');
            $place_order = json_decode($place_order,true);
            $place_order['order_completed'] = 1;
            $place_order['order_status'] = 'new';

            $place_order['is_paid'] = 1;



            $ord = mw()->shop_manager->place_order($place_order);
            $place_order['id'] = $ord;
             if($ord){

                DB::table('cart_orders')->where('id', $ord)->update([
                        'shipping_name' => $place_order['shipping_name'],
                        'billing_name' => $place_order['billing_name'],
                        'billing_city' => $place_order['billing_city'],
                        'billing_state' => $place_order['billing_state'],
                        'billing_zip' => $place_order['billing_zip'],
                        'billing_country' => $place_order['billing_country'],
                        'billing_address' => $place_order['billing_address'],

                ]);
            }
             if(!empty(mw()->user_manager->session_get('bundle_product_checkout'))){
                 mw()->user_manager->session_del('bundle_product_checkout');
             }
    //                if (env('SYNC_ENABLE') && $ord) {
            if ($ord) {
                //create product
                SyncHistory::create([
                    'sync_type' => SyncType::ORDER,
                    'sync_event' => SyncEvent::CREATE,
                    'model_id' => $place_order['id']
                ]);
            }

            if (isset($place_order['is_paid']) and $place_order['is_paid']) {
                mw()->event_manager->trigger('mw.cart.checkout.order_paid', $place_order);
            }

            $order_id = $place_order['id'];
            $cart_data = DB::table('cart')->where('order_id',$order_id)->select('rel_id','drm_ref_id')->get();
            if($cart_data){
                foreach($cart_data as $cart){
                    $stocks = DB::table('variants')->where('rel_id',$cart->rel_id)->where('drm_ref_id',$cart->drm_ref_id)->select('stock')->first();
                    $qty    = DB::table('cart')->where('rel_id',$cart->rel_id)->where('order_id',$order_id)->where('drm_ref_id',$cart->drm_ref_id)->select('qty')->first();
                    if($stocks){
                        $update_stock = $stocks->stock - $qty->qty;
                        DB::table('variants')->where('rel_id',$cart->rel_id)->where('drm_ref_id',$cart->drm_ref_id)->update([
                            'stock'=> $update_stock
                        ]);
                    }
                    $track_quantity_check = DB::table('content_data')->where('rel_id',$cart->rel_id)->where('field_name','track_quantity')->first();
                    if(isset($track_quantity_check->field_value) && $track_quantity_check->field_value == 1){
                        $product_quantity = DB::table('content_data')->where('rel_id',$cart->rel_id)->where('field_name','qty')->first();
                        if(isset($product_quantity->field_value) && $product_quantity->field_value > 0 && $product_quantity->field_value >= $qty->qty){
                            $update_qty = $product_quantity->field_value - $qty->qty;
                            DB::table('content_data')->where('rel_id',$cart->rel_id)->where('field_name','qty')->update([
                                'field_value'=> $update_qty
                            ]);
                        }
                    }
                }
            }

            if (isset($place_order) and !empty($place_order)) {
                if (!isset($place_order['success'])) {
                    $place_order['success'] = 'Your order has been placed successfully!';
                }
                $return = $place_order;
                if (isset($place_order['redirect'])) {
                    $return['redirect'] = $place_order['redirect'];
                }
                $selectValue = DB::table("selected_product_upselling_item")->where('user_id',user_id())->get();
                if($selectValue->count() > 0){
                    foreach($selectValue as $svalue){
                        DB::table('order_with_upselling')->insert(array('product_id' => $svalue->product_id, "service_id" => $svalue->service_id,'user_id' => user_id(), "order_id" => $return['id']));
                    }
                    DB::table("selected_product_upselling_item")->where('user_id',user_id())->delete();
                }
                DB::table("product_variants")->where('user_id',user_id())->delete();
                // session_set('thank_you_status', true);
            }

        return redirect()->to(url('/thank-you'));
    }
}
