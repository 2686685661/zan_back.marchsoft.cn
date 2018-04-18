<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2018/4/18
 * Time: 15:44
 */

namespace App\Models;

use DB;
class ApplyType
{
    public static $sTable = 'apply_type';

    public static function getTypes()
    {
        return DB::table(self::$sTable)->where('is_delete',0)->get(['id','type_name']);
    }

}