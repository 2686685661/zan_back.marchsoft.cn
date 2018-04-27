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
     * @param string $userID
     * @param int $typeCoin 1:被点赞 2：点赞给别人
     * @param int $sizeCount 查询条数
     * @return JSON
     */
    public static function getThumupedCoin($userID,$typeCoin,$sizeCount = 10){
        $selectCoins = null;
        $selectTarget = null;
        $selectCoinsBase = DB::table(self::$sTable)
            ->leftJoin('user',self::$sTable.'.to_user_id','=','user.id')->orderBy('use_time','desc');
        $typeCoin == 1? $selectTarget = 'to_user_id':$selectTarget = 'from_user_id';
        $selectCoins = $selectCoinsBase->where([
            [self::$sTable.'.'.$selectTarget,'=',$userID],
            [self::$sTable.'.over_time','>=',self::$sTable.'.use_time']
        ])->select('user.name','user.qq_account',self::$sTable.'.reason',self::$sTable.'.start_time',self::$sTable.'.over_time',self::$sTable.'.use_time')
            ->simplePaginate($sizeCount);
        return $selectCoins;
    }

    /**
     * @param int $countGrade
     * @param int $startDate
     * @param int $endDate
     * @return arr
     */
    public static function getThumupRank($countGrade=0, $startDate, $endDate){
        $selectCoins = null;
        $selectCoinsBase = DB::table(self::$sTable)
            ->leftJoin('user',self::$sTable.'.to_user_id','=','user.id')
            ->select('user.id','user.name','user.qq_account',self::$sTable.'.to_user_id',self::$sTable.'.use_time');
        if ($countGrade == 0){
            $selectCoins = $selectCoinsBase->where([
                ['use_time','>=',$startDate],
                ['use_time','<=',$endDate]
            ]);
        }else{
            $selectCoins = $selectCoinsBase->where([
                ['user.group_id','=',$countGrade],
                ['use_time','>=',$startDate],
                ['use_time','<=',$endDate]
            ]);
        }
        $selectCoins = $selectCoins->get()->groupBy('to_user_id');
        return $selectCoins;
    }
}