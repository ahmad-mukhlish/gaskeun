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


  public function getRekomendasiBahan() {

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
