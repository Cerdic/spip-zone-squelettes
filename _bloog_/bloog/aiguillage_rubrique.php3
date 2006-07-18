<?php
//on analyse la valeur de la variable $squelette_rubrique
if($squelette_rubrique){
      if($restreint){
	  $squelette_rubrique="-".$squelette_rubrique."-restreint";
	  }else{
	  $squelette_rubrique="-".$squelette_rubrique;}
}else{
      if($restreint){
	  $squelette_rubrique="-restreint";
	  }else{
	  $squelette_rubrique="-normal";
}}

if($squelette_rubrique=="-forum"){

//on construit $fond en fonction de $squelette_rubrique
$fond = "_template/__rubrique".$squelette_rubrique;
$delais = 60 ;
include ("inc-public.php3");

} else {

//on construit $fond en fonction de $squelette_rubrique
$fond = "_template/__rubrique".$squelette_rubrique;
$delais = 3600*24*7 ;
include ("inc-public.php3");

}

?>