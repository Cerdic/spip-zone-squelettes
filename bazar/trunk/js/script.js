$(document).ready(function(){
	// placer le html du bouton du menu sous 768px
	$('.nav').prepend('<button type="button" class="btn-nav" aria-label="afficher/masquer le menu de navigation"><span class="ham"></span><span class="ham"></span>MENU</button>');
	// afficher/masquer le menu
	$('.btn-nav').bind('click', function(){
		$(this).siblings('ul').toggleClass('ouvert');
	});
});