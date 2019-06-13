<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth ;

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
      $request->session()->put('id_pemilik', $user->id_pemilik);
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

        $user = Pemilik::find($request->session()->get('id_pemilik'));

        return view('webView.profil')->
        with('nama',$user->username)->
        with('namaLengkap',$user->nama)->
        with('no_telp',$user->no_telp)->
        with('email',$user->email)->
        with('jenis',$user->jenis)->
        with('alamat',$user->alamat)->
        with('foto',$user->foto)
        ;

      }else{
        return redirect('/');
      }
    }

    public function pedagang(Request $request)
    {

      if ($request->session()->has('username')) {

        $listPedagang = Pedagang::all();
        return view('webView.pedagang')->
        with('nama',$request->session()->get('username'))->
        with('listPedagang',$listPedagang)
        ;

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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget('username');
        $request->session()->forget('id_pemilik');
        $request->session()->flush();

        return redirect ('/');
    }

    public function profilPost(Request $request)
    {

      $user = Pemilik::find($request->session()->get('id_pemilik'));

          if ($request->file('gambar')!=null) {
              $fotoname = 'foto' . time() . '.png';

              $request->file('gambar')->storeAS('storage/user-profiles', $fotoname);
              Storage::disk('uploads')->delete('storage/user-profiles/'.$user->foto);
              $user->foto = $fotoname;
          }

          $user->nama = $request->nama;
          $user->no_telp = $request->no_telp;
          $user->email = $request->email;
          $user->jenis = $request->jenis;
          $user->alamat = $request->alamat;
          $user->save();


        return json_encode($request->file('gambar'));

      }

  }
