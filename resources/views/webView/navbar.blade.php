
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

  <ul id="dropdown" class="dropdown-content">
    <li>
      <a href="{{url('/makanan')}}"> Makanan </a>
    </li>
    <li class="divider"></li>
    <li >
      <a href="{{url('/bahan')}}"> Bahan </a>
    </li>
  </ul>

  <nav>
    <div class="nav-wrapper z-depth-3">
      <a href="#" class="brand-logo">

        <?php
        echo ucfirst($title);
        echo " ";
        echo ucfirst($nama);
        ?>

      </a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">

        <li <?php if($title == "Dashboard") echo "class = active" ;  ?>>
          <a href="{{url('/')}}">  Dashboard </a>
        </li>


        <li <?php if($title == "Profil") echo "class = active" ;  ?>>
          <a href="{{url('/profil')}}">  Profil </a>
        </li>

        <li <?php if($title == "Pedagang") echo "class = active" ;  ?>>
          <a href="{{url('/pedagang')}}">  Pedagang </a>
        </li>


        <li <?php if($title == "Makanan Dagangan" || $title == "Bahan Dagangan") echo "class = active" ; ?>>
          <a class="dropdown-trigger" href="#!" data-target="dropdown"> Dagangan
            <i class="material-icons right">arrow_drop_down</i>
          </a>
        </li>


        <li>
          <a href="{{url('/logout')}}"> Logout </a>
        </li>




      </ul>
    </div>
  </nav>


  @yield('content')

  <!--JavaScript at end of body for optimized loading-->
  <script type="text/javascript" src="{{url('js/libs/materialize/materialize.min.js')}}"></script>

</body>
</html>
