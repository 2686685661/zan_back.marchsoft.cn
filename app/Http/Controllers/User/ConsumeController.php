<?php
/**
 * Created by Visual Studio Code.
 * User: shanlei
 * Date: 2018/4/6
 * Time: 15:28
 */


namespace App\Http\Controllers\User;

use App\Models\Apply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\StarCoin;
use App\Models\order;

use DB;
use Maatwebsite\Excel\Facades\Excel;

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
            for($i=0;$i<count($ids)-1;$i++){
                $str .= $ids[$i].',';
            }
            $str .= $ids[count($ids)-1];
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

    /**
     * @api {get} user/consume/export?type&startime&endtime 导出记录表
     * @apiName export
     * @apiGroup User
     *
     * @apiParam {Number=0，1} type 类型(消费记录，审批记录)
     * @apiParam {String} startime 起始时间( yy-mm-dd)
     * @apiParam {String} endtime 结束时间( yy-mm-dd)
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 200
     *     {
     *       "code": "1",
     *        "msg": '时间段不合理'
     *     }
     *
     */
    public function exportRecord(Request $request){
        if (!$request->isMethod("get"))
            return responseToJson(1,"request error");
        $type = $request->type?$request->type:0;
        $startime = $request->startime?strtotime($request->startime):null;
        $endtime = $request->endtime?strtotime($request->endtime):null;
        if($startime > $endtime)
            return responseToJson(1,'时间段不合理');
        if($type==0){
            $datas = order::dealOrderlist($startime,$endtime)->toArray();
            $this->export(['用户账号','姓名','QQ','内容','数量','时间','拒接原因'],
                $datas,['code', 'name', 'qq_account', 'content', 'star_coin_id','created_time', 'resaon'],
                'OrderRecordTable','消费点赞币总数',function($item){
                    return count(explode(',',$item));
                },'star_coin_id');
        }elseif ($type==1){
            $datas = Apply::dealExapvlist($startime,$endtime)->toArray();
            $this->export(['申请人账号','申请人姓名','原因','数量','时间','点赞币类型'],
                $datas,['code', 'apply_user_name', 'content', 'data', 'created_time','name'],
                'ExaminationRecordTable','审批点赞币总数',function($item){
                    $count = 0;
                    foreach (json_decode($item) as $arrs){
                        $arr = (array)$arrs;
                        $count+=end($arr);
                    }
                    return $count;
                },'data');
        }

    }

    /**
     * 导出方法
     * @param $header表格头部
     * @param $data表格数字
     * @param $relation关联字段
     * @param $filename文件名
     * @param $countname统计字段
     * @param $fun处理方法
     * @param $delvalue处理属性
     */
    private function export($header,$data,$relation,$filename,$countname,$fun,$delvalue){
        $cellData = [];
        $cellData[] = $header;
        $count = 0;
        foreach ($data as $cell) {
            $arr = [];
            $cell->$delvalue = call_user_func($fun,$cell->$delvalue);
            $count += $cell->$delvalue;
            $cell->created_time = date('Y-m-d', $cell->created_time);
            foreach($relation as $item){
                $arr[] = $cell->$item;
            }
            $cellData[] = $arr;
        }
        $cellData[] = [$countname,$count];
        Excel::create($filename,function($excel) use ($cellData){
            $excel->sheet('Sheet0',function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xlsx');
    }
}

