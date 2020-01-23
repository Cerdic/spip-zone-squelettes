jQuery(function($){

	// le menu des articles
	var h = $('#sousnavmasquee').height();
	$('body').prepend('<style>#sousnavmasquee nav.fermer { margin-top:-' + h + 'px; }</style>');
	// afficher/masquer le menu
	$('#sousnavmasqueeToggle').on('click', function(){
		$(this).toggleClass('active');
		$('#sousnavmasquee nav').toggleClass('fermer');
		return false;
	});
	
	
});