<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/4/20
 * Time: 12:27
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Models\StarCoin;
use App\Models\User;
use Illuminate\Http\Request;

class ThumbsUpController extends Controller
{
    /**
     * @api {get} user/thumbsUp/getCoinList 得到自己未使用（未点出的）的点赞币
     * @apiName getCoinList
     * @apiGroup User
     *
     * @apiParam {Number} pageSize 一次加载多少
     * @apiParam {Number} page 分页 第几页
     *
     * @apiSuccess {Number} code 状态码：0 请求成功，其他数值 请求失败
     * @apiSuccess {String} msg 响应信息
     * @apiSuccess {String} result 响应结果
     * @apiSuccess {Object[]} coinList 未使用（空白的，未点出的）的点赞币数组
     * @apiSuccess {String} id 点赞币id
     * @apiSuccess {String} coin_id 币种id
     * @apiSuccess {String} coin_name 币种name
     * @apiSuccess {String} start_time 点赞币开始生效时间（时间戳）
     * @apiSuccess {String} over_time 点赞币结束生效时间（时间戳）
     * @apiSuccessExample Success-Response：请求成功
     * HTTP/1.1 200 OK
     * {
     *  "code": 0,
     *  "msg": "success",
     *  "result": {
     *       coinList:[
     *          {"id":"xxx","coin_id":"xxxxxxxx","coin_name":"xxxxxxxxxxxx","start_time":888888,"over_time":888888888},
     *          {"id":"xxx","coin_id":"xxxxxxxx","coin_name":"xxxxxxxxxxxx","start_time":888888,"over_time":888888888}
     *       ]
     *    },
     * }
     *
     * @apiErrorExample Error-Response: 请求失败
     * HTTP/1.1 200
     * {
     *  "code": 1,
     *  "msg": "failed",
     *  "result": {
     *
     *    },
     * }
     *
     */
    public function getCoinList(Request $request){
        $pageSize   = $request->input('pageSize', 5);
        $userId = get_session_user_id();
        if($userId){
            $coins = StarCoin::getCoinList($userId,$pageSize);
            if($coins){
                return responseToJson(0,'success',$coins);
            }else{
                return responseToJson(1,'failed');
            }
        }
    }

    /**
     * @api {get} user/thumbsUp/getUsedCoinList 得到自己已使用的点赞币
     * @apiName getUsedCoinList
     * @apiGroup User
     *
     * @apiParam {Number} pageSize 一次加载多少
     * @apiParam {Number} page 分页 第几页
     *
     * @apiSuccess {Number} code 状态码：0 请求成功，其他数值 请求失败
     * @apiSuccess {String} msg 响应信息
     * @apiSuccess {String} result 响应结果
     * @apiSuccess {Object[]} usedCoinList 已使用（已点出的）的点赞币数组
     * @apiSuccess {String} id 点赞币id
     * @apiSuccess {String} coin_id 币种id
     * @apiSuccess {String} to_user_id 点给某人<某人的id>
     * @apiSuccess {String} to_user_name 点给某人<某人的name>
     * @apiSuccess {String} userImgLink 某人头像链接
     * @apiSuccess {String} reason 点赞原因
     * @apiSuccess {String} use_time 点赞时间（时间戳）
     * @apiSuccess {String} start_time 点赞币开始生效时间（时间戳）
     * @apiSuccess {String} over_time 点赞币结束生效时间（时间戳）
     * @apiSuccessExample Success-Response：请求成功
     * HTTP/1.1 200 OK
     * {
     *  "code": 0,
     *  "msg": "success",
     *  "result": {
     *       usedCoinList:[
     *          {"id":"xxx","coin_id":"xxx","to_user_id":"xxx","to_user_name":"xxx","qq_account":727299708,"userImgLink":"xxx","reason":"xxx","use_time":"xxx","start_time":888888,"over_time":888888888},
     *          {"id":"xxx","coin_id":"xxx","to_user_id":"xxx","to_user_name":"xxx","qq_account":727299708,"userImgLink":"xxx","reason":"xxx","use_time":"xxx","start_time":888888,"over_time":888888888}
     *       ]
     *    },
     * }
     *
     * @apiErrorExample Error-Response: 请求失败
     * HTTP/1.1 200
     * {
     *  "code": 1,
     *  "msg": "failed",
     *  "result": {
     *
     *    },
     * }
     *
     */
    public function getUsedCoinList(Request $request){
        $pageSize   = $request->input('pageSize', 5);
        $userId = get_session_user_id();
        if($userId){
            $coins = StarCoin::getUsedCoinList($userId,$pageSize);
            if($coins){
                foreach ($coins as $key => $value){
                    $coins[$key]->userImgLink = getQqimgLink($value->qq_account);
                }
                return responseToJson(0,'success',$coins);
            }else{
                return responseToJson(1,'failed');
            }
        }
    }

    /**
     * @api {get} user/thumbsUp/getOverdueCoinList 得到已过期的点赞币
     * @apiName getOverdueCoinList
     * @apiGroup User
     *
     * @apiParam {Number} pageSize 分页 一次加载多少
     * @apiParam {Number} page 分页 第几页
     *
     * @apiSuccess {Number} code 状态码：0 请求成功，其他数值 请求失败
     * @apiSuccess {String} msg 响应信息
     * @apiSuccess {String} result 响应结果
     * @apiSuccess {Object[]} overdueCoinList 未使用（空白的，未点出的）的已过期的点赞币数组
     * @apiSuccess {String} id 点赞币id
     * @apiSuccess {String} coin_id 币种id
     * @apiSuccess {String} coin_name 币种name
     * @apiSuccess {String} start_time 点赞币开始生效时间（时间戳）
     * @apiSuccess {String} over_time 点赞币结束生效时间（时间戳）
     * @apiSuccessExample Success-Response：请求成功
     * HTTP/1.1 200 OK
     * {
     *  "code": 0,
     *  "msg": "success",
     *  "result": {
     *       overdueCoinList:[
     *          {"id":"xxx","coin_id":"xxx","coin_name":"xxx","start_time":"xxx","over_time":"xxx"},
     *          {"id":"xxx","coin_id":"xxx","coin_name":"xxx","start_time":"xxx","over_time":"xxx"}
     *       ]
     *    },
     * }
     *
     * @apiErrorExample Error-Response: 请求失败
     * HTTP/1.1 200
     * {
     *  "code": 1,
     *  "msg": "failed",
     *  "result": {
     *
     *    },
     * }
     *
     */
    public function getOverdueCoinList(Request $request){
        $pageSize   = $request->input('pageSize', 5);
        $userId = get_session_user_id();
        if($userId){
            $coins = StarCoin::getOverdueCoinList($userId,$pageSize);
            if($coins){
                return responseToJson(0,'success',$coins);
            }else{
                return responseToJson(1,'failed');
            }
        }
    }

    /**
     * @api {post} user/thumbsUp 点赞
     * @apiName thumbsUp
     * @apiGroup User
     *
     * @apiParam {String} ids 点赞币id 使用“,”给分开 例如：{1,2,3}
     * @apiParam {String} toUserId 点给某人<某人的id>
     * @apiParam {String} reason 点赞原因
     *
     * @apiSuccess {Number} code 状态码：0 点赞成功，其他数值 点赞失败
     * @apiSuccess {String} msg 响应信息
     * @apiSuccess {String} result 响应结果
     * @apiSuccessExample Success-Response：点赞成功
     * HTTP/1.1 200 OK
     * {
     *  "code": 0,
     *  "msg": "success",
     *  "result": {
     *
     *    },
     * }
     *
     * @apiErrorExample Error-Response: 点赞失败
     * HTTP/1.1 200
     * {
     *  "code": 1,
     *  "msg": "failed",
     *  "result": {
     *
     *    },
     * }
     *
     */
    public function thumbsUp(Request $request){
        $ids = explode(",", $request->ids);
        $toUserId = $request->toUserId;
        $reason = $request->reason;

        $userId = get_session_user_id();
        if($userId){
            $result = StarCoin::thumbsUp($userId,$ids,$toUserId,$reason);
            if($result)
                return responseToJson(0,'success');
            return responseToJson(0,'failed');
        }
    }

    /**
     * @api {post} user/thumbsUp/getUserListExceptSelf 得到除自己外的用户列表
     * @apiName getUserListExceptSelf
     * @apiGroup User
     *
     * @apiSuccess {Number} code 状态码：0 请求成功，其他数值 请求失败
     * @apiSuccess {String} msg 响应信息
     * @apiSuccess {String} result 响应结果
     * @apiSuccess {Object[]} userList 用户列表数组
     * @apiSuccess {String} id 用户id
     * @apiSuccess {String} name 用户name
     * @apiSuccessExample Success-Response：请求成功
     * HTTP/1.1 200 OK
     * {
     *  "code": 0,
     *  "msg": "success",
     *  "result": {
     *       userList:[
     *          {"id":"xxx","name":"xxx"},
     *          {"id":"xxx","name":"xxx"}
     *       ]
     *    },
     * }
     *
     * @apiErrorExample Error-Response: 请求失败
     * HTTP/1.1 200
     * {
     *  "code": 1,
     *  "msg": "failed",
     *  "result": {
     *
     *    },
     * }
     *
     */
    public function getUserListExceptSelf(){
        $userId = get_session_user_id();
        if($userId){
            $users = User::getUserListExceptSelf($userId);
            if($users){
                return responseToJson(0,'success',$users);
            }else{
                return responseToJson(1,'failed');
            }
        }
    }
}