<?php

namespace App\Http\Controllers\api\pedagang;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth ;


use App\model\MakananModel;
use App\model\PemilikModel;
use App\model\PedagangModel;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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


}
