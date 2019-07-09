
$(document).ready(function(){

  //when FAB with a tag clicked, do :

  $("#save").click(function(){

    ajaxProfilPost();

  });


  $("#upload").click(function(){
    $("#fileInput").click();
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

function ajaxProfilPost() {

  var formdata = new FormData();
  formdata.append("gambar",$("#fileInput").prop('files')[0]);
  formdata.append("nama",$("#nama").val());
  formdata.append("no_telp",$("#no_telp").val());
  formdata.append("email",$("#email").val());
  formdata.append("jenis",$("#jenis").val());
  formdata.append("alamat",$("textarea#alamat").val());


  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type:'POST',
    url:"/profilPost",
    data : formdata,
    contentType: false,
    processData: false,
    success:function(data){
      M.toast({html: 'Data Profil Telah Diperbaharui'})
    }

  });

}
