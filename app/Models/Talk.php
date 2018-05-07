<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2018/4/26
 * Time: 19:29
 */

namespace App\Models;


use Illuminate\Http\Request;
use DB;
class Talk
{

    public static $sTable = 'talk';

    public static function getTalk(Request $request){
        // return DB::table(self::$sTable)->where('is_delete',0)->offset(($request->page-1)*5)->limit(5)->get(['content','create_time']);
        return DB::table(self::$sTable)->where('is_delete',0)->offset(($request->page-1)*5)->limit(5)->orderBy('create_time','desc')->get(['content','create_time']);
    }

    public static function addTalk($content=''){

        return DB::table(self::$sTable)->insert(['content'=>$content,'create_time'=>time()]);
    }
}