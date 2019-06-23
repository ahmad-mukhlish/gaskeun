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

        $listPedagang  = DB::table('tb_pedagang')
            ->where('id_pemilik',$request->session()->get('id_pemilik'))
            ->get();

        return view('webView.dashboard')
        ->with('nama',$request->session()->get('username'))
        ->with('listPedagang',$listPedagang);
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

        $listPedagang = DB::table('tb_pedagang')
        ->where('id_pemilik',$request->session()->get('id_pemilik'))
        ->get();

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

      $user = Pemilik::where('username', $request->username)
      ->where('password', $request->password)
      ->first();

      return redirect()->route('regFireBase', ['id' => $user, 'username' => $user->username,
      'email' => $user->email, 'password' => $user->password
    ]);

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



    }

    public function addPedagang(Request $request)
    {
      if ($request->session()->has('username')) {
        return view('webView.addPedagang')->with('nama',$request->session()->get('username'));
      }else{
        return redirect('/');
      }
    }


    public function addPedagangPost(Request $request)
    {

      $pedagang = new Pedagang;
      $pedagang->nama = $request->nama;
      $pedagang->no_telp = $request->no_telp;
      $pedagang->email = $request->email;
      $pedagang->jenis = $request->jenis;
      $pedagang->alamat = $request->alamat;
      $pedagang->username = $request->username;
      $pedagang->password = $request->password;
      $pedagang->id_pemilik = $request->id_pemilik;


      if ($request->file('gambar')!=null) {
        $fotoname = 'foto' . time() . '.png';

        $request->file('gambar')->storeAS('storage/pedagang-profiles', $fotoname);
        $pedagang->foto = $fotoname;
      }


      $pedagang->save();

      $pedagangNow = Pedagang::where('username', $request->username)
      ->where('password', $request->password)
      ->first();

      return json_encode($pedagangNow->id_pedagang) ;
  

    }

    public function editPedagang(Request $request)
    {
      if ($request->session()->has('username')) {

        $pedagang = Pedagang::find($request->id) ;

        return view('webView.editPedagang')
        ->with('nama',$request->session()->get('username'))
        ->with('namaPedagang',$pedagang->nama)
        ->with('no_telp',$pedagang->no_telp)
        ->with('email',$pedagang->email)
        ->with('jenis',$pedagang->jenis)
        ->with('alamat',$pedagang->alamat)
        ->with('username',$pedagang->username)
        ->with('password',$pedagang->password)
        ->with('foto',$pedagang->foto)
        ->with('id',$pedagang->id_pedagang)
        ;
      }else{
        return redirect('/');
      }
    }

    public function editPedagangPost(Request $request)
    {

      $pedagang = Pedagang::find($request->id);

      if ($request->file('gambar')!=null) {
        $fotoname = 'foto' . time() . '.png';

        $request->file('gambar')->storeAS('storage/pedagang-profiles', $fotoname);
        Storage::disk('uploads')->delete('storage/pedagang-profiles/'.$pedagang->foto);
        $pedagang->foto = $fotoname;
      }

      $pedagang->nama = $request->nama;
      $pedagang->no_telp = $request->no_telp;
      $pedagang->email = $request->email;
      $pedagang->jenis = $request->jenis;
      $pedagang->alamat = $request->alamat;
      $pedagang->username = $request->username;
      $pedagang->password = $request->password;

      $pedagang->save();

    }


    public function deletePedagangPost(Request $request){
      $pedagang = Pedagang::find($request->id) ;
      Storage::disk('uploads')->delete('storage/pedagang-profiles/'.$pedagang->foto);
      $hapus = Pedagang::where('id_pedagang',$request->id)->delete();
    }

    public function cekUsername(Request $request){

      $pedagangCari = Pedagang::where('username', $request->username)
      ->first();


      $pedagang = Pedagang::find($request->id) ;

      $hasil =  array( 'ada' => 0,
      'username' => "");

      if(($pedagangCari!=null) && ($pedagang!=null)){
        $hasil = array( 'ada' => 1,
        'username' => $pedagang->username);
      } else if (($pedagangCari!=null) && ($pedagang==null)) {
        $hasil = array( 'ada' => 1,
        'username' => "");

      }


      return json_encode($hasil);
    }
  }
