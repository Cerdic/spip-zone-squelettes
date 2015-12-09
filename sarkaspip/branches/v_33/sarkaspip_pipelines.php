<?php
/**
 * Squelette SarkaSPIP v3
 * (c) 2005-2015 Licence GPL 3.
 */
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Post-propre : appliquer le filtre des couleurs typo_couleur automatiquement.
 *
 * @param string $texte
 *
 * @return mixed
 */
function sarkaspip_post_propre($texte) {
	$coloriser = charger_filtre('typo_couleur');
	$texte = $coloriser($texte);

	return $texte;
}

/**
 * Pipeline "mes_fichiers_a_sauver" permettant de rajouter des fichiers a sauvegarder dans le plugin Mes Fichiers 2.
 *
 * @param $flux
 *
 * @return array
 */
function sarkaspip_mes_fichiers_a_sauver($flux) {
	$tmp_fonds = defined('_DIR_TMP') ? _DIR_TMP.'fonds/' : _DIR_RACINE.'tmp/fonds/';
	$tmp_styles = defined('_DIR_TMP') ? _DIR_TMP.'/sarkaspip/config/' : _DIR_RACINE.'tmp/sarkaspip/config/';

	// le repertoire des images de fonds pour les styles
	if (@is_dir($tmp_fonds)) {
		$flux[] = $tmp_fonds;
	}
	// le repertoire sauvegardes du cfg des styles
	if (@is_dir($tmp_styles)) {
		$flux[] = $tmp_styles;
	}

	spip_log('*** sarkaspip_mes_fichiers_a_sauver ***');
	spip_log($flux);

	return $flux;
}

/**
 * Pipeline "zengarden_activer_theme" permettant d'effectuer les traitements d'activation d'un theme lies a Sarka-SPIP.
 *
 * @param $flux
 *
 * @return array
 */
function sarkaspip_zengarden_activer_theme($flux) {
	$dir = $flux['args']['dir'];
	$action = $flux['args']['action'];

	$dir_cfg = $dir.'/cfg';
	$cfg = preg_files($dir_cfg);

	include_spip('inc/config');

	if ($action == 'activer') {
		// On sauvegarde des valeurs actuelles pour un eventuel rappel
		$dir_cfg = sous_repertoire(_DIR_TMP, 'cfg');
		$dir_cfg = sous_repertoire(_DIR_TMP, 'themes');
		$fonds = array();
		foreach ($cfg as $_fichier_cfg) {
			$fonds[] = basename($_fichier_cfg, '.txt');
		}
		include_spip('inc/sarkaspip_filtres');
		$ok = sauvegarder_fonds($fonds, $dir_cfg, 'theme');

		// On ecrit la nouvelle configuration n�cessaire au theme choisi
		$flux['data'] = true;
		foreach ($cfg as $_fichier_cfg) {
			lire_fichier($_fichier_cfg, $tableau);
			$fond = basename($_fichier_cfg, '.txt');
			ecrire_config($fond, $tableau);
		}
	} elseif ($action == 'effacer') {
		$fichiers = array();
		$flux['data'] = true;
		foreach ($cfg as $_fichier_cfg) {
			$fond = basename($_fichier_cfg, '.txt');
			effacer_config($fond);
			$fichiers[] = _DIR_TMP.'themes/cfg/'.$fond.'.txt';
		}
		include_spip('inc/sarkaspip_filtres');
		$ok = restaurer_fonds($fichiers);
	} else {
		// action apercevoir : on ne fait rien, on sait pas faire..
	}

	return $flux;
}

// -- Fonction d'affichage des noisettes
function sarkaspip_afficher_noisettes($define, $flux, $ajax = true) {
	$noisettes = explode(':', $define);
	foreach ($noisettes as $_fond) {
		if (find_in_path($_fond.'.html')) {
			$contexte = $ajax ? array_merge($flux['args'], array('ajax' => true)) : $flux['args'];
			$html = recuperer_fond($_fond, $contexte);
			$flux['data'] .= $html;
		} else {
			$flux['data'] .= '<div class="noisette avertissement" style="margin-top: 0; font-size: 0.95em">'._T('sarkaspip:msg_fichier_introuvable', array('fichier' => $_fond.'.html')).'</div>';
		}
	}

	return $flux;
}
// -- Fonction d'insertion en debut de colonne extra
function sarkaspip_personnaliser_colonne_extra_debut($flux) {
	if (defined('_PERSO_COLONNE_EXTRA_DEBUT')) {
		$flux = sarkaspip_afficher_noisettes(_PERSO_COLONNE_EXTRA_DEBUT, $flux, true);
	}

	return $flux;
}
// -- Fonction d'insertion en fin de colonne extra
function sarkaspip_personnaliser_colonne_extra_fin($flux) {
	if (defined('_PERSO_COLONNE_EXTRA_FIN')) {
		$flux = sarkaspip_afficher_noisettes(_PERSO_COLONNE_EXTRA_FIN, $flux, true);
	}

	return $flux;
}
// -- Fonction d'insertion en debut de colonne navigation
function sarkaspip_personnaliser_colonne_navigation_debut($flux) {
	if (defined('_PERSO_COLONNE_NAVIGATION_DEBUT')) {
		$flux = sarkaspip_afficher_noisettes(_PERSO_COLONNE_NAVIGATION_DEBUT, $flux, true);
	}

	return $flux;
}
// -- Fonction d'insertion en fin de colonne navigation
function sarkaspip_personnaliser_colonne_navigation_fin($flux) {
	if (defined('_PERSO_COLONNE_NAVIGATION_FIN')) {
		$flux = sarkaspip_afficher_noisettes(_PERSO_COLONNE_NAVIGATION_FIN, $flux, true);
	}

	return $flux;
}
// -- Fonction d'insertion en fin de menu des pages speciales
function sarkaspip_personnaliser_menu_pages_speciales_fin($flux) {
	if (defined('_PERSO_MENU_PAGES_SPECIALES_FIN')) {
		$flux = sarkaspip_afficher_noisettes(_PERSO_MENU_PAGES_SPECIALES_FIN, $flux, false);
	}

	return $flux;
}
// -- Fonction d'insertion en debut de bandeau haut
function sarkaspip_personnaliser_bandeau_haut_debut($flux) {
	if (defined('_PERSO_BANDEAU_HAUT_DEBUT')) {
		$flux = sarkaspip_afficher_noisettes(_PERSO_BANDEAU_HAUT_DEBUT, $flux, false);
	}

	return $flux;
}
// -- Fonction d'insertion en fin de bandeau haut
function sarkaspip_personnaliser_bandeau_haut_fin($flux) {
	if (defined('_PERSO_BANDEAU_HAUT_FIN')) {
		$flux = sarkaspip_afficher_noisettes(_PERSO_BANDEAU_HAUT_FIN, $flux, false);
	}

	return $flux;
}
// -- Fonction d'insertion en debut de bandeau bas
function sarkaspip_personnaliser_bandeau_bas_debut($flux) {
	if (defined('_PERSO_BANDEAU_BAS_DEBUT')) {
		$flux = sarkaspip_afficher_noisettes(_PERSO_BANDEAU_BAS_DEBUT, $flux, false);
	}

	return $flux;
}
// -- Fonction d'insertion en fin de bandeau bas
function sarkaspip_personnaliser_bandeau_bas_fin($flux) {
	if (defined('_PERSO_BANDEAU_BAS_FIN')) {
		$flux = sarkaspip_afficher_noisettes(_PERSO_BANDEAU_BAS_FIN, $flux, false);
	}

	return $flux;
}
// -- Fonction d'insertion en debut de pied
function sarkaspip_personnaliser_pied_debut($flux) {
	if (defined('_PERSO_PIED_DEBUT')) {
		$flux = sarkaspip_afficher_noisettes(_PERSO_PIED_DEBUT, $flux, false);
	}

	return $flux;
}
// -- Fonction d'insertion en fin de pied
function sarkaspip_personnaliser_pied_fin($flux) {
	if (defined('_PERSO_PIED_FIN')) {
		$flux = sarkaspip_afficher_noisettes(_PERSO_PIED_FIN, $flux, false);
	}

	return $flux;
}
