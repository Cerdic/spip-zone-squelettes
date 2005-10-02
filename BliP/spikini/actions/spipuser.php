<?php

### EUH C'EST QUOI CE TRUC ??

	if ($GLOBALS['auteur_session']){
		echo "Vous êtes enregistré ".$GLOBALS['auteur_session']['nom'];
	} else {
		echo "<iframe
		include_local('inc-login.php3');
		login();
	}
?>