<?php
/******************************************************************
***  Ce plugin EVA_habillage, crיי par Olivier Gautier, est mis ***
***      א disposition sous un contrat Creative Commons BY      *** 
***                 consultable א l'adresse                     ***
***      http://www.creativecommons.org/licenses/by/2.0/fr/     ***
******************************************************************/
function balise_EVAARTICLECOMPTEUR($p) { 
    $test_nav=spip_query("SELECT nom_image FROM eva_habillage_images WHERE nom_habillage='Defaut' AND type='bloc' AND nom_div ='article_compteur'");
    $test_tab=spip_fetch_array($test_nav);
    $test=$test_tab['nom_image'];
    if ($test=='gauche') {$p->code = "'gauche'"; return $p;}
    elseif ($test=='droite') {$p->code = "'droite'"; return $p;}
    elseif ($test=='centre') {$p->code = "'centre'"; return $p;}
    elseif ($test=='non') {$p->code = "'non'"; return $p;}
    else {return;}
}

?>