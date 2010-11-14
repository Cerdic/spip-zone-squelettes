<?php

// Sécurité
if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Pipeline recuperer_fond pour ajouter les blocs de la page par défaut
 *
 * @param array $flux
 * @return array
 */
function aveline_recuperer_fond($flux){
	include_spip('inc/noizetier');
	$fond = $flux['args']['fond'];
	if(!is_array($fond))
		$bloc = substr($fond,0,strpos($fond,'/'));
	else
		$bloc = '';
	// Si on est sur un bloc contenu, navigation ou extra, on ajoute les noisettes de la page par defaut
	if (in_array($bloc,array('contenu','navigation','extra'))) {
		$contexte = $flux['data']['contexte'];
		$contexte['bloc'] = 'pre_'.$bloc;
		$contexte['type'] = 'defaut';
		$contexte['composition'] = '';
		$complements_pre = recuperer_fond('noizetier-generer-bloc',$contexte,array('raw'=>true));
		$contexte['bloc'] = 'post_'.$bloc;
		$complements_post = recuperer_fond('noizetier-generer-bloc',$contexte,array('raw'=>true));
		$flux['data']['texte'] = $complements_pre['texte'].$flux['data']['texte'].$complements_post['texte'];
	}
	return $flux;
}

/**
 * Pipeline noizetier_config_export pour ajouter le nom du squelette et sa version_base au YAML d'export du noizetier
 *
 * @param array $config
 * @return array
 */

 function aveline_noizetier_config_export($config){
	$config['squelette'] = 'aveline';
	$config['aveline_base_version'] = $GLOBALS['meta']['aveline_base_version'];
	return $config;
 }
?>
