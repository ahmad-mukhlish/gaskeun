<html>
<head>
  <title> Register</title>
  <title> Login Pemilik </title>

  <!-- meta crsf token for ajax post -->
  <meta name="csrf-token" content="{{ csrf_token() }}">


  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">


  <!-- material dialog  -->
  <link href="{{url('css/libs/material-dialog/duDialog.css')}}" rel="stylesheet">
  <script src="{{url('js/libs/material-dialog/duDialog.js')}}"></script>

  <link rel="stylesheet" type="text/css" href="{{url('css/custom/register.css')}}">
  <script src="{{url('js/custom/register.js')}}"></script>


</head>
<body>


  <h1 class="judul"> Dibuat untuk <br> pemilik pedagang keliling. </h1>

  <h2 class="keterangan"> Aplikasi Pedagang Keliling Online dibuat untuk  <br>
    memudahkan para pemilik dagangan keliling baik <br>
    secara operasional maupun manajerial. <br> <br>
    <i> Pendaftaran gratis. </i>
  </h2>

  <input type="hidden" id="link" value="{{url('/login')}}">

    <div class="container">
      <div class="card card-container">

        <form class="form-signin" id="form" action="javascript:void(0);">

          <span id="reauth-email" class="reauth-email"></span>

          <p class="subtext"> Username </p>
          <input type="text" id="username" class="form-control" placeholder="Pilih Username Anda" required autofocus>

          <p class="subtext"> Email </p>
          <input type="emal" id="email" class="form-control" placeholder="anda@contoh.com" required
          pattern="^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*$">


          <p class="subtext"> Password </p>
          <input type="password" id="password" class="form-control" placeholder="Password" required>

          <p class="subtext"> Konfirmasi Password </p>
          <input type="password" id="confirm" class="form-control" placeholder="Konfirmasi Password" required>
          <input type="submit" value ="Daftar Sekarang" id="submit" form="form">
          <br>


        </form>
      </div>
      <div class="shadow"></div>
    </div>
  </body>
  </html>
