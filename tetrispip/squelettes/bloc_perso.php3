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
$contexte_inclus['current_date']=date('Y-m-d');
//echo $GLOBALS['auteur_session']['statut'];
//echo "!!!".serialize($GLOBALS['auteur_session']);
if (($GLOBALS['auteur_session']['statut']=="0minirezo")
	||($GLOBALS['auteur_session']['statut']=="1comite")
	||($GLOBALS['auteur_session']['statut']=="6forum")){
	$contexte_inclus['auteur_session_id']=$GLOBALS['auteur_session']['id_auteur'];
	$contexte_inclus['auteur_session_statut']=$GLOBALS['auteur_session']['statut'];
}
else { 
	if ($contexte_inclus['bloc_public'])
		$fond=$GLOBALS['dossier_template']."/blocs/".$contexte_inclus['bloc_public'];
	else $fond=$GLOBALS['dossier_template']."/blocs/login";
}
//echo "!!!".$fond."!!!";
include ("inc-public.php3");
?>