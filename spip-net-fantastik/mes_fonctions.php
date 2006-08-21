<?php

	# pour la page www.spip.fr/download
	define('VERSION_STABLE', '1.9.0');
	define('VERSION_STABLE_URL', 'spip-dev/DISTRIB/SPIP-v1-9-0.zip');

	$type_urls = 'trad';

	$plugins[] = 'ancres';


	# raccourcis [->spip19] etc
	function calculer_url_spip($id, $texte, $ancre) {
	$spip = array( 
		1 => 1309,
		10 => 1309,
		103 => 1309,
		104 => 1309,
		105 => 1309,
		12 => 1310,
		121 => 1310,
		13 => 1253,
		14 => 1832,
		15 => 1911,
		16 => 1965,
		17 => 2102,
		171 => 2102,
		172 => 2102,
		18 => 2991,
		181 => 2991,
		182 => 3173,
		183 => 3333,
		19 => 3368
	);

	if (isset($spip[$id])) {
		$p= calculer_url_article($spip[$id], $texte, $ancre);
		$p[1] = 'spip'; # class
		return $p;
	} else {
		return array('/', 'spip', 'version inconnue');
	}
	}
	# indisppensable ? ou pas ?
	function generer_url_spip($id) {
		$p= calculer_url_spip($id, $texte, $ancre);
		return $p[0];
	}
	
?>
