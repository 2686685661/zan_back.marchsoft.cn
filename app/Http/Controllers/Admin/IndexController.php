<?php
/**
 * Created by PhpStorm.
 * User: WeiYalin
 * Date: 2018/4/20
 * Time: 12:27
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class IndexController extends Controller
{
   
    public function giveCoin(Request $request){
        $ids = json_decode($request->ids,true);
        $len = DB::table('user')->whereIn('id',$ids)->where('is_delete',0)->count();
        if($len!=count($ids)) return responseToJson(2,'error','有外星人');
        $num = json_decode($request->num,true);
        if(!is_numeric($num)) return responseToJson(1,'error','数量应为数字');
        $data = [];
        for($i=0;$i<count($ids);$i++){
            for($j=0;$j<$num;$j++){
                $data[] = [
                    'from_user_id'=>$ids[$i],
                    'to_user_id'=>0,
                    'coin_id'=>$request->coin_id,
                    'start_time'=>time(),
                    'over_time'=>time()+3600*24*7,
                    'use_time'=>0,
                    'reason'=>'',
                    'is_buy'=>0,
                ];
            }
        }
        $res = DB::table('star_coin')->insert($data);
        // var_dump($data,json_decode($request->ids,true));
        if($res) return responseToJson(0,'success','发币成功');
        return responseToJson(3,'error','发币失败');

    }
}