<html>
<head>
  <title> Pedagang </title>


  <!-- meta crsf token for ajax post -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="https://www.gstatic.com/firebasejs/6.2.2/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/3.1.0/firebase-auth.js"></script>
  <script src="https://www.gstatic.com/firebasejs/3.1.0/firebase-database.js"></script>

  <!-- custom css and js for this blade -->
  <link rel="stylesheet" type="text/css" href="{{url('css/custom/pedagang.css')}}">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="{{url('js/custom/pedagang.js')}}"></script>

  <!-- material dialog  -->
  <link href="{{url('css/libs/material-dialog/duDialog.css')}}" rel="stylesheet">
  <script src="{{url('js/libs/material-dialog/duDialog.js')}}"></script>

</head>
<body>
  @extends('webView/Navbar',  ['nama' => $nama], ['title' => 'Pedagang'])
  @section('content')




  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

  <div class="container">




    <?php $count = 0 ;?>
    @foreach($listPedagang as $pedagang)

    <?php $count++ ;
    if  ($count % 2 == 1)
    {echo '<div class="row">';}?>

      <div class="col s6">
        <div class="make-3D-space">
          <div class="product-card" id="<?php echo "product-card".$pedagang->id_pedagang?>">
            <div class="product-front" id="<?php echo "product-front".$pedagang->id_pedagang?>">
              <div class="shadow" id="<?php echo "shadow".$pedagang->id_pedagang?>"></div>
              <?php

              $url = 'images/placeholder.jpg' ;

              if($pedagang->foto != null) {

                $url = "storage/pedagang-profiles/".$pedagang->foto ;

              }
              ?>
              <div class="card-img" style="background-image:url('{{asset($url)}}')"/></div>
              <div class="image_overlay"></div>
              <div class="view_details" onclick=" <?php echo "flip(".$pedagang->id_pedagang.");"  ?>">
                Detail {{$pedagang->nama}}
              </div>
              <div class="stats">
                <div class="stats-container">
                  <span class="product_name">{{$pedagang->nama}}</span>
                  <div class="product-options">
                  <strong>Pedagang {{$pedagang->jenis}}</strong> <br> <br>
                    Nomor telepon : <br>
                    <strong>{{$pedagang->no_telp}}</strong>
                    <div class="fixed-action-btn" id="<?php echo "fixed-action-btn".$pedagang->id_pedagang?>">
                      <a class="btn-floating btn-large green" href="{{url('/editPedagang/'.$pedagang->id_pedagang)}}">
                        <i class="large material-icons">mode_edit</i>
                      </a>
                      <ul>
                        <li><a class="btn-floating blue" href="{{url('/editPedagang/'.$pedagang->id_pedagang)}}"><i class="material-icons">mode_edit</i></a></li>
                        <li><a class="btn-floating red" onclick=" <?php echo "dialogHapusPedagang(".$pedagang->id_pedagang.",'".$pedagang->nama."');"  ?>"><i class="material-icons">delete</i></a></li>
                      </ul>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="product-back" id="<?php echo "product-back".$pedagang->id_pedagang?>">
              <div class="shadow" id="<?php echo "shadow-back".$pedagang->id_pedagang?>"></div>
              <div class="carousel" id="<?php echo "carousel".$pedagang->id_pedagang?>">

                <!-- hidden inputs for js variables -->
                <input type="hidden" id="<?php echo "isAnimating".$pedagang->id_pedagang?>" value="false"/>
                <input type="hidden" id="<?php echo "carouselWidth".$pedagang->id_pedagang?>" value="0"/>
                <input type="hidden" id="<?php echo "page".$pedagang->id_pedagang?>" value="5"/>


                <ul>
                  <li>
                    <div class="back-content">
                          <b> Dagangan {{$pedagang->jenis}} </b>
                          @foreach($pedagang->listDagangan as $dagangan)
                          <p> {{$dagangan->nama}} </p>
                          @endforeach
                    </div>
                  </li>
                  <li>
                    <div class="back-content">
                      <p> <i class="inline-icon material-icons"> person </i>&nbsp;&nbsp;{{$pedagang->nama}} </p>
                      <p> <i class="inline-icon material-icons"> email </i>&nbsp;&nbsp;{{$pedagang->email}} </p>
                      <p> <i class="inline-icon material-icons"> phone </i>&nbsp;&nbsp;{{$pedagang->no_telp}} </p>
                      <p> <i class="inline-icon material-icons"> home </i>&nbsp;&nbsp;{{$pedagang->alamat}} </p>
                    </div>
                  </li>
                  <li>
                    <div class="back-content">
                      <p> <i class="inline-icon material-icons"> supervisor_account </i>&nbsp;&nbsp;Username &nbsp;: {{$pedagang->username}} </p>
                      <p> <i class="inline-icon material-icons"> security </i>&nbsp;&nbsp;Password&nbsp;&nbsp;&nbsp;: {{$pedagang->password}} </p>
                    </div>
                  </li>
                </ul>
                <div class="arrows-perspective">
                  <div class="carouselPrev" id="<?php echo "carouselPrev".$pedagang->id_pedagang?>"
                    onclick=" <?php echo "prev(".$pedagang->id_pedagang.");"  ?>">
                    <div class="y"></div>
                    <div class="x"></div>
                  </div>
                  <div class="carouselNext" id="<?php echo "carouselNext".$pedagang->id_pedagang?>"
                    onclick=" <?php echo "next(".$pedagang->id_pedagang.");"  ?>">
                    <div class="y"></div>
                    <div class="x"></div>
                  </div>
                </div>
              </div>
              <div class="flip-back" onclick=" <?php echo "flipBack(".$pedagang->id_pedagang.");"  ?>"
                id="<?php echo "flip-back".$pedagang->id_pedagang?>">
                <div class="cy" id="<?php echo "cy".$pedagang->id_pedagang?>"></div>
                <div class="cx" id="<?php echo "cx".$pedagang->id_pedagang?>"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php
      if  ($count % 2 == 0)
      {echo '</div>';} ?>

      @endforeach



    </div>

    <div class="fixed">


      <a class="btn-floating btn-large waves-effect waves-light green z-depth-3" id="add" href="{{url('/addPedagang')}}">
        <i class="material-icons">add</i>
      </a>


    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    @endsection
  </body>
  </html>
