<?php

// paramètres pour le plugin diapo

//nombre de vignettes par page
$GLOBALS['diapo_vignettes']=15;

//largeur de la grande image :
$GLOBALS['diapo_grand']=400;

//largeur maxi de la photo :
$GLOBALS['diapo_petit']=300;
//hauteur maxi de la photo :
$GLOBALS['diapo_petit_h']=300;

//largeur et hauteur maxi des vignettes :
$GLOBALS['diapo_vignette']=60;

//diaporama : temps de pause en millisecondes :
$GLOBALS['diapo_temps']=3000;




   // remplace la classe css 'spip_out' par 'spip_in'
   // pour les liens vers le(s) domaine(s) '_DOMAINE_INT'
   function inc_lien($lien='', $texte='', $class='', $title='', $hlang='', $rel='', $connect='') {
     if (preg_match(',('._DOMAINE_INT.'),Ui', $lien)) {
       $class = 'spip_in';
     }
     return inc_lien_dist($lien, $texte, $class, $title, $hlang, $rel, $connect);
   }

?>