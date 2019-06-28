
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

  rootPemilik = firebase.database().ref().child("pmk"+$("#id_pemilik").val());



  if($("#username").val().length != 0){

    var formdata = new FormData();
    formdata.append("username",$("#username").val());
    formdata.append("id",$("#idPedagang").val());


    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type:'POST',
      url:"/cekUsername",
      data : formdata,
      contentType: false,
      processData: false,
      success:function(data){
        var json = jQuery.parseJSON(data);
        if ((json.ada == 1)) {
          $("#username").removeClass("valid").addClass("invalid");
        }
        else {
          $("#username").removeClass("invalid").addClass("valid");
        }
      }

    });


  }

  $("#upload").click(function(){
    $("#fileInput").click();
  });

  $("#username").on("focusout", function (e) {

    var formdata = new FormData();
    formdata.append("username",$("#username").val());
    formdata.append("id",$("#idPedagang").val());


    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type:'POST',
      url:"/cekUsername",
      data : formdata,
      contentType: false,
      processData: false,
      success:function(data){
        var json = jQuery.parseJSON(data);
        if ((json.ada == 1)) {
          $("#username").removeClass("valid").addClass("invalid");
        }
        else {
          $("#username").removeClass("invalid").addClass("valid");
        }
      }

    });

  });


  $("#username").on("keyup", function (e) {

    var formdata = new FormData();
    formdata.append("username",$("#username").val());
    formdata.append("id",$("#idPedagang").val());


    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type:'POST',
      url:"/cekUsername",
      data : formdata,
      contentType: false,
      processData: false,
      success:function(data){
        var json = jQuery.parseJSON(data);
        if ((json.ada == 1)) {
          $("#username").removeClass("valid").addClass("invalid");
        }
        else {
          $("#username").removeClass("invalid").addClass("valid");
        }
      }

    });

  });

  $("#password").on("focusout", function (e) {
    if ($(this).val() != $("#passwordConfirm").val()) {
      $("#passwordConfirm").removeClass("valid").addClass("invalid");
      $("#text-confirm").attr("data-error","Password tidak cocok");
    } else if ($(this).val().length > 7) {
      $("#passwordConfirm").removeClass("invalid").addClass("valid");
    }

    if($(this).val().length < 8) {
      $("#password").removeClass("valid").addClass("invalid");
    } else {
      $("#password").removeClass("invalid").addClass("valid");
    }
  });


  $("#password").on("focusin", function (e) {

    if (($(this).val() != $("#passwordConfirm").val()) ) {
      $("#passwordConfirm").removeClass("valid").addClass("invalid");
      $("#text-confirm").attr("data-error","Password tidak cocok");
    } else if ($(this).val().length > 7){
      $("#passwordConfirm").removeClass("invalid").addClass("valid");
    }

    if($(this).val().length < 8) {
      $("#password").removeClass("valid").addClass("invalid");
    } else {
      $("#password").removeClass("invalid").addClass("valid");
    }
  });

  $("#password").on("keyup", function (e) {

    if (($(this).val() != $("#passwordConfirm").val())) {
      $("#passwordConfirm").removeClass("valid").addClass("invalid");
      $("#text-confirm").attr("data-error","Password tidak cocok");
    } else {
      $("#passwordConfirm").removeClass("invalid").addClass("valid");
    }

    if($(this).val().length < 8) {
      $("#password").removeClass("valid").addClass("invalid");
      $("#passwordConfirm").removeClass("valid").addClass("invalid");
      $("#text-confirm").attr("data-error","Password belum valid");
    } else {
      $("#password").removeClass("invalid").addClass("valid");
    }
  });


  $("#passwordConfirm").on("keyup", function (e) {
    if ($("#password").val() != $(this).val())  {
      $(this).removeClass("valid").addClass("invalid");
      $("#text-confirm").attr("data-error","Password tidak cocok");
    } else if ($("#password").val() < 8) {
      $(this).removeClass("valid").addClass("invalid") ;
      $("#text-confirm").attr("data-error","Password belum valid");
    } else{
      $(this).removeClass("invalid").addClass("valid");
    }
  });

  $("#passwordConfirm").on("focusin", function (e) {
    if ($("#password").val() != $(this).val())  {
      $(this).removeClass("valid").addClass("invalid");
      $("#text-confirm").attr("data-error","Password tidak cocok");
    } else if ($("#password").val() < 8) {
      $(this).removeClass("valid").addClass("invalid") ;
      $("#text-confirm").attr("data-error","Password belum valid");
    }
    else {
      $(this).removeClass("invalid").addClass("valid");
    }
  });

  $("#passwordConfirm").on("focusout", function (e) {
    if ($("#password").val() != $(this).val())  {
      $(this).removeClass("valid").addClass("invalid");
      $("#text-confirm").attr("data-error","Password tidak cocok");
    } else if ($("#password").val() < 8) {
      $(this).removeClass("valid").addClass("invalid") ;
      $("#text-confirm").attr("data-error","Password belum valid");
    }else {
      $(this).removeClass("invalid").addClass("valid");
    }
  });


  //when FAB with a tag clicked, do :

  $("#save").click(function(){

    if ($("#password").hasClass("valid") && $("#passwordConfirm").hasClass("valid")
    && $("#username").hasClass("valid")){
      addPedagang();
    }   else if ($("#username").hasClass("invalid")){
      M.toast({html: 'Username belum valid'}) ;
    } else {

      if ($("#nama").val().length !=0 && $("#no_telp").val().length !=0
      && $("#email").val().length !=0 && $("#jenis").val().length !=0
      && $("#alamat").val().length !=0 && $("#alamat").val().length !=0
      && $("#username").val().length !=0) {

        M.toast({html: 'Password Masih Belum Valid'}) ;

        if (!$("#password").hasClass("valid")) {
          $("#password").focus();
        }
        if (!$("#passwordConfirm").hasClass("valid") && $("#password").hasClass("valid")) {
          $("#passwordConfirm").focus();
        }
      }

      else{
        $("#submit").click();
        M.toast({html: 'Silakan Isi Data'}) ;
      }

    }

  });
});

function readGambar(input) {
  var file = input.files[0];
  var imagefile = file.type;
  var match= ["image/jpeg","image/png","image/jpg"];

  if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))

  {
    M.toast({html: 'Format foto tidak sesuai'})
    return false ;
  }

  else{

    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#gambarUbah').css({backgroundImage:'url(' + e.target.result + ')'}) ;
      };

      reader.readAsDataURL(input.files[0]);
    }

  }



}

function addPedagang() {


  var formdata = new FormData();
  formdata.append("gambar",$("#fileInput").prop('files')[0]);
  formdata.append("nama",$("#nama").val());
  formdata.append("no_telp",$("#no_telp").val());
  formdata.append("email",$("#email").val());
  formdata.append("jenis",$("#jenis").val());
  formdata.append("alamat",$("#alamat").val());
  formdata.append("username",$("#username").val());
  formdata.append("password",$("#password").val());
  formdata.append("id_pemilik",$("#id_pemilik").val());

  var id ;
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type:'POST',
    url:"/addPedagangPost",
    data : formdata,
    contentType: false,
    processData: false,
    success:function(data){
      var rootPedagang = rootPemilik.child("status").child("pdg"+data);
      rootPedagang.set({
        login : false,
        keliling : false,
        username : $("#username").val(),
        id : parseInt(data)
      });

      addPedagangFirebase(data);

    }

  });

}

function addPedagangFirebase(id) {

  var formdata2 = new FormData();
  formdata2.append("email",$("#email").val());
  formdata2.append("username",$("#username").val());
  formdata2.append("password",$("#password").val());
  formdata2.append("id_pemilik",$("#id_pemilik").val());
  formdata2.append("id_pedagang",id);

  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type:'POST',
    url:"/addPedagangFireBase",
    data : formdata2,
    contentType: false,
    processData: false,
    success:function(data){

      window.location.replace($("#link").val());
      M.toast({html: 'Data Pedagang Telah Ditambahkan'});



    }
  });
}
