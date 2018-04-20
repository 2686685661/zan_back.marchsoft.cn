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

class RecordController extends Controller
{
    /**
     * @api {get} user/thumbup 显示用户本周点赞记录
     * @apiName thumbup
     * @apiGroup User
     *
     * @apiSuccess {Object[]} thumbupedArr 被点赞数组
     * @apiSuccess {Object[]} thumbupArr  点赞数组
     * @apiSuccess {Number} countTotal  总计获得点赞币数
     * @apiSuccess {Number} totalWeek  本周获得点赞币数
     * @apiSuccess {Number} rankWeek  本周排名
     * @apiSuccessExample Success-Response: 返回个人被点赞记录
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "success",
     * "data": {
     *     thumbupedArr:[
     *          {"name":"xxx","qq_account":"xxxxxxxx","reason":"xxxxxxxxxxxx","start_time":888888,"over_time":888888888,"use_time":88888888},
     *          {"name":"xxx","qq_account":"xxxxxxxx","reason":"xxxxxxxxxxxx","start_time":888888,"over_time":888888888,"use_time":88888888},
     *          {"name":"xxx","qq_account":"xxxxxxxx","reason":"xxxxxxxxxxxx","start_time":888888,"over_time":888888888,"use_time":88888888},
     *          {"name":"xxx","qq_account":"xxxxxxxx","reason":"xxxxxxxxxxxx","start_time":888888,"over_time":888888888,"use_time":88888888},
     *          {"name":"xxx","qq_account":"xxxxxxxx","reason":"xxxxxxxxxxxx","start_time":888888,"over_time":888888888,"use_time":88888888},
     *                 ],
     *     thumbupArr:[
     *          {"name":"xxx","qq_account":"xxxxxxxx","reason":"xxxxxxxxxxxx","start_time":888888,"over_time":888888888,"use_time":88888888},
     *          {"name":"xxx","qq_account":"xxxxxxxx","reason":"xxxxxxxxxxxx","start_time":888888,"over_time":888888888,"use_time":88888888},
     *          {"name":"xxx","qq_account":"xxxxxxxx","reason":"xxxxxxxxxxxx","start_time":888888,"over_time":888888888,"use_time":88888888},
     *          {"name":"xxx","qq_account":"xxxxxxxx","reason":"xxxxxxxxxxxx","start_time":888888,"over_time":888888888,"use_time":88888888},
     *          {"name":"xxx","qq_account":"xxxxxxxx","reason":"xxxxxxxxxxxx","start_time":888888,"over_time":888888888,"use_time":88888888},
     *                 ],
     *     countTotal: 28,
     *     totalWeek: 2,
     *     rankWeek: 20,
     *      },
     * }
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
     *
     */
    public function getThumbupList(Request $request)
    {
        if ($request->isMethod("get"))
        {

        }
        responseToJson(1,"request error");
    }

    /**
     * @api {get} user/countList 显示点赞币统计记录
     * @apiName countList
     * @apiGroup User
     *
     * @apiParam {Number=0,1,2,3} countGrade 年级(0 => 全部，1 => 大一，2 => 大二， 3 => 大三)默认为 0
     * @apiParam {String} startDate 开始日期 yy-mm-dd
     * @apiParam {String} endDate 结束日期 yy-mm-dd
     *
     * @apiSuccess {Object[]} countArr 点赞排名数组
     * @apiSuccessExample Success-Response：返回点赞记录表
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "success",
     * "data": {
     *      countArr:[
     *          {"name":"xxx","qq_account":"xxxxxxxx","receive_count":28,"week_count":7},
     *          {"name":"xxx","qq_account":"xxxxxxxx","receive_count":28,"week_count":7},
     *          {"name":"xxx","qq_account":"xxxxxxxx","receive_count":28,"week_count":7},
     *          {"name":"xxx","qq_account":"xxxxxxxx","receive_count":28,"week_count":7},
     *       ],
     *    },
     * }
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
     *
     */
    public function getThumbupCount(Request $request,$userID = null)
    {
        if ($request->isMethod("get"))
        {

        }
        responseToJson(1,"request error");
    }
}
