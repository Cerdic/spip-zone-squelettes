<?php

//on analyse la valeur de la variable $squelette_rubrique
if($squelette_rubrique){
      $squelette_rubrique="-".$squelette_rubrique;
}else{
      $squelette_rubrique="-defaut";
}

//on construit $fond en fonction de $squelette_rubrique
$fond = "sous_rubrique".$squelette_rubrique;
$delais = 24 * 3600;

include ("inc-public.php");

?>