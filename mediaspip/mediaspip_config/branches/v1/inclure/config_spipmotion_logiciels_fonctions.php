<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function spipmotion_logiciels(){
	$infos_ffmpeg = charger_fonction('ffmpeg_infos','inc');
	$infos = $infos_ffmpeg();
	if(is_array($infos)){
		$contexte = array_merge($_GET,$infos);
		return recuperer_fond('prive/contenu/ffmpeg_infos', $contexte);
	}
}
?>