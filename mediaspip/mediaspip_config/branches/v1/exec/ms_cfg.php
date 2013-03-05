<?php

/*
 * Plugin CFG pour SPIP
 * (c) toggg, marcimat 2009, distribue sous licence GNU/GPL
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

function generer_url_cfg($lien){
	if(!test_espace_prive()){
		return generer_url_public('ms_config','cfg='.$lien);
	}else{
		return generer_url_ecrire('configurer','cfg='.$lien);
	}
}

function exec_ms_cfg_dist()
{
	$out = '<div class="configuration">';
	$nav = "";

	include_spip('inc/filtres');
	include_spip('inc/cfg');
	$config = new cfg(
		($nom = sinon(_request('cfg'), '')),
		($cfg_id = sinon(_request('cfg_id'),''))
		);

	// traitements du formulaire poste
	// seulement s'il provient d'un formulaire CFG
	// et non d'un formulaire CVT dans un fond CFG
	if (_request('arg'))
		$config->traiter();

	//
	// affichages
	//
	include_spip("inc/presentation");

	if (!$config->autoriser()) {
		echo $config->acces_refuse();
		exit;
	}

	$out .= "<h3>".$config->get_titre()."</h3>";

	
	// colonne gauche
	// si un formulaire cfg est demande
	if ($s = $config->logo()) {
		$s_plus = str_replace('<p></p>','',preg_replace('/<img.*\/>/','',$config->descriptif()));
		$s = $s . $s_plus;
		$nav .= $s;
	}

	// colonne droite
	// affichage des messages envoyes par cfg
	if ($s = $config->messages()){
		$nav .= '<div class="formulaire_spip">
				<div class="reponse_formulaire reponse_formulaire_erreur">';
		$nav .= $s;
		$nav .= '</div>
				</div>';
	}

	// affichage des liens
	if ($s = $config->liens()){
		$s = preg_replace(",<ul>(.*)</ul>,Uims","<ul class=\"menu-liste\">\\1</ul>",$s);
		$s = preg_replace(",<li>(.*)<\/li>,Uims","<li class=\"menu-entree\">\\1</li>",$s);
		$s = preg_replace(",<li [^>]*class=[\"']on[\"']>(.*)<\/li>,Uims","<li class=\"item on\">\\1</li>",$s);
		$nav .= $s;
	}
	if ($s = $config->liens_multi()){
		$s = preg_replace('/<ul>(.*)<\/ul>/','<ul class="liste_items">\\1</ul>',$s);
		$nav .= $s;
	}
	
	if(strlen($nav)>1){
		$out .= '<div class="config_nav">'.$nav.'</div>';
	}
	
	// centre de la page
	if ($config->get_presentation() == 'auto') {
		$out .= '<div class="configuration_contenu">';
		$out .= $config->formulaire();
		$out .= '</div>';
	} else {
		$out .= '<div class="configuration_contenu">';
		$out .=  $config->formulaire();
		$out .= '</div>';
	}

	$out .= '</div>';
	return $out;
}

?>
