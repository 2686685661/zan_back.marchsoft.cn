<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2018/4/16
 * Time: 18:55
 */

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class Apply
{
    public static $sTable = 'apply';

    public static function applyStar(Request $request){


        return DB::table(self::$sTable)->insert(['apply_user_id'=>session('user')->id,
            'apply_user_name'=>session('user')->name,
            'content'=>$request->applyContent,
            'apply_type'=>$request->applyType,
            'created_time'=>time(),
            'update_time'=>time()]);
    }
}