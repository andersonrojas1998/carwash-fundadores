<?php

Route::group(['prefix' => 'venta'], function(){
    Route::get('', 'VentaController@index')->name('venta.index');
    Route::get('create', 'VentaController@create')->name('venta.create');
    Route::get('create-market', 'VentaController@createMarket')->name('venta.create-market');
    Route::get('{venta}', 'VentaController@show')->name('venta.show');
    Route::get('{venta}/edit', 'VentaController@edit')->name('venta.edit');
    Route::post('', 'VentaController@store')->name('venta.store');    
    Route::post('update', 'VentaController@update')->name('venta.update');    
});

Route::post('update_user', 'VentaController@updateUser');    
Route::get('ticketPrint/{id}', 'TicketController@ticketPrint');
Route::get('showCopy/{id}', 'VentaController@showCopy');
Route::get('createPp', 'TicketController@create');
Route::get('sendMessageWpp', 'TicketController@sendMessageWpp');
Route::get('/buscar-cliente-placa', 'VentaController@buscarClientePlaca');
Route::get('/cierre-ventas', 'VentaController@cierreVentas')->name('venta.cierre-ventas');
Route::post('/venta/finalizar', 'VentaController@finalizarVenta')->name('venta.finalizar');