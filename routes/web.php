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



Route::group(['middleware'=>['cors']], function() {
<<<<<<< HEAD
    Route::get('test','User\PersonalCenter@getRule');
    Route::get('/','IndexController@index');
=======
    // Route::get('/','IndexController@index');
>>>>>>> 4417476df7cf49550a0b9bdc91e284b1d523d522
    include('user.php');
    include('admin.php');

    Route::group(['prefix' => 'alipay'],function() {
        Route::get('wappay','User\Alipay\AlipayWapController@alipayWapPay');
        Route::get('return','User\Alipay\AlipayWapController@alipayReturn');
        Route::get('notify','User\Alipay\AlipayWapController@alipayNotify');
    });
});

