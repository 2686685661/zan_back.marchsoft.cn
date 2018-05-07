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
    public static function getNotUserConsumeCoin($valArr,$page = 5) {
       
        $select_coins = null;
        // try{
            if($valArr['useType'] == 0) 
                $select_coins =  DB::table(self::$sTable)
                ->leftJoin(self::$sTableUser,self::$sTable.'.from_user_id','=',self::$sTableUser.'.id')
                ->where([
                    ['to_user_id','=',$valArr['userId']],
                ])->where('buy_time','=',0)
                ->select(
                    self::$sTableUser.'.name',
                    self::$sTableUser.'.qq_account',
                    self::$sTable.'.coin_id',
                    self::$sTable.'.reason',
                    self::$sTable.'.over_time',
                    self::$sTable.'.id'
                )
                // ->simplePaginate($page);
                ->get();
            else if($valArr['useType'] == 1)
                $select_coins =  DB::table(self::$sTable)
                ->leftJoin(self::$sTableUser,self::$sTable.'.from_user_id','=',self::$sTableUser.'.id')
                ->where([
                    ['to_user_id','=',$valArr['userId']],
                ])
                ->where('buy_time','!=',0)
                ->select(
                    'user.name',
                    'user.qq_account',
                    self::$sTable.'.reason',
                    self::$sTable.'.coin_id'
                )
                // ->simplePaginate($page);
                ->get();
            else if($valArr['useType'] == 2)
                $select_coins = DB::table(self::$sTable)
                ->leftJoin(self::$sTableUser,self::$sTable.'.from_user_id','=',self::$sTableUser.'.id')
                ->where([
                    ['to_user_id','=',$valArr['userId']],
                    ['over_time','<',$valArr['createTime']]
                ])
                ->select(
                    self::$sTableUser.'.name',
                    self::$sTableUser.'.qq_account',
                    self::$sTable.'.reason'
                )
                // ->simplePaginate($page);
                ->get();
            
                    

            return $select_coins; 
        // }catch(\Exception $e) {
        //     return null;
        // }
        
    }


    /**
     * 得到句柄
     * @valArr Array
     * return Handle
     */
    private static function getUserConsumeCoinHandle($valArr) {
        // try{
            return DB::table(self::$sTable)
            ->leftJoin(self::$sTableUser,self::$sTable.'.from_user_id','=',self::$sTableUser.'.id')
            ->where([
                ['to_user_id','=',$valArr['userId']],
                // ['start_time','<=',$valArr['createTime']],
                // ['over_time','>=',$valArr['createTime']]
            ]);
        // }catch(\Exception $e) {
        //     return false;
        // }
    }


    /**
     * 回调更新用户点赞币记录的buy_time
     * @formUserId Number
     * @coinId Arr Array
     */
    public static function updateUseCoinState($formUserId, $coinIdArr) {
        try{
            $updateRowsNUm = DB::table(self::$sTable)
            ->where('to_user_id','=',$formUserId)
            ->whereIn('id',$coinIdArr)
            ->update(['buy_time' => time()]);
            $updateRowsNUm ?  DB::commit() : DB::rollback(); 
            return true;
        }catch(\Exception $e) {
            return -1;
        }
        
    }

    /**
     * @param $userId 用户id
     * @param bool $isOverdue 是否过期,默认false未过期
     * @return mixed
     */
    public static function getCoinList($userId,$pageSize,$isOverdue = false) {
        $now_time = time();
        $coins_handle = DB::table(self::$sTable)->leftJoin('coin',self::$sTable.'.coin_id','=','coin.id')->where([
            ['from_user_id','=',$userId],
            ['to_user_id','=',0]
        ]);
        if($isOverdue)
            $coins_handle->where('over_time','<',$now_time);
        else
            $coins_handle->where('over_time','>=',$now_time);
        $coins = $coins_handle->select(
            self::$sTable.'.id',
            self::$sTable.'.coin_id',
            self::$sTable.'.start_time',
            self::$sTable.'.over_time',
            'coin.name as coin_name'
        )->get();
        // ->paginate($pageSize);
        return $coins;
    }

    /**
     * 得到已使用的点赞币
     * @param $userId
     * @return mixed
     */
    public static function getUsedCoinList($userId,$pageSize) {
        $coins = DB::table(self::$sTable)->leftJoin('user',self::$sTable.'.to_user_id','=','user.id')->where([
            ['from_user_id','=',$userId],
            ['to_user_id','<>',0],
        ])->select(
            self::$sTable.'.id',
            self::$sTable.'.coin_id',
            self::$sTable.'.to_user_id',
            self::$sTable.'.start_time',
            self::$sTable.'.over_time',
            self::$sTable.'.reason',
            self::$sTable.'.use_time',
            'user.name as to_user_name',
            'user.qq_account'
        )->get();
        // ->paginate($pageSize);
        return $coins;
    }

    /**
     * 得到已过期的点赞币
     * @param $userId
     * @return mixed
     */
    public static function getOverdueCoinList($userId,$pageSize) {
        return self::getCoinList($userId,$pageSize,true);
    }


    /**
     * @param string $userID
     * @param int $typeCoin 1:被点赞 2：点赞给别人
     * @param int $sizeCount 查询条数
     * @return JSON
     */
    public static function getThumupedCoin($userID,$typeCoin,$sizeCount = 1){
        // $selectCoins = null;
        // $selectTarget = null;
        // $selectCoinsBase = DB::table(self::$sTable)
        //     ->leftJoin('user',self::$sTable.'.to_user_id','=','user.id')->orderBy('use_time','desc');
        // if($typeCoin == 1) $selectTarget = 'to_user_id';
        // else $selectTarget = 'from_user_id';
        // $selectCoins = $selectCoinsBase->where([
        //     [self::$sTable.'.'.$selectTarget,'=',$userID],
        //     [self::$sTable.'.over_time','>=',self::$sTable.'.use_time']
        // ])->select('user.name','user.qq_account',self::$sTable.'.reason',self::$sTable.'.start_time',self::$sTable.'.over_time',self::$sTable.'.use_time')
        //     ->simplePaginate($sizeCount);
        // return $selectCoins;
        $selectCoinsBase = DB::table(self::$sTable)->orderBy('use_time','desc');
        if($typeCoin==1) $selectCoins = $selectCoinsBase->where('to_user_id',get_session_user_id())->paginate($sizeCount);
        else $selectCoins = $selectCoinsBase->where('from_user_id',get_session_user_id())->where('to_user_id','!=',0)->paginate($sizeCount);
        return  $selectCoins;
    }

    /**
     * @param int $countGrade
     * @param int $startDate
     * @param int $endDate
     * @return arr
     */
    public static function getThumupRank($countGrade=0, $startDate, $endDate)
    {
        $selectCoins = null;
        $selectCoinsBase = DB::table(self::$sTable)
            ->leftJoin('user', self::$sTable . '.to_user_id', '=', 'user.id')
            ->select('user.id', 'user.name', 'user.qq_account', self::$sTable . '.to_user_id', self::$sTable . '.use_time');
        if ($countGrade == 0) {
            $selectCoins = $selectCoinsBase->where([
                ['use_time', '>=', $startDate],
                ['use_time', '<=', $endDate]
            ]);
        } else {
            $selectCoins = $selectCoinsBase->where([
                ['user.group_id', '=', $countGrade],
                ['use_time', '>=', $startDate],
                ['use_time', '<=', $endDate]
            ]);
        }
        $selectCoins = $selectCoins->get()->groupBy('to_user_id')->toArray();
        return $selectCoins;
    }

    public static function thumbsUp($userId,$ids,$toUserId,$reason) {
        $name = DB::table('user')->where('id',$toUserId)->first();
        DB::beginTransaction();
        try{
            foreach ($ids as $value){
                DB::table(self::$sTable)
                    ->where('id',$value)
                    ->where('from_user_id',$userId)
                    ->update([
                        'to_user_id' => $toUserId,
                        'to_user_name' => $name->name,
                        'reason'     => $reason,
                        'use_time'   => time()
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


    /**
     * @param $page
     * @return $pageArr
     */
    public static function setPaging($page = 5) {
        $pageArr = DB::table(self::$sTable)->simplePaginate($page);

        return $pageArr;
    }
}