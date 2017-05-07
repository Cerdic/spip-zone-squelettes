<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('base/abstract_sql');

// Fichier de langue du site, utilis&eacute; dans les squelettes

$test_lang_personnalisation=array(

	// A
	'acces_restreint' => 'Accès restreint', # NEW
	'accueil' => 'ទំព័រដើម',
	'agenda' => 'Agenda', # NEW
	'aide' => 'ជំនួយ',
	'article_complet' => 'Article complet', # NEW
	'article_precedent' => 'មុន',
	'article_precedent_premier' => 'អត្ថបទដំបូង',
	'article_suivant' => 'បន្ទាប់',
	'article_suivant_dernier' => 'អត្ថបទថ្មីបំផុត',
	'articles' => 'អត្ថបទ',
	'aucun_evenement' => 'Il n\'y a aucun évènement à venir pour ce mois dans l\'agenda', # NEW
	'aucun_resultat_pour' => 'គ្មានលទ្ធផល សំរាប់',

	// B
	'breves' => 'ដំណឹង',
	'breves_rubrique' => 'ដំណឹង សំរាប់ផ្នែកនេះ',

	// C
	'contact' => 'ទាក់ទង',
	'copyright_eva' => 'និង ប្រើប្រាស់គំរូខ្នាត',
	'copyright_spip' => 'សៃថ៍នេះ ត្រូវបានគ្រប់គ្រង ដោយ',

	// D
	'de_cet_auteur' => 'ដោយ អ្នកនិពន្ធនេះ',
	'deconnecter' => 'ពិនិត្យចេញ',
	'derniere_mise_a_jour' => 'ការបន្ទាន់សម័យ ថ្មីបំផុត',
	'dernieres_breves' => 'ដំណឹងថ្មីបំផុត',
	'derniers_articles' => 'អត្ថបទថ្មីបំផុត',
	'derniers_commentaires' => 'វិចារថ្មីបំផុត',
	'derniers_podcasts' => 'Derniers podcasts', # NEW
	'derniers_sites' => 'សៃថ៍ថ្មីបំផុត',
	'diaporama' => 'ការបង្ហាញរំកិលរូបភាព',
	'dix_meilleurs_articles' => 'ដប់អត្ថបទកំពូល',
	'dix_meilleurs_breves' => 'ដប់ដំណឹងកំពូល',
	'dix_meilleurs_commentaires' => 'ដប់វិចារកំពូល',
	'doc_redacteurs' => 'Documentation en ligne pour les rédacteurs pour EVA-Web', # NEW
	'document' => 'ឯកសារ',
	'documents_joints' => 'ឯកសារភ្ជាប់',

	// E
	'erreur_404' => 'កំហុស ៤០៤',
	'evenement_aucun' => 'Il n\'y a aucun évènement à venir dans cet agenda.', # NEW
	'evenements_a_venir' => 'ព្រឹត្តិការមកដល់',
	'evenements_du' => 'ព្រឹត្តិការ សំរាប់',
	'evenements_passes' => 'ព្រឹត្តិការកន្លង',
	'evenements_passes_aucun' => 'Il n\'y a aucun évènement passé dans cet agenda.', # NEW

	// F
	'fermer_fenetre' => 'បិទបង្អួច',
	'feuilleter_livre' => 'Feuilleter le livre', # NEW
	'form_pet_message_commentaire' => 'មួយវិចារ ឬ?',

	// G
	'galaxie_spip' => 'La galaxie SPIP', # NEW
	'go' => 'ទៅ',

	// I
	'icone_eva' => 'Icone EVA-web 4', # NEW
	'identifier' => 'អ្នកកំពុងលើបណ្តាញ',
	'il_y_a' => 'មាន',
	'il_y_a1' => 'ហត្ថលេខា សំរាប់បណ្តឹងនេះ',
	'il_y_a2' => 'មានសរុប',
	'il_y_a3' => 'article(s).<br /> Ce bloc en affiche', # NEW
	'il_y_a4' => 'auteur(s).<br /> Ce bloc en affiche', # NEW
	'il_y_a5' => 'brève(s).<br /> Ce bloc en affiche', # NEW
	'inscription' => 'Inscription', # NEW

	// J
	'j1' => 'ច.',
	'j2' => 'អ.',
	'j3' => 'ព.',
	'j4' => 'ព្រ.',
	'j5' => 'ស.',
	'j6' => 'សៅ.',
	'j7' => 'អាទិ.',
	'jo1' => 'ថ្ងៃ ចន្ទ',
	'jo2' => 'ថ្ងៃ អង្គារ',
	'jo3' => 'ថ្ងៃ ពុធ',
	'jo4' => 'ថ្ងៃ ព្រហស្ប៍',
	'jo5' => 'ថ្ងៃ សុក្រ',
	'jo6' => 'ថ្ងៃ សៅរ៍',
	'jo7' => 'ថ្ងៃ អាទិត្យ',

	// L
	'lancer_diaporama' => 'បើក ការបង្ហាញរំកិលរូបភាព',
	'lien_externe' => 'តំណភ្ជាប់ខាងក្រៅ, បើកជាបង្អួចថ្មី',
	'lire_suite' => 'អានបន្ត',

	// M
	'm1' => 'ខែ មករា',
	'm10' => 'ខែ តុលា',
	'm11' => 'ខែ វិច្ឆិកា',
	'm12' => 'ខែ ធ្នូ',
	'm2' => 'ខែ កុម្ភៈ',
	'm3' => 'ខែ មិនា',
	'm4' => 'ខែ មេសា',
	'm5' => 'ខែ ឧសភា',
	'm6' => 'ខែ មិថុនា',
	'm7' => 'ខែ កក្កដា',
	'm8' => 'ខែ សីហា',
	'm9' => 'ខែ កញ្ញា',
	'meme_rubrique' => 'ក្នុងផ្នែកនេះ',
	'mentions' => 'កំណត់ត្រា',
	'mentions_adresse' => 'Adresse :', # NEW
	'mentions_directeur_publication' => 'Directeur de la publication :', # NEW
	'mentions_droit_auteur_texte' => '<p>Ce site relève de la législation française et internationale sur le droit d\'auteur et la propriété intellectuelle.</p>
	<p>Tous les droits de reproduction sont réservés.</p>', # NEW
	'mentions_droit_auteur_titre' => 'Droits d\'auteurs :', # NEW
	'mentions_legales' => 'កំណត់ត្រាផ្លូវការ',
	'mentions_liens_hypertexte_texte' => '<p>Ce site contient des liens hypertextes permettant l\'accès à des sites qui ne sont pas édités par le responsable de ce site.</p>
	<p>En conséquence le directeur de publication ne saurait être tenu pour responsable du contenu des sites auxquels l\'internaute aurait ainsi accès.</p>
	<p>Il est formellement interdit de collecter et d\'utiliser les informations disponibles sur le site à des fins commerciales.</p>
	<p>Cette interdiction s\'étend notamment, sans que cette liste ne soit limitative, à tout élément rédactionnel figurant sur le site, à la présentation des écrans, aux logiciels nécessaires à l\'exploitation, aux logos, images, photos, graphiques, de quelque nature qu\'ils soient.</p>', # NEW
	'mentions_liens_hypertexte_titre' => 'Liens hypertextes :', # NEW
	'mentions_liens_texte' => '<p>A l\'exception de sites diffusant des informations et/ou contenus ayant un caractère illégal et/ou à caractère politique, religieux, pornographique, xénophobe, vous pouvez créer un lien hypertexte vers notre Site sur votre site.</p>
	<p>La mise en place de lien hypertexte n\'autorise en aucune façon la reproduction d\'éléments du Site ou la présentation sur des sites tiers d\'éléments du Site sous forme de Frame ou système apparenté.</p>
	<p>Enfin, la mise en place de lien hypertexte n\'autorise en aucune façon de proposer l\'envoi d\'un message pré-rédigé à une adresse mail liée au Site ou la mise en place d\'un système permettant l\'envoi massif de messages quelle qu\'en soit la nature.</p>
	<p>Tous les droits de reproduction sont réservés.</p>', # NEW
	'mentions_liens_titre' => 'Liens hypertextes vers ce site :', # NEW
	'mentions_logo_cddp74' => 'Site officiel du CDDP74', # NEW
	'mentions_logo_citic' => 'Centre de l\'Informatique et des TIC de Haute-Savoie (ex CRI74)', # NEW
	'mentions_logo_edres' => 'Éducation Réseau Haute-Savoie, projet départemental', # NEW
	'mentions_logo_eva' => 'Site officiel du projet eva-web', # NEW
	'mentions_logo_spip' => 'Site officiel de SPIP', # NEW
	'mentions_logo_spipedu' => 'Spip-edu, site de la communauté éducative', # NEW
	'mentions_lois' => 'En vertu de la loi pour la confiance dans l\'économie numérique (LCEN) du 21 juin 2004, voici les coordonnées de l\'éditeur et du prestataire qui accueille le site :', # NEW
	'mentions_prestataire' => 'Prestataire assurant le stockage direct et permanent :', # NEW
	'mentions_qualite' => 'Qualité :', # NEW
	'mentions_qui_texte' => '<p>A l\'origine <a href="http://eva-web.edres74.net/eva/">EVA</a>
	correspond à un projet de portail d\'Intranet d\'Établissement, installé sur 
	les serveurs <a href="http://www.pingoo.org/">PingOO</a>.</p>
	<p>Cette version, légèrement adaptée, permet à une école ou à un établissement de mettre 
	en place un site web collaboratif, en proposant différents modèles de publication 
	(article, album photo, diaporama ...) </p>
	<p>Pour plus de renseignements sur le projet <a href="http://eva-web.edres74.net">EVA-web</a>, consultez le site 
  	<a href="http://eva-web.edres74.net">http://eva-web.edres74.net</a></p>
	<p><a href="http://eva-web.edres74.net">EVA-web</a> est un logiciel libre distribué sous Licence Publique Générale 
	<a rel="licence" target="_blank" href="http://www.april.org/gnu/gpl_french.html">GNU (GNU General Public License ou GPL)</a>
	conçu pour fonctionner à partir de l\'application <a href="https://www.spip.net/">SPIP</a>.</p>
	<div style="text-align:center;"><a rel="licence" target="_blank" href="http://www.april.org/gnu/gpl_french.html"><img alt="Licence GNU GPL" style="border-width:0" width="80" height="100" src="http://www.fsf.org/graphics/philosophical-gnu-sm.jpg"/></a></div>', # NEW
	'mentions_qui_titre' => 'EVA, par qui, pour qui ?', # NEW
	'mentions_responsable_edition' => 'Responsable d\'édition :', # NEW
	'mentions_site' => 'Site Internet de : ', # NEW
	'mentions_webmestre' => 'Webmestre :', # NEW
	'meteo' => 'អាកាសធាតុ',
	'meteo_info' => 'ពត៌មានភូមិសាស្ត្រ',
	'meteo_previsions' => 'ព្យាករ ធាតុអាកាស',
	'mis_a_jour' => 'បានបន្ទាន់សម័យ៖',
	'mot_cle' => 'ពាក្យគន្លឹះ',
	'multilinguisme' => 'បង្ហាញ មែនញាវ នៃភាសា របស់ EVA-Web ក្នុងទំព័រសាធារណះ ឬ?',
	'multilinguisme_article' => 'អត្ថបទនេះ ក្នុង៖',

	// N
	'notes' => 'កំណត់ត្រា',

	// P
	'page_bas' => 'Bas de page', # NEW
	'page_haut' => 'Haut de page', # NEW
	'pages' => 'ទំព័រ',
	'par' => 'ដោយ៖',
	'partenaires' => 'ដៃគូ',
	'plan_du_site' => 'ផែនទីសៃថ៍',
	'podcasts' => 'Podcasts', # NEW
	'podcasts_rss' => 'Podcast et RSS', # NEW
	'post_scriptum' => 'Post-scriptum', # NEW
	'pour' => 'សំរាប់',
	'publie' => 'បានបោះផ្សាយ',

	// R
	'rechercher' => 'រកមើល',
	'redaction' => 'Rédaction', # NEW
	'replier' => 'បិទ',
	'resultats' => 'លទ្ធផល',

	// S
	'site' => 'site', # NEW
	'sites' => 'សៃថ៍ដទៃ៖',
	'sites_references' => 'សៃថ៍យោង',
	'sites_rubrique' => 'សៃថ៍ សំរាប់ផ្នែកនេះ',
	'sites_syndic' => 'Sites syndiqués de la rubrique', # NEW
	'sous_rubrique' => 'Sous-rubrique', # NEW
	'statut_admin' => 'ស្ថានភាព៖ អ្នកគ្រប់គ្រង',
	'statut_redac' => 'ស្ថានភាព៖ អ្នកសរសេរ',
	'statut_visit' => 'ស្ថានភាព៖ ទស្សនាករ',
	'sur_le_web' => 'លើអិនរើណែត',
	'sur_un_total_de' => 'ពីសរុប នៃ',
	'syndic_breves' => 'Syndiquer les brèves du site', # NEW
	'syndic_site' => 'Syndiquer tout le site', # NEW

	// T
	'texte_page_404' => '<em>Désolé !</em><br />La page que vous demandez n\'existe pas ou plus.', # NEW
	'tous_droits' => 'រក្សាគ្រប់សិទ្ធិ',
	'tous_les_auteurs' => 'គ្រប់អ្នកសរសេរ',

	// V
	'version_eva' => 'EVA-Web 4.2',
	'visites' => 'ចំណូលមើល',
	'voir_en_ligne' => 'មើល លើអិនរើណែត',
	'voir_image' => 'មើលរូបភាព ជាទំហំដើម',
	'vous_etes_ici' => 'អ្នកនៅទីនេះ',

	// Z
	'zone' => 'តំបន់បានការពារ'
);

$langue_fichier_initial=$test_lang_personnalisation;
$test=sql_showtable('spip_eva_habillage_images',true);
if ($test['field']) {
$surcharges = sql_allfetsel(array('nom_image AS texte', 'nom_div AS cle'),'spip_eva_habillage_images',  array(
		"type = 'fichier_lang'",
		"nom_habillage = 'Defaut'",
		"attach = 'km'",
		"nom_image != ''"));
	foreach ($surcharges as $s) {
		if (isset($test_lang_personnalisation[$s['cle']])) {
			$test_lang_personnalisation[$s['cle']] = $s['texte'];
		}
	}
}
$GLOBALS[$GLOBALS['idx_lang']] = $test_lang_personnalisation;
?>