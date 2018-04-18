<?php
/**
 * Created by PhpStorm.
 * User: Neptune
 * Date: 2018/4/16
 * Time: 16:50
 */
namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ThumbupController extends Controller
{
    /**
     * @api {get} user/thumbuped/:userID 显示用户本周被点赞记录
     * @apiName thumbup
     * @apiGroup User
     *
     * @apiParam {Number} userID 用户ID
     * @apiSuccessExample 返回个人被点赞记录
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "success",
     * "result": {
     *     thumbupedArr:[
     *                 ],
     *     totalWeek:2,
     *     rankWeek:20,
     *           },
     * }
     *
     *
     */
    public function getThumbupedList($userID){
        
    }

    /**
     * @api {get} user/thumbup/:userID 显示用户本周点赞记录
     * @apiName getThumbupList
     * @apiGroup User
     *
     * @apiParam {Number} userID 用户ID
     * @apiSuccessExample 返回个人点赞记录
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "success",
     * "result": {
     *      thumbupArr:[
     *                 ],
     *           },
     * }
     *
     *
     */
    public function getThumbupList($userID){
        
    }

    public function getThumbupCount(){

    }
}
