<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function formulaires_recherche_ajax_charger_dist($ajax_bloc) {
	return array(
		'ajax_bloc' => $ajax_bloc,
		'recherche_'.$ajax_bloc => _request('recherche_'.$ajax_bloc),
		'lang' => $lang,
	);
}
