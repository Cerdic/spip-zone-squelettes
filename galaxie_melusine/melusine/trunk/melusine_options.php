<?php


// Des noms intelligibles pour les z_blocs
	$GLOBALS['noms_z_blocs'] = array(
		'content' => 'Contenu principal',
		'aside' => 'Contenu secondaire',
		'head' => 'En-têtes HTML',
		'head_js' => 'Scripts javascript',
		'header' => 'Bandeau',
		'footer' => 'Pied de page',
		'nav'	=> 'Onglets',
		'breadcrumb' => 'Chemins',
		'extra' => 'Contenu connexe'
	);

// Définition des blocs dispos pour Mélusine:

if (!isset($GLOBALS['z_blocs']))
	$GLOBALS['z_blocs'] = array_keys($GLOBALS['noms_z_blocs']);

// Des noms pour les types de pages gérées
	$GLOBALS['types_pages_melusine'] = array(
		"rubrique" => "Page de catégorie de contenus",
		"sommaire" => "Page d'accueil",
		"article" => "Page du contenu"
	);

?>