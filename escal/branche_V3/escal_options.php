<?php

// Pour surligner les mots recherch�s dans un article
define('_SURLIGNE_RECHERCHE_REFERERS',true);

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


// on limite la taille des images

define('_IMG_MAX_WIDTH', 500) ;
define('_IMG_MAX_HEIGHT', 500) ;
define('_IMG_MAX_SIZE', 350);




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