<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/4/20
 * Time: 12:28
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Controller;
use App\Http\Controllers\User\Msg\MsgController;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Log;
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

    /**
     * @api {post} user/getCode 获得验证码
     * @apiName getCode
     * @apiGroup User
     *
     * @apiParam {String} userName 账号
     * @apiParam {String} phone 预留的手机号码
     *
     * @apiSuccess {Number} code 状态码：0 成功，其他数值 失败
     * @apiSuccess {String} msg 响应信息
     * @apiSuccessExample Success-Response：获得验证码成功
     * HTTP/1.1 200 OK
     * {
     *  "code": 0,
     *  "msg": "success"
     * }
     *
     * @apiErrorExample Error-Response: 获得验证码失败
     * HTTP/1.1 200
     * {
     *  "code": 1,
     *  "msg": "该账号预留电话号码不符"
     * }
     *
     */
    function getCode(Request $request){
        $name  = trim($request->userName);
        $phone = trim($request->phone);
        $count = DB::table('user')->where('code',$name)->where('phone',$phone)->count();

        if($count){
            $code = strRand(6,'0123456789');
            session(['code' => $code]);
            $res = MsgController::sendSms($phone,$code);
            Log::info(json_encode($res));
            return responseToJson(0,'success');
        }else{
            return responseToJson(1,'该账号预留电话号码不符');
        }
    }


    /**
     * @api {post} user/resetPassword 登录界面重置密码
     * @apiName resetPassword
     * @apiGroup User
     *
     * @apiParam {String} userName 账号
     * @apiParam {String} password 密码
     *
     * @apiSuccess {Number} code 状态码：0 成功，其他数值 失败
     * @apiSuccess {String} msg 响应信息
     * @apiSuccessExample Success-Response：重置密码成功
     * HTTP/1.1 200 OK
     * {
     *  "code": 0,
     *  "msg": "success"
     * }
     *
     * @apiErrorExample Error-Response: 重置密码失败
     * HTTP/1.1 200
     * {
     *  "code": 1,
     *  "msg": "更新失败"
     * }
     *
     */
    function resetPassword(Request $request){
        $name           = trim($request->userName);
        $password       = trim($request->password);

        if(User::resetPassword($name,$password)){
            return responseToJson(0,'success');
        }else{
            return responseToJson(1,'更新失败');
        }
    }

    /**
     * @api {post} user/checkCode 检测验证码是否正确
     * @apiName checkCode
     * @apiGroup User
     *
     * @apiParam {String} code 验证码
     *
     * @apiSuccess {Number} code 状态码：0 成功，其他数值 失败
     * @apiSuccess {String} msg 响应信息
     * @apiSuccessExample Success-Response：成功
     * HTTP/1.1 200 OK
     * {
     *  "code": 0,
     *  "msg": "success"
     * }
     *
     * @apiErrorExample Error-Response: 失败
     * HTTP/1.1 200
     * {
     *  "code": 1,
     *  "msg": "验证码错误"
     * }
     *
     */
    function checkCode(Request $request){
        $code = trim($request->code);
        if($code != session('code')){
            return responseToJson(1,'验证码错误');
        }else{
            return responseToJson(0,'success');
        }
    }
}