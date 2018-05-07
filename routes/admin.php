<?php

Route::group(['prefix' => 'admin'],function() {

    Route::post('coin/give','Admin\IndexController@giveCoin');
    
});

