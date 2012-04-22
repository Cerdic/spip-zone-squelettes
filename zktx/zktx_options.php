<?php
// Blocs Z	
	$GLOBALS['z_blocs'] = array('content','extra1','extra2','head','head_js','header','footer','foot_js','social');

// Sécurité
	@ini_set('display_errors', 'off');
	
// Bloquer la diffusion serveur des versions SPIP + plugins
	$GLOBALS['spip_header_silencieux'] = true; 

// CK Options
	$GLOBALS['table_des_traitements']['TITRE'][]= 'typo(supprimer_numero(%s), "TYPO", $connect)';
	$GLOBALS['table_des_traitements']['NOM'][]= 'typo(supprimer_numero(%s), "TYPO", $connect)';
	$GLOBALS['toujours_paragrapher']=true;
	if (!defined('_SET_HTML_BASE')) define('_SET_HTML_BASE',false);
	$GLOBALS['derniere_modif_invalide']=true;
	if (!defined('_DUREE_CACHE_DEFAUT')) define('_DUREE_CACHE_DEFAUT',86400);
	if (!defined('_DELAI_CACHE_resultats')) define('_DELAI_CACHE_resultats',600);
	$GLOBALS['quota_cache']=100;
	if (!defined('_LOGIN_TROP_COURT')) define('_LOGIN_TROP_COURT',4);
	if (!defined('_TRANCHES')) define('_TRANCHES',10);
	
// BTE
	// Niveaux de titre
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
	// zapper les css de la BTE
	$GLOBALS['BarreTypoEnrichie_Preserve_Header'] = true; 
?>
