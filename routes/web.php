<?php

Route::get('/', 'web\PemilikController@index');
Route::get('/logout', 'web\PemilikController@logout');

Route::get('/login', 'web\LoginController@index');
Route::post('/loginPost', 'web\LoginController@loginPost');

Route::get('/register', 'web\RegisterController@index');
Route::post('/registerPost', 'web\RegisterController@registerPost');

Route::get('/profil', 'web\ProfilController@index');
Route::post('/profilPost', 'web\ProfilController@profilPost');
Route::post('/rekomendasiBahanDanMakananPost', 'web\PemilikController@rekomendasiBahanDanMakananPost');


Route::get('/pedagang', 'web\PedagangController@index');
Route::get('/addPedagang', 'web\PedagangController@addPedagang');
Route::post('/addPedagangPost', 'web\PedagangController@addPedagangPost');
Route::get('/editPedagang/{id_pedagang}', 'web\PedagangController@editPedagang');
Route::post('/editPedagangPost', 'web\PedagangController@editPedagangPost');
Route::post('/deletePedagangPost', 'web\PedagangController@deletePedagangPost');
Route::post('/cekUsername', 'web\PedagangController@cekUsername');
Route::post('/cekEmail', 'web\PedagangController@cekEmail');

Route::get('/makanan', 'web\MakananController@index');

Route::get('/bahan', 'web\BahanController@index');

Route::post('/registerFireBase', 'firebase\FirebaseController@registerFireBase');
Route::post('/addPedagangFireBase', 'firebase\FirebaseController@addPedagangFireBase');

Route::post('/api/pedagang/login', 'api\pedagang\APIPedagangController@login');
Route::get('/api/pedagang/pesananOnlineGet/{id_pedagang}', 'api\pedagang\APIPedagangController@pesananOnlineGet');
Route::get('/api/pedagang/detailTransaksiGet/{id_transaksi}', 'api\pedagang\APIPedagangController@detailTransaksiGet');
Route::get('/api/pedagang/retrieveTokenByIDGet/{id_pedagang}', 'api\pedagang\APIPedagangController@retrieveTokenByIDGet');
Route::post('/api/pedagang/saveTokenByIDPost', 'api\pedagang\APIPedagangController@saveTokenByIDPost');
Route::post('/api/pedagang/renullTokenPost', 'api\pedagang\APIPedagangController@renullTokenPost');
Route::get('/api/pedagang/transaksiByIDGet/{id_transaksi}', 'api\pedagang\APIPedagangController@transaksiByIDGet');
Route::post('/api/pedagang/notifDekatPost', 'api\pedagang\APIPedagangController@notifDekatPost');
Route::post('/api/pedagang/notifSelesaiPost', 'api\pedagang\APIPedagangController@notifSelesaiPost');
Route::post('/api/pedagang/updateTransaksiPost', 'api\pedagang\APIPedagangController@updateTransaksiPost');
Route::get('/api/pedagang/rekomendasiAreaGet/{tanggal}/{id_pedagang}', 'api\pedagang\APIPedagangController@rekomendasiAreaGet');



Route::post('/api/pembeli/login', 'api\pembeli\APIPembeliController@login');
Route::get('/api/pembeli/pilihanPedagangGet', 'api\pembeli\APIPembeliController@pilihanPedagangGet');
Route::get('/api/pembeli/makananPedagangGet/{id_pedagang}', 'api\pembeli\APIPembeliController@makananPedagangGet');
Route::post('/api/pembeli/pesanPedagangBerkelilingPost', 'api\pembeli\APIPembeliController@pesanPedagangBerkelilingPost');
Route::get('/api/pembeli/retrieveTokenByIDGet/{id_pembeli}', 'api\pembeli\APIPembeliController@retrieveTokenByIDGet');
Route::post('/api/pembeli/saveTokenByIDPost', 'api\pembeli\APIPembeliController@saveTokenByIDPost');
Route::post('/api/pembeli/notifPesanPost', 'api\pembeli\APIPembeliController@notifPesanPost');
Route::get('/api/pembeli/transaksiByIDGet/{id_transaksi}', 'api\pembeli\APIPembeliController@transaksiByIDGet');
Route::get('/api/pembeli/detailTransaksiGet/{id_transaksi}', 'api\pembeli\APIPembeliController@detailTransaksiGet');
Route::post('/api/pembeli/ratingPedagangPost', 'api\pembeli\APIPembeliController@ratingPedagangPost');
Route::get('/api/pembeli/pedagangByIDGet/{id_pedagang}', 'api\pembeli\APIPembeliController@pedagangByIDGet');
Route::post('/api/pembeli/subscribePost', 'api\pembeli\APIPembeliController@subscribePost');
Route::post('/api/pembeli/notifSubscribePost', 'api\pembeli\APIPembeliController@notifSubscribePost');
Route::get('/api/pembeli/cekSubscribeGet/{id_pedagang}/{id_pembeli}', 'api\pembeli\APIPembeliController@cekSubscribeGet');
Route::post('/api/pembeli/deleteTransaksiPost', 'api\pembeli\APIPembeliController@deleteTransaksiPost');
Route::post('/api/pembeli/notifDeleteTransaksiPost', 'api\pembeli\APIPembeliController@notifDeleteTransaksiPost');
Route::post('/api/pembeli/registerPembeliPost', 'api\pembeli\APIPembeliController@registerPembeliPost');
Route::get('/api/pembeli/profilGet/{id_pembeli}', 'api\pembeli\APIPembeliController@profilGet');
