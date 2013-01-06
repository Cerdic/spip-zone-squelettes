<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

/*
function vittory_insert_head($flux){
	return $flux;
}

function vittory_insert_head_css($flux){
	return $flux;
}
*/


function vittory_affiche_milieu($flux){
	if ($flux['args']['exec'] == 'configurer_avancees')
		$flux['data'] .= recuperer_fond('prive/squelettes/inclure/configurer', array('configurer' => 'configurer_vittory'));
	return $flux;
}

?>
