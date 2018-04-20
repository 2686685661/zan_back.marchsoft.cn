<?php

namespace App\Http\Controllers\User\Alipay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\libs\alipay\wappay\buildermodel\AlipayTradeWapPayContentBuilder;
use App\libs\alipay\wappay\service\AlipayTradeService;

class AlipayWapController extends Controller {
    public function alipayWapPay() {
        $out_trade_no = '12345678';
        $subject = 'test';
        $total_amount = 0.01;
        $body = 'test test!';
        $timeout_express="1m";

        $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
       
        $payRequestBuilder->setTimeExpress($timeout_express);
        

        $payResponse = new AlipayTradeService();

        $result=$payResponse->wapPay($payRequestBuilder,config('alipay.return_url'),config('alipay.notify_url'));


    }

    public function alipayReturn() {

    }

    public function alipayNotify() {

    }
}