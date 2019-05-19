<html>
<head>
  <title> Login Pemilik </title>
  <link rel="stylesheet" type="text/css" href="{{url('css/custom/login.css')}}">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

  <!-- material dialog  -->
  <link href="{{url('css/libs/material-dialog/duDialog.css')}}" rel="stylesheet">
  <script src="{{url('js/libs/material-dialog/duDialog.js')}}"></script>

</head>
<body>
  <div class="container">
    <div class="card card-container">
      <img id="profile-img" class="profile-img-card" src="{{url('images/login.png')}}" />
      <p id="profile-name" class="profile-name-card">Login Pemilik</p>
      <form class="form-signin" method="post" action="{{url('/loginPost')}}">

        <!-- required  for post method in laravel form -->
        {{csrf_field()}}

        <span id="reauth-email" class="reauth-email"></span>
        <input type="text" id="inputEmail" class="form-control" placeholder="Username" required autofocus name="username">
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="password">
        <input type="submit" value ="Log in">
        <br>

        <?php if(strcmp($message, "") != 0){ ?>

          <script type="text/javascript">  new duDialog('Error', "{{$message}}"); </script>

        <?php } ?>

        <center class="register"> Belum punya akun?

          <a href="{{url('/register')}}">  Silakan Daftar.. </a>

        </center>

      </form>
    </div>
    <div class="shadow"></div>
  </div>
</body>
</html>
