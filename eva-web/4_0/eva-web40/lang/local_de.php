<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('base/abstract_sql');

// Fichier de langue du site, utilis&eacute;‚dans les squelettes

$test_lang_personnalisation=array(
// A
	'acces_restreint' => 'eingeschr&auml;nkte Zone',
	'accueil' => 'Homepage',
	'agenda' => 'Kalender',
	'aide' => 'Hilfe',
	'article_complet' => 'Schlie&szlig;en Sie Artikel ab',
	'article_precedent' => 'vorhergehend artikel',
	'article_precedent_premier' => 'erster Artikel',
	'article_suivant' => 'nach',
	'article_suivant_dernier' => 'letzter Artikel',
	'articles' => 'Artikel',
	'aucun_evenement' => 'er nicht dort dieser Monat im Kalender vorgesehene Ereigni&szlig;e',
	'aucun_resultat_pour' => 'nicht Ergebni&szlig;e f&uuml;r Pr&auml;zedenzfall',

	// B
	'breves' => 'Nachrichten',
	'breves_rubrique' => 'Nachrichten f&uuml;r dieses Kapitel',

	// C
	'contact' => 'Kontakt',
	'copyright_eva' => 'und Gebrauch&szlig;chablone',
	'copyright_spip' => 'Diese Site wird vorbei gehandhabt',

	// D
	'de_cet_auteur' => 'von diesem Autor',
	'deconnecter' => 'Logout',
	'derniere_mise_a_jour' => 'Sp&auml;teste Updates',
	'dernieres_breves' => 'sp&auml;teste Nachrichten',
	'derniers_articles' => 'sp&auml;teste Artikel',
	'derniers_commentaires' => 'sp&auml;teste Kommentare',
	'derniers_podcasts' => 'die sp&auml;testen poscasts',
	'derniers_sites' => 'Sp&auml;teste Sites',
	'diaporama' => 'Diavorf&uuml;hrung',
	'dix_meilleurs_articles' => 'Artikel der Spitze zehn',
	'dix_meilleurs_breves' => 'Nachrichten der Spitzen-zehn',
	'dix_meilleurs_commentaires' => 'Kommentare der Spitze zehn',
	'doc_redacteurs' => 'Auf Zeile Dokumente f&uuml;r die Verfa&szlig;er, die EVA_Red verwenden',
	'document' => 'Dokument',
	'documents_joints' => 'Auh&auml;nge',

	// E
	'erreur_404' => 'Fehler 404',
	'evenement_aucun' => 'Es gibt kein invisaged Ereignis dieser Monat im Tagebuch',
	'evenements_a_venir' => 'Ereigni&szlig;e zum zu kommen',
	'evenements_du' => 'Ereigni&szlig;e f&uuml;r',
	'evenements_passes' => 'Letzte Ereigni&szlig;e',
	'evenements_passes_aucun' => 'Es gibt nein Vergangenheitsereigni&szlig;e im Tagebuch',

	// F
	'fermer_fenetre' => 'Schlie&szlig;en Sie das Fenster',
	'feuilleter_livre' => 'Blatt durch das Buch',
	'form_pet_message_commentaire' => 'einen Kommentar? ',

	// G
	'galaxie_spip' => 'Die SPIP Galaxie',
	'go' => 'Gehen Sie',

	// I
	'icone_eva' => '<NEW>Icone EVA-web 4',
	'identifier' => 'Sie werden angeschlo&szlig;en',
	'il_y_a' => 'Es gibt',
	'il_y_a1' => 'Kennzeichnen Sie herein diese Petition',
	'il_y_a2' => 'dort ist in der Summe',
	'il_y_a3' => 'Artikel </br> dieser Block im poster',
	'il_y_a4' => 'Autor </br> dieser Block im poster',
	'il_y_a5' => 'Nachrichten </br> dieser Block im poster',
	'inscription' => '<NEW>Inscription',

	// J
	'j1' => 'mon',
	'j2' => 'die',
	'j3' => 'mit',
	'j4' => 'don',
	'j5' => 'fre',
	'j6' => 'sam',
	'j7' => 'son',
	'jo1' => 'Montag',
	'jo2' => 'Dienstag',
	'jo3' => 'Mittwoch',
	'jo4' => 'Donnerstag',
	'jo5' => 'Freitag',
	'jo6' => 'Samstag',
	'jo7' => 'Sonntag',

	// L
	'lancer_diaporama' => '&ouml;ffnen Sie Diavorf&uuml;hrung',
	'lien_externe' => 'Externes Link, &ouml;ffnen sich im neuen Fenster',
	'lire_suite' => 'Lesen Sie mehr',

	// M
	'm1' => 'Januar',
	'm10' => 'Oktober',
	'm11' => 'November',
	'm12' => 'Dezember',
	'm2' => 'Februar',
	'm3' => 'M&auml;rz',
	'm4' => 'April',
	'm5' => 'Mai',
	'm6' => 'Juni',
	'm7' => 'Juli',
	'm8' => 'August',
	'm9' => 'September',
	'meme_rubrique' => 'In diesem Kapitel',
	'mentions' => 'Erw&auml;hnungen',
	'mentions_adresse' => '<NEW>Adresse :',
	'mentions_directeur_publication' => '<NEW>Directeur de la publication :',
	'mentions_droit_auteur_texte' => '<NEW><p>Ce site rel&egrave;ve de la l&eacute;gislation fran&ccedil;aise et internationale sur le droit d\'auteur et la propri&eacute;t&eacute; intellectuelle.</p>
	<p>Tous les droits de reproduction sont r&eacute;serv&eacute;s.</p>',
	'mentions_droit_auteur_titre' => '<NEW>Droits d\'auteurs :',
	'mentions_legales' => 'Legale Erw&auml;hnungen',
	'mentions_liens_hypertexte_texte' => '<NEW><p>Ce site contient des liens hypertextes permettant l\'acc&egrave;s &agrave; des sites qui ne sont pas &eacute;dit&eacute;s par le responsable de ce site.</p>
	<p>En cons&eacute;quence le directeur de publication ne saurait &ecirc;tre tenu pour responsable du contenu des sites auxquels l\'internaute aurait ainsi acc&egrave;s.</p>
	<p>Il est formellement interdit de collecter et d\'utiliser les informations disponibles sur le site &agrave; des fins commerciales.</p>
	<p>Cette interdiction s\'&eacute;tend notamment, sans que cette liste ne soit limitative, &agrave; tout &eacute;l&eacute;ment r&eacute;dactionnel figurant sur le site, &agrave; la pr&eacute;sentation des &eacute;crans, aux logiciels n&eacute;cessaires &agrave; l\'exploitation, aux logos, images, photos, graphiques, de quelque nature qu\'ils soient.</p>',
	'mentions_liens_hypertexte_titre' => '<NEW>Liens hypertextes :',
	'mentions_liens_texte' => '<NEW><p>A l\'exception de sites diffusant des informations et/ou contenus ayant un caract&egrave;re ill&eacute;gal et/ou &agrave; caract&egrave;re politique, religieux, pornographique, x&eacute;nophobe, vous pouvez cr&eacute;er un lien hypertexte vers notre Site sur votre site.</p>
	<p>La mise en place de lien hypertexte n\'autorise en aucune fa&ccedil;on la reproduction d\'&eacute;l&eacute;ments du Site ou la pr&eacute;sentation sur des sites tiers d\'&eacute;l&eacute;ments du Site sous forme de Frame ou syst&egrave;me apparent&eacute;.</p>
	<p>Enfin, la mise en place de lien hypertexte n\'autorise en aucune fa&ccedil;on de proposer l\'envoi d\'un message pr&eacute;-r&eacute;dig&eacute; &agrave; une adresse mail li&eacute;e au Site ou la mise en place d\'un syst&egrave;me permettant l\'envoi massif de messages quelle qu\'en soit la nature.</p>
	<p>Tous les droits de reproduction sont r&eacute;serv&eacute;s.</p>',
	'mentions_liens_titre' => '<NEW>Liens hypertextes vers ce site :',
	'mentions_logo_cddp74' => '<NEW>Site officiel du CDDP74',
	'mentions_logo_citic' => '<NEW>Centre de l\'Informatique et des TIC de Haute-Savoie (ex CRI74)',
	'mentions_logo_edres' => '<NEW>&Eacute;ducation R&eacute;seau Haute-Savoie, projet d&eacute;partemental',
	'mentions_logo_eva' => '<NEW>Site officiel du projet eva-web',
	'mentions_logo_spip' => '<NEW>Site officiel de SPIP',
	'mentions_logo_spipedu' => '<NEW>Spip-edu, site de la communaut&eacute; &eacute;ducative',
	'mentions_lois' => '<NEW>En vertu de la loi pour la confiance dans l\'&eacute;conomie num&eacute;rique (LCEN) du 21 juin 2004, voici les coordonn&eacute;es de l\'&eacute;diteur et du prestataire qui accueille le site :',
	'mentions_prestataire' => '<NEW>Prestataire assurant le stockage direct et permanent :',
	'mentions_qualite' => '<NEW>Qualit&eacute; :',
	'mentions_qui_texte' => '<NEW><p>A l\'origine <a href="http://eva-web.edres74.net/eva/">EVA</a>
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
	'mentions_qui_titre' => '<NEW>EVA, par qui, pour qui ?',
	'mentions_responsable_edition' => '<NEW>Responsable d\'&eacute;dition :',
	'mentions_site' => '<NEW>Site Internet de : ',
	'mentions_webmestre' => '<NEW>Webmestre :',
	'meteo' => '<NEW>M&eacute;t&eacute;o',
	'meteo_info' => '<NEW>Informations g&eacute;ographiques',
	'meteo_previsions' => '<NEW>Pr&eacute;visions m&eacute;t&eacute;o',
	'mis_a_jour' => 'Aktualisierend : ',
	'mot_cle' => 'Schl&uuml;&szlig;elw&ouml;rter',
	'multilinguisme' => 'Das SprachMen&uuml; von Eva-Netz in den &ouml;ffentlichen Seiten anschlagen?',
	'multilinguisme_article' => 'Dieser Artikel in :',

	// N
	'notes' => 'Anmerkungen',

	// P
	'page_bas' => '<NEW>Bas de page',
	'page_haut' => '<NEW>Haut de page',
	'pages' => 'Seiten',
	'par' => 'vorbei :',
	'partenaires' => 'Partners',
	'plan_du_site' => 'Site-Karte',
	'podcasts' => 'Podcasts',
	'podcasts_rss' => 'Podcasts und RSS',
	'post_scriptum' => 'Posten-scriptum',
	'pour' => 'f&uuml;r',
	'publie' => 'Ver&ouml;ffentlicht',

	// R
	'rechercher' => 'Entdeckung',
	'redaction' => 'Redaction',
	'replier' => 'nah',
	'resultats' => 'Resultiert',

	// S
	'site' => '<NEW>site',
	'sites' => 'Andere Sites :',
	'sites_references' => 'Bezug&szlig;ites',
	'sites_rubrique' => 'Sites f&uuml;r dieses Kapitel',
	'sites_syndic' => 'organisierten Sites gewerkschaftlich',
	'sous_rubrique' => 'Unterabschnitt',
	'statut_admin' => 'Status : Manager',
	'statut_redac' => 'Status : Verfa&szlig;er',
	'statut_visit' => 'Status : Besucher',
	'sur_le_web' => 'Auf dem Web',
	'sur_un_total_de' => 'Von der Summe von',
	'syndic_breves' => '<NEW>Syndiquer les br&egrave;ves du site',
	'syndic_site' => '<NEW>Syndiquer tout le site',

	// T
	'texte_page_404' => '<em>Traurig!</em></br>Diese Seite existiert nicht.',
	'tous_droits' => 'Alle Rechte vorbehalten',
	'tous_les_auteurs' => 'Alle Verfa&szlig;er',

	// V
	'version_eva' => 'EVA-Web 4.1',
	'visites' => 'Besuche',
	'voir_en_ligne' => 'Sehen Sie auf dem Web',
	'voir_image' => 'Sehen Sie, da&szlig; die Abbildung mit urspr&uuml;nglicher Gr&ouml;&szlig;e',
	'vous_etes_ici' => 'Sie sind hier',

	// Z
	'zone' => 'Gesch&uuml;tzte Zone'
);

$langue_fichier_initial=$test_lang_personnalisation;
$test=sql_showtable('spip_eva_habillage_images',true);
if ($test['field']) {
$surcharges = sql_allfetsel(array('nom_image AS texte', 'nom_div AS cle'),'spip_eva_habillage_images',  array(
        "type = 'fichier_lang'",
        "nom_habillage = 'Defaut'",
	"attach = 'de'",
        "nom_image != ''"));
foreach ($surcharges as $s) {
        if (isset($test_lang_personnalisation[$s['cle']])) {
                $test_lang_personnalisation[$s['cle']] = $s['texte'];
        }
}
}
$GLOBALS[$GLOBALS['idx_lang']] = $test_lang_personnalisation;
?>