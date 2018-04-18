<?php

Route::group(['prefix' => 'user'],function() {

    Route::group(['prefix' => 'consume'],function() {
        Route::get('seeCon/{uerid}/{type}','ConsumeController@getUserConsumeCoin');
    });
   
    
});