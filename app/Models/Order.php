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

    public $mTable = 'order';

    public function get_lists(Request $request){
      return  DB::table($this->mTable)->where('is_delete',0)->where('is_view',0)->limit($request->page,10)->get(['content','created_time','status','resaon']);
    }
}