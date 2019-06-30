<?php

namespace App\Http\Controllers\api\pedagang;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth ;


use App\model\PedagangModel;
use App\model\PemilikModel;

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


}
