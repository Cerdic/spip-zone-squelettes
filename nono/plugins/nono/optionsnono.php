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

// critère {une}
// permet d'affecter une rubrique spécifique pour les éditos
function critere_une($idb, &$boucles, $crit) {
	$not = $crit->not;
	$boucle = &$boucles[$idb];
	
	if ($GLOBALS['meta']['voir_une_nono']=='oui') {$var=1;} else {$var=0;};
	
	if ($not)
		erreur_squelette(_T('zbug_info_erreur_squelette'), $crit->op);

	$boucle->limit = '0, ' .$var ;
}


//critère {affiche_nb_articles}
//affichage des événements

function critere_affiche_nb_articles($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$var=$GLOBALS['meta']['nb_articles_nono'];
	$boucle->limit = '0, ' .$var ;
}

//critère {affiche_nb_breves}
//affichage des événements

function critere_affiche_nb_breves($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$var=$GLOBALS['meta']['nb_breves_nono'];
	$boucle->limit = '0, ' .$var;
}

//critère {affiche_nb_sites}
//affichage des événements

function critere_affiche_nb_sites($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$var=$GLOBALS['meta']['nb_sites_nono'];
	$boucle->limit = '0, ' .$var;
}

//critère {affiche_nb_messages}
//affichage des événements

function critere_affiche_nb_messages($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$var=$GLOBALS['meta']['nb_messages_nono'];
	$boucle->limit = '0, ' .$var ;

}

//critère {affiche_nb_syndic}
//affichage des événements

function critere_affiche_nb_syndic($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
 	$var=$GLOBALS['meta']['nb_syndic_nono'];
	$boucle->limit = '0, ' .$var ;

}

//critère {affiche_nb_syndic}
//affichage des événements

function critere_affiche_nb_evens($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
 	$var=$GLOBALS['meta']['nb_evens_nono'];
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


//balise de test pour l'affichage du calendrier

function balise_CALENDRIER_NONO($p) {
	$test=$GLOBALS['meta']['voir_cal_nono'];
	$p->code = "mon_calendrier()";
	
	#$p->interdire_scripts = true;
	return $p;
}	

// balise #MENU_NONO

function lien_menu_nono($test,$url,$nom) {

	if	($test=='oui') {
						if ($url<>'') {$p= "<a href='".$url."' class='bouton'>".$nom."</a>\n";}
						};
	return $p;
}


function balise_MENU_NONO($p) {
	$blanc="";
	if ($GLOBALS['meta']['voir_menu_nono']=='oui') {
		$p->code = "
				   lien_menu_nono(\$GLOBALS['meta']['voir_menu_nono'],\$GLOBALS['meta']['url_menu1_nono'],\$GLOBALS['meta']['nom_menu1_nono'])
                   .lien_menu_nono(\$GLOBALS['meta']['voir_menu_nono'],\$GLOBALS['meta']['url_menu2_nono'],\$GLOBALS['meta']['nom_menu2_nono'])
                   .lien_menu_nono(\$GLOBALS['meta']['voir_menu_nono'],\$GLOBALS['meta']['url_menu3_nono'],\$GLOBALS['meta']['nom_menu3_nono'])
 		           .lien_menu_nono(\$GLOBALS['meta']['voir_menu_nono'],\$GLOBALS['meta']['url_menu4_nono'],\$GLOBALS['meta']['nom_menu4_nono'])
                   .lien_menu_nono(\$GLOBALS['meta']['voir_menu_nono'],\$GLOBALS['meta']['url_menu5_nono'],\$GLOBALS['meta']['nom_menu5_nono'])"
	  
	 ;} else {$p -> code="\$blanc";};
		
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

//================================================================================
//--------------------------------------------------------------------------------
//----------------------------debut du calendier----------------------------------
function mon_calendrier($param) {


	// est ce une date ? 
	if (intval($param)==0) $param=date("Y-m-d");
	$tmp = split ("-", $param);
	if (!(checkdate($tmp[1],$tmp[2],$tmp[0]))) {
		$param = date ("Y-m-d");
	}
	

	// formatage éventuel de param 
	$tmp = split (" ", $param);
	$param = $tmp[0];
	
	$paramTAB = split ("-", $param);
	
	// quelques variables à définir
		$onlydayofmonth = true; // si true, on affiche que les jours de ce mois
		$clicable = "agendajour.php3?id_rubrique=$agenda&amp;cal_date=";
		$clicable2 ="sommaire.php3?cal_date=";
		$clicable3 ="rubrique.php3?id_rubrique=$agenda&amp;cal_date=";
			// url de votre page listant tous les articles d'un jour donné
		$clicableformat = "%Y-%m-%d"; // format de la façon dont sont passés les arguments
		$displayweeknumber = false; // affiche ou non le n° de la semaine à gauche
		$displayweekdays = true; // affiche ou non L M M J V S D en haut

	// je trouve la date du premier article publié
	// la mettre en dur pour eviter une requete
	$tmp = split ("-", "2002-09-07");
	$datemin = mktime(0,0,0,$tmp[1],$tmp[2],$tmp[0]);
	
	
	// ajouter un mois et enlever un mois dateplus datemoins
	$dateplus = strtotime ($paramTAB[1]."/".$paramTAB[2]."/".$paramTAB[0]. "+1 month"); // noter la notation anglaise m/d/Y
	$dateplus1 = strtotime ($paramTAB[1]."/1/".$paramTAB[0]. "+1 month");  
	$datemoins = strtotime ($paramTAB[1]."/".$paramTAB[2]."/".$paramTAB[0]. "-1 month");
	
	
	// rectification éventuelle de $dateplus et $datemoins sur des dates possédant des articles
	//datemoins
	if ($datemoins >= $datemin) {
		$tmp = getdate ($datemoins);
		$querymoins = "SELECT substring(`date_redac`,1,10) as jour 	FROM spip_articles WHERE statut='publie' AND (id_secteur=$agenda) like  '".sprintf ("%04d",$tmp['year'])."-".sprintf ("%02d",$tmp['mon'])."%' order by date asc";
		$result = spip_query($querymoins); 
		if (@mysql_num_rows($result) == 0) {
			// on touche pas à datemoins tant pis
		} else {
			$row = mysql_fetch_array($result);
			$tmp = split ("-", $row['jour']);
			$datemoins = strtotime ($tmp[1]."/".$tmp[2]."/".$tmp[0]);
		}
	}
	// dateplus 
	if ($dateplus1 > (time())) {
		$tmp = getdate($dateplus);
		$queryplus = "SELECT substring(`date_redac`,1,10) as jour FROM spip_articles WHERE statut='publie' AND (id_secteur=$agenda) like ".sprintf ("%04d",$tmp['year'])."-".sprintf ("%02d",$tmp['mon'])."%' order by date asc";
		$result = spip_query($queryplus); 
		if (@mysql_num_rows($result) == 0) {
			// on touche pas à dateplus tant pis 
		} else {
			$row = mysql_fetch_array($result);
			$tmp = split ("-", $row['jour']);
			$dateplus = strtotime ($tmp[1]."/".$tmp[2]."/".$tmp[0]);
		}
	}
	// fin de la rectification 
	
	$tmp = $paramTAB[0]."-".$paramTAB[1]."-";
	$query = "SELECT substring(`date_redac`,9,2) as jour
				FROM spip_articles
				WHERE statut='publie' AND (id_secteur=$agenda)
					AND `date_redac` like '$tmp%'
					
					";
	
		$result = spip_query($query);
		if (mysql_num_rows($result) == 0) {
		//	exit ("pas d'articles pour le mois $tmp ? ARGGGG");
		}
	// on remplit $jActif[] de 1 pour chaque jour du mois courrant ayant un article publié	
		while($row = mysql_fetch_array($result)) {
			$jActif[intval($row['jour'])] = 1;
		}

		//var_dump ($jentierActif);
	
	
	// on affiche le calendrier
	$date = getdate (mktime(10,0,0,$paramTAB[1], $paramTAB[2], $paramTAB[0]));
	
		$sortie="";
    
		//On recupere le premier du mois
		$pmtime=mktime(10,0,0,$date["mon"],1,$date["year"]);
		$pm=getdate($pmtime);
    
		//Puis le numero du premier jour
		$nj=$pm["wday"];
    
		$mois  = array(1=>'janvier','f&eacute;vrier','mars','avril','mai','juin','juillet','ao&ucirc;t','septembre','octobre','novembre','d&eacute;cembre');
		//On affiche les titres
				
	    $sortie.="<div class='calend_mois'>";
	    if ($datemoins >= $datemin) {$date_mois= strtotime ($paramTAB[1]."/1/".$paramTAB[0]);  
		    $sortie .= "<a href='".$clicable2.strftime($clicableformat,$datemoins)."'><<</a>&nbsp;&nbsp;
	    <a href='".$clicable3.strftime($clicableformat,$date_mois)."'>".$mois[intval(strftime("%m", $pmtime))]."</a>";
	    } else {
		    $sortie .= "<<&nbsp;&nbsp;
	    <a href='".$clicable3.strftime($clicableformat,$dateplus)."'>".$mois[intval(strftime("%m", $pmtime))]."</a>";
	    }
	    if ($dateplus1 > (time())) {
		    $sortie.="
	    &nbsp;&nbsp;<a href='".$clicable2.strftime($clicableformat,$dateplus)."'>>></a>
	    \n";
	    } else {
		    $sortie .="&nbsp;&nbsp;<a href='".$clicable2.strftime($clicableformat,$dateplus)."'>>></a>
	    \n";
	    }
	    $sortie.="</div>\n";
	    
	    // à partir de là c'est copy colle !
		if ($displayweekdays) {
			$sortie.="<div class='calend_ligne'>\n";
			//if ($displayweeknumber) $sortie.="<div class='calend_titre'><br></div>";
			$sortie.="<div class='calend_titre'>L</div>\n";
			$sortie.="<div class='calend_titre'>M</div>\n";
			$sortie.="<div class='calend_titre'>M</div>\n";
			$sortie.="<div class='calend_titre'>J</div>\n";
			$sortie.="<div class='calend_titre'>V</div>\n";
			$sortie.="<div class='calend_titre'>S</div>\n";
			$sortie.="<div class='calend_titre'>D</div>\n";
			$sortie.="</div>\n";
			}

		//Correction: Le mois peut s'etaler sur 6 semaines
		$end=false;
		$debut=0;
		if ($nj<1) $debut=-1;
		for ($sem=$debut; !$end && $sem<=5; $sem++) {$sortie.="<div class='calend_ligne'>\n";
			for ($j=1; $j<=7; $j++) {
				$jjdate=@mktime(10,0,0,$date["mon"],1-$nj+$sem*7+$j,$date["year"]);
				$jj=@getdate($jjdate);

				

			$sortie.="<div";
			if ($jj["mon"]!=$date["mon"]) {
				$sortie .= " class='calend_outday'";
				} else {
				if ($jj["yday"]==$date["yday"]) {
					$sortie .= " class='calend_today'";
					} else {
					if ($jActif[$jj['mday']]) {
						if ($j>6) {
							$sortie .= " class='calend_activeweekendday'";
							} else {
							$sortie .= " class='calend_activeday'";
							}
						} else {
						if ($j>6) {
							$sortie .= " class='calend_weekendday'";
							} else {
							$sortie .= " class='calend_weekday'";
							}
						}
					}
				}
			$sortie.= ">";
			if (!$onlydayofmonth || $jj["mon"]==$date["mon"]) {
                if (($jActif[$jj['mday']]) && ($jj["mon"]==$date["mon"])) $sortie.="<a  href=\"$clicable".strftime($clicableformat, $jjdate)."\">";


				if ($jj["yday"]==$date["yday"]) $sortie.="".$jj["mday"]."";
					else $sortie.=$jj["mday"];
                
				if (($jActif[$jj['mday']]) && ($jj["mon"]==$date["mon"])) $sortie.="</a>";
            	} else $sortie.="";
            	$sortie.="</div>\n";
				}
			$sortie.="</div>\n";

		//Cas des mois sur 5 semaines
		$jj=@getdate(@mktime(10,0,0,$date["mon"],1-$nj+$sem*7+8,$date["year"]));
		if($jj["mon"]>$date["mon"] && $jj["year"]==$date["year"] || $jj["year"]>$date["year"]) $end=true;

	}
	$sortie.="";

	return $sortie;	
}

//=============================================================================================
//---------------------------------------------------------------------------------------------
//--------------------------------debut du calendier mois--------------------------------------

function calendrier_mois($param) {

	
	// est ce une date ? 
	if (intval($param)==0) $param=date("Y-m-d");
	$tmp = split ("-", $param);
	if (!(checkdate($tmp[1],$tmp[2],$tmp[0]))) {
		$param = date ("Y-m-d");
	}
	

	// formatage éventuel de param 
	$tmp = split (" ", $param);
	$param = $tmp[0];
	
	$paramTAB = split ("-", $param);
	
	// quelques variables à définir
		$onlydayofmonth = true; // si true, on affiche que les jours de ce mois
		$clicable = "agendajour.php3?id_rubrique=$agenda&amp;cal_date=";
		$clicable2 ="sommaire.php3?cal_date=";
		$clicable3 ="rubrique.php3?id_rubrique=$agenda&amp;cal_date=";
			// url de votre page listant tous les articles d'un jour donné
		$clicableformat = "%Y-%m-%d"; // format de la façon dont sont passés les arguments
		$displayweeknumber = false; // affiche ou non le n° de la semaine à gauche
		$displayweekdays = true; // affiche ou non L M M J V S D en haut

	// je trouve la date du premier article publié
	// la mettre en dur pour eviter une requete
	$tmp = split ("-", "2002-09-07");
	$datemin = mktime(0,0,0,$tmp[1],$tmp[2],$tmp[0]);
	
	
	// ajouter un mois et enlever un mois dateplus datemoins
	$dateplus = strtotime ($paramTAB[1]."/".$paramTAB[2]."/".$paramTAB[0]. "+1 month"); // noter la notation anglaise m/d/Y
	$dateplus1 = strtotime ($paramTAB[1]."/1/".$paramTAB[0]. "+1 month");  
	$datemoins = strtotime ($paramTAB[1]."/".$paramTAB[2]."/".$paramTAB[0]. "-1 month");
	
	
	// rectification éventuelle de $dateplus et $datemoins sur des dates possédant des articles
	//datemoins
	if ($datemoins >= $datemin) {
		$tmp = getdate ($datemoins);
		$querymoins = "SELECT substring(`date_redac`,1,10) as jour 	FROM spip_articles WHERE statut='publie' AND (id_secteur=$agenda) like  '".sprintf ("%04d",$tmp['year'])."-".sprintf ("%02d",$tmp['mon'])."%' order by date asc";
		$result = spip_query($querymoins); 
		if (@mysql_num_rows($result) == 0) {
			// on touche pas à datemoins tant pis
		} else {
			$row = mysql_fetch_array($result);
			$tmp = split ("-", $row['jour']);
			$datemoins = strtotime ($tmp[1]."/".$tmp[2]."/".$tmp[0]);
		}
	}
	// dateplus 
	if ($dateplus1 > (time())) {
		$tmp = getdate($dateplus);
		$queryplus = "SELECT substring(`date_redac`,1,10) as jour FROM spip_articles WHERE statut='publie' AND (id_secteur=$agenda) like ".sprintf ("%04d",$tmp['year'])."-".sprintf ("%02d",$tmp['mon'])."%' order by date asc";
		$result = spip_query($queryplus); 
		if (@mysql_num_rows($result) == 0) {
			// on touche pas à dateplus tant pis 
		} else {
			$row = mysql_fetch_array($result);
			$tmp = split ("-", $row['jour']);
			$dateplus = strtotime ($tmp[1]."/".$tmp[2]."/".$tmp[0]);
		}
	}
	// fin de la rectification 
	
	$tmp = $paramTAB[0]."-".$paramTAB[1]."-";
	$query = "SELECT substring(`date_redac`,9,2) as jour
				FROM spip_articles
				WHERE statut='publie' AND (id_secteur=$agenda) 
					AND `date_redac` like '$tmp%'
					
					";
	
		$result = spip_query($query);
		if (mysql_num_rows($result) == 0) {
		//	exit ("pas d'articles pour le mois $tmp ? ARGGGG");
		}
	// on remplit $jActif[] de 1 pour chaque jour du mois courrant ayant un article publié	
		while($row = mysql_fetch_array($result)) {
			$jActif[intval($row['jour'])] = 1;
		}

		//var_dump ($jentierActif);
	
	
	// on affiche le calendrier
	$date = getdate (mktime(10,0,0,$paramTAB[1], $paramTAB[2], $paramTAB[0]));
	
		$sortie="";
    
		//On recupere le premier du mois
		$pmtime=mktime(10,0,0,$date["mon"],1,$date["year"]);
		$pm=getdate($pmtime);
    
		//Puis le numero du premier jour
		$nj=$pm["wday"];
    
		$mois  = array(1=>'janvier','f&eacute;vrier','mars','avril','mai','juin','juillet','ao&ucirc;t','septembre','octobre','novembre','d&eacute;cembre');
		//On affiche les titres
				
	    $sortie.="<div class='calend_mois'>";
	    if ($datemoins >= $datemin) {$date_mois= strtotime ($paramTAB[1]."/1/".$paramTAB[0]);  
		    $sortie .= "<a href='".$clicable3.strftime($clicableformat,$datemoins)."'><<</a>&nbsp;&nbsp;
	    <a href=".$clicable3.strftime($clicableformat,$date_mois).">".$mois[intval(strftime("%m", $pmtime))]."</a>";
	    } else {
		    $sortie .= "<<&nbsp;&nbsp;
	    <a href=".$clicable3.strftime($clicableformat,$dateplus).">".$mois[intval(strftime("%m", $pmtime))]."</a>";
	    }
	    if ($dateplus1 > (time())) {
		    $sortie.="
	    &nbsp;&nbsp;<a href='".$clicable3.strftime($clicableformat,$dateplus)."'>>></a>
	    \n";
	    } else {
		    $sortie .="&nbsp;&nbsp;<a href='".$clicable3.strftime($clicableformat,$dateplus)."'>>></a>
	    \n";
	    }
	    $sortie.="</div>\n";
	    
	    // à partir de là c'est copy colle !
		if ($displayweekdays) {
			$sortie.="<div class='calend_ligne'>\n";
			//if ($displayweeknumber) $sortie.="<div class='calend_titre'><br></div>";
			$sortie.="<div class='calend_titre'>L</div>\n";
			$sortie.="<div class='calend_titre'>M</div>\n";
			$sortie.="<div class='calend_titre'>M</div>\n";
			$sortie.="<div class='calend_titre'>J</div>\n";
			$sortie.="<div class='calend_titre'>V</div>\n";
			$sortie.="<div class='calend_titre'>S</div>\n";
			$sortie.="<div class='calend_titre'>D</div>\n";
			$sortie.="</div>\n";
			}

		//Correction: Le mois peut s'etaler sur 6 semaines
		$end=false;
		$debut=0;
		if ($nj<1) $debut=-1;
		for ($sem=$debut; !$end && $sem<=5; $sem++) {$sortie.="<div class='calend_ligne'>\n";
			for ($j=1; $j<=7; $j++) {
				$jjdate=@mktime(10,0,0,$date["mon"],1-$nj+$sem*7+$j,$date["year"]);
				$jj=@getdate($jjdate);

				

			$sortie.="<div";
			if ($jj["mon"]!=$date["mon"]) {
				$sortie .= " class='calend_outday'";
				} else {
				if ($jj["yday"]==$date["yday"]) {
					$sortie .= " class='calend_weekday'";
					} else {
					if ($jActif[$jj['mday']]) {
						if ($j>6) {
							$sortie .= " class='calend_activeweekendday'";
							} else {
							$sortie .= " class='calend_activeday'";
							}
						} else {
						if ($j>6) {
							$sortie .= " class='calend_weekendday'";
							} else {
							$sortie .= " class='calend_weekday'";
							}
						}
					}
				}
			$sortie.= ">";
			if (!$onlydayofmonth || $jj["mon"]==$date["mon"]) {
                if (($jActif[$jj['mday']]) && ($jj["mon"]==$date["mon"])) $sortie.="<a  href=\"$clicable".strftime($clicableformat, $jjdate)."\">";


				if ($jj["yday"]==$date["yday"]) $sortie.="".$jj["mday"]."";
					else $sortie.=$jj["mday"];
                
				if (($jActif[$jj['mday']]) && ($jj["mon"]==$date["mon"])) $sortie.="</a>";
            	} else $sortie.="";
            	$sortie.="</div>\n";
				}
			$sortie.="</div>\n";

		//Cas des mois sur 5 semaines
		$jj=@getdate(@mktime(10,0,0,$date["mon"],1-$nj+$sem*7+8,$date["year"]));
		if($jj["mon"]>$date["mon"] && $jj["year"]==$date["year"] || $jj["year"]>$date["year"]) $end=true;

	}
	$sortie.="";

	return $sortie;	
}
//=============================================================================================
//---------------------------------------------------------------------------------------------
//--------------------------------debut du calendier jour--------------------------------------


function calendrier_jour($param) {

	include("nono_conf.txt");
	// est ce une date ? 
	if (intval($param)==0) $param=date("Y-m-d");
	$tmp = split ("-", $param);
	if (!(checkdate($tmp[1],$tmp[2],$tmp[0]))) {
		$param = date ("Y-m-d");
	}
	

	// formatage éventuel de param 
	$tmp = split (" ", $param);
	$param = $tmp[0];
	
	$paramTAB = split ("-", $param);
	
	// quelques variables à définir
		$onlydayofmonth = true; // si true, on affiche que les jours de ce mois
		$clicable = "agendajour.php3?id_rubrique=$agenda&amp;cal_date=";
		$clicable2 ="sommaire.php3?cal_date=";
		$clicable3 ="rubrique.php3?id_rubrique=$agenda&amp;cal_date=";
			// url de votre page listant tous les articles d'un jour donné
		$clicableformat = "%Y-%m-%d"; // format de la façon dont sont passés les arguments
		$displayweeknumber = false; // affiche ou non le n° de la semaine à gauche
		$displayweekdays = true; // affiche ou non L M M J V S D en haut

	// je trouve la date du premier article publié
	// la mettre en dur pour eviter une requete
	$tmp = split ("-", "2002-09-07");
	$datemin = mktime(0,0,0,$tmp[1],$tmp[2],$tmp[0]);
	
	
	// ajouter un mois et enlever un mois dateplus datemoins
	$dateplus = strtotime ($paramTAB[1]."/".$paramTAB[2]."/".$paramTAB[0]. "+1 month"); // noter la notation anglaise m/d/Y
	$dateplus1 = strtotime ($paramTAB[1]."/1/".$paramTAB[0]. "+1 month");  
	$datemoins = strtotime ($paramTAB[1]."/".$paramTAB[2]."/".$paramTAB[0]. "-1 month");
	
	
	// rectification éventuelle de $dateplus et $datemoins sur des dates possédant des articles
	//datemoins
	if ($datemoins >= $datemin) {
		$tmp = getdate ($datemoins);
		$querymoins = "SELECT substring(`date_redac`,1,10) as jour FROM spip_articles WHERE statut='publie' AND (id_secteur=$agenda) like  '".sprintf ("%04d",$tmp['year'])."-".sprintf ("%02d",$tmp['mon'])."%' order by date asc";
		$result = spip_query($querymoins); 
		if (@mysql_num_rows($result) == 0) {
			// on touche pas à datemoins tant pis
		} else {
			$row = mysql_fetch_array($result);
			$tmp = split ("-", $row['jour']);
			$datemoins = strtotime ($tmp[1]."/".$tmp[2]."/".$tmp[0]);
		}
	}
	// dateplus 
	if ($dateplus1 > (time())) {
		$tmp = getdate($dateplus);
		$queryplus = "SELECT substring(`date_redac`,1,10) as jour FROM spip_articles WHERE statut='publie' AND (id_secteur=$agenda) like ".sprintf ("%04d",$tmp['year'])."-".sprintf ("%02d",$tmp['mon'])."%' order by date asc";
		$result = spip_query($queryplus); 
		if (@mysql_num_rows($result) == 0) {
			// on touche pas à dateplus tant pis 
		} else {
			$row = mysql_fetch_array($result);
			$tmp = split ("-", $row['jour']);
			$dateplus = strtotime ($tmp[1]."/".$tmp[2]."/".$tmp[0]);
		}
	}
	// fin de la rectification 
	
	$tmp = $paramTAB[0]."-".$paramTAB[1]."-";
	$query = "SELECT substring(`date_redac`,9,2) as jour
				FROM spip_articles
				WHERE statut='publie' AND (id_secteur=$agenda) 
					AND `date_redac` like '$tmp%'
					
					";
	
		$result = spip_query($query);
		if (mysql_num_rows($result) == 0) {
		//	exit ("pas d'articles pour le mois $tmp ? ARGGGG");
		}
	// on remplit $jActif[] de 1 pour chaque jour du mois courrant ayant un article publié	
		while($row = mysql_fetch_array($result)) {
			$jActif[intval($row['jour'])] = 1;
		}

		//var_dump ($jentierActif);
	
	
	// on affiche le calendrier
	$date = getdate (mktime(10,0,0,$paramTAB[1], $paramTAB[2], $paramTAB[0]));
	
		$sortie="";
    
		//On recupere le premier du mois
		$pmtime=mktime(10,0,0,$date["mon"],1,$date["year"]);
		$pm=getdate($pmtime);
    
		//Puis le numero du premier jour
		$nj=$pm["wday"];
    
		$mois  = array(1=>'janvier','f&eacute;vrier','mars','avril','mai','juin','juillet','ao&ucirc;t','septembre','octobre','novembre','d&eacute;cembre');
		//On affiche les titres
				
	    $sortie.="<div class='calend_mois'>";
	    if ($datemoins >= $datemin) {$date_mois= strtotime ($paramTAB[1]."/1/".$paramTAB[0]); 
		                             $date_jour = strtotime ($paramTAB[1]."/".$paramTAB[2]."/".$paramTAB[0]. "+1 day");
									 $date_jour_mois = strtotime ($paramTAB[1]."/".$paramTAB[2]."/".$paramTAB[0]. "-1 day");
		    $sortie .= "<a href='".$clicable.strftime($clicableformat,$date_jour_mois)."'><<</a>&nbsp;&nbsp;
	    <a href=".$clicable3.strftime($clicableformat,$date_jour).">".$mois[intval(strftime("%m", $pmtime))]."</a>";
	    } else {
		    $sortie .= "<<&nbsp;&nbsp;
	    <a href=".$clicable.strftime($clicableformat,$date_jour).">".$mois[intval(strftime("%m", $pmtime))]."</a>";
	    }
	    if ($dateplus1 > (time())) {
		    $sortie.="
	    &nbsp;&nbsp;<a href='".$clicable.strftime($clicableformat,$date_jour)."'>>></a>
	    \n";
	    } else {
		    $sortie .="&nbsp;&nbsp;<a href='".$clicable.strftime($clicableformat,$date_jour)."'>>></a>
	    \n";
	    }
	    $sortie.="</div>\n";
	    
	    // à partir de là c'est copy colle !
		if ($displayweekdays) {
			$sortie.="<div class='calend_ligne'>\n";
			//if ($displayweeknumber) $sortie.="<div class='calend_titre'><br></div>";
			$sortie.="<div class='calend_titre'>L</div>\n";
			$sortie.="<div class='calend_titre'>M</div>\n";
			$sortie.="<div class='calend_titre'>M</div>\n";
			$sortie.="<div class='calend_titre'>J</div>\n";
			$sortie.="<div class='calend_titre'>V</div>\n";
			$sortie.="<div class='calend_titre'>S</div>\n";
			$sortie.="<div class='calend_titre'>D</div>\n";
			$sortie.="</div>\n";
			}

		//Correction: Le mois peut s'etaler sur 6 semaines
		$end=false;
		$debut=0;
		if ($nj<1) $debut=-1;
		for ($sem=$debut; !$end && $sem<=5; $sem++) {$sortie.="<div class='calend_ligne'>\n";
			for ($j=1; $j<=7; $j++) {
				$jjdate=@mktime(10,0,0,$date["mon"],1-$nj+$sem*7+$j,$date["year"]);
				$jj=@getdate($jjdate);

				

			$sortie.="<div";
			if ($jj["mon"]!=$date["mon"]) {
				$sortie .= " class='calend_outday'";
				} else {
				if ($jj["yday"]==$date["yday"]) {
					$sortie .= " class='calend_weekday'";
					} else {
					if ($jActif[$jj['mday']]) {
						if ($j>6) {
							$sortie .= " class='calend_activeweekendday'";
							} else {
							$sortie .= " class='calend_activeday'";
							}
						} else {
						if ($j>6) {
							$sortie .= " class='calend_weekendday'";
							} else {
							$sortie .= " class='calend_weekday'";
							}
						}
					}
				}
			$sortie.= ">";
			if (!$onlydayofmonth || $jj["mon"]==$date["mon"]) {
                if (($jActif[$jj['mday']]) && ($jj["mon"]==$date["mon"])) $sortie.="<a  href=\"$clicable".strftime($clicableformat, $jjdate)."\">";


				if ($jj["yday"]==$date["yday"]) $sortie.="".$jj["mday"]."";
					else $sortie.=$jj["mday"];
                
				if (($jActif[$jj['mday']]) && ($jj["mon"]==$date["mon"])) $sortie.="</a>";
            	} else $sortie.="";
            	$sortie.="</div>\n";
				}
			$sortie.="</div>\n";

		//Cas des mois sur 5 semaines
		$jj=@getdate(@mktime(10,0,0,$date["mon"],1-$nj+$sem*7+8,$date["year"]));
		if($jj["mon"]>$date["mon"] && $jj["year"]==$date["year"] || $jj["year"]>$date["year"]) $end=true;

	}
	$sortie.="";

	return $sortie;	
}


?>