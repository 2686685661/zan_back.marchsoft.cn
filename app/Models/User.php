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


    public static $sTable = 'user';

    public static function updatePassword(Request $request)
    {

        return DB::table(self::$sTable)->where('code', session('code'))->update(['password' => md5(md5($request->newPassword))]);
    }

    public static function getPassword(Request $request)
    {
        return DB::table(self::$sTable)->where('code', session('code'))->first(['password']);
    }

    /**
     * 得到除自己外的用户集合
     * @return mixed
     */
    public static function getUserListExceptSelf($userId)
    {
        $users = DB::table(self::$sTable)
            ->where('id', '<>', $userId)
            ->select('id', 'name')
            ->get();
        return $users;
    }
}