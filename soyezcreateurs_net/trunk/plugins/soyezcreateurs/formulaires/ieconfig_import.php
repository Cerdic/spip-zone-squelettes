<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function ieconfig_metas_liste($prefixeaimporter = null) {
	static $ieconfig_metas;
	if (!is_array($ieconfig_metas)) {
		$ieconfig_metas = array();
		include_spip('inc/yaml');
		$config = yaml_decode(_request('_code_yaml'));
		
		foreach (pipeline('ieconfig_metas', array()) as $prefixe => $data) {
			if (isset($config[$prefixe])) {
				if (!isset($prefixeaimporter) 
					OR 
					(isset($prefixeaimporter) && $prefixe === $prefixeaimporter)
					) {
					if (isset($data['icone'])) {
						$icone = chemin_image($data['icone']);
						if (!$icone) {
							$icone = find_in_path($data['icone']);
						}
						if ($icone) {
							$icone = '<img src="' . $icone . '" alt="" style="margin-left:-50px; margin-right:34px;" />';
						}
					} else {
						$icone = 'config-export-16.png';
					}
					$ieconfig_metas[$prefixe] = $icone . (isset($data['titre']) ? $data['titre'] : $prefixe);
				}
			}
		}
	}
	return $ieconfig_metas;
}

function ieconfig_saisies_import($prefixeaimporter = null) {
	// Etape de selection du fichier
	if (!_request('_code_yaml') or _request('annuler') or _request('importer')) {
		$saisies = array(
			array(
				'saisie' => 'fieldset',
				'options' => array(
					'nom' => 'ieconfig_import_choix_fichier',
					'label' => '<:ieconfig:label_ieconfig_import_choix_fichier:>',
					'icone' => 'img/ieconfig-import.png',
				),
				'saisies' => array(
					array(
						'saisie' => 'input',
						'options' => array(
							'type' => 'file',
							'nom' => 'ieconfig_import_fichier',
							'label' => '<:ieconfig:label_ieconfig_import_fichier:>',
							'explication' => '<:ieconfig:explication_ieconfig_import_fichier:>',
						),
					),
					array(
						'saisie' => 'selection',
						'options' => array(
							'type' => 'selection',
							'nom' => 'ieconfig_import_local',
							'label' => '<:ieconfig:label_ieconfig_import_local:>',
							'explication' => '<:ieconfig:explication_ieconfig_import_local:>',
							'datas' => ieconfig_config_locales($prefixeaimporter),
						),
					),
					array(
						'saisie' => 'radio',
						'options' => array(
							'nom' => 'import_methode',
							'label' => '<:ieconfig:ieconfig_import:>',
							'datas' => array(
								'fusion' => '<:ieconfig:ieconfig_import_fusionner:>',
								'fusion_inv' => '<:ieconfig:ieconfig_import_fusionner_inv:>',
								'ecrase' => '<:ieconfig:ieconfig_import_ecraser:>',
								),
							'defaut' => 'fusion',
						),
					),
				),
			),
		);
		// Options d'importations
	} else {
		include_spip('inc/yaml');
		$config = yaml_decode(_request('_code_yaml'));
		$texte_explication = '<b>' . _T('ieconfig:texte_nom') . '</b> ' . _T_ou_typo($config['nom']);
		if ($config['description'] != '') {
			$texte_explication .= '<br /><b>' . _T('ieconfig:texte_description') . '</b> ' . _T_ou_typo($config['description']);
		}
		// On identifie les entrées ne correspondant pas à un plugin
		// Ou bien non déclarées dans ieconfig_metas
		// Convention : les clés du tableau de config correspondent aux préfixes des plugins
		$entrees = $config;
		unset($entrees['nom']);
		unset($entrees['description']);
		unset($entrees['necessite']);
		$entrees = array_map('strtolower', array_keys($entrees));
		$plugins = array_map('strtolower', array_keys(unserialize($GLOBALS['meta']['plugin'])));
		$entrees_prises_en_charge = array_merge(array_keys(pipeline('ieconfig_metas', array())), $plugins);
		$plugins_manquants = array_diff($entrees, $entrees_prises_en_charge);
		if (count($plugins_manquants) > 0) {
			$texte_explication .= '<p class="reponse_formulaire reponse_formulaire_erreur">' . _T('ieconfig:texte_plugins_manquants', array('plugins' => implode(', ', $plugins_manquants))) . '</p>';
		}


		// Gestion des plugins utilisant le pipeline ieconfig_metas
		$ieconfig_metas = ieconfig_metas_liste($prefixeaimporter);
		if (count($ieconfig_metas) > 1) {
			$saisies = array(
				array(
					'saisie' => 'explication',
					'options' => array(
						'nom' => 'import_details',
						'texte' => $texte_explication,
					),
				),
			);
			$saisies[] = array(
				'saisie' => 'fieldset',
				'options' => array(
					'nom' => 'metas_fieldset',
					'label' => _T('ieconfig:label_importer_metas').' ('._request('import_methode').')',
					'icone' => 'config-export-16.png',
				),
				'saisies' => array(
					array(
						'saisie' => 'checkbox',
						'options' => array(
							'nom' => 'import_metas',
							'label' => _T('ieconfig:label_importer'),
							'tout_selectionner' => (count($ieconfig_metas) > 1) ? 'oui':'',
							'datas' => $ieconfig_metas,
						),
					),
					array(
						'saisie' => 'hidden',
						'options' => array(
							'default' => _request('import_methode'),
							'nom' => 'import_methode',
							'label' => 'import_methode',
						),
					),
				)
			);
		}
		
		// On passe via le pipeline ieconfig
		$saisies = pipeline('ieconfig', array(
			'args' => array(
				'action' => 'form_import',
				'config' => $config,
			),
			'data' => $saisies,
		));
	}
	return $saisies;
}

function formulaires_ieconfig_import_charger_dist($prefixeaimporter = null) {
	include_spip('inc/saisies');
	$saisies = ieconfig_saisies_import($prefixeaimporter);
	$contexte = array(
		'_saisies' => $saisies,
	);
	if (_request('_code_yaml') and !_request('annuler') and !_request('importer')) {
		$contexte['_code_yaml'] = _request('_code_yaml');
	}
	

	return array_merge(saisies_charger_champs($saisies), $contexte);
}

function formulaires_ieconfig_import_verifier_dist($prefixeaimporter = null) {
	$erreurs = array();
	// Etape de selection du fichier
	if (!_request('_code_yaml')) {
		// On a rien transmis et pas de fichier local
		if (!_request('ieconfig_import_local') and $_FILES['ieconfig_import_fichier']['name'] == '') {
			$erreurs['message_erreur'] = _T('ieconfig:message_erreur_fichier_import_manquant');
		}
	} // Options d'import
	else {
		include_spip('inc/saisies');
		$erreurs = saisies_verifier(ieconfig_saisies_import($prefixeaimporter));
	}

	return $erreurs;
}

function formulaires_ieconfig_import_traiter_dist($prefixeaimporter = null) {

	include_spip('inc/config');
	// Si on est à l'étape de sélection d'un fichier de configuration
	// On place le code YAML dans le contexte
	if (!_request('_code_yaml')) {
		if ($_FILES['ieconfig_import_fichier']['name'] != '') {
			$dir = sous_repertoire(_DIR_TMP, 'ieconfig');
			$hash = md5('ieimport-' . $GLOBALS['visiteur_session']['id_auteur'] . time());
			$fichier = $dir . $hash . '-' . $_FILES['ieconfig_import_fichier']['name'];
			move_uploaded_file($_FILES['ieconfig_import_fichier']['tmp_name'], $fichier);
			lire_fichier($fichier, $code_yaml);
			@unlink($fichier);
		} else {
			$fichier = _request('ieconfig_import_local');
			lire_fichier($fichier, $code_yaml);
		}
		set_request('_code_yaml', $code_yaml);
	} // Si on valide l'import
	$ieconfig_metas = ieconfig_metas_liste($prefixeaimporter);
	if (((count($ieconfig_metas) == 1) OR _request('importer')) && _request('_code_yaml')) {
		include_spip('inc/yaml');
		$config = yaml_decode(_request('_code_yaml'));

		// On passe via le pipeline ieconfig
		$message_erreur = pipeline('ieconfig', array(
			'args' => array(
				'action' => 'import',
				'config' => $config,
			),
			'data' => '',
		));

		if (count($ieconfig_metas) == 1) {
			$import_metas = array(key($ieconfig_metas));
		} else {
			$import_metas = _request('import_metas');
		}
		if (!is_array($import_metas)) {
			$import_metas = array();
		}
		// Gestion des plugins utilisant le pipeline ieconfig_metas
		$option = _request('import_methode');
		$config_importee = '';
		foreach (pipeline('ieconfig_metas', array()) as $prefixe => $data) {
			if (in_array($prefixe, $import_metas) && isset($config[$prefixe])) {
				$config_importee .= $prefixe . ' ';
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
		}

		if ($message_erreur != '') {
			return array('message_erreur' => $message_erreur);
		} else {
			return array('message_ok' => _T('ieconfig:message_ok_import') . " ($option / $config_importee)");
		}
	}
}

// Renvoie la liste des fichiers de configurations présents dans un sous-répertoires ieconfig/
function ieconfig_config_locales($prefixeaimporter = null) {
	static $liste_config = null;

	if (is_null($liste_config)) {
		include_spip('inc/yaml');
		$liste_config = array();
		$match = '.+[.]yaml$';
		foreach (array_merge(find_all_in_path('ieconfig/', $match), find_all_in_path(_DIR_TMP . 'ieconfig/', $match)) as $fichier => $chemin) {
			$config = yaml_decode_file($chemin);
			// On regarde s'il y a un necessite
			$ok = true;
			if (isset($config['necessite'])) {
				if (!is_array($config['necessite'])) {
					$config['necessite'] = array($config['necessite']);
				}
				foreach ($config['necessite'] as $plugin) {
					if (!defined('_DIR_PLUGIN_' . strtoupper($plugin))) {
						$ok = false;
					}
				}
			}
			if (isset($prefixeaimporter) AND !isset($config[$prefixeaimporter])) {
				$ok = false;
			}
			//on vérifie s'il y a un champs nom
			if ($ok) {
				if (isset($config['nom'])) {
					$liste_config[$chemin] = _T_ou_typo($config['nom']);
				} else {
					$liste_config[$chemin] = $fichier;
				}
			}
		}
	}
	sort($liste_config);
	return $liste_config;
}
