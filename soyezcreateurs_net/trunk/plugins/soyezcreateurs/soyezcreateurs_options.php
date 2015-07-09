<?php
if (!defined('_ECRIRE_INC_VERSION')) return; 

// Pour être vraiment sûr que ce define soit utilisable dans noisettes/header/header.html avec le #EVAL
if (!defined('_DIR_LIB_SM'))
	define('_DIR_LIB_SM', _DIR_RACINE . 'lib/soundmanagerv297a-20110123/');

if (!defined('_IMG_GD_QUALITE'))
	define('_IMG_GD_QUALITE', 95); // Haute qualité pour les images réduites ; voir http://contrib.spip.net/Astuces-SPIP 

if (!defined('_ACCESSIBILITE_CONSERVER_BULLE'))
	define('_ACCESSIBILITE_CONSERVER_BULLE',true); // Pour conserver les bulles d'aide volontaire sur les liens vers les documents
#if (!defined('_BONUX_STYLE'))
#	define('_BONUX_STYLE',1); // http://zone.spip.org/trac/spip-zone/changeset/35480
if (!defined('_LARGEUR_MODE_IMAGE'))
	define('_LARGEUR_MODE_IMAGE', 799); //  Voir http://permalink.gmane.org/gmane.comp.web.spip.zone/16461
if (!defined('_TITRER_DOCUMENTS'))
	define('_TITRER_DOCUMENTS', true); // Le titre des documents joints est automatiquement pris à partir du nom du fichier (avec mediatheque) ; Voir http://zone.spip.org/trac/spip-zone/changeset/41565

// Pour forcer le mode écran large
$GLOBALS['spip_ecran']=$_COOKIE['spip_ecran']='large';

$GLOBALS['toujours_paragrapher'] = true;
$GLOBALS['barre_typo_pas_de_fork_typo'] = false; // Pour tenir compte de http://zone.spip.org/trac/spip-zone/changeset/22723 et disposer des raccourcis typo supplémentaires !
if (!defined('_AUTOBR'))
	define('_AUTOBR', ''); // cf http://www.spip.net/fr_article5427.html (TextWheel)

// Recalculer le cache si la config du site change
$GLOBALS['marqueur'] .= ":".md5($GLOBALS['meta']['boutonstexte'].$GLOBALS['meta']['btv2'].$GLOBALS['meta']['soyezcreateurs_couleurs'].$GLOBALS['meta']['soyezcreateurs_layout'].$GLOBALS['meta']['soyezcreateurs'].$GLOBALS['meta']['soyezcreateurs_google'].$GLOBALS['meta']['bte'].$GLOBALS['meta']['nom_site'].$GLOBALS['meta']['slogan_site'].$GLOBALS['meta']['descriptif_site'].$GLOBALS['meta']['email_webmaster']); // Sur un conseil de Cedric : http://permalink.gmane.org/gmane.comp.web.spip.zone/6258
if (!defined('_TRI_GROUPES_MOTS'))
	define('_TRI_GROUPES_MOTS', '0+titre,titre');  // cf http://trac.rezo.net/trac/spip/changeset/14712
if (!defined('_DUREE_CACHE_DEFAUT'))
	define('_DUREE_CACHE_DEFAUT', 12*3600); // pris en compte à partir de http://trac.rezo.net/trac/spip/changeset/10121
if (!defined('_URLS_PROPRES_MAX'))
	define('_URLS_PROPRES_MAX', 60); // pris en compte à partire de http://trac.rezo.net/trac/spip/changeset/10346 
# FBI : si on trie sur les titre puis sur les dates, les dates ne classent que ceux qui ont le même titre ==> inutile
# TODO later : quand les rang seront gérés, 'rang, date DESC' fonctionnera
#define('_TRI_ARTICLES_RUBRIQUE', '0+titre,date DESC'); // cf http://trac.rezo.net/trac/spip/changeset/11492
if (!defined('_CLEVERMAIL_NOUVEAUTES_HTML'))
	define("_CLEVERMAIL_NOUVEAUTES_HTML", 'lettre_libre');
if (!defined('_CLEVERMAIL_NOUVEAUTES_TEXT'))
	define("_CLEVERMAIL_NOUVEAUTES_TEXT", 'lettre_libre_txt');
if (!defined('_CLEVERMAIL_DISTANT'))
	define("_CLEVERMAIL_DISTANT", true); // Pour que CM calcule l'URL publique du squelette
if (!defined('_SKEL_HORS_TRAVAUX'))
	define("_SKEL_HORS_TRAVAUX", 'clevermail_do'); // Pour que le plugin en travaux laisse passer les inscriptions à la NL

if (!defined('_SIDR_PERSO'))
	define('_SIDR_PERSO', true); // Pour avoir sa propre insertion des scripts de sidr

if (!defined('_PREVIEW_TOKEN'))
	define('_PREVIEW_TOKEN', true); // http://core.spip.org/projects/spip/repository/revisions/21077 et http://core.spip.org/projects/spip/repository/revisions/21084

/*
	Le truc pour disposer dans #ENV{marker_icon_name} dans les squelettes.
	Merci à ARNO* : http://permalink.gmane.org/gmane.comp.web.spip.devel/55856
*/
#$_GET['marker_icon_name'] = '_Marker_icon'; // Pas utilisé

// Tous ces parametres sont inutiles et non pris en compte si le plugin cfg est installe
$GLOBALS['barre_typo_pas_de_fausses_puces'] = true;
$GLOBALS['BarreTypoEnrichie_Preserve_Header'] = true;
$GLOBALS['config_intertitre'] = true; // Necessaire pour empécher la configuration par CFG
$GLOBALS['debut_intertitre'] = '<h2 class="spip">';
$GLOBALS['fin_intertitre'] = '</h2>';
$GLOBALS['debut_intertitre_2'] = '<h3 class="spip">';
$GLOBALS['fin_intertitre_2'] = '</h3>';
$GLOBALS['debut_intertitre_3'] = '<h4 class="spip">';
$GLOBALS['fin_intertitre_3'] = '</h4>';
$GLOBALS['debut_intertitre_4'] = '<h5 class="spip">';
$GLOBALS['fin_intertitre_4'] = '</h5>';
$GLOBALS['debut_intertitre_5'] = '<h6 class="spip">';
$GLOBALS['fin_intertitre_5'] = '</h6>';

// Pour suivre les recommandations du RGAA :
$GLOBALS['debut_italique'] = "<em$class_spip>";
$GLOBALS['fin_italique'] = '</em>';

// Pour pouvoir styler en appliquant : http://www.sovavsiti.cz/css/hr.html
$GLOBALS['ligne_horizontale'] = "\n<div class='hrspip'><hr class='spip' /></div>\n";

# Envoi de mail aux contributeurs d'un forum si reponse a leur message
if (!defined('_SUIVI_FORUM_THREAD'))
	define('_SUIVI_FORUM_THREAD', true);

// Gere l'inscription aux evenements
// cf http://zone.spip.org/trac/spip-zone/changeset/33103
#include_spip('inc/config');
#$GLOBALS['agenda_affiche_inscription'] = (lire_config('soyezcreateurs/agenda_inscription', '') == 'on') ? 'oui' : 'non';

if (!defined('_CS_OUTILS_CACHES'))
	define('_CS_OUTILS_CACHES', 'auteurs:cs_comportement:insert_head:verstexte:trousse_balises:dossier_squelettes:type_urls:filtrer_javascript:spam:moderation_moderee:paragrapher2:auteur_forum:no_IP:flock:spip_cache:forum_lgrmaxi:simpl_interface:icone_visiter:pucesli:glossaire:blocs:toutmulti:decoupe:filets_sep:couleurs:f_jQuery:desactiver_flash:jcorner:SPIP_liens:class_spip:supprimer_numero:xml:visiteurs_connectes:titre_parent:horloge:liens_en_clair:orientation:sommaire:maj_auto:previsualisation:introduction:forcer_langue:masquer:introduction:tri_articles:webmestres:ecran_securite:autobr:soft_scroller');

function balise_SECTEUR_PDF_dist($p) {
	if (!is_array($p->param))
		$p->param=array();
	
	// Produire le premier argument {secteur_pdf}
	$texte = new Texte;
	$texte->type='texte';
	$texte->texte='secteur_pdf';
	$param = array(0=>NULL, 1=>array(0=>$texte));
	array_unshift($p->param, $param);
	
	// Transformer les filtres en arguments
	for ($i=1; $i<count($p->param); $i++) {
		if ($p->param[$i][0]) {
			if (!strstr($p->param[$i][0], '='))
				break;# on a rencontre un vrai filtre, c'est fini
			$texte = new Texte;
			$texte->type='texte';
			$texte->texte=$p->param[$i][0];
			$param = array(0=>$texte);
			$p->param[$i][1] = $param;
			$p->param[$i][0] = NULL;
		}
	}
	
	// Appeler la balise #MODELE{secteur_pdf}{arguments}
	if (!function_exists($f = 'balise_modele'))
		$f = 'balise_modele_dist';
	return $f($p);
}

function autoriser_evenement_creer_bouton($faire, $type='', $id=0, $qui = NULL, $opt = NULL){ 
	if (isset($opt['contexte']['id_article'])) 
		return autoriser('creerevenementdans','article',$opt['contexte']['id_article'],$qui); 
	return false; 
} 

include_spip('inc/plugin');

if ($plugins_actifs = liste_plugin_actifs() AND empty($plugins_actifs[strtoupper('critere_mots')])){
	function critere_mots_dist($idb, &$boucles, $crit){
		return true;
	}
	function critere_mots_selon_id_dist($idb, &$boucles, $crit){
		return true;
	}
	function critere_mots_selon_titre_dist($idb, &$boucles, $crit){
		return true;
	}
}
