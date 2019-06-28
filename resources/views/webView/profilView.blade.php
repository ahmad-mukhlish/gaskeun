<html>
<head>
  <title> Profil</title>

  <!-- meta crsf token for ajax post -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- custom css and js for this blade -->
  <link rel="stylesheet" type="text/css" href="{{url('css/custom/profil.css')}}">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="{{url('js/custom/profil.js')}}"></script>



</head>
<body>
  @extends('webView/navbar',  ['nama' => $nama], ['title' => 'Profil'])
  @section('content')


  <div class="isi">


    <div class = "row">

      <div class="foto">
        <div class="col s6 m3">
          <div class="card z-depth-3">

            <div class="card-image">

              <?php
              if ($foto != null) {
                $url = "storage/user-profiles/".$foto ;
              }
              else {
                $url = "images/placeholder.jpg";
              }
              ?>

              <div class="card-img" style="background-image:url('{{asset($url)}}')"/ id="gambarUbah"></div>

              <input type="file" id="fileInput" onchange="readGambar(this);"/>
              <a class="btn-floating halfway-fab waves-effect waves-light green" id="upload">
                <i class="material-icons">add_a_photo</i>
              </a>


            </div>
            <div class="card-content">
              <p class="nametag"> {{ucwords($nama)}}</p>
            </div>
          </div>
        </div>
      </div>

      <br>

          <div class="input-field col s8">
            <i class="material-icons prefix">account_circle</i>
            <input id="nama" type="text" class="validate" value="{{$namaLengkap}}">
            <label for="nama">Nama Lengkap</label>
          </div>


          <div class="input-field col s8">
            <i class="material-icons prefix">phone</i>
            <input id="no_telp" type="tel" class="validate" value="{{$no_telp}}">
            <label for="no_telp">Nomor Telefon</label>
          </div>


          <div class="input-field col s8">
            <i class="material-icons prefix">email</i>
            <input id="email" type="email" class="validate" value="{{$email}}">
            <span class="helper-text" data-error="Email tidak valid" data-success="Email valid"></span>
            <label for="email">Email</label>
          </div>

          <div class="input-field col s8">
            <i class="material-icons prefix">business_center</i>
            <input id="jenis" type="text" class="validate" value="{{$jenis}}">
            <label for="jenis">Jenis Usaha Dagang </label>
          </div>

          <form class="col s8">
            <div class="row" id="alamatnya">
              <div class="input-field col s12">
                <i class="material-icons prefix">edit_location</i>
                <textarea id="alamat" class="materialize-textarea">{{$alamat}}</textarea>
                <label for="alamat">Alamat</label>
              </div>
            </div>
          </form>


    </div>



  </div>
  <div class="fixed">

    <a class="btn-floating btn-large waves-effect waves-light green z-depth-3" id="save">
      <i class="material-icons">save</i>
    </a>

  </div>
  @endsection
</body>
</html>
