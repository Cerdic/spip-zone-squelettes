<?php

// S�curit�
if (!defined("_ECRIRE_INC_VERSION")) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(

	// Chaines affich�es sur la partie publique
	'rubrique_deux_points' => 'Rubrique&nbsp;:',
	'categorie_deux_points' => 'Cat&eacute;gorie&nbsp;:',
	'mots_cles_deux_points' => 'Mots-Cl&eacute;s&nbsp;:',
	'tags_deux_points' => 'Tags&nbsp;:',
	'dans' => 'Dans',
	'mis_a_jour_le' => 'Mis &agrave; jour le',
	'visiteurs_quotidiens' => 'visiteur(s) quotidien(s)',

	// Description des pages
	
	'description_pagedefaut' => 'Les blocs de cette page seront affich&eacute;s par d&eacute;faut pour les blocs o&ugrave; aucune noisette n\'est d&eacute;finie.',
	'description_page_article' => 'C\'est la page utilis&eacute;e pour afficher chaque article.',
	'description_page_rubrique' => 'C\'est la page utilis&eacute;e pour afficher chaque rubrique.',
	'description_page_auteur' => 'C\'est la page utilis&eacute;e pour afficher chaque auteur.',
	'description_page_breve' => 'C\'est la page utilis&eacute;e pour afficher chaque br&egrave;ve.',
	'description_page_mot' => 'C\'est la page utilis&eacute;e pour afficher chaque mot-cl&eacute;.',
	'description_page-forum' => 'Cette page est appel&eacute;e lorsqu\'un visiteur souhaiter poster un message dans un forum.',
	'description_page-plan' => 'Cette page est appel&eacute;e pour afficher le plan du site.',
	'description_page-recherche' => 'Cette page est affich&eacute;e lorsqu\'une recherche est effectu&eacute;e sur le site.',
	'description_page-login' => 'Cette page est affich&eacute;e lorsqu\'un visiteur souhaite se connecter.',
	'description_page-spip_pass' => 'Cette page est affich&eacute;e lorsqu\'un visiteur a oubli&eacute; son mot de passe et souhaite en changer.',
	'description_page-401' => 'Cette page est affich&eacute;e lorsqu\'un visiteur demande &agrave; voir une page pour laquelle il n\'est pas autoris&eacute;.',
	'description_page-404' => 'Cette page est affich&eacute;e lorsqu\'un visiteur demande &agrave; voir une page qui n\'existe pas ou plus.',
	'description_page_site' => 'Cette page est affich&eacute;e pour chaque site web r&eacute;f&eacute;renc&eacute;.',
	
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
	
	// Description des noisettes
	
	'description_article-contenuprincipal' => 'Affiche logo, surtitre, titre, sous-titre, date, auteur, traduction, chapeau, texte, lien hypertexte, post-scriptum et notes. Utilisez les param&egrave;tres ci-dessous pour personnaliser les &eacute;l&eacute;ments &agrave; afficher.',
	'description_liste_articles' => 'Liste l\'ensemble des articles du site ou bien les articles situ&eacute;s dans la m&ecirc;me rubrique ou dans une rubrique donn&eacute;e.',
	'description_rubrique-contenuprincipal' => 'Affiche logo, date de dernier ajout et texte. Utilisez les param&egrave;tres ci-dessous pour personnaliser les &eacute;l&eacute;ments &agrave; afficher.',
	'description_documents' => 'Par d&eacute;faut, n\'affiche pas les photos, celles-ci &eacute;tant affich&eacute;es usuellement via un port-folio. Vous pouvez forcer l\'affichage des photos au cas o&ugrave; vous n\'affichez pas de port-folio.',
	'description_article-filariane' => 'Affiche l\'arborescence des rubriques jusqu\'&agrave; l\'article.',
	'description_portfolio' => 'Port-folio de la distribution par d&eacute;faut de SPIP',
	'description_navigation_rubriques' => 'Liste des rubriques et des sous-rubriques (toutes langues) tri&eacute;es par titre.',
	
	'nom_article-contenuprincipal' => 'Contenu principal',
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
	'label_si_titre_liste' => 'Si affichage d\'un titre de liste',
	'label_titre_liste' => 'Titre de la liste&nbsp;:',
	'label_titre_liste_perso' => 'Titre de liste personnalis&eacute;&nbsp;:',
	'label_position_pagination' => 'Position de la pagination&nbsp;:',
	'label_style_pagination' => 'Style de la pagination&nbsp;:',
	'label_si_limite' => 'Si affichage d\'un nombre limit&eacute; d\'objets',
	'label_limite' => 'Nombre d\'objets &agrave; afficher&nbsp;:',
	'label_si_resume' => 'Si affichage de r&eacute;sum&eacute;s',
	'label_afficher_introduction' => 'Afficher l\'introduction&nbsp;?',
	'label_exclure_article_en_cours' => 'Exclure l\'article en cours de la liste&nbsp;?',
	'label_liste_articles' => 'Articles &agrave; lister&nbsp;:',
	'label_si_rubrique_specifique' => 'Si dans une rubrique sp&eacute;cifique',
	'label_rubrique_specifique' => 'Rubrique&nbsp;:',
	'label_si_liste_simple' => 'Si affichage d\'une liste simple',
	'label_afficher_surtitre' => 'Afficher le sur-titre&nbsp;?',
	'label_afficher_soustitre' => 'Afficher le sous-titre&nbsp;?',
	'label_afficher_rubrique' => 'Afficher la rubrique&nbsp;?',
	'label_texte_devant_rubrique' => 'Texte devant la rubrique&nbsp;:',
	'label_longueur_max_introduction' => 'Longueur maximum de l\'introduction&nbsp;:',
	'label_afficher_lire_la_suite' => 'Afficher \'Lire la suite\'&nbsp;?',
	'label_rappeler_titre' => 'Rappeler le titre&nbsp;?',
	'label_afficher_nb_commentaires' => 'Afficher le nombre de commentaires&nbsp;?',
	'label_afficher_mots_cles' => 'Afficher les mots-cl&eacute;s&nbsp;?',
	'label_texte_devant_mots_cles' => 'Texte devant les mots-cl&eacute;s&nbsp;:',
	'label_afficher_popularite' => 'Afficher la popularit&eacute;&nbsp;?',
	
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
	'item_titre_perso' => 'Titre de liste personnalis&eacute; (ci-dessous)',
	'item_pagination_debut' => 'en d&eacute;but de liste',
	'item_pagination_fin' => 'en fin de liste',
	'item_pagination_deux' => 'en d&eacute;but et en fin de liste',
	'item_pagination_defaut' => '0 | 10 | 20 | 30 | 40 | 50',
	'item_pagination_precedent_suivant' => '    page pr&eacute;c&eacute;dente | page suivante',
	'item_pagination_page' => '1 | 2 | 3 | 4 | 5 | 6',
	'item_pagination_page_precedent_suivant' => '< 1 | 2 | 3 | 4 | 5 | 6 | >',
	'item_articles_tous' => 'tous les articles du site',
	'item_meme_rubrique' => 'dans la m&ecirc;me rubrique',
	'item_rubrique_specifique' => 'dans une rubrique sp&eacute;cifique',
	
	// Description du bloc avantcontenu
	'nom_bloc_avantcontenu' => 'Avant le contenu principal',
	'description_bloc_avantcontenu' => 'Sur les pages sensibles (se connecter, mot de passe oubli&eacute;), un contenu par d&eacute;faut est maintenu. Vous pouvez utiliser ce bloc pour ins&eacute;rer des noisettes avant ce contenu par d&eacute;faut.'
	
);

?>