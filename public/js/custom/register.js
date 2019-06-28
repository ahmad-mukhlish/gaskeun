$(document).ready(function(){

  $("#submit").click(function(){
    if ($("#username").is(":focus")){
      $("#email").focus();
    }
    else if ($("#email").is(":focus")) {
      $("#password").focus();
    }
    else if ($("#password").is(":focus")) {
      $("#confirm").focus();
    }
    else {
      if ($("#password").val().length < 8) {
        new duDialog('Error', "Password Minimal 8 Karakter");
      }
      else if ($("#password").val() != $("#confirm").val()) {
        new duDialog('Error', "Password Tidak Cocok");
      }
      else if (($("#username").val().length != 0) && ($("#password").val().length != 0)
      && ($("#username").val().length != 0) && ($("#confirm").val().length != 0)) {
        ajaxRegisterPost();
      }
    }
  });
});

function ajaxRegisterPost() {
  var formdata = new FormData();
  formdata.append("username",$("#username").val());
  formdata.append("email",$("#email").val());
  formdata.append("password",$("#password").val());

  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type:'POST',
    url:"/registerPost",
    data : formdata,
    contentType: false,
    processData: false,
    success:function(data){


      var response = jQuery.parseJSON(data);
      if (response.masuk) {
        new duDialog('Success', "Data Telah Diregistrasi");
        ajaxRegisterFirebase(response.pemilik);
      }
      else {
        new duDialog('Error', response.pesan);
      }


    }

  });

}

function ajaxRegisterFirebase(pemilik) {

  var formdata2 = new FormData();
  formdata2.append("id_pemilik",pemilik.id_pemilik);
  formdata2.append("username",pemilik.username);
  formdata2.append("email",pemilik.email);
  formdata2.append("password",pemilik.password);


  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type:'POST',
    url:"/registerFireBase",
    data : formdata2,
    contentType: false,
    processData: false,
    success:function(data){

      window.location.replace($("#link").val());

    }
  });


}
