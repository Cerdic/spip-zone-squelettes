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
		'afficher_compte_twitter' => 'non',
		'compte_twitter' => 'DANEVersailles',
		'nb_tweets' => '12',
		'pagination_tweets' => '3',
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
		'bandeau_large' => 'fenetre',	
		'position_menu' => 'droite',	
		'image_bandeau' => 'non',
		'arrondi' => 'oui',
		'degrades' => 'non',
		'ombres_polices_intertitres' => 'non',
		'ombres_blocs' => 'non',
		'fondcadre' => 'uni',
		'couleurs' => 'non',
		'bodyfond' => '#FFFFFF',
		'bandeau' => '#FFFFFF',
		'barre' => '#94C11F',
		'barreover' => '#A4D12F',
		'menufond' => '#EEEEEE',
		'calfond' => '#94C11F',
		'menurollover' => '#FFFFFF',
		'couleurbordure' => '#FFFFFF',
		'liens' => '#009FE3',
		'liensover'=>'#94C11F',
		'liensmenugauche'=>'#009FE3',
		'liensmenugauchehover'=>'#94C11F',
		'liensmenuhorizontal'=>'#FFFFFF',
		'liover'=>'#efefef',
		'police_contenu'=>'DejaVu',
		'police_titres'=>'DejaVu',
		'persocss'=>'',
		'couleurs_bandeau'=>'#333333',
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
		'liens_deroulants'=>'oui',
		'afficheauteurs' => 'non',
		'afficheintroduction' => 'non',
		'affichedate' => 'non',
		'institution_lien' => 'http://www.ac-versailles.fr',
		'institution_lien_titre' => 'Site de l\'académie de Versailles',
		'institution_nom' => 'académie de Versailles',
		'nb_maxi_lignes_mosaique' => '4',
		'afficher_logos_rubrique_menu_vertical' => 'non',
		'afficher_logos_menu_horizontal' => 'oui',
	), $config);
		
	return $config;	
}
function scolaspip_regex_twitter($twitt){ // d'apres http://www.openstudio.fr/Un-flux-twitter-en-boucles-SPIP.html
      $twitt = preg_replace('#((http(s?):\/\/|ftp:\/\/{1})([0-9a-zA-ZéèàîïùôçÉÈ.\-]*\/?)*)#i',
            '<a href="$0" class="spip_out">$0</a>', $twitt);
      $twitt = preg_replace('#@([0-9a-zA-ZéèàîïùôçÉÈ_-]+)#i',
            '<a href="http://twitter.com/$1" class="spip_out">@$1</a>', $twitt);
      $twitt = preg_replace('#\#([0-9a-zA-ZéèàîïùôçÉÈ_-]+)#i',
            '<a href="http://search.twitter.com/search?q=%23$1" class="spip_out">#$1</a>',
            $twitt);      
      return $twitt;
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
function critere_scolaspip_nb_tweets_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	if(is_null(lire_config('scolaspip_accueil/nb_tweets'))) $var=10;
	else $var=lire_config('scolaspip_accueil/nb_tweets');
	$boucle->limit = '0, ' .$var ;
}
