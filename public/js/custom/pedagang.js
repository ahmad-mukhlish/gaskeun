
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


	if ($(page).val() == 1) {
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


	if ($(page).val() == 2) {
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