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

        return DB::table(self::$sTable)->where('code', session('user')->code)->update(['password' => md5(md5($request->newPassword))]);
    }

    public static function getPassword()
    {
        return DB::table(self::$sTable)->where('code', session('user')->code)->first();
    }

    /**
     * 得到除自己外的(大一~大四、老师)用户集合
     * @return mixed
     */
    public static function getUserListExceptSelf($userId)
    {
        $year = date('Y') - 4;
        $users = DB::table(self::$sTable)
            ->where('id', '<>', $userId)
            ->where('grade','>=',$year)
            ->orWhere('type',1)
            ->select('id', 'name', 'grade','type')
            ->get()
            ->groupBy('grade');
        return $users;
    }

    /**
     * @param $user 数组，包含要更新的字段
     * @return mixed
     */
    public static function update($user){
        return DB::table(self::$sTable)->where('code', session('user')->code)->update($user);
    }

    /**
     * @param $name 用户账号
     * @param $password 用户要更新的密码
     * @return mixed
     */
    public static function resetPassword($name,$password){
        return DB::table(self::$sTable)->where('code', $name)->update(['password' => $password]);
    }
}