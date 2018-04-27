<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/4/20
 * Time: 12:28
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * @api {post} user/login 登录
     * @apiName login
     * @apiGroup User
     *
     * @apiParam {String} username 账号
     * @apiParam {String} password 密码
     * @apiParam {Number} isManager 是否是管理员：0 是，1 不是
     *
     * @apiSuccess {Number} code 状态码：0 登录成功，其他数值 登录失败
     * @apiSuccess {String} msg 响应信息
     * @apiSuccessExample Success-Response：登录成功
     * HTTP/1.1 200 OK
     * {
     *  "code": 0,
     *  "msg": "success",
     *  "data": {
     *
     *    },
     * }
     *
     * @apiErrorExample Error-Response: 登录失败
     * HTTP/1.1 200
     * {
     *  "code": 1,
     *  "msg": "账号或密码错误",
     *  "data": {
     *
     *    },
     * }
     *
     */
    public function login(){

    }
}