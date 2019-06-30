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
Route::get('/', 'web\PemilikController@index');
Route::get('/logout', 'web\PemilikController@logout');

Route::get('/login', 'web\LoginController@index');
Route::post('/loginPost', 'web\LoginController@loginPost');

Route::get('/register', 'web\RegisterController@index');
Route::post('/registerPost', 'web\RegisterController@registerPost');

Route::get('/profil', 'web\ProfilController@index');
Route::post('/profilPost', 'web\ProfilController@profilPost');

Route::get('/pedagang', 'web\PedagangController@index');
Route::get('/addPedagang', 'web\PedagangController@addPedagang');
Route::post('/addPedagangPost', 'web\PedagangController@addPedagangPost');
Route::get('/editPedagang/{id}', 'web\PedagangController@editPedagang');
Route::post('/editPedagangPost', 'web\PedagangController@editPedagangPost');
Route::post('/deletePedagangPost', 'web\PedagangController@deletePedagangPost');
Route::post('/cekUsername', 'web\PedagangController@cekUsername');
Route::post('/cekEmail', 'web\PedagangController@cekEmail');

Route::get('/makanan', 'web\MakananController@index');

Route::post('/registerFireBase', 'firebase\FirebaseController@registerFireBase');
Route::post('/addPedagangFireBase', 'firebase\FirebaseController@addPedagangFireBase');

Route::post('/api/pedagang/login', 'api\pedagang\APIPedagangController@login');
