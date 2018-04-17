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

    function __construct()
    {
        $this->mOrder = new order();
    }


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
     *       "code": "0",
     *        "msg": '响应的报错信息'
     *     }
     *
     *      HTTP/1.1 200
     *     {
     *       "code": "2",
     *        "msg": '数据加载完毕，已经无法加载相应数据'
     *     }
     */
    public function get_order_list(Request $request)
    {
        if ($request->isMethod('get')) {
            $data = $this->mOrder->get_lists($request);
            if (sizeof($data) > 0) {
                return responseToJson(0, 'success', $data);
            } else {
                responseToJson(2, 'no data');
            }
        } else {
            return responseToJson(1, 'method error');
        }

    }

}