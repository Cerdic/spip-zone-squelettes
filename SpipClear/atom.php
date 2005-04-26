<?php
$fond = "atom";
$delais = 0 * 3600;

// cette ligne empeche l'affichage des boutons d'administration
$flag_preserver = true;

@header("Content-type: application/atom+xml");

include ("inc-public.php3");

?>
