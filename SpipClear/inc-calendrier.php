<?php
//
// Ce fichier ne sera execute qu'une fois
if (defined("_INC_CALENDRIER_SPIPCLEAR")) return;
define("_INC_CALENDRIER_SPIPCLEAR", "1");

// Calcule un agenda mensuel et l'affiche

function http_calendrier_billet ($mois, $annee, $jour_ved, $mois_ved, $annee_ved, $semaine = false,  $script='calendrier.php3?', $ancre='') {

  if (!$mois) {$mois = 12; $annee--;}
  elseif ($mois==13) {$mois = 1; $annee++;}
  $moisprec = $mois-1;
  $anneeprec = $annee;
  if (!$moisprec) {$moisprec = 12; $anneeprec--;}
  elseif ($moisprec==13) {$moisprec = 1; $anneeprec++;}
  if($moisprec<10) $moisprec = '0'.$moisprec;
  $moissuiv = $mois+1;
  $anneesuiv = $annee;
  if (!$moissuiv) {$moissuiv = 12; $anneesuiv--;}
  elseif ($moissuiv==13) {$moissuiv = 1; $anneesuiv++;}
  if($moissuiv<10) $moissuiv = '0'.$moissuiv;
  $lienprec = count(sql_calendrier_billets($moisprec, $anneeprec))?generer_url_blog($anneeprec."-".$moisprec, 'archives'):"";
  $liensuiv = count(sql_calendrier_billets($moissuiv, $anneesuiv))?generer_url_blog($anneesuiv."-".$moissuiv, 'archives'):"";
  if($lienprec) $lienprec = str_replace('&amp;', '&', http_href($lienprec, "&#171;", affdate_mois_annee("$anneeprec-$moisprec-1")))." ";
  if($liensuiv) $liensuiv = " ".str_replace('&amp;', '&', http_href($liensuiv, "&#187;", affdate_mois_annee("$anneesuiv-$moissuiv-1")));
  return 
      "<table summary=\""._T('spipclear:calendrier')."\">
	  <caption>" .
	    $lienprec .
	    affdate_mois_annee("$annee-$mois-1") .
	    $liensuiv .
	  "</caption>
	  <thead>
	    <tr>
	      <th scope=\"col\"><abbr title=\""._T('date_jour_2')."\">"._T('spipclear:date_jour_abbr_2')."</abbr></th>
	      <th scope=\"col\"><abbr title=\""._T('date_jour_3')."\">"._T('spipclear:date_jour_abbr_3')."</abbr></th>
	      <th scope=\"col\"><abbr title=\""._T('date_jour_4')."\">"._T('spipclear:date_jour_abbr_4')."</abbr></th>
	      <th scope=\"col\"><abbr title=\""._T('date_jour_5')."\">"._T('spipclear:date_jour_abbr_5')."</abbr></th>
	      <th scope=\"col\"><abbr title=\""._T('date_jour_6')."\">"._T('spipclear:date_jour_abbr_6')."</abbr></th>
	      <th scope=\"col\"><abbr title=\""._T('date_jour_7')."\">"._T('spipclear:date_jour_abbr_7')."</abbr></th>
	      <th scope=\"col\"><abbr title=\""._T('date_jour_1')."\">"._T('spipclear:date_jour_abbr_1')."</abbr></th>
	    </tr>
	  </thead>
	  <tbody>" .
    http_calendrier_billets ($mois, $annee, $jour_ved, $mois_ved, $annee_ved, 
			       $semaine, 
			       sql_calendrier_billets($mois, $annee),
			       $script,
			       $ancre) .
	  "</tbody>
	</table>" .
      "";
}

// typographie un mois sous forme d'un tableau de 7 colonnes

function http_calendrier_billets ($mois, $annee, $jour_ved, $mois_ved, $annee_ved, $semaine, $les_rv, $script, $ancre='') {
	global $spip_lang_left, $spip_lang_right;

	// Former une date correcte (par exemple: $mois=13; $annee=2003)
	$date_test = date("Y-m-d", mktime(0,0,0,$mois, 1, $annee));
	$mois = mois($date_test);
	$annee = annee($date_test);

	if ($semaine) 
	{
		$jour_semaine_valide = date("w",mktime(1,1,1,$mois_ved,$jour_ved,$annee_ved));
		if ($jour_semaine_valide==0) $jour_semaine_valide=7;
		$debut = mktime(1,1,1,$mois_ved,$jour_ved-$jour_semaine_valide+1,$annee_ved);
		$fin = mktime(1,1,1,$mois_ved,$jour_ved-$jour_semaine_valide+7,$annee_ved);
	} else { $debut = $fin = '';}
		  
	
	$today=getdate(time());
	$jour_today = $today["mday"];
	$mois_today = $today["mon"];
	$annee_today = $today["year"];

	$total = '';
	$ligne = '';
	$jour_semaine = date("w", mktime(1,1,1,$mois,1,$annee));
	if ($jour_semaine==0) $jour_semaine=7;
	for ($i=1;$i<$jour_semaine;$i++) $ligne .= "\n\t<td></td>";
	$style1 = "-moz-border-radius-top$spip_lang_left: 10px; -moz-border-radius-bottom$spip_lang_left: 10px;";
	$style7 = "-moz-border-radius-top$spip_lang_right: 10px; -moz-border-radius-bottom$spip_lang_right: 10px;";
	for ($j=1; $j<32; $j++) {
		$nom = mktime(1,1,1,$mois,$j,$annee);
		$jour_semaine = date("w",$nom);
		if ($jour_semaine==0) $jour_semaine=7;
		if (checkdate($mois,$j,$annee)){
		  if ($j == $jour_today AND $mois == $mois_today AND $annee == $annee_today) $couleur = "color: White";
		  else $couleur = "";
		  //contenu de la cellule en fonction du nombre de billet pour le jour donné
		  if($les_rv[$j] > 0) {
		    if($j<10) $_j = '0'.$j; else $_j = $j;
		    $contenu_cellule = str_replace('&amp;', '&', http_href(generer_url_blog("$annee-$mois-$_j", 'archives') . $ancre, 
				"<b>$j</b>",
				'',
				$couleur));
		  }
		  else {
		    $contenu_cellule = $j;
		    if($couleur) $contenu_cellule = "<span style=\"".$couleur."\">".$contenu_cellule."</span>";
		  }
		  //habillage
		  if ($j == $jour_today AND $mois == $mois_today AND $annee == $annee_today) {
		    $contenu_cellule = "<td><div class='arial2' style='margin-left: 1px; margin-top: 1px; padding: 2px; background-color: #333; text-align: center; -moz-border-radius: 5px;'>".$contenu_cellule."</div></td>";
		  }
		  elseif($j == $jour_ved AND $mois == $mois_ved AND $annee == $annee_ved) {
		    $contenu_cellule = "<td class=\"active\">".$contenu_cellule."</td>";
		  }
		  else {
		    $contenu_cellule = "<td>".$contenu_cellule."</td>";
		  }
		  $ligne .= $contenu_cellule;
		  if ($jour_semaine==7) 
		    {
		      $total .= "\n<tr>$ligne\n</tr>";
		      $ligne = '';
		    }
		}
	}
	return $total . (!$ligne ? '' : "\n<tr>$ligne\n</tr>");

}

function sql_calendrier_billets($mois, $annee) {
	global $id_blog;
	$date = date("Y-m-d", mktime(0,0,0,$mois, 1, $annee));
	$mois = mois($date);
	$annee = annee($date);

	// rendez-vous personnels dans le mois
	$result_articles=spip_query("SELECT articles.date FROM spip_articles AS articles WHERE articles.date >='$annee-$mois-1' AND articles.date < DATE_ADD('$annee-$mois-1', INTERVAL 1 MONTH) AND articles.statut='publie' AND id_secteur=$id_blog");
	$rv = array();
	while($row=spip_fetch_array($result_articles)){
		$rv[journum($row['date'])] = 1;
	}
	return $rv;
}

?>
