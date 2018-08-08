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

    public static function getLists(Request $request)
    {

        return DB::table(self::$sTable)->where('is_delete', 0)->where('is_view', 0)->where('user_id', $request->userID)->orderBy('created_time', 'desc')->offset(($request->page - 1) * 10)->limit(10)->get(['content', 'created_time', 'status', 'resaon']);
    }

    public static function getOrder()
    {
        return DB::table(self::$sTable)
            ->where('order.is_delete', 0)
            ->where('is_view', 0)->where('status', 0)
            ->where('order.group_id', session('group_id'))
            ->leftjoin('user', 'user.id', '=', 'order.user_id')
            ->first(['order.id', 'content', 'user_id', 'qq_account', 'name']);
    }

    public static function getPrecessOrder(Request $request)
    {
        return DB::table(self::$sTable)
            ->where('order.is_delete', 0)
            ->where('order.is_view', 0)
            ->where('order.status', '!=', 0)
            ->where('order.accept_id', session('id'))
            ->leftjoin('user', 'user.id', '=', 'order.user_id')
            ->offset(($request->page - 1) * 5)->limit(5)->get(['content', 'user_id', 'qq_account', 'name', 'order.status']);
    }

    /**
     * @param Request $request 请求所带的参数
     * 处理订单
     */
    public static function processOrder(Request $request)
    {

        return DB::table(self::$sTable)->where('id', $request->orderId)->update(['accept_id' => session('id'), 'status' => $request->status]);
    }

    /**
     * 取消费时新增订单记录
     * @arrVal Array
     * return Array
     */
    public static function createOrder($arrVal)
    {
        try {
            DB::beginTransaction();
            $createId = DB::table(self::$sTable)->insertGetId([
                'user_id' => $arrVal['userId'],
                'star_coin_id' => $arrVal['coinIdStr'],
                'content' => $arrVal['content'],
                'created_time' => $arrVal['createTime'],
                'group_id' => $arrVal['groupId'],
                'useful_id' => $arrVal['userfulId'],
            ]);
            return $createId;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 已处理订单列表
     * @arrVal int $startTime 查询起始时间
     * @arrVal int $endTime  查询结束时间
     * return Array
     */

    public static function dealOrderlist($startTime = null,$endTime = null)
    {
        $orderList = DB::table(self::$sTable)->where('order.is_delete', 0)->where('order.is_view', 0)->where('order.status', '=', 1);
        if ($startTime != null)
            $orderList = $orderList->where('order.created_time', '>',$startTime);
        if ($endTime)
            $orderList = $orderList->where('order.created_time', '<',$endTime);
        return $orderList->leftjoin('user', 'user.id', '=', 'order.user_id')->get(['code', 'name', 'qq_account', 'content', 'star_coin_id','created_time', 'resaon']);
    }

}