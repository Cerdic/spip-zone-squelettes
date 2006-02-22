<?php 
include("sq_conf.php3");
$delais=3600;
//secu basique
if (strstr($contexte_inclus['bloc'], '..')) {
		die ("bloc = .. ?");
}
else $fond = $GLOBALS['dossier_template']."/blocs/".$contexte_inclus['bloc'];
if ($contexte_inclus['bloc_delais']) $delais = $contexte_inclus['bloc_delais'];
$contexte_inclus['current_date']=date('Y-m-d');

//pour avoir un cache par statut
//$contexte_inclus['statut']=$auteur_session['statut'];

include ("inc-public.php3");
?>