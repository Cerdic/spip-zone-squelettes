<?php
// une url, c'est en minuscule et ce, quelque soit son format !
	define('_url_minuscules',true);
	// et ici je forcerais bien la nature du separateur ("-") si je savais comment faire ...
	
	// Forcer les url absolues a peu pres partout 
	// certainement optimisable (pas sur que ca releve de typo)
	if (!defined('_SET_HTML_BASE')) define('_SET_HTML_BASE',false);
	/* 	
	$table_des_traitements['URL_ARTICLE'][]= 'url_absolue(%s,true)';
	$GLOBALS['table_des_traitements']['URL_AUTEUR'][]= 'url_absolue(%s,true)';
	$table_des_traitements['URL_RUBRIQUE'][]= 'url_absolue(%s,true)';
	$GLOBALS['table_des_traitements']['URL_MOT'][]= 'url_absolue(%s,true)';
	$GLOBALS['table_des_traitements']['URL_SITE'][]= 'url_absolue(%s,true)';
	$GLOBALS['table_des_traitements']['URL_BREVE'][]= 'url_absolue(%s,true)';
	$GLOBALS['table_des_traitements']['URL_PAGE'][]= 'url_absolue(%s,true)';
	$GLOBALS['table_des_traitements']['CHEMIN'][]= 'url_absolue(%s,true)';
	$GLOBALS['table_des_traitements']['CSS'][]= 'url_absolue(%s,true)'; 
	*/
	// Et la même chose dans tous les champs texte
	/* 	
	$GLOBALS['table_des_traitements']['TEXTE'][]= 'abs_url('. _TRAITEMENT_RACCOURCIS .')';
	$GLOBALS['table_des_traitements']['CHAPO'][]= 'abs_url('. _TRAITEMENT_RACCOURCIS .')';
	$GLOBALS['table_des_traitements']['DESCRIPTIF'][]= 'abs_url('. _TRAITEMENT_RACCOURCIS .')';
	$GLOBALS['table_des_traitements']['INTRODUCTION'][]= 'abs_url('. _TRAITEMENT_RACCOURCIS .')';
	$GLOBALS['table_des_traitements']['PS'][]= 'abs_url('. _TRAITEMENT_RACCOURCIS .')';
	$GLOBALS['table_des_traitements']['DESCRIPTIF_SITE_SPIP'][]= 'abs_url('. _TRAITEMENT_RACCOURCIS .')';
	$GLOBALS['table_des_traitements']['SLOGAN_SITE_SPIP'][]= 'abs_url('. _TRAITEMENT_RACCOURCIS .')'; 
	*/
	
	

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
		'nav', // rajout
		'footer',
		'foot_js',
		'social' //,
		// 'p_cartouche',
		// 'p_contenu',
		// 'p_extra'
	);

// Chuck Norris ne fait jamais d'erreur !
// Quand bien même, s'il en fait une, 
// il faudrait être suicidaire pour la lui signaler !
	@ini_set('display_errors', 'off');
	
// Ce qui se passe à Vegas reste à Vegas !!!
	$GLOBALS['spip_header_silencieux'] = true; 

// CK : Des Options ... de série !
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
