<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/4/20
 * Time: 12:28
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Cookie;

class LoginController extends Controller
{
    /**
     * @api {post} user/login 普通用户登录（老师学生）
     * @apiName login
     * @apiGroup User
     *
     * @apiParam {String} username 账号
     * @apiParam {String} password 密码
     *
     * @apiSuccess {Number} code 状态码：0 登录成功，其他数值 登录失败
     * @apiSuccess {String} msg 响应信息
     * @apiSuccessExample Success-Response：登录成功
     * HTTP/1.1 200 OK
     * {
     *  "code": 0,
     *  "msg": "success",
     *  "result": {
     *
     *    },
     * }
     *
     * @apiErrorExample Error-Response: 登录失败
     * HTTP/1.1 200
     * {
     *  "code": 1,
     *  "msg": "账号或密码错误",
     *  "result": {
     *
     *    },
     * }
     *
     */
    public function login(Request $request,$isManager = 0){
        $name = $request->username;
        $password = $request->password;
        if($isManager !== 3)
            $user = DB::table('user')->where('code',$name)->first();
        else
            $user = DB::table('user')->where('code',$name)->where('type',$isManager)->first();
        if ($user) {
            if (md5(md5($password)) == $user->password) {
                $this->login_success($request,$user);
                return responseToJson(0,'登录成功',$user);
            }else{
                return responseToJson(1,'用户名或密码错误,请重新输入');
            }
        }else{
            return responseToJson(1,'账号或密码错误');
        }
    }

    /**
     * @api {post} user/adminLogin 管理员登录
     * @apiName adminLogin
     * @apiGroup User
     *
     * @apiParam {String} username 账号
     * @apiParam {String} password 密码
     *
     * @apiSuccess {Number} code 状态码：0 登录成功，其他数值 登录失败
     * @apiSuccess {String} msg 响应信息
     * @apiSuccess {String} result 响应结果
     * @apiSuccessExample Success-Response：登录成功
     * HTTP/1.1 200 OK
     * {
     *  "code": 0,
     *  "msg": "success",
     *  "result": {
     *
     *    },
     * }
     *
     * @apiErrorExample Error-Response: 登录失败
     * HTTP/1.1 200
     * {
     *  "code": 1,
     *  "msg": "账号或密码错误",
     *  "result": {
     *
     *    },
     * }
     *
     */
    public function adminLogin(Request $request){
        $this->login($request,2);
    }

    function login_success($request, $user){
        $session = $request->session();
        $session->put('user', $user);
        Cookie::queue('user',$user,time()+60*60*60*24);
        // var_dump(Cookie::get('user'));
        // setcookie('user',$user,time()+60*60*60*24);
    }

    function login_out(Request $request){
        $session = $request->session();
        $session->forget('user');
        return responseToJson(0,'退出成功');
    }

    /* 得到用户信息 */
    function getInfo(){
        $result = DB::table('user')->where('id',session('user')->id)->where('is_delete',0)->first();
        return responseToJson(0,'success',$result);
    }
}