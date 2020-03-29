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
		
		// Afficher la grille typo si besoin pendant le dev
		function debug_grille(){
			var link = document.createElement("link");
			link.setAttribute("rel", "stylesheet");
			link.setAttribute("href", "http://basehold.it/"+parseInt(window.getComputedStyle(document.body).getPropertyValue("line-height"),10));
			document.head.appendChild(link);
		}
		//debug_grille();
		
	});
})(jQuery);
