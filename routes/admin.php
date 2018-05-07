<?php

Route::group(['prefix' => 'admin'],function() {

    Route::post('coin/give','Admin\IndexController@giveCoin');
    Route::get('user/get','Admin\IndexController@getUser');
    
});

