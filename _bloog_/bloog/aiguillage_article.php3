<?php

//on analyse la valeur de la variable $squelette_article


if($squelette_article){
      if($restreint){
	  $squelette_article="-".$squelette_article."-restreint";
	  }else{
	  $squelette_article="-".$squelette_article;}
}else{
      if($restreint){
	  $squelette_article="-restreint";
	  }else{
	  $squelette_article="-normal";
}}


if(($restreint) OR ($squelette_article == "-photo") OR ($squelette_article == "-forum")){

//on construit $fond en fonction de $squelette_article
$fond = "_template/__article".$squelette_article;
$delais = 1 ;


include ("inc-public.php3");
} else {

//on construit $fond en fonction de $squelette_article
$fond = "_template/__article".$squelette_article;
$delais = 7*3600*24;


include ("inc-public.php3");


}



?>
