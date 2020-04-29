;jQuery(function($) {

	// Au chargement de la page
	$(function() {
		activer_menus_depliants();
		activer_diaporamas();
		gerer_fermables();
		gerer_collapse();
		gerer_modales();
	});

	// Lors de rechargements ajax
	if (window.jQuery){
		$(function(){
			onAjaxLoad(gerer_collapse, gerer_fermables, gerer_modales);
		});
	}
	
	/**
	 * Gérer les menus dépliants
	 * 
	 * Activé sur les menus dont les parents ont les bonnes classes :
	 * 
	 * .menu.menu_folding
	 *   ul.menu-items
	 * 
	 * .menu_folding
	 *   .menu
	 *     ul.menu-items
	 */
	function activer_menus_depliants() {
		// Variante de menu qu'on indique comme étant dépliant
		$(".menu_folding .menu, .menu.menu_folding")
			// On commence par transformer le contenu pour avoir la structure attendu par la lib JS
			.each(function() {
				var menu = $(this);
				
				// On parcourt seulement les entrées racines
				menu.find('.menu-items:first .menu-items__item')
					.each(function() {
						// S'il y a des textes libres sans lien, on transforme
						$(this)
							.find('> .menu-items__texte')
								.wrap('<a role="button" href="#">')
							.parent()
							.siblings()
								.wrap('<div>');
					});
			})
			// On lance la lib d'Adobe
			.accessibleMegaMenu({
				/* prefix for generated unique id attributes, which are required 
					 to indicate aria-owns, aria-controls and aria-labelledby */
				uuidPrefix: "accessible-megamenu",

				/* css class used to define the megamenu styling */
				menuClass: "menu-items_folding",

				/* css class for a top-level navigation item in the megamenu */
				topNavItemClass: "menu-items__topitem",

				/* css class for a megamenu panel */
				panelClass: "menu-items__panel",

				/* css class for a group of items within a megamenu panel */
				panelGroupClass: "menu-items__panelgroup",

				/* css class for the hover state */
				hoverClass: "hover",

				/* css class for the focus state */
				focusClass: "focus",

				/* css class for the open state */
				openClass: "open"
			});
	}

	/**
	 * Diaporamas Slick
	 */
	function activer_diaporamas() {
		$('[data-slideshow]').each(function() {
			var slideshow = $(this);
			
			// On essaye de décoder les params
			var params = slideshow.data('slideshow');
			if (typeof(params) == 'string') {
				try {
					params = JSON.parse(params);
				}
				catch (e) {
					console.error('Erreur dans l’analyse des paramètres supplémentaires', e);
				}
			}
			// Par défaut du vide
			if (typeof(params) != 'object') {
				params = {};
			}
			
			// On lance le diaporama
			slideshow.slick(params);
		});
	}

	/**
	 * Boutons qui ferment des trucs.
	 * On identifie la cible à fermer au moyen de l'attribut data-dismiss.
	 * 2 possibilités pour sa valeur :
	 *   - Si c'est est une ancre, le bouton peut être placé n'importe où.
	 *   - Sinon c'est une chaîne qui correspond à un attribut data-xxx de la cible, et le bouton doit être dans l'élément cible.
	 *
	 * @example
	 * <div data-xxx>
	 *    <button data-dismiss="xxx">
	 */
	function gerer_fermables() {
		$('[data-dismiss]').click(function() {
			var dismiss = $(this).data('dismiss');
			var regex = /^\#/g;
			var is_anchor = dismiss.match(regex);
			if (is_anchor) {
				var $cible = $(dismiss);
			} else {
				var $cible = $(this).closest('[data-'+dismiss+']');
			}
			$cible
				.slideUp(500)
				.animate(
					{ opacity: 0 },
					{ queue: false, duration: 250 }
				);
			return false;
		});
	}

	/**
	 * Boutons qui togglent des trucs
	 * Ce sont des liens qui mènent vers des ancres internes.
	 * Les contenus correspondants sont cachés et affiché uniquement au clic.
	 * 
	 * @example
	 * <a data-toggle="collapse" href="#truc">...</a>
	 * <div id="truc">...<div>
	 */
	function gerer_collapse() {
		$( 'a[data-toggle="collapse"][href]' )
			.each(function(i) {
				var href = $(this).attr('href');
				// Attention, des fois SPIP transforme les ancres en urls absolues
				var cible = href.substring(href.indexOf("#"));
				$(cible).hide();
			})
			.off('click.collapse').on('click.collapse', function(e) {
				e.preventDefault();
				var href = $(this).attr('href');
				// Attention, des fois SPIP transforme les ancres en urls absolues
				var cible = href.substring(href.indexOf("#"));
				$(cible).slideToggle('fast');
				$(this).toggleClass('opened');
			});
	}

	/**
	 * Boutons qui ouvrent des modales
	 * Ce sont des liens qui mènent vers des ancres internes.
	 * Les contenus correspondants sont cachés et affiché uniquement au clic.
	 * 
	 * @example
	 * <a data-toggle="modal" href="#truc">...</a>
	 * <div id="truc">...</div>
	 */
	function gerer_modales() {
		$( 'a[data-toggle="modal"][href]' )
			.each(function(i) {
				var href = $(this).attr('href');
				// Attention, des fois SPIP transforme les ancres en urls absolues
				var cible = href.substring(href.indexOf("#"));
				$(cible).hide();
			})
			.click(function(e){
				e.preventDefault();
				var href = $(this).attr('href');
				// Attention, des fois SPIP transforme les ancres en urls absolues
				var cible = href.substring(href.indexOf("#"));
				var data_title = $(this).data('title');
				var attr_title = $(this).attr('title');
				var title = (typeof(data_title) !== 'undefined' ? data_title : attr_title);
				var w_width = $(window).width();
				var width = '100%';
				if (w_width > screen_mobile_up) {
					width = '80%';
				}
				if (w_width > screen_tablet_up) {
					width = '60%';
				}
				$(cible).show();
				$.modalboxload(cible, {
					title: title,
					overlayClose: false,
					width: width,
					onClose: function(e) {
						var cible = e.cache.href;
						$(cible).hide();
					}
				});
			});
	}

	/**
	 * Recharger une cible en ajax depuis un formulaire
	 *
	 * Nb : pompé du plugin ajaxfiltre
	 *
	 * Recharge automatiquement une cible en ajax à chaque changement du formulaire.
	 * On surveille uniquement les éléments de formulaire à choix pour l'instant (select, radio, checkbox).
	 *
	 * La fonction peut être lancée indifférement sur un formulaire ou sur un parent.
	 *
	 * Les éléments surveillés peuvent avoir un attribut `data-ajaxreload-name`, et dans ce cas là la valeur sera postée avec ce nom.
	 * Inutile de mettre des crochets si c'est une valeur multiple.
	 *
	 * Évolutions :
	 * - Prendre en compte aussi les inputs texte (avec un délai)
	 *
	 * @example
	 *     ````
	 *     $('.formulaire_machin').ajaxFormReload('.list_articles');
	 *     $('.formulaire_machin form').ajaxFormReload('mon_bloc_ajax');
	 *     ````
	 * @see ajaxCallback.js
	 *
	 * @param object el
	 * @param string target
	 *     sélecteur jQuery pour la cible à recharger
	 * @param object options
	 *     Options de ajaxReload complétées avec d'autres :
	 *     - surveiller (String)   : sélecteur jQuery d'éléments à surveiller
	 *                               Défaut : select, radio, checkbox
	 *     - exclure (String)      : sélecteur jQuery d'éléments à exclure
	 *                               Défaut : ''
	 *     - masquer_submit (Bool) : masquer le bouton de validation du formulaire
	 *                               Défaut : true
	 *     - callback (Function)   : Fonction callback appelée après rechargement
	 *     - history (Bool)        : garder l'historique navigateur
	 *                               Défaut: false
	 *     - href (Bool)           : Recharger sur une autre URL
	 */
	$.ajaxFormReload = function(el, target, options) {
		var base = this;

		// Mettre en place les écouteurs d'évènements et cie
		base.init = function() {
			base.$el = $(el); // élément racine (direct un form ou non)
			base.$form = base.$el.prop("tagname") === 'FORM' ? base.$el : base.$el.find('form'); // formulaire
			base.options = $.extend({}, $.ajaxFormReload.defaultOptions, options);

			// Les champs à surveiller
			base.$champs = $(base.options.surveiller).not($(base.options.exclure));

			// Signaler que le formulaire est marabouté
			base.$el.addClass('ajaxformreload ajaxformreload_init');

			// Cacher les boutons submit
			if (base.options.masquer_submit === true) {
				base.$el.find('.boutons').addClass('visually-hidden');
			// Sinon déclencher le rechargement lorsqu'on valide le formulaire
			} else {
				base.$form.on('submit', function(e){
					base.query();
					e.preventDefault();
				});
			}

			// Déclencher rechargement ajax à chaque changement
			base.$champs.on('change', function() {
				base.query();
			});

		};

		// Récupérer les valeurs des champs surveillés
		// puis lancer le rechargement ajax de la cible
		base.query = function() {
			var
				formData = {},
				ajaxreloadOptions = {
					args: formData,
					history: base.options.history,
					callback: base.options.callback,
				};

			$(base.$champs).each(function() {
				var
					name = $(this).attr('name'),
					value = $(this).val();

				// Optionnellement on peut poster la valeur avec un autre nom
				if (typeof($(this).data('ajaxreloadName')) !== 'undefined') {
					name = $(this).data('ajaxreloadName');
				}

				// Retirer les crochets éventuels du name
				if (name.indexOf('[]') !== -1) {
					name = name.replace(/[\[\]]+/g, '');
				}

				// Valeurs multiples
				if (typeof(value) === 'object') {
					if (name in formData === false) {
						formData[name] = [];
					}
					formData[name] = formData[name].concat(value);
				// Valeur unique
				} else {
					formData[name] = value;
				}
			});

			// Passer une valeur vide explicite pour les checkbox
			// dont le name comporte des [] et dans lesquels rien n'est coché
			// Désactivé parcequ'en principe ça fait déjà ça de base. Ou j'ai loupé un truc ?
			/*
			var $checkradio = base.$el.find('input[type=checkbox][name*="[]"]');
			$.each($checkradio,function() {
				var checkRadioName = $(this).attr('name');
				// si rien n'est coché
				if (!base.$el.find('input[name="'+checkRadioName+'"]:checked').length) {
					var name = checkRadioName.replace(/[\[\]]+/g, '');
					// et si on n'a pas déjà des données
					if (!formData[name] || !formData[name].length) {
						// supprimer les données du nom avec []
						delete formData[checkRadioName];
						// ajouter un tableau vide sur le nom sans [] 
						formData[name] = [];
					}
				}
			});
			*/

			// Recharger la cible : soit c'est un sélecteur jQuery...
			// console.log(ajaxreloadOptions);
			if ($(target).length > 0) {
				$(target).ajaxReload(ajaxreloadOptions);
			// ...soit un identifiant ajax
			} else {
				ajaxReload(target, ajaxreloadOptions);
			}
		};

		base.init();
	};
	$.ajaxFormReload.defaultOptions = {
		surveiller: 'select, input[type=checkbox], input[type=radio]',
		exclure: '',
		masquer_submit: true,
		history: null,
		callback: null,
		href: null,
	};
	$.fn.ajaxFormReload = function(target, options) {
		return this.each(function() {
			(new $.ajaxFormReload(this, target, options));
		});
	};

});
