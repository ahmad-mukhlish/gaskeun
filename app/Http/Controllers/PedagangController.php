<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth ;

use App\model\Pemilik;
use App\model\Pedagang;
use App\Http\Requests;

class PedagangController extends Controller
{

  public function index(Request $request)
  {
    if ($request->session()->has('username')) {

      $listPedagang = DB::table('tb_pedagang')
      ->where('id_pemilik',$request->session()->get('id_pemilik'))
      ->get();

      return view('pedagang.pedagangView')->
      with('nama',$request->session()->get('username'))->
      with('listPedagang',$listPedagang);

    } else {
      return redirect('/');
    }

  }

  public function addPedagang(Request $request)
  {
    if ($request->session()->has('username')) {
      return view('pedagang.addPedagangView')->with('nama',$request->session()->get('username'));
    }else{
      return redirect('/');
    }
  }

  public function cekUsername(Request $request){

    $pedagangCari = Pedagang::where('username', $request->username)
    ->first();

    $pedagangNow = Pedagang::find($request->id_pedagang) ;

    $hasil =  array( 'ada' => false,
    'username' => "");

    if(($pedagangCari!=null) && ($pedagangNow!=null)){
      $hasil = array( 'ada' => true,
      'username' => $pedagangNow->username);
    } else if (($pedagangCari!=null) && ($pedagangNow==null)) {
      $hasil = array( 'ada' => true,
      'username' => "");

    }
    return json_encode($hasil);
  }


  public function cekEmail(Request $request){

    $pedagangCari = Pedagang::where('email', $request->email)
    ->first();

    $pedagangNow = Pedagang::find($request->id_pedagang) ;

    $hasil =  array( 'ada' => false,
    'email' => "");

    if(($pedagangCari!=null) && ($pedagangNow!=null)){
      $hasil = array( 'ada' => true,
      'email' => $pedagangNow->email);
    } else if (($pedagangCari!=null) && ($pedagangNow==null)) {
      $hasil = array( 'ada' => true,
      'email' => "");

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

    return json_encode($pedagangNow) ;

  }

  public function editPedagang(Request $request)
  {
    if ($request->session()->has('username')) {

      $pedagang = Pedagang::find($request->id) ;

      return view('pedagang.editPedagangView')
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

    return json_encode($pedagang);

  }

  public function deletePedagangPost(Request $request){
    $pedagang = Pedagang::find($request->id_pedagang) ;
    Storage::disk('uploads')->delete('storage/pedagang-profiles/'.$pedagang->foto);
    $hapus = Pedagang::where('id_pedagang',$request->id_pedagang)->delete();

    return json_encode($pedagang);
  }



}
