<?php



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
use Illuminate\Routing\Redirector;
use App\Models\Subscriptionorder;
// use Exception;


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



$apiContext;
$mode;
$client_id;
$secret;
$sub_data = DB::table('subscription_items')->where('id', $sub->subscription_id)->first();
$sub_info = explode(" ", $sub_data->sub_interval);

try {
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
        $client_id = get_option('client_id', 'paypal_subscription_payment') ?? null;
        $secret = get_option('client_secret', 'paypal_subscription_payment') ?? null;
    } else {
        $client_id = get_option('client_id', 'paypal_subscription_payment') ?? null;
        $secret = get_option('client_secret', 'paypal_subscription_payment') ?? null;
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
    }

    // Set the Paypal API Context/Credentials
    $apiContext = new ApiContext(new OAuthTokenCredential($client_id, $secret));

    $apiContext->setConfig($setting);







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
        ->setAmount(new Currency(array('value' => $place_order['payment_amount'], 'currency' => $place_order['payment_currency'])));

    // Set merchant preferences
    $merchantPreferences = new MerchantPreferences();
    $merchantPreferences->setReturnUrl(route('paypal.return', ['place_order' => $place_order]))
        ->setCancelUrl(route('paypal.cancel'))
        ->setAutoBillAmount('yes')
        ->setInitialFailAmountAction('CONTINUE')
        ->setMaxFailAttempts('0');

    $plan->setPaymentDefinitions(array($paymentDefinition));
    $plan->setMerchantPreferences($merchantPreferences);

    //create the plan
    $createdPlan = $plan->create($apiContext);


    $patch = new Patch();
    $value = new PayPalModel('{"state":"ACTIVE"}');
    $patch->setOp('replace')
        ->setPath('/')
        ->setValue($value);
    $patchRequest = new PatchRequest();
    $patchRequest->addPatch($patch);
    $createdPlan->update($patchRequest, $apiContext);
    $plan = Plan::get($createdPlan->getId(), $apiContext);

    //store plan id
    $subscriptionorder = new Subscriptionorder();
    $subscriptionorder->user_id = $sub->user_id;
    $subscriptionorder->product_id = $sub->product_id;
    $subscriptionorder->product_quantity = $place_order['items_count'];
    $subscriptionorder->subscription_product_price = $place_order['payment_amount'];
    $subscriptionorder->total_cycle = $sub->cycles;
    $subscriptionorder->plan_id = $plan->getId();
    $subscriptionorder->save();

    $return = array();
    $return['redirect'] = site_url() . 'subscribe/paypal?plan_id=' . $plan->getId();
    $return['type'] = 'subscription';
    return  $return;
} catch (Exception $ex) {
    return "P-0";
}
