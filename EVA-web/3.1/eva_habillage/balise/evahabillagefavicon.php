<?php
/******************************************************************
***  Ce plugin EVA_habillage, créé par Olivier Gautier, est mis ***
***      à disposition sous un contrat Creative Commons BY      *** 
***                 consultable à l'adresse                     ***
***      http://www.creativecommons.org/licenses/by/2.0/fr/     ***
******************************************************************/
function balise_EVAHABILLAGEFAVICON($p) {
	$favicon=sql_select('nom_image','spip_eva_habillage_images',"nom_habillage = 'Defaut' AND type = 'favicon'");
	$favicon_result=sql_fetch($favicon);
	if (isset($favicon_result['nom_image'])) {
		$envoi='<link rel="icon" type="image/';
		if ((strpos($favicon_result['nom_image'],'.png')) OR (strpos($favicon_result['nom_image'],'.PNG'))) {
			$envoi.='png" href="'._DIR_IMG.'eva_habillage/favicon/'.$favicon_result['nom_image'].'" />';
		}
		elseif ((strpos($favicon_result['nom_image'],'.gif')) OR (strpos($favicon_result['nom_image'],'.GIF'))) {
			$envoi.='gif" href="'._DIR_IMG.'eva_habillage/favicon/'.$favicon_result['nom_image'].'" />';
		}
		elseif ((strpos($favicon_result['nom_image'],'.ico')) OR (strpos($favicon_result['nom_image'],'.ICO'))) {
			$envoi='<link rel="shortcut icon" href="'._DIR_IMG.'eva_habillage/favicon/'.$favicon_result['nom_image'].'" />';
		}
		else {$envoi = '<link rel="icon" type="image/png" href="'._DIR_PLUGIN_EVASQUELETTES.'images/eva3_favicon.png" />';}
	}
	else {$envoi = '<link rel="icon" type="image/png" href="'._DIR_PLUGIN_EVASQUELETTES.'images/eva3_favicon.png" />';}
	$p->code = "'".$envoi."'";
	$p->interdire_scripts = false;
	return $p;
}
?>