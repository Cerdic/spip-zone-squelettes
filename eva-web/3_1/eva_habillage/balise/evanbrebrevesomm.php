<?php
function balise_EVANBREBREVESOMM($p) {
    $test_nbre=sql_select('nom_image','spip_eva_habillage_images',"nom_habillage='Defaut' AND type='nbre' AND nom_div ='nbre_sommaire_breves'");
    $test_tab=sql_fetch($test_nbre);
    $test=$test_tab['nom_image'];
    if (!isset($test)) {$t=5;}
    else {$t=$test;}
    $p->code="'".$t."'";
    return $p;
}

?>