<?php

// Liste des pages de configuration dans l'ordre de presentation
// Librement inspir� du squellete Sarkaspip
if (!defined('_ESCAL_PAGES_CONFIG')) define('_ESCAL_PAGES_CONFIG',
'accueil
|G&eacute;n&eacute;ralit&eacute;s!meta:layout:elements:bandeau:menu:niveaumenu:pied
|La page d\'accueil!sommaire_corps:sommaire_colonnes:sommaire_noisettes
|Les pages internes!rubrique:article:contact:pages_noisettes
|Un peu de style!fonds:textes:bords:arrondis
|Des plugins dans Escal!galleria:rainette:mentions:licence:spip400:socialtags:facebook
');

// les images de plus de 700 pixels de large ne seront pas enregistr�es
define('_IMG_MAX_WIDTH', 700);


// r�cup�ration de l'url du site
// pour red�finir la fonction inc_lien dans escal_options
// un grand merci � l'auteur : bobof

define('_SITE', $GLOBALS['meta']['adresse_site']); // r�cup�re l'url du site d�clar�e dans l'espace priv� > configuration > Adresse (URL) du site public
$url_el = parse_url($GLOBALS['meta']['adresse_site']);
$hote = $url_el['host'];
$hote_el  = explode('.', $hote);
$nb_el = count($hote_el);
$domaine = $hote_el[$nb_el - 2] . '.' . $hote_el[$nb_el - 1];
define('_DOMAINE_SITE', $domaine); // extrait dans l'url du site le nom du domaine pleinement qualifi� sous la forme domaine.tld



// multilinguisme

$forcer_lang = true;

 /**
 * une fonction qui regarde si $texte est une chaine de langue
 * de la forme <:qqch:>
 * si oui applique _T()
 * si non applique typo() suivant le mode choisi
 *
 * @param unknown_type $valeur Une valeur � tester. Si c'est un tableau, la fonction s'appliquera r�cursivement dessus.
 * @param string $mode_typo Le mode d'application de la fonction typo(), avec trois valeurs possibles "toujours", "jamais" ou "multi".
 * @return unknown_type Retourne la valeur �ventuellement modifi�e.
 */
if (!function_exists('_T_ou_typo')){
function _T_ou_typo($valeur, $mode_typo='toujours') {

	// Si la valeur est bien une chaine (et pas non plus un entier d�guis�)
	if (is_string($valeur) and !intval($valeur)){
		// Si la chaine est du type <:truc:> on passe � _T()
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
	// Si c'est un tableau, on reapplique la fonction r�cursivement
	elseif (is_array($valeur)){
		foreach ($valeur as $cle => $valeur2){
			$valeur[$cle] = _T_ou_typo($valeur2, $mode_typo);
		}
	}

	return $valeur;

}
}


?>