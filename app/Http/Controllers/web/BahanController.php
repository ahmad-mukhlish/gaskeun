<?php

namespace App\Http\Controllers\web;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth ;

use App\model\BahanModel;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BahanController extends Controller
{

  public function index(Request $request)
  {
    if ($request->session()->has('username')) {

      $listBahan = DB::table('tb_bahan')
      ->where('id_pemilik',$request->session()->get('id_pemilik'))
      ->get();

      foreach ($listBahan as $bahanNow) {

        $bahanNow->harga = $bahanNow->harga * 1000 ;

      }

      return view('bahan.BahanView')->with('nama',$request->session()->get('username'))->
      with('listBahan',$listBahan);

    }else{
      return redirect('/');
    }
  }




}
