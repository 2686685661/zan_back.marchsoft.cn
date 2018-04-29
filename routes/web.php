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

/**
 * 登录
 */
Route::post('user\login','User\LoginController@login');

Route::group(['middleware'=>['cors','login.check']], function() {

    // Route::get('/','IndexController@index');
    include('user.php');
    include('admin.php');

    Route::group(['prefix' => 'alipay'],function() {
        Route::get('wappay','User\Alipay\AlipayWapController@alipayWapPay');
        Route::get('return','User\Alipay\AlipayWapController@alipayReturn');
        Route::get('notify','User\Alipay\AlipayWapController@alipayNotify');
    });
});

