$(document).ready(function(){
	// afficher/masquer le menu
	$('.btn-nav').bind('click', function(){
		$(this).siblings('ul').toggleClass('ouvert');
	});
});