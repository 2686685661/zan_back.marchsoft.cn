<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware'=>['cors','login']], function() {
    Route::get('/','IndexController@index')->middleware('ip');
    Route::any('/send','TestController@request');
    include('user.php');
    include('admin.php');
    Route::get('test',function (){return get('test');});
});



Route::get('login',function (){
    header('Location: http://www.baidu.com');
    die;
});

