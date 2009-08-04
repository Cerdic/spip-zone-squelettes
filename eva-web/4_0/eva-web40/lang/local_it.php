<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('base/abstract_sql');

// Fichier de langue du site

$test_lang_personnalisation=array(
// A
'accueil' => 'Home page',
'acces_restreint' => 'Acceso limitado',
'agenda' => 'ordine del giorno',
'aide' => 'aiuto',
'articles' => 'Articoli',
'article_complet' => 'Articolo completo',
'aucun_resultat_pour' => 'nessun risultati per',
'article_precedent' => 'Articolo precedente',
'article_precedent_premier' => 'primo articolo',
'article_suivant' => 'articolo seguente',
'article_suivant_dernier' => 'ultimo articolo',
'aucun_evenement' => 'non ci sono eventi previsti questo mese nell\'ordine del giorno',

// B
'breves' => 'News',
'breves_rubrique' => 'News della sezione',

// C
'contact' => 'contatto',
'copyright_spip' => 'questo sito web √® diretto da',
'copyright_eva' => 'ed utilizza la struttura',

// D
'doc_redacteurs' => 'documenti in linea per gli editori che utilizzano Eva-Red',
'documents_joints' => 'documenti unite',
'document' => 'Documento',
'deconnecter' => 'staccarsi',
'derniers_articles' => 'gli ultimi articoli',
'dernieres_breves' => 'gli ultimi news',
'derniers_commentaires' => 'gli ultimi commenti',
'derniers_podcasts' => 'gli ultimi podcasts',
'derniers_sites' => 'gli ultimi siti web',
'de_cet_auteur' => 'di quest\'autore',
'derniere_mise_a_jour' => 'ultimi aggiornamenti',
'diaporama' => 'Diaporama',
'dix_meilleurs_articles' => 'I dieci migliori articoli',
'dix_meilleurs_commentaires' => 'I dieci migliori commenti',
'dix_meilleurs_breves' => 'I dieci migliori news',

// E
'erreur_404' => 'Errore 404',
'evenements_du' => 'gli eventi di',
'evenements_a_venir' => 'gli eventi previsti',
'evenement_aucun' => 'non ci sono eventi previsti questo mese nell\'ordine del giorno',
'evenements_passes' => 'eventi scorsi',
'evenements_passes_aucun' => 'non ci sono eventi scorsi questo mese nell\'ordine del giorno',

// F
'fermer_fenetre' => 'chiudere la finestra',
'form_pet_message_commentaire' => 'Un commento?',
'feuilleter_livre' => 'sfogliare il libro',

// G
'go' => 'andare',
'galaxie_spip' => 'la galassia SPIP',

// H

// I
'identifier' => 'siete autenticati',
'il_y_a' => 'c\'√®',
'il_y_a1' => 'firme per questa petizione',
'il_y_a2' => 'Ci √® al totale',
'il_y_a3' => 'articoli.<br/> questo blocco in manifesto',
'il_y_a4' => 'autori.<br /> questo blocco in manifesto',
'il_y_a5' => 'News.<br /> questo blocco in manifesto',

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
'lire_suite' => 'leggere il seguito',
'lancer_diaporama' => 'lanciare il diaporama',
'lien_externe'=>'legame esterno al sito, si apre in un\'altra finestra',

// M
'meme_rubrique' => 'nella stessa sezione',
'mot_cle' => 'parole chiave',
'mis_a_jour' => 'aggiornamenti : ',
'mentions' => 'Menzioni',
'mentions_legales' => 'Menzioni legali',
'm1' => 'gennaio',
'm2' => 'febbraio',
'm3' => 'marzo',
'm4' => 'aprile',
'm5' => 'maggio',
'm6' => 'giugno',
'm7' => 'luglio',
'm8' => 'agosto',
'm9' => 'settembre',
'm10' => 'ottobre',
'm11' => 'novembre',
'm12' => 'dicembre',

// N
'notes' => 'Note',

// P
'plan_du_site' => 'Mappa del sito',
'post_scriptum' => 'Post-scriptum',
'par' => 'da parte de :',
'publie' => 'pubblicato :',
'pour' => 'per',
'pages' => 'Pagine',
'partenaires' => 'Partner',
'podcasts' =>'Podcasts',
'podcasts_rss' => 'Podcast e RSS',

// R
'redaction' => 'Redazione',
'rechercher' => 'ricercare',
'resultats' => 'risultati',
'replier' => 'ripiegare',

// S
'sites' => 'altri siti web :',
'sites_references' => 'siti web rinviati',
'sites_rubrique' => 'i siti web della sezione',
'sites_syndic' => 'siti web sindacalizzati',
'sur_le_web' => 'legami utili',
'sur_un_total_de' => 'su un totale di',
'sous_rubrique' => 'suddivisione di sezione',
'statut_admin' => 'statuto: amministratore',
'statut_redac' => 'statuto: editore',
'statut_visit' => 'statuto: ospite',

// T
'texte_page_404' => '<em> Stato spiacente !</em><br /> La pagina che ricercate sembra non essere pi√π in questo sito web. ',
'tous_les_auteurs' => 'tutti gli autori',
'tous_droits' => 'tutti i diritti riservati',

// V
'version_eva' => 'EWA-Web 4.0 stabile',
'visites' => 'Visite',
'voir_en_ligne' => 'Vedere sul net :',
'voir_image' => 'Vedere l\'immagine in dimensione normale',
'vous_etes_ici' => 'Siete qui :',

//Z

'zone' => 'Zona protetta',
);

$langue_fichier_initial=$test_lang_personnalisation;
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
$GLOBALS[$GLOBALS['idx_lang']] = $test_lang_personnalisation;
?>