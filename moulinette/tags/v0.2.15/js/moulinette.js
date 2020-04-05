$(document).ready(function(){
	// contourner un bug sur la barnav responsive
	$('a.page-scroll').bind('click', function(){
		$('.navbar-collapse.navbar-right.navbar-main-collapse.collapse.in').animate({height:'1px'},200, function(){
			$(this).removeClass('in');
		});
	});
	
});