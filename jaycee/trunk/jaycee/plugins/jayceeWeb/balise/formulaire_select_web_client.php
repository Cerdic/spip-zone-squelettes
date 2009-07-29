<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2007                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;	#securite

function balise_FORMULAIRE_SELECT_WEB_CLIENT ($p) {
	$cookieWebClient = $_COOKIE['prefWebClient'];
	return calculer_balise_dynamique($p,'FORMULAIRE_SELECT_WEB_CLIENT', array( $cookieWebClient));
}

function balise_FORMULAIRE_SELECT_WEB_CLIENT_stat($args, $filtres) {
	return $args;
}

function balise_FORMULAIRE_SELECT_WEB_CLIENT_dyn($cookieWebClient ) {
	
	if ( (_request( 'submitWebClient') == 'OK') ) {
		setcookie( 'prefWebClient', _request( 'selectWebClient'), time()+ 3600 * 24 * 365, "/");
		$lsReferer = self();
		$lsReferer = parametre_url( $lsReferer, 'selectWebClient', ''); 
		$lsReferer = parametre_url( $lsReferer, 'submitWebClient', ''); 
		Header("Location:$lsReferer");
	}

	return 
		array('formulaires/select_web_client', 0,
			array(
			)
		);
}
?>
