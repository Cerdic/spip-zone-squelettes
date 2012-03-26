<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function scolaspip_accueil_config($public=null){
	include_spip("inc/filtres");
	$config = @unserialize($GLOBALS['meta']['scolaspip_accueil']);
	if (!is_array($config))
		$config = array();
	$config = array_merge(array(
		'descriptifdusite' => 'non',
		'calendrier' => 'non',
		'evenements' => 'non',
		'nb_evenements' => '10',
		'pagination_evenements' => '5',
		'breves' => 'non',
		'nb_breves' => '10',
		'pagination_breves'=>'5',
		'articles'=>'oui',
		'nb_articles'=>'10',
		'pagination_articles'=>'5',
		'forums'=>'non',
		'nb_forums' => '10',
		'pagination_forums' => '5',
	), $config);
		
	return $config;	
}
function scolaspip_couleurs_config($public=null){
	include_spip("inc/filtres");
	$config = @unserialize($GLOBALS['meta']['scolaspip_colorer']);
	if (!is_array($config))
		$config = array();
	$config = array_merge(array(
		'css_scolaspip' => 'oui',
		'bandeau_large' => '980px',	
		'position_menu' => 'gauche',	
		'image_bandeau' => 'oui',
		'arrondi' => 'non',
		'degrades' => 'non',
		'fondcadre' => 'uni',
		'couleurs' => 'non',
		'bodyfond' => '#dddddd',
		'bandeau' => '#888888',
		'barre' => '#9c9dd3',
		'menufond' => '#edc48a',
		'calfond' => '#edd6b5',
		'menurollover' => '#dddddd',
		'couleurbordure' => '#f5a32e',
		'liens' => '#454692',
		'liensover'=>'#f5a32e',
		'liensmenugauche'=>'#454692',
		'liensmenuhorizontal'=>'#666666',
		'btcom1'=>'#ffaf11',
		'btcom2'=>'#ffcf22',
		'btcom3'=>'#ffef44',
		'btcom4'=>'#ffff66',
		'btcom5'=>'#ffff88',
		'police_contenu'=>'Lucida',
		'police_titres'=>'Lucida',
		'persocss'=>'',
	), $config);
		
	return $config;	
}
function scolaspip_plus_config($public=null){
	include_spip("inc/filtres");
	$config = @unserialize($GLOBALS['meta']['scolaspip_plus']);
	if (!is_array($config))
		$config = array();
	$config = array_merge(array(
		'boutonagenda' => 'non',
		'boutonliens' => 'non',
		'afficheauteurs' => 'non',
		'afficheintroduction' => 'non',
		'affichedate' => 'non',
		'lien_logo' => 'http://www.ac-versailles.fr',
		'title_logo' => 'Site de l\'académie de Versailles',
	), $config);
		
	return $config;	
}


function scolaspip_timestamp($fichier){
	if ($m = filemtime($fichier))
		return "$fichier?$m";
	return $fichier;
}

function scolaspip_insert_head($flux){
	$config = scolaspip_couleurs_config();
	if ($config['css_scolaspip']=='oui') {
		$flux .='<script src="spip.php?page=javascript/scolaspip.js" type="text/javascript"></script>';
	}
	return $flux;
}
function scolaspip_insert_head_css($flux){
	$config = scolaspip_couleurs_config();
	if ($config['css_scolaspip']=='oui') {
		$flux .= '<link rel="stylesheet" href="'.direction_css(find_in_path('scolaspip.css')).'" type="text/css" media="all" />';
		if ($config['couleurs']=='oui') {
			$flux .= '<link rel="stylesheet" href="spip.php?page=couleurs" type="text/css" media="all" />';
		}
	}
	return $flux;
}


function critere_scolaspip_nb_articles_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$var=lire_config('scolaspip_accueil/nb_articles');
	$boucle->limit = '0, ' .$var ;
}
function critere_scolaspip_nb_breves_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$var=lire_config('scolaspip_accueil/nb_breves');
	$boucle->limit = '0, ' .$var ;
}
function critere_scolaspip_nb_forums_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$var=lire_config('scolaspip_accueil/nb_forums');
	$boucle->limit = '0, ' .$var ;
}

function critere_scolaspip_nb_evenements_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$var=lire_config('scolaspip_accueil/nb_evenements');
	$boucle->limit = '0, ' .$var ;
}
?>
