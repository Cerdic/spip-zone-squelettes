<?php

//on analyse la valeur de la variable $squelette_rubrique
if($squelette_rubrique){
      $squelette_rubrique="-".$squelette_rubrique;
}else{
      $squelette_rubrique="-defaut";
}

//on construit $fond en fonction de $squelette_rubrique
$fond = "rubrique-mod".$squelette_rubrique;

if ($squelette_rubrique="forums") {$temp=0;} else {$temp=24*3600;}

$delais = $temp;

include ("inc-public.php3");

?>
