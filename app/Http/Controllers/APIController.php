<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth ;

use App\model\Pedagang;
use App\model\Pemilik;
use App\Http\Requests;

class APIController extends Controller
{

  public function loginAPI(Request $request)
  {
    $username = $request->username;
    $password = $request->password;

    $user = Pedagang::where('username', $username)
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


}
