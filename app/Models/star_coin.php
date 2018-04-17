<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2018/4/16
 * Time: 19:14
 */

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class star_coin
{
    public static $sTable = 'star_coin';

    /**
     * $type == 0 未使用
     * $type == 1 已使用
     * $type == 2 已过期
     */
    public static function see_notuse_consume_coin($user_id,$type) {
        $now_time = time();
        $select_coins = null;
        $select_coins_handle = DB::table(self::$sTable)->leftJoin('user',self::$sTable.'.from_user_id','=','user.id')->where([
            ['to_user_id','=',$user_id],
            ['start_time','<=',$now_time],
            ['over_time','>=',$now_time]
        ]);
        if($type == 0)
            $select_coins = $select_coins_handle->where('is_buy','=',1)
            ->select('user.name','user.qq_account',self::$sTable.'.reason',self::$sTable.'.over_time',self::$sTable.'.coin_id')
            ->get();
        else if($type == 2)
            $select_coins = $select_coins_handle->where('is_buy','=',0)
            ->select('user.name','user.qq_account',self::$sTable.'.reason',self::$sTable.'.coin_id')
            ->get();
        else if($type == 3)
            $select_coins = DB::table(self::$sTable)->leftJoin('user',self::$sTable.'.from_user_id','=','user.id')->where([
                ['to_user_id','=',$user_id],
                ['over_time','<',$now_time]
            ])->select('user.name','user.qq_account',self::$sTable.'.reason')->get();

        return $select_coins;
        
    }


}