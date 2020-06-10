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

Route::get('register', function () {
    return view('auth/register');
});

Route::get('login', function () {
    return view('auth/login');
});

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::post('login', 'UserController@login')->name('login');
Route::post('register', 'UserController@register')->name('register');
Route::get('logout', 'UserController@logout');

Route::get('treatment', 'TreatmentController@index')->name('treatment');
Route::get('invoice', 'InvoiceController@index')->name('invoice');
Route::get('/home', 'HomeController@index')->name('home');
