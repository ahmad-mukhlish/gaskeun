<link rel="stylesheet" type="text/css" href="{{url('css/custom/login.css')}}">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<div class="container">
  <div class="card card-container">
    <img id="profile-img" class="profile-img-card" src="{{url('images/login.png')}}" />
    <p id="profile-name" class="profile-name-card">Login Pemilik</p>
    <form class="form-signin" method="post" action="{{url('admin/login')}}">

      <!-- required  for post method in laravel form -->
      {{csrf_field()}}

      <span id="reauth-email" class="reauth-email"></span>
      <input type="text" id="inputEmail" class="form-control" placeholder="Username" required autofocus name="username">
      <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="password">
      <input type="submit" value ="Log in">

      <br>

    </form>
  </div>
  <div class="shadow"></div>
</div>
