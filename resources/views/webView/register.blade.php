<html>
<head>
  <title> Register</title>
  <title> Login Pemilik </title>
  <link rel="stylesheet" type="text/css" href="{{url('css/custom/register.css')}}">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

  <!-- material dialog  -->
  <link href="{{url('css/libs/material-dialog/duDialog.css')}}" rel="stylesheet">
  <script src="{{url('js/libs/material-dialog/duDialog.js')}}"></script>
</head>
<body>
  <h1 class="judul"> Dibuat untuk <br> pemilik pedagang keliling. </h1>
  <h2 class="keterangan"> Aplikasi Pedagang Keliling Online dibuat untuk  <br>
                          memudahkan para pemilik dagangan keliling baik <br>
                          secara operasional maupun manajerial. <br> <br>
                          <i> Pendaftaran gratis. </i> </h2>

  <div class="container">
    <div class="card card-container">

      <form class="form-signin" method="post" action="{{url('/registerPost')}}">

        <!-- required  for post method in laravel form -->
        {{csrf_field()}}

        <span id="reauth-email" class="reauth-email"></span>

        <p class="subtext"> Username </p>
        <input type="text" id="inputEmail" class="form-control" placeholder="Pilih Username Anda" required autofocus name="username">

        <p class="subtext"> Email </p>
        <input type="emal" id="inputEmail" class="form-control" placeholder="anda@contoh.com" required autofocus name="email"
        pattern="^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*$">


        <p class="subtext"> Password </p>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="password">
        <input type="submit" value ="Daftar Sekarang">
        <br>



      </form>
    </div>
    <div class="shadow"></div>
  </div>
</body>
</html>
