<?php

Route::group(['prefix' => 'user','namespace'=>'User'],function() {

    Route::group(['prefix' => 'consume'],function() {
        Route::get('seeCon/{uerid}/{type}','ConsumeController@getUserConsumeCoin');
        Route::post('insertCoinOrder','ConsumeController@insertUserConsume');
    });

    /**
     * 登录
     */
    Route::post('login','LoginController@login');

    /**
     * 我的赞
     */
    Route::group(['prefix' => 'thumbsUp'],function() {
        Route::post('/','ThumbsUpController@thumbsUp');
        Route::post('getCoinList','ThumbsUpController@getCoinList');
        Route::post('getUsedCoinList','ThumbsUpController@getUsedCoinList');
        Route::post('getOverdueCoinList','ThumbsUpController@getOverdueCoinList');
        Route::post('getUserListExceptSelf','ThumbsUpController@getUserListExceptSelf');
    });
});