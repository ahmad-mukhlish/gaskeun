<html>
<head>
  <title> Bahan Dagangan </title>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="{{url('js/custom/bahan.js')}}"></script>
  <link rel="stylesheet" type="text/css" href="{{url('css/custom/bahan.css')}}">

</head>
<body>
  @extends('webView/Navbar',  ['nama' => $nama], ['title' => 'Bahan Dagangan'])
  @section('content')
  <br>
  <table class="striped centered">
    <thead>
      <tr>
        <th>Nama Bahan</th>
        <th>Harga Bahan (kg)</th>
      </tr>
    </thead>
    <tbody>
      @foreach($listBahan as $bahan)
      <tr>
        <td>{{ucwords($bahan->nama)}}</td>
        <td><?php echo "Rp. ".number_format($bahan->harga,0,',','.')  ?></td>
      </tr>
      @endforeach
    </tbody>
  </table>
  @endsection
</body>

</html>
