
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

$(document).ready(function(){



  if($("#username").val().length != 0) {
    ajaxCekUserName($("#username").val()) ;
  }

  if($("#email").val().length != 0) {
    ajaxCekEmail($("#email").val()) ;
  }


  $("#upload").click(function(){
    $("#fileInput").click();
  });

  $("#username").on("focusout", function (e) {
    ajaxCekUserName($("#username").val()) ;
  }) ;

  $("#username").on("keyup", function (e) {
    ajaxCekUserName($("#username").val()) ;
  });

  $("#email").on("focusout", function (e) {
    ajaxCekEmail($("#email").val()) ;
  });

  $("#email").on("keyup", function (e) {
    ajaxCekEmail($("#email").val()) ;
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



  $("#save").click(function(){

    if ($("#password").hasClass("valid") && $("#passwordConfirm").hasClass("valid")
    && $("#username").hasClass("valid")){
      ajaxAddPedagangPost();
    }
    else if ($("#username").hasClass("invalid")){
      M.toast({html: 'Username belum valid'}) ;
    }
    else if ($("#email").hasClass("invalid")){
      M.toast({html: 'Email belum valid'}) ;
    }
    else {

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

      else {
        $("#submit").click();
        M.toast({html: 'Silakan Isi Data'}) ;
      }

    }

  });
});


function ajaxCekUserName(username) {

  if($("#username").val().length != 0){

    var formdata = new FormData();
    formdata.append("username",username);


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
        var response = jQuery.parseJSON(data);
        if ((response.ada)) {
          $("#username").removeClass("valid").addClass("invalid");
        }
        else {
          $("#username").removeClass("invalid").addClass("valid");
        }
      }

    });


  }

  else {
    $("#username").removeClass("valid").addClass("invalid");
    $("#text-username").attr("data-error","Username Tidak Boleh Kosong");
  }

}

function ajaxCekEmail(email) {

  if($("#email").val().length != 0){

    var formdata = new FormData();
    formdata.append("email",email);


    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type:'POST',
      url:"/cekEmail",
      data : formdata,
      contentType: false,
      processData: false,
      success:function(data){
        var response = jQuery.parseJSON(data);
        if ((response.ada)) {
          $("#email").removeClass("valid").addClass("invalid");
          $("#text-email").attr("data-error","Email Telah Digunakan");

        }
        else {
          $("#email").removeClass("invalid").addClass("valid");
        }
      }

    });


  }

  else {

    $("#email").removeClass("valid").addClass("invalid");
    $("#text-email").attr("data-error","Email Tidak Boleh Kosong");

  }

}

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

function ajaxAddPedagangPost() {


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
      M.toast({html: 'Data Pedagang Telah Ditambahkan'});
      var pedagang = jQuery.parseJSON(data);
      addPedagangRealTimeFirebase(pedagang);
      ajaxAddPedagangFirebase(pedagang);

    }

  });

}

function ajaxAddPedagangFirebase(pedagang) {

  var formdata2 = new FormData();
  formdata2.append("id_pedagang",pedagang.id_pedagang);
  formdata2.append("email",pedagang.email);
  formdata2.append("username",pedagang.username);
  formdata2.append("password",pedagang.password);
  formdata2.append("id_pemilik",pedagang.id_pemilik);

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



    }
  });
}

function addPedagangRealTimeFirebase(pedagang) {

  var rootPemilik = firebase.database().ref().child("pemilik").child("pmk"+pedagang.id_pemilik);
  var rootPedagang = rootPemilik.child("status").child("pdg"+pedagang.id_pedagang);
  rootPedagang.set({
    login : false,
    keliling : false,
    username : pedagang.username,
    id : parseInt(pedagang.id_pedagang)
  });

}
