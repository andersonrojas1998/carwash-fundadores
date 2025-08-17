<?php

    Route::group(['prefix' => 'paquete'], function(){
        Route::get('', 'PaqueteController@index')->name('paquete.index');
        Route::post('', 'PaqueteController@store')->name('paquete.store');
        Route::get('{tipoVehiculo}/packagesByVehicleType', 'PaqueteController@packagesByVehicleType')->name('paquete.packagesByVehicleType');
    });

    Route::group(['prefix' => 'servicio'], function(){
        Route::get('', 'DetallePaqueteController@index')->name('detalle-paquete.index');
        Route::get('create', 'DetallePaqueteController@create')->name('detalle-paquete.create');
        Route::get('{detalle_paquete}/edit', 'DetallePaqueteController@edit')->name('detalle-paquete.edit');
        Route::get('{paquete}/unrelated-vehicle-type', 'DetallePaqueteController@unrelatedVehicleType')->name('detalle-paquete.unrelatedVehicleType');
        //Route::get('{tipo_vehiculo}/tipo-vehiculo', 'PaqueteController@getServicesByVehicleType')->name('paquete.serviceByVehicleType');
        Route::post('', 'DetallePaqueteController@store')->name('detalle-paquete.store');
        Route::put('{detalle_paquete}', 'DetallePaqueteController@update')->name('detalle-paquete.update');
    });
?>