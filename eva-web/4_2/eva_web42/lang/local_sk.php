<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('base/abstract_sql');

// Fichier de langue du site, utilis&eacute; dans les squelettes

$test_lang_personnalisation=array(
// A
	'acces_restreint' => 'Obmedzený prístup',
	'accueil' => 'Úvodná stránka',
	'agenda' => 'Diár',
	'aide' => 'Pomocník',
	'article_complet' => 'Celý článok',
	'article_precedent' => 'Predchádzajúci',
	'article_precedent_premier' => 'Prvý článok',
	'article_suivant' => 'Ďalší',
	'article_suivant_dernier' => 'Posledný',
	'articles' => 'Články',
	'aucun_evenement' => 'V diári nie je na tento mesiac zapísaná žiadna udalosť',
	'aucun_resultat_pour' => 'Žiadne výsledky pre',

	// B
	'breves' => 'Novinky',
	'breves_rubrique' => 'Novinky v tejto rubrike',

	// C
	'contact' => 'Kontakt',
	'copyright_eva' => 'a používať šablónu',
	'copyright_spip' => 'This site is managed by',

	// D
	'de_cet_auteur' => 'Od tohto autora',
	'deconnecter' => 'Odhlásiť sa',
	'derniere_mise_a_jour' => 'Najnovšie aktualizácie',
	'dernieres_breves' => 'Najnovšie novinky',
	'derniers_articles' => 'Najnovšie články',
	'derniers_commentaires' => 'Najnovšie komentáre',
	'derniers_podcasts' => 'Najnovšie podcasty',
	'derniers_sites' => 'Najnovšie stránky',
	'diaporama' => 'Prezentácia',
	'dix_meilleurs_articles' => 'Najlepších 10 článkov',
	'dix_meilleurs_breves' => '10 najlepších noviniek',
	'dix_meilleurs_commentaires' => '10 najlepších komentárov',
	'doc_redacteurs' => 'Online documents for writers using EVA_Red',
	'document' => 'Dokument',
	'documents_joints' => 'Prílohy',

	// E
	'erreur_404' => 'Chyba 404',
	'evenement_aucun' => 'Na tento mesiac nie je v diári naplánovaná žiadna udalosť.',
	'evenements_a_venir' => 'Nasledujúce udalosti',
	'evenements_du' => 'Udalosti do',
	'evenements_passes' => 'Udalosti v minulosti',
	'evenements_passes_aucun' => 'V diári nie sú zapísané žiadne udalosti z minulosti.',

	// F
	'fermer_fenetre' => 'Zatvoriť okno',
	'feuilleter_livre' => 'Prelistovať knihu',
	'form_pet_message_commentaire' => 'Komentár?',

	// G
	'galaxie_spip' => 'Galaxia SPIPu',
	'go' => 'Prejsť na',

	// I
	'icone_eva' => 'Ikona EVA-web 4',
	'identifier' => 'Ste prihlásený',
	'il_y_a' => 'Je',
	'il_y_a1' => 'podpis(y/ov) na túto petíciu.',
	'il_y_a2' => 'Spolu je',
	'il_y_a3' => 'článok(-nky/-nkov).</br> Tento blok je pútač',
	'il_y_a4' => 'autor(i/ov).</br> Tento blok v pútači',
	'il_y_a5' => 'News.</br>This block in poster',
	'inscription' => 'Prihlásenie',

	// J
	'j1' => 'pon',
	'j2' => 'uto',
	'j3' => 'str',
	'j4' => 'štv',
	'j5' => 'pia',
	'j6' => 'sob',
	'j7' => 'ned',
	'jo1' => 'Pondelok',
	'jo2' => 'Utorok',
	'jo3' => 'Streda',
	'jo4' => 'Štvrtok',
	'jo5' => 'Piatok',
	'jo6' => 'Sobota',
	'jo7' => 'Nedeľa',

	// L
	'lancer_diaporama' => 'Spustiť prezentáciu',
	'lien_externe' => 'Externý odkaz na stránku, otvorí sa v novom okne',
	'lire_suite' => 'Čítať ďalej',

	// M
	'm1' => 'január',
	'm10' => 'október',
	'm11' => 'november',
	'm12' => 'December',
	'm2' => 'február',
	'm3' => 'marec',
	'm4' => 'apríl',
	'm5' => 'máj',
	'm6' => 'jún',
	'm7' => 'júl',
	'm8' => 'August',
	'm9' => 'september',
	'meme_rubrique' => 'V tejto rubrike',
	'mentions' => 'Pripomienky',
	'mentions_adresse' => 'Adresa:',
	'mentions_directeur_publication' => 'Zodpovedný redaktor:',
	'mentions_droit_auteur_texte' => '<p>Táto stránka spadá pod ochranu francúzskych a medzinárodných autorských a duševného vlastníctva.</p>
 <p>Všetky práva vyhradené.</p>',
	'mentions_droit_auteur_titre' => 'Autorské práva:',
	'mentions_legales' => 'Legal notes',
	'mentions_liens_hypertexte_texte' => '<p>Na tejto stránke sú hypertextové odkazy, ktoré neupravuje zodpovedný redaktor tejto stránky.</p>
 <p>Nemôže byť preto zodpovedný za obsah stránok, ku ktorým sa používatelia môžu dostať.</p>
 <p>Zbierať a používať údaje zo stránky na komerčné účely je zakázané.</p>
 <p>Tento zákaz sa vzťahuje na (a nie je tým obmedzený) na všetky redakčné prvky na stránke, prezentačné obrazovky, softvér potrebný na prevádzku, logá, obrázky, fotky, grafiku každého druhu.</p>',
	'mentions_liens_hypertexte_titre' => 'Hypertextové odkazy:',
	'mentions_liens_texte' => '<p>Ak nemáte stránku, ktorá poskytuje osobné údaje, a/lebo je ilegálna, a/lebo politická, náboženská, pornografická, xenofóbna, môžete na svojej stránke vytvoriť odkaz na našu stránku.</p>
 <p>Pridanie odkazu vás v žiadnom prípade neoprávňuje na reprodukciu prvkov stránky ani na prezentáciu prvkov stránok tretích strán v podobe rámu alebo podobnej forme.</p>
 <p>Napokon, vytvorenie hypertextového odkazu v žiadnom prípade neoprávňuje ani na posielanie správ na predvolenú adresu prepojenú so stránkou a neoprávňuje ani na vytvorenie systému na posielanie hromadných správ bez ohľadu na ich obsah.</p>
 <p>Všetky práva vyhradené.</p>',
	'mentions_liens_titre' => 'Hypertextové odkazy na túto stránku:',
	'mentions_logo_cddp74' => 'Oficiálna stránka CDDP74',
	'mentions_logo_citic' => 'Centrum pre informatiku a IKT Haute-Savoie (napr. CRI74)',
	'mentions_logo_edres' => 'Vzdelávacia sieť Haute-Savoie, projekt départementu',
	'mentions_logo_eva' => 'Oficiálna stránka projektu eva-web',
	'mentions_logo_spip' => 'Oficiálna stránka SPIPu',
	'mentions_logo_spipedu' => 'Spip-edu, stránky škôl',
	'mentions_lois' => 'Podľa zákona o dôvere v digitálnej ekonomike (LCEN) z 21. júna 2004, kontakt na vydavateľa a poskytovateľa, ktorý je hostiteľom webu:',
	'mentions_prestataire' => 'Služba, ktorá poskytuje priame a trvalé uloženie dát:',
	'mentions_qualite' => 'Kvalita:',
	'mentions_qui_texte' => '<p>Pôvodne <a href="http://eva-web.edres74.net/eva/">EVA</a>
 zodpovedá projektu intranetového portálu inštitúcie nainštalovanom 
 na serveroch <a href="http://www.pingoo.org/">PingOO.</a></p>
 <p>Táto mierne upravená verzia  umožňuje škole alebo inštitúcii vytvoriť si
 internetovú stránku na vzájomnú spoluprácu, pričom sú v ponuke rôzne modely publikovania 
 (článok, fotoalbum, prezentácia a pod.) </p>
 <p>Ak chcete zistiť viac informácií o projekte <a href="http://eva-web.edres74.net">EVA-web,</a> navštívte stránku 
   <a href="http://eva-web.edres74.net">http://eva-web.edres74.net</a></p>
 <p><a href="http://eva-web.edres74.net">EVA-web</a> je slobodný softvér, ktorý sa distribuuje pod licenciou GNU General Public License 
 <a rel="licence" target="_blank" href="http://sk.wikipedia.org/wiki/GNU_General_Public_License">GNU (GNU General Public Licencia GPL)</a>
 určená na používanie <a href="https://www.spip.net/">SPIPu.</a></p>
 <div style="text-align:center;"><a rel="licence" target="_blank" href="http://sk.wikipedia.org/wiki/GNU_General_Public_License"><img alt="Licencia GNU GPL" style="border-width:0" width="80" height="100" src="http://www.fsf.org/graphics/philosophical-gnu-sm.jpg"/></a></div>',
	'mentions_qui_titre' => 'EVA, od koho, pre koho?',
	'mentions_responsable_edition' => 'Zodpovedný za publikovanie:',
	'mentions_site' => 'Internetová stránka: ',
	'mentions_webmestre' => 'Webmaster:',
	'meteo' => 'Počasie',
	'meteo_info' => 'Zemepisné údaje',
	'meteo_previsions' => 'Predpoveď počasia',
	'mis_a_jour' => 'Updated: ',
	'mot_cle' => 'Kľúčové slová',
	'multilinguisme' => 'Zobraziť jazykové menu EVA-Webu na verejne prístupných stránkach?',
	'multilinguisme_article' => 'Tento článok je v:',

	// N
	'notes' => 'Poznámky',

	// P
	'page_bas' => 'Päta stránky',
	'page_haut' => 'Hlavička stránky',
	'pages' => 'Stránky',
	'par' => 'od:',
	'partenaires' => 'Partneri',
	'plan_du_site' => 'Mapa stránky',
	'podcasts' => 'Podcasty',
	'podcasts_rss' => 'Podcasty a RSS',
	'post_scriptum' => 'Post scriptum',
	'pour' => 'pre',
	'publie' => 'Publikovaný:',

	// R
	'rechercher' => 'Vyhľadať',
	'redaction' => 'Redakcia',
	'replier' => 'Zatvoriť',
	'resultats' => 'Výsledky',

	// S
	'site' => 'stránka',
	'sites' => 'Iné stránky:',
	'sites_references' => 'Odkazy na stránky',
	'sites_rubrique' => 'Odkazy v tejto rubrike',
	'sites_syndic' => 'Syndicated sites',
	'sous_rubrique' => 'Podrubrika',
	'statut_admin' => 'Funkcia: administrátor<br />',
	'statut_redac' => 'Funkcia: redaktor',
	'statut_visit' => 'Funkcia: návštevník',
	'sur_le_web' => 'Na webe',
	'sur_un_total_de' => 'Z celkového počtu',
	'syndic_breves' => 'Syndikovať novinky na stránke',
	'syndic_site' => 'Syndikovať celú stránku',

	// T
	'texte_page_404' => '<em>Je nám ľúto.</em></br>Požadovaná stránka neexistuje.',
	'tous_droits' => 'Všetky práva vyhradené',
	'tous_les_auteurs' => 'Všetci autori',

	// V
	'version_eva' => 'EVA-Web 4.2',
	'visites' => 'Návštevy',
	'voir_en_ligne' => 'Zobraziť online',
	'voir_image' => 'Zobraziť obrázok vo zväčšenej veľkosti',
	'vous_etes_ici' => 'Nachádzate sa tu:',

	// Z
	'zone' => 'chránená zóna'
);

$langue_fichier_initial=$test_lang_personnalisation;
$test=sql_showtable('spip_eva_habillage_images',true);
if ($test['field']) {
$surcharges = sql_allfetsel(array('nom_image AS texte', 'nom_div AS cle'),'spip_eva_habillage_images',  array(
		"type = 'fichier_lang'",
		"nom_habillage = 'Defaut'",
		"attach = 'sk'",
		"nom_image != ''"));
	foreach ($surcharges as $s) {
		if (isset($test_lang_personnalisation[$s['cle']])) {
			$test_lang_personnalisation[$s['cle']] = $s['texte'];
		}
	}
}
$GLOBALS[$GLOBALS['idx_lang']] = $test_lang_personnalisation;
?>