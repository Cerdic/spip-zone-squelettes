<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip('inc/filtres_ecrire');

if($GLOBALS['connect_id_auteur'] == 0)
	$GLOBALS['connect_id_auteur'] = $GLOBALS['visiteur_session']['id_auteur'];

?>