<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth ;

use App\model\Pedagang;
use App\model\Pemilik;
use App\Http\Requests;

class DashboardController extends Controller
{

  public function index(Request $request)
  {
    if ($request->session()->has('username')) {

      $listPedagang  = DB::table('tb_pedagang')
      ->where('id_pemilik',$request->session()->get('id_pemilik'))
      ->get();

      return view('webView.dashboard')
      ->with('nama',$request->session()->get('username'))
      ->with('listPedagang',$listPedagang);

    } else {
      return redirect('/login');
    }
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
