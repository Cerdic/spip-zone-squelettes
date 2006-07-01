<?php
	# $mysql_profile = true;
	# $auto_compress = false;
	# $bouton_admin_debug = true;

	# les fichiers de langue sont ceux que gere trad-lang, ils
	# se trouvent dans /var/shim/spipnet/lang/ , on cherche donc
	# lang/local_fr dans ../
	$dossier_squelettes = '/var/shim/spipnet/:squelettes/';
	define('_TIDY_COMMAND', './tidy');
	define('_TIDY_SIGNAL_ID_MOT', 280); # le mot cle a apposer aux articles non compliants
	$GLOBALS["xhtml"] = true;
	
	# taille max du cache
	$quota_cache = 20;

	# pour la page www.spip.fr/download
	define('VERSION_STABLE', '1.8.3');
	define('VERSION_STABLE_URL', 'spip-dev/DISTRIB/SPIP-v1-8-3.zip');

	$type_urls = 'trad';

	$plugins[] = 'ancres';

	# choix du squelette www.spip.net/?var_skel=fraich
	# www.spip.net/?var_skel= pour revenir au normal
	if (isset($_GET['var_skel'])) {
		if ($_GET['var_skel'] == 'fraich')
			setcookie('skel', $_COOKIE['skel'] = 'fraich', NULL, '/');
		elseif ($_GET['var_skel'] == 'hBones')
			setcookie('skel', $_COOKIE['skel'] = 'hBones', NULL, '/');
		else
			setcookie('skel', $_COOKIE['skel'] = '', time()-3600*24, '/');
	}
	if ($_COOKIE['skel'] == 'fraich')
		$dossier_squelettes = '/var/shim/spipnet:dist';
	elseif ($_COOKIE['skel'] == 'hBones')
		$dossier_squelettes = '/var/shim/spipnet:hBones';


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
