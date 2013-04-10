/**
 * Fonction pour les codes embed
 * Au click / focus d'un textarea ou input ayant la class .code_embed,
 * On sélectionne automatiquement l'ensemble du contenu
 */
var mediaspip_embed = function(){
	jQuery('.code_embed').each(function(){
		if(jQuery(this).parents('div.info-embed').find('span.title').size() > 0){
			var id_code = jQuery(this).parents('div.info-embed').find('textarea').attr('id');
			jQuery(this).parents('div.info-embed').find('.formulaire_embed_code').hide();
			jQuery(this).parents('div.info-embed').find('span.title').append('<span class="show_code show_code_plus">&nbsp;+</span>').wrapInner('<a class="show_code" href="#'+id_code+'"></a></span>');
		}
		jQuery('.show_code').click(function(){
			if(jQuery(this).parents('div.info-embed').find('.formulaire_embed_code').is(':hidden')){
				jQuery(this).parents('div.info-embed').find('.formulaire_embed_code').slideDown("normal");
				jQuery(this).parents('div.info-embed').find('span.show_code').html('&nbsp;-').removeClass('show_code_plus').addClass('show_code_moins');
    		}else{
				jQuery(this).parents('div.info-embed').find('.formulaire_embed_code').slideUp("normal");
    			jQuery(this).parents('div.info-embed').find('span.show_code').removeClass('show_code_moins').addClass('show_code_plus').html('&nbsp;+');
    		}
			return false;
		});
	});
	jQuery('.copypaste').click(function(){
		jQuery(this).focus().select();
	});
}

var mediaspip_supprimer_visu = function(){
	/**
	 * On vire certains champs de formulaires non désirés
	 * Ils doivent aussi être cachés via CSS 
	 * - le champ ajout_rapide de polyhierarchie
	 */
	jQuery(".item_picker .choix_rapide")
		.detach();
}

var mediaspip_infos_techniques = function(){
	$('.em_infos_supp_documents').unbind().each(function(){
		$(this).find('div').hide();
		if($(this).find('strong a').size() == 0){
			$(this).find('strong').eq(0).wrapInner('<a href="#"></a>');
		}
		$(this).find('strong a').unbind().click(function(e){
			$(this).parent().parent().find('div').toggle('slow');
			return false;
		});
	});
}

var mediaspip_sous_menus = function(){
	// On cache les sous-menus :
    $("#nav ul li ul").each(function(){
		// On récupère les width des menus pour fixer celle du parent
		var width = jQuery(this).outerWidth()+2;
		$(this).parents('li').css({'width':width+'px'});
		$(this).hide();
	});

    // On modifie l'évènement "click" sur les liens dans les items de liste
    // qui portent la classe "toggleSubMenu" :
    $("#nav ul li").hover(function () {
    		if($(this).find('ul').is(':hidden')){
    			$(this).find('ul').slideDown("normal");
    		}
        },
		function(){
        	if($(this).find('ul').is(':visible')){
				$(this).unbind('mousehover').find('ul').slideUp("normal").bind('mouseouver',function(){
					$(this).find('ul').slideDown("normal");
				});
        	}
		}
    );
}

var mediaspip_hauteur_blocs = function(){
	if(typeof(jQuery.fn.equalHeights) ==  'function'){
		$('.liste_medias_vignettes').each(function(){
			$(this).find('.vignette').equalHeights();
		});
		$('#liste_actus,#liste_editos,.zengarden .liste_themes .theme').equalHeights();
		$('#exergue ul li').equalHeights();
	}
}

var mediaspip_sliders = function(){
	if($('#exergue ul li').size() > 1){
		$("#exergue").easySlider({
			numeric: true
		});
	}
}

var mediaspip_svg = function(){
	if($('object[type="image/svg+xml"]').size() > 0){
		$('object[type="image/svg+xml"]').each(function(){
			var height = $(this).height();
			$(this).parent().append('<div class="svg"></div>');
			var div = $(this).parent().find('.svg');
			if(height > 0){
				div.height(height);
			}
			div.svg({ 
			    loadURL: $(this).attr('data'), // External document to load 
			    onLoad: null, // Callback once loaded 
			    settings: {}, // Additional settings for SVG element 
			    initPath: ''});
			$(this).detach();
		});	
	}
}

/**
 * Lancement au chargement de la page des fonctions
 */
jQuery(document).ready(function(){
	if(($('#navigation .formulaire_login').parent('.visible').size() == 0) && ($('#navigation .formulaire_login .reponse_formulaire_erreur').size() == 0)){
		$('#navigation .formulaire_login').hide();
		if($('#navigation .formulaire_login').parent().prev('h2').find('.show_login').size() == 0){
			$('#navigation .formulaire_login').parent().prev('h2').wrapInner('<span class="show_login"><a href="#"></a></span>').append('<span class="show_login_plus"><a href="#">&nbsp;+</a></span>');
		}
	}
	else{
		if($('#navigation .formulaire_login').parent().prev('h2').find('.show_login').size() == 0){
			$('#navigation .formulaire_login').parent().prev('h2').wrapInner('<span class="show_login"><a href="#"></a></span>').append('<span class="show_login_plus"><a href="#">&nbsp;-</a></span>');
		}
		$('#navigation .formulaire_login input.password').focus();
	}

	$('.show_login,.show_login_plus').click(function(e){
		if($('#navigation .formulaire_login').is(':visible')){
			e.preventDefault();
			$('.show_login_plus a').html('&nbsp;+');
			$('#navigation .formulaire_login').slideUp('slow');
		}else{
			e.preventDefault();
			$('.show_login_plus a').html('&nbsp;-');
			$('#navigation .formulaire_login').slideDown('slow');
		}
		return false;
	});

	mediaspip_svg();
	mediaspip_hauteur_blocs();
	mediaspip_embed();
	mediaspip_infos_techniques();
	mediaspip_sous_menus();
	mediaspip_sliders();
	mediaspip_supprimer_visu();
	onAjaxLoad(mediaspip_svg);
	onAjaxLoad(mediaspip_infos_techniques);
	onAjaxLoad(mediaspip_hauteur_blocs);
	onAjaxLoad(mediaspip_supprimer_visu);
});