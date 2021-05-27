<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::group(['prefix'=>'admin', 'middleware'=>'auth:web'], function(){
    Route::get('profile', 'UserController@index')->name('users.index');
    Route::get('profile/edit', 'UserController@edit')->name('users.edit');
    Route::post('profile', 'UserController@store')->name('users.store');
    Route::get('dashboard', 'AdminPanelController@index')
        ->name('dashboard');

    Route::post('change-password', 'UserController@changePassword')->name('change.password');

    Route::resource('drivers', 'DriverController');
    Route::resource('customers', 'CustomerController');
    Route::resource('service-providers', 'ServiceProviderController');
    Route::resource('orders', 'OrderController');

});

Route::group(['prefix'=>'admin', 'middleware'=>['auth:web', 'can:super-admin']], function(){
    Route::resource('administrators', 'AdministratorController');
    Route::resource('companies', 'CompaniesController');
});

Route::group([
    'middleware' => 'auth:web'
], function () {

    if (false === config('admin.auth.custom')) {
        Route::get('logout', 'Auth\LoginController@logout')->name('logout');
    }
});
