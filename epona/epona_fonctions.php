<?php

/*
 *   Accorde le nom singulier 'nom' avec 'nombre'
 *   Exemple : [#TOTAL_BOUCLE (#TOTAL_BOUCLE|accorder{article})]
 *    retourne '1 article' ou '7 articles' suivant #TOTAL_BOUCLE
 *   25 Mars 2004 - Marc Lebas (mlebas@labeille.net)
*/
function epona_accorder ($nombre, $nom) {
  switch ($nombre) {
    case 0 : return ""; 
    case 1 : return $nombre."&nbsp;".$nom;
    default : return $nombre."&nbsp;".$nom."s";
  }
}

?>
