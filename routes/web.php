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
Route::get('/dashboard', 'WebController@dashboard')->name('dashboard');
Route::post('/loginPost', 'WebController@loginPost');
Route::post('/registerPost', 'WebController@registerPost');
Route::post('/profilPost', 'WebController@profilPost');
Route::get('/register', 'WebController@register');
Route::get('/profil', 'WebController@profil');
Route::get('/pedagang', 'WebController@pedagang');
Route::get('/makanan', 'WebController@makanan');
Route::get('/logout', 'WebController@logout');
