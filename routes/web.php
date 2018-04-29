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
    Route::get('test','User\PersonalCenter@getRule');
    Route::get('/','IndexController@index');
    include('user.php');
    include('admin.php');
});

