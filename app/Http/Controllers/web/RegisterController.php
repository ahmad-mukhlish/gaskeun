<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth ;


use App\model\PemilikModel;

use App\Http\RequestsModel;
use App\Http\Controllers\Controller;


class RegisterController extends Controller
{

  public function index()
  {
    return view('authorization.registerView');
  }

  public function registerPost(Request $request)
  {

    $pemilikCariUsername = PemilikModel::where('username', $request->username)
    ->first();

    $pemilikCariEmail = PemilikModel::where('email', $request->email)
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
        $pemilik = new PemilikModel;
        $pemilik->username = $request->username;
        $pemilik->email = $request->email;
        $pemilik->password = $request->password;
        $pemilik->save();

        $user = PemilikModel::where('username', $request->username)
        ->where('password', $request->password)
        ->first();

        $hasil =  array( 'masuk' => true,
        'pemilik' => $user );

        return json_encode($hasil) ;
      }




    }

  }
