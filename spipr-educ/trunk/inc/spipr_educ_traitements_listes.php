<?php
// Demande de suppression d'un élément
function spipr_educ_liste_del($liste,$element) {
	$tab=explode(",",$liste);
	unset($tab[array_search($element, $tab)]);
	$retour=implode(",",$tab);
	return $retour;
}

// Demande de déplacement d'un élément vers un niveau supérieur
function spipr_educ_liste_up($liste,$element) {
	$tab=explode(",",$liste);
	$place = array_search ($element,$tab);
	if ($place==0) $retour=$liste;
	else {
		$place_precedent = $place - 1;
		$valeur_precedent = $tab[$place_precedent];
		$tab[$place]=$valeur_precedent;
		$tab[$place_precedent]=$element;
		$retour=implode(",",$tab);
	}
	return $retour;
}

// Demande de déplacement d'un élément vers un niveau inférieur
function spipr_educ_liste_down($liste,$element) {
	$tab=explode(",",$liste);
	$place = array_search ($element,$tab);
	if ($place==count($tab)-1) $retour=$liste;
	else {
		$place_suivant = $place + 1;
		$valeur_suivant = $tab[$place_suivant];
		$tab[$place]=$valeur_suivant;
		$tab[$place_suivant]=$element;
		$retour=implode(",",$tab);
	}
	return $retour;
}
?>