<?php
/******************************************************************
***  Ce plugin EVA_habillage, crיי par Olivier Gautier, est mis ***
***      א disposition sous un contrat Creative Commons BY      *** 
***                 consultable א l'adresse                     ***
***      http://www.creativecommons.org/licenses/by/2.0/fr/     ***
******************************************************************/
function balise_EVANBREBREVEPAGBREVE($p) {
    $test_nbre=sql_select('nom_image','spip_eva_habillage_images',"nom_habillage='Defaut' AND type='nbre' AND nom_div ='nbre_breves_breve'");
    $test_tab=sql_fetch($test_nbre);
    $test=$test_tab['nom_image'];
    if (!isset($test)) {$t=5;}
    else {$t=$test;}
    $p->code="'".$t."'";
    return $p;
}

?>