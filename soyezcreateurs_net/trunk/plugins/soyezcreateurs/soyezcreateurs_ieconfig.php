<?php
	
	function soyezcreateurs_ieconfig($flux){
		$action = $flux['args']['action'];
		
		//formulaire d'export
		if ($action == 'form_export'){
			$saisies = array(
			array(
				'saisie' => 'fieldset',
				'options' => array(
					'nom' => 'soyezcreateurs_export',
					'label' => '<:soyezcreateurs:soyezcreateurs:>',
					'icone' => 'soyezcreateurs-16.png',
				),
				'saisies' => array(
					array(
						'saisie' => 'explication',
						'options' => array(
							'nom' => 'soyezcreateurs_export_explication',
							'texte' => '<:soyezcreateursprive:ieconfig_soyezcreateurs_export_explication:>',
						),
					),
					array(
						'saisie' => 'oui_non',
						'options' => array(
							'nom' => 'soyezcreateurs_export_option',
							'label' => '<:soyezcreateursprive:ieconfig_soyezcreateurs_export_option:>',
							'defaut' => '',
						),
					),
					array(
						'saisie' => 'checkbox',
						'options' => array(
							'nom' => 'soyezcreateurs_export_choix',
							'label' => '<:soyezcreateursprive:ieconfig_soyezcreateurs_export_option_choix:>',
							'data' => array(
								'soyezcreateurs' => '<:soyezcreateursprive:soyezcreateurs_export_soyezcreateurs:>',
								'soyezcreateurs_layout' => '<:soyezcreateursprive:soyezcreateurs_export_soyezcreateurs_layout:>',
								'soyezcreateurs_couleurs' => '<:soyezcreateursprive:soyezcreateurs_export_soyezcreateurs_couleurs:>',
								'soyezcreateurs_google' => '<:soyezcreateursprive:soyezcreateurs_export_soyezcreateurs_google:>',
							),
							'defaut' => 'soyezcreateurs',
						),
						
							
					),
				),
			),
		);
		$flux['data'] = array_merge($flux['data'], $saisies);
		}
		
		
		// Tableau d'export
		if ($action == 'export' && _request('soyezcreateurs_export_option') == 'on') {
			include_spip('soyezcreateurs_fonctions_ieconfig');
			
			$flux['data']['soyezcreateurs'] = soyezcreateurs_tableau_export(_request('soyezcreateurs_export_choix'));
		}
		
		// Formulaire d'import
			if ($action == 'form_import' && isset($flux['args']['config']['soyezcreateurs'])) {				
			$saisies = array(
					array(
						'saisie' => 'fieldset',
						'options' => array(
							'nom' => 'soyezcreateurs_import',
							'label' => '<:soyezcreateursprive:soyezcreateurs:>',
							'icone' => 'soyezcreateurs-16.png',
						),
					),
				);
				$s1 = array();
		//on détermine quelles configuration sont effectivement sauvegarder  
				foreach ($flux['args']['config']['soyezcreateurs'] as $section=>$exist){
					$s1[] = array(
						'saisie' => 'radio',
						'options' => array(
							'nom' => 'soyezcreateurs_import_choix_'.$section,
							'label' => '<:soyezcreateursprive:ieconfig_soyezcreateurs_import_explication_'.$section.':>',
							'datas' => array(
								'rien' => '<:soyezcreateursprive:soyezcreateurs_import_soyezcreateurs_rien:>',
								'fusion' => '<:soyezcreateursprive:soyezcreateurs_import_soyezcreateurs_fusionner:>',
								'ecrase' => '<:soyezcreateursprive:soyezcreateurs_import_ecraser:>',	
								),
							'defaut' => 'fusion',
							)
						);
				} 			
			$saisies[0]['saisies'] = $s1;
			$flux['data'] = array_merge($flux['data'], $saisies);
		}
		
		// Import de la configuration
		if ($action == 'import' && isset($flux['args']['config']['soyezcreateurs'])) {
			include_spip('soyezcreateurs_fonctions_ieconfig');
			if (!soyezcreateurs_importer_configuration(
			_request('soyezcreateurs_import_choix_soyezcreateurs'),
			_request('soyezcreateurs_import_choix_soyezcreateurs_layout'),
			_request('soyezcreateurs_import_choix_soyezcreateurs_couleurs'),
			_request('soyezcreateurs_import_choix_soyezcreateurs_google'),
			_request('soyezcreateurs_import_option_soyezcreateurs'),
			_request('soyezcreateurs_import_option_soyezcreateurs_layout'),
			_request('soyezcreateurs_import_option_soyezcreateurs_couleurs'),
			_request('soyezcreateurs_import_option_soyezcreateurs_google') ,
			$flux['args']['config']['soyezcreateurs'])) 
			{
				$flux['data'] .= _T('soyezcreateursprive_fr:ieconfig_probleme_import_config').'<br />';
			}
		}

		return($flux);
	}