<?php
/*
 *   +----------------------------------+
 *    Nom du Filtre : opendocblank  
 *   +----------------------------------+
 *    date :    2006.06.27
 *    auteur :  erational - http://www.erational.org
 *    version:  1.0
 *    compatible:  SPIP 1.9 SVN 
 *    licence:  GPL
 *   +-------------------------------------+
 *   Fonctions de ce filtre :
 *	 ouvre les liens documents contenu dans un texte dans un _blank
 *	 (pour eviter que l'internaute perde la navigation dans l'interface) 
 *
 *   +-------------------------------------+
 *
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * https://contrib.spip.net/???
*/
function opendocblank($str){
  $extensions = array("jpg","png","gif","doc","rtf","pdf","xls");
  foreach ($extensions as $extension) {  
      $str = eregi_replace("<a href='([^\.]*).$extension'>","<a href='\\1.$extension' target='_blank'>",$str);
  }
  return $str;
}

// ---------------------------------------
// Filtre no_url
// supprime les liens 
// ---------------------------------------
function no_url($str){
   $str = eregi_replace("http://([^[:space:]<]*)","",$str);
   return $str;
} 

// ---------------------------------------
// Filtre nettoyage
// supprime divers trucs 
// ---------------------------------------
function cleaner($str){
   $str = str_replace("\""," ",$str);
   return $str;
}

  
/*
 *   +----------------------------------+
 *    Nom du Filtre : licence   
 *   +----------------------------------+
 *    date : 2005.06.14
 *    auteur :  erational - http://www.erational.org
 *    version: 1.2
 *    licence: GPL
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *	retourne les mentions legales, liens et code RDF  en fonction de la licence choisie
 *	notamment les 6 contrats Creative commons http://creativecommons.org/license/?lang=fr 
 *
 *   valeurs possibles:
*	- copyright
*	- gpl
*	- cc by
*	- cc by-nd
*	- cc by-nc-nd
*	- cc by-nc
*	- cc by-nc-sa
*	- cc by-sa
*   +-------------------------------------+
*
* Pour toute suggestion, remarque, proposition d'ajout
* reportez-vous au forum de l"article :
* https://contrib.spip.net/Filtre-Licence
*/


function licence($titre, $param="") {
  if (empty($titre)) $titre = $param; // pour permettre une utilisation a "vide" hors boucle ex. [(#REM|licence{"cc by-nc-sa"})]
	$str = "\n<!-- licence -->\n";	
	$titre = strtolower($titre);
	switch($titre)  {
		case "copyright": // copyright
					$str .= "&copy; copyright auteur de l'article\n";
					break;
					
		case "gpl":		// GPL
					$str .= "<a href=\"http://www.gnu.org/copyleft/gpl.html\">licence GPL</a>\n";
					break;	
		case "cc by":	// Creative Commons - Paternité 
					$str .= "<a rel=\"license\" href=\"http://creativecommons.org/licenses/by/2.0/fr/deed.fr\"><img alt=\"Contrat Creative Commons\" src=\"http://creativecommons.org/images/public/somerights20.gif\" /></a><br />\n";
					$str .= "<a rel=\"license\" href=\"http://creativecommons.org/licenses/by/2.0/fr/deed.fr\">Creative Commons</a>\n";
					$str .= "<!--\n";
					$str .= "<rdf:RDF xmlns=\"http://web.resource.org/cc/\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\">\n";
					$str .= "<Work rdf:about=\"\">\n";
					$str .= "	   <dc:type rdf:resource=\"http://purl.org/dc/dcmitype/Text\" />\n";
					$str .= "	   <license rdf:resource=\"http://creativecommons.org/licenses/by/2.0/fr/deed.fr\" />\n";
					$str .= "	</Work>\n";
						
					$str .= "	<License rdf:about=\"http://creativecommons.org/licenses/by/2.0/fr/deed.fr\">\n";
					$str .= "	   <permits rdf:resource=\"http://web.resource.org/cc/Reproduction\" />\n";
					$str .= "	   <permits rdf:resource=\"http://web.resource.org/cc/Distribution\" />\n";
					$str .= "	   <requires rdf:resource=\"http://web.resource.org/cc/Notice\" />\n";
					$str .= "	   <requires rdf:resource=\"http://web.resource.org/cc/Attribution\" />\n";
					$str .= "	   <permits rdf:resource=\"http://web.resource.org/cc/DerivativeWorks\" />\n";
					$str .= "	</License>\n";
					$str .= "</rdf:RDF>\n";
					$str .= "-->\n";
					break;
		case "cc by-nd":	// Creative Commons - Paternité pas de modification	
					$str .= "<a rel=\"license\" href=\"http://creativecommons.org/licenses/by-nd/2.0/fr/deed.fr\"><img alt=\"Contrat Creative Commons\" src=\"http://creativecommons.org/images/public/somerights20.gif\" /></a><br />\n";
					$str .= "<a rel=\"license\" href=\"http://creativecommons.org/licenses/by-nd/2.0/fr/deed.fr\">Creative Commons</a>\n";
					$str .= "<!--\n";
					$str .= "<rdf:RDF xmlns=\"http://web.resource.org/cc/\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\">\n";
					$str .= "<Work rdf:about=\"\">\n";
					$str .= "	   <dc:type rdf:resource=\"http://purl.org/dc/dcmitype/Text\" />\n";
					$str .= "	   <license rdf:resource=\"http://creativecommons.org/licenses/by-nd/2.0/fr/deed.fr\" />\n";
					$str .= "	</Work>\n";
						
					$str .= "	<License rdf:about=\"http://creativecommons.org/licenses/by-nd/2.0/fr/deed.fr\">\n";
					$str .= "	   <permits rdf:resource=\"http://web.resource.org/cc/Reproduction\" />\n";
					$str .= "	   <permits rdf:resource=\"http://web.resource.org/cc/Distribution\" />\n";
					$str .= "	   <requires rdf:resource=\"http://web.resource.org/cc/Notice\" />\n";
					$str .= "	   <requires rdf:resource=\"http://web.resource.org/cc/Attribution\" />\n";
					$str .= "	</License>\n";
					$str .= "</rdf:RDF>\n";
					$str .= "-->\n";
					break;
					
		case "cc by-nc-nd":	// Creative Commons - Paternité Pas d"Utilisation Commerciale Pas de Modification	
					$str .= "<a rel=\"license\" href=\"http://creativecommons.org/licenses/by-nc-nd/2.0/fr/deed.fr\"><img alt=\"Contrat Creative Commons\" src=\"http://creativecommons.org/images/public/somerights20.gif\" /></a><br />\n";
					$str .= "<a rel=\"license\" href=\"http://creativecommons.org/licenses/by-nc-nd/2.0/fr/deed.fr\">Creative Commons</a>\n";
					$str .= "<!--\n";
					$str .= "<rdf:RDF xmlns=\"http://web.resource.org/cc/\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\">\n";
					$str .= "<Work rdf:about=\"\">\n";
					$str .= "	   <dc:type rdf:resource=\"http://purl.org/dc/dcmitype/Text\" />\n";
					$str .= "	   <license rdf:resource=\"http://creativecommons.org/licenses/by-nc-nd/2.0/fr/deed.fr\" />\n";
					$str .= "	</Work>\n";
						
					$str .= "	<License rdf:about=\"http://creativecommons.org/licenses/by-nc-nd/2.0/fr/deed.fr\">\n";
					$str .= "	   <permits rdf:resource=\"http://web.resource.org/cc/Reproduction\" />\n";
					$str .= "	   <permits rdf:resource=\"http://web.resource.org/cc/Distribution\" />\n";
					$str .= "	   <requires rdf:resource=\"http://web.resource.org/cc/Notice\" />\n";
					$str .= "	   <requires rdf:resource=\"http://web.resource.org/cc/Attribution\" />\n";
					$str .= "	   <prohibits rdf:resource=\"http://web.resource.org/cc/CommercialUse\" />\n";
					$str .= "	</License>\n";
					$str .= "</rdf:RDF>\n";
					$str .= "-->\n";
					break;
		case "cc by-nc":	// Creative Commons - Paternité Pas d"Utilisation Commerciale 	
					$str .= "<a rel=\"license\" href=\"http://creativecommons.org/licenses/by-nc/2.0/fr/deed.fr\"><img alt=\"Contrat Creative Commons\" src=\"http://creativecommons.org/images/public/somerights20.gif\" /></a><br />\n";
					$str .= "<a rel=\"license\" href=\"http://creativecommons.org/licenses/by-nc/2.0/fr/deed.fr\">Creative Commons</a>\n";
					$str .= "<!--\n";
					$str .= "<rdf:RDF xmlns=\"http://web.resource.org/cc/\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\">\n";
					$str .= "<Work rdf:about=\"\">\n";
					$str .= "	   <dc:type rdf:resource=\"http://purl.org/dc/dcmitype/Text\" />\n";
					$str .= "	   <license rdf:resource=\"http://creativecommons.org/licenses/by-nc/2.0/fr/deed.fr\" />\n";
					$str .= "	</Work>\n";
						
					$str .= "	<License rdf:about=\"http://creativecommons.org/licenses/by-nc/2.0/fr/deed.fr\">\n";
					$str .= "	   <permits rdf:resource=\"http://web.resource.org/cc/Reproduction\" />\n";
					$str .= "	   <permits rdf:resource=\"http://web.resource.org/cc/Distribution\" />\n";
					$str .= "	   <requires rdf:resource=\"http://web.resource.org/cc/Notice\" />\n";
					$str .= "	   <requires rdf:resource=\"http://web.resource.org/cc/Attribution\" />\n";
					$str .= "	   <prohibits rdf:resource=\"http://web.resource.org/cc/CommercialUse\" />\n";
					$str .= "  	   <permits rdf:resource=\"http://web.resource.org/cc/DerivativeWorks\" />\n";
					$str .= "	  <requires rdf:resource=\"http://web.resource.org/cc/ShareAlike\" />\n";
					$str .= "	</License>\n";
					$str .= "</rdf:RDF>\n";
					$str .= "-->\n";
					break;
					
		case "cc by-nc-sa":	// Creative Commons - Paternité Pas d"Utilisation Commerciale Partage des Conditions Initiales à  l"Identique 	
					$str .= "<a rel=\"license\" href=\"http://creativecommons.org/licenses/by-nc-sa/2.0/fr/deed.fr\"><img alt=\"Contrat Creative Commons\" src=\"http://creativecommons.org/images/public/somerights20.gif\" /></a><br />\n";
					$str .= "<a rel=\"license\" href=\"http://creativecommons.org/licenses/by-nc-sa/2.0/fr/deed.fr\" style=\"display:none\">Creative Commons</a>\n";
					$str .= "<!--\n";
					$str .= "<rdf:RDF xmlns=\"http://web.resource.org/cc/\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\">\n";
					$str .= "<Work rdf:about=\"\">\n";
					$str .= "	   <dc:type rdf:resource=\"http://purl.org/dc/dcmitype/Text\" />\n";
					$str .= "	   <license rdf:resource=\"http://creativecommons.org/licenses/by-nc-sa/2.0/fr/deed.fr\" />\n";
					$str .= "	</Work>\n";
						
					$str .= "	<License rdf:about=\"http://creativecommons.org/licenses/by-nc-sa/2.0/fr/deed.fr\">\n";
					$str .= "	   <permits rdf:resource=\"http://web.resource.org/cc/Reproduction\" />\n";
					$str .= "	   <permits rdf:resource=\"http://web.resource.org/cc/Distribution\" />\n";
					$str .= "	   <requires rdf:resource=\"http://web.resource.org/cc/Notice\" />\n";
					$str .= "	   <requires rdf:resource=\"http://web.resource.org/cc/Attribution\" />\n";
					 $str .= "	   <prohibits rdf:resource=\"http://web.resource.org/cc/CommercialUse\" />\n";
					$str .= "        <permits rdf:resource=\"http://web.resource.org/cc/DerivativeWorks\" />\n";
					$str .= "         <requires rdf:resource=\"http://web.resource.org/cc/ShareAlike\" />\n";
					$str .= "	</License>\n";
					$str .= "</rdf:RDF>\n";
					$str .= "-->\n";
					break;
					
			
		case "cc by-sa":	// Creative Commons - Paternité  Partage des Conditions Initiales à  l"Identique	
					$str .= "<a rel=\"license\" href=\"http://creativecommons.org/licenses/by-sa/2.0/fr/deed.fr\"><img alt=\"Contrat Creative Commons\" src=\"http://creativecommons.org/images/public/somerights20.fr.png\" /></a><br />\n";
					$str .= "<a rel=\"license\" href=\"http://creativecommons.org/licenses/by-sa/2.0/fr/deed.fr\">Creative Commons</a>\n";
					$str .= "<!--\n";
					$str .= "<rdf:RDF xmlns=\"http://web.resource.org/cc/\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\">\n";
					$str .= "<Work rdf:about=\"\">\n";
					$str .= "	   <dc:type rdf:resource=\"http://purl.org/dc/dcmitype/Text\" />\n";
					$str .= "	   <license rdf:resource=\"http://creativecommons.org/licenses/by-sa/2.0/fr/deed.fr\" />\n";
					$str .= "	</Work>\n";
						
					$str .= "	<License rdf:about=\"http://creativecommons.org/licenses/by-sa/2.0/fr/deed.fr\">\n";
					$str .= "	   <permits rdf:resource=\"http://web.resource.org/cc/Reproduction\" />\n";
					$str .= "	   <permits rdf:resource=\"http://web.resource.org/cc/Distribution\" />\n";
					$str .= "	   <requires rdf:resource=\"http://web.resource.org/cc/Notice\" />\n";
					$str .= "	   <requires rdf:resource=\"http://web.resource.org/cc/Attribution\" />\n";
					$str .= "        <permits rdf:resource=\"http://web.resource.org/cc/DerivativeWorks\" />\n";
					$str .= "         <requires rdf:resource=\"http://web.resource.org/cc/ShareAlike\" />\n";
					$str .= "	</License>\n";
					$str .= "</rdf:RDF>\n";
					$str .= "-->\n";
					break;
	}	
	return $str;	
  
}

?>
