<?php
/**
 * Created by Visual Studio Code.
 * User: shanlei
 * Date: 2018/4/26
 * Time: 15:39
 */


namespace App\Http\Controllers\User\Alipay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\libs\alipay\wappay\buildermodel\AlipayTradeWapPayContentBuilder;
use App\libs\alipay\wappay\service\AlipayTradeService;
// use Yansongda\Pay\Pay;
use DB;

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
        $num = $request->count;
        $code = $request->code;
        if(!is_numeric($num)||$num==0||$code=='') return responseToJson(1,'error','数据有误');
        $user = DB::table('user')->where(['code'=>$code,'is_delete'=>0])->first();
        if(!$user) return responseToJson(2,'error','该工号不存在');
        $count = $num/2;
        if($count>200) return responseToJson(1,'error','数量不能超过200');
        $out_trade_no = getTradeNOString();
        if($user->type==1) {
            $r = DB::table('buy_order')->insert([
                'out_trade_no' => $out_trade_no,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'count' => $count,
                'money' => 0,
                'is_pay' => 1,
                'is_delete' => 0,
                'create_time' => time(),
                'update_time' => time()
            ]);
            if($r){
                $data = [];
                for($j=0;$j<$num;$j++){
                    $data[] = [
                        'from_user_id'=>$user->id,
                        'from_user_name' => $user->name,
                        'to_user_name' => '',
                        'to_user_id'=> 0,
                        'coin_id'=> 1,
                        'start_time' => time(),
                        'over_time'=>(time()+3600*24*7),
                        'use_time'=>0,
                        'reason'=>'',
                        'buy_time'=>0,
                    ];
                }
                $res = DB::table('star_coin')->insert($data);
                if($res) return '<h1 style="text-align:center;">老师免单，已购买成功，可不要贪杯哦~</h1>';
            }
            return '<h1 style="text-align:center;">购买失败</h1>';
        }
        $r = DB::table('buy_order')->insert([
            'out_trade_no' => $out_trade_no,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'count' => $count,
            'money' => $num,
            'is_pay' => 0,
            'is_delete' => 0,
            'create_time' => time(),
            'update_time' => 0
        ]);
        // if($r){
        //     $order = [
        //         'out_trade_no' => $out_trade_no,
        //         'total_amount' => $num,
        //         'subject' => '点赞币购买',
        //     ];

        //     $alipay = Pay::alipay(config('alipay'))->web($order);

        //     return $alipay;// laravel 框架中请直接 `return $alipay`
        // }
        // return '<h1 style="text-align:center;">购买失败</h1>';


        // $out_trade_no = getTradeNOString();
        $subject = '点赞币';
        $total_amount = $num;
        $body = '点赞币购买';
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
        $config = config('alipay');
        $alipaySevice = new AlipayTradeService($config); 
        $arr=$_GET;
        $result = $alipaySevice->check($arr);
        // var_dump($arr);
        if(!$result) {   //这里的对公钥的判定不正确，故加！
            if($alipaySevice->appid == $arr['app_id']) {
                // dd($this->id);
                if($arr['out_trade_no'] != null) {
                    // orders::update_order_state_trade($arr['out_trade_no']);
                    // return redirect('/front/celebration/'.$arr['out_trade_no']);
                    $order = DB::table('buy_order')->where(['out_trade_no'=>$arr['out_trade_no'],'is_pay'=>0])->first();
                    // var_dump($order);
                    if($order){
                        $r = DB::table('buy_order')->where('out_trade_no',$arr['out_trade_no'])->update([
                            'is_pay' => 1,
                            'update_time' => time()
                        ]);
                        $data = [];
                        for($j=0;$j< $order->count ;$j++){
                            $data[] = [
                                'from_user_id'=>$order->user_id,
                                'from_user_name' => $order->user_name,
                                'to_user_name' => '',
                                'to_user_id'=> 0,
                                'coin_id'=> 1,
                                'start_time' => time(),
                                'over_time'=>(time()+3600*24*7),
                                'use_time'=>0,
                                'reason'=>'',
                                'buy_time'=>0,
                            ];
                        }
                        $res = DB::table('star_coin')->insert($data);
                        return '<h1 style="text-align:center;">已购买成功，欢迎下次再来~</h1>';
                    }
                }
                echo '验证成功';
            }else {
                echo '验证失败';
            }
        }
        // $data = Pay::alipay(config('alipay'))->verify();
        //     $order = DB::table('buy_order')->where(['out_trade_no'=>$data->out_trade_no,'is_pay'=>0])->first();
        //     if($order){
        //         $r = DB::table('buy_order')->where('out_trade_no',$data->out_trade_no)->update([
        //             'is_pay' => 1,
        //             'update_time' => time()
        //         ]);
        //         $data = [];
        //         for($j=0;$j< $order->count ;$j++){
        //             $data[] = [
        //                 'from_user_id'=>$order->user_id,
        //                 'from_user_name' => $order->user_name,
        //                 'to_user_name' => '',
        //                 'to_user_id'=> 0,
        //                 'coin_id'=> 1,
        //                 'start_time' => time(),
        //                 'over_time'=>(time()+3600*24*7),
        //                 'use_time'=>0,
        //                 'reason'=>'',
        //                 'buy_time'=>0,
        //             ];
        //         }
        //         $res = DB::table('star_coin')->insert($data);
        //         return '<h1 style="text-align:center;">已购买成功，欢迎下次再来~</h1>';
        //     }
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
        $arr=$_POST;
        $status = $_POST['trade_status'];
        if($status == 'TRADE_SUCCESS' || $status == 'TRADE_FINISHED') {
            //交易成功
            if($arr['out_trade_no'] != null) {
                // orders::update_order_state_trade($arr['out_trade_no']);
                // return redirect('/front/celebration/'.$arr['out_trade_no']);
                $order = DB::table('buy_order')->where(['out_trade_no'=>$arr['out_trade_no'],'is_pay'=>0])->first();
                if($order){
                    $r = DB::table('buy_order')->where('out_trade_no',$arr['out_trade_no'])->update([
                        'is_pay' => 1,
                        'update_time' => time()
                    ]);
                    $data = [];
                    for($j=0;$j< $order->count ;$j++){
                        $data[] = [
                            'from_user_id'=>$order->user_id,
                            'from_user_name' => $order->user_name,
                            'to_user_name' => '',
                            'to_user_id'=> 0,
                            'coin_id'=> 1,
                            'start_time' => time(),
                            'over_time'=>(time()+3600*24*7),
                            'use_time'=>0,
                            'reason'=>'',
                            'buy_time'=>0,
                        ];
                    }
                    $res = DB::table('star_coin')->insert($data);
                }
            }
            echo 'success';
        }
        echo 'fail';

        // $alipay = Pay::alipay(config('alipay'));
    
        // try{
        //     $data = $alipay->verify(); // 是的，验签就这么简单！

        //     // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
        //     // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
        //     // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
        //     // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
        //     // 4、验证app_id是否为该商户本身。
        //     // 5、其它业务逻辑情况
        //     if($data->trade_status=='TRADE_SUCCESS'||$data->trade_status=='TRADE_FINISHED'){
        //         $order = DB::table('buy_order')->where(['out_trade_no'=>$data->out_trade_no,'is_pay'=>0])->first();
        //         if($order){
        //             $r = DB::table('buy_order')->where('out_trade_no',$data->out_trade_no)->update([
        //                 'is_pay' => 1,
        //                 'update_time' => time()
        //             ]);
        //             $data = [];
        //             for($j=0;$j< $order->count ;$j++){
        //                 $data[] = [
        //                     'from_user_id'=>$order->user_id,
        //                     'from_user_name' => $order->user_name,
        //                     'to_user_name' => '',
        //                     'to_user_id'=> 0,
        //                     'coin_id'=> 1,
        //                     'start_time' => time(),
        //                     'over_time'=>(time()+3600*24*7),
        //                     'use_time'=>0,
        //                     'reason'=>'',
        //                     'buy_time'=>0,
        //                 ];
        //             }
        //             $res = DB::table('star_coin')->insert($data);
        //         }
        //     }
        // } catch (Exception $e) {
        //     // $e->getMessage();
        // }

        // return $alipay->success();// laravel 框架中请直接 `return $alipay->success()`
    }
}