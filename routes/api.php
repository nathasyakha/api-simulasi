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

Route::group(['middleware' => 'auth:api'], function () {

    Route::put('user/update', 'UserController@update')->name('user.update');
    Route::post('detail', 'UserController@details')->name('user.detail');
    Route::delete('user/delete', 'UserController@destroy')->name('user.destroy');
    Route::post('logout', 'UserController@logout');

    Route::get('treatment_price', 'TreatmentPriceController@index')->name('treatprice.index');
    Route::get('treatment_price/edit/{id}', 'TreatmentPriceController@edit')->name('treatprice.edit');
    Route::post('treatment_price', 'TreatmentPriceController@store')->name('treatprice.store');
    Route::put('treatment_price/update/{id}', 'TreatmentPriceController@update')->name('treatprice.update');
    Route::delete('treatment_price/delete/{id}', 'TreatmentPriceController@destroy')->name('treatprice.destroy');

    Route::get('treatment_type', 'TreatmentTypeController@index')->name('treattype.index');
    Route::get('treatment_type/edit/{id}', 'TreatmentTypeController@edit')->name('treattype.edit');
    Route::post('treatment_type', 'TreatmentTypeController@store')->name('treattype.store');
    Route::put('treatment_type/update/{id}', 'TreatmentTypeController@update')->name('treattype.update');
    Route::delete('treatment_type/delete/{id}', 'TreatmentTypeController@destroy')->name('treattype.destroy');

    Route::get('transact', 'TransactController@index')->name('transact.index');
    Route::get('transact/edit/{id}', 'TransactController@edit')->name('transact.edit');
    Route::post('transact', 'TransactController@store')->name('transact.store');
    Route::put('transact/update/{id}', 'TransactController@update')->name('transact.update');
    Route::delete('transact/delete/{id}', 'TransactController@destroy')->name('transact.destroy');

    Route::get('detail_transact', 'DetailTransactController@index')->name('detail_transact.index');
    Route::get('detail_transact/edit/{id}', 'DetailTransactController@edit')->name('detail_transact.edit');
    Route::post('detail_transact', 'DetailTransactController@store')->name('detail_transact.store');
    Route::put('detail_transact/update/{id}', 'DetailTransactController@update')->name('detail_transact.update');
    Route::delete('detail_transact/delete/{id}', 'DetailTransactController@destroy')->name('detail_transact.destroy');
});
