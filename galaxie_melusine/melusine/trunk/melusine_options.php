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
		"categorie" => "Disposition 1 - 3 colonnes - aside/content/extra",
		"accueil" => "Disposition 2 - 3 colonnes - content/aside/extra",
		"contenu" => "Disposition 3 - 2 colonnes - aside/content",
		"bonus" => "Disposition 4 - 2 colonnes - content/extra"
	);

if (!isset($GLOBALS['z_blocs']))
	$GLOBALS['z_blocs'] = array_keys($GLOBALS['noms_z_blocs']);

// Des noms pour les types de dispositions gérées
	$GLOBALS['types_dispositions_melusine'] = array(
		"Dispo 1" => "Disposition 1 - 3 colonnes - aside/content/extra",
		"Dispo 2" => "Disposition 2 - 3 colonnes - content/aside/extra",
		"Dispo 3" => "Disposition 3 - 2 colonnes - aside/content",
		"Dispo 4" => "Disposition 4 - 2 colonnes - content/extra"
	);

if (!isset($GLOBALS['z_blocs']))
	$GLOBALS['z_blocs'] = array_keys($GLOBALS['noms_z_blocs']);

// Des images pour les types de dispositions gérées
	$GLOBALS['images_dispositions_melusine'] = array(
		"Dispo 1" => "/layouts/layout11.gif",
		"Dispo 2" => "/layouts/layout1.gif",
		"Dispo 3" => "/layouts/layout2.gif",
		"Dispo 4" => "/layouts/layout3.gif"
	);
?>