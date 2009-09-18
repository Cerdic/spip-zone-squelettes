<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('base/abstract_sql');

// Fichier de langue du site, utilisé dans les squelettes

$test_lang_personnalisation=array(
	// A
	'acces_restreint' => 'Acc&egrave;s restreint',
	'accueil' => 'Accueil',
	'agenda' => 'Agenda',
	'aide' => 'Aide',
	'article_complet' => 'Article complet',
	'article_precedent' => 'Pr&eacute;c&eacute;dent',
	'article_precedent_premier' => 'Premier',
	'article_suivant' => 'Suivant',
	'article_suivant_dernier' => 'Dernier',
	'articles' => 'Articles',
	'aucun_evenement' => 'Il n\'y a aucun &eacute;v&egrave;nement &agrave; venir pour ce mois dans l\'agenda',
	'aucun_resultat_pour' => 'Aucun r&eacute;sultat pour',

	// B
	'breves' => 'Br&egrave;ves',
	'breves_rubrique' => 'Br&egrave;ves de la rubrique',

	// C
	'contact' => 'Contact',
	'copyright_eva' => 'et utilise le squelette ',
	'copyright_spip' => 'Ce site est g&eacute;r&eacute; sous',

	// D
	'de_cet_auteur' => 'de cet auteur',
	'deconnecter' => 'Se d&eacute;connecter',
	'derniere_mise_a_jour' => 'Derni&egrave;re mise &agrave; jour',
	'dernieres_breves' => 'Derni&egrave;res br&egrave;ves',
	'derniers_articles' => 'Derniers articles',
	'derniers_commentaires' => 'Derniers commentaires',
	'derniers_podcasts' => 'Derniers podcasts',
	'derniers_sites' => 'Derniers sites',
	'diaporama' => 'Diaporama',
	'dix_meilleurs_articles' => 'Dix meilleurs articles',
	'dix_meilleurs_breves' => 'Dix meilleures br&egrave;ves',
	'dix_meilleurs_commentaires' => 'Dix meilleurs commentaires',
	'doc_redacteurs' => 'Documentation en ligne pour les r&eacute;dacteurs pour EVA-Web',
	'document' => 'Document',
	'documents_joints' => 'Documents joints',

	// E
	'erreur_404' => 'Erreur 404',
	'evenement_aucun' => 'Il n\'y a aucun &eacute;v&egrave;nement &agrave; venir dans cet agenda.',
	'evenements_a_venir' => 'Ev&egrave;nements &agrave; venir',
	'evenements_du' => 'Les &eacute;v&egrave;nements du',
	'evenements_passes' => 'Ev&egrave;nements pass&eacute;s',
	'evenements_passes_aucun' => 'Il n\'y a aucun &eacute;v&egrave;nement pass&eacute; dans cet agenda.',

	// F
	'fermer_fenetre' => 'Fermer la fen&ecirc;tre',
	'feuilleter_livre' => 'Feuilleter le livre',
	'form_pet_message_commentaire' => 'Un commentaire&nbsp;?',

	// G
	'galaxie_spip' => 'La galaxie SPIP',
	'go' => 'go',

	// I
	'icone_eva' => 'Icone EVA-web 4',
	'identifier' => 'Vous &ecirc;tes authentifi&eacute;',
	'inscription' => 'Inscription',
	'il_y_a' => 'Il y a',
	'il_y_a1' => 'signature(s) &agrave; cette p&eacute;tition.',
	'il_y_a2' => 'Il y a au total',
	'il_y_a3' => 'article(s).<br /> Ce bloc en affiche',
	'il_y_a4' => 'auteur(s).<br /> Ce bloc en affiche',
	'il_y_a5' => 'br&egrave;ve(s).<br /> Ce bloc en affiche',

	// J
	'j1' => 'lu',
	'j2' => 'ma',
	'j3' => 'me',
	'j4' => 'je',
	'j5' => 've',
	'j6' => 'sa',
	'j7' => 'di',
	'jo1' => 'Lundi',
	'jo2' => 'Mardi',
	'jo3' => 'Mercredi',
	'jo4' => 'Jeudi',
	'jo5' => 'Vendredi',
	'jo6' => 'Samedi',
	'jo7' => 'Dimanche',

	// L
	'lancer_diaporama' => 'Lancer le Diaporama',
	'lien_externe' => 'Lien externe au site, s\'ouvre dans une nouvelle fen&ecirc;tre',
	'lire_suite' => 'Lire la suite',

	// M
	'm1' => 'janvier',
	'm10' => 'octobre',
	'm11' => 'novembre',
	'm12' => 'd&eacute;cembre',
	'm2' => 'f&eacute;vrier',
	'm3' => 'mars',
	'm4' => 'avril',
	'm5' => 'mai',
	'm6' => 'juin',
	'm7' => 'juillet',
	'm8' => 'ao&ucirc;t',
	'm9' => 'septembre',
	'meme_rubrique' => 'Dans cette rubrique',
	'mentions' => 'Mentions',
	'mentions_adresse' => 'Adresse :',
	'mentions_directeur_publication' => 'Directeur de la publication :',
	'mentions_droit_auteur_texte' => '<p>Ce site rel&egrave;ve de la l&eacute;gislation fran&ccedil;aise et internationale sur le droit d\'auteur et la propri&eacute;t&eacute; intellectuelle.</p>
	<p>Tous les droits de reproduction sont r&eacute;serv&eacute;s.</p>',
	'mentions_droit_auteur_titre' => 'Droits d\'auteurs :',
	'mentions_legales' => 'Mentions l&eacute;gales',
	'mentions_liens_hypertexte_texte' => '<p>Ce site contient des liens hypertextes permettant l\'acc&egrave;s &agrave; des sites qui ne sont pas &eacute;dit&eacute;s par le responsable de ce site.</p>
	<p>En cons&eacute;quence le directeur de publication ne saurait &ecirc;tre tenu pour responsable du contenu des sites auxquels l\'internaute aurait ainsi acc&egrave;s.</p>
	<p>Il est formellement interdit de collecter et d\'utiliser les informations disponibles sur le site &agrave; des fins commerciales.</p>
	<p>Cette interdiction s\'&eacute;tend notamment, sans que cette liste ne soit limitative, &agrave; tout &eacute;l&eacute;ment r&eacute;dactionnel figurant sur le site, &agrave; la pr&eacute;sentation des &eacute;crans, aux logiciels n&eacute;cessaires &agrave; l\'exploitation, aux logos, images, photos, graphiques, de quelque nature qu\'ils soient.</p>',
	'mentions_liens_hypertexte_titre' => 'Liens hypertextes :',
	'mentions_liens_texte' => '<p>A l\'exception de sites diffusant des informations et/ou contenus ayant un caract&egrave;re ill&eacute;gal et/ou &agrave; caract&egrave;re politique, religieux, pornographique, x&eacute;nophobe, vous pouvez cr&eacute;er un lien hypertexte vers notre Site sur votre site.</p>
	<p>La mise en place de lien hypertexte n\'autorise en aucune fa&ccedil;on la reproduction d\'&eacute;l&eacute;ments du Site ou la pr&eacute;sentation sur des sites tiers d\'&eacute;l&eacute;ments du Site sous forme de Frame ou syst&egrave;me apparent&eacute;.</p>
	<p>Enfin, la mise en place de lien hypertexte n\'autorise en aucune fa&ccedil;on de proposer l\'envoi d\'un message pr&eacute;-r&eacute;dig&eacute; &agrave; une adresse mail li&eacute;e au Site ou la mise en place d\'un syst&egrave;me permettant l\'envoi massif de messages quelle qu\'en soit la nature.</p>
	<p>Tous les droits de reproduction sont r&eacute;serv&eacute;s.</p>',
	'mentions_liens_titre' => 'Liens hypertextes vers ce site :',
	'mentions_logo_cddp74' => 'Site officiel du CDDP74',
	'mentions_logo_citic' => 'Centre de l\'Informatique et des TIC de Haute-Savoie (ex CRI74)',
	'mentions_logo_edres' => '&Eacute;ducation R&eacute;seau Haute-Savoie, projet d&eacute;partemental',
	'mentions_logo_eva' => 'Site officiel du projet eva-web',
	'mentions_logo_spip' => 'Site officiel de SPIP',
	'mentions_logo_spipedu' => 'Spip-edu, site de la communaut&eacute; &eacute;ducative',
	'mentions_lois' => 'En vertu de la loi pour la confiance dans l\'&eacute;conomie num&eacute;rique (LCEN) du 21 juin 2004, voici les coordonn&eacute;es de l\'&eacute;diteur et du prestataire qui accueille le site :',
	'mentions_prestataire' => 'Prestataire assurant le stockage direct et permanent :',
	'mentions_qualite' => 'Qualit&eacute; :',
	'mentions_qui_texte' => '<p>A l\'origine <a href="http://eva-web.edres74.net/eva/">EVA</a>
	correspond &agrave; un projet de portail d\'Intranet d\'&Eacute;tablissement, install&eacute; sur 
	les serveurs <a href="http://www.pingoo.org/">PingOO</a>.</p>
	<p>Cette version, l&eacute;g&egrave;rement adapt&eacute;e, permet &agrave; une &eacute;cole ou &agrave; un &eacute;tablissement de mettre 
	en place un site web collaboratif, en proposant diff&eacute;rents mod&egrave;les de publication 
	(article, album photo, diaporama ...) </p>
	<p>Pour plus de renseignements sur le projet <a href="http://eva-web.edres74.net">EVA-web</a>, consultez le site 
  	<a href="http://eva-web.edres74.net">http://eva-web.edres74.net</a></p>
	<p><a href="http://eva-web.edres74.net">EVA-web</a> est un logiciel libre distribu&eacute; sous Licence Publique G&eacute;n&eacute;rale 
	<a rel="licence" target="_blank" href="http://www.april.org/gnu/gpl_french.html">GNU (GNU General Public License ou GPL)</a>
	con&ccedil;u pour fonctionner &agrave; partir de l\'application <a href="http://www.spip.net/">SPIP</a>.</p>
	<div style="text-align:center;"><a rel="licence" target="_blank" href="http://www.april.org/gnu/gpl_french.html"><img alt="Licence GNU GPL" style="border-width:0" width="80" height="100" src="http://www.fsf.org/graphics/philosophical-gnu-sm.jpg"/></a></div>',
	'mentions_qui_titre' => 'EVA, par qui, pour qui ?',
	'mentions_responsable_edition' => 'Responsable d\'&eacute;dition :',
	'mentions_site' => 'Site Internet de : ',
	'mentions_webmestre' => 'Webmestre :',
	'meteo' => 'M&eacute;t&eacute;o',
	'meteo_info' => 'Informations g&eacute;ographiques',
	'meteo_previsions' => 'Pr&eacute;visions m&eacute;t&eacute;o',
	'mis_a_jour' => 'Modifi&eacute; :',
	'mot_cle' => 'Mots-cl&eacute;',
	'multilinguisme' => 'Afficher le menu de langue d\'EVA-web dans les pages publiques ?',
	'multilinguisme_article' => 'Cet article en :',

	// N
	'notes' => 'Notes',

	// P
	'pages' => 'Pages',
	'page_bas' => 'Bas de page',
	'page_haut' => 'Haut de page',
	'par' => 'Par :',
	'partenaires' => 'Partenaires',
	'plan_du_site' => 'Plan',
	'podcasts' => 'Podcasts',
	'podcasts_rss' => 'Podcast et RSS',
	'post_scriptum' => 'Post-scriptum',
	'pour' => 'pour',
	'publie' => 'Publi&eacute; :',

	// R
	'rechercher' => 'Rechercher',
	'redaction' => 'R&eacute;daction',
	'replier' => 'Replier',
	'resultats' => 'R&eacute;sultats',

	// S
	'site' => 'site',
	'sites' => 'Autres sites :',
	'sites_references' => 'Sites r&eacute;f&eacute;renc&eacute;s',
	'sites_rubrique' => 'Sites de la rubrique',
	'sites_syndic' => 'Sites syndiqu&eacute;s de la rubrique',
	'sous_rubrique' => 'Sous-rubrique',
	'statut_admin' => 'Statut : Administrateur<br />',
	'statut_redac' => 'Statut : R&eacute;dacteur',
	'statut_visit' => 'Statut : Visiteur',
	'sur_le_web' => 'Sur le web',
	'sur_un_total_de' => 'sur un total de',
	'syndic_site' => 'Syndiquer tout le site',
	'syndic_breves' => 'Syndiquer les br&egrave;ves du site',

	// T
	'texte_page_404' => '<em>D&eacute;sol&eacute; !</em><br />La page que vous demandez n\'existe pas ou plus.',
	'tous_droits' => 'Tous droits r&eacute;serv&eacute;s',
	'tous_les_auteurs' => 'Tous les auteurs',

	// V
	'version_eva' => 'EVA-Web 4.1',
	'visites' => 'Visites',
	'voir_en_ligne' => 'Voir en ligne :',
	'voir_image' => 'Voir l\'image en grand',
	'vous_etes_ici' => 'Vous &ecirc;tes ici :',

	// Z
	'zone' => 'zone prot&eacute;g&eacute;e'
);

$langue_fichier_initial=$test_lang_personnalisation;
include_spip('base/trouver_table');
if (base_trouver_table_dist(spip_eva_habillage_images)) {
$surcharges = sql_allfetsel(array('nom_image AS texte', 'nom_div AS cle'),'spip_eva_habillage_images',  array(
        "type = 'fichier_lang'",
        "nom_habillage = 'Defaut'",
	"attach = 'fr'",
        "nom_image != ''"));
foreach ($surcharges as $s) {
        if (isset($test_lang_personnalisation[$s['cle']])) {
                $test_lang_personnalisation[$s['cle']] = $s['texte'];
        }
}
}
$GLOBALS[$GLOBALS['idx_lang']] = $test_lang_personnalisation;
?>