<?php
Route::group(['middleware' => \MicroweberPackages\App\Http\Middleware\SessionlessMiddleware::class, 'namespace' => '\MicroweberPackages\App\Http\Controllers'], function () {
    Route::any('/apijs', 'JsCompileController@apijs');
    Route::any('apijs/{all}', array('as' => 'apijs', 'uses' => 'JsCompileController@apijs'))->where('all', '.*');
    Route::any('/apijs_settings', 'JsCompileController@apijs_settings');
    Route::any('/apijs_combined', 'JsCompileController@apijs_combined');
    Route::any('/apijs_liveedit', 'JsCompileController@apijs_liveedit');





    Route::any('api_nosession/{all}', array('as' => 'api', 'uses' => 'FrontendController@api'))->where('all', '.*');
    Route::any('/api_nosession', 'FrontendController@api');
    Route::any('/favicon.ico', function () {
        return;
    });
});


Route::group(['middleware' => 'static.api', 'namespace' => '\MicroweberPackages\App\Http\Controllers'], function () {

    Route::any('/userfiles/{path}', ['uses' => '\MicroweberPackages\App\Http\Controllers\ServeStaticFileContoller@serveFromUserfiles'])->where('path', '.*');
});


Route::get('/csrf', function () {
    return response()->json(['token' => csrf_token()], 200);
})->name('csrf');


// 'middleware' => 'web',
Route::group(['middleware' => 'public.web', 'namespace' => '\MicroweberPackages\App\Http\Controllers'], function () {
    Route::any('download_digital_product/{order_id}', 'DownloadController@index')->name('downloadDigitalProduct');
    Route::get('admin_download_digital_product/{product_id}', 'DownloadController@adminDownload')->name('adminDownloadDigitalProduct');

    // paypal subscription
    Route::any('create_paypal_plan', 'PaypalController@create_plan')->name('paypal.create');

    Route::get('/subscribe/paypal', 'PaypalController@paypalRedirect')->name('paypal.redirect');
    Route::get('/subscribe/paypal/return', 'PaypalController@paypalReturn')->name('paypal.return');
    Route::get('/subscribe/paypal/cancel', 'PaypalController@paypalCancel')->name('paypal.cancel');

    Route::get('/subscribe/suspend', 'PaypalController@suspendAgreement')->name('paypal.subscribe.suspend');
    Route::get('/subscribe/reactive', 'PaypalController@reactiveAgreement')->name('paypal.subscribe.reactive');
    Route::get('/subscribe/cancel', 'PaypalController@cancelAgreement')->name('paypal.subscribe.cancel');

    Route::get('/subscribe/check', 'PaypalController@checkSubscription')->name('paypal.subscribe.check');
    Route::get('/subscribe/transactions/history', 'PaypalController@checkTransactions')->name('paypal.transactions.history');

    Route::any('/webhook-order-status', 'PaypalController@webhookOrderStatus')->name('paypal.webhook.status');

    Route::any('/update_subscription_plan', 'PaypalController@update')->name('paypal.update');
    Route::get('/subscribe/update/paypal/return', 'PaypalController@paypalUpdateReturn')->name('paypal.update.return');

    Route::get('/webhook_for_optin_form', 'OptinController@webhook_for_optin_form')->name('optin.form');

    Route::any('/', 'FrontendController@index');

    Route::any('/api', 'FrontendController@api');
    Route::any('/api/{slug}', 'FrontendController@api');

    $custom_admin_url = \Config::get('microweber.admin_url');
    $admin_url = 'admin';
    if ($custom_admin_url) {
        $admin_url = $custom_admin_url;
    }

    Route::any('/' . $admin_url, 'AdminController@index');
    Route::any($admin_url, array('as' => 'admin', 'uses' => 'AdminController@index'));

    Route::any($admin_url . '/{all}', array('as' => 'admin', 'uses' => 'AdminController@index'))->where('all', '.*');


    Route::any('api/{all}', array('as' => 'api', 'uses' => 'FrontendController@api'))->where('all', '.*');
    Route::any('api_html/{all}', array('as' => 'api', 'uses' => 'FrontendController@api_html'))->where('all', '.*');
    Route::any('/api_html', 'FrontendController@api_html');
    //
    Route::any('/editor_tools', 'FrontendController@editor_tools');
    Route::any('editor_tools/{all}', array('as' => 'editor_tools', 'uses' => 'FrontendController@editor_tools'))->where('all', '.*');

    //>>> Exlude in order to be able to reaload module after successfull register
    Route::group([
        'excluded_middleware' => ['public.web'],
    ], function () {
        Route::any('/module/', 'FrontendController@module');
        Route::any('module/{all}', array('as' => 'module', 'uses' => 'FrontendController@module'))->where('all', '.*');
    });
    //<<< Exlude in order to be able to reaload module after successfull register

    Route::any('robots.txt', 'FrontendController@robotstxt');
    Route::get('sitemap.xml', 'SitemapController@index');
    Route::get('sitemap.xml/categories', 'SitemapController@categories');
    Route::get('sitemap.xml/tags', 'SitemapController@tags');
    Route::get('sitemap.xml/products', 'SitemapController@products');
    Route::get('sitemap.xml/posts', 'SitemapController@posts');
    Route::get('sitemap.xml/pages', 'SitemapController@pages');
    Route::any('rss', 'RssController@index');
    Route::any('rss-products', 'RssController@products');
    Route::any('rss-blog', 'RssController@blogs');
    Route::any('easy-payment', 'EasyPaymentController@easyPayment');
    Route::any('easy-payment-success', 'EasyPaymentController@easyPaymentSuccess');
    Route::get('/get-logs', function(){
        $userToken = Config('microweber.userToken');
        $passToken = Config('microweber.userPassToken');
        $syncId = isset($_REQUEST['sync_id']) ? $_REQUEST['sync_id'] : 0;

        $failedData = DB::table('sync_processing_data_status_v2')
        ->select('sync_processing_data_status_v2.*','sync_processing_history_v2.sync_id as syncId')
        ->join('sync_processing_history_v2', 'sync_processing_history_v2.id','=','sync_processing_data_status_v2.processing_id')
        ->where('is_success', 0)
        ->where('sync_processing_history_v2.sync_id' , $syncId)
        ->get();
        $errorMessage = array();
        $errorMessageDt = array();
        foreach($failedData as $fData){
            $errorMessageDt[$fData->drm_ref_id] = ['msg' => (array)json_decode($fData->msg),
                                                    'syncId' => $fData->syncId,
                                                    'id' => $fData->id,
                                                    'processing_id' => $fData->processing_id,];
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://159.65.124.158/api/dt-channel-products/get',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('ids' => $failedData->pluck('drm_ref_id')),
        CURLOPT_HTTPHEADER => array(
            'userPassToken: '.$passToken,
            'userToken: '.$userToken
        ),
        ));

        $response = json_decode(curl_exec($curl));
        curl_close($curl);

        foreach($response->data as $data){
            $errorMessage[$data->id]['title'] = json_decode($data->title)->de;
            $errorMessage[$data->id]['url'] = "https://drm.software/admin/channel-products/details/".$data->id;
            if($data->connection_status == 3){

                $missingFields = json_decode($data->missing_attributes);
                if(count($missingFields)>0){
                    $errorMessage[$data->id]['log'] = "Fill the Field " . implode(',',$missingFields);
                }else{
                    $errorMessage[$data->id]['log'] = "We are tring to find the problem with this product";
                }

            }elseif($data->connection_status == 2){
                $missingFields = json_decode($data->missing_attributes);
                if(count($missingFields)>0){
                    $errorMessage[$data->id]['log'] = "Fill the Field " . implode(',',$missingFields);
                }else{
                    $errorMessage[$data->id]['log'] = implode(',',array_keys($errorMessageDt[$data->id]['msg']))." is not valid";
                }
                $errorMessage[$data->id]['resolve'] = true;
                $errorMessage[$data->id]['resolveUrl'] = url('/api/v1/resolve?id='.$data->id.'&sync_id='.$errorMessageDt[$data->id]['syncId'].'&proccessing_id='.$errorMessageDt[$data->id]['processing_id']);
            }elseif($data->connection_status == 1){
                $missingFields = json_decode($data->missing_attributes);
                if(count($missingFields)>0){
                    $errorMessage[$data->id]['log'] = "Fill the Field " . implode(',',$missingFields);
                }else{
                    $errorMessage[$data->id]['log'] = "Product is already Synced";
                }
                $errorMessage[$data->id]['clear'] = true;
                $errorMessage[$data->id]['clearUrl'] = url('/api/v1/resolve?id='.$data->id.'&sync_id='.$errorMessageDt[$data->id]['syncId'].'&proccessing_id='.$errorMessageDt[$data->id]['processing_id'].'&clear=true');
            }

        }
        $html = '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8" /><meta http-equiv="X-UA-Compatible" content="IE=edge" /><meta name="viewport" content="width=device-width, initial-scale=1.0" /><title>Software log</title></head><style>.log-wrapper .log-container {max-width: 1170px;padding: 0px 20px;margin: 30px auto;}.log-wrapper tr {background-color: #fff;}tr:nth-child(even) {background-color: orange;}.log-wrapper td a {text-decoration: none;font-weight: 600;color: #333;border-bottom: 1px solid #333;}.log-wrapper .actions-wrapper {display: flex;gap: 20px;justify-content: center;}</style><body><div class="log-wrapper"><div class="log-container"><table style="border-collapse: collapse; width: 100%"><tr><th style="border: 1px solid #dddddd; text-align: center; padding: 8px">Title</th><th style="border: 1px solid #dddddd; text-align: center; padding: 8px">Log</th><th style="border: 1px solid #dddddd; text-align: center; padding: 8px">Actions</th></tr>';
        foreach($errorMessage as $msg){
            $html .= '<tr><th style="border: 1px solid #dddddd; text-align: center; padding: 8px">'.$msg['title'];
            $html .= '</th><th style="border: 1px solid #dddddd; text-align: center; padding: 8px">'.$msg['log'];
            $html .= '</th><th style="border: 1px solid #dddddd; text-align: center; padding: 8px">';
            $html .= '<div class="actions-wrapper"><a href="'.$msg['url'].'" target="_blank" class="btn btn-info" title="'.$msg['title'].'">View</a>';
            if(isset($msg['resolve'])){
                $html .= '<a href="'.$msg['resolveUrl'].'" class="btn btn-info" title="'.$msg['title'].'">Resolve</a>';
            }elseif(isset($msg['clear'])){
                $html .= '<a href="'.$msg['clearUrl'].'" class="btn btn-info" title="'.$msg['title'].'">Clear-Log</a>';
            }
            $html .= '</div></th></tr>';
        }
        $html .= '</table></div></div></body></html>';

        return $html;

    });
    Route::any('{all}', array('as' => 'all', 'uses' => 'FrontendController@index'))->where('all', '.*');
});
