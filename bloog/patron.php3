<?php

if (!$patron) $patron = $_GET["patron"] ;
if (!$date) $date = $_GET["date"] ;

$contexte_inclus['date']= $date ;

if($format == "texte") {header("Location: patron-texte.php3?patron=$patron&date=$date");exit();}
$fond = "patrons/$patron";
$delais = 1;
$flag_preserver=true ;

include ("inc-public.php3");


?>
