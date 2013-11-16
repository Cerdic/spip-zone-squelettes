<?php

	// Forcer les url absolues a peu pres partout 
	// certainement optimisable (pas sur que ca releve de typo)
	/*
	if (!defined('_SET_HTML_BASE')) define('_SET_HTML_BASE',true);
 	$GLOBALS['table_des_traitements']['URL_ARTICLE'][]= 'typo(url_absolue(%s), "TYPO", $connect)';
	$GLOBALS['table_des_traitements']['URL_AUTEUR'][]= 'typo(url_absolue(%s), "TYPO", $connect)';
	$GLOBALS['table_des_traitements']['URL_RUBRIQUE'][]= 'typo(url_absolue(%s), "TYPO", $connect)';
	$GLOBALS['table_des_traitements']['URL_MOT'][]= 'typo(url_absolue(%s), "TYPO", $connect)';
	$GLOBALS['table_des_traitements']['URL_SITE'][]= 'typo(url_absolue(%s), "TYPO", $connect)';
	$GLOBALS['table_des_traitements']['URL_BREVE'][]= 'typo(url_absolue(%s), "TYPO", $connect)';
	$GLOBALS['table_des_traitements']['URL_PAGE'][]= 'typo(url_absolue(%s), "TYPO", $connect)';
	$GLOBALS['table_des_traitements']['CHEMIN'][]= 'typo(url_absolue(%s), "TYPO", $connect)';
	$GLOBALS['table_des_traitements']['CSS'][]= 'typo(url_absolue(%s), "TYPO", $connect)';  
	*/
	// Et ca, forcement ca marche pas ...
	//$GLOBALS['table_des_traitements']['TEXTE'][]= 'typo(abs_url(%s), "TYPO", $connect)';
	//$GLOBALS['table_des_traitements']['CHAPO'][]= 'typo(abs_url(%s), "TYPO", $connect)';
	//$GLOBALS['table_des_traitements']['DESCRIPTIF'][]= 'typo(abs_url(%s), "TYPO", $connect)';

// connection noiZetier
  define('_NOIZETIER_REPERTOIRE_PAGES','content/');
	define('_NOIZETIER_LISTER_PAGES_SANS_XML',true);


// Pousse toi d'là que j'mette mes nouveaux blocs Z !	
	$GLOBALS['z_blocs'] = array(
		'content',
		'extra1',
		'extra2',
		'head',
		'head_js',
		'header',
		'nav',
		'footer',
		'foot_js',
		'social' //,
	);
	
// Semantique on a dit !
	// Titre (BTE PP)
	$GLOBALS['debut_intertitre'] = '<h2 class="h2">';
	$GLOBALS['fin_intertitre'] = '</h2>';
	$GLOBALS['debut_intertitre_2'] = '<h3 class="h3">';
	$GLOBALS['fin_intertitre_2'] = '</h3>';
	$GLOBALS['debut_intertitre_3'] = '<h4 class="h4">';
	$GLOBALS['fin_intertitre_3'] = '</h4>';
	$GLOBALS['debut_intertitre_4'] = '<h5 class="h5">';
	$GLOBALS['fin_intertitre_4'] = '</h5>';
	$GLOBALS['debut_intertitre_5'] = '<h6 class="h6">';
	$GLOBALS['fin_intertitre_5'] = '</h6>';
	$GLOBALS['BarreTypoEnrichie_Preserve_Header'] = true; 
	// (CK)
	$GLOBALS['table_des_traitements']['TITRE'][]= 'typo(supprimer_numero(%s), "TYPO", $connect)';
	$GLOBALS['table_des_traitements']['NOM'][]= 'typo(supprimer_numero(%s), "TYPO", $connect)';
	$GLOBALS['toujours_paragrapher']=true;
?>
