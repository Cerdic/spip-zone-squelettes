<?php

// Ce fichier defini les classes CSS en tant que variable php, pour permettre un changement de theme graphique comparable a celui de sedna

/*
Remplacer '8' par rand (0 ,9) dans la ligne 16 -> Switch autonome couleur (puis vider le cache)
*/

	// CHOIX CSS PAR DEFAUT DE BliP. Modifications possibles : remplacer les valeurs numériques par d'autres valeurs numériques, à condition que la déclaration CSS existe sinon plantage.
$css_blip = array(	
	'couleur' => '8',
	'structure' => '0',
	'tete' => '0',
	'menu' => '0',
	'corps' => '0',
	'pied' => '0',
	'lateral' => '0',
	'divers' => '0',	
); 

	// COULEURS ET PROPORTIONS DU SITE
$css_blip_couleur_1_nom = 'n&ordm; 01 : Vert p&eacute;tillant et orange intense';
$css_blip_couleur_1 = array(
	// Jeu de couleur n°1
	'gris|fonce' => '#333333',
	'gris|moyen' => '#666666',
	'gris|clair' => '#aaaaaa',
	'couleur|1' => '#85c329',
	'couleur|1|clair' => '#bcde89',
	'couleur|2' => '#fb9622',
	'couleur|2|clair' => '#ffd600',
	'couleur|neutre' => '#ffffff',
	'couleur|neutre|bis' => 'transparent',
	'taille|espacement_bloc' => '3em',
	'taille|geant' => '1.5em',
	'taille|grand' => '1.25em',
	'taille|moyen' => '1em',
	'taille|normal' => '0.75em',
	'taille|petit' => '0.5em',
	'taille|bordure' => '0.25em',
);

$css_blip_couleur_10_nom = 'n&ordm; 10 : Vert feutr&eacute; et bleu oc&eacute;an';
$css_blip_couleur_10 = array(
	// Jeu de couleur n°10
	'gris|fonce' => '#aaaaaa',
	'gris|moyen' => '#666666',
	'gris|clair' => '#333333',
	'couleur|1' => '#549e46',
	'couleur|1|clair' => '#c6dfc1',
	'couleur|2' => '#1e73cd',
	'couleur|2|clair' => '#c5e1f4',
	'couleur|neutre' => '#ffffff',
	'couleur|neutre|bis' => 'transparent',
	'taille|espacement_bloc' => '3em',
	'taille|geant' => '1.5em',
	'taille|grand' => '1.25em',
	'taille|moyen' => '1em',
	'taille|normal' => '0.75em',
	'taille|petit' => '0.5em',
	'taille|bordure' => '0.25em',
); 

$css_blip_couleur_11_nom = 'n&ordm; 11 : Test en cours';
$css_blip_couleur_11 = array(
	// Jeu de couleur n°11
	'gris|fonce' => '#aaaaaa',
	'gris|moyen' => '#666666',
	'gris|clair' => '#333333',
	'couleur|1' => '#1a8ab3',
	'couleur|1|clair' => '#c2e2ee',
	'couleur|2' => '#c43219',
	'couleur|2|clair' => '#dc715e',
	'couleur|neutre' => '#000000',
	'couleur|neutre|bis' => 'transparent',
	'taille|espacement_bloc' => '3em',
	'taille|geant' => '1.5em',
	'taille|grand' => '1.25em',
	'taille|moyen' => '1em',
	'taille|normal' => '0.75em',
	'taille|petit' => '0.5em',
	'taille|bordure' => '0.25em',
); 

$css_blip_couleur_12_nom = 'n&ordm; 12 : Noir intense, Gris sobre et bleu oc&eacute;an (th&egrave;me earth)';
$css_blip_couleur_12 = array(
	// Jeu de couleur n°12
	'gris|fonce' => '#333333',
	'gris|moyen' => '#666666',
	'gris|clair' => '#aaaaaa',
	'couleur|1' => '#224570',
	'couleur|1|clair' => '#7797B3',
	'couleur|2' => '#000000',
	'couleur|2|clair' => '#cccccc',
	'couleur|neutre' => '#ffffff',
	'couleur|neutre|bis' => 'transparent',
	'taille|espacement_bloc' => '3em',
	'taille|geant' => '1.5em',
	'taille|grand' => '1.25em',
	'taille|moyen' => '1em',
	'taille|normal' => '0.75em',
	'taille|petit' => '0.5em',
	'taille|bordure' => '0.25em',
); 


$css_blip_couleur_13_nom = 'n&ordm; 13 : Gris sobre, rouge p&eacute;tillant et vert nature (th&egrave;me coccinelle)';
$css_blip_couleur_13 = array(
	// Jeu de couleur n°13
	'gris|fonce' => '#333333',
	'gris|moyen' => '#666666',
	'gris|clair' => '#aaaaaa',
	'couleur|1' => '#3D6300',
	'couleur|1|clair' => '#A6CB31',
	'couleur|2' => '#D70900',
	'couleur|2|clair' => '#CA5533',
	'couleur|neutre' => '#ffffff',
	'couleur|neutre|bis' => 'transparent',
	'taille|espacement_bloc' => '3em',
	'taille|geant' => '1.5em',
	'taille|grand' => '1.25em',
	'taille|moyen' => '1em',
	'taille|normal' => '0.75em',
	'taille|petit' => '0.5em',
	'taille|bordure' => '0.25em',
); 


$css_blip_couleur_2_nom = 'n&ordm; 02 : Violet intense et orange p&eacute;tillant';
$css_blip_couleur_2 = array(
	// Jeu de couleur n°1
	'gris|fonce' => '#333333',
	'gris|moyen' => '#666666',
	'gris|clair' => '#aaaaaa',
	'couleur|1' => '#600051',
	'couleur|1|clair' => '#925F6E',
	'couleur|2' => '#fb9622',
	'couleur|2|clair' => '#ffd600',
	'couleur|neutre' => '#ffffff',
	'couleur|neutre|bis' => 'transparent',
	'taille|espacement_bloc' => '3em',
	'taille|geant' => '1.5em',
	'taille|grand' => '1.25em',
	'taille|moyen' => '1em',
	'taille|normal' => '0.75em',
	'taille|petit' => '0.5em',
	'taille|bordure' => '0.25em',
); 

$css_blip_couleur_3_nom = 'n&ordm; 03 : Bleu azur et orange p&eacute;tillant';
$css_blip_couleur_3 = array(
	// Jeu de couleur n°1
	'gris|fonce' => '#333333',
	'gris|moyen' => '#666666',
	'gris|clair' => '#aaaaaa',
	'couleur|1' => '#009999',
	'couleur|1|clair' => '#66DEFF',
	'couleur|2' => '#fb9622',
	'couleur|2|clair' => '#ffd600',
	'couleur|neutre' => '#ffffff',
	'couleur|neutre|bis' => 'transparent',
	'taille|espacement_bloc' => '3em',
	'taille|geant' => '1.5em',
	'taille|grand' => '1.25em',
	'taille|moyen' => '1em',
	'taille|normal' => '0.75em',
	'taille|petit' => '0.5em',
	'taille|bordure' => '0.25em',
); 

$css_blip_couleur_4_nom = 'n&ordm; 04 : Rouge intense et orange p&eacute;tillant';
$css_blip_couleur_4 = array(
	// Jeu de couleur n°1
	'gris|fonce' => '#333333',
	'gris|moyen' => '#666666',
	'gris|clair' => '#aaaaaa',
	'couleur|1' => '#D00000',
	'couleur|1|clair' => '#DD7875',
	'couleur|2' => '#fb9622',
	'couleur|2|clair' => '#ffd600',
	'couleur|neutre' => '#ffffff',
	'couleur|neutre|bis' => 'transparent',
	'taille|espacement_bloc' => '3em',
	'taille|geant' => '1.5em',
	'taille|grand' => '1.25em',
	'taille|moyen' => '1em',
	'taille|normal' => '0.75em',
	'taille|petit' => '0.5em',
	'taille|bordure' => '0.25em',
); 

$css_blip_couleur_5_nom = 'n&ordm; 05 : Rose bonbon et orange p&eacute;tillant';
$css_blip_couleur_5 = array(
	// Jeu de couleur n°1
	'gris|fonce' => '#333333',
	'gris|moyen' => '#666666',
	'gris|clair' => '#aaaaaa',
	'couleur|1' => '#cc0066',
	'couleur|1|clair' => '#ff6666',
	'couleur|2' => '#fb9622',
	'couleur|2|clair' => '#ffd600',
	'couleur|neutre' => '#ffffff',
	'couleur|neutre|bis' => 'transparent',
	'taille|espacement_bloc' => '3em',
	'taille|geant' => '1.5em',
	'taille|grand' => '1.25em',
	'taille|moyen' => '1em',
	'taille|normal' => '0.75em',
	'taille|petit' => '0.5em',
	'taille|bordure' => '0.25em',
); 

$css_blip_couleur_6_nom = 'n&ordm; 06 : Vert kaki et orange p&eacute;tillant';
$css_blip_couleur_6 = array(
	// Jeu de couleur n°1
	'gris|fonce' => '#333333',
	'gris|moyen' => '#666666',
	'gris|clair' => '#aaaaaa',
	'couleur|1' => '#666633',
	'couleur|1|clair' => '#999999',
	'couleur|2' => '#fb9622',
	'couleur|2|clair' => '#ffd600',
	'couleur|neutre' => '#ffffff',
	'couleur|neutre|bis' => 'transparent',
	'taille|espacement_bloc' => '3em',
	'taille|geant' => '1.5em',
	'taille|grand' => '1.25em',
	'taille|moyen' => '1em',
	'taille|normal' => '0.75em',
	'taille|petit' => '0.5em',
	'taille|bordure' => '0.25em',
); 

$css_blip_couleur_7_nom = 'n&ordm; 07 : Orange p&eacute;tillant et bleu oc&eacute;an';
$css_blip_couleur_7 = array(
	// Jeu de couleur n°1
	'gris|fonce' => '#333333',
	'gris|moyen' => '#666666',
	'gris|clair' => '#aaaaaa',
	'couleur|1' => '#fb9622',
	'couleur|1|clair' => '#ffd600',
	'couleur|2' => '#1e73cd',
	'couleur|2|clair' => '#c0daef',
	'couleur|neutre' => '#ffffff',
	'couleur|neutre|bis' => 'transparent',
	'taille|espacement_bloc' => '3em',
	'taille|geant' => '1.5em',
	'taille|grand' => '1.25em',
	'taille|moyen' => '1em',
	'taille|normal' => '0.75em',
	'taille|petit' => '0.5em',
	'taille|bordure' => '0.25em',
); 

$css_blip_couleur_8_nom = 'n&ordm; 08 : Bleu oc&eacute;an et rouge intense';
$css_blip_couleur_8 = array(
	// Jeu de couleur n°1
	'gris|fonce' => '#333333',
	'gris|moyen' => '#666666',
	'gris|clair' => '#aaaaaa',
	'couleur|1' => '#1a8ab3',
	'couleur|1|clair' => '#c2e2ee',
	'couleur|2' => '#c43219',
	'couleur|2|clair' => '#dc715e',
	'couleur|neutre' => '#ffffff',
	'couleur|neutre|bis' => 'transparent',
	'taille|espacement_bloc' => '3em',
	'taille|geant' => '1.5em',
	'taille|grand' => '1.25em',
	'taille|moyen' => '1em',
	'taille|normal' => '0.75em',
	'taille|petit' => '0.5em',
	'taille|bordure' => '0.25em',
); 

$css_blip_couleur_9_nom = 'n&ordm; 09 : Bleu intense et orange p&eacute;tillant';
$css_blip_couleur_9 = array(
	// Jeu de couleur n°1
	'gris|fonce' => '#333333',
	'gris|moyen' => '#666666',
	'gris|clair' => '#aaaaaa',
	'couleur|1' => '#1e73cd',
	'couleur|1|clair' => '#c0daef',
	'couleur|2' => '#fb9622',
	'couleur|2|clair' => '#ffd600',
	'couleur|neutre' => '#ffffff',
	'couleur|neutre|bis' => 'transparent',
	'taille|espacement_bloc' => '3em',
	'taille|geant' => '1.5em',
	'taille|grand' => '1.25em',
	'taille|moyen' => '1em',
	'taille|normal' => '0.75em',
	'taille|petit' => '0.5em',
	'taille|bordure' => '0.25em',
);  
?>
