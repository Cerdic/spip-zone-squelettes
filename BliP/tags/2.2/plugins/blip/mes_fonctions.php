<?php

function balise_SPIP_VERSION($p) {
	global $spip_version_affichee;
	$p->code = "'$spip_version_affichee'";
	$p->statut = 'php';
	return $p;
}

?>