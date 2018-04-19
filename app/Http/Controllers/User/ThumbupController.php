<?php
/**
 * Created by VS Code.
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
     * @api {get} /getThumbupList/:id 显示用户的点赞记录
     * @apiName getThumbupList
     * @apiGroup User
     *
     * @apiParam {Number} id 用户ID
     * @apiSuccessExample 返回个人点赞记录
     * HTTP/1.1 200 OK
     * {
     * "code": 200,
     * "msg": "success",
     * "result": {
     *
     *           },
     * }
     *
     *
     */
    public function getThumbupList(Request $request){
        
    }
}
