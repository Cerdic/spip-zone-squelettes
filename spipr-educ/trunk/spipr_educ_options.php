<?php
// Ci-dessous les déclarations de bases de SPIPr
if (!isset($GLOBALS['z_blocs']))
	$GLOBALS['z_blocs'] = array('content','aside','extra','head','head_js','header','footer','breadcrumb');

define('_ZENGARDEN_FILTRE_THEMES','spipr');
define('_ALBUMS_INSERT_HEAD_CSS',false);

if (
	defined('_SPIPR_AUTH_DEMO')?
		_SPIPR_AUTH_DEMO
		:
		(isset($GLOBALS['visiteur_session']['statut'])
    AND $GLOBALS['visiteur_session']['statut']=='0minirezo'
    AND $GLOBALS['visiteur_session']['webmestre']=='oui')
	)
	_chemin(_DIR_PLUGIN_SPIPR_EDUC."demo/");

// Ci-dessous les déclarations de SPIPr-éduc utiles

// Choix du thème : on sélectionne le dossier squelettes utile pour remplacer les noisettes du squelette de base, concernant les style, le plugin prend en charge sans passage par ce dossier
include_spip('base/abstract_sql');
$test = sql_showtable('spip_spipr_educ', true);
	if ($test['field']){
		$test_theme=sql_select('nom','spip_spipr_educ',"type='theme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
		$tab_theme=sql_fetch($test_theme);
		if ($tab_theme['nom']!='theme_de_base') $GLOBALS['dossier_squelettes'] = _DIR_PLUGIN_SPIPR_EDUC."themes/".$tab_theme['nom'];
	}
?>