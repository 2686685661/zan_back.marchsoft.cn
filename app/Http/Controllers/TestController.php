<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
class TestController {

    public function request(Request $request) {
        echo "the request is shoudao!";
    }
}