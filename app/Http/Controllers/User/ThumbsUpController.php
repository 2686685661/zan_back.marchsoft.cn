<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/4/20
 * Time: 12:27
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;

class ThumbsUpController extends Controller
{
    /**
     * @api {post} user/getCoinList 得到自己未使用（空白的，未点出的）的点赞币
     * @apiName getCoinList
     * @apiGroup User
     *
     * @apiParam {String} userId 用户id
     *
     * @apiSuccess {Number} code 状态码：0 请求成功，其他数值 请求失败
     * @apiSuccess {String} msg 响应信息
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
     *  "data": {
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
     *  "data": {
     *
     *    },
     * }
     *
     */
    public function getCoinList(){

    }

    /**
     * @api {post} user/getUsedCoinList 得到自己未使用（空白的，未点出的）的点赞币
     * @apiName getUsedCoinList
     * @apiGroup User
     *
     * @apiParam {String} userId 用户id
     *
     * @apiSuccess {Number} code 状态码：0 请求成功，其他数值 请求失败
     * @apiSuccess {String} msg 响应信息
     * @apiSuccess {Object[]} usedCoinList 已使用（已点出的）的点赞币数组
     * @apiSuccess {String} id 点赞币id
     * @apiSuccess {String} coin_id 币种id
     * @apiSuccess {String} to_user_id 点给某人<某人的id>
     * @apiSuccess {String} to_user_name 点给某人<某人的name>
     * @apiSuccess {String} reason 点赞原因
     * @apiSuccess {String} use_time 点赞时间（时间戳）
     * @apiSuccessExample Success-Response：请求成功
     * HTTP/1.1 200 OK
     * {
     *  "code": 0,
     *  "msg": "success",
     *  "data": {
     *       usedCoinList:[
     *          {"id":"xxx","coin_id":"xxx","to_user_id":"xxx","to_user_name":"xxx","reason":"xxx","use_time":"xxx"},
     *          {"id":"xxx","coin_id":"xxx","to_user_id":"xxx","to_user_name":"xxx","reason":"xxx","use_time":"xxx"}
     *       ]
     *    },
     * }
     *
     * @apiErrorExample Error-Response: 请求失败
     * HTTP/1.1 200
     * {
     *  "code": 1,
     *  "msg": "failed",
     *  "data": {
     *
     *    },
     * }
     *
     */
    public function getUsedCoinList(){

    }

    /**
     * @api {post} user/getOverdueCoinList 得到自己未使用（空白的，未点出的）的已过期的点赞币数组
     * @apiName getOverdueCoinList
     * @apiGroup User
     *
     * @apiParam {String} userId 用户id
     *
     * @apiSuccess {Number} code 状态码：0 请求成功，其他数值 请求失败
     * @apiSuccess {String} msg 响应信息
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
     *  "data": {
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
     *  "data": {
     *
     *    },
     * }
     *
     */
    public function getOverdueCoinList(){

    }

    /**
     * @api {post} user/thumbsUp 登录
     * @apiName thumbsUp
     * @apiGroup User
     *
     * @apiParam {Number} id[] 点赞币id数组
     * @apiParam {String} toUserId 点给某人<某人的id>
     * @apiParam {String} reason 点赞原因
     *
     * @apiSuccess {Number} code 状态码：0 点赞成功，其他数值 点赞失败
     * @apiSuccess {String} msg 响应信息
     * @apiSuccessExample Success-Response：点赞成功
     * HTTP/1.1 200 OK
     * {
     *  "code": 0,
     *  "msg": "success",
     *  "data": {
     *
     *    },
     * }
     *
     * @apiErrorExample Error-Response: 点赞失败
     * HTTP/1.1 200
     * {
     *  "code": 1,
     *  "msg": "failed",
     *  "data": {
     *
     *    },
     * }
     *
     */
    public function thumbsUp(){

    }

    /**
     * @api {post} user/getUserList 得到用户列表
     * @apiName getUserList
     * @apiGroup User
     *
     * @apiSuccess {Number} code 状态码：0 请求成功，其他数值 请求失败
     * @apiSuccess {String} msg 响应信息
     * @apiSuccess {Object[]} userList 用户列表数组
     * @apiSuccess {String} id 用户id
     * @apiSuccess {String} name 用户name
     * @apiSuccessExample Success-Response：请求成功
     * HTTP/1.1 200 OK
     * {
     *  "code": 0,
     *  "msg": "success",
     *  "data": {
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
     *  "data": {
     *
     *    },
     * }
     *
     */
    public function getUserList(){

    }
}