<?php
function sc_trouver_corr_un ($id_article) {
	$row = sql_fetsel('spip_articles.id_article, spip_articles.titre', 
		'spip_articles',
		"id_article=$id_article");
	return $row;
}
function sc_trouver_corr_pl ($id_article) {
	$row = sql_fetsel('spip_articles.id_article, spip_rubriques.titre, spip_rubriques.id_rubrique', 'spip_articles LEFT JOIN spip_rubriques ON spip_rubriques.id_rubrique = spip_articles.id_rubrique', "id_article=$id_article");
	return $row;
}
function sc_decoder_date ($date_d, $date_e) {
	$debut = array();
	$debut['annee'] = substr($date_d, 0, 4);
	$debut['mois'] = substr($date_d, 4, 2);
	$debut['jour'] = substr($date_d, 6, 2);
	$debut['heure'] = substr($date_d, 9, 2);
	$debut['minutes'] = substr($date_d, 11, 2);
	$debut['secondes'] = substr($date_d, 13, 2);
	$debut['mois_fr'] = sc_get_mois($debut['mois']);
	$debut['jour_fr'] = sc_get_jour(mktime($debut['heure'], $debut['minutes'], $debut['secondes'], $debut['mois'], $debut['jour'], $debut['annee']));
	$fin = array();
	$fin['annee'] = substr($date_e, 0, 4);
	$fin['mois'] = substr($date_e, 4, 2);
	$fin['jour'] = substr($date_e, 6, 2);
	$fin['heure'] = substr($date_e, 9, 2);
	$fin['minutes'] = substr($date_e, 11, 2);
	$fin['secondes'] = substr($date_e, 13, 2);
	$fin['mois_fr'] = sc_get_mois($fin['mois']);
	$fin['jour_fr'] = sc_get_jour(mktime($fin['heure'], $fin['minutes'], $fin['secondes'], $fin['mois'], $fin['jour'], $fin['annee']));
	$get_same = sc_same_day($debut, $fin);
	if ($get_same) {
		if (intval($debut['jour']) < 10)
			$debut['jour'] = substr($debut['jour'], 1, 1);
		$resultat = "Le ".$debut['jour_fr']." ".$debut['jour']." ".$debut['mois_fr']." ".$debut['annee']." de ".$debut['heure'].":".$debut['minutes']." &agrave; ".$fin['heure'].":".$fin['minutes']."";
	}
	else if (!$get_same) {
		if (intval($debut['jour']) < 10)
			$debut['jour'] = substr($debut['jour'], 1, 1);
		if (intval($fin['jour']) < 10)
			$fin['jour'] = substr($fin['jour'], 1, 1);
		$resultat = "Du ".$debut['jour_fr']." ".$debut['jour']." ".$debut['mois_fr']." ".$debut['annee']." &agrave; ".$debut['heure'].":".$debut['minutes']." au ".$fin['jour_fr']." ".$fin['jour']." ".$fin['mois_fr']." ".$fin['annee']." &agrave; ".$fin['heure'].":".$fin['minutes']."";
	}
	return $resultat;
}
function sc_same_day ($debut, $fin) {
	$start = mktime(0, 0, 0, $debut['mois'], $debut['jour'], $debut['annee']);
	$end = mktime(0, 0, 0, $fin['mois'], $fin['jour'], $fin['annee']);
	if ($start == $end)
		return true;
	else if ($start != $end)
		return false;
}
function sc_get_mois ($nb) {
	$mois["01"] = _T('date_mois_1');
	$mois["02"] = _T('date_mois_2');
	$mois["03"] = _T('date_mois_3');
	$mois["04"] = _T('date_mois_4');
	$mois["05"] = _T('date_mois_5');
	$mois["06"] = _T('date_mois_6');
	$mois["07"] = _T('date_mois_7');
	$mois["08"] = _T('date_mois_8');
	$mois["09"] = _T('date_mois_9');
	$mois["10"] = _T('date_mois_10');
	$mois["11"] = _T('date_mois_11');
	$mois["12"] = _T('date_mois_12');
	return $mois[$nb];
}
function sc_get_jour ($nb) {
	$nb = intval($nb);
	$j = date("w", $nb);
	$jour["0"] = _T('date_jour_1');
	$jour["1"] = _T('date_jour_2');
	$jour["2"] = _T('date_jour_3');
	$jour["3"] = _T('date_jour_4');
	$jour["4"] = _T('date_jour_5');
	$jour["5"] = _T('date_jour_6');
	$jour["6"] = _T('date_jour_7');
	return $jour[$j];
}
function sc_agenda_mini($i) {
  $args = func_get_args();
  $une_date = array_shift($args); // une date comme balise
  $sinon = array_shift($args);
  if (!$une_date) return $sinon;
  $type = 'sc_mini';
  $agenda = sc_Agenda_memo_full(0);
  $evt = array();
  foreach (($args ? $args : array_keys($agenda)) as $k) {  
      if (is_array($agenda[$k]))
		foreach($agenda[$k] as $d => $v) { 
		  $evt[$d] = $evt[$d] ? (array_merge($evt[$d], $v)) : $v;
		}
    }
	$la_date = mktime(0, 0, 0, mois($une_date), 1, annee($une_date));
    include_spip('inc/agenda');
    return http_calendrier_init($la_date, $type, '', '', '', array('', $evt));
}

function http_calendrier_sc_mini($annee, $mois, $jour, $echelle, $partie_cal, $script, $ancre, $evt) {
	list($sansduree, $evenements, $premier_jour, $dernier_jour) = $evt;

	if ($sansduree)
		foreach($sansduree as $d => $r) {
			$evenements[$d] = !$evenements[$d] ? $r : 
				 array_merge($evenements[$d], $r);
			 }

	if (!$premier_jour) $premier_jour = '01';
	if (!$dernier_jour) {
		$dernier_jour = 31;
		while (!(checkdate($mois,$dernier_jour,$annee))) $dernier_jour--;
	}

	// affichage du debut de semaine hors periode
	$ligne = '';
	$debut = date("w",mktime(1,1,1,$mois,$premier_jour,$annee));
	for ($i=$debut ? $debut : 7;$i>1;$i--) {
		$mois_t_precedent = mktime(1,1,1,$mois-1,1,$annee);
		$jour_mois_precedent = date('t', $mois_t_precedent)+2-$i;
		$mois_precedent = date("m",$mois_t_precedent);
		$annee_en_cours = date("Y",$nom);
		$amj = date("Y",$mois_t_precedent) . $mois_precedent . $jour_mois_precedent;
		$evts = $evenements[$amj];
		$class="";
		if ($evts) {
			$nb_elmts= @count($evts);
			if ($nb_elmts>1){
				$row = sc_trouver_corr_pl($evts[0]['ID']);
				$id_rub = intval($row['id_rubrique']);
				$titre_rub = supprimer_numero($row['titre']);
				$url = generer_url_public('agenda', 'id_rubrique='.$id_rub.'');
				$evts = "<a href='".$url."' title='$titre_rub ("._T('agenda:voir_evenements_rubrique').")'>".intval($jour_mois_precedent)."</a>";
			}
			else{
				$row = sc_trouver_corr_un($evts[0]['ID']);
				$url = generer_url_entite($row['id_article'], 'article');
				$info = sc_decoder_date($evts[0]['DTSTART'], $evts[0]['DTEND']);
				$title = $row['titre']." : ".$evts[0]['SUMMARY']." - ".$info;
				$evts = "<a href='".$url."' title='".$title.
				"'>".intval($jour_mois_precedent)."</a>";
			}
			$class='occupe';
			
		}
		else {
			$evts = intval($jour_mois_precedent);
			$class = 'horsperiode';
		}
		$ligne .= "\n\t<td class=\"$class\">".$evts."</td>";
	}
	//mois en cours
	$total = '';
	for ($j=$premier_jour; $j<=$dernier_jour; $j++) {
		$nom = mktime(1,1,1,$mois,$j,$annee);
		$jour = date("d",$nom);
		$jour_semaine = date("w",$nom);
		$mois_en_cours = date("m",$nom);
		$annee_en_cours = date("Y",$nom);
		$amj = date("Y",$nom) . $mois_en_cours . $jour;

		if ($jour_semaine==1 AND $ligne != '') { 
			$total .= "\n<tr>$ligne\n</tr>";
			$ligne = '';
		}

		$evts = $evenements[$amj];
		$class="";
		if ($evts) {
			$nb_elmts= @count($evts);
			if ($nb_elmts>1){
				$row = sc_trouver_corr_pl($evts[0]['ID']);
				$id_rub = intval($row['id_rubrique']);
				$titre_rub = supprimer_numero($row['titre']);
				$url = generer_url_public('agenda', 'id_rubrique='.$id_rub.'');
				$evts = "<a href='".$url."' title='$titre_rub ("._T('agenda:voir_evenements_rubrique').")'>".intval($jour)."</a>";
			}
			else{
				$row = sc_trouver_corr_un($evts[0]['ID']);
				$url = generer_url_entite($row['id_article'], 'article');
				$info = sc_decoder_date($evts[0]['DTSTART'], $evts[0]['DTEND']);
				$title = $row['titre']." : ".$evts[0]['SUMMARY']." - ".$info;
				$evts = "<a href='".$url."' title='".$title.
				"'>".intval($jour)."</a>";
			}
			$class='occupe';
			
		}
		else {
			$evts = intval($jour);
			$class='libre';
		}
		$ligne .= "\n\t<td  class='$class".($amj == date("Ymd")?' today':'')."'>" . $evts . "\n\t</td>";
	}
	$jour_mois_suivant=1;
	// affichage de la fin de semaine hors periode
	for($j=$jour_semaine ? $jour_semaine : 7; $j<7; $j++) {
		$nom = mktime(1,1,1,$mois+1,$j,$annee);
		$jour = date("d",$nom);
		$jour_semaine = date("w",$nom);
		$mois_suivant = date("m",$nom);
		$annee_en_cours = date("Y",$nom);
		$amj = date("Y",$nom) . $mois_suivant . '0'.$jour_mois_suivant;
		$evts = $evenements[$amj];
		$class="";
		if ($evts) {
			$nb_elmts= @count($evts);
			if ($nb_elmts>1){
				$row = sc_trouver_corr_pl($evts[0]['ID']);
				$id_rub = intval($row['id_rubrique']);
				$titre_rub = supprimer_numero($row['titre']);
				$url = generer_url_public('agenda', 'id_rubrique='.$id_rub.'');
				$evts = "<a href='".$url."' title='$titre_rub ("._T('agenda:voir_evenements_rubrique').")'>".intval($jour_mois_suivant++)."</a>";
			}
			else{
				$row = sc_trouver_corr_un($evts[0]['ID']);
				$url = generer_url_entite($row['id_article'], 'article');
				$info = sc_decoder_date($evts[0]['DTSTART'], $evts[0]['DTEND']);
				$title = $row['titre']." : ".$evts[0]['SUMMARY']." - ".$info;
				$evts = "<a href='".$url."' title='".$title.
				"'>".intval($jour_mois_suivant++)."</a>";
			}
			$class= 'occupe';
			
		}
		else {
			$evts = intval($jour_mois_suivant++);
			$class = 'horsperiode';
		}
		$ligne .= "\n\t<td class=\"$class\">".$evts."</td>";
	}

	return $total . ($ligne ? "\n<tr>$ligne\n</tr>" : '');
}
function sc_agenda_memo_full($date_deb=0, $date_fin=0 , $titre='', $descriptif='', $lieu='', $url='', $cal='')
{
	static $agenda = array();
	if (!$date_deb) {
		$res = $agenda;
		$agenda=array();
		return $res;
	}
	$url=str_replace("&amp;","&",$url);
	
	$idatedeb = date_ical($date_deb);
	$idatefin = date_ical($date_deb);
	$vidatefin = date_ical($date_fin);
	$cal = trim($cal); // func_get_args (filtre alterner) rajoute \n !!!!
	$startday1=explode(' ',$date_deb);
	$startday1=$startday1['0'].' 00:00:00';
	$ts_startday1=strtotime($startday1);
	$ts_date_fin=strtotime($date_deb);
	$maxdays=365;
	while (($ts_startday1<=$ts_date_fin)&&($maxdays-->0))
	{
		$day=date('Y-m-d H:i:s',$ts_startday1);
		$agenda[$cal][(date_anneemoisjour($day))][] =  array(
			'CATEGORIES' => $cal,
			'DTSTART' => $idatedeb,
			'DTEND' => $vidatefin,
			'DESCRIPTION' => $descriptif,
			'SUMMARY' => $titre,
			'LOCATION' => $lieu,
			'ID' => $url);
		$ts_startday1 += 26*3600; // le jour suivant : +26 h pour gerer les changements d'heure
		$ts_startday1 = mktime(0, 0, 0, date("m",$ts_startday1), 
		date("d",$ts_startday1), date("Y",$ts_startday1)); // et remise a zero de l'heure	
	}
	// toujours retourner vide pour qu'il ne se passe rien
	return "";
}
?>
