<?php

namespace App\Http\Controllers\web;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth ;

use App\model\MakananModel;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MakananController extends Controller
{

  public function index(Request $request)
  {
    if ($request->session()->has('username')) {

      $listMakanan = DB::table('tb_makanan')
      ->where('id_pemilik',$request->session()->get('id_pemilik'))
      ->get();

      foreach ($listMakanan as $makananNow) {

        $listBahan = DB::table('tb_bahan AS b')
        ->select('b.nama', 'r.jumlah')
        ->join('tb_resep AS r', 'b.id_bahan', '=', 'r.id_bahan')
        ->join('tb_makanan AS m', 'r.id_makanan', '=', 'm.id_makanan')
        ->where('m.id_makanan','=',$makananNow->id_makanan)
        ->get();

        $makananNow->listBahan = $listBahan ;

      }

      return view('makanan.MakananView')->
      with('nama',$request->session()->get('username'))->
      with('listMakanan',$listMakanan);

    } else {
      return redirect('/');
    }
  }




}
