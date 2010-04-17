<?php

// S�curit�
if (!defined("_ECRIRE_INC_VERSION")) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// Chaines affich�es sur la partie publique
	'rubrique_deux_points' => 'Rubrique&nbsp;:',
	'categorie_deux_points' => 'Cat&eacute;gorie&nbsp;:',
	'mots_cles_deux_points' => 'Mots-Cl&eacute;s&nbsp;:',
	'tags_deux_points' => 'Tags&nbsp;:',
	'theme_deux_points' => 'Th&egrave;me&nbsp;:',
	'sujet_deux_points' => 'Sujet&nbsp;:',
	'themes_deux_points' => 'Th&egrave;mes&nbsp;:',
	'categories_deux_points' => 'Cat&eacute;gories&nbsp;:',
	'sujets_deux_points' => 'Sujets&nbsp;:',
	'tags' => 'Tags',
	'categories' => 'Cat&eacute;gories',
	'themes' => 'Th&egrave;mes',
	'sujets' => 'Sujets',
	'dans' => 'Dans',
	'mis_a_jour_le' => 'Mis &agrave; jour le',
	'visiteurs_quotidiens' => 'visiteur(s) quotidien(s)',

	// Description des pages
	
	'description_pagedefaut' => 'Les blocs de cette page seront ajout&eacute;s sur toutes les pages du site.',
	'description_page_article' => 'Page par d&eacute;faut pour les articles.',
	'description_page_rubrique' => 'Page par d&eacute;faut pour les rubriques.',
	'description_page_auteur' => 'Page par d&eacute;faut pour les auteurs.',
	'description_page_breve' => 'Page par d&eacute;faut pour les br&egrave;s.',
	'description_page_mot' => 'Page par d&eacute;faut pour les mot-cl&eacute;s.',
	'description_page-forum' => 'Cette page est appel&eacute;e lorsqu\'un visiteur souhaiter poster un message dans un forum.',
	'description_page-plan' => 'Cette page est appel&eacute;e pour afficher le plan du site.',
	'description_page-recherche' => 'Cette page est affich&eacute;e lorsqu\'une recherche est effectu&eacute;e sur le site.',
	'description_page-login' => 'Cette page est n&eacute;cessaire pour se connecter &agrave; l\'espace priv&eacute;. Par s&eacute;curit&eacute;, si la noisette <i>Formulaire d\'identification</i> sp&eacute;cifique &agrave; cette page n\'est pas ins&eacute;r&eacute;e dans le bloc <i>Contenu</i>, elle y sera ins&eacute;r&eacute;e d\'office.',
	'description_page-spip_pass' => 'Cette page est affich&eacute;e lorsqu\'un visiteur a oubli&eacute; son mot de passe et souhaite en changer.',
	'description_page-401' => 'Cette page est affich&eacute;e lorsqu\'un visiteur demande &agrave; voir une page pour laquelle il n\'est pas autoris&eacute;.',
	'description_page-404' => 'Cette page est affich&eacute;e lorsqu\'un visiteur demande &agrave; voir une page qui n\'existe pas ou plus.',
	'description_page_site' => 'Page par d&eacute;faut pour les sites web r&eacute;f&eacute;renc&eacute;s.',
	
	'nom_page-sommaire' => 'Page d\'accueil du site',
	'nom_pagedefaut' => 'Page par d&eacute;faut',
	'nom_page_article' => 'Article',
	'nom_page_rubrique' => 'Rubrique',
	'nom_page_auteur' => 'Auteur',
	'nom_page_breve' => 'Br&egrave;ve',
	'nom_page_mot' => 'Mot-Cl&eacute;',
	'nom_page-forum' => 'Forum',
	'nom_page-plan' => 'Plan du site',
	'nom_page-recherche' => 'Recherche sur le site',
	'nom_page-login' => 'Se connecter',
	'nom_page-spip_pass' => 'Mot de passe oubli&eacute;',
	'nom_page-401' => 'Erreur 401',
	'nom_page-404' => 'Erreur 404',
	'nom_page_site' => 'Site r&eacute;f&eacute;renc&eacute;',
	
	// Description des blocs de la page par d�faut
	'nom_bloc_pre_contenu' => 'Pr&eacute;-Contenu',
	'nom_bloc_post_contenu' => 'Post-Contenu',
	'nom_bloc_pre_navigation' => 'Pr&eacute;-Navigation',
	'nom_bloc_post_navigation' => 'Post-Navigation',
	'nom_bloc_pre_extra' => 'Pr&eacute;-Extra',
	'nom_bloc_post_extra' => 'Post-Extra',
	'description_bloc_pre_contenu' => 'Les noisettes de ce bloc seront ins&eacute;r&eacute;es sur toutes les pages avant le bloc <i>Contenu</i>.',
	'description_bloc_post_contenu' => 'Les noisettes de ce bloc seront ins&eacute;r&eacute;es sur toutes les pages apr&egrave; le bloc <i>Contenu</i>.',
	'description_bloc_pre_navigation' => 'Les noisettes de ce bloc seront ins&eacute;r&eacute;es sur toutes les pages avant le bloc <i>Navigation</i>.',
	'description_bloc_post_navigation' => 'Les noisettes de ce bloc seront ins&eacute;r&eacute;es sur toutes les pages apr&egrave; le bloc <i>Navigation</i>.',
	'description_bloc_pre_extra' => 'Les noisettes de ce bloc seront ins&eacute;r&eacute;es sur toutes les pages avant le bloc <i>Extra</i>.',
	'description_bloc_post_extra' => 'Les noisettes de ce bloc seront ins&eacute;r&eacute;es sur toutes les pages apr&egrave; le bloc <i>Extra</i>.',
	
	// Description des noisettes
	
	'description_article-contenuprincipal' => 'Affiche logo, surtitre, titre, sous-titre, date, auteur, traduction, chapeau, texte, lien hypertexte, post-scriptum et notes.',
	'description_liste_articles' => 'Liste l\'ensemble des articles du site ou bien les articles situ&eacute;s dans la m&ecirc;me rubrique ou dans une rubrique donn&eacute;e.',
	'description_rubrique-contenuprincipal' => 'Affiche logo, date de dernier ajout et texte. Utilisez les param&egrave;tres ci-dessous pour personnaliser les &eacute;l&eacute;ments &agrave; afficher.',
	'description_documents' => 'Par d&eacute;faut, n\'affiche pas les photos, celles-ci &eacute;tant affich&eacute;es usuellement via un port-folio. Vous pouvez forcer l\'affichage des photos au cas o&ugrave; vous n\'affichez pas de port-folio.',
	'description_article-filariane' => 'Affiche l\'arborescence des rubriques jusqu\'&agrave; l\'article.',
	'description_portfolio' => 'Port-folio de la distribution par d&eacute;faut de SPIP',
	'description_navigation_rubriques' => 'Liste des rubriques et des sous-rubriques (toutes langues) tri&eacute;es par titre.',
	'description_article-mots_cles' => 'Liste les mots-cl&eacute;s associ&eacute;s &agrave; l\'article.',
	'description_menu' => 'Affiche un menu d&eacute;fini avec le plugin Menus.',
	
	'nom_article-contenuprincipal' => 'Contenu principal de l\'article',
	'nom_liste_articles' => 'Articles de la rubrique ou tous les articles',
	'nom_rubrique-contenuprincipal' => 'Contenu principal',
	'nom_documents' => 'Documents',
	'nom_filariane' => 'Fil d\'ariane',
	'nom_forum' => 'Forum',
	'nom_petition' => 'P&eacute;tition',
	'nom_portfolio' => 'Port-folio',
	'nom_logositespip' => 'Logo du site SPIP',
	'nom_formulaire_recherche' => 'Formulaire de recherche',
	'nom_navigation_rubriques' => 'Navigation par rubriques',
	'nom_article-mots_cles' => 'Mots-Cl&eacute;s de l\'article',
	'nom_menu' => 'Menu',
	'nom_page-login-formulaire_login' => 'Formulaire d\'identification',
	
	'label_afficher_date' => 'Afficher la date de publication&nbsp;?',
	'label_afficher_date_modif' => 'Afficher la date de derni&egrave;re modification&nbsp;?',
	'label_afficher_date_dernier_ajout' => 'Afficher la date de dernier ajout&nbsp;?',
	'label_afficher_auteurs' => 'Afficher les auteurs&nbsp;?',
	'label_afficher_traductions' => 'Afficher les traductions&nbsp;?',
	'label_afficher_lienhypertexte' => 'Afficher le lien hypertexte&nbsp;?',
	'label_afficher_logo' => 'Afficher le logo&nbsp;?',
	'label_utiliser_logo_article_rubrique' => 'Afficher le logo de la rubrique parente si l\'article n\'a pas de logo&nbsp;?',
	'label_exclure_photos' => 'Exclure les photos&nbsp;?',
	'label_afficher_lien_accueil' => 'Lien vers la page d\'accueil&nbsp;?',
	'label_ariane_separateur' => 'S&eacute;parateur&nbsp;:',
	'label_afficher_titre_article' => 'Afficher le titre de l\'article&nbsp;?',
	'label_taille_max_logo' => 'Taille maximum du logo (en pixels)&nbsp;:',
	'label_afficher_descriptif' => 'Afficher descriptif&nbsp;?',
	'label_afficher_recherche' => 'Afficher le texte recherch&eacute;&nbsp;?',
	'label_inclure_photos_vues' => 'Afficher les photos d&eacute;j&agrave; inclues dans la page&nbsp;?',
	'label_afficher_titre_rubriques' => 'Afficher "Rubriques" comme titre&nbsp;?',
	'label_selection' => '&Eacute;l&eacute;ments &agrave; s&eacute;lectionner&nbsp;:',
	'label_si_pagination' => 'Si utilisation d\'une pagination',
	'label_pas_pagination' => 'Pas de la pagination&nbsp;:',
	'label_style_liste' => 'Style de liste&nbsp;:',
	'label_tri' => 'Crit&egrave;re de tri&nbsp;:',
	'label_senstri' => 'Sens du tri&nbsp;:',
	'label_restreindre_langue' => 'Restreindre &agrave; la langue en cours&nbsp;?',
	'label_afficher_titre_liste' => 'Afficher un titre de liste&nbsp;?',
	'label_titre_liste' => 'Si affichage d\'un titre, lequel&nbsp;?',
	'label_titre_liste_perso' => 'Si titre personnalis&eacute;&nbsp;:',
	'label_position_pagination' => 'Position de la pagination&nbsp;:',
	'label_style_pagination' => 'Style de la pagination&nbsp;:',
	'label_limite' => 'Si nombre limit&eacute;, nombre d\'objets &agrave; afficher&nbsp;:',
	'label_si_resume' => 'Si affichage de r&eacute;sum&eacute;s',
	'label_afficher_introduction' => 'Afficher l\'introduction&nbsp;?',
	'label_exclure_article_en_cours' => 'Exclure l\'article en cours de la liste&nbsp;?',
	'label_liste_articles' => 'Articles &agrave; lister&nbsp;:',
	'label_rubrique_specifique' => 'Si rubrique sp&eacute;cifique, quelle rubrique&nbsp;?',
	'label_si_liste_simple' => 'Si affichage d\'une liste simple',
	'label_afficher_surtitre' => 'Afficher le sur-titre&nbsp;?',
	'label_afficher_soustitre' => 'Afficher le sous-titre&nbsp;?',
	'label_afficher_rubrique' => 'Afficher la rubrique&nbsp;?',
	'label_texte_devant_rubrique' => 'Si oui, texte devant la rubrique&nbsp;:',
	'label_longueur_max_introduction' => 'Si introduction, longueur maximum&nbsp;:',
	'label_afficher_texte_article' => 'Afficher le texte de l\'article&nbsp;?',
	'label_afficher_lire_la_suite' => 'Afficher \'Lire la suite\'&nbsp;?',
	'label_rappeler_titre' => 'Rappeler le titre&nbsp;?',
	'label_afficher_nb_commentaires' => 'Afficher le nombre de commentaires&nbsp;?',
	'label_afficher_mots_cles' => 'Afficher les mots-cl&eacute;s&nbsp;?',
	'label_texte_devant_mots_cles' => 'Si oui, texte devant les mots-cl&eacute;s&nbsp;:',
	'label_afficher_popularite' => 'Afficher la popularit&eacute;&nbsp;?',
	'label_liste_mots' => 'Mots-Cl&eacute;s &agrave; lister&nbsp;:',
	'label_groupes_specifiques' => 'Si certains groupes, lesquels &nbsp;?',
	'label_separer_resultats_groupes' => 'S&eacute;parer les r&eacute;sultats par groupe&nbsp;?',
	'label_afficher_groupe' => 'Afficher le type (groupe) de mot-cl&eacute;&nbsp;?',
	'label_lien_groupe_mots' => 'Si oui, ajouter un lien vers la page des groupes de mots&nbsp;?',
	'label_afficher_statistiques_mot' => 'Afficher les statistiques du mot-cl&eacute;&nbsp;?',
	'label_si_texte_complet' => 'Si affichage du texte complet',
	'label_taille_max_images_texte' => 'Largeur maximale (en pixels) des images dans le texte&nbsp;:',
	'label_identifiant_menu' => 'Menu &eacute; afficher&nbsp;:',
	'label_afficher_titre_menu' => 'Afficher le titre du menu&nbsp;?',
	
	'explication_restreindre_langue' => 'Dans le cas d\'un site multilingue, on peut vouloir restreindre l\'affichage uniquement aux objets dans la m&ecirc;me langue.',
	'explication_raccourcis_typo' => 'Vous pouvez utiliser les raccourcis typographiques de SPIP.',
	'explication_meme_rubrique' => 'Si vous choisissez <i>m&ecirc;me rubrique</i>, la liste sera limit&eacute;e aux objets situ&eacute;e dans la m&ecirc;me rubrique si l\'on est situ&eacute; dans une rubrique et listera tous les objets sinon.',
	
	'item_tout' => 'tous les &eacute;l&eacute;ments sans pagination',
	'item_limite' => 'un nombre limit&eacute; d\'&eacute;l&eacute;ments',
	'item_pagination' => 'utiliser une pagination',
	'item_liste' => 'liste simple',
	'item_resume' => 'r&eacute;sum&eacute;s',
	'item_titre' => 'titre',
	'item_date' => 'date de publication',
	'item_date_modif' => 'date de derni&egrave;re modification',
	'item_date_redac' => 'date de r&eacute;daction ant&eacute;rieure',
	'item_popularite' => 'popularit&eacute;',
	'item_ascendant' => 'tri ascendant',
	'item_descendant' => 'tri descendant',
	'item_titre_perso' => 'Titre personnalis&eacute;',
	'item_pagination_debut' => 'en d&eacute;but de liste',
	'item_pagination_fin' => 'en fin de liste',
	'item_pagination_deux' => 'en d&eacute;but et en fin de liste',
	'item_pagination_defaut' => '0 | 10 | 20 | 30 | 40 | 50',
	'item_pagination_precedent_suivant' => '    page pr&eacute;c&eacute;dente | page suivante',
	'item_pagination_page' => '1 | 2 | 3 | 4 | 5 | 6',
	'item_pagination_page_precedent_suivant' => '< 1 | 2 | 3 | 4 | 5 | 6 | >',
	'item_pagination_simple' => '&laquo; 1 /10 &raquo;',
	'item_articles_tous' => 'tous les articles du site',
	'item_meme_rubrique' => 'dans la m&ecirc;me rubrique',
	'item_rubrique_specifique' => 'dans une rubrique sp&eacute;cifique',
	'item_mots_tous' => 'tous les mots-cl&eacute;s',
	'item_groupes_specifiques' => 'uniquement les mots-cl&eacute;s appartenant &agrave; certains groupes',
	'item_rien' => 'rien',
	'item_introduction' => 'introduction',
	'item_complet' => 'texte complet',
	
	
);

?>