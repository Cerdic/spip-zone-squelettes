<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2006                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *

 *   modification faite des meta de Spip pour gérer les meta de Nono	   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;
include_ecrire('inc/meta');

//
// Appliquer les valeurs par defaut pour les options non initialisees
//
function init_config_nono() {

	$liste_meta = array(
		'nono_base_version' => '0.2',
		
		'keywords_nono' => '',
		'copyright_nono' => '',
		'redacteur_nono' => '',
		'directeur_nono' => '',
		
		'voir_agenda_nono' => 'non',
		'voir_calendrier_nono' => 'non',
		'voir_articles_nono' => 'oui',
		'voir_breves_nono' => 'oui',
		'voir_sites_nono' => 'non',
		'voir_syndic_nono'=> 'non',
		'voir_messages_nono' => 'non',

		
		'activer_edito' => 'non',
		'id_edito' => '0',
		'activer_meslogos' => 'non',
		'id_meslogos' => '0'
		
		
		
		);
	while (list($nom, $valeur) = each($liste_meta)) {
		if (!$GLOBALS['meta'][$nom]) {
			ecrire_meta($nom, $valeur);
			$modifs = true;
		}
	}

	if ($modifs) ecrire_metas();
}


//
// Gestion des modifs
//

function appliquer_modifs_nono() {
	global $nono_base_version,$keywords,$directeur_nono,$redacteur_nono;
	global $activer_edito,$id_edito,$activer_meslogos,$id_meslogos,$id_parent;
	global $voir_agenda_nono,$voir_calendrier_nono,$voir_articles_nono,$voir_breves_nono,$voir_sites_nono,$voir_syndic_nono,$voir_messages_nono;

	//include_spip(base/liste_meta_nono); // va chercher la liste des meta de nono
		
	$liste_meta_nono=array (

		'nono_base_version' ,
		
		'keywords_nono',
		'copyright_nono',
		'redacteur_nono',
		'directeur_nono',
				
		'activer_edito',
		'id_edito',
		
		'activer_meslogos',
		'id_meslogos',
		
		'voir_agenda_nono',
		'voir_calendrier_nono',
		'voir_articles_nono',
		'voir_breves_nono',
		'voir_sites_nono',
		'voir_syndic_nono',
		'voir_messages_nono'

	);

	if (isset($id_parent)) ecrire_meta('id_edito',$id_parent);
		
	while (list(,$i) = each($liste_meta_nono))
		if (isset($GLOBALS[$i])) ecrire_meta($i, $GLOBALS[$i]);

	

	// mise à zero id
	// évite les erreurs de critère
	// permet de faire des requetes vides -> boucles valides
	
	
	
	
	ecrire_metas();
}

?>
