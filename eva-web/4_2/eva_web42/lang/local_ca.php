<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('base/abstract_sql');

// Fichier de langue du site, utilis&eacute; dans les squelettes

$test_lang_personnalisation=array(

// A
	'acces_restreint' => 'Acc�s restringit',
	'accueil' => 'Inici',
	'agenda' => 'Agenda',
	'aide' => 'Ajuda',
	'article_complet' => 'Article complet',
	'article_precedent' => 'Anterior',
	'article_precedent_premier' => 'Primer',
	'article_suivant' => 'Seg�ent',
	'article_suivant_dernier' => '�ltim',
	'articles' => 'Articles',
	'aucun_evenement' => 'A l\'agenda d\'aquest mes no hi ha cap esdeveniment previst',
	'aucun_resultat_pour' => 'Cap resultat per',

	// B
	'breves' => 'Breus',
	'breves_rubrique' => 'Breus de la secci�',

	// C
	'contact' => 'Contacte',
	'copyright_eva' => 'i utilitzeu l\'esquelet',
	'copyright_spip' => 'Aquest lloc est� gestionat sota',

	// D
	'de_cet_auteur' => 'd\'aquest autor',
	'deconnecter' => 'Desconnectar-se',
	'derniere_mise_a_jour' => '�ltima actualitzaci�',
	'dernieres_breves' => '�ltimes breus',
	'derniers_articles' => '�ltims articles',
	'derniers_commentaires' => '�ltimes comentaris',
	'derniers_podcasts' => '�ltims podcasts ',
	'derniers_sites' => '�ltims llocs',
	'diaporama' => 'Diaporama ',
	'dix_meilleurs_articles' => 'Els deu millors articles',
	'dix_meilleurs_breves' => 'Les deu millors breus ',
	'dix_meilleurs_commentaires' => 'Els deu millors comentaris',
	'doc_redacteurs' => 'Documentaci� en l�nia per als escriptors de EVA-Web ',
	'document' => 'Document',
	'documents_joints' => 'Documents adjunts',

	// E
	'erreur_404' => 'Error 404',
	'evenement_aucun' => 'A l\'agenda no hi ha cap esdeveniment proper.',
	'evenements_a_venir' => 'Propers esdeveniments',
	'evenements_du' => 'Els esdeveniments del',
	'evenements_passes' => 'Esdeveniments passats ',
	'evenements_passes_aucun' => 'A l\'agenda no hi ha cap esdeveniment passat',

	// F
	'fermer_fenetre' => 'Tancar la finestra',
	'feuilleter_livre' => 'Examinar el llibre',
	'form_pet_message_commentaire' => 'Un comentari?',

	// G
	'galaxie_spip' => 'La gal�xia SPIP ',
	'go' => 'anar',

	// I
	'icone_eva' => 'Icona EVA-web 4',
	'identifier' => 'Esteu autenticats ',
	'il_y_a' => 'Hi ha',
	'il_y_a1' => 'signatura (es) a aquesta petici�. ',
	'il_y_a2' => 'Hi ha un total de ',
	'il_y_a3' => 'article(s).<br /> Aquest bloc en mostra ',
	'il_y_a4' => 'autor(s).<br /> Aquest bloc en mostra',
	'il_y_a5' => 'breu(s).<br /> Aquest bloc en mostra',
	'inscription' => 'Inscripci�',

	// J
	'j1' => 'dl',
	'j2' => 'dt',
	'j3' => 'dc',
	'j4' => 'dj',
	'j5' => 'dv',
	'j6' => 'ds',
	'j7' => 'dg',
	'jo1' => 'Dilluns',
	'jo2' => 'Dimarts',
	'jo3' => 'Dimecres',
	'jo4' => 'Dijous',
	'jo5' => 'Divendres',
	'jo6' => 'Dissabte',
	'jo7' => 'Diumenge',

	// L
	'lancer_diaporama' => 'Llan�ar el Diaporama',
	'lien_externe' => 'Enlla� extern al lloc, s\'obre en una nova finestra',
	'lire_suite' => 'Llegir la continuaci�',

	// M
	'm1' => 'gener',
	'm10' => 'octubre',
	'm11' => 'novembre',
	'm12' => 'desembre',
	'm2' => 'febrer',
	'm3' => 'mar�',
	'm4' => 'abril',
	'm5' => 'maig',
	'm6' => 'juny',
	'm7' => 'juliol',
	'm8' => 'agost',
	'm9' => 'setembre',
	'meme_rubrique' => 'En aquesta secci�',
	'mentions' => 'Mencions',
	'mentions_adresse' => 'Adre�a: ',
	'mentions_directeur_publication' => 'Director de la publicaci�: ',
	'mentions_droit_auteur_texte' => '<p>Aquest lloc es basa en la legislaci� francesa i internacional pel que fa als drets d\'autor i a la propietat intel�lectual.</p>
 <p>Estan reservats tots els drets de reproducci�.</p>',
	'mentions_droit_auteur_titre' => 'Drets d\'autors: ',
	'mentions_legales' => 'Mencions legals',
	'mentions_liens_hypertexte_texte' => '<p>Aquest lloc cont� enlla�os que permeten l\'acc�s a llocs que no s�n editats pel responsable d\'aquest lloc.</p>
 <p>En conseq��ncia, el director de publicaci� no pot ser responsable del contingut dels llocs als que l\'internauta podria tenir acc�s.</p>
 <p>Est� totalment prohibit recollir i utilitzar les informacions que hi ha disponibles al lloc amb finalitats comercials.</p>
 <p>Aquesta prohibici� s\'est�n sobretot, sense que la llista sigui limitativa, a qualsevol element de redaccional que hi hagi al lloc, a la presentaci� de pantalles, al programari necessari per les explicacions, als logos, imatges, fotos, gr�fics, de qualsevol tipus.</p>',
	'mentions_liens_hypertexte_titre' => 'Enlla�os: ',
	'mentions_liens_texte' => '<p>Excepte els llocs que difonguin informacions i/o continguts que tinguin un car�cter il�legal i/o un car�cter pol�tic, religi�s, pornogr�fic, xen�fob, podeu crear un enlla� des del vostre lloc cap al nostre Lloc Web.</p>
 <p>La publicaci� de l\'enlla� no autoritza de cap manera la reproducci� d\'elements del Lloc o la presentaci� a tercers indrets d\'elements del Lloc en forma de Frame o sistema similar.</p>
 <p>Finalment, la publicaci� de l\'enlla� no autoritza, en cap cas, l\'enviament de missatges escrits pr�viament a un correu electr�nic vinculat al Lloc o la publicaci� d\'un sistema que permeti l\'enviament massiu de missatges sigui quina sigui la seva naturalesa. </p>
 <p>Estan reservats tots els drets de reproducci�.</p>',
	'mentions_liens_titre' => 'Enlla�os cap aquest lloc: ',
	'mentions_logo_cddp74' => 'Lloc oficial del CDDP74',
	'mentions_logo_citic' => 'Centre de la Inform�tica i les TIC de l\'Haute-Savoie (ex CRI74)',
	'mentions_logo_edres' => 'Educaci� Xarxa Haute-Savoie, projecte departamental',
	'mentions_logo_eva' => 'Lloc oficial del projecte eva-web',
	'mentions_logo_spip' => 'Lloc oficial d\'SPIP',
	'mentions_logo_spipedu' => 'Spip-edu, lloc de la comunitat educativa',
	'mentions_lois' => 'En virtut de la "loi pour la confiance dans l\'�conomie num�rique" (LCEN) del 21 de juny del 2004, podeu trobar aqu� les dades de l\'editor i del prove�dor que acull el lloc:',
	'mentions_prestataire' => 'Prove�dor que assegura l\'emmagatzematge directe i permanent: ',
	'mentions_qualite' => 'Qualitat: ',
	'mentions_qui_texte' => '<p>Origin�riament <a href="http://eva-web.edres74.net/eva/">EVA</a>
 correspon a un projecte de portal d\'Intranet d\'Establiment, instal�lat als servidors <a href="http://www.pingoo.org/">PingOO</a>.</p>
 <p>Aquesta versi�, lleugerament adaptada, permet a una escola o a un establiment implementar un lloc Web col�laboratiu, proposant diferents models de publicaci� (article, �lbum de fotos, diaporama ...) </p>
 <p>Si voleu m�s informaci� sobre el projecte <a href="http://eva-web.edres74.net">EVA-web</a>, consulteu el lloc <a href="http://eva-web.edres74.net">http://eva-web.edres74.net</a></p>
 <p><a href="http://eva-web.edres74.net">EVA-web</a> �s un programari lliure distribu�t sota Llic�ncia P�blica General 
 <a rel="licence" target="_blank" href="http://www.april.org/gnu/gpl_french.html">GNU (GNU General Public License o GPL)</a>
 concebut per funcionar a partir de l\'aplicaci� <a href="http://www.spip.net/">SPIP</a>.</p>
 <div style="text-align:center;"><a rel="licence" target="_blank" href="http://www.april.org/gnu/gpl_french.html"><img alt="Licence GNU GPL" style="border-width:0" width="80" height="100" src="http://www.fsf.org/graphics/philosophical-gnu-sm.jpg"/></a></div>',
	'mentions_qui_titre' => 'EVA, per qui, per a qui?',
	'mentions_responsable_edition' => 'Responsable d\'edici�: ',
	'mentions_site' => 'Lloc Internet de: ',
	'mentions_webmestre' => 'Webmestre: ',
	'meteo' => 'Temps',
	'meteo_info' => 'Informacions geogr�fiques',
	'meteo_previsions' => 'Previsi� del temps',
	'mis_a_jour' => 'Modificat:',
	'mot_cle' => 'Paraules clau',
	'multilinguisme' => 'Mostrar el men� de llengua d\'EVA-web a les p�gines p�bliques?',
	'multilinguisme_article' => 'Aquest article en:',

	// N
	'notes' => 'Notes',

	// P
	'page_bas' => 'Peu de p�gina',
	'page_haut' => 'Cap�alera',
	'pages' => 'P�gines',
	'par' => 'Per:',
	'partenaires' => 'Socis',
	'plan_du_site' => 'Mapa',
	'podcasts' => 'Podcasts',
	'podcasts_rss' => 'Podcast i RSS',
	'post_scriptum' => 'Postdata',
	'pour' => 'per',
	'publie' => 'Publicat:',

	// R
	'rechercher' => 'Cercar',
	'redaction' => 'Redacci�',
	'replier' => 'Tornar a plegar',
	'resultats' => 'Resultats',

	// S
	'site' => 'lloc',
	'sites' => 'Altres llocs:',
	'sites_references' => 'Llocs referenciats',
	'sites_rubrique' => 'Llocs de la secci�',
	'sites_syndic' => 'Llocs sindicats de la secci�',
	'sous_rubrique' => 'Subsecci� ',
	'statut_admin' => 'Estatus: Administrador<br />',
	'statut_redac' => 'Estatus: Redactor',
	'statut_visit' => 'Estatus: Visitant',
	'sur_le_web' => 'A la Web',
	'sur_un_total_de' => 'd\'un total de ',
	'syndic_breves' => 'Sindicar les breus del lloc',
	'syndic_site' => 'Sindicar tot el lloc',

	// T
	'texte_page_404' => '<em>Ho sentim!</em><br />La p�gina que busqueu no existeix.',
	'tous_droits' => 'Reservats tots els drets',
	'tous_les_auteurs' => 'Tots els autors',

	// V
	'version_eva' => 'EVA-Web 4.1 ',
	'visites' => 'Visites',
	'voir_en_ligne' => 'Veure en l�nia:',
	'voir_image' => 'Veure la imatge m�s gran',
	'vous_etes_ici' => 'Esteu aqu�:',

	// Z
	'zone' => 'zona protegida'
);

$langue_fichier_initial=$test_lang_personnalisation;
$test=sql_showtable('spip_eva_habillage_images',true);
if ($test['field']) {
$surcharges = sql_allfetsel(array('nom_image AS texte', 'nom_div AS cle'),'spip_eva_habillage_images',  array(
        "type = 'fichier_lang'",
        "nom_habillage = 'Defaut'",
	"attach = 'ca'",
        "nom_image != ''"));
foreach ($surcharges as $s) {
        if (isset($test_lang_personnalisation[$s['cle']])) {
                $test_lang_personnalisation[$s['cle']] = $s['texte'];
        }
}
}
$GLOBALS[$GLOBALS['idx_lang']] = $test_lang_personnalisation;
?>