<html>
<head>
  <title> Dashboard </title>


    <script src="https://www.gstatic.com/firebasejs/6.2.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/3.1.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/3.1.0/firebase-database.js"></script>


  <!-- custom css and js for this blade -->
  <link rel="stylesheet" type="text/css" href="{{url('css/custom/dashboard.css')}}">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="{{url('js/custom/dashboard.js')}}"></script>

</head>

<body>
  @extends('webView/navbar',  ['nama' => $nama], ['title' => 'Dashboard'])
  @section('content')


  <input type="hidden" id="id_pemilik" value="{{Session::get('id_pemilik')}}"/>
  <div id="map"></div>
  <section id="card">
    <?php $count = 0 ?>
    @foreach($listPedagang as $pedagang)
    <?php $count++
    ?>
    <div class="card--content z-depth-3" id="<?php echo "kartu".$pedagang->id_pedagang?>">
      <br>
      {{$pedagang->username}}
    </div>
    <input type="hidden" id="<?php echo "mark".$pedagang->id_pedagang?>" value="<?php echo color($count)?>">
    <input type="hidden" id="<?php echo "icon".$count?>" value="{{asset('images/mark'.$count.'.png')}}">
    <input type="hidden" id="<?php echo $pedagang->id_pedagang?>" value="{{$count}}">

    @endforeach


  </section>
  <script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaYa3SZ4n5pYR3Q-Twzqd4lNPPzf4kzlM&callback=initMap">
  </script>
  @endsection

  <?php
  function color($id){

    $color ;

    switch ($id) {
      case 1:
      $color = "#F44336" ;
      break;
      case 2:
      $color = "#E91E63" ;
      break;
      case 3:
      $color = "#9C27B0" ;
      break;
      case 4:
      $color = "#673AB7" ;
      break;
      case 5:
      $color = "#3F51B5" ;
      break;
      case 6:
      $color = "#2196F3" ;
      break;
      case 7:
      $color = "#03A9F4" ;
      break;
      case 8:
      $color = "#00BCD4" ;
      break;
      case 9:
      $color = "#009688" ;
      break;
      case 10:
      $color = "#4CAF50" ;
      break;
      case 11:
      $color = "#8BC34A" ;
      break;
      case 12:
      $color = "#CDDC39" ;
      break;
      case 13:
      $color = "#FFEB3B" ;
      break;
      case 14:
      $color = "#FFC107" ;
      break;
      case 15:
      $color = "#FF9800" ;
      break;
      case 16:
      $color = "#FF5722" ;
      break;
      case 17:
      $color = "#795548" ;
      break;
      case 18:
      $color = "#9E9E9E" ;
      break;
      case 19:
      $color = "#607D8B" ;
      break;
      default:
      $color = "#000000" ;
      ;
    }


    return $color ;
  }
  ?>

</body>
</html>
