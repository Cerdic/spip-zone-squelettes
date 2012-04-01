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
		'bandeau' => '#4b4b4b',
		'barre' => '#c4c4c4',
		'barreover' => '#dddddd',
		'menufond' => '#F2E19D',
		'calfond' => '#edd6b5',
		'menurollover' => '#000000',
		'couleurbordure' => '#ffcc00',
		'liens' => '#cc6600',
		'liensover'=>'#A85503',
		'liensmenugauche'=>'#A85503',
		'liensmenugauchehover'=>'#666666',
		'liensmenuhorizontal'=>'#333333',
		'liover'=>'#efefef',
		'btcom1'=>'#DDDDDD',
		'btcom2'=>'#EEEEEE',
		'btcom3'=>'#F4F4F4',
		'btcom4'=>'#DDDDDD',
		'btcom5'=>'#EEEEEE',
		'police_contenu'=>'Lucida',
		'police_titres'=>'Lucida',
		'persocss'=>'',
		'couleurs_bandeau'=>'#ffffff',
		'couleurs_intertitres'=>'#333333',
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

function critere_scolaspip_nb_articles_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	if(is_null(lire_config('scolaspip_accueil/nb_articles'))) $var=10;
	else $var=lire_config('scolaspip_accueil/nb_articles');
	$boucle->limit = '0, ' .$var ;
}
function critere_scolaspip_nb_breves_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	if(is_null(lire_config('scolaspip_accueil/nb_breves'))) $var=10;
	else $var=lire_config('scolaspip_accueil/nb_breves');
	$boucle->limit = '0, ' .$var ;
}
function critere_scolaspip_nb_forums_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	if(is_null(lire_config('scolaspip_accueil/nb_forums'))) $var=10;
	else $var=lire_config('scolaspip_accueil/nb_forums');
	$boucle->limit = '0, ' .$var ;
}

function critere_scolaspip_nb_evenements_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	if(is_null(lire_config('scolaspip_accueil/nb_evenements'))) $var=10;
	else $var=lire_config('scolaspip_accueil/nb_evenements');
	$boucle->limit = '0, ' .$var ;
}
?>
