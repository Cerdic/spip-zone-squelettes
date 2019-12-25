<?php
// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) return;

function curalicious_insert_head_css($flux){
	$flux.= '<link rel="stylesheet" type="text/css" href="'.find_in_path('css/curalicious.css').'" />';
	return $flux;
}

?>
