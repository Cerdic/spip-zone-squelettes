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
function init_config_nono() {

	$liste_meta = array(
		'nono_base_version' => '0.2',
		
		'keywords_nono' => '',
		'copyright_nono' => '',
		'redacteur_nono' => '',
		'directeur_nono' => '',
		
		'nb_evens_nono' => '0',
		'voir_cal_nono' => 'non',
		'voir_une_nono' => 'non',
		'nb_articles_nono' => '3',
		'nb_breves_nono' => '2',
		'nb_sites_nono' => '0',
		'nb_syndic_nono' => '0',
		'nb_messages_nono' => '0',

		'voir_menu_nono' => 'non',
		'nom_menu1_nono' => '',
		'url_menu1_nono' => '',
		'nom_menu2_nono' => '',
		'url_menu2_nono' => '',
		'nom_menu3_nono' => '',
		'url_menu3_nono' => '',
		'nom_menu4_nono' => '',
		'url_menu4_nono' => '',
		'nom_menu5_nono' => '',
		'url_menu5_nono' => '',
		
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
	global $nono_base_version, $keywords, $directeur_nono, $redacteur_nono;
	global $activer_edito, $id_edito, $activer_meslogos, $id_meslogos, $id_parent;
	global $voir_une_nono, $voir_cal_nono, $voir_menu_nono;
	global $nb_evens_nono, $nb_articles_nono, $nb_breves_nono, $nb_sites_nono, $nb_syndic_nono, $nb_messages_nono;
	global $nom_menu1_nono, $url_menu1_nono, $nom_menu2_nono, $url_menu2_nono, $nom_menu3_nono, $url_menu3_nono, $nom_menu4_nono, $url_menu4_nono, $nom_menu5_nono, $url_menu5_nono;

		
	$liste_meta_nono=array (

		'nono_base_version' ,
		
		'keywords_nono',
		'copyright_nono',
		'redacteur_nono',
		'directeur_nono',
		
		'voir_menu_nono',
		'nom_menu1_nono',
		'url_menu1_nono',
		'nom_menu2_nono',
		'url_menu2_nono',
		'nom_menu3_nono',
		'url_menu3_nono',
		'nom_menu4_nono',
		'url_menu4_nono',
		'nom_menu5_nono',
		'url_menu5_nono',
				
		'activer_edito',
		'id_edito',
		
		'activer_meslogos',
		'id_meslogos',
		
		'nb_evens_nono',
		'voir_cal_nono',
		'voir_une_nono',
		'nb_articles_nono',
		'nb_breves_nono',
		'nb_sites_nono',
		'nb_syndic_nono',
		'nb_messages_nono'

	);

	if (isset($id_parent)) ecrire_meta('id_edito',$id_parent);
		
	while (list(,$i) = each($liste_meta_nono))
		if (isset($GLOBALS[$i])) ecrire_meta($i, $GLOBALS[$i]);

	// mise à zero id
	// évite les erreurs de critère
	// permet de faire des requetes vides -> boucles valides
	
	ecrire_metas();
	
	// purger les squelettes
	$purger_skel = true;
}

?>
