<?php

function agenda_mini($i) {
  $args = func_get_args();
  $une_date = array_shift($args); // une date comme balise
  $sinon = array_shift($args);
  if (!$une_date) return $sinon;
  $type = 'mini';
  $agenda = agenda_memo(0);
  $evt = array();
  foreach (($args ? $args : array_keys($agenda)) as $k) {  
      if (is_array($agenda[$k]))
		foreach($agenda[$k] as $d => $v) { 
		  $evt[$d] = $evt[$d] ? (array_merge($evt[$d], $v)) : $v;
		}
    }
	$la_date = mktime(0, 0, 0, mois($une_date), 1, annee($une_date));
    include_ecrire('inc_calendrier.php');
    return http_calendrier_init($la_date, $type, '', '', '', $evt);
}

function http_calendrier_mini($annee, $mois, $jour, $echelle, $partie_cal, $script, $ancre, $evt) {
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
		$ligne .= "\n\t<td>&nbsp;</td>";
	}

	$total = '';
	for ($j=$premier_jour; $j<=$dernier_jour; $j++) {
		$nom = mktime(1,1,1,$mois,$j,$annee);
		$jour = date("d",$nom);
		$jour_semaine = date("w",$nom);
		$mois_en_cours = date("m",$nom);
		$annee_en_cours = date("Y",$nom);
		$amj = date("Y",$nom) . $mois_en_cours . $jour;

		if ($jour_semaine==1) { 
			$total .= "\n<tr>$ligne\n</tr>";
			$ligne = '';
		}

		//aujourd'hui
		if ($amj == date("Ymd")) {
			/*$couleur_lien = "red";
			$couleur_fond = "white";*/
		}
		$evts = $evenements[$amj];
		if ($evts) {
			$evts = "<a href=\"".$evts[0]['URL']."\">".$evts[0]['SUMMARY']."</a>";
		}
		else {
			$evts = intval($jour);
		}
		$ligne .= "\n\t<td>" . $evts . "\n\t</td>";
	}
	// affichage de la fin de semaine hors periode
	for($j=$jour_semaine; $j<7; $j++) {
		$ligne .= "\n\t<td>&nbsp;</td>";			
	}

	return $total . ($ligne ? "\n<tr>$ligne\n</tr>" : '');
}

?>
