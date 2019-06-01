
<html>
<head>

  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="{{url('css/libs/materialize/materialize.min.css')}}"  media="screen,projection"/>

  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

  <!-- custom css and js -->
  <link rel="stylesheet" type="text/css" href="{{url('css/custom/navbar.css')}}">
  <script type="text/javascript" src="{{url('js/custom/navbar.js')}}"></script>


</head>
<body>
  <nav>
    <div class="nav-wrapper">
      <a href="#" class="brand-logo">

        <?php
           echo ucfirst($title);
           echo " ";
           echo ucfirst($nama);
        ?>

      </a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="sass.html">Dashboard</a></li>
        <li><a href="sass.html">Profil</a></li>
        <li><a href="badges.html">Pedagang</a></li>
        <li><a href="collapsible.html">Makanan</a></li>
      </ul>
    </div>
  </nav>


  @yield('content')

  <!--JavaScript at end of body for optimized loading-->
  <script type="text/javascript" src="{{url('js/libs/materialize/materialize.min.js')}}"></script>

</body>
</html>
