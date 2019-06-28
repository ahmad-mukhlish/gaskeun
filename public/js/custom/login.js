$(document).ready(function(){


  $("#submit").click(function(){

    if ($("#username").is(":focus")){
      $("#password").focus();
    }
    else {
      ajaxLoginPost();
    }
  });
});

function ajaxLoginPost() {

  var formdata = new FormData();
  formdata.append("username",$("#username").val());
  formdata.append("password",$("#password").val());

  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type:'POST',
    url:"/loginPost",
    data : formdata,
    contentType: false,
    processData: false,
    success:function(data){

      var response = jQuery.parseJSON(data);

      if (response.masuk) {
        window.location.replace($("#link").val());
      }
      else {
        new duDialog('Error', response.pesan);
      }

    }

  });

}
