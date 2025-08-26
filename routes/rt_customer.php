<?php

Route::group(['prefix' => 'clientes'], function(){
    Route::get('/', 'ClientesController@index')->name('clientes.index');   
});