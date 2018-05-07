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
        $len = DB::table('user')->whereIn('id',$ids)->where('is_delete',0)->get();
        if(count($len)!=count($ids)) return responseToJson(2,'error','有外星人');
        $num = json_decode($request->num,true);
        if(!is_numeric($num)) return responseToJson(1,'error','数量应为数字');
        $data = [];
        for($i=0;$i<count($ids);$i++){
            for($j=0;$j<$num;$j++){
                foreach($len as $key => $val) {
                    if($val->id==$ids[$i]){
                        $data[] = [
                            'from_user_id'=>$ids[$i],
                            'from_user_name' => $val->name,
                            'to_user_name' => '',
                            'to_user_id'=>0,
                            'coin_id'=>$request->coin_id,
                            'start_time'=>time(),
                            'over_time'=>time()+3600*24*7,
                            'use_time'=>0,
                            'reason'=>'',
                            'is_buy'=>0,
                        ];
                        break;
                    }
                }
                
            }
        }
        $res = DB::table('star_coin')->insert($data);
        // var_dump($data,json_decode($request->ids,true));
        if($res) return responseToJson(0,'success','发币成功');
        return responseToJson(3,'error','发币失败');

    }
    //得到大一~大三的学生
    public function getUser(Request $request){
        $year = date('Y') - 3;
        $users = DB::table('user')
            ->where('grade','>=',$year)
            ->where('type',0)->orderBy('grade','desc')
            ->select('id', 'name', 'grade','name_quanpin','qq_account','name_jianpin','code','group_id')
            ->get()
            ->groupBy('grade');
        foreach($users as $key => $val){
            $res[] = $val;
        }
        return responseToJson(0,'success',$res);
    }
    
}