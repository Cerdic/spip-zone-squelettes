<?php

//    Fichier créé pour SPIP avec un bout de code emprunté à celui ci.
//    Distribué sans garantie sous licence GPL./
//    Jean Sébastien Barboteu
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

// réécriture des URLs

$type_urls='propres2';

// critère {edito}
// permet d'affecter une rubrique spécifique pour les éditos

function critere_edito($idb, &$boucles, $crit) {
	$not = $crit->not;
	$boucle = &$boucles[$idb];
	
	$var=$GLOBALS['meta']['id_edito'];
	
	if ($GLOBALS['meta']['activer_edito']=='oui') {$id_edito=$var;} else {$id_edito=0;};
	
	if ($not)
		erreur_squelette(_T('zbug_info_erreur_squelette'), $crit->op);

	$boucle->where[]= array("'='", "'$boucle->id_table." . "id_rubrique'", $id_edito);
}

//critère agenda
// permet d'affecter une rubrique spécifique pour les événements

function critere_agenda($idb, &$boucles, $crit) {
	$not = $crit->not;
	$boucle = &$boucles[$idb];
	
	$var=$GLOBALS['meta']['id_agenda'];
	
	if ($GLOBALS['meta']['activer_agenda']=='oui') {$id_agenda=$var;} else {$id_agenda=0;};
	
	if ($not)
		erreur_squelette(_T('zbug_info_erreur_squelette'), $crit->op);

	$boucle->where[]= array("'='", "'$boucle->id_table." . "id_rubrique'", $id_agenda);
}



// critère {une}
// permet d'affecter une rubrique spécifique pour les éditos
function critere_une($idb, &$boucles, $crit) {
	$not = $crit->not;
	$boucle = &$boucles[$idb];
	
	if ($GLOBALS['meta']['voir_une_scola']=='oui') {$var=1;} else {$var=0;};
	
	if ($not)
		erreur_squelette(_T('zbug_info_erreur_squelette'), $crit->op);

	$boucle->limit = '0, ' .$var ;
}


//critère {affiche_nb_articles}


function critere_affiche_nb_articles($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$var=$GLOBALS['meta']['nb_articles_scola'];
	$boucle->limit = '0, ' .$var ;
}

//critère {affiche_nb_breves}

function critere_une_breves($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$var=$GLOBALS['meta']['nb_breves_scola'];
	if ($var>1) {$var=1;};
	$boucle->limit = '0, ' .$var;
}


function critere_affiche_nb_breves($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$var=$GLOBALS['meta']['nb_breves_scola'];
	if ($var==1) {$var=0;};
	$boucle->limit = '0, ' .$var;
}

//critère {affiche_nb_sites}


function critere_affiche_nb_sites($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$var=$GLOBALS['meta']['nb_sites_scola'];
	$boucle->limit = '0, ' .$var;
}

//critère {affiche_nb_messages}


function critere_affiche_nb_messages($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$var=$GLOBALS['meta']['nb_messages_scola'];
	$boucle->limit = '0, ' .$var ;

}

//critère {affiche_nb_syndic}
//affichage des événements

function critere_affiche_nb_syndic($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
 	$var=$GLOBALS['meta']['nb_syndic_scola'];
	$boucle->limit = '0, ' .$var ;

}

//critère {affiche_nb_syndic}
//affichage des événements

function critere_affiche_nb_evens($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
 	$var=$GLOBALS['meta']['nb_evens_scola'];
	$boucle->limit = '0, '.$var ;

}


// critère {mes_logos}
// permet d'affecter un logo à un objet SPIP (rubrique, article, breve, site)

function critere_mes_logos($idb, &$boucles, $crit) {

	
	if ($GLOBALS['meta']['activer_meslogos']=='oui') {$var=$GLOBALS['meta']['id_meslogos'];} else {$var=0;};
	
	if ($not)
		erreur_squelette(_T('zbug_info_erreur_squelette'), $crit->op);

	$boucle->where[]= array("'='", "'$boucle->id_table." . "id_groupe'", $var);
	
}



// balise #MENU_NONO

function scola_lien_menu($test,$url,$nom) {

	if	($test=='oui') {
						if ($url<>'') {$p= "<a href='".$url."' class='bouton'>".$nom."</a>\n";}
						};
	return $p;
}


function balise_MENU_SCOLA($p) {
	$blanc="";
	if ($GLOBALS['meta']['voir_menu_scola']=='oui') {
		$p->code = "
				   scola_lien_menu(\$GLOBALS['meta']['voir_menu_scola'],\$GLOBALS['meta']['url_menu1_scola'],\$GLOBALS['meta']['nom_menu1_scola'])
                   .scola_lien_menu(\$GLOBALS['meta']['voir_menu_scola'],\$GLOBALS['meta']['url_menu2_scola'],\$GLOBALS['meta']['nom_menu2_scola'])
                   .scola_lien_menu(\$GLOBALS['meta']['voir_menu_scola'],\$GLOBALS['meta']['url_menu3_scola'],\$GLOBALS['meta']['nom_menu3_scola'])
 		           .scola_lien_menu(\$GLOBALS['meta']['voir_menu_scola'],\$GLOBALS['meta']['url_menu4_scola'],\$GLOBALS['meta']['nom_menu4_scola'])
                   .scola_lien_menu(\$GLOBALS['meta']['voir_menu_scola'],\$GLOBALS['meta']['url_menu5_scola'],\$GLOBALS['meta']['nom_menu5_scola'])"
	  
	 ;} else {$p -> code="\$blanc";};
		
	#$p->interdire_scripts = true;
	return $p;
	
}


// balise #DIRECTEUR

function balise_DIRECTEUR_SCOLA($p) {
	
	
	$p->code = "\$GLOBALS['meta']['directeur_scola']";
	#$p->interdire_scripts = true;
	return $p;
}	

// balise #REDACTEUR

function balise_REDACTEUR_SCOLA($p) {
	
	$p->code = "\$GLOBALS['meta']['redacteur_scola']";
	#$p->interdire_scripts = true;
	return $p;
}	

// balise #COPYRIGHT

function balise_COPYRIGHT_SCOLA($p) {
	
	$p->code = "\$GLOBALS['meta']['copyright_scola']";
	#$p->interdire_scripts = true;
	return $p;
}	

// balise #KEYWORDS

function balise_KEYWORDS_SCOLA($p) {
	
	$p->code = "\$GLOBALS['meta']['keywords_scola']";
	#$p->interdire_scripts = true;
	return $p;
}	

// balise #CONTACT

function balise_CONTACT_SCOLA($p) {
	
	$p->code = "\$GLOBALS['meta']['contact_scola']";
	#$p->interdire_scripts = true;
	return $p;
}	

// insert du bandeau

function afficher_bandeau($type, $id_objet, $id, $texteon, $script) {
	global $spip_display;

	if ($spip_display != 4) {
	
	  $redirect = generer_url_ecrire($script, "$id_objet=$id", true);
		$logon = $type.'on'.$id;
		
		include_spip('inc/session');
		echo "<p>";
		debut_cadre_relief("image-24.gif");
		echo "<div class='verdana1' style='text-align: center;'>";
		$desc = afficher_logo($logon, $texteon, $type, 'on', $id, $redirect);

		echo "</div>";
		fin_cadre_relief();
		echo "</p>";
	}
}

// Le selecteur de rubriques en mode classique (menu)
function selecteur_groupe_html($id) {

$query="SELECT id_groupe,titre FROM spip_groupes_mots ORDER BY titre";
$result=spip_query($query);
echo "<br><SELECT name='id_meslogos' \nstyle='font-size: 90%; width: 99%; font-face: verdana,arial,helvetica,sans-serif; max-height: 24px;'>";
while ($row=spip_fetch_array($result)) {
	echo "<OPTION ".mySel($row['id_groupe'],$id).">".$row['titre']."</OPTION>\n";

	}
echo "</select>";
}


?>