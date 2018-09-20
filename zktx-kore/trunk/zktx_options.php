<?php
// blocs Z !	
	$GLOBALS['z_blocs'] = array(
		'head',
		'head_js',
		'header',
		'content',
		'extra1',
		'extra2',
		'footer',
		'foot_js' //,
	);

	// activer le chargement parallele sur les blocs contenu et more
	define('_Z_AJAX_PARALLEL_LOAD','extra1,extra2,footer');
	
// Titre (BTE PP)
	$GLOBALS['debut_intertitre'] = '<h2 class=\"h2\">';
	$GLOBALS['fin_intertitre'] = '</h2>';
	$GLOBALS['debut_intertitre_2'] = '<h3 class=\"h3\">';
	$GLOBALS['fin_intertitre_2'] = '</h3>';
	$GLOBALS['debut_intertitre_3'] = '<h4 class=\"h4\">';
	$GLOBALS['fin_intertitre_3'] = '</h4>';
	$GLOBALS['debut_intertitre_4'] = '<h5 class=\"h5\">';
	$GLOBALS['fin_intertitre_4'] = '</h5>';
	$GLOBALS['debut_intertitre_5'] = '<h6 class=\"h6\">';
	$GLOBALS['fin_intertitre_5'] = '</h6>';
	$GLOBALS['BarreTypoEnrichie_Preserve_Header'] = true; 