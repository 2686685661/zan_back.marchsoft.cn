<?php

namespace App\Http\Controllers\User\Alipay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\libs\alipay\wappay\buildermodel\AlipayTradeWapPayContentBuilder;
use App\libs\alipay\wappay\service\AlipayTradeService;

class AlipayWapController extends Controller {

        /**
     * @api {get} /alipay/wappay 购买点赞币支付宝手机网站支付接口
     * @apiName alipayWapPay
     * @apiGroup alipay
     *
     * @apiParam {String} out_trade_no 唯一订单id(后端自动生成).
     * @apiParam {String} subject 订单介绍.
     * @apiParam {Number} total_amount 支付金额.
     * @apiParam {String} body 订单主题介绍.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *      回调return_url,页面重新加载
     *
     * @apiError UserNotFound The id of the User was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 200
     *     {
     *       "code": "1",
     *        "msg": '响应的报错信息'
     *     }
     *
     *      HTTP/1.1 200
     *     {
     *       "code": "2",
     *        "msg": '数据加载完毕，已经无法加载相应数据'
     *     }
     */
    public function alipayWapPay(Request $request) {
        $out_trade_no = getTradeNOString();
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

            /**
     * @api {get} /alipay/return 支付同步回调接口
     * @apiName alipayReturn
     * @apiGroup alipay
     *
     * @apiParam {String} out_trade_no 唯一订单id(后端自动生成).
     * @apiParam {String} subject 订单介绍.
     * @apiParam {Number} total_amount 支付金额.
     * @apiParam {String} body 订单主题介绍.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     * @apiError UserNotFound The id of the User was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 200
     *     {
     *       "code": "1",
     *        "msg": '响应的报错信息'
     *     }
     *
     *      HTTP/1.1 200
     *     {
     *       "code": "2",
     *        "msg": '数据加载完毕，已经无法加载相应数据'
     *     }
     */
    public function alipayReturn() {
        
    }

    /**
     * @api {post} /alipay/notify 支付异步回调接口
     * @apiName alipayNotify
     * @apiGroup alipay
     *
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *
     * @apiError UserNotFound The id of the User was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 200
     *     {
     *       "code": "1",
     *        "msg": '响应的报错信息'
     *     }
     *
     *      HTTP/1.1 200
     *     {
     *       "code": "2",
     *        "msg": '数据加载完毕，已经无法加载相应数据'
     *     }
     */
    public function alipayNotify() {

    }
}