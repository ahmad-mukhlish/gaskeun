
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



$(document).ready(function(){

  $(".card--content").hide();
  rootPemilik = firebase.database().ref().child("pmk"+$("#id_pemilik").val()).child("status");
  rootPemilik.on('child_changed', function (data) {

    console.log(data);
    var pesan ;
    if (data.val().login && data.val().keliling)
    { pesan = data.val().username + " sedang berkeliling" ;
      $("#kartu"+id).css("color","#FFF");
      $("#kartu"+id).css("background-color",$("#mark"+id).val());
    } else if (data.val().login && !data.val().keliling) {
      pesan = data.val().username + " sedang online, tidak berkeliling" ;
      id = data.val().id ;
      $("#kartu"+id).show();
      $("#kartu"+id).css("color","#000");
      $("#kartu"+id).css("background-color","#FFF");
    } else if (!data.val().login && !data.val().keliling) {
      pesan = data.val().username + " offline " ;
      $("#kartu"+id).hide();
    }

    M.toast({html: pesan});


  });


  $("#card2").hide();



});

function initMap() {




  var bdg = {lat: parseFloat($("#lat").val()), lng: parseFloat($("#long").val())};
  // The map, centered at Uluru
  var map = new google.maps.Map(
    document.getElementById('map'), {zoom: 14, center: bdg});
    // The marker, positioned at Uluru

    var image = $("#image").val();
    var beachMarker = new google.maps.Marker({
      position: {lat: -6.9086045, lng: 107.6325662},
      map: map,
      icon: image
    });

  }
