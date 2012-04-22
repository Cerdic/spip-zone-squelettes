// script communs à tout le site
/***************************************************
	  PINNED NAVIGATION
***************************************************/
function element_positions(section){
	var element_y = new Array();
	$(section).each(function(i){
		element_y[i] = parseInt($(this).position().top);
		//alert(i + " " + element_y[i]);
	})
	element_y[element_y.length] = parseInt($("#footer").position().top);
	return element_y;
}

function where(section){
	var offset_y = f_scrollTop();
	var element_y = new Array();
	element_y = element_positions(section);
	var h_prev = 0;
	for(i = 1 ; i <= element_y.length ; i++ ){
		var j = i + 1;
		var h = element_y[i];
	
		if (offset_y > h_prev && offset_y < h){
			var section_id = $(".panel:nth-child(" + j + ")").attr("id");
			var is_animated = $(":not('.slide'):animated").length;
			if (!is_animated){
				$("#nav ul li a, .pinned ul li a").removeClass("current");
				$("#nav ul li a[href=#" + section_id + "], .pinned ul li a[href=#" + section_id + "]").addClass("current");
			}
		}
		h_prev = h;	
	}
}

jQuery(document).ready(function($){
		
	$("#nav ul li a, .pinned ul li a").click(function(){
		$("#menu ul li a, pinned ul li a").removeClass("current");
		$(this).addClass("current");
	})
	
	var win_width = parseInt($("html, body").width());
	var offset_y = f_scrollTop();
	
	if (offset_y > 100 && ($("#nav").hasClass("")) && (win_width > 960) && !is_tablet() ){
		$("#nav").addClass("pinned");
	}
	
	if (win_width <= 960 || is_tablet() ){
		$menu = $("#nav").clone();
		$(".panel:gt(0)").prepend("<div class='pinned'>" + $menu.html() + "</div>");
		$(".panel:gt(0) .pinned ul").prepend("<li><a href='#top'>home</a></li>");
		$(".pinned li a.spip_logos").closest("li").remove();
	
		$(".pinned ul li a, #nav ul li a").click(function(){	  
			$(".pinned ul li a, #nav ul li a").removeClass("current");
			var href = $(this).attr("href");
			$(".pinned ul li a[href='" + href + "']").addClass("current");
			$(".pinned ul li a[href='#top']").removeClass("current");
		})
		
		
	}
	
	
						   
	$(window).scroll(function () {  
		where(".panel");
		var nav_h = parseInt($("#nav").outerHeight());
    	var offset_y = f_scrollTop();
		
		var win_width = parseInt($("html, body").width());
		
		if (win_width > 960 && !is_tablet()){
			$(".pinned").remove();
			if (offset_y > 100){
			  
				if (!$("#nav").hasClass("pinned")){
					$("#nav").fadeOut(function(){
						$("#nav").addClass("pinned").slideDown("slow");
					})
				}	  
			}
			else{
				if ($("#nav").hasClass("pinned")){
					$("#nav").slideUp(function(){
						$("#nav").removeClass("pinned").fadeIn();
					});
				}
			}
		}
		else{
			$(".pinned").remove();
			$menu = $("#nav").clone();
			$(".panel:gt(0)").prepend("<div class='pinned'>" + $menu.html() + "</div>");
			$(".panel:gt(0) pinned ul").prepend("<li><a href='#top'>home</a></li>");
			$(".pinned li a.spip_logos").closest("li").remove();
			
			//if (is_tablet()){
				$(".menu ul li a, #nav ul li a").click(function(){	  
					$(".menu ul li a, #nav ul li a").removeClass("current");
					var href = $(this).attr("href");
					$(".menu ul li a[href='" + href + "']").addClass("current");
					$(".menu ul li a[href='#top']").removeClass("current");
				})
			//}
		}
    });

	


});



/***************************************************
	 ADDITIONAL FUNCTIONS FOR PINNED NAVIGATION
***************************************************/
function f_scrollTop() {
	return f_filterResults (
		window.pageYOffset ? window.pageYOffset : 0,
		document.documentElement ? document.documentElement.scrollTop : 0,
		document.body ? document.body.scrollTop : 0
	);
}
function f_filterResults(n_win, n_docel, n_body) {
	var n_result = n_win ? n_win : 0;
	if (n_docel && (!n_result || (n_result > n_docel)))
		n_result = n_docel;
	return n_body && (!n_result || (n_result > n_body)) ? n_body : n_result;
}

function is_tablet(){
		if (navigator.userAgent.match(/Android/i) ||
	    navigator.userAgent.match(/webOS/i) ||
	    navigator.userAgent.match(/iPhone/i) ||
	    navigator.userAgent.match(/iPod/i) ||
	    navigator.userAgent.match(/iPad/i)) return true; else return false;
}
