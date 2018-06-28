<?php

/*
 *   +----------------------------------+
 *    Fonctions relatives à ieconfig
 *   +----------------------------------+
 *    Date : Juin-juillet 2018
 *    Auteur :  RIEDELAndreas
*/

/**
* Retourne le tableau des configurations de SoyezCréateur pour l'export ieconfig
* 
* @param array $input
*
* @return $data
**/

function soyezcreateurs_tableau_export($input){
	$data = array();
	
	// On calcule le tableau des paramètres de soyezcreateurs
	foreach ($input as $etape){
		$data[$etape] = sql_allfetsel(
			'nom, valeur',
			'spip_meta',
			'nom=\''.$etape.'\''
		);
		// On remet au propre les parametres
		foreach ($data[$etape] as $cle => $soyezcreateurs) {
			$data[$etape][$cle]['valeur'] = unserialize($soyezcreateurs['valeur']);
		}	
	}
	
	
	/* $data['soyezcreateurs'] = sql_allfetsel(
		'nom, valeur',
		'spip_meta',
		'nom=\'soyezcreateurs\''
	);

	// On remet au propre les parametres
	foreach ($data['soyezcreateurs'] as $cle => $soyezcreateurs) {
		$data['soyezcreateurs'][$cle]['valeur'] = unserialize($soyezcreateurs['valeur']);
	} */ 

	$data = pipeline('soyezcreateurs_config_export', $data);

	return $data;
	
}


/**
* Retourne le tableau des configurations de SoyezCréateur pour l'export ieconfig
* 
* @param text $type_import
* @param text $import_compos
* @param array $config
*
* @return bool
**/
function soyezcreateurs_importer_configuration($choix_sc,$choix_sc_l,$choix_sc_c,$choix_sc_g,$import_sc, $import_sc_l,$import_sc_c,$import_sc_g,$config) {
	
	$config = pipeline('soyezcreateurs_config_import', $config);

	$soyezcreateurs = $config['soyezcreateurs'];
	$soyezcreateurs_layout = $config['soyezcreateurs_layout'];
	$soyezcreateurs_couleurs = $config['soyezcreateurs_couleurs'];
	$soyezcreateurs_google = $config['soyezcreateurs_google'];
	
	if ($choix_sc != 'rien' and $choix_sc !== null) {
		$ok = insert_base_ieconfig($choix_sc,$soyezcreateurs);		
	}
	if ($choix_sc_l != 'rien' and $choix_sc_l !== null) {
		$ok = insert_base_ieconfig($choix_sc_l,$soyezcreateurs_layout);
	}
	if ($choix_sc_c != 'rien' and $choix_sc_c !== null) {
		$ok = insert_base_ieconfig($choix_sc_c,$soyezcreateurs_couleurs);
	}
	if ($choix_sc_g != 'rien' and $choix_sc_g !== null) {
		$ok = insert_base_ieconfig($choix_sc_g,$soyezcreateurs_google);
	}
			
	return $ok;
}

function insert_base_ieconfig($choix,$sections){
		if ($choix == 'ecrase') {			
			foreach ($sections as $section) {
				$section['valeur'] = serialize($section['valeur']);
			}
			
			if (sql_countsel('spip_meta','nom=\''.$section['nom'].'\'') != 0) {
				$t = sql_delete('spip_meta','nom=\''.$section['nom'].'\'');
			}
			$ok = sql_insertq('spip_meta', array('nom' => $section['nom'], 'valeur' => $section['valeur']));
				
		} 
		if ($choix == 'fusion') {
			foreach ($sections as $section) {
				$import = $section;
			}
			$nom = $import['nom'];
			if (sql_countsel('spip_meta','nom=\''.$nom.'\'') != 0) {
				$val_exist = sql_fetsel(
					'nom, valeur',
					'spip_meta',
					'nom=\''.$nom.'\''
				);				
				$val_exist['valeur'] = unserialize($val_exist['valeur']);
				
				$import['valeur'] = array_merge($val_exist['valeur'],$import['valeur']);
				
				
				$t = sql_delete('spip_meta','nom=\''.$import['nom'].'\'');
			}
			$import['valeur'] = serialize($import['valeur']);
			$ok = sql_insertq('spip_meta', array('nom' => $import['nom'], 'valeur' => $import['valeur']));
		}
		if ($choix == 'fusion_inv') {
			foreach ($sections as $section) {
				$import = $section;
			}
			$nom = $import['nom'];
			if (sql_countsel('spip_meta','nom=\''.$nom.'\'') != 0) {
				$val_exist = sql_fetsel(
					'nom, valeur',
					'spip_meta',
					'nom=\''.$nom.'\''
				);				
				$val_exist['valeur'] = unserialize($val_exist['valeur']);
				
				$import['valeur'] = array_merge($import['valeur'],$val_exist['valeur']);
				
				
				$t = sql_delete('spip_meta','nom=\''.$import['nom'].'\'');
			}
			$import['valeur'] = serialize($import['valeur']);
			$ok = sql_insertq('spip_meta', array('nom' => $import['nom'], 'valeur' => $import['valeur']));
		}
		//invalidation du cache
		include_spip('inc/invalideur');
		suivre_invalideur('soyezcreateurs-import-config');
		if ($ok == 0) {
				return true;
		}
		else {
			return false;
		}
	
}

function getURI(){
    $adresse = $_SERVER['PHP_SELF'];
    $i = 0;
    foreach($_GET as $cle => $valeur){
        $adresse .= ($i == 0 ? '?' : '&').$cle.($valeur ? '='.$valeur : '');
        $i++;
    }
    return $adresse;
}