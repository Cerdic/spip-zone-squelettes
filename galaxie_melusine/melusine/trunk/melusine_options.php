<?php


// Des noms intelligibles pour les z_blocs
	$GLOBALS['noms_z_blocs'] = array(
		'content' => 'contenu principal',
		'aside' => 'contenu secondaire',
		'head' => 'nn-têtes HTML',
		'head_js' => 'scripts javascript',
		'header' => 'bandeau',
		'footer' => 'pied de page',
		'footer2' => 'deuxième pied de page',
		'nav'	=> 'onglets',
		'breadcrumb' => 'chemins',
		'extra' => 'contenu connexe',
		'pre_content' => 'pré contenu'
	);

// Définition des blocs dispos pour Mélusine:

if (!isset($GLOBALS['z_blocs']))
	$GLOBALS['z_blocs'] = array_keys($GLOBALS['noms_z_blocs']);

// Des noms pour les types de gabarits gérées
	$GLOBALS['types_gabarits_melusine'] = array(
		"categorie" => "gabarit de catégorie de contenus",
		"accueil" => "gabarit d'accueil",
		"contenu" => "gabarit du contenu"
	);

//$forcer_lang = true ; 
?>