<?php 
echo "/***************************".$contexte_inclus['bloc']."****************************/";
include("sq_conf.php3");
//secu basique
if (strstr($contexte_inclus['bloc'], '..')) {
		die ("bloc = .. ?");
}

//  valeurs par defaut
//TODO : verifier que c'est bien le delai du 
//squelette incluant qui est pris par defaut
$delais=3600;

$fond = $rep_fond."/_";

$contexte_inclus['sq_squelette']=$sq_squelette;
$contexte_inclus['sq_couleur']=$sq_couleur;
$contexte_inclus['sq_typographie']=$sq_typographie;

if ($contexte_inclus['bloc']) $fond = $GLOBALS['dossier_template']."/css/".$contexte_inclus['bloc'];
if ($contexte_inclus['bloc_delais']) $delais = $contexte_inclus['bloc_delais'];

include ("inc-public.php3");

?>