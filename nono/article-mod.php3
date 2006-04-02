<?php

//on analyse la valeur de la variable $squelette_article
if($squelette_article){
      $squelette_article="-".$squelette_article;
}else{
      $squelette_article="-defaut";
}

//on construit $fond en fonction de $squelette_article
$fond = "article-mod".$squelette_article;

if ($squelette_article="forum") {$temp=0;} else {$temp=24*3600;}

$delais = $temp;

include ("inc-public.php3");

?>
