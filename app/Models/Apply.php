<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2018/4/16
 * Time: 18:55
 */

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class Apply
{
    public static $sTable = 'apply';

    public static function applyStar(Request $request){


        return DB::table(self::$sTable)->insert(['apply_user_id'=>session('user')->id,
            'apply_user_name'=>session('user')->name,
            'content'=>$request->applyContent,
            'apply_type'=>$request->applyType,
            'created_time'=>time(),
            'update_time'=>time()]);
    }

    /**
     * 已处理审批列表
     * @arrVal int $startTime 查询起始时间
     * @arrVal int $endTime  查询结束时间
     * return Array
     */

    public static function dealExapvlist($startTime = null,$endTime = null)
    {
        $orderList = DB::table(self::$sTable)->where('apply.status', 1);
        if ($startTime != null)
            $orderList = $orderList->where('apply.created_time', '>',$startTime);
        if ($endTime)
            $orderList = $orderList->where('apply.created_time', '<',$endTime);
        return $orderList->join('user', 'apply.apply_user_id', '=', 'user.id')
            ->join('coin','apply.coin_id','=','coin.id')
            ->get(['user.code', 'apply.apply_user_name', 'apply.content', 'apply.data', 'apply.created_time','coin.name']);
    }
}