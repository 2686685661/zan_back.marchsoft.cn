<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2018/4/16
 * Time: 14:57
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Models\Apply;
use App\Models\order;
use App\Models\ApplyType;
use App\Models\Rule;
use App\Models\Talk;
use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use DB;

class personalCenter extends Controller
{

    public $mOrder;


    /**
     * @api {get} user/personalCenter/getOrderList 用户订单列表
     * @apiName getOrderList
     * @apiGroup User
     *
     * @apiParam {Number} page 页码.
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
//        if ($request->isMethod('options')) {
        if (!empty($request->page)) {
            $data = Order::getLists($request);
            if (sizeof($data) > 0) {
                return responseToJson(0, 'success', $data);
            } else {
                return responseToJson(2, 'no data');
            }

        } else {
            return responseToJson(1, 'no page');
        }
//        } else {
//            return responseToJson(1, 'method error');
//        }

    }

    /**
     * @api {post} user/personalCenter/addApply  申请点赞币
     * @apiName addApply
     * @apiGroup User
     *
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
        
        // if ($request->isMethod('options')) {
            // echo "123";
            if (!empty($request->applyContent) && !empty($request->applyType)) {
                $result = Apply::applyStar($request);
                echo $result;
                return responseToJson(0, 'success');
            } else {
                return responseToJson(1, '输入数据不完善');
            }
        // }

    }

    /**
     * @api {get} user/personalCenter/getApplyType  返回类型列表
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

    public function getTypes(Request $request)
    {

//        if ($request->isMethod('options')) {
        // $data = ApplyType::getTypes();
        $data = DB::table('coin')->where('is_delete',0)->select('id as value','name as label')->get();
        // if (sizeof($data) > 0) {
        return responseToJson(0, 'success', $data);
//         } else {
//             return responseToJson(2, '无数据');
//         }
// //        } else {
//            return responseToJson(1, 'request Error');
//        }
    }

    /**
     * @api {get} user/personalCenter/getBuyOrder  查询需要处理的订单列表
     * @apiName getBuyOrder
     * @apiGroup User
     *
     * @apiSuccess {Number} id 对应订单id
     * @apiSuccess {String} user_id 对应用户id
     * @apiSuccess {String} content  购买内容.
     * @apiSuccess {String} name  用户名称.
     * @apiSuccess {Number} qq_account  用户qq号
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "code": "0",
     *       "msg": "success",
     *       "data":{
     *                  id:,
     *                  user_id:,
     *                  content:,
     *                  name:,
     *                  qq_account:
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
    public function getBuyOrder(Request $request)
    {

        session('group_id',1);
        if (!empty(session('group_id'))) {
            return responseToJson(0, 'success', Order::getOrder());
        } else {
            return responseToJson(1, 'no GroupId');
        }

    }

    /**
     * @api {get} user/personalCenter/getProcessOrderr  查询用户已经处理的订单列表
     * @apiName getProcessOrderr
     * @apiGroup User
     * @apiParam {Number} page 页码
     *
     * @apiSuccess {Number} user_id 对应用户id
     * @apiSuccess {String} content  购买内容.
     * @apiSuccess {String} name  用户名称.
     * @apiSuccess {Number} qq_account  用户qq号
     * @apiSuccess {Number} status 订单状态 0未接受 1拒绝 2接受 3完成
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "code": "0",
     *       "msg": "success",
     *       "data":{
     *                  user_id:,
     *                  content:,
     *                  name:,
     *                  qq_account,
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
    public function getProcessOrderr(Request $request)
    {

        if (!empty($request->page)) {
            return responseToJson(0, 'success', Order::getPrecessOrder($request));
        } else {
            return responseToJson(1, 'no page');
        }

    }

    /**
     * @api {post} user/personalCenter/updateOrder  处理订单
     * @apiName updateOrder
     * @apiGroup User
     * @apiParam {Number} orderId 账单Id
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "code": "0",
     *       "msg": "success"
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

    public function processOrder(Request $request)
    {

        if (!empty($request->orderId)) {

            $data = Order::processOrder($request);
            if ($data == 1) {
                return responseToJson(0, 'success');
            } else {
                return responseToJson(1, '出错了,请重试');
            }
        } else {
            return responseToJson(1, '请求数据不完整，请刷新一下重试');
        }
    }


    /**
     * @api {get} user/personalCenter/getTalk  获取匿名聊天
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
    public function getTalk(Request $request)
    {

        if (!empty($request->page)) {

            $data = Talk::getTalk($request);
            if (sizeof($data) > 0) {
                return responseToJson(0, 'success', $data);
            } else {
                return responseToJson(2, 'no data');
            }
        } else {
            return responseToJson(1, 'no page');
        }
    }

    /**
     * @api {post} user/personalCenter/addTalk  添加匿名聊天
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
    public function addTalk(Request $request)
    {

        $content = $request->content;
        if ($content!=null&&$content!='') {
            $result = Talk::addTalk($content);
            return responseToJson(0, 'success');
        } else {
            return responseToJson(1, 'no content');
        }
    }

    /**
     * @api {post} user/personalCenter/updatePassword  修改密码
     * @apiName updatePassword
     * @apiGroup User
     * @apiParam {String} oldPassword 旧密码
     * @apiParam {String} newPassword 新密码
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
    public function updatePassword(Request $request)
    {

        if (!empty(get_session_user_id())) {
            if (!empty($request->oldPassword)) {
                if (!empty($request->newPassword)) {

                    // if (!empty($request->newPasswordAgain)) {
                        if (md5(md5($request->oldPassword)) === User::getPassword()->password) {
                                $result = User::updatePassword($request);
                                if ($result == 1)
                                    return responseToJson(0, 'success');
                                else
                                    return responseToJson(1, '出错了,请重试一下');

                        } else {
                            return responseToJson(1, '密码验证错误，请重新输入旧密码');
                        }
                    // } else {
                        // return responseToJson(1, '请确认密码');
                    // }
                } else {
                    return responseToJson(1, '请输入新密码');
                }
            } else {
                return responseToJson(1, '请输入旧密码');
            }
        } else {
            return responseToJson(1, '请输入账号');
        }
    }

    /**
     * @api {get} user/personalCenter/getRule  查看点赞币规则
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
    public function getRule(Request $request)
    {

        $data = Rule::getRule();
        if (sizeof($data) == 1) {
            return responseToJson(0, 'success', $data);
        } else {
            return responseToJson(2, 'no data');
        }

    }

}