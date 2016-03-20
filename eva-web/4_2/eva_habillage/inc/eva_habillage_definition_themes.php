<?php
function eva_habillage_definition_themes () {

	//Définition des sélecteurs de personnalisation d'EVA (on regroupe les sécteurs en fonction du thè et de la propriété concernée)
	//Fond d'écran
	$eva_fond_ecran_background = array('body');
	//Fond des pages
	$eva_fond_page_background = array('div#page');
	//Fond des blocs
	$eva_fond_bloc_background = array('#forum ul.forum div.contenu','blockquote.spip','#forum ul.forum div.auteur','#forum ul.forum div.texte','#forum ul.forum','hr','.spip_cadre','textarea.spip_cadre','fieldset','#formrecherche','#forum ul.forum div.titre .auteur','.divers div.contenu','div#contenu ul','div.bloc ul','div#contenu .bloc','div#menu .bloc','div#menudroit .bloc','div.bloc','ul#sommaire','div#menu .bloc ul','div#menudroit .bloc ul');
	//Fond de l'éditorial et des chapeaux
	$eva_fond_edito_background = array('.edito .titre','div#photo img','div#contenu div.chapo','div.edito','div#entetediaporama','div#boutondiaporama a span');
	//Entêtes des pages
	$eva_entete_page_background = array('div#entete');
	//Barres des liens et de l'arborescence situées au-dessus de l'entête de la page, bloc affichant l'auteur et la date de publication
	$eva_barres_entete_background = array('div#entete ul.liens');
	//Barres d'arborescence situé sous l'entête de la page
	$eva_barres_entete_arborescence_background = array('div#arborescence');
	//Secteur présentant les auteurs et la date
	$eva_barres_entete_auteur_background = array('#auteursdates','.edito .titre div#auteursdates','.bloc #auteursdates');
	//Fond des titres de l'entête
	$eva_barres_entete_texte_background = array('div#entete h1 span','div#entete h2 span');
	//Fond du secteur de sur-titre, titre et sous-titre
	$eva_fond_titre_article_background = array ('.bloc .titre');
	//Pied de page
	$eva_pied_page_background = array('ul#pied');
	//Pied de page : barre des logos
	$eva_pied_logo_background = array('#logo-pied');
	//Fond des titre des blocs,du menu, des premiers éléments des tableaux générés par SPIP
	$eva_fond_titres_background = array('h3','h3.titre','legend','.divers','.divers h4','table.spip tr.row_first th','div#contenu div.ps h4','div#menu h3.titre','div#menudroit h3.titre','table.spip tr.row_first','div#contenu div.lien','div#contenu div.notes h4','div#contenu h4.titre','div#contenu h3.titre','#forum ul.forum div.titre h4');
	$eva_fond_titres_background_color = array('#forum .bouton a','#forum .bouton a:hover');
	//Fonds du menu de navigation
	$eva_menu_fond_background_color = array('ul#sommaire', 'ul#sommaire li');
	//Fonds des secteurs inactifs du menu
	$eva_menu_off_background = array('ul#albumvignettes li.on a:hover img','ul#albumvignettes li a img','div#menu ul#sommaire .off','div#menu ul#sommaire li','div#menudroit ul#sommaire .off','div#menudroit ul#sommaire li');
	//Fond du secteur actif du menu
	$eva_menu_on_background = array('ul#albumvignettes li a:hover img','ul#albumvignettes li.on a img','div#menu ul#sommaire .on','div#menudroit ul#sommaire .on');
	//Fonds des listes d'éléments impairs
	$eva_liste_impair_background = array('.spip tr.row_even td','div#menu .bloc ul li.un','div#menudroit .bloc ul li.un','div#contenu ul li.un');
	//Fonds des listes d'éléments pairs
	$eva_liste_pair_background = array('.spip tr.row_odd td','div#menu .bloc ul li.deux','div#menudroit .bloc ul li.deux','div#contenu ul li.deux');
	//Type de police de caractères, hors formulaire, <code>...</code>, ...
	$eva_police_type_font_family = array('body');
	//Couleur du texte du site
	$eva_texte_principal_color = array('#forum ul.forum div.contenu','blockquote.spip','#forum ul.forum div.auteur','#forum ul.forum div.texte','#forum ul.forum','body','div#menu .bloc ul li','div#contenu .bloc ul li','div#menudroit .bloc ul li','.menupaginationbas','li .menupaginationbas','.menupaginationhaut','li .menupaginationhaut','div#contenu .bloc','div#menu .bloc','div#menudroit .bloc','div#contenu ul li','div .contenu','.divers','.erreur','hr','.spip_cadre','textarea.spip_cadre','fieldset','div#contenu','div#contenu .bloc','.bloc','ul#sommaire','div#menu .bloc ul','div#menudroit .bloc ul','div#contenu .bloc ul li','.auteur');
	//Couleur du texte des listes paires
	$texte_liste_paire_color = array('div#menu .bloc ul li.deux','div#menudroit .bloc ul li.deux','div#contenu ul li.deux','div#contenu ul li.deux h2','table.spip tr.row_odd','div#contenu ul.bloc li.deux');
	//Couleur du texte des listes impaire
	$texte_liste_impaire_color = array('div#menu .bloc ul li.un','div#contenu ul li.un','div#contenu ul li.un h2','div#menudroit .bloc ul li.un','table.spip tr.row_odd','div#contenu ul.bloc li.un');
	//Couleur du texte des secteurs d'entete
	$texte_entetes_color = array('div#entete h1 a','div#entete h2');
	//Couleur du texte des sur-titres
	$texte_surtitre_color = array('.titre h4.surtitre');
	//Couleur du texte des titres
	$texte_titre_color = array('.titre h2','div#contenu h2');
	//Couleur du texte des sous-titres
	$texte_soustitre_color = array('.titre h4.soustitre');
	//Couleur des textes du menu de navigation
	$couleur_liens_menu_color = array('ul#sommaire a');
	//Couleur du texte du secteur courant dans le menu de navigation
	$couleur_liens_menu_actif_color = array('ul#sommaire a.on','ul#sommaire ul a.on');
	//Couleur des textes du menu de navigation lors du survol
	$couleur_liens_menu_survol_color = array('ul#sommaire a:hover','ul#sommaire ul a:hover');
	//Couleur des textes des titres des blocs
	$texte_barres_entete_color = array('h3','h3.titre','h3.titre a','h3 a','div#contenu h3','legend','#forum .bouton a','.bloc .titre','.divers h4','table.spip tr.row_first th','div#contenu div.ps h4','div#menu h3.titre','div#menudroit h3.titre','table.spip tr.row_first','div#contenu div.lien','.contenu .lien','div#contenu div.notes h4','div#contenu h4.titre','div#contenu h3.titre','#forum ul.forum div.titre h4');
	//Couleur de le première lettre des titres des blocs
	$texte_premiere_lettre_entete_color = array('h3:first-letter','h3.titre:first-letter','h3.titre a:first-letter','.titre h2:first-letter','#forum .bouton a:first-letter','.bloc .titre:first-letter','.divers h4:first-letter','div#contenu div.lien:first-letter','div#contenu div.ps h4:first-letter','div#contenu div.notes h4:first-letter','div#contenu div.lien:first-letter','.contenu .lien:first-letter','div#contenu h4.titre:first-letter','div#contenu h3:first-letter','div#contenu .bloc h3:first-letter','div#contenu .bloc h3.titre:first-letter','div#menu h3:first-letter','div#menuDroit h3:first-letter','.divers h4:first-letter','h3:first-letter');
	//Couleur du texte de l'Editorial et des chapeaux
	$texte_edito_color = array('div#contenu .edito','div#contenu div.chapo','div#entetediaporama h2','div#boutondiaporama a span');
	//Couleur du texte du titre de l'éditorial
	$texte_edito_titre_color = array('div#contenu .edito h3.titre','div#contenu .edito h2.titre','.edito .titre','div#contenu .edito .titre a','.edito h2 a');
	//Couleur de la première lettre du texte du titre de l'éditorial
	$texte_edito_titre_premier_color = array('div#contenu .edito h3.titre:first-letter','.edito .titre:first-letter');
	//Couleur du texte dans les barres des liens et d'arborescence
	$texte_entete_arborescence_color = array('div#arborescence','div#arborescence a','div#arborescence strong','div#arborescence em','div#entete ul.liens','div#entete ul.liens a','div#entete ul.liens li.on a');
	//Couleur du texte du secteur d'auteur
	$texte_auteur_color = array('#auteursdates','.edito .titre div#auteursdates a','#auteursdates a','.bloc #auteursdates li','.bloc #auteursdates li a');
	//Couleur des textes du pied de page
	$texte_pied_color = array('ul#pied','ul#pied a','ul#pied li.on a','ul#pied a:hover','ul#pied p a:hover');
	//Couleur des liens
	$couleur_lien_color = array('h4.titre a','div#boutondiaporama a','a','.texte a','div#menu .bloc ul li a.on','div#menu .bloc ul li.on strong','div#menudroit .bloc ul li a.on','div#menudroit .bloc ul li.on strong');
	//Couleur des liens survolés
	$couleur_lien_survol_color = array('div#boutondiaporama a:hover','#forum .bouton a:hover','.texte a:hover','a:hover','div#contenu a:hover','div#menu .bloc ul a:hover','div#menudroit .bloc ul a:hover','div#arborescence a:hover','div#entete ul.liens a:hover');
	//Couleur des liens des listes impaires
	$couleur_lien_impair_color = array('div#menudroit .bloc ul li.un a','div#menu .bloc ul li.un a','div#contenu .bloc li.un a','.bloc li .un a');
	//Couleur des liens des listes impaires lors du survol
	$couleur_lien_impair_survol_color = array ('div#menudroit .bloc ul li.un a:hover','div#menu .bloc ul li.un a:hover','div#contenu .bloc li.un a:hover','div#contenu .un a:hover');
	//Couleur des liens des listes paires
	$couleur_lien_pair_color = array('div#menudroit .bloc ul li.deux a','div#menu .bloc ul li.deux a','div#contenu .bloc li.deux a','.bloc li .deux a');
	//Couleur des liens des listes paires lors du survol
	$couleur_lien_pair_survol_color = array('div#menudroit .bloc ul li.deux a:hover','div#menu .bloc ul li.deux a:hover','div#contenu .bloc li.deux a:hover','div#contenu .deux a:hover');
	//Couleur des bordures de la page, largeur et styles
	$bordure_page_border_color = array('div#page');
	//Couleur principale des bordures
	$couleur_bordure_color =array('.divers','hr');
	$couleur_bordure_border_color = array('div#contenu .bloc','div#menu .bloc','div#menudroit .bloc','.divers','hr','div#boutondiaporama a span','div #entetediaporama','div #entetediaporama h2 span','.lien','.divers','.bloc','#forum .bouton a','#formRecherche','input.formrecherche','fieldset','.forml','textarea.spip_cadre','table.spip th','table.spip td','table.spip tr.row_odd','table.spip tr.row_even','hr','.spip_encadrer','a.spip_barre img','a.spip_barre:hover img');
	$couleur_bordure_border_top_color = array('h3','#forum ul.forum div.titre h4','.menupaginationbas');
	$couleur_bordure_right_color = array('#forum ul.forum div.titre h4','#forum ul.forum div.titre .auteur','#forum ul.forum div.contenu');
	$couleur_bordure_bottom_color = array('h3','#forum ul.forum div.contenu','.menupaginationhaut');
	$couleur_bordure_left_color = array('#forum ul.forum div.titre h4','#forum ul.forum div.titre .auteur','#forum ul.forum div.contenu','div.spip_poesie');
	//Couleur des bordures des secteurs d'entête
	$couleur_bordure_entete_border_color = array('div#entete h2 span','div#entete h1 span');
	$couleur_bordure_entete_border_top_color = array('div#entete ul.liens a:hover');
	$couleur_bordure_entete_bottom_color = array('div#arborescence','div#entete ul.liens','div#entetediaporama','div#entete');
	$couleur_bordure_entete_left_color = array('div#entete ul.liens li');
	//Couleur, taille, style des bordures du secteur de sous-titre, de titre et de sur-titre
	$bordure_couleur_titre_border = array('.titre');
	//Couleur des bordures du secteur d'auteur
	$couleur_bordure_auteur_color = array('#auteursdates');
	//Couleur de la bordure de l'éditorial
	$couleur_bordure_edito_border_color = array('div#contenu .edito','div#entetediaporama','div#boutondiaporama a span');
	//Couleur des bordures des secteurs de pied de page
	$couleur_bordure_pied_border_top_color = array('ul#pied a:hover','#logo-pied','ul#pied');
	$couleur_bordure_pied_bottom_color = array('ul#pied a:hover');
	$couleur_bordure_pied_left_color = array('ul#pied li');
	//Couleur de la bordure encadrant le menu de navigation
	$couleur_bordure_menu_border_color = array('ul#sommaire');
	//Couleur des bordures des secteurs du menu de navigation
	$couleur_bordure_menu_secteurs_border_color = array('ul#sommaire li');
	//Largeur de la page
	$largeur_page_width = array('div#page','div#entete ul.liens');
	//Largeur du menu de gauche
	$largeur_menu_width = array('div#menu');
	//Largeur du menu de droite
	$largeur_menudroite_width = array('div#menudroit');
	//Largeur du contenu
	$largeur_contenu_width = array('div#contenu');
	//Hauteur du secteur d'entête
	$hauteur_entete_height = array('div#entete');
	//Déplacement horizontal des boutons d administration
	$deplacement_horizontal_bouton_admin_right = array('div .spip-admin-float','html body .spip-admin-float');
	//Déplacement vertical des boutons d administration
	$deplacement_vertical_bouton_admin_top = array('div .spip-admin-float','html body .spip-admin-float');
    
//Définition générale des thêmes de personnalisation d'EVA (on regroupe les propriétées définies ci-dessus en fonction du thême CSS concerné)
	$eva_fond_ecran = array(
		'background' => $eva_fond_ecran_background
	);
	$eva_fond_page = array(
		'background' => $eva_fond_page_background
	);
	$eva_fond_bloc = array(
		'background' => $eva_fond_bloc_background
	);
	$eva_fond_edito = array(
		'background' => $eva_fond_edito_background
	);
	$fond_titre_edito = array(
		'background' => $texte_edito_titre_color
	);
	$eva_entete_page = array(
		'background' => $eva_entete_page_background
	);
	$eva_barres_entete = array(
		'background' => $eva_barres_entete_background
	);
	$eva_barres_entete_arborescence = array(
		'background' => $eva_barres_entete_arborescence_background
	);
	$eva_barres_entete_auteur = array(
		'background' => $eva_barres_entete_auteur_background
	);
	$eva_barres_entete_texte = array(
		'background' => $eva_barres_entete_texte_background
	);
	$eva_fond_titre_article = array(
		'background' => $eva_fond_titre_article_background
	);
	$eva_pied_page = array(
		'background' => $eva_pied_page_background
	);
	$eva_pied_logo = array(
		'background' => $eva_pied_logo_background
	);
	$eva_fond_titres = array(
		'background' => $eva_fond_titres_background,
		'background-color' => $eva_fond_titres_background_color
	);
	$eva_menu_fond = array(
		'background-color' => $eva_menu_fond_background_color
	);
	$eva_menu_off = array(
		'background' => $eva_menu_off_background
	);
	$eva_menu_on = array(
		'background' => $eva_menu_on_background
	);
	$eva_liste_impair = array(
		'background' => $eva_liste_impair_background
	);
	$eva_liste_pair = array(
		'background' => $eva_liste_pair_background
	);
	$eva_police_type = array(
		'font-family' => $eva_police_type_font_family
	);
	$eva_texte_principal = array(
		'color' => $eva_texte_principal_color
	);
	$texte_liste_paire = array(
		'color' => $texte_liste_paire_color
	);
	$texte_liste_impaire = array(
		'color' => $texte_liste_impaire_color
	);
	$texte_entetes = array(
		'color' => $texte_entetes_color
	);
	$texte_surtitre = array(
		'color' => $texte_surtitre_color
	);
	$texte_titre = array(
		'color' => $texte_titre_color
	);
	$texte_soustitre = array(
		'color' => $texte_soustitre_color
	);
	$couleur_liens_menu = array(
		'color' => $couleur_liens_menu_color
	);
	$couleur_liens_menu_actif = array(
		'color' => $couleur_liens_menu_actif_color
	);
	$couleur_liens_menu_survol = array(
		'color' => $couleur_liens_menu_survol_color
	);
	$texte_barres_entete = array(
		'color' => $texte_barres_entete_color
	);
	$texte_premiere_lettre_entete = array(
		'color' => $texte_premiere_lettre_entete_color
	);
	$texte_edito = array(
		'color' => $texte_edito_color
	);
	$texte_edito_titre = array(
		'color' => $texte_edito_titre_color
	);
	$texte_edito_titre_premier = array(
		'color' => $texte_edito_titre_premier_color
	);
	$texte_entete_arborescence = array(
		'color' => $texte_entete_arborescence_color
	);
	$texte_auteur = array(
		'color' => $texte_auteur_color
	);
	$texte_pied = array(
		'color' => $texte_pied_color
	);
	$couleur_lien = array(
		'color' => $couleur_lien_color
	);
	$couleur_lien_survol = array(
		'color' => $couleur_lien_survol_color
	);
	$couleur_lien_impair = array(
		'color' => $couleur_lien_impair_color
	);
	$couleur_lien_impair_survol = array(
		'color' => $couleur_lien_impair_survol_color
	);
	$couleur_lien_pair = array(
		'color' => $couleur_lien_pair_color
	);
	$couleur_lien_pair_survol = array(
		'color' => $couleur_lien_pair_survol_color
	);
	$bordure_page = array(
		'border-color' => $bordure_page_border_color
	);
	$bordure_largeur_page = array(
		'border-width' => $bordure_page_border_color
	);
	$bordure_style_page = array(
		'border-style' => $bordure_page_border_color
	);
	$couleur_bordure = array(
		'color' => $couleur_bordure_color,
		'border-color' => $couleur_bordure_border_color,
		'border-top-color' => $couleur_bordure_border_top_color,
		'border-right-color' => $couleur_bordure_right_color,
		'border-bottom-color' => $couleur_bordure_bottom_color,
		'border-left-color' => $couleur_bordure_left_color
	);
	$couleur_largeur_bordure = array(
		'border-width' => $couleur_bordure_border_color,
		'border-top-width' => $couleur_bordure_border_top_color,
		'border-right-width' => $couleur_bordure_right_color,
		'border-bottom-width' => $couleur_bordure_bottom_color,
		'border-left-width' => $couleur_bordure_left_color
	);
	$couleur_style_bordure = array(
		'border-style' => $couleur_bordure_border_color,
		'border-top-style' => $couleur_bordure_border_top_color,
		'border-right-style' => $couleur_bordure_right_color,
		'border-bottom-style' => $couleur_bordure_bottom_color,
		'border-left-style' => $couleur_bordure_left_color
	);
	$couleur_bordure_entete = array(
		'border-color' => $couleur_bordure_entete_border_color,
		'border-top-color' => $couleur_bordure_entete_border_top_color,
		'border-bottom-color' => $couleur_bordure_entete_bottom_color,
		'border-left-color' => $couleur_bordure_entete_left_color
	);
	$couleur_largeur_bordure_entete = array(
		'border-width' => $couleur_bordure_entete_border_color,
		'border-top-width' => $couleur_bordure_entete_border_top_color,
		'border-bottom-width' => $couleur_bordure_entete_bottom_color,
		'border-left-width' => $couleur_bordure_entete_left_color
	);
	$couleur_style_bordure_entete = array(
		'border-style' => $couleur_bordure_entete_border_color,
		'border-top-style' => $couleur_bordure_entete_border_top_color,
		'border-bottom-style' => $couleur_bordure_entete_bottom_color,
		'border-left-style' => $couleur_bordure_entete_left_color
	);
	$bordure_couleur_titre = array(
		'border-color' => $bordure_couleur_titre_border
	);
	$couleur_largeur_titre = array(
		'border-width' => $bordure_couleur_titre_border
	);
	$couleur_style_titre = array(
		'border-style' => $bordure_couleur_titre_border
	);    
	$couleur_bordure_auteur = array(
		'border-color' => $couleur_bordure_auteur_color
	);
	$couleur_largeur_bordure_auteur = array(
		'border-width' => $couleur_bordure_auteur_color
	);
	$couleur_style_bordure_auteur = array(
		'border-style' => $couleur_bordure_auteur_color
	);    
	$couleur_bordure_edito = array(
		'border-color' => $couleur_bordure_edito_border_color
	);
	$couleur_largeur_bordure_edito = array(
		'border-width' => $couleur_bordure_edito_border_color
	);
	$couleur_style_bordure_edito = array(
		'border-style' => $couleur_bordure_edito_border_color
	);
	$couleur_bordure_pied = array(
		'border-top-color' => $couleur_bordure_pied_border_top_color,
		'border-bottom-color' => $couleur_bordure_pied_bottom_color,
		'border-left-color' => $couleur_bordure_pied_left_color
	);
	$couleur_largeur_bordure_pied = array(
		'border-top-width' => $couleur_bordure_pied_border_top_color,
		'border-bottom-width' => $couleur_bordure_pied_bottom_color,
		'border-left-width' => $couleur_bordure_pied_left_color
	);
	$couleur_style_bordure_pied = array(
		'border-top-style' => $couleur_bordure_pied_border_top_color,
		'border-bottom-style' => $couleur_bordure_pied_bottom_color,
		'border-left-style' => $couleur_bordure_pied_left_color
	);
	$couleur_bordure_menu = array(
		'border-color' => $couleur_bordure_menu_border_color
	);
	$couleur_largeur_bordure_menu = array(
		'border-width' => $couleur_bordure_menu_border_color
	);
	$couleur_style_bordure_menu = array(
		'border-style' => $couleur_bordure_menu_border_color
	);
	$couleur_bordure_menu_secteurs = array(
		'border-color' => $couleur_bordure_menu_secteurs_border_color
	);
		$couleur_largeur_bordure_menu_secteurs = array(
		'border-width' => $couleur_bordure_menu_secteurs_border_color
	);
	$couleur_style_bordure_menu_secteurs = array(
		'border-style' => $couleur_bordure_menu_secteurs_border_color
	);
	$largeur_page = array(
		'width' => $largeur_page_width
	);
	$largeur_menu = array(
		'width' => $largeur_menu_width
	);
	$largeur_menudroite= array(
		'width' => $largeur_menudroite_width
	);
	$largeur_contenu = array(
		'width' => $largeur_contenu_width
	);
	$hauteur_entete = array(
		'height' => $hauteur_entete_height
	);
	$deplacement_horizontal_bouton_admin = array(
		'right' => $deplacement_horizontal_bouton_admin_right
	);
	$deplacement_vertical_bouton_admin = array(
		'top' => $deplacement_vertical_bouton_admin_top
	);

// Tableau regroupant les différents thêmes de personnalisation d'EVA
	global $eva_habillage_themes;
	$eva_habillage_themes = array(
		'fond_ecran' => $eva_fond_ecran,
		'fond_page' => $eva_fond_page,
		'fond_bloc' => $eva_fond_bloc,
		'fond_edito' => $eva_fond_edito,
		'fond_titre_edito' => $fond_titre_edito,
		'fond_entete_pages' => $eva_entete_page,
		'fond_barres_entete' => $eva_barres_entete,
		'fond_barres_entete_arborescence' => $eva_barres_entete_arborescence,
		'fond_barres_entete_auteur' => $eva_barres_entete_auteur,
		'fond_barres_entete_texte' => $eva_barres_entete_texte,
		'fond_titre_article' => $eva_fond_titre_article,
		'fond_pied_pages' => $eva_pied_page,
		'fond_pied_logos' => $eva_pied_logo,
		'fond_titres' => $eva_fond_titres,
		'fond_menu_fond' => $eva_menu_fond,
		'fond_menu_off' => $eva_menu_off,
		'fond_menu_on' => $eva_menu_on,
		'fond_liste_elements_impairs' => $eva_liste_impair,
		'fond_liste_elements_pairs' => $eva_liste_pair,
		'texte_police_type' => $eva_police_type,
		'texte_principal' => $eva_texte_principal,
		'texte_liste_paire' => $texte_liste_paire,
		'texte_liste_impaire' => $texte_liste_impaire,
		'texte_entetes' => $texte_entetes, 
		'texte_surtitre' => $texte_surtitre,
		'texte_titre' => $texte_titre,
		'texte_soustitre' => $texte_soustitre,
		'texte_couleur_liens_menu' => $couleur_liens_menu,
		'texte_couleur_liens_menu_actif' => $couleur_liens_menu_actif,
		'texte_couleur_liens_menu_survol' => $couleur_liens_menu_survol,
		'texte_barres_entete' => $texte_barres_entete,
		'texte_premiere_lettre_entete' => $texte_premiere_lettre_entete,
		'texte_edito' => $texte_edito,
		'texte_edito_titre' => $texte_edito_titre,
		'texte_edito_titre_premier' => $texte_edito_titre_premier,
		'texte_entete_arborescence' => $texte_entete_arborescence,
		'texte_auteur' => $texte_auteur,
		'texte_pied' => $texte_pied,
		'lien_couleur_lien' => $couleur_lien,
		'lien_couleur_lien_survol' => $couleur_lien_survol,
		'lien_couleur_lien_impair' => $couleur_lien_impair,
		'lien_couleur_lien_impair_survol' => $couleur_lien_impair_survol,
		'lien_couleur_lien_pair' => $couleur_lien_pair,
		'lien_couleur_lien_pair_survol' => $couleur_lien_pair_survol,
		'bordure_page' => $bordure_page,
		'bordure_largeur_page' => $bordure_largeur_page,
		'bordure_style_page' => $bordure_style_page,
		'bordure_couleur_bordure' => $couleur_bordure,
		'bordure_largeur_couleur_bordure' => $couleur_largeur_bordure,
		'bordure_style_couleur_bordure' => $couleur_style_bordure,
		'bordure_couleur_bordure_entete' => $couleur_bordure_entete,
		'bordure_largeur_couleur_bordure_entete' => $couleur_largeur_bordure_entete,
		'bordure_style_couleur_bordure_entete' => $couleur_style_bordure_entete,
		'bordure_couleur_titre' => $bordure_couleur_titre,
		'bordure_largeur_titre' => $couleur_largeur_titre,
		'bordure_style_titre' => $couleur_style_titre,
		'bordure_couleur_bordure_auteur' => $couleur_bordure_auteur,
		'bordure_largeur_couleur_bordure_auteur' => $couleur_largeur_bordure_auteur,
		'bordure_style_couleur_bordure_auteur' => $couleur_style_bordure_auteur,
		'bordure_couleur_bordure_edito' => $couleur_bordure_edito,
		'bordure_largeur_couleur_bordure_edito' => $couleur_largeur_bordure_edito,
		'bordure_style_couleur_bordure_edito' => $couleur_style_bordure_edito,
		'bordure_couleur_bordure_pied' => $couleur_bordure_pied,
		'bordure_largeur_couleur_bordure_pied' => $couleur_largeur_bordure_pied,
		'bordure_style_couleur_bordure_pied' => $couleur_style_bordure_pied,
		'bordure_couleur_bordure_menu' => $couleur_bordure_menu,
		'bordure_largeur_couleur_bordure_menu' => $couleur_largeur_bordure_menu,
		'bordure_style_couleur_bordure_menu' => $couleur_style_bordure_menu,
		'bordure_couleur_bordure_menu_secteurs' => $couleur_bordure_menu_secteurs,
		'bordure_largeur_couleur_bordure_menu_secteurs' => $couleur_largeur_bordure_menu_secteurs,
		'bordure_style_couleur_bordure_menu_secteurs' => $couleur_style_bordure_menu_secteurs,
		'taille_largeur_page' => $largeur_page,
		'taille_largeur_menu' => $largeur_menu,
		'taille_largeur_menudroite' => $largeur_menudroite,
		'taille_largeur_contenu' => $largeur_contenu,
		'taille_hauteur_entete' => $hauteur_entete,
		'admin_deplacement_horizontal_bouton_admin' => $deplacement_horizontal_bouton_admin,
		'admin_deplacement_vertical_bouton_admin' => $deplacement_vertical_bouton_admin
	);
	return $eva_habillage_themes;
}

function EVA_def_themes() {
	$def_themes = array('fond_','texte_','lien_','bordure_','taille_','admin_');
	return $def_themes;
}

function EVA_def_textes() {
	return array(
		'texte_police_type' => $eva_police_type,	
	);
}

function EVA_def_themes_global() {
	return array(
		'fond_ecran' => $eva_fond_ecran,
		'fond_page' => $eva_fond_page,
		'fond_bloc' => $eva_fond_bloc,
		'fond_edito' => $eva_fond_edito,
		'fond_titre_edito' => $fond_titre_edito,
		'fond_entete_pages' => $eva_entete_page,
		'fond_barres_entete' => $eva_barres_entete,
		'fond_barres_entete_arborescence' => $eva_barres_entete_arborescence,
		'fond_barres_entete_auteur' => $eva_barres_entete_auteur,
		'fond_barres_entete_texte' => $eva_barres_entete_texte,
		'fond_titre_article' => $eva_fond_titre_article,
		'fond_pied_pages' => $eva_pied_page,
		'fond_pied_logos' => $eva_pied_logo,
		'fond_titres' => $eva_fond_titres,
		'fond_menu_fond' => $eva_menu_fond,
		'fond_menu_off' => $eva_menu_off,
		'fond_menu_on' => $eva_menu_on,
		'fond_liste_elements_impairs' => $eva_liste_impair,
		'fond_liste_elements_pairs' => $eva_liste_pair,
		'texte_principal' => $eva_texte_principal,
		'texte_liste_paire' => $texte_liste_paire,
		'texte_liste_impaire' => $texte_liste_impaire,
		'texte_entetes' => $texte_entetes, 
		'texte_surtitre' => $texte_surtitre,
		'texte_titre' => $texte_titre,
		'texte_soustitre' => $texte_soustitre,
		'texte_couleur_liens_menu' => $couleur_liens_menu,
		'texte_couleur_liens_menu_actif' => $couleur_liens_menu_actif,
		'texte_couleur_liens_menu_survol' => $couleur_liens_menu_survol,
		'texte_barres_entete' => $texte_barres_entete,
		'texte_premiere_lettre_entete' => $texte_premiere_lettre_entete,
		'texte_edito' => $texte_edito,
		'texte_edito_titre' => $texte_edito_titre,
		'texte_edito_titre_premier' => $texte_edito_titre_premier,
		'texte_entete_arborescence' => $texte_entete_arborescence,
		'texte_auteur' => $texte_auteur,
		'texte_pied' => $texte_pied,
		'lien_couleur_lien' => $couleur_lien,
		'lien_couleur_lien_survol' => $couleur_lien_survol,
		'lien_couleur_lien_impair' => $couleur_lien_impair,
		'lien_couleur_lien_impair_survol' => $couleur_lien_impair_survol,
		'lien_couleur_lien_pair' => $couleur_lien_pair,
		'lien_couleur_lien_pair_survol' => $couleur_lien_pair_survol,
		'bordure_page' => $bordure_page,
		'bordure_largeur_page' => $bordure_largeur_page,
		'bordure_style_page' => $bordure_style_page,
		'bordure_couleur_bordure' => $couleur_bordure,
		'bordure_largeur_couleur_bordure' => $couleur_largeur_bordure,
		'bordure_style_couleur_bordure' => $couleur_style_bordure,
		'bordure_couleur_bordure_entete' => $couleur_bordure_entete,
		'bordure_largeur_couleur_bordure_entete' => $couleur_largeur_bordure_entete,
		'bordure_style_couleur_bordure_entete' => $couleur_style_bordure_entete,
		'bordure_couleur_titre' => $bordure_couleur_titre,
		'bordure_largeur_titre' => $couleur_largeur_titre,
		'bordure_style_titre' => $couleur_style_titre,
		'bordure_couleur_bordure_auteur' => $couleur_bordure_auteur,
		'bordure_largeur_couleur_bordure_auteur' => $couleur_largeur_bordure_auteur,
		'bordure_style_couleur_bordure_auteur' => $couleur_style_bordure_auteur,
		'bordure_couleur_bordure_edito' => $couleur_bordure_edito,
		'bordure_largeur_couleur_bordure_edito' => $couleur_largeur_bordure_edito,
		'bordure_style_couleur_bordure_edito' => $couleur_style_bordure_edito,
		'bordure_couleur_bordure_pied' => $couleur_bordure_pied,
		'bordure_largeur_couleur_bordure_pied' => $couleur_largeur_bordure_pied,
		'bordure_style_couleur_bordure_pied' => $couleur_style_bordure_pied,
		'bordure_couleur_bordure_menu' => $couleur_bordure_menu,
		'bordure_largeur_couleur_bordure_menu' => $couleur_largeur_bordure_menu,
		'bordure_style_couleur_bordure_menu' => $couleur_style_bordure_menu,
		'bordure_couleur_bordure_menu_secteurs' => $couleur_bordure_menu_secteurs,
		'bordure_largeur_couleur_bordure_menu_secteurs' => $couleur_largeur_bordure_menu_secteurs,
		'bordure_style_couleur_bordure_menu_secteurs' => $couleur_style_bordure_menu_secteurs,
		'taille_largeur_page' => $largeur_page,
		'taille_largeur_menu' => $largeur_menu,
		'taille_largeur_menudroite' => $largeur_menudroite,
		'taille_largeur_contenu' => $largeur_contenu,
		'taille_hauteur_entete' => $hauteur_entete,
		'admin_deplacement_horizontal_bouton_admin' => $deplacement_horizontal_bouton_admin,
		'admin_deplacement_vertical_bouton_admin' => $deplacement_vertical_bouton_admin
	);
}

function EVA_div_images() {
	global $eva_habillage_images;
	$eva_habillage_images = array(
		'image_ecran' => array('body'),
		'image_page' => array('div#page'),
		'image_bloc' => array('div#contenu .bloc','div#menu .bloc','div#menudroit .bloc','#formrecherche','#forum ul.forum div.titre .auteur','.divers div.contenu','div#contenu ul','div.bloc ul','div.bloc','ul#sommaire','div#menu .bloc ul','div#menudroit .bloc ul'),
		'image_edito' => array('div#contenu div.chapo','div.edito'),
		'image_edito_titre' => array('#contenu div.edito h3.titre','.edito .titre'),
		'image_entete_page' => array('div#entete'),
		'image_barre_entete' => array('div#entete ul.liens'),
		'image_barre_entete_arborescence' => array('div#arborescence'),
		'image_entete_article' => array('.bloc#article_contenu .titre'),
		'image_barre_auteur' => array('.edito .titre div#auteursdates','#auteursdates','.bloc #auteursdates'),
		'image_titre_entete' => array('div#entete h1 span','div#entete h2 span'),
		'image_pied' => array('ul#pied'),
		'image_pied-logo' => array('#logo-pied'),
		'image_titres' => array('h3','legend','.divers h4','table.spip tr.row_first th','div#contenu div.ps h4','div#menudroit h3.titre','div#contenu h3.titre','div#menu h3.titre','div#menudroit h2.titre','div#contenu h2.titre','div#menu h2.titre','table.spip tr.row_first','div#contenu div.lien','div#contenu div.notes h4','div#contenu h4.titre','#forum ul.forum div.titre h4','#forum .bouton a'),
		'image_menu' => array('ul#sommaire'),
		'image_menu_off' => array('div#menu ul#sommaire li','div#menu ul#sommaire .off','div#menudroit ul#sommaire .off'),
		'image_menu_on' => array('div#menu ul#sommaire .on','div#menudroit ul#sommaire .on'),
		'image_impairs' => array('.spip tr.row_even td','div#menudroit .bloc ul li.un','div#menu .bloc ul li.un','div#contenu ul li.un'),
		'image_pairs' => array('.spip tr.row_odd td','div#menu .bloc ul li.deux','div#menudroit .bloc ul li.deux','div#contenu ul li.deux'),
		'liste_menu_off' => array('div#menu ul .off','div#menudroit ul .off'),
		'liste_menu_on' => array('div#menu ul .on','div#menudroit ul .on'),
		'liste_impairs_menu' => array('div#menu .bloc ul li.un','div#menudroit .bloc ul li.un'),
		'liste_pairs_menu' => array('div#menu .bloc ul li.deux','div#menudroit .bloc ul li.deux'),
		'liste_impairs_contenu' => array('div#contenu ul li.un'),
		'liste_pairs_contenu' => array('div#contenu ul li.deux')
    );

	$req_menu_horizontal_actif0=sql_select('nom_image','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND nom_div='menu_depliable_horizontal_articles' AND attach='entete'");
	$req_menu_horizontal_actif1=sql_select('nom_image','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND nom_div='menu_depliable_horizontal' AND attach='entete'");
	$req_menu_horizontal_actif2=sql_select('nom_image','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND nom_div='headers_menu_depliable_horiz' AND attach='headers'");
	$tab_menu_horizontal_actif0=sql_fetch($req_menu_horizontal_actif0);
	$tab_menu_horizontal_actif1=sql_fetch($req_menu_horizontal_actif1);
	$tab_menu_horizontal_actif2=sql_fetch($req_menu_horizontal_actif2);
	$req_menu_horizontal_actif0=$tab_menu_horizontal_actif0['nom_image'];
	$req_menu_horizontal_actif1=$tab_menu_horizontal_actif1['nom_image'];
	$req_menu_horizontal_actif2=$tab_menu_horizontal_actif2['nom_image'];
	if (
		($req_menu_horizontal_actif0=='oui' OR $req_menu_horizontal_actif1=='oui')
		AND $req_menu_horizontal_actif2=='oui') {
			$eva_habillage_images['image_fond_menu_horizontal_base']=array('#menu_horizontal','#menu_horizontal a');
			$eva_habillage_images['image_fond_menu_horizontal_survol']=array('#menu_horizontal a:hover','#menu_horizontal li .on:hover');
			$eva_habillage_images['image_fond_menu_horizontal_actif']=array('#menu_horizontal li .on');
		}
		$test=sql_select('nom_image','spip_eva_habillage_images',"type='multilinguisme' AND nom_habillage='Defaut' AND nom_div='menu_langue_actif'");
		$tab=sql_fetch($test);
		$envoi=$tab['nom_image'];
		if ($envoi) {
			$eva_habillage_images['image_fond_menu_langue']=array('.menulangue');
		}
		return $eva_habillage_images;
}

function EVA_blocs_sommaire() {
	global $eva_blocs_sommaire;
	$eva_blocs_sommaire = array(
		'sommaire_navigation',
		'sommaire_edito',
		'sommaire_articles',
		'sommaire_mini_calendrier',
		'sommaire_connexion',
		'sommaire_breve',
		'sommaire_site',
		'sommaire_podcast',
		'sommaire_logo',
		'sommaire_syndic',
		'sommaire_compteur'
	);
	return $eva_blocs_sommaire;
}

function EVA_blocs_rubrique() {
	global $eva_blocs_rubrique;
	$eva_blocs_rubrique = array(
		'rubrique_navigation',
		'rubrique_contenu',
		'rubrique_sous_rubriques',
		'rubrique_articles',
		'rubrique_podcast',
		'rubrique_documents',
		'rubrique_breve',
		'rubrique_site',
		'rubrique_site_syndic',
		'rubrique_mot',
		'rubrique_syndic'
	);
	return $eva_blocs_rubrique;
}

function EVA_blocs_article() {
	global $eva_blocs_article;
	$eva_blocs_article = array(
		'article_navigation',
		'article_contenu',
		'article_forum',
		'article_signature',
		'article_petition',
		'article_meme_rubrique',
		'article_mot',
		'article_compteur'
	);
	return $eva_blocs_article;
}

function EVA_blocs_breve() {
	global $eva_blocs_breve;
	$eva_blocs_breve = array(
		'breve_navigation',
		'breve_contenu',
		'breve_breves'
	);
	return $eva_blocs_breve;
}

function EVA_blocs_auteur() {
	global $eva_blocs_auteur;
	$eva_blocs_auteur = array(
		'auteur_navigation',
		'auteur_contenu',
		'auteur_auteurs',
		'auteur_articles'
	);
	return $eva_blocs_auteur;
}

function EVA_blocs_site() {
	global $eva_blocs_site;
	$eva_blocs_site = array(
		'site_navigation',
		'site_contenu',
		'site_syndic',
		'site_podcast',
		'site_sites'
	);
	return $eva_blocs_site;
}

function EVA_les_blocs() {
	$t = array(
		'sommaire' => EVA_blocs_sommaire(),
		'rubrique' => EVA_blocs_rubrique(),
		'article' => EVA_blocs_article(),
		'breve' => EVA_blocs_breve(),
		'auteur' => EVA_blocs_auteur(),
		'site' => EVA_blocs_site()
	);
	return $t;
}

function EVA_mes_blocs() {
	$t = array(
		'EVA_choix_bloc_sommaire' => EVA_blocs_sommaire(),
		'EVA_choix_bloc_rubrique' => EVA_blocs_rubrique(),
		'EVA_choix_bloc_article' => EVA_blocs_article(),
		'EVA_choix_bloc_breve' => EVA_blocs_breve(),
		'EVA_choix_bloc_auteur' => EVA_blocs_auteur(),
		'EVA_choix_bloc_site' => EVA_blocs_site()
	);
	return $t;
}

function EVA_blocs_entete() {
	$t = array(
		'entete_classique',
		'entete_sans_liens',
		'entete_sans_titre',
		'entete_arborescence',
	);
	return $t;
}

function EVA_NBRE_somm() {
	global $eva_nbre_somm;
	$eva_nbre_somm = array(
		'nbre_sommaire_articles',
		'nbre_sommaire_breves',
		'nbre_sommaire_sites',
		'nbre_sommaire_articles_syndic'
	);
	return $eva_nbre_somm;
}

function EVA_NBRE_rub() {
	global $eva_nbre_rub;
	$eva_nbre_rub = array(
		'nbre_rubrique_breves',
		'nbre_rubrique_sites_ref',
		'nbre_rubrique_articles_syndic'
	);
	return $eva_nbre_rub;
}

function EVA_NBRE_art() {
	global $eva_nbre_art;
	$eva_nbre_art = array(
		'nbre_articles_article'
	);
	return $eva_nbre_art;
}

function EVA_NBRE_breve() {
	global $eva_nbre_breve;
	$eva_nbre_breve = array(
		'nbre_breves_breve'
	);
	return $eva_nbre_breve;
}

function EVA_NBRE_auteur() {
	global $eva_nbre_auteur;
	$eva_nbre_auteur = array(
		'nbre_auteurs_auteur',
		'nbre_articles_auteur'
	);
	return $eva_nbre_auteur;
}

function EVA_mes_nbres() {
	$m = array(
		'EVA_nbre_sommaire' => EVA_NBRE_somm(),
		'EVA_nbre_rubrique' => EVA_NBRE_rub(),
		'EVA_nbre_article' => EVA_NBRE_art(),
		'EVA_nbre_breve' => EVA_NBRE_breve(),
		'EVA_nbre_auteur' => EVA_NBRE_auteur()
	);
	return $m;
}

function EVA_secteurs_Flash() {
	$flash = array(
		'flash_secteur_titre',
		'flash_secteur_pied',
		'flash_secteur_sites_partenaires',
		'flash_secteur_barre_logo',
	);
	return $flash;
}

function EVA_menu_dynamique_horizontal() {
	$menu = array(
		'evabonus_menu_horizontal_couleur_fond'=>'#menu_horizontal , #menu_horizontal li , #menu_horizontal li a , #menu_horizontal a {background-color:',
		'evabonus_menu_horizontal_couleur_fond_survol'=>'#menu_horizontal li a:hover {background-color:',
		'evabonus_menu_horizontal_couleur_fond_actif'=>'#menu_horizontal a .on, #menu_horizontal li .on {background-color:',
		'evabonus_menu_horizontal_couleur_texte'=>'#menu_horizontal a {color:',
		'evabonus_menu_horizontal_couleur_texte_survol'=>'#menu_horizontal a:hover {color:',
		'evabonus_menu_horizontal_couleur_texte_actif'=>'#menu_horizontal a .on, #menu_horizontal li .on{color:',
		'evabonus_menu_horizontal_couleur_bordure_style'=>'#menu_horizontal li {border-right-style:',
		'evabonus_menu_horizontal_couleur_bordure_largeur'=>'#menu_horizontal li {border-right-width:',
		'evabonus_menu_horizontal_couleur_bordure_couleur'=>'#menu_horizontal li {border-right-color:'
	);
	return $menu;
}

function EVA_menu_langue() {
	$menu = array(
		'eva_menu_langue_couleur_fond'=>'.menulangue {background-color:',
		'eva_menu_langue_couleur_texte'=>'.menulangue, .menulangue a {color:',
		'eva_menu_langue_bordure_style'=>'.menulangue  {border-style:',
		'eva_menu_langue_bordure_width'=>'.menulangue {border-width:',
		'eva_menu_langue_bordure_couleur'=>'.menulangue {border-color:'
	);
	return $menu;
}
?>