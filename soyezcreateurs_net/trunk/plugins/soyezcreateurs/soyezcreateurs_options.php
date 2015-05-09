<?php
if (!defined('_ECRIRE_INC_VERSION')) return; 
define('_EXTENSION_PHP', ''); // Ne pas chercher de .php3 !

// Pour être vraiment sûr que ce define soit utilisable dans noisettes/header/header.html avec le #EVAL
if (!defined('_DIR_LIB_SM'))
	define('_DIR_LIB_SM', _DIR_RACINE . 'lib/soundmanagerv297a-20110123/');

define('_IMG_GD_QUALITE', 95); // Haute qualité pour les images réduites ; voir http://contrib.spip.net/Astuces-SPIP 

define('_ACCESSIBILITE_CONSERVER_BULLE',true); // Pour conserver les bulles d'aide volontaire sur les liens vers les documents
define('_BONUX_STYLE',1); // http://zone.spip.org/trac/spip-zone/changeset/35480
define('_LARGEUR_MODE_IMAGE', 799); //  Voir http://permalink.gmane.org/gmane.comp.web.spip.zone/16461
define('_TITRER_DOCUMENTS', true); // Le titre des documents joints est automatiquement pris à partir du nom du fichier (avec mediatheque) ; Voir http://zone.spip.org/trac/spip-zone/changeset/41565

$GLOBALS['toujours_paragrapher'] = true;
$GLOBALS['barre_typo_pas_de_fork_typo'] = false; // Pour tenir compte de http://zone.spip.org/trac/spip-zone/changeset/22723 et disposer des raccourcis typo supplémentaires !
define('_AUTOBR', ''); // cf http://www.spip.net/fr_article5427.html (TextWheel)

// Recalculer le cache si la config du site change
$GLOBALS['marqueur'] .= ":".md5($GLOBALS['meta']['boutonstexte'].$GLOBALS['meta']['btv2'].$GLOBALS['meta']['soyezcreateurs_couleurs'].$GLOBALS['meta']['soyezcreateurs_layout'].$GLOBALS['meta']['soyezcreateurs'].$GLOBALS['meta']['soyezcreateurs_google'].$GLOBALS['meta']['bte'].$GLOBALS['meta']['nom_site'].$GLOBALS['meta']['slogan_site'].$GLOBALS['meta']['descriptif_site'].$GLOBALS['meta']['email_webmaster']); // Sur un conseil de Cedric : http://permalink.gmane.org/gmane.comp.web.spip.zone/6258
define('_TRI_GROUPES_MOTS', '0+titre,titre');  // cf http://trac.rezo.net/trac/spip/changeset/14712
define('_DUREE_CACHE_DEFAUT', 12*3600); // pris en compte à partir de http://trac.rezo.net/trac/spip/changeset/10121
define('_URLS_PROPRES_MAX', 60); // pris en compte à partire de http://trac.rezo.net/trac/spip/changeset/10346 
# FBI : si on trie sur les titre puis sur les dates, les dates ne classent que ceux qui ont le même titre ==> inutile
# TODO later : quand les rang seront gérés, 'rang, date DESC' fonctionnera
#define('_TRI_ARTICLES_RUBRIQUE', '0+titre,date DESC'); // cf http://trac.rezo.net/trac/spip/changeset/11492
define("_CLEVERMAIL_NOUVEAUTES_HTML", 'lettre_libre');
define("_CLEVERMAIL_NOUVEAUTES_TEXT", 'lettre_libre_txt');
define("_CLEVERMAIL_DISTANT", true); // Pour que CM calcule l'URL publique du squelette

define("_SIDR_PERSO", true); // Pour avoir sa propre insertion des scripts de sidr

define('_PREVIEW_TOKEN', true); // http://core.spip.org/projects/spip/repository/revisions/21077 et http://core.spip.org/projects/spip/repository/revisions/21084

// ajout SPIP 3
include_spip('inc/config');

/*
	Le truc pour disposer dans #ENV{marker_icon_name} dans les squelettes.
	Merci à ARNO* : http://permalink.gmane.org/gmane.comp.web.spip.devel/55856
*/
$_GET['marker_icon_name'] = '_Marker_icon';

$couleurs = charger_fonction('couleurs', 'inc');
$couleurs( array(
// Vert
1 => array (
		"couleur_foncee" => "#9DBA00",
		"couleur_claire" => "#C5E41C",
		"couleur_lien" => "#657701",
		"couleur_lien_off" => "#A6C113"
		),
// Violet clair
2 => array (
		"couleur_foncee" => "#eb68b3",
		"couleur_claire" => "#ffa9e6",
		"couleur_lien" => "#8F004D",
		"couleur_lien_off" => "#BE6B97"
		),
// Orange
3 => array (
		"couleur_foncee" => "#fa9a00",
		"couleur_claire" => "#ffc000",
		"couleur_lien" => "#FF5B00",
		"couleur_lien_off" => "#B49280"
		),
// Saumon
4 => array (
		"couleur_foncee" => "#CDA261",
		"couleur_claire" => "#FFDDAA",
		"couleur_lien" => "#AA6A09",
		"couleur_lien_off" => "#B79562"
		),
//  Bleu pastel
5 => array (
		"couleur_foncee" => "#5da7c5",
		"couleur_claire" => "#97d2e1",
		"couleur_lien" => "#116587",
		"couleur_lien_off" => "#81B7CD"
		),
//  Gris
6 => array (
		"couleur_foncee" => "#85909A",
		"couleur_claire" => "#C0CAD4",
		"couleur_lien" => "#3B5063",
		"couleur_lien_off" => "#6D8499"
		),
7 => array ("couleur_foncee" => "#0F7FB3",
		"couleur_claire" => "#0094d3",
		"couleur_lien" => "#116587",
		"couleur_lien_off" => "#81B7CD"
		),
// Vert de gris
8 => array (
		"couleur_foncee" => "#999966",
		"couleur_claire" => "#CCCC99",
		"couleur_lien" => "#666633",
		"couleur_lien_off" => "#999966"
		),
// Rose vieux
9 => array (
		"couleur_foncee" => "#EB68B3",
		"couleur_claire" => "#E4A7C5",
		"couleur_lien" => "#8F004D",
		"couleur_lien_off" => "#BE6B97"
		),
// Violet
10 => array (
		"couleur_foncee" => "#8F8FBD",
		"couleur_claire" => "#C4C4DD",
		"couleur_lien" => "#6071A5",
		"couleur_lien_off" => "#5C5C8C"
		),
//  Gris
11 => array (
		"couleur_foncee" => "#909090",
		"couleur_claire" => "#D3D3D3",
		"couleur_lien" => "#808080",
		"couleur_lien_off" => "#909090"
		),
));

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
define('_SUIVI_FORUM_THREAD', true);

// Se passer de |supprimer_numero partout
//$table_des_traitements['TITRE'][]= 'typo(supprimer_numero(%s), "TYPO", $connect)'; //  cf http://trac.rezo.net/trac/spip/changeset/15451
// Remplacé par un pipeline sur declarer_tables_interfaces

// Gere l'inscription aux evenements
// cf http://zone.spip.org/trac/spip-zone/changeset/33103
include_spip('inc/config');
$GLOBALS['agenda_affiche_inscription'] = (lire_config('soyezcreateurs/agenda_inscription', '') == 'on') ? 'oui' : 'non';

// http://www.weblog.eliaz.fr/article38.html Pour mettre une version plus récente de jQuery
$GLOBALS['spip_pipeline']['insert_head'] = str_replace('|f_jQuery', '', $GLOBALS['spip_pipeline']['insert_head']);

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

######## PACK ACTUEL DE CONFIGURATION DU COUTEAU SUISSE #########
// Attention, les surcharges sur les define() ou les globales ne sont pas specifiees ici
$GLOBALS['cs_installer']['SoyezCreateurs'] = 'cs_SoyezCreateurs';

function cs_SoyezCreateurs() { return array(
	// Installation des outils par défaut
	'outils' =>
		'boites_privees,
		citations_bb,
		typo_exposants,
		guillemets,
		mailcrypt,
		insertions,
		corbeille,
		spip_ecran',

	// Installation des variables par défaut
	'variables' => array(
		'expo_bofbof' => 1,
		'decoration_styles' => 'span.surfluo = background-color:#ffff00; padding:0px 2px;
span.surgris = background-color:#EAEAEC; padding:0px 2px;
fluo = surfluo',
		'pp_edition_decoration' => 1,
		'pp_forum_decoration' => 1,
		'spip_ecran' => 'large',
		'insertions' => 'oeuf = &oelig;uf
cceuil = ccueil
(a priori) = {a priori}
(([hH])uits) = $1uit
/([cC]h?)oeur/ = $1&oelig;ur
/oeuvre/ = &oelig;uvre
(O[Ee]uvre([rs]?)) = &OElig;uvre$1
/\\b([cC]|[mM].c|[rR]ec)on+ais+a((?:n(?:ce|te?)|ble)s?)\\b/ = $1onnaissa$2
CO2 = <abbr title="CO2, Dioxyde de carbone, O=C=O">CO<sub>2</sub></abbr>
oeil = &oelig;il
(O[Ee]il) = &OElig;il',
		'cs_rss' => 0,
		'format_spip' => 0,
		'stat_auteurs' => 1,
		'qui_webmasters' => 1,
		'bp_urls_propres' => 1,
		'bp_tri_auteurs' => 1
	)
);
}

?>
