<?php
/**
 * Created by PhpStorm.
 * User: Neptune
 * Date: 2018/4/16
 * Time: 16:50
 */
namespace App\Http\Controllers\User;

use App\Models\CoinStatus;
use App\Models\StarCoin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecordController extends Controller
{
    private $userID = 1;
    /**
     * @api {get} user/record/thumbup?page&isthumbup 显示用户点赞详细记录
     * @apiName thumbup
     * @apiGroup User
     *
     * @apiParam {Number=1,2,3} page 页码(1，2，3)
     * @apiParam {Number=1,2} isthumbup 点赞与被点赞(1，2)
     * @apiSuccess {Object[]} thumbupArr  点赞数组
     * @apiSuccessExample Success-Response: 返回个人被点赞记录
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "success",
     * "data": {
     *     thumbupArr:[
     *          {"name":"xxx","img_url":"xxxxxxxx","reason":"xxxxxxxxxxxx","start_time":888888,"over_time":888888888,"use_time":88888888},
     *          {"name":"xxx","img_url":"xxxxxxxx","reason":"xxxxxxxxxxxx","start_time":888888,"over_time":888888888,"use_time":88888888},
     *          {"name":"xxx","img_url":"xxxxxxxx","reason":"xxxxxxxxxxxx","start_time":888888,"over_time":888888888,"use_time":88888888},
     *          {"name":"xxx","img_url":"xxxxxxxx","reason":"xxxxxxxxxxxx","start_time":888888,"over_time":888888888,"use_time":88888888},
     *          {"name":"xxx","img_url":"xxxxxxxx","reason":"xxxxxxxxxxxx","start_time":888888,"over_time":888888888,"use_time":88888888},
     *                 ],
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
    public function getThumbupList(Request $request){
        if ($request->isMethod("get")) {
            $page = $request->page;
            $isTumbUp = $request->isthumbup;
            if(preg_match("/^\d*$/",$page)&&preg_match("/^[1-2]*$/",$isTumbUp)){
                $result = json_decode(json_encode(StarCoin::getThumupedCoin($this->userID,$isTumbUp,10)))->data;
                foreach ($result as $item){
                    $item->qq_account = getQqimgLink($item->qq_account);
                }
                return $result!=null?responseToJson(0,'success',$result):responseToJson(1,"no query result");
            }
            return responseToJson(1,"request parameter error");
        }
        return responseToJson(1,"request error");
    }

    /**
     * @api {get} user/record/countnum 显示用户点赞统计记录
     * @apiName countnum
     * @apiGroup User
     *
     * @apiSuccess {Number} countTotal  总计获得点赞币数
     * @apiSuccess {Number} totalWeek  本周获得点赞币数
     * @apiSuccess {Number} rankWeek  本周排名
     * @apiSuccessExample Success-Response: 返回个人被点赞记录统计
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "success",
     * "data": {
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

    public function getCountNumber(Request $request){
        if ($request->isMethod('get')){
            $weekDate = week();
            $countTotal = CoinStatus::getThumupTotal($this->userID);
            $weekTotal = StarCoin::getThumupRank(0,$weekDate[0],$weekDate[1])->toArray();
            if ($countTotal!=null&&$weekTotal!=null){
                $listArr = $this->getGroupCount($weekTotal);
                $perArr = [];
                foreach ($listArr as $value){
                    if ($value['id'] == $this->userID) $perArr = $value;
                }
                return responseToJson(0,"success", [
                    'countTotal'=>$countTotal[0]->receive_count,
                    'totalWeek'=>$perArr['week'],
                    'rankWeek'=>$perArr['rank']
                ]);
            }
            return responseToJson(1,"request parameter error");
        }
        return responseToJson(1,"request error");
    }


    /**
     * @api {get} user/record/countList?countGrade&startDate&endDate 显示点赞币统计记录
     * @apiName countList
     * @apiGroup User
     *
     * @apiParam {Number=0,1,2,3} countGrade 年级(0 => 全部，1 => 大一，2 => 大二， 3 => 大三)默认为 0
     * @apiParam {String} startDate 开始日期 yy-mm-dd
     * @apiParam {String} endDate 结束日期 yy-mm-dd
     *
     * @apiSuccess {Object[]} IndRank 个人信息数组
     * @apiSuccess {Object[]} countArr 点赞排名数组
     * @apiSuccessExample Success-Response：返回点赞币统计记录
     * HTTP/1.1 200 OK
     * {
     * "code": 0,
     * "msg": "success",
     * "data": {
     *      IndRank:[
     *          {"name":"xxx","img_url":"xxxxxxxx","receive_count":21,"week_count":8},
     *       ],
     *      countArr:[
     *          {"name":"xxx","img_url":"xxxxxxxx","receive_count":28,"week_count":7},
     *          {"name":"xxx","img_url":"xxxxxxxx","receive_count":25,"week_count":2},
     *          {"name":"xxx","img_url":"xxxxxxxx","receive_count":20,"week_count":5},
     *          {"name":"xxx","img_url":"xxxxxxxx","receive_count":18,"week_count":1},
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
    public function getThumbupCount(Request $request)
    {
        if ($request->isMethod("get"))
        {
            $countGrade = $request->countGrade;
            $startDate = $request->startDate;
            $endDate = $request->endDate;
            $result = StarCoin::getThumupRank(0,week()[0],week()[1]);
            return responseToJson(1,'success',$result);

        }
        return responseToJson(1,"request error");
    }
    /**
     * 分组排名
     */
    private function getGroupCount($array){
        $week = week();
        usort($array,'funcCompare');
        $listArr = [];
        $sum = 0;
        foreach ($array as $i=>$item){
            foreach ($item as $obj){
                if ($obj->use_time>=$week[0]&&$obj->use_time<=$week[1]) $sum ++;
            }
            $listArr[] = ['id'=>$item[0]->id,'name'=>$item[0]->name,'img_url'=>getQqimgLink($item[0]->qq_account),'total'=>count($item),'week'=>$sum,'rank'=>($i+1)];
            $sum = 0;
        }
        return $listArr;
    }
}
