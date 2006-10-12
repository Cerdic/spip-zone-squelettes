<?php

//    Fichier créé pour SPIP avec un bout de code emprunté à celui ci.
//    Distribué sans garantie sous licence GPL./
//    Copyright (C) 2006  Jean Sébastien Barboteu
//
//		code basé sur exec/config.php
//
//    This program is free software; you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation; either version 2 of the License, or any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with this program; if not, write to the Free Software
//    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

if (!defined("_ECRIRE_INC_VERSION")) return;
include_ecrire('inc/meta');

//
// Appliquer les valeurs par defaut pour les options non initialisees
//
function init_config_scola() {

	$liste_meta = array(
		'scola_base_version' => '0.2',
		
		'keywords_scola' => '',
		'copyright_scola' => '',
		'redacteur_scola' => '',
		'directeur_scola' => '',
		'contact_scola' => '',
		
		'nb_evens_scola' => '0',
		'voir_cal_scola' => 'non',
		'voir_une_scola' => 'non',
		'nb_articles_scola' => '3',
		'nb_breves_scola' => '2',
		'nb_sites_scola' => '0',
		'nb_syndic_scola' => '0',
		'nb_messages_scola' => '0',

		'voir_menu_scola' => 'non',
		'nom_menu1_scola' => '',
		'url_menu1_scola' => '',
		'nom_menu2_scola' => '',
		'url_menu2_scola' => '',
		'nom_menu3_scola' => '',
		'url_menu3_scola' => '',
		'nom_menu4_scola' => '',
		'url_menu4_scola' => '',
		'nom_menu5_scola' => '',
		'url_menu5_scola' => '',
		
		'activer_edito' => 'non',
		'id_edito' => '0',
		'activer_agenda' => 'non',
		'id_agenda' => '0',
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

function appliquer_modifs_scola() {
	global $scola_base_version, $keywords, $directeur_scola, $redacteur_scola, $contact_scola;
	global $activer_edito, $id_edito, $activer_agenda, $id_agenda,$activer_meslogos, $id_meslogos, $id_parent;
	global $voir_une_scola, $voir_menu_scola;
	global $nb_evens_scola, $nb_articles_scola, $nb_breves_scola, $nb_sites_scola, $nb_syndic_scola, $nb_messages_scola;
	global $nom_menu1_scola, $url_menu1_scola, $nom_menu2_scola, $url_menu2_scola, $nom_menu3_scola, $url_menu3_scola, $nom_menu4_scola, $url_menu4_scola, $nom_menu5_scola, $url_menu5_scola;

		
	$liste_meta_scola=array (

		'scola_base_version' ,
		
		'keywords_scola',
		'copyright_scola',
		'redacteur_scola',
		'directeur_scola',
		'contact_scola',
		
		'voir_menu_scola',
		'nom_menu1_scola',
		'url_menu1_scola',
		'nom_menu2_scola',
		'url_menu2_scola',
		'nom_menu3_scola',
		'url_menu3_scola',
		'nom_menu4_scola',
		'url_menu4_scola',
		'nom_menu5_scola',
		'url_menu5_scola',
				
		'activer_edito',
		'id_edito',
		'activer_agenda',
		'id_agenda',
		
		'activer_meslogos',
		'id_meslogos',
		
		'nb_evens_scola',
		'voir_cal_scola',
		'voir_une_scola',
		'nb_articles_scola',
		'nb_breves_scola',
		'nb_sites_scola',
		'nb_syndic_scola',
		'nb_messages_scola'

	);

	if (isset($id_parent)) ecrire_meta('id_edito',$id_parent);
	if (isset($id_parent)) ecrire_meta('id_agenda',$id_parent);

		
	while (list(,$i) = each($liste_meta_scola))
		if (isset($GLOBALS[$i])) ecrire_meta($i, $GLOBALS[$i]);

	// mise à zero id
	// évite les erreurs de critère
	// permet de faire des requetes vides -> boucles valides
	
	ecrire_metas();
	
	// purger les squelettes
	$purger_skel = true;
}

?>
