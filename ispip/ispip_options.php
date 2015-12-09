<?php
/*
 * Plugin iSPIP
 * (c) 2009-2015
 * Distribue sous licence GPL
 *
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

// ne pas laisser les bots indexer les pages ispip
// les reorienter vers la page principale correspondante
if (strpos($_SERVER['HTTP_USER_AGENT'], 'bot') !== false
	and strncmp($p = _request('page'), 'ispip', 5) == 0) {
	if ($p == 'ispip') {
		$r = $GLOBALS['meta']['adresse_site'];
	} else {
		include_spip('base/connect_sql');
		$type = explode('-', $p);
		$type = end($type);
		$primary = id_table_objet($type);
		$id = _request($primary);
		$r = generer_url_entite($id, $type);
	}
	include_spip('inc/headers');
	redirige_par_entete($r, '', 301);
}
