<?php

namespace App\Http\Controllers\web;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth ;

use App\model\PedagangModel;
use App\model\PemilikModel;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PemilikController extends Controller
{

  public function index(Request $request)
  {
    if ($request->session()->has('username')) {

      $listPedagang  = DB::table('tb_pedagang')
      ->where('id_pemilik',$request->session()->get('id_pemilik'))
      ->get();

      return view('pemilik.DashboardView')
      ->with('nama',$request->session()->get('username'))
      ->with('listPedagang',$listPedagang);

    } else {
      return redirect('/login');
    }
  }


  public function rekomendasiBahanGet(Request $request) {

    // $hariIni = $this->operasiRugiUntung(
    //   $this->getMakananTerjualHariIni($request->tanggal_hari_ini,$request->id_pemilik),
    //   $this->getMakananTerjualKemarin($request->tanggal_kemarin,$request->id_pemilik)
    // );
    //
    $hariIni = $this->getMakananTerjualHariIni($request->tanggal_hari_ini,$request->id_pemilik) ;
    // //
    // $hariIni = $this->getMakananTerjualKemarin($request->tanggal_kemarin,$request->id_pemilik) ;

    return json_encode($hariIni);

  }

  private function getMakananTerjualHariIni($tanggalHariIni, $idPemilik) {

    $hariIniFromDB = DB::table('tb_transaksi AS t')
    ->select(DB::raw('m.id_makanan, m.nama makanan, SUM(d.jumlah) jumlah'))
    ->join('tb_detail_transaksi AS d', 't.id_transaksi', '=', 'd.id_transaksi')
    ->join('tb_makanan AS m', 'd.id_makanan', '=', 'm.id_makanan')
    ->join('tb_pemilik AS p', 'm.id_pemilik', '=', 'p.id_pemilik')
    ->where('t.status','=',1)
    ->where('t.tanggal','=',$tanggalHariIni)
    ->where('p.id_pemilik','=',$idPemilik)
    ->groupBy('m.id_makanan')
    ->get();


    $listMakanan = DB::table('tb_makanan AS m')
    ->select('m.id_makanan','m.nama')
    ->where('m.id_pemilik',$idPemilik)
    ->get();

    foreach ($listMakanan as $makananNow)
    {
      $makananNow->jumlah = 0 ;
      foreach ($hariIniFromDB as $makananHariIniNow)
      {
        if ($makananNow->id_makanan == $makananHariIniNow->id_makanan)
        {
          $makananNow->jumlah = $makananHariIniNow->jumlah ;
        }
      }
    }

    return $listMakanan;

  }

  private function getMakananTerjualKemarin($tanggalKemarin, $idPemilik) {

    $kemarinFromDB = DB::table('tb_transaksi AS t')
    ->select(DB::raw('m.id_makanan, m.nama makanan, SUM(d.jumlah) jumlah'))
    ->join('tb_detail_transaksi AS d', 't.id_transaksi', '=', 'd.id_transaksi')
    ->join('tb_makanan AS m', 'd.id_makanan', '=', 'm.id_makanan')
    ->join('tb_pemilik AS p', 'm.id_pemilik', '=', 'p.id_pemilik')
    ->where('t.status','=',1)
    ->where('t.tanggal','=',$tanggalKemarin)
    ->where('p.id_pemilik','=',$idPemilik)
    ->groupBy('m.id_makanan')
    ->get();


    $listMakanan = DB::table('tb_makanan AS m')
    ->select('m.id_makanan','m.nama')
    ->where('m.id_pemilik',$idPemilik)
    ->get();

    foreach ($listMakanan as $makananNow)
    {
      $makananNow->jumlah = 0 ;
      foreach ($kemarinFromDB as $makananKemarinNow)
      {
        if ($makananNow->id_makanan == $makananKemarinNow->id_makanan)
        {
          $makananNow->jumlah = $makananKemarinNow->jumlah ;
        }
      }
    }

    return $listMakanan;

  }

  private function operasiRugiUntung($listMakananTerjualHariIni, $listMakananTerjualKemarin) {

    foreach ($listMakananTerjualHariIni as $makananHariIniNow) {

      foreach ($listMakananTerjualKemarin as $makananKemarinNow) {

        if ($makananHariIniNow->id_makanan == $makananKemarinNow->id_makanan)
        {

          //untung
          if ($makananHariIniNow->jumlah > $makananKemarinNow->jumlah)
          {
            $makananHariIniNow->jumlah++ ;
          }
          //rugi
          else if ($makananHariIniNow->jumlah < $makananKemarinNow->jumlah)
          {
            if ($makananHariIniNow->jumlah != 0)
            {$makananHariIniNow->jumlah-- ;}
          }

        }

      }

    }

    return $listMakananTerjualHariIni;

  }


  public function getLaporanPenjualan() {

  }


  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->forget('username');
    $request->session()->forget('id_pemilik');
    $request->session()->flush();

    return redirect ('/');
  }



}
