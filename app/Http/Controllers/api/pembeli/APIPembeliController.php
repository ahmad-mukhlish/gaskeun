<?php

namespace App\Http\Controllers\api\pembeli;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth ;


use App\model\PembeliModel;
use App\model\TransaksiModel;
use App\model\DetailTransaksiModel;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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


    $pesan = "Pesanan Berhasil Diterima" ;

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
      }
    }
    else {
      $pesan = "Terjadi Kesalahan";
    }


    return $pesan ;

  }


}
