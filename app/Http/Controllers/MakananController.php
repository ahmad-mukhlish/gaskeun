<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth ;

use App\model\Pedagang;
use App\model\Pemilik;
use App\Http\Requests;

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
