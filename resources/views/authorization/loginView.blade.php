<html>
<head>
  <title> Login Pemilik </title>

  <!-- meta crsf token for ajax post -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

  <!-- material dialog  -->
  <link href="{{url('css/libs/material-dialog/duDialog.css')}}" rel="stylesheet">
  <script src="{{url('js/libs/material-dialog/duDialog.js')}}"></script>

  <link rel="stylesheet" type="text/css" href="{{url('css/custom/login.css')}}">
  <script src="{{url('js/custom/login.js')}}"></script>



</head>
<body>
  <div class="container">

    <input type="hidden" id="link" value="{{url('/')}}">

    <div class="card card-container">
      <img id="profile-img" class="profile-img-card" src="{{url('images/login.png')}}" />
      <p id="profile-name" class="profile-name-card">Login Pemilik</p>

      <form class="form-signin" id="form" action="javascript:void(0);">

        <span id="reauth-email" class="reauth-email"></span>
        <input type="text" id="username" class="form-control" placeholder="Username" required autofocus>
        <input type="password" id="password" class="form-control" placeholder="Password" required>
        <input type="submit" value ="Log in" id="submit" form="form">
        <br>

        <center class="register"> Belum punya akun?

          <a href="{{url('/register')}}">  Silakan Daftar.. </a>

        </center>

      </form>
    </div>

    <div class="shadow"></div>

  </div>
</body>
</html>
