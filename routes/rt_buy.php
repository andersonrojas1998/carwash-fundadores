<?php

Route::group(['prefix' => 'unidad-de-medida'], function(){
    Route::get('', 'UnidadDeMedidaController@index')->name('unidad-de-medida.index');
    Route::post('', 'UnidadDeMedidaController@store')->name('unidad-de-medida.store');
});

Route::get('condiciones', 'CondicionesController@index')->name('condiciones.index');

Route::get('estado', 'EstadoController@index')->name('estado.index');

Route::group(['prefix' => 'compra'], function(){
    Route::get('', 'CompraController@index')->name('compra.index');
    Route::get('create', 'CompraController@create')->name('compra.create');
    Route::get('edit/{compra}', 'CompraController@edit')->name('compra.edit');
    Route::get('edit-payment/{compra}', 'CompraController@editPayment')->name('compra.edit-payment');
    Route::get('data', 'CompraController@dataTable')->name('compra.data');
    Route::get('products/{compra}', 'CompraController@getProducts')->name('compra.products');
    Route::post('', 'CompraController@store')->name('compra.store');
    Route::put('', 'CompraController@update')->name('compra.update');
    Route::put('update-payment', 'CompraController@updatePayment')->name('compra.update-payment');
});