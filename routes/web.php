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
    return view('welcome');
});

Route::get('login', function () {
    return view('auth/login');
});
Route::post('login', 'UserController@login')->name('login');
// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');


Route::get('logout', 'UserController@logout');

Route::get('treatment_price', 'TreatmentPriceController@index')->name('treatprice');
Route::get('treatment_type', 'TreatmentTypeController@index')->name('treattype');
Route::get('transact', 'TransactController@index')->name('transact');
Route::get('detail_transact', 'DetailTransactController@index')->name('detail_transact');
Route::get('/home', 'HomeController@index')->name('home');
