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

class User
{
    public static $mTable = 'user';

    /**
     * 得到除自己外的用户集合
     * @return mixed
     */
    public static function getUserListExceptSelf() {
        $users = DB::table(self::$mTable)
            ->where(['id','<>',get_session_user_id()])
            ->select('id','name')
            ->get();
        return $users;
    }
}