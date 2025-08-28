<?php
use App\Http\Controllers\LoanController;

Route::group(['prefix' => 'loans'], function() {
    Route::get('/', 'LoanController@index')->name('loans.index');
    Route::post('/', 'LoanController@store')->name('loans.store');
    Route::get('/{id}','LoanController@show')->name('loans.show');
    Route::get('/{id}/edit', 'LoanController@edit')->name('loans.edit');
    Route::put('/{id}', 'LoanController@update')->name('loans.update');
    Route::delete('/{id}', 'LoanController@destroy')->name('loans.destroy');
});