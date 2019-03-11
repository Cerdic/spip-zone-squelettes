jQuery(function($){

	// le menu des articles
	var h = $('#sousnav').height();
	$('body').prepend('<style>#sousnav nav.fermer { margin-top:-' + h + 'px; }</style>');
	// afficher/masquer le menu
	$('#sousnavToggle').on('click', function(){
		$(this).toggleClass('active');
		$('#sousnav nav').toggleClass('fermer');
		return false;
	});
	
	
});