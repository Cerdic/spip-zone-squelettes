<?php 

//      Mes_fonctions.php3 

$GLOBALS['dossier_squelettes'] = 'spipcast'; 



/*
 *   +----------------------------------+
 *    Nom du Filtre : RSS 2.0 et un fil ATOM 0.3
 *   +-------------------------------------+
 *  
 * Mise a jours et discution:
 * https://contrib.spip.net/Un-fil-RSS-2-et-un-fil-ATOM-3?var_recherche=rss2
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



/*
 *   +----------------------------------+
 *    Nom du Filtre :    smileys II
 *   +----------------------------------+
 *    Date : mercredi 14 octobre 2003
 *    Auteur :  BoOz (booz.bloog@laposte.net)
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
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=261
*/



function smileys($chaine) {

$listimag=array();
$rep1="spipcast/images/smileys/";
$listfich=opendir($rep1);
while ($fich=readdir($listfich))
{ 	if(($fich !='..') and ($fich !='.') and ($fich !='.DS_Store'))
	{ 
$nomfich=substr($fich,0,strrpos($fich, "."));
$listimag[$nomfich]= '<img class="smiley" alt="smiley" src="spipcast/images/smileys/' . $fich . '" />' ;
	}
}


ksort($listimag);
reset($listimag);

while (list($nom,$chem) = each($listimag))
{ 
  $chaine = str_replace(":".$nom, $chem , $chaine);
}

        return $chaine;
}



?>