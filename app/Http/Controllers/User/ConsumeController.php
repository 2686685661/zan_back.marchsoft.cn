<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\StarCoin;
use App\Models\order;

class ConsumeController extends Controller
{
    
        /**
     * @api {get} /user/seeCon 获得点赞币消费记录
     * @apiName getUserConsumeCoin
     * @apiGroup User
     *
     * @apiParam {Number} userid 查看人的id.
     * @apiParam {Number} type 点赞币使用记录种类
     *
     * @apiSuccess {String} name 点赞人的姓名
     * @apiSuccess {String} qq_account  点赞人的qq号.
     * @apiSuccess {String} img_url  赞点人的头像网址.
     * @apiSuccess {String} reason  点赞原因.
     * @apiSuccess {Int} over_time  点赞币过期时间.
     * @apiSuccess {Int} coin_id  点赞币种类.
     * @apiSuccessExample Success-Response:
     *     
     *    HTTP/1.1 200 OK
     *    $type == 0 || 1:
     *     {
     *       "code": "0",
     *       "msg": "success",
     *       "data":{
     *                  [
     *                       {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test',over_time:'1234567896',coin_id:1},
     *                       {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test',over_time:'1234567896',coin_id:1}       
     *                  ],
     *                  [
     *                       {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test',over_time:'1234567896',coin_id:2},
     *                       {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test',over_time:'1234567896',coin_id:2}
     *                  ],
     *                  [
     *                       {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test',over_time:'1234567896',coin_id:3},
     *                       {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test',over_time:'1234567896',coin_id:3}
     *                  ]
     *              }
     *     }
     *    $type == 3:
     *     {
     *       "code": "0",
     *       "msg": "success",
     *       "data":{
     *                  {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test'}    
     *              }
     *     }
     *     
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
    public function getUserConsumeCoin(Request $request) {
        if($request->isMethod('get')) {
            $user_id = $request->userid;
            $type = $request->type;
            if(is_numeric($user_id) && is_numeric($type)) {
                $select_coins = StarCoin::getNotUserConsumeCoin($user_id,$type);
                if($type != 3) {
                    for($i = 0; $i < count($select_coins); $i++) {
                        for($j = 0; $j < count($select_coins[$i]); $j++) {
                            $select_coins[$i][$j]->img_url = getQqimgLink($select_coins[$i][$j]->qq_account);
                        }
                    }
                }else {
                    for($i = 0; $i < count($select_coins); $i++) {
                        $select_coins[$i]->img_url = getQqimgLink($select_coins[$i]->qq_account);
                    }
                }

                return responseToJson(0,'success',$select_coins);
            }
        }

        return responseToJson(1,'error in server');
    }



        /**
     * @api {post} /user/insertCoinOrder 使用点赞币消费
     * @apiName insertUserConsume
     * @apiGroup User
     *
     * @apiParam {Number} coin_useful 点赞币用途id.
     * @apiParam {Array} coin_id_arr 点赞币id.
     * @apiParam {Number} use_id 使用人id.
     * @apiParam {String} content 点赞币用途.
     * @apiParam {NUmber} group_id 组别id.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "code": "0",
     *       "msg": "使用成功",
     *       "data":{
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
    public function insertUserConsume(Request $request) {
        
    }

    //当订单成功时修改str_coin表的回调函数
    private function updateUserCoinUseState() {

    }
}
