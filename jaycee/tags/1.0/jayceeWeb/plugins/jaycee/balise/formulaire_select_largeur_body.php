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

function balise_FORMULAIRE_SELECT_LARGEUR_BODY ($p) {
	$cookieBodyWidth = $_COOKIE['prefBodyWidth'];
	return calculer_balise_dynamique($p,'FORMULAIRE_SELECT_LARGEUR_BODY', array( $cookieBodyWidth));
}

function balise_FORMULAIRE_SELECT_LARGEUR_BODY_stat($args, $filtres) {
	return $args;
}

function balise_FORMULAIRE_SELECT_LARGEUR_BODY_dyn($cookieBodyWidth ) {
	
	if ( (_request( 'submitBodyWidth') == 'OK') ) {
		setcookie( 'prefBodyWidth', _request( 'selectBodyWidth'), time()+ 3600 * 24 * 365, "/");
		$lsReferer = self();
		$lsReferer = parametre_url( $lsReferer, 'selectBodyWidth', ''); 
		$lsReferer = parametre_url( $lsReferer, 'submitBodyWidth', ''); 
		Header("Location:$lsReferer");
	}

	return 
		array('formulaires/select_largeur_body', 0,
			array(
			)
		);
}
?>
