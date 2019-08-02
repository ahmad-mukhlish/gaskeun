<?php

namespace App\Http\Controllers\web;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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

      $listMakanan  = DB::table('tb_makanan')
      ->where('id_pemilik',$request->session()->get('id_pemilik'))
      ->get();

      $listBahan  = DB::table('tb_bahan')
      ->where('id_pemilik',$request->session()->get('id_pemilik'))
      ->get();

      return view('pemilik.DashboardView')
      ->with('nama',$request->session()->get('username'))
      ->with('listPedagang',$listPedagang)
      ->with('listMakanan',$listMakanan)
      ->with('listBahan',$listBahan);

    } else {
      return redirect('/login');
    }
  }


  public function rekomendasiBahanDanMakananPost(Request $request) {


    $tanggal = $request->tanggal ;
    $tanggalKemarin = date('Y-m-d', strtotime($tanggal .' -1 day'));
    $tanggalBesok = date('Y-m-d', strtotime($tanggal .' +1 day'));



    // $hariIni = $this->getMakananTerjualKemarin($tanggalKemarin,$request->id_pemilik) ;
    // $hariIni = $this->getMakananTerjualHariIni($tanggal,$request->id_pemilik) ;

    // $hariIni = $this->operasiRugiUntung(
    // $this->getMakananTerjualHariIni($tanggal,$request->id_pemilik),
    // $this->getMakananTerjualKemarin($tanggalKemarin,$request->id_pemilik)
    // ) ;

    // $hariIni = $this->getPreOrderMakananList($tanggalBesok, $request->id_pemilik) ;

    // $hariIni = $this->getMakananBesokFix(
    //
    //   $this->operasiRugiUntung(
    //     $this->getMakananTerjualHariIni($tanggal,$request->id_pemilik),
    //     $this->getMakananTerjualKemarin($tanggalKemarin,$request->id_pemilik)
    //   ),
    //
    //   $hariIni = $this->getPreOrderMakananList($tanggalBesok, $request->id_pemilik)
    //
    //   ) ;

    // $hariIni = $this->getPersentaseHujan($request->id_pemilik);

    // $hariIni = $this->getCuacaBesok($request->latitude, $request->longitude) ;
    //

    $rekomedasiMakanan = $this->operasiCuacaBesok($this->getMakananBesokFix(

      $this->operasiRugiUntung(
        $this->getMakananTerjualHariIni($tanggal,$request->id_pemilik),
        $this->getMakananTerjualKemarin($tanggalKemarin,$request->id_pemilik)
      ),

      $this->getPreOrderMakananList($tanggalBesok, $request->id_pemilik)

    ),
    $this->getCuacaBesok($request->latitude, $request->longitude),
    $this->getPersentaseHujan($request->id_pemilik)
    ) ;



    $rekomendasiBahan = $this->getRekomendasiBahan
    (
      $this->getBahanPerMakanan
      (
        $this->operasiCuacaBesok
        (
          $this->getMakananBesokFix
          (
            $this->operasiRugiUntung
            (
              $this->getMakananTerjualHariIni($tanggal,$request->id_pemilik),
              $this->getMakananTerjualKemarin($tanggalKemarin,$request->id_pemilik)
            ),
            $this->getPreOrderMakananList($tanggalBesok, $request->id_pemilik)
          ),
          $this->getCuacaBesok($request->latitude, $request->longitude),
          $this->getPersentaseHujan($request->id_pemilik)
        ),
        $request->id_pemilik
      ),
      $request->id_pemilik) ;

      $rekomendasi =  array('makanan' => $rekomedasiMakanan, 'bahan' => $rekomendasiBahan);

    return json_encode($rekomendasi) ;

  }

  private function getMakananTerjualHariIni($tanggalHariIni, $idPemilik) {

    $hariIniFromDB = DB::table('tb_transaksi AS t')
    ->select(DB::raw('m.id_makanan, m.nama makanan, SUM(d.jumlah) jumlah','m.harga'))
    ->join('tb_detail_transaksi AS d', 't.id_transaksi', '=', 'd.id_transaksi')
    ->join('tb_makanan AS m', 'd.id_makanan', '=', 'm.id_makanan')
    ->join('tb_pemilik AS p', 'm.id_pemilik', '=', 'p.id_pemilik')
    ->where('t.status','=',1)
    ->where('t.tanggal','=',$tanggalHariIni)
    ->where('p.id_pemilik','=',$idPemilik)
    ->groupBy('m.id_makanan')
    ->get();


    $listMakanan = DB::table('tb_makanan AS m')
    ->select('m.id_makanan','m.nama','m.harga')
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
    ->select(DB::raw('m.id_makanan, m.nama makanan, SUM(d.jumlah) jumlah','m.harga'))
    ->join('tb_detail_transaksi AS d', 't.id_transaksi', '=', 'd.id_transaksi')
    ->join('tb_makanan AS m', 'd.id_makanan', '=', 'm.id_makanan')
    ->join('tb_pemilik AS p', 'm.id_pemilik', '=', 'p.id_pemilik')
    ->where('t.status','=',1)
    ->where('t.tanggal','=',$tanggalKemarin)
    ->where('p.id_pemilik','=',$idPemilik)
    ->groupBy('m.id_makanan')
    ->get();


    $listMakanan = DB::table('tb_makanan AS m')
    ->select('m.id_makanan','m.nama','m.harga')
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

  public function getPreOrderMakananList($tanggalBesok,$idPemilik) {

    $preOrderFromDB = DB::table('tb_transaksi AS t')
    ->select(DB::raw('m.id_makanan, m.nama makanan, SUM(d.jumlah) jumlah','m.harga'))
    ->join('tb_detail_transaksi AS d', 't.id_transaksi', '=', 'd.id_transaksi')
    ->join('tb_makanan AS m', 'd.id_makanan', '=', 'm.id_makanan')
    ->join('tb_pemilik AS p', 'm.id_pemilik', '=', 'p.id_pemilik')
    ->where('t.pre_order_status','=',1)
    ->where('t.tanggal','=',$tanggalBesok)
    ->where('p.id_pemilik','=',$idPemilik)
    ->groupBy('m.id_makanan')
    ->get();


    $listMakanan = DB::table('tb_makanan AS m')
    ->select('m.id_makanan','m.nama','m.harga')
    ->where('m.id_pemilik',$idPemilik)
    ->get();

    foreach ($listMakanan as $makananNow)
    {
      $makananNow->jumlah = 0 ;
      foreach ($preOrderFromDB as $preOrderNow)
      {
        if ($makananNow->id_makanan == $preOrderNow->id_makanan)
        {
          $makananNow->jumlah = $preOrderNow->jumlah ;
        }
      }
    }

    return $listMakanan;

  }

  public function getMakananBesokFix($listMakananUntungRugi, $listMakananPreOrder) {

    foreach ($listMakananUntungRugi as $makananUntungRugiNow)
    {

      foreach ($listMakananPreOrder as $makananPreOrderNow)
      {

        if ($makananUntungRugiNow->id_makanan == $makananPreOrderNow->id_makanan)

        {
          $makananUntungRugiNow->jumlah += $makananPreOrderNow->jumlah ;
        }

      }

    }

    return $listMakananUntungRugi ;


  }

  public function getPersentaseHujan($idPemilik) {

    $tidakHujanFromDB = DB::table('tb_transaksi AS t')
    ->select(DB::raw('COUNT(id_transaksi) jumlah_transaksi_tidak_hujan'))
    ->join('tb_pedagang AS ped', 't.id_pedagang', '=', 'ped.id_pedagang')
    ->join('tb_pemilik AS pem', 'ped.id_pemilik', '=', 'pem.id_pemilik')
    ->where('t.status','=',1)
    ->where('t.cuaca','=',"tidak hujan")
    ->where('pem.id_pemilik','=',$idPemilik)
    ->get();

    $tidakHujan = $tidakHujanFromDB[0]->jumlah_transaksi_tidak_hujan ;

    $hujanFromDB = DB::table('tb_transaksi AS t')
    ->select(DB::raw('COUNT(id_transaksi) jumlah_transaksi_hujan'))
    ->join('tb_pedagang AS ped', 't.id_pedagang', '=', 'ped.id_pedagang')
    ->join('tb_pemilik AS pem', 'ped.id_pemilik', '=', 'pem.id_pemilik')
    ->where('t.status','=',1)
    ->where('t.cuaca','=',"hujan")
    ->where('pem.id_pemilik','=',$idPemilik)
    ->get();

    $hujan = $hujanFromDB[0]->jumlah_transaksi_hujan ;

    return $hujan / $tidakHujan ;



  }

  public function getCuacaBesok($latitude,$longitude) {

    $endpoint = "api.openweathermap.org/data/2.5/forecast/daily";
    $client = new \GuzzleHttp\Client();

    $response = $client->request('GET', $endpoint, ['query' => [
      'lat' => $latitude,
      'lon' => $longitude,
      'appid' => '9de243494c0b295cca9337e1e96b00e2',
      'cnt' => '2'
      ]]);


      $statusCode = $response->getStatusCode();
      $responseJSON = json_decode($response->getBody(), true);
      $cuaca = $responseJSON["list"][1]["weather"][0]["main"] ;
      if ($cuaca == "Rain" || $cuaca == "Drizzle" || $cuaca == "Thunderstorm") {
        $cuaca = "hujan";
      } else {
        $cuaca = "tidak hujan";
      }

      return $cuaca ;
    }

    public function operasiCuacaBesok($listMakananBesokFix, $cuacaBesok, $persentaseHujan) {

      foreach ($listMakananBesokFix as $makananBesokFixNow) {
        if ($cuacaBesok == "hujan") {
          $makananBesokFixNow->jumlah = ceil($makananBesokFixNow->jumlah * $persentaseHujan) ;
        }
      }

      return $listMakananBesokFix ;

    }

    public function getBahanPerMakanan($listMakananBesokCuaca,$idPemilik) {

      foreach ($listMakananBesokCuaca as $makananBesokCuacaNow) {

        $makananBesokCuacaNow->listBahan = DB::table('tb_makanan AS m')
        ->select(DB::raw('b.id_bahan,
        b.nama,
        (r.jumlah * '.$makananBesokCuacaNow->jumlah.')/1000 kilogram,
        b.harga * (r.jumlah * '.$makananBesokCuacaNow->jumlah.') harga'))
        ->join('tb_resep AS r', 'm.id_makanan', '=', 'r.id_makanan')
        ->join('tb_bahan AS b', 'r.id_bahan', '=', 'b.id_bahan')
        ->join('tb_pemilik AS p', 'b.id_pemilik', '=', 'p.id_pemilik')
        ->where('m.id_makanan','=',$makananBesokCuacaNow->id_makanan)
        ->where('p.id_pemilik','=',$idPemilik)
        ->get(); ;

      }

      return $listMakananBesokCuaca ;

    }


    public function getRekomendasiBahan($listMakananBahan,$idPemilik) {

      $listBahan = DB::table('tb_bahan')
      ->select('id_bahan','nama')
      ->where('id_pemilik',$idPemilik)
      ->get();

      foreach ($listBahan as $bahanNow) {

        $bahanNow->kilogram = 0.0 ;
        $bahanNow->harga = 0 ;

        foreach ($listMakananBahan as $makananBahanNow) {

          foreach ($makananBahanNow->listBahan as $bahanMakananNow) {

            if ($bahanNow->id_bahan == $bahanMakananNow->id_bahan) {

              $bahanNow->kilogram += $bahanMakananNow->kilogram ;
              $bahanNow->harga += $bahanMakananNow->harga ;

            }

          }

        }

      }

      return $listBahan;

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
