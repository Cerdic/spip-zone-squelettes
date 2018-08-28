<?php

/*
 *   +----------------------------------+
 *    Fonctions relatives à ieconfig
 *   +----------------------------------+
 *    Date : Juin-juillet 2018
 *    Auteur :  RIEDELAndreas
*/


/*Fonction permettant une importation de configuration en spécifiant le chemin du fichier et l'action à accomplir
/*@param $chemin : chemin du fichier à importer
/*@param $option : option à appliquer 
/*Type d'option : 
/*	- 'rien' : Ne rien faire
/*	- 'ecrasement' : Écraser complètement la configuraion actuel, les paramètres non renseigné dans le fichier d'importation sont remis à default
/*	- 'fusion' : Fusionner la configuration actuelle avec le fichier d'importation, les paramètres non renseignés dans le fichier d'importation sont conservés
/*	- 'fusion_inv' : Fusionner la configuration actuelle avec le fichier d'importation, les paramètres renseignés dans le fichier d'importation sont ignorés s'il sont présent dans la configuration actuelle
*/
function sc_ieconfig_importer_fichier($chemin, $option = 'ecrase') {
	include_spip('inc/yaml');
	$config = yaml_decode_file($chemin);
	
	// On passe via le pipeline ieconfig
	$message_erreur = pipeline('ieconfig', array(
		'args' => array(
			'action' => 'import',
			'config' => $config,
		),
		'data' => '',
	));

	// Gestion des plugins utilisant le pipeline ieconfig_metas
	foreach (pipeline('ieconfig_metas', array()) as $prefixe => $data) {
		if (isset($data['metas_brutes'])) {
			foreach (explode(',', $data['metas_brutes']) as $meta) {
				// On teste le cas ou un prefixe est indique (dernier caractere est *)
				if (substr($meta, -1) == '*') {
					$p = substr($meta, 0, -1);
					foreach ($config[$prefixe] as $m => $v) {
						if (substr($m, 0, strlen($p)) == $p) {
							if (($option === 'ecrase') OR ($option === 'fusion')) {
								ecrire_config($m);
							}
							if ($option === 'fusion_inv') {
								if (is_null(lire_config($m . '/'))) {
									ecrire_config($m . '/', $v);
								}
							}
						}
					}
				} elseif (isset($config[$prefixe][$meta])) {
					if (($option === 'ecrase') OR ($option === 'fusion')) {
						ecrire_config($meta . '/', $config[$prefixe][$meta]);
					}
					if ($option === 'fusion_inv') {
						if (is_null(lire_config($meta . '/'))) {
							ecrire_config($meta . '/', $config[$prefixe][$meta]);
						}
					}
				}
			}
		}
		if (isset($data['metas_serialize'])) {
			foreach (explode(',', $data['metas_serialize']) as $meta) {
				// On teste le cas ou un prefixe est indique (dernier caractere est *)
				if (substr($meta, -1) == '*') {
					$p = substr($meta, 0, -1);
					foreach ($config[$prefixe] as $m => $v) {
						if (substr($m, 0, strlen($p)) == $p) {
							$import = array();
							if ($option === 'ecrase') {
								$import = $v;
							}
							if ($option === 'fusion') {
								$import = array_merge(lire_config($m . '/'), $v);
							}
							if ($option === 'fusion_inv') {
								$import_plus = array_diff_key($v, lire_config($meta . '/'));
								$import_base = array_diff_key(lire_config($meta . '/'), $import_plus);
								$import = (array_merge($import_plus, $import_base));
							}
							ksort($import);
							ecrire_config($m . '/', serialize($import));
						}
					}
				} elseif (isset($config[$prefixe][$meta])) {
					$import = array();
					if ($option === 'ecrase') {
						$import = $config[$prefixe][$meta];
					}
					if ($option === 'fusion') {
						$import = array_merge(lire_config($meta . '/'), $config[$prefixe][$meta]);
					}
					if ($option === 'fusion_inv') {
						$import_plus = array_diff_key($config[$prefixe][$meta], lire_config($meta . '/'));
						$import_base = array_diff_key(lire_config($meta . '/'), $import_plus);
						$import = (array_merge($import_plus, $import_base));
					}
					ksort($import);
					ecrire_config($meta . '/', serialize($import));
				}
			}
		}
	}

	if ($message_erreur != '') {
		return array('message_erreur' => $message_erreur);
	} else {
		return array('message_ok' => _T('ieconfig:message_ok_import'));
	}
}

