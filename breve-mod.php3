<?php

//on analyse la valeur de la variable $squelette_rubrique
if($squelette_breve){
      $squelette_breve="-".$squelette_breve;
}else{
      $squelette_breve="-defaut";
}

//on construit $fond en fonction de $squelette_rubrique
$fond = "breve-mod".$squelette_breve;

$delais = 24*3600;

include ("inc-public.php3");

?>
