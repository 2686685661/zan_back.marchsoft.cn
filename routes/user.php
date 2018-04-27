<?php

Route::group(['prefix' => 'user','namespace' => 'User'],function() {

    Route::group(['prefix' => 'consume'],function() {
        Route::get('seeCon/{uerid}/{type}','ConsumeController@getUserConsumeCoin');
        Route::post('insertCoinOrder','ConsumeController@insertUserConsume');
    });

    Route::group(['prefix' => 'record'],function() {
        Route::get('thumbup','RecordController@getThumbupList');
        Route::get('countnum','RecordController@getCountNumber');
        Route::get('countList','RecordController@getThumbupCount');
    });
});