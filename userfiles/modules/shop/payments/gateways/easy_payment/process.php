<?php

use App\Services\Order\OrderService;
$easyUrl = app(OrderService::class)->easyPayment($place_order);
if($easyUrl){

    if(isset($easyUrl['success']) && $easyUrl['success'] == false){
        $error['error'] = 'Please Set your Secret key & Checkout key First';
        return $error;
    }
    if($easyUrl['paymentId'] == null){
        $error['error'] = 'Please switch your setting to Live From Administrator';
        return $error;
    }

    $sessionId = uniqid();

    mw()->user_manager->session_set($sessionId ,json_encode($place_order,true) );

    $return = array();
    $return['redirect'] = url('/easy-payment?paymentId='.$easyUrl['paymentId'].'&returnUrl='.url('/easy-payment-success?ref='.$sessionId));
    $return['type'] = 'easy';

    return $return;
}
