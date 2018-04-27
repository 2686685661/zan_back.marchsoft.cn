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

class StarCoin
{

    public static $sTable = 'star_coin';

    /**
     * $type == 0 未使用
     * $type == 1 已使用
     * $type == 2 已过期
     */
    public static function getNotUserConsumeCoin($user_id,$typeCoin) {
        $now_time = time();
        $select_coins = null;
        $select_coins_handle = DB::table(self::$sTable)->leftJoin('user',self::$sTable.'.from_user_id','=','user.id')->where([
            ['to_user_id','=',$user_id],
            ['start_time','<=',$now_time],
            ['over_time','>=',$now_time]
        ]);
        if($typeCoin == 0)
            $select_coins = $select_coins_handle->where('is_buy','=',1)
            ->select('user.name','user.qq_account',self::$sTable.'.reason',self::$sTable.'.over_time',self::$sTable.'.coin_id')
            ->groupBy(self::$sTable.'.coin_id')
            ->get();
        else if($typeCoin == 1)
            $select_coins = $select_coins_handle->where('is_buy','=',0)
            ->select('user.name','user.qq_account',self::$sTable.'.reason',self::$sTable.'.coin_id')
            ->groupBy(self::$sTable.'.coin_id')
            ->get();
        else if($typeCoin == 2)
            $select_coins = DB::table(self::$sTable)->leftJoin('user',self::$sTable.'.from_user_id','=','user.id')->where([
                ['to_user_id','=',$user_id],
                ['over_time','<',$now_time]
            ])->select('user.name','user.qq_account',self::$sTable.'.reason')->get();

        return $select_coins;
    }


    public static function insertUserOrder($orderMsg) {

    }

    public static function updateUseCoinState($coinIdArr) {

    }

    /**
     * @param $userId 用户id
     * @param bool $isOverdue 是否过期,默认false未过期
     * @return mixed
     */
    public static function getCoinList($userId,$isOverdue = false) {
        $now_time = time();
        $coins_handle = DB::table(self::$sTable)->leftJoin('coin',self::$sTable.'.coin_id','=','coin.id')->where([
            ['from_user_id','=',$userId],
            ['to_user_id','=',0]
        ]);
        if($isOverdue)
            $coins_handle->where(['over_time','<',$now_time]);
        else
            $coins_handle->where(['over_time','>=',$now_time]);
        $coins = $coins_handle->select(
            self::$sTable.'id',
            self::$sTable.'coin_id',
            self::$sTable.'start_time',
            self::$sTable.'over_time',
            'coin.name as coin_name'
        )->get();
        return $coins;
    }

    /**
     * 得到已使用的点赞币
     * @param $userId
     * @return mixed
     */
    public static function getUsedCoinList($userId) {
        $coins = DB::table(self::$sTable)->leftJoin('user',self::$sTable.'.to_user_id','=','user.id')->where([
            ['from_user_id','=',$userId],
            ['to_user_id','<>',0],
        ])->select(
            self::$sTable.'id',
            self::$sTable.'coin_id',
            self::$sTable.'to_user_id',
            self::$sTable.'start_time',
            self::$sTable.'over_time',
            self::$sTable.'reason',
            self::$sTable.'use_time',
            'user.name as to_user_name',
            'user.qq_account'
        )->get();
        return $coins;
    }

    /**
     * 得到已过期的点赞币
     * @param $userId
     * @return mixed
     */
    public static function getOverdueCoinList($userId) {
        return self::getCoinList($userId,true);
    }

    public static function thumbsUp($ids,$toUserId,$reason) {
        DB::beginTransaction();
        try{
            foreach ($ids as $value){
                DB::table(self::$sTable)
                    ->where('id',$value)
                    ->where('from_user_id',get_session_user_id())
                    ->update([
                        'to_user_id' => $toUserId,
                        'reason'     => $reason,
                        'use_time'   => millisecond()
                    ]);
            }
            DB::commit();
            return true;
        }catch (Exception $e){
            DB::rollback();
            Log::info($e);
            return false;
        }
    }
}