<?php
namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth ;

use App\model\PemilikModel;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{

  public function index()
  {
    return view('authorization.loginView');
  }


  public function loginPost(Request $request)
  {
    $username = $request->username;
    $password = $request->password;

    $user = PemilikModel::where('username', $username)
    ->where('password', $password)
    ->first();

    $hasil =  array( 'masuk' => false,
    'pesan' => "Username atau password salah");


    if ($user != null) {

      $request->session()->put('username', $username);
      $request->session()->put('id_pemilik', $user->id_pemilik);

      $hasil =  array( 'masuk' => true,
      'pesan' => "Login Berhasil");

    }

    return json_encode($hasil) ;
  }

}
