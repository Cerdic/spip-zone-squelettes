/**
 * Fonction pour les codes embed
 * Au click / focus d'un textarea ou input ayant la class .code_embed,
 * On sélectionne automatiquement l'ensemble du contenu
 * 
 * TODO Il faudrait peut mettre ce code dans le plugin d'embed code 
 */
var mediaspip_embed = function(){
	jQuery('.code_embed').each(function(){
		var parent = jQuery(this).parents('div.info-embed');
		if(parent.find('span.title').size() > 0){
			var id_code = parent.find('textarea').attr('id');
			parent.find('.formulaire_embed_code').hide();
			parent.find('span.title').append('<span class="show_code show_code_plus">&nbsp;+</span>').wrapInner('<a class="show_code" href="#'+id_code+'"></a></span>');
		}
		jQuery('.show_code').click(function(){
			var parent = jQuery(this).parents('div.info-embed');
			if(parent.find('.formulaire_embed_code').is(':hidden')){
				parent.find('.formulaire_embed_code').slideDown("normal");
				parent.find('span.show_code').html('&nbsp;-').removeClass('show_code_plus').addClass('show_code_moins');
    		}else{
				parent.find('.formulaire_embed_code').slideUp("normal");
    			parent.find('span.show_code').removeClass('show_code_moins').addClass('show_code_plus').html('&nbsp;+');
    		}
			return false;
		});
	});
	jQuery('.copypaste').click(function(){
		jQuery(this).focus().select();
	});
}

/**
 * On vire certains champs de formulaires non désirés
 * Ils doivent aussi être cachés via CSS 
 * - le champ ajout_rapide de polyhierarchie
 */
var mediaspip_supprimer_visu = function(){
	jQuery(".item_picker .choix_rapide").detach();
}

var mediaspip_sous_menus = function(){
	// On cache les sous-menus :
    jQuery("#nav ul li ul").each(function(){
		// On récupère les width des menus pour fixer celle du parent
		var width = jQuery(this).outerWidth()+2;
		jQuery(this).parents('li').css({'width':width+'px'});
		jQuery(this).hide();
	});

    // On modifie l'évènement "click" sur les liens dans les items de liste
    // qui portent la classe "toggleSubMenu" :
    jQuery("#nav ul li").hover(
    	function(){
    		var ul = jQuery(this).find('ul');
    		if(ul.is(':hidden'))
    			ul.slideDown("normal");
        },
		function(){
        	var ul = jQuery(this).find('ul');
        	if(ul.is(':visible')){
				ul.slideUp("normal").bind('mouseouver',function(){
					ul.slideDown("normal");
				});
        	}
		}
    );
}

var mediaspip_hauteur_blocs = function(){
	if(typeof(jQuery.fn.equalHeights) ==  'function'){
		jQuery('.liste_medias_vignettes').each(function(){
			jQuery(this).find('.thumbnail').equalHeights();
		});
		jQuery('.zengarden .liste_themes .theme').equalHeights();
		if(jQuery('#liste_editos').size() > 1)
			jQuery('#liste_editos').equalHeights();
		if(jQuery('#liste_actus').size() > 1)
			jQuery('#liste_actus').equalHeights();
	}
}

/**
 * L'exergue de la home en slider
 * si on a plusieurs éléments
 */
var mediaspip_sliders = function(){
	if(window.$.fn.easySlider && jQuery('#exergue ul li').size() > 1){
		jQuery('#exergue ul li img').each(function(){
			var width = $(this).width();
			$(this).css({'width':width+'px'})
		});
		jQuery("#exergue").easySlider({numeric: true});
		/**
		 * Changement de slide, on met en pause les vidéos et sons en lecture dans les autres slides
		 */
		jQuery("#exergue").parent().find("#controls li").click(function(){
			if(!jQuery(this).is('.current')){
			    jQuery("#exergue video,#exergue audio").each(function(){
			    	media = jQuery(this)[0];
			    	if(!media.paused && !media.ended && media.currentTime != 0)
			    		jQuery(this)[0].pause();
			    });
			}
		});
	}
}

/**
 * Afficher proprement les svg depuis leur balise object
 */
var mediaspip_svg = function(){
	if(jQuery('object[type="image/svg+xml"]').size() > 0){
		jQuery('object[type="image/svg+xml"]').each(function(){
			var height = jQuery(this).height();
			jQuery(this).parent().append('<div class="svg"></div>');
			var div = jQuery(this).parent().find('.svg');
			if(height > 0)
				div.height(height);
			div.svg({ 
			    loadURL: jQuery(this).attr('data'), // External document to load 
			    onLoad: null, // Callback once loaded 
			    settings: {}, // Additional settings for SVG element 
			    initPath: ''});
			jQuery(this).detach();
		});	
	}
}

/**
 * Les fonctions à recharger à chaque ajaxload
 * 
 * On évite ainsi de charger à bloc le tableau
 */
var mediaspip_ajaxload = function(){
	mediaspip_supprimer_visu();
	mediaspip_svg();
	setTimeout(mediaspip_hauteur_blocs, 3000);
}
/**
 * Lancement au chargement de la page des fonctions
 */
jQuery(function(){
	var login = jQuery('#extra1 .formulaire_login');
	var parent_login_h2 = jQuery('#extra1 .formulaire_login').parent().prev('h2');
	if((login.parent('.visible').size() == 0) && (login.find('.reponse_formulaire_erreur').size() == 0)){
		login.hide();
		if(parent_login_h2.find('.show_login').size() == 0)
			parent_login_h2.wrapInner('<span class="show_login"><a href="#"></a></span>').append('<span class="show_login_plus"><a href="#">&nbsp;+</a></span>');
	}
	else{
		if(parent_login_h2.find('.show_login').size() == 0)
			parent_login_h2.wrapInner('<span class="show_login"><a href="#"></a></span>').append('<span class="show_login_plus"><a href="#">&nbsp;-</a></span>');
		login.find('input.password').focus();
	}

	jQuery('.show_login,.show_login_plus').click(function(e){
		if(login.is(':visible')){
			e.preventDefault();
			jQuery('.show_login_plus a').html('&nbsp;+');
			login.slideUp('slow');
		}else{
			e.preventDefault();
			jQuery('.show_login_plus a').html('&nbsp;-');
			login.slideDown('slow');
		}
		return false;
	});

	mediaspip_svg();
	setTimeout(mediaspip_hauteur_blocs, 3000);
	mediaspip_embed();
	mediaspip_sous_menus();
	mediaspip_sliders();
	//jQuery(window).load(function(){mediaspip_sliders()});
	mediaspip_supprimer_visu();
	onAjaxLoad(mediaspip_ajaxload);
});