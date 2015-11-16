<?php
/**
 * Utilisations de pipelines par spipr vide
 *
 * @plugin     spipr vide
 * @copyright  2013
 * @author     Alain Cousin
 * @licence    GNU/GPL
 * @package    SPIP\Spipr_vide\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

 function spipr_vide_noizetier_blocs_defaut($blocs) {
	unset($blocs['navigation']);
	unset($blocs['extra']);
	unset($blocs['contenu']);

	static $blocs_defaut = null;
	if (is_null($blocs_defaut)){
		$blocs_defaut = array (
			'content' => array(
				'nom' => _T('spipr_vide:nom_bloc_content'),
				'description' => _T('spipr_vide:description_bloc_content'),
				'icon' => 'bloc-contenu-24.png'
				),
			'aside' => array(
				'nom' => _T('spipr_vide:nom_bloc_aside'),
				'description' => _T('spipr_vide:description_bloc_aside'),
				'icon' => 'bloc-navigation-24.png'
				),
			'extra' => array(
				'nom' => _T('spipr_vide:nom_bloc_extra'),
				'description' => _T('spipr_vide:description_bloc_extra'),
				'icon' => 'bloc-extra-24.png'
				)
		);
		$blocs_defaut = pipeline('noizetier_blocs_defaut',$blocs_defaut);
	}
	return $blocs_defaut;
}

/**
 * Pipeline recuperer_fond pour ajouter les blocs de la page par défaut
 *
 * @param array $flux
 * @return array
 */
 function spipr_vide_recuperer_fond($flux){
	// Le pipeline n'est utilisé que si le noiZetier est actif, ZPIP-vide pouvant être utilisé seulement pour un reset.
	if (defined('_DIR_PLUGIN_NOIZETIER')) {
		include_spip('inc/noizetier');
		$fond = $flux['args']['fond'];
		if(!is_array($fond))
			$bloc = substr($fond,0,strpos($fond,'/'));
		else
			$bloc = '';
		// Si on est sur un bloc contenu, navigation ou extra, on ajoute les noisettes de la page par defaut
		// On ajoute également une ancre correspondant au nom du bloc
		if (in_array($bloc,array('content','aside','extra'))) {
			$contexte = $flux['data']['contexte'];
			$contexte['bloc'] = 'pre_'.$bloc;			
			$contexte['type'] = 'defaut';
			$contexte['composition'] = '';
			if ($flux['args']['contexte']['voir']=='noisettes' && autoriser('configurer','noizetier'))
					$complements_pre = recuperer_fond('noizetier-generer-bloc-voir-noisettes',$contexte,array('raw'=>true));
				else
					$complements_pre = recuperer_fond('noizetier-generer-bloc',$contexte,array('raw'=>true));
			$contexte['bloc'] = 'post_'.$bloc;
			if ($flux['args']['contexte']['voir']=='noisettes' && autoriser('configurer','noizetier'))
					$complements_post = recuperer_fond('noizetier-generer-bloc-voir-noisettes',$contexte,array('raw'=>true));
				else
					$complements_post = recuperer_fond('noizetier-generer-bloc',$contexte,array('raw'=>true));
			$ancre = "<a name=\"$bloc\"></a>\n";
			$flux['data']['texte'] = $ancre.$complements_pre['texte'].$flux['data']['texte'].$complements_post['texte'];
		}
	}
	return $flux;
}

/**
 * Pipeline noizetier_config_export pour ajouter la version_base des noisettes au YAML d'export du noizetier
 *
 * @param array $config
 * @return array
 */

 function spipr_vide_noizetier_config_export($config){
	$config['spipr_vide_base_version'] = $GLOBALS['meta']['spipr_vide_base_version'];
	return $config;
}

 function spipr_vide_noizetier_config_import($config){	
	
	if ($version_actuelle) {
		include_spip('spipr_vide_administrations');
		$config['noisettes'] = spipr_vide_maj_noisettes($config['noisettes'], $version_actuelle);
	}
	
	return $config;
}

?>