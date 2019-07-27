<?php

namespace App\Http\Controllers\api\pembeli;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth ;


use App\model\PembeliModel;
use App\model\PedagangModel;
use App\model\TransaksiModel;
use App\model\DetailTransaksiModel;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class APIPembeliController extends Controller
{

  public function login(Request $request)
  {
    $username = $request->username;
    $password = $request->password;

    $user = PembeliModel::where('username', $username)
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

  public function pilihanPedagangGet(Request $request)
  {
    $listPedagang = DB::table('tb_pedagang')->get();

    return json_encode($listPedagang);

  }

  public function makananPedagangGet(Request $request) {

    $listMakanan = DB::table('tb_makanan AS m')
    ->select('m.id_makanan', 'm.nama', 'm.foto','m.harga', 'm.deskripsi','m.id_pemilik')
    ->join('tb_dagangan AS d', 'm.id_makanan', '=', 'd.id_makanan')
    ->join('tb_pedagang AS p', 'd.id_pedagang', '=', 'p.id_pedagang')
    ->where('p.id_pedagang','=',$request->id_pedagang)
    ->get();

    return json_encode($listMakanan);

  }

  public function pesanPedagangBerkelilingPost(Request $request) {


    $pesan = "" ;

    $transaksi = new TransaksiModel;
    $transaksi->id_pembeli = $request->id_pembeli;
    $transaksi->id_pedagang = $request->id_pedagang;
    $transaksi->catatan = $request->catatan;
    $transaksi->alamat = $request->alamat;
    $transaksi->area = $request->area;
    $transaksi->latitude = $request->latitude;
    $transaksi->longitude = $request->longitude;
    $transaksi->tanggal = $request->tanggal;
    $transaksi->status = 0;
    $transaksi->pre_order_status = 0;

    //if insertion is success
    if($transaksi->save())
    {

      $listPesanan = json_decode($request->listPesanan, TRUE);
      foreach ($listPesanan as $pesanan) {

        $detail = new DetailTransaksiModel;
        $detail->id_makanan = $pesanan["id_makanan"] ;
        $detail->id_transaksi = $transaksi->id_transaksi;
        $detail->jumlah = $pesanan["jumlah"] ;
        $detail->save();
        $pesan = $transaksi->id_transaksi;
      }
    }
    else {
      $pesan = "Terjadi Kesalahan";
    }


    return $pesan ;

  }

  public function saveTokenByIDPost(Request $request) {


    $pembeli = PembeliModel::find($request->id_pembeli) ;
    $pembeli->fcm_token = $request->fcm_token ;
    $pesan = "Terjadi kesalahan" ;

    if($pembeli->save()) {

      $pesan = "Simpan Token Berhasil" ;

    }

    return $pesan ;

  }



  public function retrieveTokenByIDGet(Request $request) {

    $pembeli = PembeliModel::find($request->id_pembeli) ;

    $hasil = "" ;

    if ($pembeli) {

      $hasil = $pembeli->fcm_token ;

    }

    return $hasil ;

  }

  public function notifPesanPost(Request $request) {

    $optionBuilder = new OptionsBuilder();
    $optionBuilder->setTimeToLive(60*20);

    $notificationBuilder = new PayloadNotificationBuilder('Pesanan baru!');
    $notificationBuilder->setBody("Pesanan di ".$request->area.
    " senilai Rp.".$request->nilai)
    ->setSound('default')
    ->setIcon('ic_stat_name');

    $dataBuilder = new PayloadDataBuilder();
    $dataBuilder->addData(['id_transaksi' => $request->id_transaksi]);

    $option = $optionBuilder->build();
    $notification = $notificationBuilder->build();
    $data = $dataBuilder->build();

    $pedagang = PedagangModel::find($request->id_pedagang);

    $token = $pedagang->fcm_token ;

    $hasil = "Pesanan berhasil di notif" ;

    if ($token == null) {
      $hasil = "Pedagang tidak tersedia (Token pedagang tidak tersedia)" ;
    } else
    {
      $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);
    }

    return $hasil;

  }


  public function transaksiByIDGet(Request $request){

    $transaksi = DB::table('tb_transaksi AS t')
    ->select('t.id_transaksi','t.latitude', 't.longitude', 'pem.id_pemilik',
    'ped.id_pedagang', 'ped.nama', 'ped.no_telp','t.catatan')
    ->join('tb_pedagang AS ped', 't.id_pedagang', '=', 'ped.id_pedagang')
    ->join('tb_pemilik AS pem', 'ped.id_pemilik', '=', 'pem.id_pemilik')
    ->where('t.id_transaksi','=',$request->id_transaksi)
    ->get();

    return json_encode($transaksi[0]);

  }


  public function detailTransaksiGet(Request $request){

    $listDetailTransaksi = DB::table('tb_detail_transaksi AS d')
    ->select('m.nama', 'm.harga', 'd.jumlah')
    ->join('tb_makanan AS m', 'd.id_makanan', '=', 'm.id_makanan')
    ->where('d.id_transaksi','=',$request->id_transaksi)
    ->get();

    return json_encode($listDetailTransaksi);

  }





}
