<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'namespace' => 'Drivers',
    'prefix' => 'auth/drivers'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('verify', 'AuthController@verify');

});

Route::group([

    'middleware' => 'auth:driver',
    'namespace' => 'Drivers',
    'prefix' => 'driver'

], function ($router) {
    Route::get('get-profile', 'DriverController@getProfile');
    Route::put('edit-profile', 'DriverController@editProfile');
    Route::put('push-notifications', 'DriverController@setStatus');
    Route::get('orders', 'DriverController@getOrders');
    Route::put('order-confirm', 'DriverController@orderConfirm');
    Route::post('refresh-token', 'AuthController@refresh');
    Route::post('devices', 'DriverController@saveTokenDevices');
    Route::post('logout', 'AuthController@logout');
    Route::get('support', 'DriverController@getSupport');

});

Route::group([

    'middleware' => 'api',
    'namespace' => 'Customers',
    'prefix' => 'auth/customers'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('registration', 'AuthController@registration');
    Route::post('verify', 'AuthController@verify');
});


Route::group([

    'middleware' => 'auth:customer',
    'namespace' => 'Customers',
    'prefix' => 'customer'

], function ($router) {

    Route::get('customer-type', 'CustomerController@getTypeCustomer');
    Route::put('provide-info-customer', 'CustomerController@signUpCustomer');
    Route::put('provide-info-service-provider', 'CustomerController@signUpServiceProvider');
    Route::get('get-profile', 'CustomerController@getProfile');
    Route::put('edit-profile', 'CustomerController@editProfile');
    Route::put('create-order', 'CustomerController@setOrders');
    Route::get('check-drivers-around', 'CustomerController@checkDriversAround');
    Route::get('support', 'CustomerController@getSupport');
    Route::put('push-notifications', 'CustomerController@changePushNotifications');
    Route::post('refresh-token', 'AuthController@refresh');
    Route::post('devices', 'CustomerController@saveTokenDevices');
    Route::post('logout', 'AuthController@logout');
    Route::put('reject', 'CustomerController@rejectNotifications');

});
