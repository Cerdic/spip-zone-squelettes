<?php

//
// Recuperer le sous-repertoire d'installation
//
if (preg_match(',/([^/]*)/[^/]*$,', __FILE__, $r)) 
	define('SPIKINI', $r[1].'/');
else 
	define('SPIKINI', 'spikini/');

chdir ('../');

//
// Detecter spip vs. spip-lab
//
if (@file_exists('ecrire/inc_version.php3')) 
	define('SPIP_LAB', 0);
else if (@file_exists('inc.php')) 
	define('SPIP_LAB', 1);
else {
	die("Aucun spip ni spip-lab n'est install&eacute; dans le r&eacute;pertoire parent. Impossible d'utiliser Spikini.");
}

//
// Inclure les fichiers spip de base
//
if (SPIP_LAB) {
	include("inc.php");
	spip_connect();
	include_spip("calcul.php");
	
	define('SPIP_LOGIN', 'spip_login.php');
	define('SPIP_COOKIE', 'spip_cookie.php');
}
else {
	include('ecrire/inc_version.php3');
	
	// ;))
	function include_spip($fichier) {
		include_ecrire("inc_".$fichier."3");
	}

	include_ecrire('inc_connect.php3');
	include_local('inc-calcul.php3');

	define('SPIP_LOGIN', 'spip_login.php3');
	define('SPIP_COOKIE', 'spip_cookie.php3');
}


//
// Authentification spip
//
if ($HTTP_COOKIE_VARS['spip_session'] OR ($PHP_AUTH_USER AND !$ignore_auth_http)) {
	include_spip('session.php');
	verifier_visiteur();
	$cs= lire_meta('charset');
	if($cs!="iso-8859-1") {
		include_spip('charsets.php');
		$auteur_session['nom']= charset2unicode($auteur_session['nom']);
	}
}


// Hacks pour ne pas trop perturber wakka.php
unset($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING']);
$_SERVER['PHP_SELF'] = str_replace('/index.php', '/wakka.php', $_SERVER['PHP_SELF']);
$_SERVER['PHP_SELF'] = str_replace('/multi.php', '/wakka.php', $_SERVER['PHP_SELF']);


?>
