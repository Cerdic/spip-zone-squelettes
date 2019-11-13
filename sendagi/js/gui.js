/********************************
 *  GUI: interface utilisateur
 *
 ********************************/
 

$(document).ready(function(){

	// print
	$('.print a').click(function() {
		window.print();
		return false;
	});

	// Lien en spip_out s'ouvre ds une nouvelle fenetre
	$('a.spip_out,a[rel*=external]').attr('target','_blank').attr('rel','external noopener noreferrer');

	// carousel
	$('.owl-carousel').owlCarousel({
		loop:true,
		margin:10,
		nav:false,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:1
			},
			1000:{
				items:1
			}
		}
	})

	// Go to the top
	// http://www.jqueryscript.net/other/Minimal-Back-To-Top-Functionality-with-jQuery-CSS3.html
	$(window).scroll(function(event){
		var scroll = $(window).scrollTop();
		if (scroll >= 800) {
			$(".go-top").addClass("show");
		} else {
			$(".go-top").removeClass("show");
		}
	});


	$('.go-top a').click(function(){
		$('html, body').animate({
			scrollTop: $( $(this).attr('href') ).offset().top
		}, 1000);
	});

	// scroll doux
	$('.smooth-scroll').click (function() {
		var target = $(this).attr('href');
		var hash = "#" + target.substring(target.indexOf('#')+1);
		$('html, body').animate({ scrollTop:$(hash).offset().top 	}, 600);
		return false;
	});



});

