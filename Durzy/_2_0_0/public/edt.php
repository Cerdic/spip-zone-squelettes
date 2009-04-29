<?php
/*
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *    propre à EDT
 *    Philippe Avi
 *   +-------------------------------------+ 
 *  
*/

// pour ratelier #[edt]#
function edt($string){
$res =  substr ($string, 8); //enleve le chemin

$res2 =  strpos   ($res, "edt");//enleve ce qui est aprés EDT
if ($res2 != 0) {
$res = substr ($res, 0, $res2);
}

$res3 =  strpos   ($res, "_m_46__");//affiche M.
if ($res3 != 0) {
$res ="M. ".substr ($res, 0, $res3);
}

$res3 =  strpos   ($res, "_mme_");//affiche Mme
if ($res3 != 0) {
$res ="Mme ".substr ($res, 0, $res3);
}

$res3 =  strpos   ($res, "_mlle_");//affiche Mlle
if ($res3 != 0) {
$res ="Mlle ".substr ($res, 0, $res3);
}

$res2 =  strpos   ($res, "_233_");//remplace les é
if ($res2 != 0) {
$res4 = strstr($res, "_233_");
$res4 = substr_replace($res4, '', 0,5);
$res = substr_replace($res, '&eacute;', $res2).$res4;
}

$res2 =  strpos   ($res, "_201_");//remplace les É
if ($res2 != 0) {
$res4 = strstr($res, "_201_");
$res4 = substr_replace($res4, '', 0,5);
$res = substr_replace($res, '&eacute;', $res2).$res4;
}

$res2 =  strpos   ($res, "_232_");//remplace les è
if ($res2 != 0) {
$res4 = strstr($res, "_232_");
$res4 = substr_replace($res4, '', 0,5);
$res = substr_replace($res, 'è', $res2).$res4;
}

$res2 =  strpos   ($res, "_32_");//remplace les -
if ($res2 != 0) {
$res4 = strstr($res, "_32_");
$res4 = substr_replace($res4, '', 0,4);
$res = substr_replace($res, '-', $res2).$res4;
}

$res2 =  strpos   ($res, "_45_");//remplace les espaces
if ($res2 != 0) {
$res4 = strstr($res, "_45_");
$res4 = substr_replace($res4, '', 0,4);
$res = substr_replace($res, '-', $res2).$res4;
}

$res = strtr($res, "_", " ");//remplace _ par espace

return($res);}//retourne le résultat
?>
