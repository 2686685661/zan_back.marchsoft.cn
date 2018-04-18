<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2018/4/16
 * Time: 14:57
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Models\order;
use Illuminate\Http\Request;

class personalCenter extends Controller
{

    public $mOrder;



    /**
     * @api {get} /getOrderList/:page Request 订单列表
     * @apiName getOrderList
     * @apiGroup User
     *
     * @apiParam {Number} page 页码.
     *
     * @apiSuccess {String} content 订单内容
     * @apiSuccess {Number} created_time  创建时间.
     * @apiSuccess {Number} status  订单状态.
     * @apiSuccess {String} resaon  订单拒绝的理由.
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "code": "0",
     *       "msg": "success",
     *       "data":{
     *                  content:'test',
     *                  created_time:0,
     *                  status:1,
     *                  resaon:''
     *              }
     *     }
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
    public function getOrderList(Request $request)
    {
        if ($request->isMethod('options')) {
            if (!empty($request->page)) {
               $data = Order::getLists($request);
                if (sizeof($data) > 0) {
                    return responseToJson(0, 'success', $data);
                } else {
                    responseToJson(2, 'no data');
                }
            }else{
                return responseToJson(1,'no page');
            }
        } else {
            return responseToJson(1, 'method error');
        }

    }
    /**
     * @api {post} /getOrderList Request 申请请求是否添加成功
     * @apiName addApply
     * @apiGroup User
     *
     * @apiParam {Number} applyUserId 申请人id.
     * @apiParam {String} applyUserName 申请人姓名.
     * @apiParam {String} applyContent 申请点赞币具体内容，包括申请给哪些人，张数以及描述，要求为json数据.
     * @apiParam {Number} applyType 点赞币申请类型的id.
     *
     * @apiSuccess {Number} code 状态码 0正常
     * @apiSuccess {String} msg  响应信息.
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "code": "0",
     *       "msg": "success",
     *     }
     *
     * @apiError UserNotFound The id of the User was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 200
     *     {
     *       "code": "1",
     *        "msg": '响应的报错信息'
     *     }
     */
    public function applicationStar(Request $request)
    {

        if ($request->isMethod('options')) {

                if(!empty($request->applyUserId) && !empty($request->applyUserName) && !empty($request->applyContent) && !empty($request->applyType)){

                }else{
                    return responseToJson(1,'输入数据不完善');
                }

        }

    }

}