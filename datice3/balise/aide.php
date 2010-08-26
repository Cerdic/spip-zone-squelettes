<?php
function balise_AIDE($p) {
   return calculer_balise_dynamique($p,AIDE,array());
       
}

function balise_AIDE_dyn($p) {
	$add="http://datice.ac-creteil.fr/spip/spip.php?page=aide&id_article=".$p."?keepThis=true&amp;TB_iframe=true&amp;height=500&amp;width=500"  ;
	if(strpos($_SERVER['REQUEST_URI'],"/ecrire/")){$vers="../";}
	else{$vers="";};
	$destination=$vers."prive/images/aide.gif";		
	$texte= "<a href=$add class='thickbox' > <img src='".$destination."'> </a>";
	return $texte;
	

}
?>