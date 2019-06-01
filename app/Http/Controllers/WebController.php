<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\model\Pedagang;
use App\model\Pemilik;
use App\Http\Requests;



class WebController extends Controller
{



  public function index()
  {
    $message = "";
    return view('webView.login')->with('message', $message);
  }


  public function loginPost(Request $request)
  {
    $username = $request->username;
    $password = $request->password;

    $user = Pemilik::where('username', $username)
    ->where('password', $password)
    ->first();

    $coba = "coba" ;
    if ($user!=null) {
      $request->session()->put('username', $username);
      return redirect()->action(
        'WebController@dashboard', ['username' => $user->username]);
    }else{
      return view('webView.login')->with('message', 'Username atau Password Salah');
    }
  }

  public function dashboard(Request $request)
  {
    if ($request->session()->has('username')) {
      return view('webView.dashboard')->with('nama',$request->session()->get('username'));
    }else{
      return redirect('/');
    }
  }

  public function profil(Request $request)
  {
    if ($request->session()->has('username')) {
      return view('webView.profil')->with('nama',$request->session()->get('username'));
    }else{
      return redirect('/');
    }
  }

  public function pedagang(Request $request)
  {
    if ($request->session()->has('username')) {
      return view('webView.pedagang')->with('nama',$request->session()->get('username'));
    }else{
      return redirect('/');
    }
  }

  public function makanan(Request $request)
  {
    if ($request->session()->has('username')) {
      return view('webView.makanan')->with('nama',$request->session()->get('username'));
    }else{
      return redirect('/');
    }
  }

  public function register()
  {
    return view('webView.register');
  }

  public function registerPost(Request $request)
  {
    $pemilik = new Pemilik;
    $pemilik->username = $request->username;
    $pemilik->email = $request->email;
    $pemilik->password = $request->password;
    $pemilik->save();
    return redirect('/');
  }

}
