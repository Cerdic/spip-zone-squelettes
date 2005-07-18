<?php 

//      Mes_fonctions.php3 

$GLOBALS['dossier_squelettes'] = 'spipcast'; 



/*
 *   +----------------------------------+
 *    Nom du Filtre : RSS 2.0 et un fil ATOM 0.3
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *    Dans un texte, genere automatiquement le smiley 
 *    approprie a la place d'une chaine :nom.
 *    Ce filtre utilise les smileys disponibles dans       
 *    le repertoire smileys/
 *    Exemple d'application :
 *    [(#TEXTE|smileys)]
 *   +-------------------------------------+ 
 *  
 * Mise a jours et discution:
 * http://www.spip-contrib.net/Un-fil-RSS-2-et-un-fil-ATOM-3?var_recherche=rss2
*/

function pasdecrochet($texte) {
  // replaces ">" if first character by "*"
	$first = substr($texte,0,1);
	if (ord($first)==ord('>')) {
  	$texte = substr($texte,1);
	}
	return $texte;
}

function w3cdate($texte) {
	// sets date (from #DATE) to W3C format
	$texte = substr($texte,0,10)."T".substr($texte,11,8)."Z";
	return $texte;
}	

function tagdate($texte) {
	// sets date (from #DATE) to W3C URI tag format
	$texte = substr($texte,0,10);
	return $texte;
}	

function supprimehttp($texte) {
	// removes "http://" from URL to build Atom tag
	$texte = substr($texte,7);
	return $texte;
}


?>