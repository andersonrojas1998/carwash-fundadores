<?php
Route::group(['prefix' => 'usuarios'], function(){
    Route::get('inicio', 'DocenteController@index');
    Route::get('creacion', 'DocenteController@index_create');
    Route::post('create', 'DocenteController@create');
    Route::post('update', 'DocenteController@update');
    Route::get('show/{id}', 'DocenteController@showUser');
    Route::get('ventas', 'DocenteController@sales');
    Route::get('/dt_sales_user', 'DocenteController@dt_sales_user');
    Route::get('/dt_pay_pending/{id}/{status}', 'DocenteController@dt_pay_pending');
    Route::get('/pay_sales', 'DocenteController@pay_sales');
});
Route::get('/dt_user', 'DocenteController@dt_user');

Route::get('/income_store/{dateini}/{dateend}', 'ReportsController@income_store');
Route::get('/showTeacher', 'DocenteController@showTeacher');
Route::get('/showGradesAssign', 'DocenteController@gradeAssignments');
Route::get('/assignmentCourseTeacher', 'DocenteController@assignmentCourseTeacher');


Route::get('/checkin-employe', 'LlegadaLavadorController@index')->name('checkin.index');
Route::post('/checkin-employe/save', 'LlegadaLavadorController@store')->name('checkin.store');
Route::post('/checkin-employe/estado', 'LlegadaLavadorController@cambiarEstado')->name('checkin.estado');
Route::get('/loans_by_user/{id}', 'DocenteController@loans_by_user');