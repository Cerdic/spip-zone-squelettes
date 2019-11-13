/********************************
 *  GUI: interface utilisateur
 *
 *  version:  1.0
 *  date:     2014.04.30
 *
 ********************************/
 
      
$(document).ready(function(){

	// print
	$(".print a").click(function() {
		window.print();
		return false;
	});


	// Lien en spip_out et external s'ouvre ds une nouvelle fenetre + secu referer
	$('a.spip_out,a[rel*=external]').attr('target','_blank').attr('rel','external noopener noreferrer');


	// menu recherche desktop
	$(".btn-nav-search").bind('click', function (e) {
		if ($(".search-desktop").hasClass("active")) {
			$(".search-desktop").removeClass("active");
		} else {
			$(".search-desktop").addClass("active");
		}
		return false;
	});

	// menu RDW
	$(".menu-rwd-trigger").bind('click', function (e) {
		if ($(".main").hasClass("main-header-open"))  {
			$(".main").removeClass("main-header-open");
		}  else {
			$(".main").addClass("main-header-open");
		}
		return false;
	});

	// scroll doux
	$(".smooth-scroll").click (function() {
		var target = $(this).attr('href');
		var hash = "#" + target.substring(target.indexOf('#')+1);
		$('html, body').animate({ scrollTop:$(hash).offset().top 	}, 600);
		return false;
	});



});

