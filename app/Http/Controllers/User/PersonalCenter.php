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
use App\Models\ApplyType;
use Illuminate\Http\Request;

class personalCenter extends Controller
{

    public $mOrder;



    /**
     * @api {get} /getOrderList 订单列表
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
     * @api {post} /addApply  申请点赞币
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
    /**
     * @api {get} /getApplyType  返回类型列表
     * @apiName getApplyType
     * @apiGroup User
     *
     * @apiSuccess {Number} id 类型id
     * @apiSuccess {String} type_name  类型名称.
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "code": "0",
     *       "msg": "success",
     *       "data":{
     *                  id:,
     *                  type_name:
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
     *        "msg": '无数据'
     *     }
     */

    public function getTypes(Request $request){

        if($request->isMethod('options')){
            $data = ApplyType::getTypes();
            if(sizeof($data)>0){
                return responseToJson(0,'success',$data);
            }else{
                return responseToJson(2,'无数据');
            }
        }else{
            return responseToJson(1,'request Error');
        }
    }

    /**
     * @api {get} /getBuyOrder  查询需要处理的订单列表
     * @apiName getBuyOrder
     * @apiGroup User
     * @apiParam {Number} id 用户id.
     * @apiParam {Number} groupId 组别id.
     *
     * @apiSuccess {Number} id 类型id
     * @apiSuccess {String} content  购买内容.
     * @apiSuccess {String} name  用户名称.
     * @apiSuccess {Number} code  用户qq号
     * @apiSuccess {Number} status 订单状态 0未接受 1拒绝 2接受 3完成
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "code": "0",
     *       "msg": "success",
     *       "data":{
     *                  id:,
     *                  content:,
     *                  name:,
     *                  code,
     *                  status:
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
     *        "msg": '无数据'
     *     }
     */
    public function getBuyOrder(Request $request){


    }

    /**
     * @api {get} /getTalk  获取匿名聊天
     * @apiName getTalk
     * @apiGroup User
     * @apiParam {Number} page 页码
     * @apiSuccess {String} content 匿名内容
     * @apiSuccess {int} create_time 上传时间
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "code": "0",
     *       "msg": "success",
     *       "data":{
     *                  content:,
     *                  create_time:
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
     *        "msg": '无数据'
     *     }
     */
    public function getTalk(Request $request){

    }

    /**
     * @api {post} /addTalk  添加匿名聊天
     * @apiName addTalk
     * @apiGroup User
     *
     * @apiParam {String} content 内容
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
    public function addTalk(Request $request){

    }

    /**
     * @api {post} /updatePassword  修改密码
     * @apiName updatePassword
     * @apiGroup User
     *
     * @apiParam {Nubmer} id 用户id
     * @apiParam {String} oldPassword 旧密码
     * @apiParam {String} newPassword 新密码
     * @apiParam {String} newPasswordAgain 再次输入的新密码
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
    public function updatePassword(Request $request){

    }

    /**
     * @api {get} /getRule  查看点赞币规则
     * @apiName getRule
     * @apiGroup User
     *
     * @apiSuccess {String} content 点赞币规则.
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "code": "0",
     *       "msg": "success",
     *       "data":{
     *                  content:
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
     *        "msg": '无数据'
     *     }
     */
    public function getRule(Request $request){

    }
}