/**
 * Navigation javascript des menus
 * sur les éléments de la div #aside ayant les class .menu et .rubriques
 * on applique un effet d'ouverture au survol
 */

(function($){
	$(document).ready(function(){
		/*
		 * Menu depliant de navigation
		 */
		$('#aside .menu.rubriques li:not(.ouverte) ul,#aside .menu.important:not(.diogene) li:not(.ouverte) ul').hide();
		function menu_mediaspip() {
			$('#aside .menu.rubriques li a,#aside .menu.rubriques li .bouton_action_post, #aside .menu.rubriques li .titre,#aside .menu.important:not(.diogene) li a,#aside .menu.rubriques li .titre,#aside .menu.important li .bouton_action_post, #aside .menu.important li .titre').each(function(){
				var me = $(this)
				if (me.parent().find('>ul').is(':visible')) {
					me.addClass('ouverte');
				}else if (me.parent().find('>ul').is(':hidden')) {
					me.addClass('fermee');
				}
			});
			$('#aside .menu.rubriques li a,#aside .menu.rubriques li .bouton_action_post, #aside .menu.rubriques li .titre,#aside .menu.important:not(.diogene) li a,#aside .menu.rubriques li .titre,#aside .menu.important li .bouton_action_post, #aside .menu.important li .titre').not('.do').addClass('do').hover(function(){
				var me=$(this);
				var time=400;
				// un temps plus long pour refermer !
				if (me.parent().find('>ul').is(':visible'))
					time=1000;

				me.addClass('hop');
				setTimeout(function(){
					// verifier que la souris n'est pas deja partie !
					if (me.is('.hop')) {
						var parent = me.parent(); // parent = li
						// verifier que ce n'est pas une liste exposee
						if (!parent.is('.on')) {
							// fermer les ul
							var ul = parent.find('>ul');
							if (ul.is(':visible')) {
								ul.find('li:not(.ouverte) ul').hide();
								ul.slideUp('fast');
								me.removeClass('ouverte');
								me.addClass('fermee');
							// ou ouvrir le premier
							} else {
								// selon la config de documentations
								// il faut peut etre charger en ajax le contenu
								// de la navigation, uniquement pour les ul
								// de premier niveau.
								if (ul.size()) {
									ul.slideDown('fast');
									me.removeClass('fermee');
									me.addClass('ouverte');
								}
							}
						}
					}
				}, time);
			},function(){
				$(this).removeClass('hop');
			});
		}
		menu_mediaspip();
		onAjaxLoad(menu_mediaspip);
	});
})(jQuery);