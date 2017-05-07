<?php
if (!defined("_ECRIRE_INC_VERSION")) return; 


/**
 * Supprimer le numero sur les titres 
 *
 * @param array $interface 
 * @return array
**/
function soyezcreateurs_declarer_tables_interfaces($interface){
	// Documentation et inspiration :
	// - https://programmer.spip.net/declarer_tables_interfaces,379
	// - http://permalink.gmane.org/gmane.comp.web.spip.devel/57655
	// version complexe (ne pas ecraser la definition existante)
	if (isset($interface['table_des_traitements']['TITRE'][0])) {
		$s = $interface['table_des_traitements']['TITRE'][0];
	} else {
		$s = '%s';
	}
	$interface['table_des_traitements']['TITRE'][0] = str_replace('%s', 'supprimer_numero(%s)', $s);
	
	return $interface; 
}


/**
 * Inserer les noiZettes du noiZetier
 * qui ont ete definies 
 *
 * @param array $flux
 * @return array
**/
function soyezcreateurs_recuperer_fond($flux){

	include_spip('inc/noizetier');
	$fond = $flux['args']['fond'];
	$into = '';
	if (!is_array($fond)) {
		$bloc = substr($fond, 0, strpos($fond, '/'));
		if ($bloc) $into = substr($fond, strpos($fond, '/')+1);
	} else {
		$bloc = '';
	}
	// Si on est sur un bloc contenu, navigation ou extra, on ajoute les noisettes de la page par defaut
	// ainsi que les noisettes pre et post de la page.
	if (in_array($bloc, array('contenu', 'navigation', 'extra'))
	// il ne faut pas que contenu/xxx qui inclu contenu/dist fasse des affichages en double.
	and $into != 'dist') {

		
		$contexte = $flux['data']['contexte'];

		// pre_$bloc / $type
		$contexte['bloc'] = 'pre_'.$bloc;
		$type_pre = recuperer_fond('noizetier-generer-bloc', $contexte);

		// $bloc / $type
		$contexte['bloc'] = $bloc;
		$type_post = recuperer_fond('noizetier-generer-bloc', $contexte);
		
		// pre_$bloc / defaut
		$contexte['type'] = 'defaut';
		$contexte['composition'] = '';
		$contexte['bloc'] = 'pre_'.$bloc;
		$complements_pre = recuperer_fond('noizetier-generer-bloc', $contexte);

		// $bloc / defaut
		$contexte['bloc'] = $bloc;
		$complements_post = recuperer_fond('noizetier-generer-bloc', $contexte);


		$flux['data']['texte'] =
			$complements_pre . $type_pre . $flux['data']['texte'] . $type_post . $complements_post;
	}
	return $flux;
}


/**
 * Ajouter la possibilité de d'indiquer des choses avant le squelette actuel. 
 *
 * @param array $flux liste les insertions possibles
 * @return array
**/
function soyezcreateurs_noizetier_blocs_defaut($flux) {

	$blocs = array();
	foreach ($flux as $nom => $desc) {
		switch ($nom) {
			
			case 'contenu':
				$blocs['pre_'.$nom] = array(
					'nom' => _T('soyezcreateurs:noizetier_nom_bloc_pre_contenu'),
					'description' => _T('soyezcreateurs:noizetier_description_bloc_pre_contenu'),
					'icon' => find_in_path('img/ic_bloc_contenu.png')
				);
				break;
				
			case 'navigation':
				$blocs['pre_'.$nom] = array(
					'nom' => _T('soyezcreateurs:noizetier_nom_bloc_pre_navigation'),
					'description' => _T('soyezcreateurs:noizetier_description_bloc_pre_navigation'),
					'icon' => find_in_path('img/ic_bloc_navigation.png')
				);
				break;
				
			case 'extra':
				$blocs['pre_'.$nom] = array(
					'nom' => _T('soyezcreateurs:noizetier_nom_bloc_pre_extra'),
					'description' => _T('soyezcreateurs:noizetier_description_bloc_pre_extra'),
					'icon' => find_in_path('img/ic_bloc_extra.png')
				);
				break;
		}
		$blocs[$nom] = $desc; 
	}

		
	return $blocs;
}

?>
