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
        if(count($len)!=count($ids)) return responseToJson(2,'有外星人','有外星人');
        $num = json_decode($request->num,true);
        if(!is_numeric($num)) return responseToJson(1,'数量应为数字','数量应为数字');
        if($num*count($ids)>200) return responseToJson(1,'数量不能超过200','数量不能超过200');
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
                            'over_time'=>$request->coin_id==1?(time()+3600*24*7):(time()+3600*24*100*365),
                            'use_time'=>0,
                            'reason'=>'',
                            'buy_time'=>0,
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
            ->where('type','!=',1)->orderBy('grade','desc')
            ->select('id', 'name', 'grade','name_quanpin','qq_account','name_jianpin','code','group_id')
            ->get()
            ->groupBy('grade');
        foreach($users as $key => $val){
            $res[] = $val;
        }
        return responseToJson(0,'success',$res);
    }

    //获取申请
    public function getApplyList(Request $request){
        $page = $request->page;
        $list =  DB::table('apply')->orderBy('updated_time')->orderBy('created_time','desc')->paginate(10);
        return responseToJson(0,'success',$list);
    }
    //申请审批
    public function updateApply(Request $request){
        DB::beginTransaction();
        try{
            $id = $request->id;
            $status = $request->status;
            $r =  DB::table('apply')->where('id',$id)->update(['status'=>$status]);
            if($r){
                if($status==1){
                    $d = DB::table('apply')->where('id',$id)->first();
                    $arr = json_decode($d->data,true);
                    $codes = [];
                    for($i=0;$i<count($arr);$i++){
                        $codes[] = $arr[$i]['code'];
                    }
                    $user = DB::table('user')->whereIn('code',$codes)->where('is_delete',0)->get();
                    $data = [];
                    for($i=0;$i<count($arr);$i++){
                        $name = '';
                        $id = 0;
                        foreach($user as $k=>$v){
                            if($v->code==$arr[$i]['code']){
                                $name = $v->name;
                                $id = $v->id;
                                break;
                            }
                        }
                        if($id!=0){
                            for($j=0;$j<intval($arr[$i]['num']);$j++){
                                $data[] = [
                                    'from_user_id'=>0,
                                    'from_user_name' =>'三月',
                                    'to_user_name' => $name,
                                    'to_user_id'=>$id,
                                    'coin_id'=>$d->coin_id,
                                    'start_time'=>time(),
                                    'over_time'=> $d->coin_id==1?(time()+3600*24*7):(time()+3600*24*100*365),
                                    'use_time'=>time(),
                                    'reason'=>$d->content,
                                    'buy_time'=>0,
                                ];
                                // break;
                            }
                        }
                        
                    }
                    $res = DB::table('star_coin')->insert($data);
                }
            }
            DB::commit();
            return responseToJson(0,'success','审批成功');
        } catch (\Exception $e){
            DB::rollback();
        }
        return responseToJson(1,'error','审批失败');
    }


    //获取订单列表
    public function getOrderList(Request $request){
        $page = $request->page;
        $list =  DB::table('order')->orderBy('status')->orderBy('created_time')->paginate(10);
        $ids = [];
        // var_dump($list);
        foreach($list as $key => $val){
            $ids[] = $val->user_id;
            // var_dump($key,$val);
        }
        $user = DB::table('user')->whereIn('id',$ids)->get();
        foreach($list as $key => $val){
            foreach($user as $k => $v){
                if($v->id == $val->user_id){
                    $val->qq_account = $v->qq_account;
                    $val->name = $v->name;
                    break;
                }
            }
            
        }
        return responseToJson(0,'success',$list);
    }
    //申请审批
    public function updateOrder(Request $request){
        DB::beginTransaction();
        try{
            $id = $request->id;
            $status = $request->status;
            $r =  DB::table('order')->where('id',$id)->update(['status'=>$status]);
            if($r){
                if($status==2){
                    $d = DB::table('order')->where('id',$id)->first();
                    $ids = explode(",",$d->star_coin_id);
                    DB::table('star_coin')->whereIn('id',$ids)->update(['buy_time'=>0]);
                }
            }
            DB::commit();
            return responseToJson(0,'success','操作成功');
        } catch (\Exception $e){
            DB::rollback();
        }
        return responseToJson(1,'error','操作失败');
    }
    

    //统计页面  累计发放  累计申请  累计购买
    public function stat(Request $request){
        $countGrade = $request->countGrade;
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        $givecount = 0;
        $applycount = 0;
        $buycount = 0;
        
        $coin = DB::table('star_coin');
        $order = DB::table('buy_order')->where(['is_pay'=>1,'is_delete'=>0]);
        $apply = DB::table('star_coin')->where('from_user_id',0);
        $gouwu = DB::table('order')->where(['status'=>1,'is_delete'=>0])->where('content','like','[购物]:%');
        $qingjia = DB::table('order')->where(['status'=>1,'is_delete'=>0])->where('content','like','[请假]%');
        $xiaojia = DB::table('order')->where(['status'=>1,'is_delete'=>0])->where('content','like','[销假]%');
        $duihuan = DB::table('order')->where(['status'=>1,'is_delete'=>0])->where('content','like','[兑换现金]:%');
        
        if($countGrade!=0){
            $u = DB::table('user')->where('is_delete',0);
            if(date('m')<6) $u->where('grade',date('Y')-$countGrade);
            else $u->where('grade',date('Y')-$countGrade+1);
            $user = $u->get();
            $ids = [];
            // var_dump($user);
            foreach($user as $k => $v) {
                $ids[] = $v->id;
            }
            $coin->whereIn('from_user_id',$ids);
            $apply->whereIn('to_user_id',$ids);
            $order->whereIn('user_id',$ids);
            $gouwu->whereIn('user_id',$ids);
            $qingjia->whereIn('user_id',$ids);
            $xiaojia->whereIn('user_id',$ids);
            $duihuan->whereIn('user_id',$ids);
        }

        $buyAll = $order->get();
        foreach($buyAll as $key=>$val){
            $buycount += $val->count;
        }

        $applycount =  $apply->count();

        $gouwuCount = $gouwu->count();
        $qingjiaCount = $qingjia->count();
        $xiaojiaCount = $xiaojia->count();
        $duihuanCount = $duihuan->count();

        // var_dump($gouwuCount,$qingjiaCount, $xiaojiaCount,$duihuanCount);

        $endDate = strtotime($endDate);
        $startDate = strtotime($startDate);
        $all = $coin->where('start_time','<=',$endDate)->where('start_time','>=',$startDate)->count();

        if($countGrade!=0){
            $givecount = $all-$buycount;
            // $applycount = DB::table('star_coin')->whereIn('to_user_id',$ids);
        } else {
            $givecount = $all-$buycount-$applycount;
        }

        return responseToJson(0,'success',[
            'givecount'=>$givecount,
            'applycount'=>$applycount,
            'buycount'=>$buycount,
            'gouwuCount'=>$gouwuCount,
            'qingjiaCount'=>$qingjiaCount,
            'xiaojiaCount'=>$xiaojiaCount,
            'duihuanCount'=>$duihuanCount,
        ]);
    }
}