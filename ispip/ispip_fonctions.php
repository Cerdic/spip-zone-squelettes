<?php

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

// A utiliser sur #CHAPEAU
// Renvoie rien si pas de redirection
// Renvoie l'URL sinon
// Source : http://archives.rezo.net/archives/spip.mbox/RQEXYFM5WMKL3D652GKG5GVEA7EV2GUQ/
function adr_virt($lien) {
	$lien = strip_tags($lien);
	if ($lien[0] != '=') {
		return '';
	}
	$lien = substr($lien, 1);
	if (preg_match(',^(https?:|mailto:|www.),', $lien)) {
		return traiter_lien_explicite($lien);
	} else {
		return traiter_lien_implicite($lien);
	}
}
