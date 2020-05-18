<?php

// Liste des pages de configuration dans l'ordre de presentation
// Librement inspiré du squelette Sarkaspip
if (!defined('_ESCAL_PAGES_CONFIG')) define('_ESCAL_PAGES_CONFIG',
'accueil
|generalites!meta:layout:elements:bandeau:menuh:multilinguisme:pied
|colonne_principale!sommaire_principal:rubrique_principal:article_principal:contact_principal:forumsite_principal
|choix_blocs!sommaire_lateral:rubrique_lateral:article_lateral:forumsite_lateral:autres_lateral
|parametrage_blocs!deplier_replier:titre_contenu
|style!fonds:bords:arrondis
|plugins!galleria:rainette:mentions:articlepdf:spipdf:licence:spip400:socialtags:liens_sociaux:qrcode:facebook:signalement:shoutbox
');

	// Header prive
	 if (isset($GLOBALS['spip_pipeline']['header_prive'])) {
    $GLOBALS['spip_pipeline']['header_prive'] .= "|header_prive_perso";
	 } else {
    $GLOBALS['spip_pipeline']['header_prive'] = "header_prive_perso";
	 }
    function header_prive_perso($flux) {
        return $flux .= '
    	<link rel="stylesheet" type="text/css" href="'.find_in_path('styles/prive_perso.css').'" media="all" />
    	';
    }

// surlignage des recherches
if (isset($_REQUEST['recherche'])) {
  $_GET['var_recherche'] = $_REQUEST['recherche'];
}
define('_SURLIGNE_RECHERCHE_REFERERS',true);

// les images de plus de 2000 pixels de largeur ou de hauteur ne seront pas enregistrées
define('_IMG_MAX_WIDTH', lire_config('escal/config/imgmax',1000) );
define('_IMG_MAX_HEIGHT', lire_config('escal/config/imgmax',1000) );

// Et pour éviter de faire planter GD2 :
 define('_IMG_GD_MAX_PIXELS', 2000000);


// forcer l'écran large dans l'espace privé
$GLOBALS['spip_ecran']=$_COOKIE['spip_ecran']='large';

// récupération de l'url du site
// pour redéfinir la fonction inc_lien dans escal_options
// un grand merci à l'auteur : bobof

define('_SITE', $GLOBALS['meta']['adresse_site']); // récupère l'url du site déclarée dans l'espace privé > configuration > Adresse (URL) du site public
$url_el = parse_url($GLOBALS['meta']['adresse_site']);
$hote = $url_el['host'];
$hote_el  = explode('.', $hote);
$nb_el = count($hote_el);
$domaine = $hote_el[$nb_el - 2] . '.' . $hote_el[$nb_el - 1];
define('_DOMAINE_SITE', $domaine); // extrait dans l'url du site le nom du domaine pleinement qualifié sous la forme domaine.tld

// proteger le #FORMULAIRE_CONTACT
$GLOBALS['formulaires_no_spam'][] = 'contact';

// multilinguisme

$forcer_lang = true;

 /**
 * une fonction qui regarde si $texte est une chaine de langue
 * de la forme <:qqch:>
 * si oui applique _T()
 * si non applique typo() suivant le mode choisi
 *
 * @param unknown_type $valeur Une valeur à tester. Si c'est un tableau, la fonction s'appliquera récursivement dessus.
 * @param string $mode_typo Le mode d'application de la fonction typo(), avec trois valeurs possibles "toujours", "jamais" ou "multi".
 * @return unknown_type Retourne la valeur éventuellement modifiée.
 */
if (!function_exists('_T_ou_typo')){
function _T_ou_typo($valeur, $mode_typo='toujours') {

	// Si la valeur est bien une chaine (et pas non plus un entier déguisé)
	if (is_string($valeur) and !intval($valeur)){
		// Si la chaine est du type <:truc:> on passe à _T()
		if (preg_match('/^\<:(.*?):\>$/', $valeur, $match))
			$valeur = _T($match[1]);
		// Sinon on la passe a typo()
		else {
			if (!in_array($mode_typo, array('toujours', 'multi', 'jamais')))
				$mode_typo = 'toujours';

			if ($mode_typo == 'toujours' or ($mode_typo == 'multi' and strpos($valeur, '<multi>') !== false)){
				include_spip('inc/texte');
				$valeur = typo($valeur);
			}
		}
	}
	// Si c'est un tableau, on reapplique la fonction récursivement
	elseif (is_array($valeur)){
		foreach ($valeur as $cle => $valeur2){
			$valeur[$cle] = _T_ou_typo($valeur2, $mode_typo);
		}
	}

	return $valeur;

}
}

