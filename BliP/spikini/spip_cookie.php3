<?php
	// simple changement de répertoire :(
	chdir('../');
	include('ecrire/inc_version.php3');
	$cookie_path = ereg_replace('[^/]*/[^/]*$', '', $REQUEST_URI);
	if (!$cookie_path) $cookie_path='/';
	include('spip_cookie.php3');
?>
