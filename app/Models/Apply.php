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

        return DB::table(self::$sTable)->insert(['apply_user_id'=>$request->user_id,'apply_user_name'=>$request->user_name,'content'=>$request->apply_content]);
    }
}