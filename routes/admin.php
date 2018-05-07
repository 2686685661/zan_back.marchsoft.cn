<?php

Route::group(['prefix' => 'admin'],function() {

    Route::post('coin/give','Admin\IndexController@giveCoin');
    Route::get('user/get','Admin\IndexController@getUser');
    Route::get('apply/get','Admin\IndexController@getApplyList');
    Route::post('apply/update','Admin\IndexController@updateApply');

    Route::get('order/get','Admin\IndexController@getOrderList');
    Route::post('order/update','Admin\IndexController@updateOrder');
});

