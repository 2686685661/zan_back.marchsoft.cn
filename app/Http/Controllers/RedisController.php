<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    //
    public function testRedis() {
        $value = Redis::set('aa','aaaaaaaaa');
        var_dump($value);
        $a = Redis::get('aa');
        dd($a);

    }
}
