<html>
<head>
  <title> Tambah Pedagang </title>

  <!-- meta crsf token for ajax post -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="https://www.gstatic.com/firebasejs/6.2.2/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/3.1.0/firebase-auth.js"></script>
  <script src="https://www.gstatic.com/firebasejs/3.1.0/firebase-database.js"></script>

  <!-- custom css and js for this blade -->
  <link rel="stylesheet" type="text/css" href="{{url('css/custom/addPedagang.css')}}">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="{{url('js/custom/addPedagang.js')}}"></script>


</head>
<body>
  @extends('webView/navbar',  ['nama' => $nama], ['title' => 'Tambah Pedagang'])
  @section('content')

  <div class="isi">


    <form id="form">

      <!-- required  for post method in laravel form -->
      {{csrf_field()}}

      <div class = "row">

        <div class="foto">
          <div class="col s6 m3">
            <div class="card z-depth-3">

              <div class="card-image">

                <div class="card-img" style="background-image:url('{{asset('images/placeholder.jpg')}}')"/ id="gambarUbah"></div>

                <input type="file" id="fileInput" onchange="readGambar(this);" name="gambar"/>
                <a class="btn-floating halfway-fab waves-effect waves-light green" id="upload">
                  <i class="material-icons">add_a_photo</i>
                </a>


              </div>
              <div class="card-content">
                <p class="nametag"> Pedagang Baru {{ucwords($nama)}}</p>
              </div>
            </div>
          </div>
        </div>

        <br>
        <input type="hidden" id="link" value="{{url('/pedagang')}}"/>
        <input type="hidden" id="id_pemilik" value="{{Session::get('id_pemilik')}}"/>

        <div class="input-field col s8">
          <i class="material-icons prefix">account_circle</i>
          <input id="nama" type="text" class="validate" required name="nama">
          <span class="helper-text" data-error="Nama Harus Diisi"></span>
          <label for="nama">Nama Lengkap</label>
        </div>


        <div class="input-field col s8">
          <i class="material-icons prefix">phone</i>
          <input id="no_telp" type="tel" class="validate" required name="no_telp">
          <span class="helper-text" data-error="Nomor telepon harus diisi"></span>
          <label for="no_telp">Nomor Telefon</label>
        </div>

        <div class="input-field col s8">
          <i class="material-icons prefix">email</i>
          <input id="email" type="email" class="validate" required name="email">
          <span class="helper-text" data-error="Email tidak valid" data-success="Email Tersedia" id="text-email"></span>
          <label for="email">Email</label>
        </div>

        <div class="input-field col s8">
          <i class="material-icons prefix">business_center</i>
          <input id="jenis" type="text" class="validate" required name="jenis">
          <span class="helper-text" data-error="Jenis Usaha Harus Diisi"></span>
          <label for="jenis">Jenis Usaha Dagang </label>
        </div>

        <div class="input-field col s12">
          <i class="material-icons prefix">edit_location</i>
          <input id="alamat" type="text" class="validate" required name="alamat">
          <label for="alamat">Alamat</label>
          <span class="helper-text" data-error="Alamat Harus Diisi"></span>
        </div>

        <div class="input-field col s12">
          <i class="material-icons prefix">supervisor_account</i>
          <input id="username" type="text" class="validate" required name="username">
          <span class="helper-text" data-error="Username telah terpakai" data-success="Username tersedia" id="text-username"></span>
          <label for="username">Username</label>
        </div>


        <div class="input-field col s12">
          <i class="material-icons prefix">security</i>
          <input id="password" type="password" class="validate" required name="password">
          <span class="helper-text" data-error="Password minimal 8 karakter" data-success="Password valid" id="text-password"></span>
          <label for="password">Password</label>
        </div>

        <div class="input-field col s12">
          <i class="material-icons prefix">check</i>
          <input id="passwordConfirm" type="password" class="validate" required>
          <span class="helper-text" data-error="Password tidak cocok" data-success="Password cocok" id="text-confirm"></span>
          <label for="passwordConfirm" >Ketik Password Sekali Lagi</label>
        </div>


      </div>
      <button class="btn waves-effect waves-light" type="submit" form="form" id="submit"> Submit</button>
    </form>

  </div>
  <div class="fixed">

    <a class="btn-floating btn-large waves-effect waves-light green z-depth-3" id="save">
      <i class="material-icons">save</i>
    </a>

  </div>

  @endsection

</body>
</html>
