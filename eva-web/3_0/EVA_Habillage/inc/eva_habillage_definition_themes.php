<?php
/******************************************************************
***  Ce plugin EVA_habillage, créé par Olivier Gautier, est mis ***
***      à disposition sous un contrat Creative Commons BY      *** 
***                 consultable à l'adresse                     ***
***      http://www.creativecommons.org/licenses/by/2.0/fr/     ***
******************************************************************/
function eva_habillage_definition_themes () {

//Définition des sélecteurs de personnalisation d'EVA (on regroupe les sélecteurs en fonction du thème et de la propriété concernée)
    //Fond d'écran
    $eva_fond_ecran_background = array('body');
    //Fond des pages
    $eva_fond_page_background = array('div#Page');
    //Fond des blocs
    $eva_fond_bloc_background = array('hr','.spip_cadre','textarea.spip_cadre','fieldset','#FormRecherche','#Forum ul.forum div.titre .auteur','.divers div.contenu','div#Contenu ul','div.bloc ul','div.bloc','div.bloc2','ul#Sommaire','div#Menu .bloc ul','div#MenuDroit .bloc ul');
    //Fond de l'éditorial et des chapeaux
    $eva_fond_edito_background = array('.edito .Titre','div#Photo img','div#Contenu div.chapo','div.edito','div#EnteteDiaporama','div#BoutonDiaporama a span');
    //Entêtes des pages
    $eva_entete_page_background = array('div#Entete');
    //Barres des liens et de l'arborescence situées au-dessus de l'entête de la page, bloc affichant l'auteur et la date de publication
    $eva_barres_entete_background = array('div#Entete ul.liens');
    //Barres d'arborescence situé sous l'entête de la page
    $eva_barres_entete_arborescence_background = array('div#Arborescence');
    //Secteur présentant les auteurs et la date
    $eva_barres_entete_auteur_background = array('#AuteursDates','.bloc2 #AuteursDates');
   //Fond des titres de l'entête
    $eva_barres_entete_texte_background = array('div#Entete h1 span','div#Entete h2 span');
    //Fond du secteur de sur-titre, titre et sous-titre
    $eva_fond_titre_article_background = array ('div .Titre');
     //Pied de page
    $eva_pied_page_background = array('ul#Pied');
    //Pied de page : barre des logos
    $eva_pied_logo_background = array('#Logo-Pied');
    //Fond des titre des blocs,du menu, des premiers éléments des tableaux générés par SPIP
    $eva_fond_titres_background = array('.bloc2 .Titre','.divers','.divers h4','table.spip tr.row_first th','div#Contenu div.ps h4','div#Menu h3.titre','div#MenuDroit h3.titre','table.spip tr.row_first','div#Contenu div.lien','div#Contenu div.notes h4','div#Contenu h4.titre','div#Contenu h3.titre','#Forum ul.forum div.titre h4');
    $eva_fond_titres_background_color = array('#Forum .bouton a','#Forum .bouton a:hover');
    //Fonds du menu de navigation
    $eva_menu_fond_background_color = array('ul#Sommaire', 'ul#Sommaire li');
    //Fonds des secteurs inactifs du menu
    $eva_menu_off_background = array('ul#AlbumVignettes li.on a:hover img','ul#AlbumVignettes li a img','div#Menu ul#Sommaire .off','div#Menu ul#Sommaire li','div#MenuDroit ul#Sommaire .off','div#MenuDroit ul#Sommaire li');
    //Fond du secteur actif du menu
    $eva_menu_on_background = array('ul#AlbumVignettes li a:hover img','ul#AlbumVignettes li.on a img','div#Menu ul#Sommaire .on','div#MenuDroit ul#Sommaire .on');
    //Fonds des listes d'éléments impairs
    $eva_liste_impair_background = array('.spip tr.row_even td','div#Menu .bloc ul li.un','div#MenuDroit .bloc ul li.un','div#Contenu ul li.un');
    //Fonds des listes d'éléments pairs
    $eva_liste_pair_background = array('.spip tr.row_odd td','div#Menu .bloc ul li.deux','div#MenuDroit .bloc ul li.deux','div#Contenu ul li.deux');
    //Type de police de caractères, hors formulaire, <code>...</code>, ...
    $eva_police_type_font_family = array('body');
    //Couleur du texte du site
    $eva_texte_principal_color = array('div .contenu','h3.titre','h3.titre a','.divers','.erreur','hr','.spip_cadre','textarea.spip_cadre','fieldset','div#Contenu','div#Contenu .bloc2','.bloc','ul#Sommaire','div#Menu .bloc ul','div#MenuDroit .bloc ul','div#Contenu .bloc ul li','.auteur');
    //Couleur du texte des listes paires
    $texte_liste_paire_color = array('div#Menu .bloc ul li.deux','div#MenuDroit .bloc ul li.deux','div#Contenu ul li.deux','div#Contenu ul li.deux h2','table.spip tr.row_odd','div#Contenu ul.bloc li.deux');
    //Couleur du texte des listes impaire
    $texte_liste_impaire_color = array('div#Menu .bloc ul li.un','div#Contenu ul li.un','div#Contenu ul li.un h2','div#MenuDroit .bloc ul li.un','table.spip tr.row_odd','div#Contenu ul.bloc li.un');
    //Couleur du texte des secteurs d'entete
    $texte_entetes_color = array('div#Entete h1 a','div#Entete h2');
    //Couleur du texte des sur-titres
    $texte_surtitre_color = array('.Titre h4.surtitre');
    //Couleur du texte des titres
    $texte_titre_color = array('.Titre h2','div#Contenu h2');
    //Couleur du texte des sous-titres
    $texte_soustitre_color = array('.Titre h4.soustitre');
    //Couleur des textes du menu de navigation
    $couleur_liens_menu_color = array('ul#Sommaire a');
    //Couleur du texte du secteur courant dans le menu de navigation
    $couleur_liens_menu_actif_color = array('ul#Sommaire a.on','ul#Sommaire ul a.on');
    //Couleur des textes du menu de navigation lors du survol
    $couleur_liens_menu_survol_color = array('ul#Sommaire a:hover','ul#Sommaire ul a:hover');
    //Couleur des textes des titres des blocs
    $texte_barres_entete_color = array('h3','div#Contenu h3','legend','#Forum .bouton a','.bloc2 .Titre','.divers h4','table.spip tr.row_first th','div#Contenu div.ps h4','div#Menu h3.titre','div#MenuDroit h3.titre','table.spip tr.row_first','div#Contenu div.lien','.contenu .lien','div#Contenu div.notes h4','div#Contenu h4.titre','div#Contenu h3.titre','#Forum ul.forum div.titre h4');
    //Couleur de le première lettre des titres des blocs
    $texte_premiere_lettre_entete_color = array('.Titre h2:first-letter','#Forum .bouton a:first-letter','.bloc2 .Titre:first-letter','.divers h4:first-letter','div#Contenu div.lien:first-letter','div#Contenu div.ps h4:first-letter','div#Contenu div.notes h4:first-letter','div#Contenu div.lien:first-letter','.contenu .lien:first-letter','div#Contenu h4.titre:first-letter','div#Contenu h3:first-letter','div#Contenu .bloc2 h3:first-letter','div#Contenu .bloc2 h3.titre:first-letter','div#Menu h3:first-letter','div#MenuDroit h3:first-letter','.divers h4:first-letter','h3:first-letter');
    //Couleur du texte de l'Editorial et des chapeaux
    $texte_edito_color = array('div#Contenu .edito','div#Contenu div.chapo','div#EnteteDiaporama h2','div#BoutonDiaporama a span');
    //Couleur du texte du titre de l'éditorial
    $texte_edito_titre_color = array('div#Contenu .edito h3.titre','.edito .Titre');
    //Couleur de la première lettre du texte du titre de l'éditorial
    $texte_edito_titre_premier_color = array('div#Contenu .edito h3.titre:first-letter','.edito .Titre:first-letter');
    //Couleur du texte dans les barres des liens et d'arborescence
    $texte_entete_arborescence_color = array('div#Arborescence','div#Arborescence a','div#Arborescence strong','div#Arborescence em','div#Entete ul.liens','div#Entete ul.liens a','div#Entete ul.liens li.on a');
    //Couleur du texte du secteur d'auteur
    $texte_auteur_color = array('#AuteursDates','#AuteursDates a','.bloc2 #AuteursDates li','.bloc2 #AuteursDates li a');
    //Couleur des textes du pied de page
    $texte_pied_color = array('ul#Pied','ul#Pied a','ul#Pied li.on a','ul#Pied a:hover','ul#Pied p a:hover');
    //Couleur des liens
    $couleur_lien_color = array('h4.titre a','div#BoutonDiaporama a','a','.texte a','div#Menu .bloc ul li a.on','div#Menu .bloc ul li.on strong','div#MenuDroit .bloc ul li a.on','div#MenuDroit .bloc ul li.on strong');
    //Couleur des liens survolés
    $couleur_lien_survol_color = array('div#BoutonDiaporama a:hover','#Forum .bouton a:hover','.texte a:hover','a:hover','div#Contenu a:hover','div#Menu .bloc ul a:hover','div#MenuDroit .bloc ul a:hover','div#Arborescence a:hover','div#Entete ul.liens a:hover');
    //Couleur des liens des listes impaires
    $couleur_lien_impair_color = array('div#MenuDroit .bloc ul li.un a','div#Menu .bloc ul li.un a','div#Contenu .bloc li.un a','.bloc li .un a');
    //Couleur des liens des listes impaires lors du survol
    $couleur_lien_impair_survol_color = array ('div#MenuDroit .bloc ul li.un a:hover','div#Menu .bloc ul li.un a:hover','div#Contenu .bloc li.un a:hover','div#Contenu .un a:hover');
    //Couleur des liens des listes paires
    $couleur_lien_pair_color = array('div#MenuDroit .bloc ul li.deux a','div#Menu .bloc ul li.deux a','div#Contenu .bloc li.deux a','.bloc li .deux a');
    //Couleur des liens des listes paires lors du survol
    $couleur_lien_pair_survol_color = array('div#MenuDroit .bloc ul li.deux a:hover','div#Menu .bloc ul li.deux a:hover','div#Contenu .bloc li.deux a:hover','div#Contenu .deux a:hover');
    //Couleur des bordures de la page, largeur et styles
    $bordure_page_border_color = array('div#Page');
    //Couleur principale des bordures
    $couleur_bordure_color =array('.divers','hr');
    $couleur_bordure_border_color = array('.divers','hr','div#BoutonDiaporama a span','div #EnteteDiaporama','div #EnteteDiaporama h2 span','.lien','.divers','.bloc','.bloc2','#Forum .bouton a','#FormRecherche','input.formrecherche','fieldset','.forml','textarea.spip_cadre','table.spip th','table.spip td','table.spip tr.row_odd','table.spip tr.row_even','hr','.spip_encadrer','a.spip_barre img','a.spip_barre:hover img');
    $couleur_bordure_border_top_color = array('h3','#Forum ul.forum div.titre h4','.MenuPaginationBas');
    $couleur_bordure_right_color = array('#Forum ul.forum div.titre h4','#Forum ul.forum div.titre .auteur','#Forum ul.forum div.contenu');
    $couleur_bordure_bottom_color = array('h3','#Forum ul.forum div.contenu','.MenuPaginationHaut');
    $couleur_bordure_left_color = array('#Forum ul.forum div.titre h4','#Forum ul.forum div.titre .auteur','#Forum ul.forum div.contenu','div.spip_poesie');
    //Couleur des bordures des secteurs d'entête
    $couleur_bordure_entete_border_color = array('div#Entete h2 span','div#Entete h1 span');
    $couleur_bordure_entete_border_top_color = array('div#Entete ul.liens a:hover');
    $couleur_bordure_entete_bottom_color = array('div#Arborescence','div#Entete ul.liens','div#EnteteDiaporama','div#Entete');
    $couleur_bordure_entete_left_color = array('div#Entete ul.liens li');
    //Couleur, taille, style des bordures du secteur de sous-titre, de titre et de sur-titre
    $bordure_couleur_titre_border = array('.Titre');
    //Couleur des bordures du secteur d'auteur
    $couleur_bordure_auteur_color = array('#AuteursDates');
    //Couleur de la bordure de l'éditorial
    $couleur_bordure_edito_border_color = array('div#Contenu .edito','div#EnteteDiaporama','div#BoutonDiaporama a span');
    //Couleur des bordures des secteurs de pied de page
    $couleur_bordure_pied_border_top_color = array('ul#Pied a:hover','#Logo-Pied','ul#Pied');
    $couleur_bordure_pied_bottom_color = array('ul#Pied a:hover');
    $couleur_bordure_pied_left_color = array('ul#Pied li');
    //Couleur de la bordure encadrant le menu de navigation
    $couleur_bordure_menu_border_color = array('ul#Sommaire');
    //Couleur des bordures des secteurs du menu de navigation
    $couleur_bordure_menu_secteurs_border_color = array('ul#Sommaire li');
    //Largeur de la page
    $largeur_page_width = array('div#Page','div#Entete ul.liens');
    //Largeur du menu de gauche
    $largeur_menu_width = array('div#Menu');
    //Largeur du menu de droite
    $largeur_menudroite_width = array('div#MenuDroit');
    //Largeur du contenu
    $largeur_contenu_width = array('div#Contenu');
    //Hauteur du secteur d'entête
    $hauteur_entete_height = array('div#Entete');
    //Déplacement horizontal des boutons d administration
    $deplacement_horizontal_bouton_admin_right = array('div .spip-admin-float','html body .spip-admin-float');
    //Déplacement vertical des boutons d administration
    $deplacement_vertical_bouton_admin_top = array('div .spip-admin-float','html body .spip-admin-float');
    
//Définition générale des thèmes de personnalisation d'EVA (on regroupe les propriétés définies ci-dessus en fonction du thème CSS concerné)
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
    
// Tableau regroupant les différents thèmes de personnalisation d'EVA
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

function EVA_div_images() {
    global $eva_habillage_images;
    $eva_habillage_images = array(
    'image_ecran' => array('body'),
    'image_page' => array('div#Page'),
    'image_bloc' => array('#FormRecherche','#Forum ul.forum div.titre .auteur','.divers div.contenu','div#Contenu ul','div.bloc ul','div.bloc','div.bloc2','ul#Sommaire','div#Menu .bloc ul','div#MenuDroit .bloc ul'),
    'image_edito' => array('div#Contenu div.chapo','div.edito'),
    'image_edito_titre' => array('#Contenu div.edito h3.titre','.edito .Titre'),
    'image_entete_page' => array('div#Entete'),
    'image_barre_entete' => array('div#Entete ul.liens'),
    'image_barre_entete_arborescence' => array('div#Arborescence'),
    'image_barre_auteur' => array('#AuteursDates','.bloc2 #AuteursDates'),
    'image_titre_entete' => array('div#Entete h1 span','div#Entete h2 span'),
    'image_pied' => array('ul#Pied'),
    'image_pied-logo' => array('#Logo-Pied'),
    'image_titres' => array('.bloc2 .Titre','.divers h4','table.spip tr.row_first th','div#Contenu div.ps h4','div#MenuDroit h3.titre','div#Menu h3.titre','table.spip tr.row_first','div#Contenu div.lien','div#Contenu div.notes h4','div#Contenu h4.titre','div#Contenu h3.titre','#Forum ul.forum div.titre h4','#Forum .bouton a'),
    'image_menu' => array('ul#Sommaire', 'ul#Sommaire li'),
    'image_menu_off' => array('div#Menu ul#Sommaire li','div#Menu ul#Sommaire .off','div#MenuDroit ul#Sommaire .off'),
    'image_menu_on' => array('div#Menu ul#Sommaire .on','div#MenuDroit ul#Sommaire .on'),
    'image_impairs' => array('.spip tr.row_even td','div#MenuDroit .bloc ul li.un','div#Menu .bloc ul li.un','div#Contenu ul li.un'),
    'image_pairs' => array('.spip tr.row_odd td','div#Menu .bloc ul li.deux','div#MenuDroit .bloc ul li.deux','div#Contenu ul li.deux'),
    'liste_menu_off' => array('div#Menu ul .off','div#MenuDroit ul .off'),
    'liste_menu_on' => array('div#Menu ul .on','div#MenuDroit ul .on'),
    'liste_impairs_menu' => array('div#Menu .bloc ul li.un','div#MenuDroit .bloc ul li.un'),
    'liste_pairs_menu' => array('div#Menu .bloc ul li.deux','div#MenuDroit .bloc ul li.deux'),
    'liste_impairs_contenu' => array('div#Contenu ul li.un'),
    'liste_pairs_contenu' => array('div#Contenu ul li.deux')
    );
    return $eva_habillage_images;
}

function EVA_blocs_sommaire() {
    global $eva_blocs_sommaire;
    $eva_blocs_sommaire = array(
    'sommaire_navigation',
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
    'breve_breves'
    );
    return $eva_blocs_breve;
}

function EVA_blocs_auteur() {
    global $eva_blocs_auteur;
    $eva_blocs_auteur = array(
    'auteur_navigation',
    'auteur_auteurs',
    'auteur_articles'
    );
    return $eva_blocs_auteur;
}

function EVA_mes_blocs() {
$t = array(
'EVA_choix_bloc_sommaire' => EVA_blocs_sommaire(),
'EVA_choix_bloc_rubrique' => EVA_blocs_rubrique(),
'EVA_choix_bloc_article' => EVA_blocs_article(),
'EVA_choix_bloc_breve' => EVA_blocs_breve(),
'EVA_choix_bloc_auteur' => EVA_blocs_auteur());
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
?>