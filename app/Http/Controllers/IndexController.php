<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    

    public function index() {

        // echo 'aaa';
        $user = get_redis_session_user();

        if($user) {
            echo "我现在登录到后台界面了,session存在";
        }
        echo '我现在在登录界面,session不存在';
    }
}
