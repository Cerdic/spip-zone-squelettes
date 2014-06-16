<?php


// Des noms intelligibles pour les z_blocs
	$GLOBALS['noms_z_blocs'] = array(
		'content' => 'contenu principal',
		'aside' => 'contenu secondaire',
		'head' => 'nn-têtes HTML',
		'head_js' => 'scripts javascript',
		'header' => 'bandeau',
		'footer' => 'pied de page',
		'nav'	=> 'onglets',
		'breadcrumb' => 'chemins',
		'extra' => 'contenu connexe'
	);

// Définition des blocs dispos pour Mélusine:

if (!isset($GLOBALS['z_blocs']))
	$GLOBALS['z_blocs'] = array_keys($GLOBALS['noms_z_blocs']);

// Des noms pour les types de gabarits gérées
	$GLOBALS['types_gabarits_melusine'] = array(
		"categorie" => "page de catégorie de contenus",
		"accueil" => "page d'accueil",
		"contenu" => "page du contenu"
	);


?>