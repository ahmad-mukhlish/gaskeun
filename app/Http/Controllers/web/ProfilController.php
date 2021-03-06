<?php

namespace App\Http\Controllers\web;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth ;


use App\model\PemilikModel;

use App\Http\RequestsModel;
use App\Http\Controllers\Controller;

class ProfilController extends Controller
{

  public function index(Request $request)
  {
    if ($request->session()->has('username')) {

      $user = PemilikModel::find($request->session()->get('id_pemilik'));

      return view('pemilik.ProfilView')->
      with('nama',$user->username)->
      with('namaLengkap',$user->nama)->
      with('no_telp',$user->no_telp)->
      with('email',$user->email)->
      with('jenis',$user->jenis)->
      with('alamat',$user->alamat)->
      with('foto',$user->foto)
      ;

    } else {
      return redirect('/');
    }
  }


  public function profilPost(Request $request)
  {

    $user = PemilikModel::find($request->session()->get('id_pemilik'));

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

}
