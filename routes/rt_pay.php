<?php

Route::group(['prefix' => 'pago'], function(){
    Route::get('inicio', 'CompraController@indexPay');  
    Route::post('', 'PayController@store')->name('pago.store');   
});