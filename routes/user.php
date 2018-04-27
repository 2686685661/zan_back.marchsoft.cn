<?php

Route::group(['prefix' => 'user'],function() {

    Route::group(['prefix' => 'consume'],function() {
        Route::get('seeCon/{userid}/{type}','User\ConsumeController@getUserConsumeCoin');
        Route::get('insertCoinOrder/{use_id}/{coin_useful}/{coin_id_arr}/{group_id}/{content}','User\ConsumeController@insertUserConsume');
    });

    
   
    
});