<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('base/abstract_sql');

// Fichier de langue du site

$test_lang_personnalisation=array(
// A
	'acces_restreint' => 'Acceso limitado',
	'accueil' => 'Home page',
	'agenda' => 'ordine del giorno',
	'aide' => 'aiuto',
	'article_complet' => 'Articolo completo',
	'article_precedent' => 'Articolo precedente',
	'article_precedent_premier' => 'primo articolo',
	'article_suivant' => 'articolo seguente',
	'article_suivant_dernier' => 'ultimo articolo',
	'articles' => 'Articoli',
	'aucun_evenement' => 'non ci sono eventi previsti questo mese nell\'ordine del giorno',
	'aucun_resultat_pour' => 'nessun risultati per',

	// B
	'breves' => 'News',
	'breves_rubrique' => 'News della sezione',

	// C
	'contact' => 'contatto',
	'copyright_eva' => 'ed utilizza la struttura',
	'copyright_spip' => 'questo sito web ?® diretto da',

	// D
	'de_cet_auteur' => 'di quest\'autore',
	'deconnecter' => 'staccarsi',
	'derniere_mise_a_jour' => 'ultimi aggiornamenti',
	'dernieres_breves' => 'gli ultimi news',
	'derniers_articles' => 'gli ultimi articoli',
	'derniers_commentaires' => 'gli ultimi commenti',
	'derniers_podcasts' => 'gli ultimi podcasts',
	'derniers_sites' => 'gli ultimi siti web',
	'diaporama' => 'Diaporama',
	'dix_meilleurs_articles' => 'I dieci migliori articoli',
	'dix_meilleurs_breves' => 'I dieci migliori news',
	'dix_meilleurs_commentaires' => 'I dieci migliori commenti',
	'doc_redacteurs' => 'documenti in linea per gli editori che utilizzano Eva-Red',
	'document' => 'Documento',
	'documents_joints' => 'documenti unite',

	// E
	'erreur_404' => 'Errore 404',
	'evenement_aucun' => 'non ci sono eventi previsti questo mese nell\'ordine del giorno',
	'evenements_a_venir' => 'gli eventi previsti',
	'evenements_du' => 'gli eventi di',
	'evenements_passes' => 'eventi scorsi',
	'evenements_passes_aucun' => 'non ci sono eventi scorsi questo mese nell\'ordine del giorno',

	// F
	'fermer_fenetre' => 'chiudere la finestra',
	'feuilleter_livre' => 'sfogliare il libro',
	'form_pet_message_commentaire' => 'Un commento?',

	// G
	'galaxie_spip' => 'la galassia SPIP',
	'go' => 'andare',

	// I
	'icone_eva' => '<NEW>Icone EVA-web 4',
	'identifier' => 'siete autenticati',
	'il_y_a' => 'c\'?®',
	'il_y_a1' => 'firme per questa petizione',
	'il_y_a2' => 'Ci ?® al totale',
	'il_y_a3' => 'articoli.<br/> questo blocco in manifesto',
	'il_y_a4' => 'autori.<br /> questo blocco in manifesto',
	'il_y_a5' => 'News.<br /> questo blocco in manifesto',
	'inscription' => '<NEW>Inscription',

	// J
	'j1' => 'lu',
	'j2' => 'ma',
	'j3' => 'me',
	'j4' => 'gi',
	'j5' => 've',
	'j6' => 'sa',
	'j7' => 'do',
	'jo1' => 'luned&iagrave;',
	'jo2' => 'marted&iagrave;',
	'jo3' => 'mercoled&iagrave;',
	'jo4' => 'gioved&iagrave;',
	'jo5' => 'venerd&iagrave;',
	'jo6' => 'sabato',
	'jo7' => 'domenica',

	// L
	'lancer_diaporama' => 'lanciare il diaporama',
	'lien_externe' => 'legame esterno al sito, si apre in un\'altra finestra',
	'lire_suite' => 'leggere il seguito',

	// M
	'm1' => 'gennaio',
	'm10' => 'ottobre',
	'm11' => 'novembre',
	'm12' => 'dicembre',
	'm2' => 'febbraio',
	'm3' => 'marzo',
	'm4' => 'aprile',
	'm5' => 'maggio',
	'm6' => 'giugno',
	'm7' => 'luglio',
	'm8' => 'agosto',
	'm9' => 'settembre',
	'meme_rubrique' => 'nella stessa sezione',
	'mentions' => 'Menzioni',
	'mentions_adresse' => '<NEW>Adresse :',
	'mentions_directeur_publication' => '<NEW>Directeur de la publication :',
	'mentions_droit_auteur_texte' => '<NEW><p>Ce site rel&egrave;ve de la l&eacute;gislation fran&ccedil;aise et internationale sur le droit d\'auteur et la propri&eacute;t&eacute; intellectuelle.</p>
	<p>Tous les droits de reproduction sont r&eacute;serv&eacute;s.</p>',
	'mentions_droit_auteur_titre' => '<NEW>Droits d\'auteurs :',
	'mentions_legales' => 'Menzioni legali',
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
	'mis_a_jour' => 'aggiornamenti : ',
	'mot_cle' => 'parole chiave',
	'multilinguisme' => 'Pubblicare il frammento di linguaggio di Eva-web nelle pagine pubbliche?',
	'multilinguisme_article' => 'Quest\'articolo in:',

	// N
	'notes' => 'Note',

	// P
	'page_bas' => '<NEW>Bas de page',
	'page_haut' => '<NEW>Haut de page',
	'pages' => 'Pagine',
	'par' => 'da parte de :',
	'partenaires' => 'Partner',
	'plan_du_site' => 'Mappa del sito',
	'podcasts' => 'Podcasts',
	'podcasts_rss' => 'Podcast e RSS',
	'post_scriptum' => 'Post-scriptum',
	'pour' => 'per',
	'publie' => 'pubblicato :',

	// R
	'rechercher' => 'ricercare',
	'redaction' => 'Redazione',
	'replier' => 'ripiegare',
	'resultats' => 'risultati',

	// S
	'site' => '<NEW>site',
	'sites' => 'altri siti web :',
	'sites_references' => 'siti web rinviati',
	'sites_rubrique' => 'i siti web della sezione',
	'sites_syndic' => 'siti web sindacalizzati',
	'sous_rubrique' => 'suddivisione di sezione',
	'statut_admin' => 'statuto: amministratore',
	'statut_redac' => 'statuto: editore',
	'statut_visit' => 'statuto: ospite',
	'sur_le_web' => 'legami utili',
	'sur_un_total_de' => 'su un totale di',
	'syndic_breves' => '<NEW>Syndiquer les br&egrave;ves du site',
	'syndic_site' => '<NEW>Syndiquer tout le site',

	// T
	'texte_page_404' => '<em> Stato spiacente !</em><br /> La pagina che ricercate sembra non essere pi?? in questo sito web. ',
	'tous_droits' => 'tutti i diritti riservati',
	'tous_les_auteurs' => 'tutti gli autori',

	// V
	'version_eva' => 'EVA-Web 4.1',
	'visites' => 'Visite',
	'voir_en_ligne' => 'Vedere sul net :',
	'voir_image' => 'Vedere l\'immagine in dimensione normale',
	'vous_etes_ici' => 'Siete qui :',

	// Z
	'zone' => 'Zona protetta'
);

$langue_fichier_initial=$test_lang_personnalisation;
$test=sql_showtable('spip_eva_habillage_images',true);
if ($test['field']) {
$surcharges = sql_allfetsel(array('nom_image AS texte', 'nom_div AS cle'),'spip_eva_habillage_images',  array(
        "type = 'fichier_lang'",
        "nom_habillage = 'Defaut'",
	"attach = 'it'",
        "nom_image != ''"));
foreach ($surcharges as $s) {
        if (isset($test_lang_personnalisation[$s['cle']])) {
                $test_lang_personnalisation[$s['cle']] = $s['texte'];
        }
}
}
$GLOBALS[$GLOBALS['idx_lang']] = $test_lang_personnalisation;
?>