<?php

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

Route::get('/', 'WebController@index');
Route::get('/home', 'WebController@home')->name('home');
Route::post('/loginPost', 'WebController@loginPost');
Route::post('/registerPost', 'WebController@registerPost');
Route::get('/register', 'WebController@register');