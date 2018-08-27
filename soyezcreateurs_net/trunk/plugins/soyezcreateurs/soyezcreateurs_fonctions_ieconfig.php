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
function sc_ieconfig_importer_fichier($chemin,$option) {
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

			//Si on veut une importation avec écrasement
			if ($option === 'ecrase') {
				
				if (isset($data['metas_brutes'])) {
					foreach (explode(',', $data['metas_brutes']) as $meta) {
						// On teste le cas ou un prefixe est indique (dernier caractere est *)
						if (substr($meta, -1) == '*') {
							$p = substr($meta, 0, -1);
							foreach ($config[$prefixe] as $m => $v) {
								if (substr($m, 0, strlen($p)) == $p) {
									ecrire_config($m . '/', $v);
								}
							}
						} elseif (isset($config[$prefixe][$meta])) {
							ecrire_config($meta . '/', $config[$prefixe][$meta]);
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
									ecrire_config($m . '/', serialize($v));
								}
							}
						} elseif (isset($config[$prefixe][$meta])) {
							ecrire_config($meta . '/', serialize($config[$prefixe][$meta]));
						}
					}
				}
			}
			//Si on veut une importation avec fusion
			if ($option === 'fusion') {
				
				if (isset($data['metas_brutes'])) {
					foreach (explode(',', $data['metas_brutes']) as $meta) {
						// On teste le cas ou un prefixe est indique (dernier caractere est *)
						if (substr($meta, -1) == '*') {
							$p = substr($meta, 0, -1);
							foreach ($config[$prefixe] as $m => $v) {
								if (substr($m, 0, strlen($p)) == $p) {
									$save = lire_config($m . '/', $v);
									$import = ($v);
									$import = array_merge($save,$import);
									ecrire_config($m . '/', $v);
								}
							}
						} elseif (isset($config[$prefixe][$meta])) {
							$save = lire_config($meta . '/', $config[$prefixe][$meta]);
							$import = ($config[$prefixe][$meta]);							
							$import = array_merge($save,$import);
							ecrire_config($meta . '/', $import);
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
									$save = lire_config($m . '/', serialize($v));
									$import = ($v);
									$import = array_merge($save,$import);
									ecrire_config($m . '/', serialize($import));				
								}
							}
						} elseif (isset($config[$prefixe][$meta])) {
							$save = lire_config($meta . '/', serialize($config[$prefixe][$meta]));
							$import = ($config[$prefixe][$meta]);
							$import = array_merge($save,$import);
							ecrire_config($meta . '/', serialize($import));
						}
					}
				}
			}
			//Si on veut une importation avec fusion_inv
			if ($option === 'fusion_inv') {

				if (isset($data['metas_brutes'])) {
					foreach (explode(',', $data['metas_brutes']) as $meta) {
						// On teste le cas ou un prefixe est indique (dernier caractere est *)
						if (substr($meta, -1) == '*') {
							$p = substr($meta, 0, -1);
							foreach ($config[$prefixe] as $m => $v) {
								if (substr($m, 0, strlen($p)) == $p) {
									$save = lire_config($m . '/', $v);
									$import = ($v);
									$import = array_merge($import,$save);
									ecrire_config($m . '/', $import);
								}
							}
						} elseif (isset($config[$prefixe][$meta])) {
							$save = lire_config($meta . '/', $config[$prefixe][$meta]);
							$import = ($config[$prefixe][$meta]);							
							$import = array_merge($import,$save);
							ecrire_config($meta . '/', $import);
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
									$save = lire_config($m . '/', serialize($v));
									$import = ($v);
									$import = array_merge($import,$save);
									ecrire_config($m . '/', serialize($import));
								}
							}
						} elseif (isset($config[$prefixe][$meta])) {
							$save = lire_config($meta . '/', serialize($config[$prefixe][$meta]));
							$import = ($config[$prefixe][$meta]);
							$import = array_merge($import,$save);
							ecrire_config($meta . '/', serialize($import));
						}
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

