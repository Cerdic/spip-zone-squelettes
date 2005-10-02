<?php

	//
	// multi-spikini
	//
	// on lui passe le nom du wiki (multi.php?wname=toto&wiki=PagePrincipale)
	// et il nous branche sur les bonnes tables (wiki_toto_xxx)
	//

	// verifs securite
	if (!ereg("^[a-z0-9_]+$", $wname)) $wname='testxy';

	// fichier de config (qui indique que le wiki est crיי)
	function multi_config_file() {
		global $wname;

		return 'ecrire/wakka_'.$wname.'_config.php';
	}

	$multi = true;
	PutEnv("WAKKA_CONFIG=".multi_config_file());
	$_SERVER['PHP_SELF'] = '/multi.php';
	include ('index.php');

?>