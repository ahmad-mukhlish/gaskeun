$(document).ready(function(){


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
