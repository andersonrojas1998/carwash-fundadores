<?php

    Route::get('presentacion', 'PresentacionController@index')->name('presentacion.index');

    Route::group(['prefix' => 'marca'], function(){
        Route::get('', 'MarcaController@index')->name('marca.index');
        Route::post('', 'MarcaController@store')->name('marca.store');
    });

    Route::group(['prefix' => 'tipo-producto'], function(){
        Route::get('', 'TipoProductoController@index')->name('tipo-producto.index');
        Route::post('', 'TipoProductoController@store')->name('tipo-producto.store');
    });

    Route::group(['prefix' => 'producto'], function(){
        Route::get('', 'ProductoController@index')->name('producto.index');
        Route::get('data/{area}', 'ProductoController@dataTable')->name('producto.data');
        Route::get('{producto}', 'ProductoController@getQuantity')->name('producto.cantidad');
        Route::post('', 'ProductoController@store')->name('producto.store');
        Route::put('', 'ProductoController@update')->name('producto.update');
    });

    Route::get('area', 'AreaController@index')->name('area.index');
