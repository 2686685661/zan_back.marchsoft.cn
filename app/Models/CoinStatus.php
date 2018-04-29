<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2018/4/16
 * Time: 18:58
 */

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class CoinStatus
{

    public static $sTable = 'coin_status';

    /**
     * 获得总点赞数
     * @param $userID
     * @return mixed
     */
    public static function getThumupTotal($userID){
        $selectCoinsBase = DB::table(self::$sTable)->select('receive_count')
            ->where(self::$sTable.'.user_id','=',$userID)->get();
        return $selectCoinsBase;
    }
}