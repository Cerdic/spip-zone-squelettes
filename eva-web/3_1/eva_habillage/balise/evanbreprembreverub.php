<?php
function balise_EVANBREPREMBREVERUB($p) {
    $test_nbre=sql_select('nom_image','spip_eva_habillage_images',"nom_habillage='Defaut' AND type='nbre' AND nom_div ='nbre_rubrique_breves'");
    $test_tab=sql_fetch($test_nbre);
    $test=$test_tab['nom_image'];
    if ((isset($test)) AND ($test=='0')) {$t=0;}
    else {$t=1;}
    $p->code="'".$t."'";
    return $p;
}

?>