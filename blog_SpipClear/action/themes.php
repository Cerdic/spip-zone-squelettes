<?php

//spip.php?action=themes&choix=1&url=spip.php?article1

function action_themes() {
	include_spip('inc/actions');
	include_spip('inc/cookie');
	
 $un_an = 365*24*3600; // un an en secondes.


 $redirect = verifier_url_retour(_request('url'));
 $choix = verifier_choix_theme(_request('choix'));

 $duree = $choix != '' ? time() + $un_an : time() - 1;

 spip_setcookie('spip_themes', $choix, $duree);

 if (ereg("^Apache", $GLOBALS['SERVER_SOFTWARE'])) {
 	redirige_par_entete($redirect);
 }
 else {
 	include_spip('inc/headers');
 	spip_header("Refresh: 0; url=" . $redirect);
 	echo "<html><head>";
 	echo "<meta http-equiv='Refresh' content='0; url=".$redirect."'>";
 	echo "</head>\n";
 	echo "<body><a href='".$redirect."'>"._T('navigateur_pas_redirige')."</a></body></html>";
 }
}

function verifier_choix_theme($choix) {
 return $choix;
}

function verifier_url_retour($url) {

			spip_log($log_referer = $_SERVER['HTTP_REFERER'], 'themes');

 return 	'/spip_dev/spip.php?article1'; //$url;
}

?>