<?php
/******************************************************************
***  Ce plugin EVA_habillage, cr�� par Olivier Gautier, est mis ***
***      � disposition sous un contrat Creative Commons BY      *** 
***                 consultable � l'adresse                     ***
***      http://www.creativecommons.org/licenses/by/2.0/fr/     ***
******************************************************************/
function balise_EVANBRESITESYNDRUB($p) {
    $test_nbre=sql_select('nom_image','spip_eva_habillage_images',"nom_habillage='Defaut' AND type='nbre' AND nom_div ='nbre_rubrique_sites_synd'");
    $test_tab=sql_fetch($test_nbre);
    $test=$test_tab['nom_image'];
    if (!isset($test)) {$t=4;}
    elseif ($test<2) {$t=0;}
    else {$t=$test-1;}
    $p->code="'".$t."'";
    return $p;
}

?>