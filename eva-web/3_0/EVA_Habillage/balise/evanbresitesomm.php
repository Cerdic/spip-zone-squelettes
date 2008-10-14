<?php
/******************************************************************
***  Ce plugin EVA_habillage, crיי par Olivier Gautier, est mis ***
***      א disposition sous un contrat Creative Commons BY      *** 
***                 consultable א l'adresse                     ***
***      http://www.creativecommons.org/licenses/by/2.0/fr/     ***
******************************************************************/
function balise_EVANBRESITESOMM($p) {
    $test_nbre=spip_query("SELECT nom_image FROM eva_habillage_images WHERE nom_habillage='Defaut' AND type='nbre' AND nom_div ='nbre_sommaire_sites'");
    $test_tab=spip_fetch_array($test_nbre);
    $test=$test_tab['nom_image'];
    if (!isset($test)) {$t=4;}
    elseif ($test<2) {$t=0;}
    else {$t=$test-1;}
    $p->code="'".$t."'";
    return $p;
}

?>