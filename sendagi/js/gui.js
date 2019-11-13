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
	// voir aussi http://blog.gaboweb.com/2009/07/02/target_blank-automatique-jquery-respecter-normes-xhtml-strictes/
	$('a.spip_out').click(function(){
		$(this).attr('rel','external noopener noreferrer'); // securité : https://www.mail-archive.com/spip-zone@rezo.net/msg40738.html
		window.open(this.href);
		return false;
	});

	// clic externe nouvelle fenetre
	$("a[rel*=external]").click(function(){
		$(this).attr('rel','external noopener noreferrer'); // securité : https://www.mail-archive.com/spip-zone@rezo.net/msg40738.html
		this.target= "_blank";
	});

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

