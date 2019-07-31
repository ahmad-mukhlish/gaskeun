<?php

namespace App\Http\Controllers\api\pedagang;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth ;


use App\model\MakananModel;
use App\model\PemilikModel;
use App\model\PedagangModel;
use App\model\PembeliModel;
use App\model\TransaksiModel;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class APIPedagangController extends Controller
{

  public function login(Request $request)
  {
    $username = $request->username;
    $password = $request->password;

    $user = PedagangModel::where('username', $username)
    ->where('password', $password)
    ->first();

    $hasil ;

    if ($user==null) {
      $hasil = array('nama' => "Password Salah") ;
    } else {
      $hasil = $user ;
    }

    return json_encode($hasil);

  }

  public function pesananOnlineGet(Request $request) {

    $listTransaksi = DB::table('tb_transaksi AS t')
    ->select('t.id_transaksi', 't.id_pembeli', 'p.nama','p.foto', 'p.no_telp','t.catatan',
    't.pre_order_status','t.alamat','t.area', 't.latitude', 't.longitude')
    ->join('tb_pembeli AS p', 't.id_pembeli', '=', 'p.id_pembeli')
    ->where('t.id_pedagang','=',$request->id_pedagang)
    ->where('t.status','=',0)
    ->get();

    foreach ($listTransaksi as $transaksi) {
      // retrive total harga and total item

      $harga = 0 ;
      $item = 0 ;

      $listDetailTransaksi = DB::table('tb_detail_transaksi')
      ->where('id_transaksi',$transaksi->id_transaksi)
      ->get();

      foreach ($listDetailTransaksi as $detailTransaksi) {

        $makanan = MakananModel::find($detailTransaksi->id_makanan) ;
        $harga += $makanan->harga * $detailTransaksi->jumlah ;
        $item  += $detailTransaksi->jumlah ;

        $transaksi->harga = $harga ;
        $transaksi->item = $item ;

      }

    }

    return json_encode($listTransaksi);

  }


  public function detailTransaksiGet(Request $request){

    $listDetailTransaksi = DB::table('tb_detail_transaksi AS d')
    ->select('m.nama', 'm.harga', 'd.jumlah')
    ->join('tb_makanan AS m', 'd.id_makanan', '=', 'm.id_makanan')
    ->where('d.id_transaksi','=',$request->id_transaksi)
    ->get();

    return json_encode($listDetailTransaksi);

  }

  public function saveTokenByIDPost(Request $request) {


    $pedagang = PedagangModel::find($request->id_pedagang) ;
    $pedagang->fcm_token = $request->fcm_token ;
    $pesan = "Terjadi kesalahan" ;

    if($pedagang->save()) {

      $pesan = "Simpan Token Berhasil" ;

    }

    return $pesan ;

  }



  public function retrieveTokenByIDGet(Request $request) {

    $pedagang = PedagangModel::find($request->id_pedagang) ;

    $hasil = "" ;

    if ($pedagang) {

      $hasil = $pedagang->fcm_token ;

    }

    return $hasil ;

  }


  public function renullTokenPost(Request $request) {


    $pedagang = PedagangModel::find($request->id_pedagang) ;
    $pedagang->fcm_token = null;
    $pesan = "Terjadi kesalahan" ;

    if($pedagang->save()) {

      $pesan = "Null Token Berhasil" ;

    }

    return $pesan ;

  }


  public function transaksiByIDGet(Request $request) {

    $listTransaksi = DB::table('tb_transaksi AS t')
    ->select('t.id_transaksi', 't.id_pembeli', 'p.nama','p.foto', 'p.no_telp','t.catatan',
    't.pre_order_status','t.alamat','t.area', 't.latitude', 't.longitude')
    ->join('tb_pembeli AS p', 't.id_pembeli', '=', 'p.id_pembeli')
    ->where('t.id_transaksi','=',$request->id_transaksi)
    ->get();

    foreach ($listTransaksi as $transaksi) {
      // retrive total harga and total item

      $harga = 0 ;
      $item = 0 ;

      $listDetailTransaksi = DB::table('tb_detail_transaksi')
      ->where('id_transaksi',$transaksi->id_transaksi)
      ->get();

      foreach ($listDetailTransaksi as $detailTransaksi) {

        $makanan = MakananModel::find($detailTransaksi->id_makanan) ;
        $harga += $makanan->harga * $detailTransaksi->jumlah ;
        $item  += $detailTransaksi->jumlah ;

        $transaksi->harga = $harga ;
        $transaksi->item = $item ;

      }

    }

    return json_encode($listTransaksi[0]);

  }

  public function notifDekatPost(Request $request) {

    $optionBuilder = new OptionsBuilder();
    $optionBuilder->setTimeToLive(60*20);

    $pedagang = PedagangModel::find($request->id_pedagang);


    $notificationBuilder = new PayloadNotificationBuilder($pedagang->nama." Sudah Dekat");


    $notificationBuilder->setBody("Pedagang ".$pedagang->jenis." Mendekat")
    ->setSound('default')
    ->setIcon('ic_stat_name');

    $dataBuilder = new PayloadDataBuilder();
    $dataBuilder->addData(['id_transaksi' => $request->id_transaksi, 'jenis' => 'dekat']);

    $option = $optionBuilder->build();
    $notification = $notificationBuilder->build();
    $data = $dataBuilder->build();

    $pembeli = PembeliModel::find($request->id_pembeli);

    $token = $pembeli->fcm_token ;

    $hasil = "Pendekatan berhasil di notif" ;

    if ($token == null) {
      $hasil = "Pembeli tidak tersedia (Token pedagang tidak tersedia)" ;
    } else
    {
      $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
    }

    return $hasil;

  }

  public function notifSelesaiPost(Request $request) {

    $optionBuilder = new OptionsBuilder();
    $optionBuilder->setTimeToLive(60*20);



    $notificationBuilder = new PayloadNotificationBuilder("Transaksi Selesai");

    $pedagang = PedagangModel::find($request->id_pedagang);

    $notificationBuilder->setBody("Terimakasih Telah Membeli")
    ->setSound('default')
    ->setIcon('ic_stat_name');

    $dataBuilder = new PayloadDataBuilder();
    $dataBuilder->addData(['id_transaksi' => $request->id_transaksi, 'id_pedagang'=> $pedagang->id_pedagang,
    'jenis' => 'selesai']);

    $option = $optionBuilder->build();
    $notification = $notificationBuilder->build();
    $data = $dataBuilder->build();

    $pembeli = PembeliModel::find($request->id_pembeli);

    $token = $pembeli->fcm_token ;

    $hasil = "Penyelesaian berhasil di notif" ;

    if ($token == null) {
      $hasil = "Pembeli tidak tersedia (Token pedagang tidak tersedia)" ;
    } else
    {
      $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
    }

    return $hasil;

  }


  public function updateTransaksiPost(Request $request) {

    $hasil = "Terjadi kesalahan" ;

    $transaksi = TransaksiModel::find($request->id_transaksi);
    $transaksi->cuaca = $request->cuaca ;
    $transaksi->status = 1 ;
    if ($transaksi->save()) {

      $hasil = "Transaksi berhasi diupdate" ;

    }

    return $hasil ;

  }

  public function rekomendasiAreaGet(Request $request) {

    $listRekomendasi = DB::table('tb_transaksi AS t')
    ->select(DB::raw('t.area, SUM(d.jumlah * m.harga) pendapatan'))
    ->join('tb_pedagang AS p', 't.id_pedagang', '=', 'p.id_pedagang')
    ->join('tb_detail_transaksi AS d', 't.id_transaksi', '=', 'd.id_transaksi')
    ->join('tb_makanan AS m', 'd.id_makanan', '=', 'm.id_makanan')
    ->where('t.status','=',1)
    ->where('t.tanggal','=',$request->tanggal)
    ->where('t.id_pedagang','=',$request->id_pedagang)
    ->groupBy('t.area')
    ->orderBy('pendapatan', 'desc')
    ->get();

    return json_encode($listRekomendasi);


  }

}
