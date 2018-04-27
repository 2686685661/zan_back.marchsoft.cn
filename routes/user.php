<?php

Route::group(['prefix' => 'user','namespace'=>'User'],function() {

    Route::group(['prefix' => 'consume'],function() {
        Route::get('seeCon/{userid}/{type}','User\ConsumeController@getUserConsumeCoin');
        Route::get('insertCoinOrder/{use_id}/{coin_useful}/{coin_id_arr}/{group_id}/{content}','User\ConsumeController@insertUserConsume');
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