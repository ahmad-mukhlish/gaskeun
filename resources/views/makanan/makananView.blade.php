<html>
<head>
  <title> Makanan Dagangan </title>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="{{url('js/custom/makanan.js')}}"></script>
  <link rel="stylesheet" type="text/css" href="{{url('css/custom/makanan.css')}}">
</head>
<body>
  @extends('webView/Navbar',  ['nama' => $nama], ['title' => 'Makanan Dagangan'])
  @section('content')

  <div class="isi">

    <?php $count = 0 ;?>
    @foreach($listMakanan as $makanan)

    <?php $count++ ;
    if  ($count % 2 == 1)
    {echo '<div class="row">';}?>

      <div class="col m4">

        <div class="card hover-reveal z-depth-3">
          <div class="card-image waves-effect waves-block waves-light">
                <div class="card-img activator" style="background-image:url('{{asset('storage/makanan-photos/'.$makanan->foto)}}')" id="trigger"/></div>
          </div>

          <div class="card-content">
            <span class="card-title activator grey-text text-darken-4"> <b> {{ucwords($makanan->nama)}} </b> </span>
            <span class="card-title activator grey-text text-darken-4"> <b> <?php echo "Rp. ".number_format($makanan->harga,0,',','.')  ?>  </b> </span>
              <a class="btn-floating btn-large blue edit z-depth-3">
                <i class="large material-icons">mode_edit</i>
              </a>

              <a class="btn-floating btn-large red hapus z-depth-3">
                <i class="large material-icons">delete</i>
              </a>
          </div>

          <div class="card-reveal">
            <span class="card-title grey-text text-darken-4" id="close"> <strong> {{$makanan->nama}} <strong> <i class="material-icons right">close</i></span>

              <br>

              <table class="bordered highlight">

                <thead>
                  <tr>
                    <th data-field="id">Bahan</th>
                    <th data-field="quantity">Jumlah (gram)</th>
                  </tr>
                </thead>

                <tbody>

                  @foreach($makanan->listBahan as $bahan)
                  <tr>
                    <td>{{$bahan->nama}}</td>
                    <td>{{$bahan->jumlah}}</td>
                  </tr>
                  @endforeach

                </tbody>

              </table>

              <br>
              <p> {{$makanan->deskripsi}} </p>

            </div>
          </div>
        </div>






        <?php
        if  ($count % 2 == 0)
        {echo '</div>';} ?>

        @endforeach

      </div>


    </div>


    <div class="fixed">
      <a class="btn-floating btn-large waves-effect waves-light green z-depth-3" id="add" href="{{url('/addMakanan')}}">
        <i class="material-icons">add</i>
      </a>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    @endsection
  </body>
  </html>
