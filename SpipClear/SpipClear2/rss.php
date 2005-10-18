<?php
$fond = "rss";
$delais = 3600;

// cette ligne empeche l'affichage des boutons d'administration
$flag_preserver = true;

@header("Content-type: application/rss+xml");

include ("inc-public.php3");

?>
