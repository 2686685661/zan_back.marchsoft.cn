<?php


Route::group(['prefix' => 'user','namespace' => 'User'],function() {

    /**
     * 去消费
     */
    Route::group(['prefix' => 'consume'],function() {
        Route::get('seeCon/{type}','ConsumeController@getUserConsumeCoin');
        Route::post('insertCoinOrder','ConsumeController@insertUserConsume');
        // Route::post('insertCoinOrder/{use_id}/{coin_useful}/{coin_id_arr}/{group_id}/{content}','User\ConsumeController@insertUserConsume');
    });


    /**
     * 显示记录
     */

    Route::group(['prefix' => 'record'],function() {
        Route::get('thumbup','RecordController@getThumbupList');
        Route::get('countnum','RecordController@getCountNumber');
        Route::get('countList','RecordController@getThumbupCount');
    });

    /**
     * 我的赞
     */
    Route::group(['prefix' => 'thumbsUp'],function() {
        Route::post('/','ThumbsUpController@thumbsUp');
        Route::get('getCoinList','ThumbsUpController@getCoinList');
        Route::get('getUsedCoinList','ThumbsUpController@getUsedCoinList');
        Route::get('getOverdueCoinList','ThumbsUpController@getOverdueCoinList');
        Route::get('getUserListExceptSelf','ThumbsUpController@getUserListExceptSelf');
    });
    Route::group(['prefix' => 'personalCenter'],function() {
        Route::any('/getOrderList','PersonalCenter@getOrderList');
        Route::any('/addApply','PersonalCenter@applicationStar');
        Route::any('/getApplyType','PersonalCenter@getTypes');
        Route::any('/getBuyOrder','PersonalCenter@getBuyOrder');
        Route::any('/getProcessOrderr','PersonalCenter@getProcessOrderr');
        Route::any('/updateOrder','PersonalCenter@processOrder');
        Route::any('/getTalk','PersonalCenter@getTalk');
        Route::any('/addTalk','PersonalCenter@addTalk');
        Route::any('/updatePassword','PersonalCenter@updatePassword');
        Route::any('/getRule','PersonalCenter@getRule');
    });

});