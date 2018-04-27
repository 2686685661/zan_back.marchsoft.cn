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
    public static $sTableUser = 'user';

    
    /**
     * 获得取消费模块中用户点赞币情况
     * @valArr Array
     * return Array
     */
    public static function getNotUserConsumeCoin($valArr) {
       
        $select_coins = null;
        try{
            if($valArr['useType'] == 0) 
                $select_coins = self::getUserConsumeCoinHandle($valArr)
                ->where('is_buy','=',1)
                ->select(
                    self::$sTableUser.'.name',
                    self::$sTableUser.'.qq_account',
                    self::$sTable.'.coin_id',
                    self::$sTable.'.reason',
                    self::$sTable.'.over_time'
                )
                ->get();
            else if($valArr['useType'] == 1)
                $select_coins = self::getUserConsumeCoinHandle($valArr)
                ->where('is_buy','=',0)
                ->select(
                    'user.name',
                    'user.qq_account',
                    self::$sTable.'.reason',
                    self::$sTable.'.coin_id'
                )
                ->get();
            else if($valArr['useType'] == 2)
                $select_coins = DB::table(self::$sTable)
                ->leftJoin(self::$sTableUser,self::$sTable.'.from_user_id','=',self::$sTableUser.'.id')
                ->where([
                    ['to_user_id','=',$userId],
                    ['over_time','<',$now_time]
                ])
                ->select(
                    self::$sTableUser.'.name',
                    self::$sTableUser.'.qq_account',
                    self::$sTable.'.reason'
                )
                ->get()
                ->toArray();
            
                    

            return $select_coins; 
        }catch(\Exception $e) {
            return false;
        }
        
    }


    /**
     * 得到句柄
     * @valArr Array
     * return Handle
     */
    private static function getUserConsumeCoinHandle($valArr) {
        try{
            return DB::table(self::$sTable)
            ->leftJoin(self::$sTableUser,self::$sTable.'.from_user_id','=',self::$sTableUser.'.id')
            ->where([
                ['to_user_id','=',$valArr['userId']],
                ['start_time','<=',$valArr['createTime']],
                ['over_time','>=',$valArr['createTime']]
            ]);
        }catch(\Exception $e) {
            return false;
        }
    }


    /**
     * 回调更新用户点赞币记录的is_buy
     * @formUserId Number
     * @coinId Arr Array
     */
    public static function updateUseCoinState($formUserId, $coinIdArr) {
        try{
            $updateRowsNUm = DB::table(self::$sTable)
            ->where('to_user_id','=',$formUserId)
            ->whereIn('id',$coinIdArr)
            ->update(['is_buy' => 0]);
            $updateRowsNUm ?  DB::commit() : DB::rollback(); 
            return true;
        }catch(\Exception $e) {
            return -1;
        }
        
    }

}