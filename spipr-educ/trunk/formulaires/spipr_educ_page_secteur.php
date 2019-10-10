<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_page_secteur_charger_dist($page,$secteur) {
	//On donnera ici les éléments suivants :
	// L'intitulé du h3
	// L'intitulé du paragraphe introductif
	// Les deux précédents seront traité dans un tableau ici
	// La page
	// Le secteur
	// Les info sont ici : https://programmer.spip.net/Passage-d-arguments-aux-fonctions
	$tab_abrege = array(
		'sommaire' => 'sommaire',
		'rubrique' => 'rubriques',
		'article' => 'articles',
		'breve' => 'brèves',
		'site' => 'sites',
		'auteur' => 'auteurs',
		'autre' => 'autres pages'
	);
	$tab_complet = array(
		'sommaire' => 'votre page de sommaire',
		'rubrique' => 'de vos rubriques',
		'article' => 'de vos articles',
		'breve' => 'de vos brèves',
		'site' => 'de vos sites',
		'auteur' => 'de vos auteurs',
		'autre' => 'de vos autres pages'
	);
	$tab_secteur = array(
		'header' => "dans l'entête",
		'aside' => "dans la colonne secondaire",
		'breadcrumb' => "dans le fil d'ariane",
		'content' => "dans la colonne de contenus",
		'extra' => "dans la colonne tertiaire",
		'footer' => "dans le pied de page",
		'head' => "dans l'entête html",
		'head_js' => "dans l'entête javascript"
	);
	$secteur_majuscule = array(
		'header' => "Entête",
		'aside' => "Colonne secondaire",
		'breadcrumb' => "Fil d'ariane",
		'content' => "Colonne de contenus",
		'extra' => "Colonne tertiaire",
		'footer' => "Pied de page",
		'head' => "Entête html",
		'head_js' => "Entête javascript"
	);
	$valeurs=array(
		'page' => $page,
		'page_abrege' => $tab_abrege[$page],
		'page_complet' => $tab_complet[$page],
		'secteur_complet' => $tab_secteur[$secteur],
		'secteur_majuscule' => $secteur_majuscule[$secteur],
		'secteur' => $secteur
	);
	if (is_numeric(_request('ajout_nouveau_bloc_x'))) $valeurs['deplie']='ok';
	return $valeurs;
}

function formulaires_spipr_educ_page_secteur_traiter_dist($page,$secteur) {
	$res = array('editable'=>true);	
	include_spip('inc/spipr_educ_deplacement_bloc');
	// On regarde si un déplacement d'un bloc vers le haut a été demandé
	spipr_educ_bloc_vers_le_haut($page,$secteur);
	//On poursuit avec le cas d'un déplacement vers le bas
	spipr_educ_bloc_vers_le_bas($page,$secteur);
	//Cas d'un bloc à cacher
	spipr_educ_bloc_cacher($page,$secteur);
	//Cas d'un bloc à supprimer
	spipr_educ_bloc_supprimer_definitivement($page,$secteur);
	//Cas d'un bloc de la distribution SPIPr_edu à ajouter
	spipr_educ_bloc_ajouter_distrib_spipr_edu($page,$secteur);
	//Cas d'un bloc personnel à ajouter
	spipr_educ_bloc_ajouter_personnel($page,$secteur);
	$res['message_ok'] = _T('config_info_enregistree');
	return $res;
}
?>