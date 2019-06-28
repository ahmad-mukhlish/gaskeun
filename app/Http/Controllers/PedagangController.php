<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth ;


use App\model\Pemilik;
use App\Http\Requests;

class ProfilController extends Controller
{

  public function index(Request $request)
  {
    if ($request->session()->has('username')) {

      $listPedagang = DB::table('tb_pedagang')
      ->where('id_pemilik',$request->session()->get('id_pemilik'))
      ->get();

      return view('pedagang.pedagang')->
      with('nama',$request->session()->get('username'))->
      with('listPedagang',$listPedagang);

    }else{
      return redirect('/');
    }
  }

  public function addPedagang(Request $request)
  {
    if ($request->session()->has('username')) {
      return view('pedagang.addPedagang')->with('nama',$request->session()->get('username'));
    }else{
      return redirect('/');
    }
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



}
