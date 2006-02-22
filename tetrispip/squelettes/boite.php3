<?php 
include("sq_conf.php3");
$delais=3600;
//secu basique
if (strstr($contexte_inclus['bloc'], '..')) {
		die ("bloc = .. ?");
}
else $fond = $GLOBALS['dossier_template']."/blocs/".$contexte_inclus['bloc'];
if ($contexte_inclus['bloc_delais']) $delais = $contexte_inclus['bloc_delais'];

$contexte_inclus['sq_typographie']=$sq_typographie;
$contexte_inclus['sq_couleur']=$sq_couleur;
$contexte_inclus['sq_id_rubrique']=$sq_id_rubrique;
$contexte_inclus['current_date']=date('Y-m-d H:i:s');
//echo $GLOBALS['auteur_session']['statut'];
//echo "!!!".serialize($GLOBALS['auteur_session']);
if (($GLOBALS['auteur_session']['statut']=="0minirezo")
	||($GLOBALS['auteur_session']['statut']=="1comite")
	||($GLOBALS['auteur_session']['statut']=="6forum"))
	$contexte_inclus['auteur_session_id']=$GLOBALS['auteur_session']['id_auteur'];
else 
	if ($contexte_inclus['bloc_public'])
		$fond=$GLOBALS['dossier_template']."/blocs/".$contexte_inclus['bloc_public'];
	else $fond=$GLOBALS['dossier_template']."/blocs/login";

if (isset($arg))$contexte_inclus['arg']=$arg;
include ("inc-public.php3");
?>