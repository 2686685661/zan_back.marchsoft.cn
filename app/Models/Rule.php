<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2018/4/16
 * Time: 19:13
 */

namespace App\Models;
use DB;
use Illuminate\Http\Request;

class Rule
{

    public static $sTable = 'rule';

    public static function getRule(){
        return DB::table(self::$sTable)->orderBy('created_time','desc')->first(['content']);
    }
}