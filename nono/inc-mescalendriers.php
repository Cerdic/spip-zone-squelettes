<?
//================================================================================
//--------------------------------------------------------------------------------
//----------------------------debut du calendier----------------------------------
function mon_calendrier($param) {

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

function calendrier_mois($param) {

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