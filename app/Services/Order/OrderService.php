<?php


namespace App\Services\Order;

use App\Models\Content;
use App\Enums\SyncEvent;
use App\Models\Category;
use App\Models\Order;
use App\Models\SyncHistory;
use App\Services\DrmSyncService;
use Illuminate\Support\Facades\DB;
use App\Services\BaseService;
use Illuminate\Support\Arr;

class OrderService extends BaseService
{
    public $order;
    public function all(array $filters = [])
    {
        $query = Order::whereHas('carts')->with('carts.content:id,ean,drm_ref_id');

        $limit = Arr::get($filters, 'limit', 20);

        $query_modify = $limit != '-1' ? $query->paginate($limit) : $query->get();

        $order_modify = query_modify($query_modify);
        return $order_modify;
    }

    public function getById($id)
    {
        return Order::with('carts')->find($id);
    }

    public function store(array $data)
    {
        return $this->saveOrder($data);
    }

    public function update($id, array $data)
    {
        return $this->saveOrder($data, $id);
    }

    public function destroy($id)
    {
        return Order::where('drm_ref_id', $id)->delete();
    }

    private function saveOrder($data, $id = null)
    {
        $product = Order::firstOrNew(['drm_ref_id' => $id]);
        $product->fill($data);
        $product->save();

        return $product;
    }

    public function syncOrderToDrm(SyncHistory $syncHistory)
    {
        $syncService = new DrmSyncService("http://165.22.24.129");
        switch ($syncHistory->sync_event) {
            case SyncEvent::CREATE:
                try {
                    $order = Order::with('carts')->with('carts.content:id,ean,drm_ref_id')->find($syncHistory->model_id);
                    $data = [];
                    if($order){

                        $taxs = mw()->tax_manager->get();
                        $tax_sum = 0;
                        $tax_sum = @$order->tax_rate ?? $taxs[0]['rate'];
                        $country_tax = taxRateCountry($order->country);
                        if(@$country_tax and !empty($country_tax)){
                            $tax_sum = @$order->tax_rate ?? $country_tax;
                        }
                        $country = @$order->country ?? null;
                        $order->carts->map(function ($cart) use ($country,$tax_sum){
                            $cart->ean = $cart->content->first()->ean;
                            $cart->price_with_tax = (function_exists('roundPrice')) ? roundPrice(taxPrice_cart($cart->price,$tax_sum)) : taxPrice_cart($cart->price,$tax_sum);
                            return $cart;

                        });
                        $shipping = array(
                            'name' => $order->shipping_name,
                            'address' => $order->address,
                            'country' => $order->country,
                            'city' => $order->city,
                            'zip' => $order->zip,
                        );
                        $blilling = array(
                            'name' => $order->billing_name,
                            'address' => $order->billing_address,
                            'country' => $order->billing_country,
                            'city' => $order->billing_city,
                            'zip' => $order->billing_zip,
                        );
                        $order->shipping_info = $shipping ?? [];
                        $order->blilling_info = $blilling ?? [];
                        if($order->payment_gw == "shop/payments/gateways/test_payment"){
                            $order->test_order = 1;
                        }
                        $pay_methode = explode("/",$order->payment_gw);
                        $order->payment_gw = end($pay_methode) ?? $order->payment_gw;
                        $order->payment_type = $order->payment_gw;
                        $order->discount_value = $order->discount_value;
        //                        $order->tax_rate = $tax_sum;
                        $order = $order->toArray();

                        $response = $syncService->storeOrder($order);
                        if (!empty($response['id'])) {
                            DB::table('cart_orders')->update([
                                'drm_ref_id' => $response['id']
                            ]);
                            $syncHistory->update([
                                'response' => json_encode($response),
                                'synced_at' => date('Y-m-d H:i:s'),
                            ]);
                        }
                    }
                    $syncHistory->increment('tries');
                } catch (\Exception $e) {
                    $syncHistory->update([
                        'exception'=>json_encode($e->getMessage()),
                        'tries' => $syncHistory->tries + 1
                    ]);
                }
                break;

            case SyncEvent::UPDATE:
                try {
                    $order = Order::with('carts')->find($syncHistory->model_id)->toArray();
                    if ($order && $order->drm_ref_id) {
                        $response = $syncService->updateOrder($order->drm_ref_id, $order);
                        if (!empty($response['id'])) {
                            DB::table('cart_orders')->update([
                                'drm_ref_id' => $response['id']
                            ]);
                            $syncHistory->update([
                                'response' => json_encode($response),
                                'synced_at' => date('Y-m-d H:i:s'),
                            ]);
                        }
                    }
                    $syncHistory->increment('tries');
                } catch (\Exception $e) {
                    $syncHistory->update([
                        'exception'=>json_encode($e->getMessage()),
                        'tries' => $syncHistory->tries + 1
                    ]);
                }
                break;
        }

        return $syncHistory;
    }

    public function easyPayment($place_order){

        $sid = mw()->user_manager->session_id();
        $get_params = array();
        $get_params['order_completed'] = 0;
        $get_params['session_id'] = $sid;
        $sumq = mw()->database_manager->get('cart', $get_params);
        // $sumq = collect($sumq)->map(function($q) use ($place_order) {
        //     $price = $q['price']+product_tax_amount($q['price'],$q['tax_rate']);
        //     $p = array();
        //     $p['name'] = $q['title'];
        //     $p['quantity'] = $q['qty'];
        //     $p['unitPrice'] = mw()->shop_manager->currency_format_no_sym($price,$place_order['currency']);
        //     $p['grossTotalAmount'] = mw()->shop_manager->currency_format_no_sym($price*$q['qty'],$place_order['currency']);
        //     $p['netTotalAmount'] = mw()->shop_manager->currency_format_no_sym($price*$q['qty'],$place_order['currency']);
        //     $p['reference'] = $q['id'];
        //     $p['unit'] = "kg";
        //     return $p;
        // })->toArray();
        // if($place_order['payment_shipping'] > 0){
        //     $countItem = count($sumq);
        //     $unitShipping = $place_order['payment_shipping']/$countItem;
        //     $sumq = collect($sumq)->map(function($q) use ($unitShipping) {
        //                 $q['grossTotalAmount'] = $q['grossTotalAmount']+mw()->shop_manager->currency_format_no_sym($unitShipping);
        //                 $q['netTotalAmount'] = $q['netTotalAmount']+mw()->shop_manager->currency_format_no_sym($unitShipping);
        //                 return $q;
        //             })->toArray();
        // }

        $amount =  mw()->shop_manager->currency_format_no_sym(round($place_order['payment_amount'],2),$place_order['currency']);
        $p = array();
        $p['name'] = 'Demo Product';
        $p['quantity'] = 1;
        $p['unitPrice'] = $amount;
        $p['grossTotalAmount'] = $amount;
        $p['netTotalAmount'] = $amount;
        $p['reference'] = ''.uniqid();
        $p['unit'] = "kg";

        $payload = array (
            'checkout' =>
            array (
            'integrationType' => 'EmbeddedCheckout',
            "url" => url('/checkout'),
            "termsUrl" => url('/terms')
            ),
            'order' =>
            array (
                'items' => array(
                    0 => $p
                ),
                'amount' => mw()->shop_manager->currency_format_no_sym(round($place_order['payment_amount'],2),$place_order['currency']),
                'currency' => $place_order['currency'],
                'reference' => 'Demo Order',
            ),
        );

        $mode = get_option('easypay_testmode','payments');

        $domain = 'api.dibspayment.eu';
        $baseURI =  ($mode == 'n') ? ('https://' . $domain . '/v1/payments') : ('https://test.' . $domain . '/v1/payments');
        $secretKey = ($mode == 'n') ? get_option('easypay_api_key','payments') : get_option('easypay_test_api_key','payments');

        if($secretKey == false){

            return array('success' => false, 'message' => 'Secret key not found');

        }


        $payload = json_encode($payload);

        $ch = curl_init($baseURI);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: '.$secretKey));
        $result = curl_exec($ch);
        $result = json_decode($result, true);
        return $result;

    }

}
