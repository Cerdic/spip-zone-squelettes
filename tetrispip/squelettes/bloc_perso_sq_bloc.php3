<?php 
include("sq_conf.php3");
$delais=3600;
//secu basique
if ((strstr($sq_squelette, '..'))||($INSECURE['sq_squelette'])) {
		die ("bloc = .. ?");
}
else $fond = $GLOBALS['dossier_template']."/_".$sq_squelette;
if ($contexte_inclus['bloc_delais']) $delais = $contexte_inclus['bloc_delais'];

$contexte_inclus['sq_typographie']=$sq_typographie;
$contexte_inclus['sq_couleur']=$sq_couleur;
$contexte_inclus['sq_id_rubrique']=$sq_id_rubrique;

//global $auteur_session;
if (isset($auteur_session['id_auteur']))
	$contexte_inclus['auteur_session_id']=$auteur_session['id_auteur'];
else $fond=$GLOBALS['dossier_template']."/blocs/login";

include ("inc-public.php3");
?>