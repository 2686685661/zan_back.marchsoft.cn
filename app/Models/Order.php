<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2018/4/16
 * Time: 19:12
 */

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class order
{

    public static $sTable = 'order';

    public static function getLists(Request $request){
      return  DB::table(self::$sTable)->where('is_delete',0)->where('is_view',0)->limit($request->page,10)->get(['content','created_time','status','resaon']);
    }

    /**
     * 取消费时新增订单记录
     * @arrVal Array
     * return Array
     */
    public static function createOrder($arrVal) {
      try{
        DB::beginTransaction();
        $createId = DB::table(self::$sTable)->insertGetId([
          'user_id'       => $arrVal['userId'],
          'star_coin_id'  => $arrVal['coinIdStr'],
          'content'       => $arrVal['content'],
          'created_time'  => $arrVal['createTime'],
          'group_id'      => $arrVal['groupId'],
          'useful_id'     => $arrVal['userfulId'],
        ]);
        return $createId;
      }catch(\Exception $e) {
        return false;
      }
    }
}