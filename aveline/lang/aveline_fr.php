<?php

// S�curit�
if (!defined("_ECRIRE_INC_VERSION")) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(

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
	'description_page-contact' => 'Acessible via <i>spip.php?page=contact</i>, cette page optionnelle permet de renseigner vos coordonn&eacute;es et/ou de fournir un formulaire de contact.',
	
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
	'nom_page-contact' => 'Contact',
	
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
	'description_documents' => 'Par d&eacute;faut, n\'affiche pas les photos, celles-ci &eacute;tant affich&eacute;es usuellement via un portfolio. Vous pouvez forcer l\'affichage des photos au cas o&ugrave; vous n\'affichez pas de portfolio.',
	'description_article-filariane' => 'Affiche l\'arborescence des rubriques jusqu\'&agrave; l\'article.',
	'description_portfolio' => 'Portfolio de la distribution par d&eacute;faut de SPIP.',
	'description_navigation_rubriques' => 'Liste des rubriques et des sous-rubriques (toutes langues) tri&eacute;es par titre.',
	'description_navigation_secteurs_langue' => 'Liste des rubriques et des sous-rubriques, tri&eacute;es par titre, du secteur de la langue actuelle. &Agrave; n\'utiliser que sur un site organis&eacute; en secteurs de langue (une langue par secteur et un secteur par langue).',
	'description_article-mots_cles' => 'Liste les mots-cl&eacute;s associ&eacute;s &agrave; l\'article.',
	'description_menu' => 'Affiche un menu d&eacute;fini avec le plugin Menus.',
	'description_selecteur_archives' => 'Cette noisette est &agrave; utiliser en conjonction avec la noisette <i>Articles de la rubrique ou du site</i> (les deux noisettes doivent &ecirc;tre plac&eacute;es sur la m&ecirc;me page). &Agrave; la mani&egrave;re d\'un blog, elle fournit une liste des mois et/ou des ann&eacute;es pour lesquels des articles ont &eacute;t&eacute; publi&eacute;s et permet de recharger la page en filtrant les r&eacute;sultats selon la p&eacute;riode choisie. Pensez &agrave; param&eacute;trer le choix de la rubrique comme pour la noisette <i>Articles de la rubrique ou du site</i>.',
	'description_formulaire_contact' => 'N&eacute;cessite le plugin <i>Formulaire de contact avanc&eacute;</i>. Le formulaire est configurable sur cette page&nbsp;: <a href="./?exec=cfg&cfg=contact">/?exec=cfg&cfg=contact</a>.',
	
	'nom_article-contenuprincipal' => 'Contenu principal de l\'article',
	'nom_liste_articles' => 'Articles de la rubrique ou tous les articles',
	'nom_rubrique-contenuprincipal' => 'Contenu principal',
	'nom_article-documents' => 'Documents de l\'article',
	'nom_filariane' => 'Fil d\'ariane',
	'nom_article-filariane' => 'Fil d\'ariane de l\'article',
	'nom_article-forum' => 'Forum de l\'article',
	'nom_petition' => 'P&eacute;tition',
	'nom_article-portfolio' => 'Portfolio de l\'article',
	'nom_logositespip' => 'Logo du site SPIP',
	'nom_formulaire_recherche' => 'Formulaire de recherche',
	'nom_navigation_rubriques' => 'Navigation par rubriques',
	'nom_navigation_secteurs_langue' => 'Navigation par rubriques du secteur de langue',
	'nom_article-mots_cles' => 'Mots-Cl&eacute;s de l\'article',
	'nom_menu' => 'Menu',
	'nom_page-login-formulaire_login' => 'Formulaire d\'identification',
	'nom_article-formulaire_notation' => 'Formulaire de notation de l\'article',
	'nom_selecteur_archives' => 'S&eacute;lecteur d\'archives',
	'nom_article-lien_hypertexte' => 'Lien hypertexte de l\'article',
	'nom_formulaire_contact' => 'Formulaire de contact avanc&eacute;',
	
	'label_afficher_date' => 'Afficher la date de publication&nbsp;?',
	'label_afficher_date_modif' => 'Afficher la date de derni&egrave;re modification&nbsp;?',
	'label_afficher_date_dernier_ajout' => 'Afficher la date de dernier ajout&nbsp;?',
	'label_afficher_auteurs' => 'Afficher les auteurs&nbsp;?',
	'label_afficher_traductions' => 'Afficher les traductions&nbsp;?',
	'label_afficher_lienhypertexte' => 'Afficher le lien hypertexte&nbsp;?',
	'label_afficher_logo' => 'Afficher le logo&nbsp;?',
	'label_utiliser_logo_article_rubrique' => 'Afficher le logo de la rubrique parente si l\'article n\'a pas de logo&nbsp;?',
	'label_exclure_photos' => 'Exclure les photos&nbsp; du portfolio?',
	'label_afficher_lien_accueil' => 'Lien vers la page d\'accueil&nbsp;?',
	'label_ariane_separateur' => 'S&eacute;parateur&nbsp;:',
	'label_afficher_titre_article' => 'Afficher le titre de l\'article&nbsp;?',
	'label_taille_max_logo' => 'Taille maximum du logo (en pixels)&nbsp;:',
	'label_afficher_descriptif' => 'Afficher le descriptif&nbsp;?',
	'label_afficher_recherche' => 'Afficher le texte recherch&eacute;&nbsp;?',
	'label_inclure_photos_vues' => 'Afficher les photos d&eacute;j&agrave; inclues dans la page&nbsp;?',
	'label_inclure_documents_vus' => 'Afficher les documents d&eacute;j&agrave; inclue dans la page&nbsp;?',
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
	'label_afficher_visites' => 'Afficher le nombre de visites&nbsp;?',
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
	'label_choix_tri' => 'Permettre au visiteur de modifier le tri&nbsp;?',
	'label_si_choix_tri' => 'Si tri modifiable',
	'label_position_choix_tri' => 'Position de la liste de choix&nbsp;:',
	'label_afficher_note' => 'Afficher la note&nbsp;?',
	'label_afficher_formulaire_note' => 'Afficher le formulaire de notation&nbsp;?',
	'label_formulaire_notation' => 'Si formulaire de notation, lequel&nbsp;?',
	'label_afficher_titre_noisette' => 'Afficher un titre de noisette&nbsp;?',
	'label_titre_noisette' => 'Si affichage d\'un titre, lequel&nbsp;?',
	'label_titre_noisette_perso' => 'Si titre personnalis&eacute;&nbsp;:',
	'label_afficher_secteur' => 'Afficher secteur&nbsp;?',
	'label_afficher_selecteur_archives' => 'Afficher un s&eacute;lecteur d\'archives par mois et/ou ann&eacute;e&nbsp;?',
	'label_si_afficher_selecteur_archives' => 'Si affichage d\'un s&eacute;lecteur d\'archives',
	'label_position_selecteur_archives' => 'Position du s&eacute;lecteur&nbsp;:',
	'label_pas_selecteur_archives' => 'Pas du s&eacute;lecteur&nbsp;:',
	'label_texte_devant_selecteur_archives' => 'Texte devant le s&eacute;lecteur&nbsp;:',
	'label_compteur_articles_selecteur_archives' => 'Afficher le nombre d\'articles&nbsp;?',
	'label_style_selecteur' => 'Style du s&eacute;lecteur&nbsp;:',
	'label_hauteur_max_images' => 'Hauteur maximum des images&nbsp;:',
	'label_longueur_max_titres' => 'Longueur maximum des titres&nbsp;:',
	'label_afficher_type' => 'Afficher le type de document&nbsp;?',
	'label_afficher_taille' => 'Afficher la taille du document&nbsp;?',
	'label_afficher_telecharger' => 'Afficher un lien "T&eacute;l&eacute;charger"&nbsp;?',
	'label_thread' => 'Pr&eacute;sentation des fils de discussions&nbsp;:',
	'label_afficher_logo_auteur' => 'Afficher le logo de l\'auteur&nbsp;?',
	'label_formulaire_reponse_volant' => 'Formulaire de r&eacute;ponse volant&nbsp;?',
	'label_afficher_titre_message' => 'Afficher le titre du message&nbsp;?',
	'label_afficher_lien_permanent' => 'Afficher un lien permanent&nbsp;?',
	'label_niveau_titre' => 'Niveau du titre&nbsp;:',
	
	'explication_restreindre_langue' => 'Dans le cas d\'un site multilingue, on peut vouloir restreindre l\'affichage uniquement aux objets dans la m&ecirc;me langue.',
	'explication_raccourcis_typo' => 'Vous pouvez utiliser les raccourcis typographiques de SPIP.',
	'explication_meme_rubrique' => 'Si vous choisissez <i>m&ecirc;me rubrique</i>, la liste sera limit&eacute;e aux objets situ&eacute;e dans la m&ecirc;me rubrique si l\'on est situ&eacute; dans une rubrique et listera tous les objets sinon.',
	'explication_tri' => 'ATTENTION&nbsp;: le crit&egrave;re note n&eacute;cessite que le plugin Notation soit actif.',
	'explication_choix_tri' => 'Comme sur SPIP-Contrib, ajoute des liens permettant au visiteur de modifier le crit&egrave;re de tri de la liste.',
	'explication_necessite_notation' => 'ATTENTION&nbsp;: n&eacute;cessite que le plugin Notation soit actif.',
	'explication_afficher_selecteur_archives' => '&Agrave; la fa&ccedil;on d\'un blog, ajoute en d&eacute;but et/ou en fin de liste un s&eacute;lecteur permettant de restreindre la liste aux publications d\'un mois ou d\'une date donn&eacute;e. Pour afficher ce s&eacute;lecteur dans un autre bloc, vous pouvez utiliser &agrave; la place une noisette <i>S&eacute;lecteur d\'archives</i>.',
	'explication_formulaire_reponse_volant' => 'Reproduis le fonction de SPIP-Contrib&nbsp;: lorsque le visiteur clique sur r&eacute;pondre &agrave; ce message, le formulaire de r&eacute;ponse vient se placer sous le message.',
	
	'item_tout' => 'tous les &eacute;l&eacute;ments sans pagination',
	'item_limite' => 'un nombre limit&eacute; d\'&eacute;l&eacute;ments',
	'item_pagination' => 'utiliser une pagination',
	'item_liste' => 'liste simple',
	'item_select' => 's&eacute;lecteur de formulaire',
	'item_resume' => 'r&eacute;sum&eacute;s',
	'item_titre' => 'titre',
	'item_date' => 'date de publication',
	'item_extension' => 'extension',
	'item_date_modif' => 'date de derni&egrave;re modification',
	'item_date_redac' => 'date de r&eacute;daction ant&eacute;rieure',
	'item_popularite' => 'popularit&eacute;',
	'item_visites' => 'nombre de visites',
	'item_nbre_commentaires' => 'nombre de commentaires',
	'item_note' => 'note (n&eacute;cessite le plugin Notation)',
	'item_ascendant' => 'tri ascendant',
	'item_descendant' => 'tri descendant',
	'item_titre_perso' => 'Titre personnalis&eacute;',
	'item_debut' => 'en d&eacute;but de liste',
	'item_fin' => 'en fin de liste',
	'item_deux' => 'en d&eacute;but et en fin de liste',
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
	'item_notation' => 'formulaire de notation classique',
	'item_jaime_jaimepas' => 'formulaire J\'aime / Je n\'aime pas',
	'item_jaime' => 'formulaire J\'aime',
	'item_annee' => 'par ann&eacute;e',
	'item_mois' => 'par mois',
	'item_annee_mois' => 'par ann&eacute;e et par mois',
	'item_aucun' => 'aucun',
	'item_nb_messages' => 'xx Messages de forum',
	'item_thread_plat' => 'liste de commentaires (&agrave; plat)',
	'item_thread_simple' => 'en enfilades simples (les r&eacute;ponses se suivent au sein d\'un m&ecirc;me sujet)',
	'item_thread_complet' => 'en arborescence (en thread, on peut r&eacute;pondre &agrave; chaque message)'
);

?>