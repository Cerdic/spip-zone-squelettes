<?php
// une url, c'est en minuscule et ce, quelque soit son format !
	define('_url_minuscules',true);
	// et ici je forcerais bien la nature du separateur ("-") si je savais comment faire ...
	
	// Forcer les url absolues a peu pres partout 
	// certainement optimisable (pas sur que ca releve de typo)
	if (!defined('_SET_HTML_BASE')) define('_SET_HTML_BASE',true);
	$GLOBALS['table_des_traitements']['URL_ARTICLE'][]= 'typo(url_absolue(%s), "TYPO", $connect)';
	$GLOBALS['table_des_traitements']['URL_RUBRIQUE'][]= 'typo(url_absolue(%s), "TYPO", $connect)';
	$GLOBALS['table_des_traitements']['URL_MOT'][]= 'typo(url_absolue(%s), "TYPO", $connect)';
	$GLOBALS['table_des_traitements']['URL_SITE'][]= 'typo(url_absolue(%s), "TYPO", $connect)';
	$GLOBALS['table_des_traitements']['URL_BREVE'][]= 'typo(url_absolue(%s), "TYPO", $connect)';
	$GLOBALS['table_des_traitements']['URL_PAGE'][]= 'typo(url_absolue(%s), "TYPO", $connect)';
	$GLOBALS['table_des_traitements']['CHEMIN'][]= 'typo(url_absolue(%s), "TYPO", $connect)';
	$GLOBALS['table_des_traitements']['CSS'][]= 'typo(url_absolue(%s), "TYPO", $connect)';
	// Et ca, forcement ca marche pas ...
	//$GLOBALS['table_des_traitements']['TEXTE'][]= 'typo(abs_url(%s), "TYPO", $connect)';
	//$GLOBALS['table_des_traitements']['CHAPO'][]= 'typo(abs_url(%s), "TYPO", $connect)';
	//$GLOBALS['table_des_traitements']['DESCRIPTIF'][]= 'typo(abs_url(%s), "TYPO", $connect)';

// connection noiZetier
  define('_NOIZETIER_REPERTOIRE_PAGES','content/');
	define('_NOIZETIER_LISTER_PAGES_SANS_XML',true);


// Pousse toi d'l� que j'mette mes nouveaux blocs Z !	
	$GLOBALS['z_blocs'] = array(
		'content',
		'extra1',
		'extra2',
		'head',
		'head_js',
		'header',
		'nav', // rajout
		'footer',
		'foot_js',
		'social' //,
		// 'p_cartouche',
		// 'p_contenu',
		// 'p_extra'
	);

// Chuck Norris ne fait jamais d'erreur !
// Quand bien m�me, s'il en fait une, 
// il faudrait �tre suicidaire pour la lui signaler !
	@ini_set('display_errors', 'off');
	
// Ce qui se passe � Vegas reste � Vegas !!!
	$GLOBALS['spip_header_silencieux'] = true; 

// CK : Des Options ... de s�rie !
	$GLOBALS['table_des_traitements']['TITRE'][]= 'typo(supprimer_numero(%s), "TYPO", $connect)';
	$GLOBALS['table_des_traitements']['NOM'][]= 'typo(supprimer_numero(%s), "TYPO", $connect)';
	$GLOBALS['toujours_paragrapher']=true;
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
	// My CSS is better than yours, bitch !
	$GLOBALS['BarreTypoEnrichie_Preserve_Header'] = true; 
?>
