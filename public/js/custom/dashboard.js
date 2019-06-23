
var firebaseConfig = {
  apiKey: "AIzaSyBRRFMyIKXR31h-x-YXI7N3wyCsdiSe9ik",
  authDomain: "pedagangkeliling99.firebaseapp.com",
  databaseURL: "https://pedagangkeliling99.firebaseio.com",
  projectId: "pedagangkeliling99",
  storageBucket: "pedagangkeliling99.appspot.com",
  messagingSenderId: "437659920533",
  appId: "1:437659920533:web:4f56a3c0b2447655"
};
firebase.initializeApp(firebaseConfig);


var rootPemilik;
var map;
var markers;



$(document).ready(function(){

  $(".card--content").hide();
  rootStatus = firebase.database().ref().child("pmk"+$("#id_pemilik").val()).child("status");
  rootLokasi = firebase.database().ref().child("pmk"+$("#id_pemilik").val()).child("lokasi");

  rootStatus.once('value', function (data) {
    var idPedagangList = Object.keys(data.val());

    markers = [];
    ids = new Array();

    idPedagangList.forEach(function(pedagangNow, index){
      var statusPedagangNow = data.val()[pedagangNow] ;
      if (statusPedagangNow.login && statusPedagangNow.keliling){
        $("#kartu"+statusPedagangNow.id).show();
        $("#kartu"+statusPedagangNow.id).css("color","#FFF");
        $("#kartu"+statusPedagangNow.id).css("background-color",$("#mark"+statusPedagangNow.id).val());


        //place the marker on snapshot location for each pedagang
        rootLokasi.once('value', function(snapshotLokasi) {
          var snapshotLokasiPedagangNow = snapshotLokasi.val()[pedagangNow] ;

          index++ ;
          markers[statusPedagangNow.id] = new google.maps.Marker({
            position: {lat: snapshotLokasiPedagangNow.latitude, lng: snapshotLokasiPedagangNow.longitude},
            map: map,
            icon : $("#icon" + index).val()
          });

          map.panTo( new google.maps.LatLng( snapshotLokasiPedagangNow.latitude, snapshotLokasiPedagangNow.longitude ));

        });

      } else if (statusPedagangNow.login && !statusPedagangNow.keliling) {
        $("#kartu"+statusPedagangNow.id).show();
        $("#kartu"+statusPedagangNow.id).css("color","#000");
        $("#kartu"+statusPedagangNow.id).css("background-color","#FFF");
      } else if (!statusPedagangNow.login && !statusPedagangNow.keliling) {
        $("#kartu"+statusPedagangNow.id).hide();
      }
    });




  });


  rootStatus.on('child_changed', function (data) {

    var pesan ;

    if (data.val().login && data.val().keliling){

      pesan = data.val().username + " sedang berkeliling" ;

      $("#kartu"+data.val().id).css("color","#FFF");
      $("#kartu"+data.val().id).css("background-color",$("#mark"+data.val().id).val());

      //place the marker on snapshot location for each pedagang
      rootLokasi.once('value', function(snapshotLokasi) {


        var key = "pdg" + data.val().id ;
        var snapshotLokasiPedagangNow = snapshotLokasi.val()[key] ;

        var index = $("#"+data.val().id).val();
        markers[data.val().id] = new google.maps.Marker({
          position: {lat: snapshotLokasiPedagangNow.latitude, lng: snapshotLokasiPedagangNow.longitude},
          map: map,
          icon : $("#icon" + index).val()
        });

        map.panTo( new google.maps.LatLng( snapshotLokasiPedagangNow.latitude, snapshotLokasiPedagangNow.longitude ));

      });


    } else if (data.val().login && !data.val().keliling) {

      pesan = data.val().username + " sedang online, tidak berkeliling" ;

      $("#kartu"+data.val().id).show();
      $("#kartu"+data.val().id).css("color","#000");
      $("#kartu"+data.val().id).css("background-color","#FFF");



      markers[data.val().id].setMap(null);

    } else if (!data.val().login && !data.val().keliling) {


      markers[data.val().id].setMap(null);
      pesan = data.val().username + " offline " ;

      $("#kartu"+data.val().id).hide();
    }

    M.toast({html: pesan});


  });


  rootLokasi.on('child_changed',function(data){

    if (data.val().moving) {

      markers[data.val().id].setMap(null);


      rootLokasi.once('value', function(snapshotLokasi) {


        var key = "pdg" + data.val().id ;
        var snapshotLokasiPedagangNow = snapshotLokasi.val()[key] ;

        var index = $("#"+data.val().id).val();
        markers[data.val().id] = new google.maps.Marker({
          position: {lat: snapshotLokasiPedagangNow.latitude, lng: snapshotLokasiPedagangNow.longitude},
          map: map,
          icon : $("#icon" + index).val()
        });


      });
    }

  });

  $("#card2").hide();



});

function initMap() {
  var bdg = {lat: -6.914744, lng: 107.609810};

  map = new google.maps.Map(
    document.getElementById('map'), {zoom: 24, center: bdg});

  }
