<?php
function spipr_educ_definition_des_structures() {
	$superieure_a_1200 = array(7,8,9,10,11,12,33,34,35,36,37,38);
	$de_980_a_1200 = array(33,34,35,36,37,38,7,8,9,10,11,12);
	$de_768_a_979 = array (33,34,35,36,37,38,39,40);
	$moins_de_768 = array (27,28);
	$structure = array(
		'tres_grand'=>$superieure_a_1200,
		'grand'=>$de_980_a_1200,
		'moyen'=>$de_768_a_979,
		'petit'=>$moins_de_768
	);
	return $structure;
}
function spipr_educ_noms_des_structures() {
	$nom = array(
	'7' => "3 colonnes en largeurs fixes, mod&egrave;le 1",
	'8' => "3 colonnes en largeurs fixes, mod&egrave;le 2",
	'9' => "3 colonnes en largeurs fixes, mod&egrave;le 3",
	'10' =>  "3 colonnes en largeurs fixes, mod&egrave;le 4",
	'11' =>  "3 colonnes en largeurs fixes, mod&egrave;le 5",
	'12' =>  "3 colonnes en largeurs fixes, mod&egrave;le 6",
	'27' => "Colonne principale en pleine largeur, les autres en-dessous, mod&egrave;le 1",
	'28' => "Colonne principale en pleine largeur, les autres en-dessous, mod&egrave;le 2",
	'33' => "2 colonnes en largeurs fixes, mod&egrave;le 1",
	'34' => "2 colonnes en largeurs fixes, mod&egrave;le 2",
	'35' => "2 colonnes en largeurs fixes, mod&egrave;le 3",
	'36' => "2 colonnes en largeurs fixes, mod&egrave;le 4",
	'37' => "2 colonnes en largeurs fixes, mod&egrave;le 5",
	'38' => "2 colonnes en largeurs fixes, mod&egrave;le 6",
	'39' => "Colonne principale en largeur fixe, les deux autres en-dessous, mod&egrave;le 1",
	'40' => "Colonne principale en largeur fixe, les deux autres en-dessous, mod&egrave;le 2",
	);
	return $nom;
}
function spipr_educ_definition_largeurs_colonnes() {
	$tableau = array (
		'7' => array(6,3,3),
		'8' => array(6,3,3),
		'9' => array(6,3,3),
		'10' => array(6,3,3),
		'11' => array(6,3,3),
		'12' => array(6,3,3),
		'27' => array('auto','48%','48%'),
		'28' => array('auto','48%','48%'),
		'33' => array(8,4,4),
		'34' => array(8,4,4),
		'35' => array(8,4,8),
		'36' => array(8,4,8),
		'37' => array(8,4,12),
		'38' => array(8,4,12),
		'39' => array(12,6,6),
		'40' => array(12,6,6)
	);
	return $tableau;
}
?>