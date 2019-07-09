
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

var carouselSlideWidth = 335;


$(document).ready(function(){

	// Lift card and show stats on Mouseover
	$('.product-card').hover(function(){
		$(this).addClass('animate');
		$('div.carouselNext, div.carouselPrev').addClass('visible');
	}, function(){
		$(this).removeClass('animate');
		$('div.carouselNext, div.carouselPrev').removeClass('visible');
	});

	// fab
	$('.fixed-action-btn').floatingActionButton({
		direction: 'left',
	});


	$('#add').hover(function(){
		$(this).removeClass('green');
		$(this).addClass('blue');
	},function(){
		$(this).addClass('green');
		$(this).removeClass('blue');
	});




});


function flip(id){

	var carouselNext = "#carouselNext" + id ;
	var carouselPrev = "#carouselPrev" + id ;
	var productCard = "#product-card" + id ;
	var shadow = "#shadow" + id ;
	var productFront = "#product-front" + id ;
	var productBack= "#product-back" + id ;
	var fab = "#fixed-action-btn" + id ;
	var cx = "#cx" + id ;
	var cy = "#cy" + id ;

	var page = "#page" + id ;
	var isAnimating = "#isAnimating" + id ;
	var carouselWidth = "#carouselWidth" + id;
	var carousel = "#carousel" + id ;


	prev(id);
  prev(id);
	$(page).val(1);
	$(isAnimating).val("false");
	$(carouselWidth).val(0);

	var total = 0;

	// building the width of the casousel
	$(carousel+' li').each(function(){
		total += carouselSlideWidth;

	});

	$(carouselWidth).val(total);
	$($(carousel+' ul')).css('width', $(carouselWidth).val());



	$(carouselNext, carouselPrev).removeClass('visible');
	$(productCard).addClass('flip-10');
	$(fab).hide();

	setTimeout(function(){
		$(productCard).removeClass('flip-10').addClass('flip90').find('div.shadow').show().fadeTo( 80 , 1, function(){
			$(productFront, shadow).hide();
		});
	}, 50);

	setTimeout(function(){
		$(productCard).removeClass('flip90').addClass('flip190');
		$(productBack).show().find('div.shadow').show().fadeTo( 90 , 0);
		setTimeout(function(){
			$(productCard).removeClass('flip190').addClass('flip180').find('div.shadow').hide();
			setTimeout(function(){
				$(productCard).css('transition', '100ms ease-out');
				$(cx+','+cy).addClass('s1');
				setTimeout(function(){$(cx+','+cy).addClass('s2');}, 100);
				setTimeout(function(){$(cx+','+cy).addClass('s3');}, 200);
				$(carouselNext+','+carouselPrev).addClass('visible');
			}, 100);
		}, 100);
	}, 150);


}


function flipBack(id) {
	var carouselNext = "#carouselNext" + id ;
	var carouselPrev = "#carouselPrev" + id ;
	var productCard = "#product-card" + id ;
	var shadow = "#shadow" + id ;
	var fab = "#fixed-action-btn" + id ;
	var shadowBack = "#shadow-back" + id ;
	var productFront = "#product-front" + id ;
	var productBack= "#product-back" + id ;
	var cx = "#cx" + id ;
	var cy = "#cy" + id ;


	$(productCard).removeClass('flip180').addClass('flip190');
	setTimeout(function(){
		$(productCard).removeClass('flip190').addClass('flip90');

		$(shadowBack).css('opacity', 0).fadeTo( 100 , 1, function(){
			$(productBack+','+shadowBack).hide();
			$(productFront+','+shadow).show();
		});
	}, 50);

	setTimeout(function(){
		$(productCard).removeClass('flip90').addClass('flip-10');
		$(shadow).show().fadeTo( 100 , 0);
		setTimeout(function(){
			$(shadow).hide();
			$(productCard).removeClass('flip-10').css('transition', '100ms ease-out');
			$(cx, cy).removeClass('s1 s2 s3');
			$(fab).show();
		}, 100);
	}, 150);

}

function next(id) {

	var page = "#page" + id ;
	var isAnimating = "#isAnimating" + id ;
	var carouselWidth = "#carouselWidth" + id;
	var carousel = "#carousel" + id ;


	if ($(page).val() == 1 || $(page).val() == 2) {
		// $('div.carouselPrev').show();
		var currentLeft = Math.abs(parseInt($($(carousel+' ul')).css("left")));
		var newLeft = currentLeft + carouselSlideWidth;
		if(newLeft == $(carouselWidth).val() || $(isAnimating).val() == true){return;}
		$(carousel+' ul').css({'left': "-" + newLeft + "px",
		"transition": "300ms ease-out"
	});
	$(isAnimating).val("true") ;
	setTimeout(function(){$(isAnimating).val("false");}, 300);
	var pageCounter = $(page).val();
	pageCounter++ ;
	$(page).val(pageCounter);
	// $('div.carouselNext').hide();
}

}

function prev(id) {


	var page = "#page" + id ;
	var isAnimating = "#isAnimating" + id ;
	var carouselWidth = "#carouselWidth" + id;
	var carousel = "#carousel" + id ;


	if ($(page).val() == 2 || $(page).val() == 3) {
		// $('div.carouselNext').show();
		var currentLeft = Math.abs(parseInt($($(carousel+' ul')).css("left")));
		var newLeft = currentLeft - carouselSlideWidth;
		if(newLeft < 0  || $(isAnimating).val() == true){return;}
		$(carousel+' ul').css({'left': "-" + newLeft + "px",
		"transition": "300ms ease-out"
	});
	$(isAnimating).val("true") ;
	setTimeout(function(){$(isAnimating).val("false");}, 300);
	var pageCounter = $(page).val();
	pageCounter-- ;
	$(page).val(pageCounter);
	// $('div.carouselPrev').hide();
}


}

function dialogHapusPedagang(id_pedagang, nama){

	new duDialog('Konfirmasi Hapus', 'Anda Yakin Menghapus Data '+ nama +'?', duDialog.OK_CANCEL, {
		okText: 'Ya',
		cancelText: 'Tidak',
		callbacks: {
			okClick: function(){
				this.hide();
        ajaxDeletePedagangPost(id_pedagang);
			},
			cancelClick: function(){
				this.hide();
			}
		}
	});
}

function ajaxDeletePedagangPost(id_pedagang) {
  var formdata = new FormData();
  formdata.append("id_pedagang",id_pedagang);
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type:'POST',
    url:"/deletePedagangPost",
    data : formdata,
    contentType: false,
    processData: false,
    success:function(data){
      M.toast({html: 'Data pedagang dihapus, mereload halaman...'}) ;
      var pedagang = jQuery.parseJSON(data);
      deletePedagangRealTimeFirebase(pedagang);
      console.log(pedagang);

    }

  });
}

function deletePedagangRealTimeFirebase(pedagang) {

  var rootPemilik = firebase.database().ref().child("pemilik").child("pmk"+pedagang.id_pemilik);

	var rootPedagangLokasi = rootPemilik.child("lokasi").child("pdg"+pedagang.id_pedagang);
	rootPedagangLokasi.remove();

	var rootPedagangStatus = rootPemilik.child("status").child("pdg"+pedagang.id_pedagang);
	rootPedagangStatus.remove().then(function() {
			location.reload();
	})
	.catch(function(error) {
	});


}
