<?php

namespace MicroweberPackages\App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\Psr7\parse_query;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use MicroweberPackages\Install\Http\Controllers\InstallController;
use MicroweberPackages\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Subscriptionorder;
use Exception;
use App\Models\SyncHistory;
use App\Enums\SyncEvent;
use App\Enums\SyncType;
use MicroweberPackages\Order\OrderManager;


// Used to process plans
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
// use to process billing agreements
use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;
use PayPal\Api\Payer;
use PayPal\Api\ShippingAddress;

class PaypalController extends Controller
{
    private $apiContext;
    private $mode;
    private $client_id;
    private $secret;

    // Create a new instance with our paypal credentials
    public function __construct()
    {
        // Detect if we are running in live mode or sandbox
        $mode = get_option('test_mode', 'paypal_subscription_payment_mode');
        if ($mode == "yes" or !$mode) {
            $setting  = array(
                'mode' => 'sandbox',
                // Specify the max connection attempt (3000 = 3 seconds)
                'http.ConnectionTimeOut' => 3000,
                // Specify whether or not we want to store logs
                'log.LogEnabled' => true,
                // Specigy the location for our paypal logs
                'log.FileName' => storage_path() . '/logs/paypal.log',
                'log.LogLevel' => 'DEBUG'
            );
            $this->client_id = get_option('client_id', 'paypal_subscription_payment');
            $this->secret = get_option('client_secret', 'paypal_subscription_payment');
        } else {
            $setting  = array(
                'mode' => 'live',
                // Specify the max connection attempt (3000 = 3 seconds)
                'http.ConnectionTimeOut' => 3000,
                // Specify whether or not we want to store logs
                'log.LogEnabled' => true,
                // Specigy the location for our paypal logs
                'log.FileName' => storage_path() . '/logs/paypal.log',
                'log.LogLevel' => 'DEBUG'
            );
            $this->client_id = get_option('client_id', 'paypal_subscription_payment');
            $this->secret = get_option('client_secret', 'paypal_subscription_payment');
        }

        // Set the Paypal API Context/Credentials
        $this->apiContext = new ApiContext(new OAuthTokenCredential($this->client_id, $this->secret));

        $this->apiContext->setConfig($setting);
    }

    public function create_plan()
    {
        $user = Auth::user();
        //login check
        if (isset($user)) {
            // Create a new billing plan
            $plan = new Plan();
            $plan->setName('App Name daily Billing')
                ->setDescription('Daily Subscription to the App Name')
                ->setType('fixed');

            // Set billing plan definitions
            $paymentDefinition = new PaymentDefinition();
            $paymentDefinition->setName('Regular Payments')
                ->setType('REGULAR')
                ->setFrequency('Day')
                ->setFrequencyInterval('1')
                ->setCycles('12')
                ->setAmount(new Currency(array('value' => 1, 'currency' => 'USD')));

            // Set merchant preferences
            $merchantPreferences = new MerchantPreferences();
            $merchantPreferences->setReturnUrl(route('paypal.return'))
                ->setCancelUrl(route('paypal.cancel'))
                ->setAutoBillAmount('yes')
                ->setInitialFailAmountAction('CONTINUE')
                ->setMaxFailAttempts('0');

            $plan->setPaymentDefinitions(array($paymentDefinition));
            $plan->setMerchantPreferences($merchantPreferences);
            //create the plan
            try {
                $createdPlan = $plan->create($this->apiContext);

                try {
                    $patch = new Patch();
                    $value = new PayPalModel('{"state":"ACTIVE"}');
                    $patch->setOp('replace')
                        ->setPath('/')
                        ->setValue($value);
                    $patchRequest = new PatchRequest();
                    $patchRequest->addPatch($patch);
                    $createdPlan->update($patchRequest, $this->apiContext);
                    $plan = Plan::get($createdPlan->getId(), $this->apiContext);

                    //store plan id
                    // $subscription = new Subscription();
                    // $subscription->user_id = $user->id;
                    // $subscription->plan_id = $plan->getId();
                    // $subscription->save();
                    return redirect()->route('paypal.redirect', ['plan_id' => $plan->getId()]);
                } catch (PayPal\Exception\PayPalConnectionException $ex) {
                    echo $ex->getCode();
                    echo $ex->getData();
                    die($ex);
                } catch (Exception $ex) {
                    die($ex);
                }
            } catch (PayPal\Exception\PayPalConnectionException $ex) {
                echo $ex->getCode();
                echo $ex->getData();
                die($ex);
            } catch (Exception $ex) {
                die($ex);
            }
        } else {
            echo 'Please login First!';
        }
    }
    public function paypalRedirect(Request $request)
    {

        // Create new agreement
        $agreement = new Agreement();
        $agreement->setName('App Name Daily Subscription Agreement')
            ->setDescription('Basic Subscription')
            ->setStartDate(\Carbon\Carbon::now()->addSeconds(5)->toIso8601String());

        // Set plan id
        $plan = new Plan();
        $plan->setId($request->plan_id);
        $agreement->setPlan($plan);

        // Add payer type
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $agreement->setPayer($payer);

        try {
            // Create agreement
            $agreement = $agreement->create($this->apiContext);

            // Extract approval URL to redirect user
            $approvalUrl = $agreement->getApprovalLink();

            return redirect($approvalUrl);
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
             return redirect()->to(site_url('checkout'));
        } catch (Exception $ex) {
            return redirect()->to(site_url('checkout'));
        }
    }

    public function paypalReturn(Request $request)
    {

        $token = $request->token;
        $agreement = new \PayPal\Api\Agreement();

        try {
            // Execute agreement
            $result = $agreement->execute($token, $this->apiContext);
            // dump($result);
            $subscriptionorder = Subscriptionorder::where('user_id', user_id())->orderBy('created_at', 'desc')->first();
            if (isset($result->id)) {
                $subscriptionorder->agreement_id = $result->id;
                $subscriptionorder->email = $result->payer->payer_info->email;
                $subscriptionorder->start_date = $result->start_date;
                $subscriptionorder->end_date = $result->agreement_details->final_payment_date;
                $subscriptionorder->state = $result->state;
                $subscriptionorder->next_billing_date = $result->agreement_details->next_billing_date;
                $subscriptionorder->cycle_completed = $result->agreement_details->cycles_completed;
                $subscriptionorder->cycle_remaining = $result->agreement_details->cycles_remaining;
                $subscriptionorder->failed_payment_count = $result->agreement_details->failed_payment_count;
                $subscriptionorder->payment_method = $result->payer->payment_method;
                $subscriptionorder->save();
                if (session_id() == '') {
                    session_start();
                }
                $u_session = session_id();
                $u_id = user_id() ?? 0;
                $newsub = DB::table('subscription_order_status')->where('order_id', null)->where('user_id', $u_id)->where('session_id', $u_session)->orderBy('id', 'desc')->update([
                    'agreement_id' =>   $result->id,
                    'sub_order_id' => $subscriptionorder->id
                ]);
            }



            $place_order = $request->place_order;


            $subscriptionorder->order_id = $place_order['id'];
            $subscriptionorder->save();

            $place_order['order_completed'] = 1;
            $place_order['order_status'] = 'new';


            if ($result->agreement_details->cycles_completed == 1) {
                $subscriptionorder->cycle_completed = $result->agreement_details->cycles_completed;
                $subscriptionorder->save();
                $place_order['is_paid'] = 1;
            } else {
                $place_order['is_paid'] = 0;
            }

            $order_manager = new OrderManager();
            $ord = $order_manager->place_order($place_order);
            $place_order['id'] = $ord;

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
                $this->app->event_manager->trigger('mw.cart.checkout.order_paid', $place_order);
            }

            $order_id = $place_order['id'];
            $cart_data = DB::table('cart')->where('order_id', $order_id)->select('rel_id', 'drm_ref_id')->get();
            if ($cart_data) {
                foreach ($cart_data as $cart) {
                    $stocks = DB::table('variants')->where('rel_id', $cart->rel_id)->where('drm_ref_id', $cart->drm_ref_id)->select('stock')->first();
                    $qty    = DB::table('cart')->where('rel_id', $cart->rel_id)->where('drm_ref_id', $cart->drm_ref_id)->select('qty')->first();
                    if ($stocks) {
                        $update_stock = $stocks->stock - $qty->qty;
                        DB::table('variants')->where('rel_id', $cart->rel_id)->where('drm_ref_id', $cart->drm_ref_id)->update([
                            'stock' => $update_stock
                        ]);
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
                $selectValue = DB::table("selected_product_upselling_item")->where('user_id', user_id())->get();
                if ($selectValue->count() > 0) {
                    foreach ($selectValue as $svalue) {
                        DB::table('order_with_upselling')->insert(array('product_id' => $svalue->product_id, "service_id" => $svalue->service_id, 'user_id' => user_id(), "order_id" => $return['id']));
                    }
                    DB::table("selected_product_upselling_item")->where('user_id', user_id())->delete();
                }
                DB::table("product_variants")->where('user_id', user_id())->delete();
                // session_set('thank_you_status', true);
                // $activeTheme = DB::table("thank_you_pages")->where('is_active', 1)->orderBy('template_name', 'asc')->get();

                // dd($request->place_order);



                // return redirect()->to(url('/') . '/thank-you');
            }







            return redirect()->to(url('/thank-you'));

            // echo 'New Subscriber Created and Billed and next billing date: ' . $result->agreement_details->next_billing_date . ' cycles completed: ' . $result->agreement_details->cycles_completed . ' Cycles remaining: ' . $result->agreement_details->cycles_remaining . ' Total Cycle: ' . ($result->agreement_details->cycles_completed + $result->agreement_details->cycles_remaining) . ' failed payment count: ' . $result->agreement_details->failed_payment_count;
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // echo 'You have either cancelled the request or your session has expired';
        }
    }

    public function paypalCancel(Request $request)
    {
         return redirect()->to(site_url('checkout'));
    }

    public function checkSubscription($agr_id)
    {

        // Retrieving the Agreement object from Create Agreement From Credit Card Sample
        $agreementId = $agr_id;


        try {
            $agreement = Agreement::get($agreementId, $this->apiContext);
            return $agreement;
            // if ($agreement->agreement_details->failed_payment_count == 0) {
            //     echo 'this subscriber has no due!';
            // } else {
            //     echo $agreement->agreement_details->failed_payment_count . 'cycle due pending!';
            // }
        } catch (Exception $ex) {
            // dd($ex);
        }
    }

    public function checkTransactions()
    {
        $user = Auth::user();
        //login check
        if (isset($user)) {
            // Retrieving the Agreement object from Create Agreement From Credit Card Sample
            $agreementId = "I-1L6XNWJMCJXW";
            $subscription = Subscriptionorder::where('user_id', Auth::user()->id)->where('agreement_id', $agreementId)->first();

            $params = array('start_date' => date('Y-m-d', strtotime($subscription->start_date)), 'end_date' => date('Y-m-d', strtotime($subscription->end_date)));

            try {
                $result = Agreement::searchTransactions($agreementId, $params, $this->apiContext);
                foreach ($result->agreement_transaction_list as $value) {
                    echo 'transaction_id: ' . $value->transaction_id . ', amount (' . $value->amount->currency . '): ' . $value->amount->value . ', status: ' . $value->status . ', time: ' . $value->time_stamp . '<br>';
                }
            } catch (Exception $ex) {
                // dd($ex);
            }
        } else {
            echo 'Please login First!';
        }
    }

    public function suspendAgreement()
    {
        /** @var Agreement $createdAgreement */
        $agreementId = $_REQUEST['id'];
        $agreement = new Agreement();
        $agreement->setId($agreementId);

        //Create an Agreement State Descriptor, explaining the reason to suspend.
        $agreementStateDescriptor = new AgreementStateDescriptor();
        $agreementStateDescriptor->setNote("Suspending the agreement");



        try {
            $agreement->suspend($agreementStateDescriptor, $this->apiContext);
            $agreement = Agreement::get($agreement->getId(), $this->apiContext);

            //update suspend status
            $subscription = Subscriptionorder::where('user_id', Auth::user()->id)->where('agreement_id', $agreementId)->first();
            $subscription->state = $agreement->state;
            $subscription->save();
            DB::table('subscription_order_status')->where('agreement_id', $agreementId)->update(['order_status' => "inactive"]);
            return redirect()->to(site_url('subscription_product'));
        } catch (Exception $ex) {
            return redirect()->to(site_url('subscription_product'));
        }
    }

    public function reactiveAgreement()
    {
        /** @var Agreement $suspendedAgreement */
        $agreementId = $_REQUEST['id'];
        $suspendedAgreement = new Agreement();
        $suspendedAgreement->setId($agreementId);


        //Create an Agreement State Descriptor, set note.
        $agreementStateDescriptor = new AgreementStateDescriptor();
        $agreementStateDescriptor->setNote("Reactivating the agreement");

        try {
            $suspendedAgreement->reActivate($agreementStateDescriptor, $this->apiContext);
            $agreement = Agreement::get($suspendedAgreement->getId(), $this->apiContext);

            //update reactive status
            $subscription = Subscriptionorder::where('user_id', Auth::user()->id)->where('agreement_id', $agreementId)->first();
            $subscription->state = $agreement->state;
            $subscription->save();
            $time_update = (date('Y-m-d H:i:s'));
            DB::table('subscription_order_status')->where('agreement_id', $agreementId)->update(['order_status' => "active", 'updated_at' => $time_update]);

            return redirect()->to(site_url('subscription_product'));

        } catch (Exception $ex) {
            return redirect()->to(site_url('subscription_product'));

        }
    }

    public function cancelAgreement()
    {


        /** @var Agreement $Agreement */
        $agreementId = $_REQUEST['id'];
        $agreement = new Agreement();
        $agreement->setId($agreementId);

        //Create an Agreement State Descriptor, explaining the reason to cancel.
        $agreementStateDescriptor = new AgreementStateDescriptor();
        $agreementStateDescriptor->setNote("Cancel the agreement");

        try {
            $agreement->cancel($agreementStateDescriptor, $this->apiContext);
            $cancelAgreementDetails = Agreement::get($agreement->getId(), $this->apiContext);

            //update cancel status
            $subscription = Subscriptionorder::where('user_id', Auth::user()->id)->where('agreement_id', $agreementId)->first();
            $subscription->state = $cancelAgreementDetails->state;
            $subscription->save();
            DB::table('subscription_order_status')->where('agreement_id', $agreementId)->update([
                'order_status' => "cancel"
            ]);
            if(!isset($_GET['status'])){
                return redirect()->to(site_url('subscription_product'));
            }
        } catch (Exception $ex) {
            if(!isset($_GET['status'])){
                return redirect()->to(site_url('subscription_product'));
            }
        }

    }
    public function webhookOrderStatus(Request $request)
    {

        $event_type = $request->event_type ?? null;
        if (isset($event_type) && $event_type == "PAYMENT.SALE.COMPLETED") {
            $billing_agreement_resource = $request->resource ?? null;
            $billing_agreement_id = $billing_agreement_resource['billing_agreement_id'] ?? null;
            $billing_agreement_state = $billing_agreement_resource['state'] ?? null;
            if (isset($billing_agreement_id) && $billing_agreement_state == "completed") {
                $sub_data = DB::table('subscriptionorders')->where('agreement_id', $billing_agreement_id)->first();
                if($sub_data->cycle_completed == 0){
                    DB::table('cart_orders')->where('id', $sub_data->order_id)->update([
                        'is_paid' => 1
                    ]);
                    DB::table('subscriptionorders')->where('agreement_id', $billing_agreement_id)->update([
                        'cycle_completed' => 1,
                        'cycle_remaining' => ($sub_data->cycle_remaining-1),
                    ]);
                    DB::table('subscription_order_status')->where('agreement_id', $billing_agreement_id)->update([
                        'order_status' => 'active'
                    ]);
                } else{

                    //add new order
                    $id = $sub_data->order_id;
                    $order_data = get_order_by_id($sub_data->order_id);
                    if(isset($order_data)){
                        $order_data['id']= "";
                        $order_data['updated_at'] = date('Y-m-d H:i:s');
                        $order_data['created_at'] = date('Y-m-d H:i:s');
                        $id = DB::table('cart_orders')->insertGetId($order_data);
                    }

                    //add new cart data in cart table
                    $cart_data = get_cart("order_id=$sub_data->order_id");
                    $cart_data[0]['order_id'] = $id;
                    $cart_data[0]['id']= "";
                    $cart_data[0]['updated_at'] = date('Y-m-d H:i:s');
                    $cart_data[0]['created_at'] = date('Y-m-d H:i:s');
                    $cart_data = $cart_data[0];
                    unset($cart_data['content_data']);
                    unset($cart_data['url']);
                    unset($cart_data['picture']);
                    DB::table('cart')->insertGetId($cart_data);

                    //Update subscriptionorder table
                    DB::table('subscriptionorders')->where('agreement_id', $billing_agreement_id)->update([
                        'cycle_completed' => ($sub_data->cycle_completed+1),
                        'cycle_remaining' => ($sub_data->cycle_remaining-1),
                        'order_id' => $id
                    ]);

                    //add data in subscription order status table
                    $data = DB::table('subscription_order_status')->where('sub_order_id', $sub_data->id)->where('order_type', 'new')->first();
                    $new_order = [];
                    $new_order['product_id'] = $data->product_id;
                    $new_order['subscription_id'] = $data->subscription_id;
                    $new_order['cycles'] = $data->cycles;
                    $new_order['order_price'] = $data->order_price;
                    $new_order['order_id'] = $id;
                    $new_order['order_status'] = $data->order_status;
                    $new_order['user_id'] = $data->user_id;
                    $new_order['session_id'] = $data->session_id;
                    $new_order['order_count'] = $data->order_count+1;
                    $new_order['order_type'] = $data->order_type;
                    $new_order['old_order_id'] = $data->id;
                    $new_order['tax_amount'] = $data->tax_amount;
                    $new_order['created_at'] = date('Y-m-d H:i:s');
                    $new_order['updated_at'] = date('Y-m-d H:i:s');
                    $new_order['agreement_id'] = $data->agreement_id;
                    $new_order['sub_order_id'] = $data->sub_order_id;

                    DB::table('subscription_order_status')->insert($new_order);
                    DB::table('subscription_order_status')->where('id', $data->id)->update(['order_type' => "old"]);

                }
            } else {
                DB::table('webhook_data')->insert([
                'data' => "2nd".$event_type
                ]);
            }
        }else{
            DB::table('webhook_data')->insert([
            'data' => "1st".$event_type
        ]);
        }
        //Storage::put('attempt.txt', $_REQUEST);
        //$option = array();
        //$option['option_value'] = $request;
        //$option['option_key'] = 'webhook';
        //$option['option_group'] = 'webhook_data';
        //save_option($option);
        //DB::table('webhook_data')->insert([
        //    'data' => $request->event_type
        //]);



    }
    public function update()
    {
        $id = $_REQUEST['id'];
        $sub = $_REQUEST['sub'];
        $sub_get = DB::table('subscription_items')->where('id',$sub)->first();
        $status = DB::table('subscription_order_status')->where('agreement_id', $id)->first();
        if(!$sub_get or $sub_get == null or !$status){
            header("Location: ".site_url());
            exit();
        }
        $agreementId =$id;
        $sub_info = explode(" ", $sub_get->sub_interval);

        $subscriptionorder = Subscriptionorder::where('user_id', user_id())->where('agreement_id', $agreementId)->orderBy('created_at', 'desc')->first();
        $order = get_order_by_id($subscriptionorder->order_id);


        // Create a new billing plan
        $plan = new Plan();
        $plan->setName('App Name daily Billing')
            ->setDescription('Daily Subscription to the App Name')
            ->setType('infinite');

        // Set billing plan definitions
        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Regular Payments')
            ->setType('REGULAR')
            ->setFrequency($sub_info[1])
            ->setFrequencyInterval($sub_info[0])
            ->setCycles(0)
            ->setAmount(new Currency(array('value' => $subscriptionorder->subscription_product_price, 'currency' => $order['currency'])));

        // Set merchant preferences
        $merchantPreferences = new MerchantPreferences();
        $merchantPreferences->setReturnUrl(route('paypal.update.return', ['agreement_id' => $agreementId, 'sub_id'=>$sub]))
            ->setCancelUrl(site_url('subscription_product?id='.$status->id))
            ->setAutoBillAmount('yes')
            ->setInitialFailAmountAction('CONTINUE')
            ->setMaxFailAttempts('0');

        $plan->setPaymentDefinitions(array($paymentDefinition));
        $plan->setMerchantPreferences($merchantPreferences);
        //create the plan
        try {
            $createdPlan = $plan->create($this->apiContext);

            try {
                $patch = new Patch();
                $value = new PayPalModel('{"state":"ACTIVE"}');
                $patch->setOp('replace')
                    ->setPath('/')
                    ->setValue($value);
                $patchRequest = new PatchRequest();
                $patchRequest->addPatch($patch);
                $createdPlan->update($patchRequest, $this->apiContext);
                $plan = Plan::get($createdPlan->getId(), $this->apiContext);

                //store plan id
                $newSubscriptionorder = new Subscriptionorder();
                $newSubscriptionorder->user_id = $subscriptionorder->user_id;
                $newSubscriptionorder->product_id = $subscriptionorder->product_id;
                $newSubscriptionorder->product_quantity = $subscriptionorder->product_quantity;
                $newSubscriptionorder->subscription_product_price = $subscriptionorder->subscription_product_price;
                $newSubscriptionorder->total_cycle = $subscriptionorder->total_cycle;
                $newSubscriptionorder->cycle_completed = $subscriptionorder->cycle_completed;
                $newSubscriptionorder->order_id = $subscriptionorder->order_id;
                $newSubscriptionorder->plan_id =  $plan->getId();
                $newSubscriptionorder->save();

                return redirect()->route('paypal.redirect', ['plan_id' => $plan->getId()]);
            } catch (PayPal\Exception\PayPalConnectionException $ex) {
                echo $ex->getCode();
                echo $ex->getData();
                die($ex);
            } catch (Exception $ex) {
                die($ex);
            }
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }
    }

    public function paypalUpdateReturn(Request $request)
    {

        $token = $request->token;
        $agreement = new \PayPal\Api\Agreement();

        //previous id which must be cancel
        $previous_agreement = $request->agreement_id;
        $sub_id = $request->sub_id;

        try {
            // Execute agreement
            $result = $agreement->execute($token, $this->apiContext);
            // store agreement info
            $subscriptionorder = Subscriptionorder::where('user_id', user_id())->orderBy('created_at', 'desc')->first();
            if (isset($result->id)) {
                $subscriptionorder->agreement_id = $result->id;
                $subscriptionorder->email = $result->payer->payer_info->email;
                $subscriptionorder->start_date = $result->start_date;
                $subscriptionorder->end_date = $result->agreement_details->final_payment_date;
                $subscriptionorder->state = $result->state;
                $subscriptionorder->next_billing_date = $result->agreement_details->next_billing_date;
                $subscriptionorder->cycle_remaining = $result->agreement_details->cycles_remaining;
                $subscriptionorder->failed_payment_count = $result->agreement_details->failed_payment_count;
                $subscriptionorder->payment_method = $result->payer->payment_method;
                $subscriptionorder->save();

                $data = DB::table('subscription_order_status')->where('agreement_id', $previous_agreement)->first();
                $new_order = [];
                    $new_order['product_id'] = $data->product_id;
                    $new_order['subscription_id'] = $sub_id;
                    $new_order['cycles'] = $data->cycles;
                    $new_order['order_price'] = $data->order_price;
                    $new_order['order_id'] = $data->order_id;
                    $new_order['order_status'] = $data->order_status;
                    $new_order['user_id'] = $data->user_id;
                    $new_order['session_id'] = $data->session_id;
                    $new_order['order_count'] = $data->order_count;
                    $new_order['order_type'] = $data->order_type;
                    $new_order['old_order_id'] = $data->id;
                    $new_order['tax_amount'] = $data->tax_amount;
                    $new_order['created_at'] = date('Y-m-d H:i:s');
                    $new_order['updated_at'] = date('Y-m-d H:i:s');
                    $new_order['agreement_id'] = $result->id;
                    $new_order['sub_order_id'] = $subscriptionorder->id;

                    $newId = DB::table('subscription_order_status')->insertGetId($new_order);

            }
            $this->cancelPreviousAgreement($previous_agreement);
            if(isset($newId)){
                return redirect()->to(url('/') . '/subscription_product?id='.$newId);
            } else{
                return redirect()->to(url('/') . '/subscription_product');
            }

            // echo 'New Subscriber Created and Billed and next billing date: ' . $result->agreement_details->next_billing_date . ' cycles completed: ' . $result->agreement_details->cycles_completed . ' Cycles remaining: ' . $result->agreement_details->cycles_remaining . ' Total Cycle: ' . ($result->agreement_details->cycles_completed + $result->agreement_details->cycles_remaining) . ' failed payment count: ' . $result->agreement_details->failed_payment_count;
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            // echo 'You have either cancelled the request or your session has expired';
        }
    }
    private function cancelPreviousAgreement($id)
    {


        /** @var Agreement $Agreement */
        $agreementId = $id;
        $agreement = new Agreement();
        $agreement->setId($agreementId);

        //Create an Agreement State Descriptor, explaining the reason to cancel.
        $agreementStateDescriptor = new AgreementStateDescriptor();
        $agreementStateDescriptor->setNote("Cancel the agreement");

        try {
            $agreement->cancel($agreementStateDescriptor, $this->apiContext);
            $cancelAgreementDetails = Agreement::get($agreement->getId(), $this->apiContext);

            //update cancel status
            $subscription = Subscriptionorder::where('user_id', Auth::user()->id)->where('agreement_id', $agreementId)->first();
            $subscription->state = $cancelAgreementDetails->state;
            $subscription->save();
            DB::table('subscription_order_status')->where('agreement_id', $agreementId)->update([
                'order_status' => "cancel"
            ]);
        } catch (Exception $ex) {
        }
    }
}
