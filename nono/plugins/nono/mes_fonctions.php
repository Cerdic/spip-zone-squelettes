<?php

$GLOBALS['dossier_squelettes'] = 'nono';

//================================================================================
//--------------------------------------------------------------------------------
//----------------------------debut du calendier----------------------------------
function Nono_mon_calendrier($param) {

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

function Nono_calendrier_mois($param) {

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


function Nono_calendrier_jour($param) {

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



// affichage de la date

function Nono_date() {

$date1 = date("D");
$date2 = date("d");
$date3 = date("n");
$date4 = date("Y");


switch($date1)
  {
   case 'Mon':
        echo 'lundi '.$date2;
        break;

   case 'Tue':
        echo 'mardi '.$date2;
         break;

   case 'Wed':
         echo 'mercredi '.$date2;
         break;

   case 'Thu':
        echo 'jeudi '.$date2;
        break;

    case 'Fri':
         echo 'vendredi '.$date2;
        break;

   case 'Sat':
        echo 'samedi '.$date2;
        break;

   case 'Sun':
        echo 'dimanche '.$date2;
         break;

  }


switch($date3)
  {
   case '01':
        echo ' janvier '.$date4;
        break;

   case '02':
         echo ' f&eacute;vrier '.$date4;
        break;

   case '03':
         echo ' mars '.$date4;
        break;

   case '04':
         echo ' avril '.$date4;
        break;

   case '05':
        echo ' mai '.$date4;
        break;

   case '06':
         echo ' juin '.$date4;
        break;

   case '07':
         echo ' juillet '.$date4;
         break;

   case '08':
         echo ' ao&ucirc;t '.$date4;
        break;

   case '09':
        echo ' septembre '.$date4;
        break;

   case '10':
        echo ' octobre '.$date4;
        break;

   case '11':
        echo ' novembre '.$date4;
         break;

   case '12':
         echo ' d&eacute;cembre '.$date4;
        break;

  }
  
  }

// netoyage du code
 
function w3c($str) {
    if($str!="") {
        // suppresion des hspace, vspace
        $str = preg_replace( "/(h|v)space='.'|border=0/i" , "" , $str);
        
        // h3 imbrique dans un p
        $str = preg_replace( "/<p class=\"spip\"> <h3>/i" , "<h3>" , $str);
        $str = preg_replace( "/<\/h3>( )*<\/p>/i" , "</h3>" , $str);
        
        // tableaux imbriques dans p
        $str = preg_replace( "/<p class=\"spip\"><table class=\"spip\">/i" , "<table>" , $str);
        $str = preg_replace( "/<\/table>( )*<\/p>/i" , "</table>" , $str);
        
        // ol ou ul imbrique dans p
        $str = preg_replace( "/<p class=\"spip\"><(o|u)l class=\"spip\">/i" , "<\\1l class=\"spip\">" , $str);
        $str = preg_replace( "/<\/(o|u)l>( )*<\/p>/i" , "</\\1l>" , $str);
        
               
        // <b> -> <strong> et <i> -> <em>
        $str = preg_replace( "/(<b class=\"spip\">|<b>)/i" , "<strong>" , $str);
        $str = preg_replace( "/(<i class=\"spip\">|<i>)/i" , "<em>" , $str);
        $str = preg_replace( "/<\/b>/i" , "</strong>" , $str);
        $str = preg_replace( "/<\/i>/i" , "</em>" , $str);
        
       	
	}
    
    // renvoyer la chaine corrigee
    return $str;
}

$GLOBALS['debut_intertitre'] = "\n<h3>";
$GLOBALS['fin_intertitre'] = "</h3>\n";


/*
*   +----------------------------------+
*    Nom du Filtre :    limit_images_size
*   +----------------------------------+
*    Date : 21 septembre 2003
*    Auteur :  Mortimer Porte (mortimer(dot)porte(at)urbanet(dot)ch)
*   +-------------------------------------+
*    Fonctions de ce filtre :
*        redimensionne si nescessaire les images incluses dans le texte d'un article.
*        param1: largeur maximale (>0, sinon ignorée)
*        param2: hauteur maximale (>0, sinon ignorée)
*        [param3: insérer un lien sur l'image (1= oui,0= non)]
*    Exemple d'application :
*    [(#TEXTE|limit_images_size{400,0,1})]
*   +-------------------------------------+
*  
* Pour toute suggestion, remarque, proposition d'ajout
* reportez-vous au forum de l'article :
* http://www.uzine.net/spip_contrib/article.php3?id_article=251
*/
function limit_images_size($string, $largeur_maxi=0, $hauteur_maxi=0, $with_link=0) {

$reg = "/<img src='IMG\/([^']+)' ?([^ ]+) width=[^ ]+ ?([^ ]+) height=[^ ]+ ([^>]+)>/";

        preg_match_all ($reg, $string, $matches);
        
        $to_return = $string;

        for ($i=0; $i< count($matches[0]); $i++) {
                $img = $matches[1][$i];
                $bef = $matches[2][$i];
                $aft = $matches[4][$i];
                $btw =  $matches[3][$i];
                $size =  redimlogo ($img, $largeur_maxi, $hauteur_maxi);

                $before = "";
                $after = "";

                if($with_link) {
                        $before = "<a href='IMG/".$img."'>";
                        $after = "</a>";
                }

                $to_return = preg_replace("<".$matches[0][$i].">",
                                $before."<img src='IMG/".$img."' ".$size." ".$bef." ".$btw." ".$aft." >".$after,
                                $to_return,1);
        }        

        return $to_return;
}
// FIN du Filtre limit_images_size

/*
 *   +----------------------------------+
 *    Nom du Filtre :    redimlogo
 *   +----------------------------------+
 *    Date : mercredi 16 avril 2003
 *    Auteur :  Roustoubi (roustoubi@tiscali.fr)
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *    Renvoie les paramètres width & height pour réduire
 *    proportionnellement (si nécessaire) un logo dans un
 *    rectangle de dimensions données
 *    Les dimensions sont passées en paramètre du filtre
 *    (à partir de SPIP v.1.5a2)
 *    Exemple d'application :
 *    [<img src="IMG/(#LOGO_RUBRIQUE|fichier)"][(#LOGO_RUBRIQUE|fichier|texte_script|redimlogo{200,0})>]
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=110
*/

function redimlogo ($image, $largeur_maxi=0, $hauteur_maxi=0) {
	$image= "IMG/$image";
	if ($largeur_maxi<=0 AND $hauteur_maxi<=0) {} // Pas de mise à l'échelle si négatif ou nul
	elseif ($image != "IMG/") { // Que si l'image existe !
		$dim_image = @GetImageSize($image);
		$largeur_image = $dim_image[0];
		$hauteur_image = $dim_image[1];
		if ($largeur_image+$hauteur_image>0) { 
			// Calcul des facteurs de réduction
			$reduction_largeur = $largeur_maxi/$largeur_image;
			$reduction_hauteur = $hauteur_maxi/$hauteur_image;
			// Choix du "bon" facteur de réduction
			if ($reduction_largeur<=0) { $reduction = min(1,$reduction_hauteur); }
			elseif ($reduction_hauteur<=0) { $reduction = min(1,$reduction_largeur); }
			else {$reduction = min(1, $reduction_hauteur, $reduction_largeur); }
			// Calcul des paramètres à renvoyer
			$largeur = ceil($largeur_image*$reduction);
			$hauteur = ceil($hauteur_image*$reduction);
			$parametres = " height=\"".$hauteur."\" width=\"".$largeur."\"" ;
		}
	}
	return $parametres;
}
// FIN du Filtre redimlogo

/*
 *   +----------------------------------+
 *    Nom du Filtre :    redimimage
 *   +----------------------------------+
 *    Date : mercredi 16 avril 2003
 *    Auteur :  Roustoubi (roustoubi@tiscali.fr)
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *    Renvoie les paramètres width & height pour réduire
 *    proportionnellement (si nécessaire) un logo dans un
 *    rectangle de dimensions données
 *    Les dimensions sont passées en paramètre du filtre
 *    (à partir de SPIP v.1.5a2)
 *    Exemple d'application :
 *    [<img src="IMG/(#LOGO_RUBRIQUE|fichier)"][(#LOGO_RUBRIQUE|fichier|texte_script|redimlogo{200,0})>]
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=110
*/

function redimimage ($image, $largeur_maxi=0, $hauteur_maxi=0) {
	
	if ($largeur_maxi<=0 AND $hauteur_maxi<=0) {} // Pas de mise à l'échelle si négatif ou nul
	elseif ($image != "IMG/") { // Que si l'image existe !
		$dim_image = @GetImageSize($image);
		$largeur_image = $dim_image[0];
		$hauteur_image = $dim_image[1];
		if ($largeur_image+$hauteur_image>0) { 
			// Calcul des facteurs de réduction
			$reduction_largeur = $largeur_maxi/$largeur_image;
			$reduction_hauteur = $hauteur_maxi/$hauteur_image;
			// Choix du "bon" facteur de réduction
			if ($reduction_largeur<=0) { $reduction = min(1,$reduction_hauteur); }
			elseif ($reduction_hauteur<=0) { $reduction = min(1,$reduction_largeur); }
			else {$reduction = min(1, $reduction_hauteur, $reduction_largeur); }
			// Calcul des paramètres à renvoyer
			$largeur = ceil($largeur_image*$reduction);
			$hauteur = ceil($hauteur_image*$reduction);
			$parametres = "height=\"".$hauteur."\" width=\"".$largeur."\"" ;
		}
	}
	return $parametres;
}
// FIN du Filtre redimlogo

/*
 *   +----------------------------------+
 *    Nom du Filtre Resizelogo
 *   +----------------------------------+
 *    Date : dimanche 8 juin 2003
 *    Auteur :  jsb + js.barboteu@laposte.net
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *    Cette fonction permet de changer la taille de votre
 *    logo sur le serveur à la première visualisation
 *    sur votre site. 
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=179
*/
function ResizeLogo( $image, $newWidth, $newHeight){

// détection du type de l'image

eregi("(...)$",$image,$regs); $type = $regs[1];
switch($type){ 
case "gif": $srcImage = @imagecreatefromgif( $image ); break;
case "jpg": $srcImage = @imagecreatefromjpeg( $image ); break;
case "png": $srcImage = @imagecreatefrompng( $image ); break;
default : unset($type); break;} 

if($srcImage){

// hauteurs/largeurs
$srcWidth = imagesx( $srcImage ); 
$srcHeight = imagesy( $srcImage ); 
$ratioWidth = $srcWidth/$newWidth;
$ratioHeight = $srcHeight/$newHeight;

// taille maximale dépassée ?
if (($ratioWidth > 1) || ($ratioHeight > 1)) {
if( $ratioWidth < $ratioHeight){ 
$destWidth = $srcWidth/$ratioHeight;
$destHeight = $newHeight; 
}else{ 
$destWidth = $newWidth; 
$destHeight = $srcHeight/$ratioWidth;}
}else {$destWidth = $srcWidth;  $destHeight = $srcHeight;}

// resize
$destImage = imagecreate( $destWidth, $destHeight); 
imagecopyresized( $destImage, $srcImage, 0, 0, 0, 0, $destWidth, $destHeight, 
                                                     $srcWidth, $srcHeight );

// nom du fichier
$dest_file  = $image ;
// création et sauvegarde de l'image finale
/* Ici on peut éditer le chemin de sauvegarde ($dest_file) */
switch($type){
case "gif": @imageCreateFromGIF($destImage, $dest_file); break;
case "jpg": @imageCreateFromJPEG($destImage, $dest_file); break; 
case "png": @imageCreateFromPNG($destImage, $dest_file); break;}

// libère la mémoire
imagedestroy( $srcImage );
imagedestroy( $destImage );

// renvoit l'URL de l'image
return $dest_file;}

// erreur
else {echo "Image inexistante ou aucun support ";
        if ($type){echo "pour le format $type";}
        else {echo "pour ce format de fichier";}
exit();}}
//FIN du filtre

// Filtre SMILEYS - 23 janvier 2003
//
// pour toute suggestion, remarque, proposition d'ajout d'un 
// smileys, etc ; reprotez vous au forum de l'article :
// http://www.uzine.net/spip_contrib/article.php3?id_article=38

function smileys($chaine) {
$chemin = "<img src=\"smileys/";


         $chemin = "<img ALT=\"smiley\" src=\"smileys/";

// On peut mettre les smileys-images où l'on veut. Mais il faut 
// penser à modifier la variable $chemin de la fonction en conséquence.

         $chaine = str_replace(":->", $chemin . "diable.png\">", $chaine);

         $chaine = str_replace(":-((", $chemin . "en_colere.png\">", $chaine);
		 
         $chaine = str_replace(":-))", $chemin . "mort_de_rire.png\">", $chaine);
         $chaine = str_replace(":-D", $chemin . "mort_de_rire.png\">", $chaine);

         $chaine = str_replace(":-)", $chemin . "sourire.png\">", $chaine);
		 
         $chaine = str_replace(":'-))", $chemin . "pleure_de_rire.png\">", $chaine);
         $chaine = str_replace(":'-D", $chemin . "pleure_de_rire.png\">", $chaine);

         $chaine = str_replace(":o)", $chemin . "rigolo.png\">", $chaine);
		 
         $chaine = str_replace("B-)", $chemin . "lunettes.png\">", $chaine);

         $chaine = str_replace(";-)", $chemin . "clin_d-oeil.png\">", $chaine);

         $chaine = str_replace(":-p", $chemin . "tire_la_langue.png\">", $chaine);

         $chaine = str_replace(":-|", $chemin . "bof.png\">", $chaine);
		 
         $chaine = str_replace(":-/", $chemin . "mouai.png\">", $chaine);

         $chaine = str_replace(":-o", $chemin . "surprit.png\">", $chaine);
         $chaine = str_replace(":-O", $chemin . "surprit.png\">", $chaine);
		 
         $chaine = str_replace(":-(", $chemin . "pas_content.png\">", $chaine);

         $chaine = str_replace(":'-(", $chemin . "triste.png\">", $chaine);

        return $chaine;
}

/*
 *   +----------------------------------+
 *    Nom du Filtre : Sommaire de l'article                                               
 *   +----------------------------------+
 *    Date : Vendredi 6 juin 2003
 *    Auteur :  Noplay (noplay@altern.org) 
 *              Aurélien PIERARD : aurelien.pierard@sig.premier-ministre.gouv.fr                                     
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *      Cette modification permet d'afficher le sommaire de l'article 
 *      généré dynamiquement à partir du texte de l'article. Vous pouvez naviguer 
 *      dans l'article en cliquant sur les titres du sommaires. 
 *
 *      Tous ce qui ce trouve entre {{{ et }}} est considéré comme un titre à ajouter au sommaire de l'article.
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=76
*/
//SOMMAIRE
function sommaire_article($texte)
{
		$artsuite = 0;
        $page = split('-----', $texte);
        $uri_art = generer_url_article($GLOBALS['id_article']);
        $uri_art .= strpos($uri_art, '?') ? '&' : '?';

	$i=0;
	$texte="";
	while($page[$i]){
		// On ajoute une ancre aux intertitres "{{{ }}}" que l'on utilise pour créer le sommaire
		preg_match_all("|\{\{\{(.*)\}\}\}|U",$page[$i], $regs);
	 	$nb=1;
		for($j=0;$j<count($regs[1]);$j++){
			$p=$i+1;
	    	$texte=$texte."<a href=\"". $uri_art . "artsuite=" .$i. "#sommaire_".$nb."\" title=\"".$regs[1][$j]."\">".$regs[1][$j]."</a>, p$p<br />";
			$nb++;
	    }
		$i++;
	}
		return $texte;
}
// Fin du filtre sommaire

/*
 *   +----------------------------------+
 *    Nom du Filtre : decouper_en_page                                               
 *   +----------------------------------+
 *    Date : Vendredi 6 juin 2003
 *    Auteur :  "gpl"  : gpl@macplus.org  
 *              Aurélien PIERARD : aurelien.pierard@sig.premier-ministre.gouv.fr
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *		Il sert a présenter un article sur plusieurs pages  
 *   +-------------------------------------+ 
 *  
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=62
*/


function decouper_en_page($texte) {
        global $artsuite, $var_recherche, $num_pages;
		
        if (empty($artsuite)) $artsuite = 0;
	
		// on divise la page (séparateur : "-----")        
        $page = split('-----', $texte);
        // Nombre total de pages
        $num_pages = count($page);

        // Si une seule page ou numéro illégal, alors retourner tout le texte.
        // Cas spécial : si var_recherche positionné, tout renvoyer pour permettre à la surbrillance de fonctionner correctement.
        if ($num_pages == 1 || !empty($var_recherche) || $artsuite < 0 || $artsuite > $num_pages) {
			// On place les ancres sur les intertitres
			$texte = preg_replace("|\{\{\{(.*)\}\}\}|U","<a name=\"sommaire_#NB_TITRE_DE_MON_ARTICLE#\">$0</a>", $texte);
			$array = explode("#NB_TITRE_DE_MON_ARTICLE#" , $texte);
			$res =count($array);
			$i =1;
			$texte=$array[0];
			while($i<$res){
				$texte=$texte.$i.$array[$i];
				$i++;
			}
			return $texte;
        } 

        $p_prec = $artsuite - 1;
        $p_suiv = $artsuite + 1;
        $uri_art = generer_url_article($GLOBALS['id_article']);
        $uri_art .= strpos($uri_art, '?') ? '&' : '?';

		// On place les ancres sur les intertitres
		$page[$artsuite] = preg_replace("|\{\{\{(.*)\}\}\}|U","<a name=\"sommaire_#NB_TITRE_DE_MON_ARTICLE#\">$0</a>", $page[$artsuite]);
		$array = explode("#NB_TITRE_DE_MON_ARTICLE#" , $page[$artsuite]);
		$res =count($array);
		$i =1;
		$page[$artsuite]=$array[0];
		while($i<$res){
			$page[$artsuite]=$page[$artsuite].$i.$array[$i];
			$i++;
		}
		// Pagination
	    switch (TRUE) {
			case ($artsuite == 0):
				$precedent = "";
				$suivant = "<a href='" . $uri_art . "artsuite=" . $p_suiv ."&recalcul=oui'>&gt;&gt;</a>";
				break;
			case ($artsuite == ($num_pages-1)):
				$precedent = "<a href='" . $uri_art . "artsuite=" . $p_prec ."&recalcul=oui'>&lt;&lt;</a>";
				$suivant = "";
				break;
			default:
				$precedent = "<a href='" . $uri_art . "artsuite=" . $p_prec . "&recalcul=oui'>&lt;&lt;</a>";
				$suivant = "<a href='" . $uri_art . "artsuite=" . $p_suiv . "&recalcul=oui'>&gt;&gt;</a>";
				break;
        }
    
        for ($i = 0; $i < $num_pages; $i++) {
			$j = $i;
			if ($i == $artsuite) {
				$milieu .= " <strong>" . ++$j . "</strong> ";
            } 
			else {
				$milieu .= " <a href='" . $uri_art . "artsuite=$i&recalcul=oui'>" . ++$j . "</a> ";
			}
        }

        // Ici, on peut personnaliser la présentation
        $resultat .= $page[$artsuite];
        $resultat .= "<p class='pagination'><div class='pagination' align='center'>pages : $precedent $milieu $suivant</div></p>";
        return $resultat;
}
// FIN du Filtre decouper_en_page

?>
