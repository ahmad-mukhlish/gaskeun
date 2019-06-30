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

class MakananController extends Controller
{

  public function index(Request $request)
  {
    if ($request->session()->has('username')) {
      return view('makanan.makananView')->with('nama',$request->session()->get('username'));
    }else{
      return redirect('/');
    }
  }




}
