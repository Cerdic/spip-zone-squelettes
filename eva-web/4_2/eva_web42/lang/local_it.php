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
	'icone_eva' => 'Icona EVA-web 4',
	'identifier' => 'siete autenticati',
	'il_y_a' => 'c\'?®',
	'il_y_a1' => 'firme per questa petizione',
	'il_y_a2' => 'Ci ?® al totale',
	'il_y_a3' => 'articoli.<br/> questo blocco in manifesto',
	'il_y_a4' => 'autori.<br /> questo blocco in manifesto',
	'il_y_a5' => 'News.<br /> questo blocco in manifesto',
	'inscription' => 'Iscrizione',

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
	'mentions_adresse' => 'Indirizzo:',
	'mentions_directeur_publication' => 'Direttore della pubblicazione:',
	'mentions_droit_auteur_texte' => '<p>Questo sito è protetto dalla legge italiana ed internazionale sul diritto d\'autore e la proprietà intellettuale.</p>
 <p>Tutti i diritti di riproduzione sono riservati.</p>',
	'mentions_droit_auteur_titre' => 'Diritti degli autori:',
	'mentions_legales' => 'Menzioni legali',
	'mentions_liens_hypertexte_texte' => '<p>Questo sito contiene dei link ipertestuali che consentono l\'accesso a siti non gestiti la responsabile di questo sito.</p>
 <p>Di conseguenza il direttore della pubblicazione non potrà essere ritenuto responsabile del contenuto dei siti ai quali il navigatore avrà accesso.</p>
 <p>&amp;Egrave; formalmente vietato raccogliere e utilizzare le informazioni disponibili sul sito a scopi commerciali.</p>
 <p>Questo divieto si estendo in particolare, senza che questa lista sia esaustiva, a tutti gli elementi redazionali esistenti sul sito, alla veste grafica delle schermate, ai software necessari alla pubblicazione, ai logo, immagini, foto, grafiche, di qualsiasi natura esse siano.</p>',
	'mentions_liens_hypertexte_titre' => 'Link ipertestuali:',
	'mentions_liens_texte' => '<p>Ad eccezione dei siti che diffondono informazioni e/o contenuti aventi un carattere illegale e/o politico, religioso, pornografico, xenofobo, puoi creare un link ipertestuale verso il nostro sito sul tuo sito.</p>
 <p>L\'inserimento di un link ipertestuale non autorizza in alcun modo la riproduzione di elementi del sito o la presentazione su siti terzi di elementi del sito sotto forma di Frame o simili.</p>
 <p>Infine, l\'inserimento di un link ipertestuale non autorizza in alcun modo di proporre per l\'invio un messaggio redatto automaticamente ad un indirizzo email legato al sito o la creazione di un sistema che permette l\'invio massivo di messaggi qualsiasi sia la loro natura.</p>
 <p>Tutti i diritti di riproduzione sono riservati.</p>',
	'mentions_liens_titre' => 'Link ipertestuali verso questo sito:',
	'mentions_logo_cddp74' => 'Sito ufficiale del CDDP74',
	'mentions_logo_citic' => 'Centro per l\'informatica e per l\'ITC dell\'Alta Savoia (ex CRI74)',
	'mentions_logo_edres' => 'Rete scolastica dell\'Alta Savia, progetto dipartimentale',
	'mentions_logo_eva' => 'Sito ufficiale del progetto eva-web',
	'mentions_logo_spip' => 'Sito ufficiale di SPIP',
	'mentions_logo_spipedu' => 'Spip-edu, sito della comunità educativa',
	'mentions_lois' => 'Ai sensi della legge sulla fiducia nell\'economia digitale (LCEN) del 21 giugno 2004, ecco le coordinate dell\'editore e del fornitore del servizio che ospita il sito:',
	'mentions_prestataire' => 'Fornitore del servizio che assicura la memorizzazione diretta e permanente:',
	'mentions_qualite' => 'Qualità:',
	'mentions_qui_texte' => '<p>In origine <a href="http://eva-web.edres74.net/eva/">EVA</a>
corrispondeva a un progetto di portale d\'Intranet istituzionalem installato sui 
 server <a href="http://www.pingoo.org/">PingOO</a>.</p>
 <p>Questa versione, leggermente adattata, consente ad una scuola ou ad una istituzione di creare 
 un sito web collaborativo, proponendo diversi modelli di pubblicazione 
 (articolo, album fotografico, slideshow ...) </p>
 <p>Per maggiori informazioni sul progetto <a href="http://eva-web.edres74.net">EVA-web</a>, consulta il sito 
   <a href="http://eva-web.edres74.net">http://eva-web.edres74.net</a></p>
 <p><a href="http://eva-web.edres74.net">EVA-web</a> è un software libero distribuito sotto licenza pubblica generale 
 <a rel="licence" target="_blank" href="http://katolaz.homeunix.net/gplv3/gplv3-it-final.html">GNU (GNU General Public License o GPL)</a>
 concepito per funzionare grazie all\'applicazione <a href="https://www.spip.net/">SPIP</a>.</p>
 <div style="text-align:center;"><a rel="licence" target="_blank" href="http://katolaz.homeunix.net/gplv3/gplv3-it-final.html"><img alt="Licence GNU GPL" style="border-width:0" width="80" height="100" src="http://www.fsf.org/graphics/philosophical-gnu-sm.jpg"/></a></div>',
	'mentions_qui_titre' => 'EVA, di chi, per chi?',
	'mentions_responsable_edition' => 'Responsabile di pubblicazione:',
	'mentions_site' => 'Sito internet di: ',
	'mentions_webmestre' => 'Webmaster:',
	'meteo' => 'Meteo',
	'meteo_info' => 'Informazioni geografiche',
	'meteo_previsions' => 'Previsioni meteo',
	'mis_a_jour' => 'aggiornamenti : ',
	'mot_cle' => 'parole chiave',
	'multilinguisme' => 'Pubblicare il frammento di linguaggio di Eva-web nelle pagine pubbliche?',
	'multilinguisme_article' => 'Quest\'articolo in:',

	// N
	'notes' => 'Note',

	// P
	'page_bas' => 'Fine pagina',
	'page_haut' => 'Inizio pagina',
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
	'site' => 'sito',
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
	'syndic_breves' => 'RSS delle brevi del sito',
	'syndic_site' => 'RSS di tutto il sito',

	// T
	'texte_page_404' => '<em> Stato spiacente !</em><br /> La pagina che ricercate sembra non essere pi?? in questo sito web. ',
	'tous_droits' => 'tutti i diritti riservati',
	'tous_les_auteurs' => 'tutti gli autori',

	// V
	'version_eva' => 'EVA-Web 4.2',
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