<?php
/******************************************************************
***  Ce plugin EVA_habillage, crיי par Olivier Gautier, est mis ***
***      א disposition sous un contrat Creative Commons BY      *** 
***                 consultable א l'adresse                     ***
***      http://www.creativecommons.org/licenses/by/2.0/fr/     ***
******************************************************************/
function balise_EVAFLASHLOGOBLOCTEST($p) {
	$titre=sql_select('id','spip_eva_habillage_images',"nom_habillage = 'Defaut' AND type = 'flash' AND nom_div = 'flash_secteur_sites_partenaires'");
	$envoi=sql_count($titre);
	$p->code = "'".$envoi."'";
	$p->interdire_scripts = false;
	return $p;
}
?>