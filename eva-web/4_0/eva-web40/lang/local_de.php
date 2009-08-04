<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('base/abstract_sql');

// Fichier de langue du site, utilis&eacute;‚dans les squelettes

$test_lang_personnalisation=array(
// A <:form_pet_message_commentaire:>
'accueil' => 'Homepage',
'acces_restreint' => 'eingeschr&auml;nkte Zone',
'agenda' => 'Kalender',
'aide' => 'Hilfe',
'articles' => 'Artikel',
'article_complet' =>  'Schlie&szlig;en Sie Artikel ab',
'aucun_resultat_pour' =>  'nicht Ergebni&szlig;e f&uuml;r Pr&auml;zedenzfall',
'article_precedent' =>  'vorhergehend artikel',
'article_precedent_premier' => 'erster Artikel',
'article_suivant' => 'nach',
'article_suivant_dernier' => 'letzter Artikel',
'aucun_evenement' => 'er nicht dort dieser Monat im Kalender vorgesehene Ereigni&szlig;e',

// B
'breves' => 'Nachrichten',
'breves_rubrique' => 'Nachrichten f&uuml;r dieses Kapitel',

// C
'contact' => 'Kontakt',
'copyright_spip' => 'Diese Site wird vorbei gehandhabt',
'copyright_eva' => 'und Gebrauch&szlig;chablone',

// D
'doc_redacteurs' => 'Auf Zeile Dokumente f&uuml;r die Verfa&szlig;er, die EVA_Red verwenden',
'documents_joints' => 'Auh&auml;nge',
'document' => 'Dokument',
'deconnecter' => 'Logout',
'derniers_articles' => 'sp&auml;teste Artikel',
'dernieres_breves' => 'sp&auml;teste Nachrichten',
'derniers_commentaires' => 'sp&auml;teste Kommentare',
'derniers_podcasts' => 'die sp&auml;testen poscasts',
'derniers_sites' => 'Sp&auml;teste Sites',
'de_cet_auteur' => 'von diesem Autor',
'derniere_mise_a_jour' => 'Sp&auml;teste Updates',
'diaporama' =>  'Diavorf&uuml;hrung',
'dix_meilleurs_articles' => 'Artikel der Spitze zehn',
'dix_meilleurs_commentaires' => 'Kommentare der Spitze zehn',
'dix_meilleurs_breves' => 'Nachrichten der Spitzen-zehn',

// E
'erreur_404' => 'Fehler 404',
'evenements_du' => 'Ereigni&szlig;e f&uuml;r',
'evenements_a_venir' => 'Ereigni&szlig;e zum zu kommen',
'evenement_aucun' => 'Es gibt kein invisaged Ereignis dieser Monat im Tagebuch',
'evenements_passes' => 'Letzte Ereigni&szlig;e',
'evenements_passes_aucun' => 'Es gibt nein Vergangenheitsereigni&szlig;e im Tagebuch',

// F
'fermer_fenetre' => 'Schlie&szlig;en Sie das Fenster',
'form_pet_message_commentaire' => 'einen Kommentar? ',
'feuilleter_livre' => 'Blatt durch das Buch',

// G
'go' => 'Gehen Sie',
'galaxie_spip' => 'Die SPIP Galaxie',

// H

// I
'identifier' => 'Sie werden angeschlo&szlig;en',
'il_y_a' => 'Es gibt',
'il_y_a1' => 'Kennzeichnen Sie herein diese Petition',
'il_y_a2' =>  'dort ist in der Summe',
'il_y_a3' => 'Artikel </br> dieser Block im poster',
'il_y_a4' => 'Autor </br> dieser Block im poster',
'il_y_a5' => 'Nachrichten </br> dieser Block im poster',

// J
'j1' => 'mon',
'j2' => 'die',
'j3' => 'mit',
'j4' => 'don',
'j5' => 'fre',
'j6' => 'sam',
'j7' => 'son',
'jo1' =>'Montag',
'jo2' => 'Dienstag',
'jo3' => 'Mittwoch',
'jo4' => 'Donnerstag',
'jo5' => 'Freitag',
'jo6' => 'Samstag',
'jo7' => 'Sonntag',

// L
'lire_suite' => 'Lesen Sie mehr',
'lancer_diaporama' => '&ouml;ffnen Sie Diavorf&uuml;hrung',
'lien_externe'=> 'Externes Link, &ouml;ffnen sich im neuen Fenster',

// M
'meme_rubrique' => 'In diesem Kapitel',
'mot_cle' => 'Schl&uuml;&szlig;elw&ouml;rter',
'mis_a_jour' => 'Aktualisierend : ',
'mentions' => 'Erw&auml;hnungen',
'mentions_legales' => 'Legale Erw&auml;hnungen',
'm1' => 'Januar',
'm2' => 'Februar',
'm3' => 'M&auml;rz',
'm4' => 'April',
'm5' => 'Mai',
'm6' => 'Juni',
'm7' => 'Juli',
'm8' => 'August',
'm9' => 'September',
'm10' => 'Oktober',
'm11' => 'November',
'm12' => 'Dezember',

// N
'notes' => 'Anmerkungen',

// P
'plan_du_site' => 'Site-Karte',
'post_scriptum' => 'Posten-scriptum',
'par' => 'vorbei :',
'publie' => 'Ver&ouml;ffentlicht',
'pour' => 'f&uuml;r',
'pages' => 'Seiten',
'partenaires' => 'Partners',
'podcasts' => 'Podcasts',
'podcasts_rss' => 'Podcasts und RSS',

// R
'redaction' => 'Redaction',
'rechercher' => 'Entdeckung',
'resultats' => 'Resultiert',
'replier' => 'nah',

// S
'sites' => 'Andere Sites :',
'sites_references' => 'Bezug&szlig;ites',
'sites_rubrique' =>  'Sites f&uuml;r dieses Kapitel',
'sites_syndic' => 'organisierten Sites gewerkschaftlich',
'sur_le_web' => 'Auf dem Web',
'sur_un_total_de' => 'Von der Summe von',
'sous_rubrique' => 'Unterabschnitt',
'statut_admin' =>  'Status : Manager',
'statut_redac' => 'Status : Verfa&szlig;er',
'statut_visit' => 'Status : Besucher',

// T
'texte_page_404' => '<em>Traurig!</em></br>Diese Seite existiert nicht.',
'tous_les_auteurs' => 'Alle Verfa&szlig;er',
'tous_droits' =>  'Alle Rechte vorbehalten',

// V
'version_eva' => 'Eva-Web 4,0 Stall',
'visites' =>'Besuche',
'voir_en_ligne' => 'Sehen Sie auf dem Web',
'voir_image' => 'Sehen Sie, da&szlig; die Abbildung mit urspr&uuml;nglicher Gr&ouml;&szlig;e',
'vous_etes_ici' => 'Sie sind hier',

//Z

'zone' => 'Gesch&uuml;tzte Zone',
);

$langue_fichier_initial=$test_lang_personnalisation;
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
$GLOBALS[$GLOBALS['idx_lang']] = $test_lang_personnalisation;
?>