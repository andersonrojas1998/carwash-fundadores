<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

Route::get('/','PagesController@homeIndex');

Route::get('notifications', function () {
    return view('pages.notifications.index');
});


// For Clear cache
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
    /* php artisan cache:clear
    php artisan route:clear
    php artisan config:clear
    php artisan view:clear */
});
/*
Route::any('/{page?}',function(){
    return View::make('pages.error-pages.error-404');
})->where('page','.*');*/


Auth::routes();

Route::group(['middleware' => ['auth']], function () {    
    Route::get('/home', 'HomeController@index')->name('home');                    
    require (__DIR__ . '/rt_users.php');
    require (__DIR__ . '/rt_reports.php');
    require (__DIR__ . '/rt_product.php');
    require (__DIR__ . '/rt_buy.php');
    require (__DIR__ . '/rt_package.php');
    require (__DIR__ . '/rt_sell.php');
    require (__DIR__ . '/rt_pay.php');
    require (__DIR__ . '/rt_customer.php');
    require (__DIR__ . '/rt_loans.php');     


    Route::get('/change-password', function() {
        return view('auth.change_password');
    })->name('password.change');
    Route::post('/change-password','ChangePasswordController@update')->name('password.update');
});

