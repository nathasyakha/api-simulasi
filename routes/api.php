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

Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');

Route::group(['middleware' => 'auth:api'], function () {

    Route::put('user/update', 'UserController@update')->name('user.update');
    Route::post('detail', 'UserController@details')->name('user.detail');
    Route::delete('user/delete', 'UserController@destroy')->name('user.destroy');
    Route::post('logout', 'UserController@logout');

    Route::get('treatment', 'TreatmentController@index')->name('treatment.index');
    Route::get('treatment/edit/{id}', 'TreatmentController@edit')->name('treatment.edit');
    Route::post('treatment', 'TreatmentController@store')->name('treatment.store');
    Route::post('treatment/update/{id}', 'TreatmentController@update')->name('treatment.update');
    Route::delete('treatment/delete/{id}', 'TreatmentController@destroy')->name('treatment.destroy');

    Route::get('invoice', 'InvoiceController@index')->name('invoice.index');
    Route::get('invoice/edit/{id}', 'InvoiceController@show')->name('invoice.show');
    Route::post('invoice', 'InvoiceController@store')->name('invoice.store');
    Route::put('invoice/update/{id}', 'InvoiceController@update')->name('invoice.update');
    Route::delete('invoice/delete/{id}', 'InvoiceController@destroy')->name('invoice.destroy');
});
