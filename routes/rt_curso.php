<?php
Route::group(['prefix' => 'cursos'], function(){
    Route::get('inicio', 'CursosController@index'); 
    Route::get('grado/{id}', 'CursosController@listCourse'); 
    Route::post('addCourseGrade', 'CursosController@addCourseGrade'); 
});