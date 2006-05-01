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
		else
			setcookie('skel', $_COOKIE['skel'] = '', time()-3600*24, '/');
	}
	if ($_COOKIE['skel'] == 'fraich')
		$dossier_squelettes = '/var/shim/spipnet/:fraichdist/';

?>
