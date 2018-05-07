<?php
/**
 * Created by Visual Studio Code.
 * User: shanlei
 * Date: 2018/4/6
 * Time: 15:28
 */


namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\StarCoin;
use App\Models\order;

use DB;

class ConsumeController extends Controller
{
    
        /**
     * @api {get} /user/seeCon 获得点赞币消费记录
     * @apiName getUserConsumeCoin
     * @apiGroup User
     *
     * @apiParam {Number} type 点赞币使用记录种类
     *    $type == 0 未使用
     *    $type == 1 已使用
     *    $type == 2 已过期
     * @apiSuccess {String} name 点赞人的姓名
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
     *       "data":[
     *                  0=>[
     *                       {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test',over_time:'1234567896',coin_id:1},
     *                       {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test',over_time:'1234567896',coin_id:1}       
     *                  ],
     *                  1=>[
     *                       {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test',over_time:'1234567896',coin_id:2},
     *                       {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test',over_time:'1234567896',coin_id:2}
     *                  ],
     *                  2=>[
     *                       {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test',over_time:'1234567896',coin_id:3},
     *                       {name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test',over_time:'1234567896',coin_id:3}
     *                  ]
     *              ]
     *     }
     *    $type == 2:
     *     {
     *       "code": "0",
     *       "msg": "success",
     *       "data":[
     *                  0=>{name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test'}
     *                  1=>{name:'test',qq_account:'261231',img_url:'www.baidu.com',reason:'test'}        
     *              ]
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
        if(!$request->isMethod('get')) 
            return responseToJson(1,'error in server');

        if(!is_numeric($request->type))
            return responseToJson(1,'error in server');
        

        // $valArr = array(
        //     'userId' => $request->userid,
        //     'useType' => $request->type,
        //     'createTime' =>time()
        // );

        $valArr = array(
            'userId' => get_session_user_id(),
            'useType' => $request->type,
            'createTime' => time()
        );
        // var_dump($valArr);
        $select_coins = StarCoin::getNotUserConsumeCoin($valArr);
// var_dump($select_coins);
        // if(!$select_coins) return responseToJson(1,'error in server');

        // $select_coins = ($request->type != 2) ? $this->coinArrayGroup($select_coins) : $select_coins;

        // $select_coins = $this->setUserCoinImgUrl($select_coins, $request->type);


        // dd($select_coins);
        return responseToJson(0,'success',$select_coins);
        
    }




        /**
     * @api {post} /user/insertCoinOrder 使用点赞币消费
     * @apiName insertUserConsume
     * @apiGroup User
     *
     * @apiParam {Number} coin_useful 点赞币用途id.
     * @apiParam {Array} coin_id_arr 点赞币id.
     * @apiParam {String} content 点赞币用途.
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
        // $coinUsefulId = is_numeric($request->coin_useful)?$request->coin_useful:'';
        // $coinIdArr = is_array($request->coin_id_arr)?$request->coin_id_arr:[];
        // // $coinIdArr = [5,6,7,8];
        // // $groupId = is_numeric($request->group_id)?$request->group_id:'';
        // $content = is_string($request->content)?trim($request->content):'';

        // $formUserId = get_session_user_id();
        // $arr = array(
        //     'userId' => $formUserId,
        //     'userfulId' => $coinUsefulId,
        //     'groupId' => $groupId,
        //     'coinIdStr' => strChangeArr($coinIdArr,','),
        //     'content' => $content,
        //     'createTime' => time()
        // );


        // $createId = order::createOrder($arr);
        // $createBoo = ($createId ? $this->updateUserCoinUseState($formUserId,$coinIdArr) : false);
        DB::beginTransaction();
        try{
            $ids = json_decode($request->ids,true);
            $count = DB::table('star_coin')->whereIn('id',$ids)->where('over_time','>=',time())
                    ->where(['buy_time'=>0,'to_user_id'=>get_session_user_id()])->count();
            if($count!=count($ids)) return responseToJson(2,'请选择合适的币');
            $str = '';
            for($i=0;$i<count($ids);$i++){
                $str .= $ids[$i]+',';
            }
            $content = $request->content;
            $res = DB::table('order')->insert([
                'user_id'=>get_session_user_id(),
                'star_coin_id'=>$str,
                'content'=>$content,
                'created_time'=>time()
            ]);
            DB::table('star_coin')->whereIn('id',$ids)->update(['buy_time'=>time()]);
            DB::commit();
            return responseToJson(0,'下单成功');
        } catch (\Exception $e){
            DB::rollBack();
        }
        return responseToJson(1,'下单失败');
        
    }

    /**
     * 当订单成功时修改str_coin表的回调函数
     * 用于修改str_coin表中的is_buy字段
     * @formUserId Number
     * @coinIdArr Array
     * return Array
     */
    private function updateUserCoinUseState($formUserId, $coinIdArr) {
        // dd($coinIdArr);
        return StarCoin::updateUseCoinState($formUserId,$coinIdArr);
        
    }

    /**
     * 对数组中集合进行分组的函数
     * @arr Array
     * return Array
     */
    private function coinArrayGroup($arr) {

        if(empty($arr) && !is_array($arr)) $arr = $arr->toArray();
        $result = array();
        foreach($arr as $key => $value)
            $result[$value->coin_id][] = $value;
            
        $ret = array();
        foreach ($result as $key => $value)
            array_push($ret, $value);

        return $ret;
    }

    /**
     * 设置点赞币记录的用户头像url
     * @arr  Array
     * @useType NUmber
     * return Array
     */
    private function setUserCoinImgUrl($arr,$useType) {
        if($useType == 2)
            for($i = 0; $i < count($arr); $i++) {
                $arr[$i]->img_url = getQqimgLink($arr[$i]->qq_account);
                unset($arr[$i]->qq_account);
            }
        else
            for($i = 0; $i < count($arr); $i++)
                for($j = 0; $j < count($arr[$i]); $j++) {
                    $arr[$i][$j]->img_url = getQqimgLink($arr[$i][$j]->qq_account);
                    unset($arr[$i][$j]->qq_account);
                }
        
        return $arr;
    }

}

