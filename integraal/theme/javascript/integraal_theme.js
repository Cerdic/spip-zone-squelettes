;(function($){
	$(function(){
		// … des choses après chargement de la page
		
		// Ajouter un bouton de menu pour les mobiles
		$('.header .container').append(
			$('<a class="menus-toggle" href="#firstnav">Menu</a>')
				.click(function(){
					$('.access, .firstnav').slideToggle();
					return false;
				})
		);
	});
})(jQuery);
