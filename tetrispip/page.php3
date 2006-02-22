<?php
include("sq_conf.php3");
$flag_preserver=true;
// Appel spip
if (!function_exists('find_in_path')) {
	define('_SPIP_PAGE',1); # ne pas mourir si on passe le $fond  
	include ('ecrire/inc_version.php3');
}
// Reglage du $fond
if (isset($contexte_inclus['fond'])){
	// Securite 
	if (strstr($fond, '/')) die ("Faut pas se gener");
	$fond = $GLOBALS['dossier_template']."/".$contexte_inclus['fond'];
}
else if (isset($_GET["fond"])){
	// Securite 
	if (strstr($fond, '/')) die ("Faut pas se gener");
	$fond = $GLOBALS['dossier_template']."/".$_GET["fond"];
}
else
	$fond = '404';

// Reglage du $delais
// par defaut : la valeur existante (inclusion) ou sinon SPIP fera son reglage
if (isset($_GET["delais"])) $delais = $_GET["delais"];
else if (isset($contexte_inclus['delais'])) $delais = $contexte_inclus['delais'];
else $delais = 3600;

if (!find_in_path($fond.".html")) {
	spip_log("page.php3: find_in_path ne trouve pas le squelette $fond");
	$fond = '404';
}
if (isset($auteur_session['statut'])){
	$contexte_inclus['private']=true;
	@header('Expires: Mon, 26 Jul 1997 05:00:00 GMT') ;
	@header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT') ;
	// HTTP/1.0
	@header('Pragma: no-cache') ;
	@header("Cache-Control: no-cache, must-revalidate"); 
	@header('Cache-Control: post-check=0, pre-check=0', false) ;
}
//else {echo "test";}
include ("inc-public.php3");

?>