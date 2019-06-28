<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Auth ;


use App\model\Pemilik;
use App\Http\Requests;

class RegisterController extends Controller
{

  public function index()
  {
    return view('authorization.registerView');
  }

  public function registerPost(Request $request)
  {

    $pemilikCariUsername = Pemilik::where('username', $request->username)
    ->first();

    $pemilikCariEmail = Pemilik::where('email', $request->email)
    ->first();


    if ($pemilikCariUsername != null)

    {
      $hasil =  array( 'masuk' => false,
      'pesan' => "Username telah digunakan" );
      return json_encode($hasil) ;

    }

    else if ($pemilikCariEmail != null) {

      $hasil =  array( 'masuk' => false,
      'pesan' => "Email telah digunakan" );
      return json_encode($hasil) ;

    }
      else {
        $pemilik = new Pemilik;
        $pemilik->username = $request->username;
        $pemilik->email = $request->email;
        $pemilik->password = $request->password;
        $pemilik->save();

        $user = Pemilik::where('username', $request->username)
        ->where('password', $request->password)
        ->first();

        $hasil =  array( 'masuk' => true,
        'pemilik' => $user );

        return json_encode($hasil) ;
      }




    }

  }
