<?php

// S&eacute;curit&eacute;
if (!defined("_ECRIRE_INC_VERSION")) return;

$GLOBALS[$GLOBALS['idx_lang']] = array(
	// C
	'config-aveline-type-blog' => 'Aveline - Configuration de type blog',
	'config-aveline-zpip-dist' => 'Aveline - Zpip-dist',
	'config-aveline-zpip-groupe-mots' => 'Aveline - Zpip avec groupes de mots',
	'config-aveline-zpip-groupe-mots-menus' => 'Aveline - Zpip avec groupes de mots et menus',
	'config-aveline-zpip-secteurs-langue' => 'Aveline - Zpip avec secteurs de langue',
	'config-aveline-zpip-secteurs-langue-menus' => 'Aveline - Zpip avec secteurs de langue et menus',
	
	// D
	'description-config-aveline-type-blog' => 'Pr&eacute;sentation de type blog (les br&egrave;ves sont d&eacute;sactiv&eacute;es).',
	'description-config-aveline-zpip-dist' => 'Cette configuration reproduit Zpip-dist (adapt&eacute;e pour un site monolingue).',
	'description-config-aveline-zpip-groupe-mots' => 'Cette configuration reproduit Zpip-dist en ajoutant une page pour les groupes de mots.',
	'description-config-aveline-zpip-groupe-mots-menus' => 'Cette configuration reproduit Zpip-dist en ajoutant une page pour les groupes de mots et en ajoutant deux menus (pour la barre horizontale et pour la navigation).',
	'description-config-aveline-zpip-secteurs-langue' => 'Cette configuration est adapt&eacute;e aux sites multilingues organis&eacute;s en secteurs de langue.',
	'description-config-aveline-zpip-secteurs-langue-menus' => 'Cette configuration est adapt&eacute;e aux sites multilingues organis&eacute;s en secteurs de langue. Elle ajoute également deux menus (pour la barre horizontale et pour la navigation).',
	'description_agenda-contenuprincipal' => 'Affiche date, titre, descriptif, lieu, adresse, logo et nombre de participants.',
	'description_article-contenuprincipal' => 'Affiche logo, surtitre, titre, sous-titre, date, auteur, traduction, chapeau, texte, lien hypertexte, post-scriptum et notes.',
	'description_article-filariane' => 'Affiche l\'arborescence des rubriques jusqu\'&agrave; l\'article.',
	'description_article-mots_cles' => 'Liste les mots-cl&eacute;s associ&eacute;s &agrave; l\'article.',
	'description_auteur-contenuprincipal' => 'Affiche nom, logo, biographie et site web.',
	'description_breve-contenuprincipal' => 'Affiche logo, titre, texte, lien hypertexte et notes.',
	'description_breve-filariane' => 'Affiche l\'arborescence des rubriques jusqu\'&agrave; la br&egrave;ve.',
	'description_breve-mots_cles' => 'Liste les mots-cl&eacute;s associ&eacute;s &agrave; la br&egrave;ve.',
	'description_documents' => 'Par d&eacute;faut, n\'affiche pas les photos, celles-ci &eacute;tant affich&eacute;es usuellement via un portfolio. Vous pouvez forcer l\'affichage des photos au cas o&ugrave; vous n\'affichez pas de portfolio.',
	'description_evenement-filariane' => 'Affiche l\'arborescence des rubriques jusqu\'&agrave; l\'&eacute;v&egrave;nement.',
	'description_evenement-mots_cles' => 'Liste les mots-cl&eacute;s associ&eacute;s &agrave; l\'&eacute;v&egrave;nement.',
	'description_formulaire_inscription' => 'Ne s\'affichera que si vous avez autoris&eacute; l\'inscriprion de nouveaux r&eacute;dacteurs.',
	'description_groupe_mots-contenuprincipal' => 'Affiche nom, descriptif et texte.',
	'description_liste_articles' => 'Liste l\'ensemble des articles du site ou bien les articles situ&eacute;s dans la m&ecirc;me rubrique ou dans une rubrique donn&eacute;e.',
	'description_liste_auteurs' => 'Liste l\'ensemble des auteurs du site ayant au moins un article publi&eacute;.',
	'description_liste_breves' => 'Liste l\'ensemble des br&egrave;ves du site ou bien les br&egrave;ves situ&eacute;s dans la m&ecirc;me rubrique, le m&ecirc;me secteur ou dans une rubrique donn&eacute;e.',
	'description_liste_forums' => 'Liste l\'ensemble des messages de forum du site (permet d\'afficher par exemple les derniers commentaires post&eacute;s).',
	'description_liste_sites' => 'Liste l\'ensemble des sites ou bien les sites situ&eacute;s dans la m&ecirc;me rubrique ou dans une rubrique donn&eacute;e.',
	'description_liste_syndic_articles' => 'Liste l\'ensemble des articles syndiqu&eacute;s du site SPIP ou bien les articles syndiqu&eacute;s situ&eacute;s dans la m&ecirc;me rubrique ou dans une rubrique donn&eacute;e.',
	'description_mot-contenuprincipal' => 'Affiche nom, logo, type, descriptif et texte.',
	'description_navigation_rubriques' => 'Liste des rubriques et des sous-rubriques (toutes langues) tri&eacute;es par titre.',
	'description_navigation_secteurs_langue' => 'Liste des rubriques et des sous-rubriques, tri&eacute;es par titre, du secteur de la langue actuelle. &Agrave; n\'utiliser que sur un site organis&eacute; en secteurs de langue (une langue par secteur et un secteur par langue).',
	'description_page-forum-contenuprincipal' => 'Affiche un r&eacute;sum&eacute; de l\'objet parent (message, article, rubrique, br&egrave;ve ou site) et le formulaire de r&eacute;ponse.',
	'description_page-plan-contenuprincipal' => 'Affiche le titre de la page.',
	'description_page-sommaire-contenuprincipal' => 'Affiche le nom du site, son descriptif et son logo.',
	'description_plan_simple' => 'Affiche liste les rubriques, sous-rubriques et articles du site.',
	'description_plan_simple_secteur_langue' => 'Affiche liste les rubriques, sous-rubriques et articles du secteur de langue. &Agrave; utiliser sur un site organis&eacute; avec un secteur par langue.',
	'description_portfolio' => 'Portfolio de la distribution par d&eacute;faut de SPIP.',
	'description_resultats_recherche' => 'Les r&eacute;sultats seront tri&eacute;s par pertinence (points) d&eacute;croissante.',
	'description_rubrique-contenuprincipal' => 'Affiche logo, date de dernier ajout, descriptif et texte.',
	'description_rubrique-filariane' => 'Affiche l\'arborescence des rubriques jusqu\'&agrave; la rubrique.',
	'description_rubrique-formulaire_site' => 'Affiche un formulaire permettant aux visiteurs du site de proposer des r&eacute;f&eacute;rencements de sites. Ces sites appara&icirc;tront comme &laquo;&nbsp;propos&eacute;s&nbsp;&raquo; dans l\'espace priv&eacute;, en attendant une validation par les administrateurs.<br />Ce formulaire ne s\'affiche que si vous avez activ&eacute; l\'option &laquo;&nbsp;G&eacute;rer un annuaire de sites&nbsp;&raquo; dans la Configuration sur site dans l\'espace priv&eacute;, et si vous avez r&eacute;gl&eacute; &laquo;&nbsp;Qui peut proposer des sites r&eacute;f&eacute;renc&eacute;s&nbsp;&raquo; sur &laquo;&nbsp;les visiteurs du site public&nbsp;&raquo;.',
	'description_rubrique-miniplan' => 'Affiche l\'arborescence des sous-rubriques de la rubrique.',
	'description_rubrique-mots_cles' => 'Liste les mots-cl&eacute;s associ&eacute;s &agrave; la rubrique.',
	'description_rubrique-sous_rubriques' => 'Liste les sous-rubrique de la rubrique en cours.',
	'description_rubriques_racine' => 'Liste les rubriques situ&eacute;es &agrave; la racine du site web, encore appel&eacute;es secteurs.',
	'description_rubriques_secteur_langue' => 'Liste les sous-rubriques du secteur de la langue en cours. Cette noisette est sp&eacute;cifique aux sites structur&eacute;s avec un secteur par langue.',
	'description_selecteur_archives' => 'Cette noisette est &agrave; utiliser en conjonction avec la noisette <i>Liste d\'articles</i> (les deux noisettes doivent &ecirc;tre plac&eacute;es sur la m&ecirc;me page). &Agrave; la mani&egrave;re d\'un blog, elle fournit une liste des mois et/ou des ann&eacute;es pour lesquels des articles ont &eacute;t&eacute; publi&eacute;s et permet de recharger la page en filtrant les r&eacute;sultats selon la p&eacute;riode choisie. Vous devez param&eacute;trer le choix de la rubrique comme pour la noisette <i>Liste d\'articles</i>.',
	'description_site-contenuprincipal' => 'Affiche logo, nom, descriptif, lien et notes.',
	'description_site-filariane' => 'Affiche l\'arborescence des rubriques jusqu\'au site.',
	'description_site-mots_cles' => 'Liste les mots-cl&eacute;s associ&eacute;s au site.',
	'description_site-syndic_articles' => 'Liste l\'ensemble des articles syndiqu&eacute;s de ce site.',
	
	// E
	'explication_afficher_selecteur_archives' => '&Agrave; la fa&ccedil;on d\'un blog, ajoute en d&eacute;but et/ou en fin de liste un s&eacute;lecteur permettant de restreindre la liste aux publications d\'un mois ou d\'une date donn&eacute;e.',
	'explication_afficher_tri_alphabetique_nom' => 'Quand la liste tri&eacute;e par nom, affiche un index alphab&eacute;tique permet d\'acc&eacute;der directement aux &eacute;l&eacute;ments dont le titre commence par la lettre demand&eacute;e.',
	'explication_afficher_tri_alphabetique_titre' => 'Quand la liste tri&eacute;e par titre, affiche un index alphab&eacute;tique permet d\'acc&eacute;der directement aux &eacute;l&eacute;ments dont le titre commence par la lettre demand&eacute;e. <strong>ATTENTION&nbsp;:</strong> ne fonctionnera pas correctement si vous utilisez des titres num&eacute;rot&eacute;s.',
	'explication_choix_tri' => 'Comme sur SPIP-Contrib, ajoute des liens permettant au visiteur de modifier le crit&egrave;re de tri de la liste.',
	'explication_formulaire_reponse_volant' => 'Reproduis le fonction de SPIP-Contrib&nbsp;: lorsque le visiteur clique sur r&eacute;pondre &agrave; ce message, le formulaire de r&eacute;ponse vient se placer sous le message.',
	'explication_lien_page_auteurs' => 'Rajoute un lien vers une page \'auteurs\' o&ugrave; vous pourrez lister l\'ensemble des auteurs du site. Vous devrez cr&eacute;er cette page (composition du type \'page\' avec l\'identifiant \'auteurs\'.',
	'explication_necessite_notation' => 'ATTENTION&nbsp;: n&eacute;cessite que le plugin Notation soit actif.',
	'explication_raccourcis_typo' => 'Vous pouvez utiliser les raccourcis typographiques de SPIP.',
	'explication_restreindre_langue' => 'Dans le cas d\'un site multilingue, on peut vouloir restreindre l\'affichage uniquement aux objets dans la m&ecirc;me langue.',
	'explication_tri_note' => 'ATTENTION&nbsp;: le crit&egrave;re note n&eacute;cessite que le plugin Notation soit actif.',
	'explication_utiliser_logo_evenement_article_rubrique' => 'Pour que les &eacute;v&egrave;nements puissent avoir leur propre logo, vous devez installer le plugin \'Documents et Logo pour Agenda\'.',
	'explication_vignette_ajout_css' => 'Une majorit&eacute; de th&egrave;mes pour Zpip ne prennent pas en compte les vignettes d\'auteurs. Cette option permet de rajouter en dur dans le squelette quelques styles CSS pour am&eacute;liorer l\'affichage. &Agrave; ne pas activer si le th&egrave;me prend en charge les vignettes.',
	
	// I
	'item_annee' => 'par ann&eacute;e',
	'item_articles_tous' => 'tous les articles du site',
	'item_ascendant' => 'tri ascendant',
	'item_aucun' => 'aucun',
	'item_branche_actuelle' => 'dans la branche',
	'item_branche_specifique' => 'dans une ou plusieurs branches sp&eacute;cifiques',
	'item_breves_toutes' => 'toutes les br&egrave;ves du site',
	'item_complet' => 'texte complet',
	'item_date' => 'date de publication',
	'item_date_modif' => 'date de derni&egrave;re modification',
	'item_date_redac' => 'date de r&eacute;daction ant&eacute;rieure',
	'item_date_rubrique' => 'date de la derni&egrave;re publication effectu&eacute;e dans la rubrique',
	'item_debut' => 'en d&eacute;but de liste',
	'item_descendant' => 'tri descendant',
	'item_deux' => 'en d&eacute;but et en fin de liste',
	'item_extension' => 'extension',
	'item_fin' => 'en fin de liste',
	'item_groupes_specifiques' => 'uniquement les mots-cl&eacute;s appartenant &agrave; certains groupes',
	'item_introduction' => 'introduction',
	'item_jaime' => 'formulaire J\'aime',
	'item_jaime_jaimepas' => 'formulaire J\'aime / Je n\'aime pas',
	'item_lesauteurs' => 'les auteurs de l\'article',
	'item_lien_groupe' => 'la page du groupe de mots',
	'item_lien_mot' => 'la page du premier mot du groupe',
	'item_limite' => 'un nombre limit&eacute; d\'&eacute;l&eacute;ments',
	'item_liste' => 'liste simple',
	'item_meme_rubrique' => 'dans la m&ecirc;me rubrique',
	'item_meme_secteur' => 'dans le m&ecirc;me secteur',
	'item_mois' => 'par mois',
	'item_mots_tous' => 'tous les mots-cl&eacute;s',
	'item_nb_articles' => 'par nombre d\'articles',
	'item_nb_messages' => 'xx Messages de forum',
	'item_nbre_commentaires' => 'nombre de commentaires',
	'item_nom' => 'par nom',
	'item_nom_site' => 'nom du site',
	'item_notation' => 'formulaire de notation classique',
	'item_note' => 'note (n&eacute;cessite le plugin Notation)',
	'item_num_titre' => 'rang (num&eacute;ro du titre)',
	'item_pagination' => 'utiliser une pagination',
	'item_pagination_defaut' => '0 | 10 | 20 | 30 | 40 | 50',
	'item_pagination_page' => '1 | 2 | 3 | 4 | 5 | 6',
	'item_pagination_page_precedent_suivant' => '< 1 | 2 | 3 | 4 | 5 | 6 | >',
	'item_pagination_precedent_suivant' => '    page pr&eacute;c&eacute;dente | page suivante',
	'item_pagination_simple' => '&laquo; 1 /10 &raquo;',
	'item_points' => 'pertinence (points)',
	'item_popularite' => 'popularit&eacute;',
	'item_resume' => 'r&eacute;sum&eacute;s',
	'item_rien' => 'rien',
	'item_rubrique_specifique' => 'dans une ou plusieurs rubriques sp&eacute;cifiques',
	'item_secteur_specifique' => 'dans un ou plusieurs secteurs sp&eacute;cifiques',
	'item_select' => 's&eacute;lecteur de formulaire',
	'item_sites_tous' => 'tous les sites web',
	'item_syndic_articles_tous' => 'tous les articles syndiqu&eacute;s du site',
	'item_texte_seul' => 'le d&eacute;but du message',
	'item_thread_complet' => 'en arborescence (en thread, on peut r&eacute;pondre &agrave; chaque message)',
	'item_thread_plat' => 'liste de commentaires (&agrave; plat)',
	'item_thread_simple' => 'en enfilades simples (les r&eacute;ponses se suivent au sein d\'un m&ecirc;me sujet)',
	'item_titre' => 'titre',
	'item_titre_perso' => 'Titre personnalis&eacute;',
	'item_titre_seul' => 'le titre',
	'item_titre_texte' => 'le titre et le d&eacute;but du message',
	'item_tout' => 'tous les &eacute;l&eacute;ments sans pagination',
	'item_vignettes' => 'vignettes',
	'item_visites' => 'nombre de visites',
	
	// L
	'label_afficher' => 'Afficher&nbsp;:',
	'label_afficher_adresse' => 'Afficher l\'adresse du lieu&nbsp?',
	'label_afficher_auteurs' => 'Afficher les auteurs&nbsp;?',
	'label_afficher_bio' => 'Afficher la biographie de l\'auteur&nbsp;?',
	'label_afficher_categorie' => 'Afficher la cat&eacute;gorie&nbsp;?',
	'label_afficher_date' => 'Afficher la date de publication&nbsp;?',
	'label_afficher_date_dernier_ajout' => 'Afficher la date de dernier ajout&nbsp;?',
	'label_afficher_date_modif' => 'Afficher la date de derni&egrave;re modification&nbsp;?',
	'label_afficher_derniers_articles_syndiques' => 'Afficher les derniers articles syndiqu&eacute;s&nbsp;?',
	'label_afficher_descriptif' => 'Afficher le descriptif&nbsp;?',
	'label_afficher_descriptif_site' => 'Afficher le descriptif du site&nbsp;?',
	'label_afficher_docs_joints' => 'Afficher les documents joints&nbsp;?',
	'label_afficher_formulaire_note' => 'Afficher le formulaire de notation&nbsp;?',
	'label_afficher_groupe' => 'Afficher le type (groupe) de mot-cl&eacute;&nbsp;?',
	'label_afficher_introduction' => 'Afficher l\'introduction&nbsp;?',
	'label_afficher_lien' => 'Afficher le lien&nbsp;?',
	'label_afficher_lien_accueil' => 'Lien vers la page d\'accueil&nbsp;?',
	'label_afficher_lien_permanent' => 'Afficher un lien permanent&nbsp;?',
	'label_afficher_lienhypertexte' => 'Afficher le lien hypertexte&nbsp;?',
	'label_afficher_lieu' => 'Afficher le lieu&nbsp?',
	'label_afficher_lire_la_suite' => 'Afficher \'Lire la suite\'&nbsp;?',
	'label_afficher_logo' => 'Afficher le logo&nbsp;?',
	'label_afficher_logo_auteur' => 'Afficher le logo de l\'auteur&nbsp;?',
	'label_afficher_logo_site' => 'Afficher le logo du site&nbsp;?',
	'label_afficher_mots_cles' => 'Afficher les mots-cl&eacute;s&nbsp;?',
	'label_afficher_nb_articles' => 'Afficher le nombre d\'articles&nbsp;?',
	'label_afficher_nb_commentaires' => 'Afficher le nombre de commentaires&nbsp;?',
	'label_afficher_nb_participants' => 'Afficher le nombre de participants&nbsp;?',
	'label_afficher_nb_resultats' => 'Afficher le nombre de r&eacute;sultats&nbsp;?',
	'label_afficher_nom_auteur' => 'Afficher le nom de l\'auteur&nbsp;?',
	'label_afficher_nom_site' => 'Afficher le nom du site&nbsp;?',
	'label_afficher_note' => 'Afficher la note&nbsp;?',
	'label_afficher_popularite' => 'Afficher la popularit&eacute;&nbsp;?',
	'label_afficher_recherche' => 'Afficher le texte recherch&eacute;&nbsp;?',
	'label_afficher_resume_parent' => 'Afficher un r&eacute;sum&eacute; de l\'objet parent&nbsp;?',
	'label_afficher_rubrique' => 'Afficher la rubrique&nbsp;?',
	'label_afficher_secteur' => 'Afficher secteur&nbsp;?',
	'label_afficher_selecteur_archives' => 'Afficher un s&eacute;lecteur d\'archives par mois et/ou ann&eacute;e&nbsp;?',
	'label_afficher_si_pas_article' => 'Afficher le mini-plan seulement si la rubrique ne contient pas d\'articles&nbsp;?',
	'label_afficher_site_web' => 'Afficher le site web&nbsp;?',
	'label_afficher_slogan_site' => 'Afficher le slogan du site&nbsp;?',
	'label_afficher_source' => 'Afficher la source&nbsp;?',
	'label_afficher_soustitre' => 'Afficher le sous-titre&nbsp;?',
	'label_afficher_statistiques_mot' => 'Afficher les statistiques du mot-cl&eacute;&nbsp;?',
	'label_afficher_surtitre' => 'Afficher le sur-titre&nbsp;?',
	'label_afficher_tags' => 'Afficher les tags&nbsp;?',
	'label_afficher_taille' => 'Afficher la taille du document&nbsp;?',
	'label_afficher_telecharger' => 'Afficher un lien "T&eacute;l&eacute;charger"&nbsp;?',
	'label_afficher_texte_article' => 'Afficher le texte de l\'article&nbsp;?',
	'label_afficher_titre' => 'Afficher le titre&nbsp;?',
	'label_afficher_titre_article' => 'Afficher le titre de l\'article&nbsp;?',
	'label_afficher_titre_breve' => 'Afficher le titre de la br&egrave;ve&nbsp;?',
	'label_afficher_titre_evenement' => 'Afficher le titre de l\'&eacute;v&egrave;nement&nbsp;?',
	'label_afficher_titre_groupe' => 'Afficher le titre du groupe de mots&nbsp;?',
	'label_afficher_titre_liste' => 'Afficher un titre de liste&nbsp;?',
	'label_afficher_titre_message' => 'Afficher le titre du message&nbsp;?',
	'label_afficher_titre_mot' => 'Afficher le titre du mot-cl&eacute;&nbsp;?',
	'label_afficher_titre_noisette' => 'Afficher un titre de noisette&nbsp;?',
	'label_afficher_titre_rubrique' => 'Afficher le titre de la rubrique&nbsp;?',
	'label_afficher_titre_site' => 'Afficher le titre du site&nbsp;?',
	'label_afficher_traductions' => 'Afficher les traductions&nbsp;?',
	'label_afficher_tri_alphabetique_nom' => 'Tri alphab&eacute;tique sur le nom&nbsp;?',
	'label_afficher_tri_alphabetique_titre' => 'Tri alphab&eacute;tique sur le titre&nbsp;?',
	'label_afficher_type' => 'Afficher le type de document&nbsp;?',
	'label_afficher_url' => 'Afficher l\'URL&nbsp;?',
	'label_afficher_url_syndic' => 'Afficher le lien du fichier de syndication&nbsp;?',
	'label_afficher_visites' => 'Afficher le nombre de visites&nbsp;?',
	'label_ariane_separateur' => 'S&eacute;parateur&nbsp;:',
	'label_branche_specifique' => 'Si branche(s) sp&eacute;cifique(s), quelles branches&nbsp;?',
	'label_choix_tri' => 'Permettre au visiteur de modifier le tri&nbsp;?',
	'label_compteur_articles_selecteur_archives' => 'Afficher le nombre d\'articles&nbsp;?',
	'label_exclure_article_en_cours' => 'Exclure l\'article en cours de la liste&nbsp;?',
	'label_exclure_auteur_en_cours' => 'Exclure l\'auteur en cours de la liste&nbsp;?',
	'label_exclure_breve_en_cours' => 'Exclure la br&egrave;ve en cours de la liste&nbsp;?',
	'label_exclure_photos' => 'Exclure les photos du portfolio&nbsp;?',
	'label_exclure_site_en_cours' => 'Exclure le site en cours de la liste&nbsp;?',
	'label_formulaire_notation' => 'Si formulaire de notation, lequel&nbsp;?',
	'label_formulaire_reponse_volant' => 'Formulaire de r&eacute;ponse volant&nbsp;?',
	'label_groupes_specifiques' => 'Si certains groupes, lesquels &nbsp;?',
	'label_hauteur_logo' => 'Hauteur maximum du logo (facultatif)&nbsp;:',
	'label_hauteur_max_images' => 'Hauteur maximum des images&nbsp;:',
	'label_inclure_documents_vus' => 'Afficher les documents d&eacute;j&agrave; inclue dans la page&nbsp;?',
	'label_inclure_photos_vues' => 'Afficher les photos d&eacute;j&agrave; inclues dans la page&nbsp;?',
	'label_largeur_logo' => 'Largeur maximum du logo (facultatif)&nbsp;:',
	'label_lien_externe' => 'Le lien pointe directement sur l\'URL du site (lien externe)&nbsp;?',
	'label_lien_groupe' => 'Le lien pointe vers&nbsp;:',
	'label_lien_groupe_mots' => 'Si oui, ajouter un lien vers la page des groupes de mots&nbsp;?',
	'label_lien_page_auteurs' => 'Ajouter un lien vers la page \'auteurs\'&nbsp;?',
	'label_limite' => 'Si nombre limit&eacute;, nombre d\'objets &agrave; afficher&nbsp;:',
	'label_liste_articles' => 'Articles &agrave; lister&nbsp;:',
	'label_liste_breves' => 'Br&egrave;ves &agrave; lister &nbsp;:',
	'label_liste_mots' => 'Mots-Cl&eacute;s &agrave; lister&nbsp;:',
	'label_liste_sites' => 'Sites &agrave; lister&nbsp;:',
	'label_liste_syndic_articles' => 'Articles syndiqu&eacute;s &agrave; lister&nbsp;:',
	'label_longueur_max_introduction' => 'Si introduction, longueur maximum&nbsp;:',
	'label_longueur_max_texte' => 'Longueur maximum du texte&nbsp;:',
	'label_longueur_max_titres' => 'Longueur maximum des titres&nbsp;:',
	'label_message_aucun_resultat' => 'Afficher un message si la recherche ne produit aucun r&eacute;sultat&nbsp;?',
	'label_niveau_titre' => 'Niveau du titre&nbsp;:',
	'label_nombre_articles_syndiques_a_afficher' => 'Nombre d\'articles syndiqu&eacute;s &agrave; afficher&nbsp:',
	'label_pas_pagination' => 'Pas de la pagination&nbsp;:',
	'label_pas_selecteur_archives' => 'Pas du s&eacute;lecteur&nbsp;:',
	'label_position_choix_tri' => 'Position de la liste de choix&nbsp;:',
	'label_position_pagination' => 'Position de la pagination&nbsp;:',
	'label_position_selecteur_archives' => 'Position du s&eacute;lecteur&nbsp;:',
	'label_position_tri_alphabetique' => 'Position du tri alphab&eacute;tique&nbsp;:',
	'label_rappeler_nom' => 'Rappeler le nom de l\'auteur&nbsp;?',
	'label_rappeler_titre' => 'Rappeler le titre&nbsp;?',
	'label_restreindre_langue' => 'Restreindre &agrave; la langue en cours&nbsp;?',
	'label_rubrique_specifique' => 'Si rubrique(s) sp&eacute;cifique(s), quelles rubriques&nbsp;?',
	'label_secteur_specifique' => 'Si secteur(s) sp&eacute;cifique(s), quels secteurs&nbsp;?',
	'label_selection' => '&Eacute;l&eacute;ments &agrave; s&eacute;lectionner&nbsp;:',
	'label_senstri' => 'Sens du tri&nbsp;:',
	'label_separer_resultats_groupes' => 'S&eacute;parer les r&eacute;sultats par groupe&nbsp;?',
	'label_si_afficher_selecteur_archives' => 'Si affichage d\'un s&eacute;lecteur d\'archives',
	'label_si_choix_tri' => 'Si tri modifiable',
	'label_si_liste_simple' => 'Si affichage d\'une liste simple',
	'label_si_pagination' => 'Si utilisation d\'une pagination',
	'label_si_resume' => 'Si affichage de r&eacute;sum&eacute;s',
	'label_si_texte_complet' => 'Si affichage du texte complet',
	'label_si_tri_alphabetique' => 'Si tri alphab&eacute;tique',
	'label_si_vignettes' => 'Si affichage de vignettes',
	'label_style_liste' => 'Style de liste&nbsp;:',
	'label_style_pagination' => 'Style de la pagination&nbsp;:',
	'label_style_selecteur' => 'Style du s&eacute;lecteur&nbsp;:',
	'label_taille_max_images_texte' => 'Largeur maximale (en pixels) des images dans le texte&nbsp;:',
	'label_taille_max_logo' => 'Taille maximum du logo (en pixels)&nbsp;:',
	'label_texte_devant_mots_cles' => 'Si oui, texte devant les mots-cl&eacute;s&nbsp;:',
	'label_texte_devant_rubrique' => 'Si oui, texte devant la rubrique&nbsp;:',
	'label_texte_devant_selecteur_archives' => 'Texte devant le s&eacute;lecteur&nbsp;:',
	'label_thread' => 'Pr&eacute;sentation des fils de discussions&nbsp;:',
	'label_titre_liste' => 'Si affichage d\'un titre, lequel&nbsp;?',
	'label_titre_liste_perso' => 'Si titre personnalis&eacute;&nbsp;:',
	'label_titre_noisette' => 'Si affichage d\'un titre, lequel&nbsp;?',
	'label_titre_noisette_perso' => 'Si titre personnalis&eacute;&nbsp;:',
	'label_tri' => 'Crit&egrave;re de tri&nbsp;:',
	'label_utiliser_logo_article_rubrique' => 'Afficher le logo de la rubrique parente si l\'article n\'a pas de logo&nbsp;?',
	'label_utiliser_logo_breve_rubrique' => 'Afficher le logo de la rubrique parente si la br&egrave;ve n\'a pas de logo&nbsp;?',
	'label_utiliser_logo_evenement_article_rubrique' => 'Afficher le logo de l\'article parent si l\'&eacute;v&egrave;nement n\'a pas de logo&nbsp;?',
	'label_vignette_ajout_css' => 'Ajout en dur de CSS sp&eacute;cifiques&nbsp;?',
	
	// N
	'nom_article-contenuprincipal' => 'Contenu principal de l\'article',
	'nom_article-documents' => 'Documents de l\'article',
	'nom_article-filariane' => 'Fil d\'ariane de l\'article',
	'nom_article-formulaire_notation' => 'Formulaire de notation de l\'article',
	'nom_article-forum' => 'Forum de l\'article',
	'nom_article-lien_hypertexte' => 'Lien hypertexte de l\'article',
	'nom_article-mots_cles' => 'Mots-Cl&eacute;s de l\'article',
	'nom_article-portfolio' => 'Portfolio de l\'article',
	'nom_auteur-articles' => 'Articles de cet auteur',
	'nom_auteur-contenuprincipal' => 'Contenu principal de l\'auteur',
	'nom_auteur-filariane' => 'Fil d\'ariane de l\'auteur',
	'nom_auteur-formulaire_ecrire_auteur' => 'Formulaire d\'envoi de mail &agrave; l\'auteur',
	'nom_autres_groupes' => 'Autres groupes de mots-cl&eacute;s',
	'nom_breve-contenuprincipal' => 'Contenu principal de la br&egrave;ve',
	'nom_breve-filariane' => 'Fil d\'ariane de la br&egrave;ve',
	'nom_breve-forum' => 'Forum de la br&egrave;ve',
	'nom_breve-mots_cles' => 'Mots-Cl&eacute;s de la br&egrave;ve',
	'nom_evenement-contenuprincipal' => 'Contenu principal de l\'&eacute;v&egrave;nement',
	'nom_evenement-documents' => 'Documents de l\'&eacute;v&egrave;nement',
	'nom_evenement-filariane' => 'Fil d\'ariane de l\'&eacute;v&egrave;nement',
	'nom_evenement-forumaire_participer_evenement' => 'Formulaire d\'inscription &agrave; l\'&eacute;v&egrave;nement',
	'nom_evenement-mots_cles' => 'Mots-Cl&eacute;s de l\'&eacute;v&egrave;nement',
	'nom_evenement-portfolio' => 'Portfolio de l\'&eacute;v&egrave;nement',
	'nom_filariane' => 'Fil d\'ariane',
	'nom_formulaire_inscription' => 'Formulaire d\'inscription de nouveaux r&eacute;dacteurs',
	'nom_formulaire_recherche' => 'Formulaire de recherche',
	'nom_groupe_mots-contenuprincipal' => 'Contenu principal du groupe de mots',
	'nom_groupe_mots-filariane' => 'Fil d\'ariane du groupe de mots',
	'nom_groupe_mots-mots_cles' => 'Mots-cl&eacute;s du groupe',
	'nom_liste_articles' => 'Liste d\'articles',
	'nom_liste_auteurs' => 'Liste d\'auteurs',
	'nom_liste_breves' => 'Liste de br&egrave;ves',
	'nom_liste_documents' => 'Liste documents',
	'nom_liste_forums' => 'Liste de messages de forum',
	'nom_liste_mots_cles' => 'Liste de mots-cl&eacute;s',
	'nom_liste_portfolio' => 'Portfolio de toutes les images du site',
	'nom_liste_sites' => 'Liste de sites',
	'nom_liste_syndic_articles' => 'Liste d\'articles syndiqu&eacute;s',
	'nom_logositespip' => 'Logo du site SPIP',
	'nom_mot-articles' => 'Articles li&eacute;s au mot-cl&eacute;',
	'nom_mot-breves' => 'Br&egrave;ves li&eacute;es au mot-cl&eacute;',
	'nom_mot-contenuprincipal' => 'Contenu principal du mot-cl&eacute;',
	'nom_mot-filariane' => 'Fil d\'ariane du mot-cl&eacute;',
	'nom_mot-forums' => 'Messages de forum li&eacute;s au mot-cl&eacute;',
	'nom_mot-mots-meme-groupe' => 'Mots-cl&eacute;s dans le m&ecirc;me groupe de mots',
	'nom_mot-rubriques' => 'Rubriques li&eacute;es au mot-cl&eacute;',
	'nom_mot-sites' => 'Sites li&eacute;s au mot-cl&eacute;',
	'nom_navigation_rubriques' => 'Navigation par rubriques',
	'nom_navigation_secteurs_langue' => 'Navigation par rubriques du secteur de langue',
	'nom_page-forum-contenuprincipal' => 'Contenu principal de la page forum',
	'nom_page-login-formulaire_login' => 'Formulaire d\'identification',
	'nom_page-plan-contenuprincipal' => 'Contenu principal de la page plan',
	'nom_page-recherche-articles' => 'Articles trouv&eacute;s',
	'nom_page-recherche-auteurs' => 'Auteurs trouv&eacute;s',
	'nom_page-recherche-breves' => 'Br&egrave;ves trouv&eacute;es',
	'nom_page-recherche-contenuprincipal' => 'Contenu principal de la page recherche',
	'nom_page-recherche-documents' => 'Documents trouv&eacute;s',
	'nom_page-recherche-forums' => 'Messages de forum trouv&eacute;s',
	'nom_page-recherche-mots' => 'Mots-cl&eacute;s trouv&eacute;s',
	'nom_page-recherche-rubriques' => 'Rubriques trouv&eacute;es',
	'nom_page-recherche-sites' => 'Sites web trouv&eacute;s',
	'nom_page-sommaire-contenuprincipal' => 'Contenu principal de la page d\'accueil',
	'nom_petition' => 'P&eacute;tition',
	'nom_plan_simple' => 'Plan simple du site',
	'nom_plan_simple_secteur_langue' => 'Plan simple du secteur de langue',
	'nom_rubrique-contenuprincipal' => 'Contenu principal de la rubrique',
	'nom_rubrique-documents' => 'Documents de la rubrique',
	'nom_rubrique-filariane' => 'Fil d\'ariane de la rubrique',
	'nom_rubrique-formulaire_site' => 'Formulaire de proposition de site',
	'nom_rubrique-forum' => 'Forum de la rubrique',
	'nom_rubrique-miniplan' => 'Mini-plan de la rubrique',
	'nom_rubrique-mots_cles' => 'Mots-Cl&eacute;s de la rubrique',
	'nom_rubrique-portfolio' => 'Portfolio de la rubrique',
	'nom_rubrique-sous_rubriques' => 'Sous-Rubriques',
	'nom_rubriques_racine' => 'Rubriques &agrave; la racine du site',
	'nom_rubriques_secteur_langue' => 'Rubriques du secteur de langue',
	'nom_selecteur_archives' => 'S&eacute;lecteur d\'archives (pour les articles)',
	'nom_site-contenuprincipal' => 'Contenu principal du site',
	'nom_site-filariane' => 'Fil d\'ariane du site',
	'nom_site-forum' => 'Forum du site',
	'nom_site-mots_cles' => 'Mots-Cl&eacute;s du site',
	'nom_site-syndic_articles' => 'Articles syndiqu&eacute;s de ce site',
	'nom_titre_descriptif_site' => 'Titre et descriptif du site',
);

?>