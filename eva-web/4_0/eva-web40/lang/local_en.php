<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('base/abstract_sql');

// Fichier de langue du site, utilis‚àö¬© dans les squelettes

$test_lang_personnalisation=array(
// A
	'acces_restreint' => 'Restricted access',
	'accueil' => 'Home page',
	'agenda' => 'Diary',
	'aide' => 'Help',
	'article_complet' => 'Complete articles',
	'article_precedent' => 'Previous',
	'article_precedent_premier' => 'First article',
	'article_suivant' => 'Next',
	'article_suivant_dernier' => 'Lastest article',
	'articles' => 'Articles',
	'aucun_evenement' => 'No comming event invisaged this month in the diary',
	'aucun_resultat_pour' => 'No results for',

	// B
	'breves' => 'News',
	'breves_rubrique' => 'News for this section',

	// C
	'contact' => 'Contact',
	'copyright_eva' => 'and use template',
	'copyright_spip' => 'This site is managed by',

	// D
	'de_cet_auteur' => 'By this author',
	'deconnecter' => 'Logout',
	'derniere_mise_a_jour' => 'Latest updates',
	'dernieres_breves' => 'Latest news',
	'derniers_articles' => 'Latest articles',
	'derniers_commentaires' => 'Latest comments',
	'derniers_podcasts' => 'Latest podcasts',
	'derniers_sites' => 'Latest sites',
	'diaporama' => 'Slide show',
	'dix_meilleurs_articles' => 'Top ten articles',
	'dix_meilleurs_breves' => 'Top ten News',
	'dix_meilleurs_commentaires' => 'Top ten comments',
	'doc_redacteurs' => 'On line documents for writers using EVA_Red',
	'document' => 'Document',
	'documents_joints' => 'Attachments',

	// E
	'erreur_404' => 'Error 404',
	'evenement_aucun' => 'No comming event invisaged this month in the diary',
	'evenements_a_venir' => 'Events to come',
	'evenements_du' => 'Events for',
	'evenements_passes' => 'Past events',
	'evenements_passes_aucun' => 'No past event in the diary',

	// F
	'fermer_fenetre' => 'Close the window',
	'feuilleter_livre' => 'Leaf through the book',
	'form_pet_message_commentaire' => 'One comment?',

	// G
	'galaxie_spip' => 'The SPIP galaxy',
	'go' => 'Go',

	// I
	'identifier' => 'You are connected',
	'il_y_a' => 'There is',
	'il_y_a1' => 'Signature(s) for this petition',
	'il_y_a2' => 'There is in total',
	'il_y_a3' => 'Article(s).</br> This block in poster',
	'il_y_a4' => 'Author(s).</br> This block in poster',
	'il_y_a5' => 'News.</br>This block in poster',

	// J
	'j1' => 'Mon',
	'j2' => 'Tue',
	'j3' => 'Wen',
	'j4' => 'Thur',
	'j5' => 'Fri',
	'j6' => 'Sat',
	'j7' => 'Sun',
	'jo1' => 'Monday',
	'jo2' => 'Tuesday',
	'jo3' => 'Wednesday',
	'jo4' => 'Thursday',
	'jo5' => 'Friday',
	'jo6' => 'Saturday',
	'jo7' => 'Sunday',

	// L
	'lancer_diaporama' => 'Open Slide show',
	'lien_externe' => 'External link, open in new window',
	'lire_suite' => 'Read more',

	// M
	'm1' => 'January',
	'm10' => 'October',
	'm11' => 'November',
	'm12' => 'December',
	'm2' => 'February',
	'm3' => 'March',
	'm4' => 'April',
	'm5' => 'May',
	'm6' => 'June',
	'm7' => 'July',
	'm8' => 'August',
	'm9' => 'September',
	'meme_rubrique' => 'In this section',
	'mentions' => 'Mentions',
	'mentions_legales' => 'Legal mentions',
	'mis_a_jour' => 'Updating : ',
	'mot_cle' => 'Key words',
	'multilinguisme' => 'Display the menu of language of EVA-Web in the public pages?',
	'multilinguisme_article' => 'This article in :',

	// N
	'notes' => 'Notes',

	// P
	'pages' => 'Pages',
	'par' => 'by :',
	'partenaires' => 'Partners',
	'plan_du_site' => 'Site map',
	'podcasts' => 'Podcasts',
	'podcasts_rss' => 'Podcasts and RSS',
	'post_scriptum' => 'Post-scriptum',
	'pour' => 'for',
	'publie' => 'Published',

	// R
	'rechercher' => 'Find',
	'redaction' => 'Redaction',
	'replier' => 'Close',
	'resultats' => 'Results',

	// S
	'sites' => 'Other Sites :',
	'sites_references' => 'Reference Sites',
	'sites_rubrique' => 'Sites for this section',
	'sites_syndic' => 'Syndicated sites',
	'sous_rubrique' => 'Subsection',
	'statut_admin' => 'Status : Manager',
	'statut_redac' => 'Status : Writer',
	'statut_visit' => 'Status : Visitor',
	'sur_le_web' => 'On the Web',
	'sur_un_total_de' => 'From total of',

	// T
	'texte_page_404' => '<em>Sorry !</em></br>This page seems to have been removed from this site',
	'tous_droits' => 'All rights reserved',
	'tous_les_auteurs' => 'All writers',

	// V
	'version_eva' => 'EVA-Web 4.0 stable',
	'visites' => 'Visits',
	'voir_en_ligne' => 'See on the web',
	'voir_image' => 'See the picture with original size',
	'vous_etes_ici' => 'You are here',

	// Z
	'zone' => 'Protected zone'
);

$langue_fichier_initial=$test_lang_personnalisation;
$surcharges = sql_allfetsel(array('nom_image AS texte', 'nom_div AS cle'),'spip_eva_habillage_images',  array(
        "type = 'fichier_lang'",
        "nom_habillage = 'Defaut'",
	"attach = 'en'",
        "nom_image != ''"));
foreach ($surcharges as $s) {
        if (isset($test_lang_personnalisation[$s['cle']])) {
                $test_lang_personnalisation[$s['cle']] = $s['texte'];
        }
}
$GLOBALS[$GLOBALS['idx_lang']] = $test_lang_personnalisation;
?>