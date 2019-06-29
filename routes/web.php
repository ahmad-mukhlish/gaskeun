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
Route::get('/', 'DashboardController@index');
Route::get('/logout', 'DashboardController@logout');


Route::get('/login', 'LoginController@index');
Route::post('/loginPost', 'LoginController@loginPost');

Route::get('/register', 'RegisterController@index');
Route::post('/registerPost', 'RegisterController@registerPost');

Route::get('/profil', 'ProfilController@index');
Route::post('/profilPost', 'ProfilController@profilPost');


Route::get('/pedagang', 'PedagangController@index');
Route::get('/addPedagang', 'PedagangController@addPedagang');
Route::post('/addPedagangPost', 'PedagangController@addPedagangPost');
Route::get('/editPedagang/{id}', 'PedagangController@editPedagang');
Route::post('/editPedagangPost', 'PedagangController@editPedagangPost');
Route::post('/deletePedagangPost', 'PedagangController@deletePedagangPost');
Route::post('/cekUsername', 'PedagangController@cekUsername');
Route::post('/cekEmail', 'PedagangController@cekEmail');



Route::get('/makanan', 'WebController@makanan');


Route::post('/registerFireBase', 'firebase\FirebaseController@registerFireBase');
Route::post('/addPedagangFireBase', 'firebase\FirebaseController@addPedagangFireBase');

Route::post('/loginAPI', 'APIController@loginAPI');
