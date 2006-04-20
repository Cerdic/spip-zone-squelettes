<?php

//    Fichier créé pour SPIP avec un bout de code emprunté à celui ci.
//    Distribué sans garantie sous licence GPL./
//    Copyright (C) 2006  Jean Sébastien Barboteu
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


// critère {edito}
// permet d'affecter une rubrique spécifique pour les éditos
function critere_edito($idb, &$boucles, $crit) {
	$not = $crit->not;
	$boucle = &$boucles[$idb];
	
	// on va chercher la meta
	lire_metas();
	$var=$GLOBALS['meta']['id_edito'];
	if ($GLOBALS['meta']['activer_edito']='oui') {$id_edito=$var;} else {$id_edito=0;};
	
	
	if ($not)
		erreur_squelette(_T('zbug_info_erreur_squelette'), $crit->op);

	$boucle->where[]= array("'='", "'$boucle->id_table." . "id_rubrique'", $id_edito);
}

//critère {affiche_nb_articles}
//affichage des événements

function critere_affiche_nb_articles($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$var=$GLOBALS['meta']['nb_articles_nono'];
	$boucle->limit = '0, ' .$var. '' ;
}

//critère {affiche_nb_breves}
//affichage des événements

function critere_affiche_nb_breves($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$var=$GLOBALS['meta']['nb_breves_nono'];
	$boucle->limit = '0, ' .$var. '' ;
}

//critère {affiche_nb_sites}
//affichage des événements

function critere_affiche_nb_sites($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$var=$GLOBALS['meta']['nb_sites_nono'];
	$boucle->limit = '0, ' .$var. '' ;
}

//critère {affiche_nb_messages}
//affichage des événements

function critere_affiche_nb_messages($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$var=$GLOBALS['meta']['nb_messages_nono'];
	$boucle->limit = '0, ' .$var. '' ;

}

//critère {affiche_nb_syndic}
//affichage des événements

function critere_affiche_nb_syndic($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
 	$var=$GLOBALS['meta']['nb_syndic_nono'];
	$boucle->limit = '0, ' .$var. '' ;

}

//critère {affiche_nb_syndic}
//affichage des événements

function critere_affiche_nb_evens($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
 	$var=$GLOBALS['meta']['nb_evens_nono'];
	$boucle->limit = '0, ' .$var. '' ;

}


// critère {mes_logos}
// permet d'affecter un logo à un objet SPIP (rubrique, article, breve, site)

function balise_CALENDRIER_NONO($p) {
	
	$p->code = "\$GLOBALS['meta']['voir_calendrier_nono']";
	#$p->interdire_scripts = true;
	return $p;
}	



// balise #DIRECTEUR

function balise_DIRECTEUR_NONO($p) {
	
	$p->code = "\$GLOBALS['meta']['directeur_nono']";
	#$p->interdire_scripts = true;
	return $p;
}	

// balise #REDACTEUR

function balise_REDACTEUR_NONO($p) {
	
	$p->code = "\$GLOBALS['meta']['redacteur_nono']";
	#$p->interdire_scripts = true;
	return $p;
}	

// balise #COPYRIGHT

function balise_COPYRIGHT_NONO($p) {
	
	$p->code = "\$GLOBALS['meta']['copyright_nono']";
	#$p->interdire_scripts = true;
	return $p;
}	

// balise #KEYWORDS

function balise_KEYWORDS_NONO($p) {
	
	$p->code = "\$GLOBALS['meta']['keywords_nono']";
	#$p->interdire_scripts = true;
	return $p;
}	

// pour afficher mes boutons dans l'interface privée

function bouton_radio_nono($nom, $valeur, $titre, $actif = false) {
	static $id_label = 0;
	
	
	$texte = "<input type='radio' name='$nom' value='$valeur' id='label_$id_label'";
	if ($actif) {
		$texte .= ' checked="checked"';
		$titre = '<b>'.$titre.'</b>';
	}
	$texte .= " /> <label for='label_$id_label'>$titre</label>\n";
	$id_label++;
	return $texte;
}


?>