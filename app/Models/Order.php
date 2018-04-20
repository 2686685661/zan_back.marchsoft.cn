<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2018/4/16
 * Time: 19:12
 */

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class order
{

    public static $sTable = 'order';

    public static function getLists(Request $request){
      return  DB::table(self::$sTable)->where('is_delete',0)->where('is_view',0)->limit($request->page,10)->get(['content','created_time','status','resaon']);
    }
}