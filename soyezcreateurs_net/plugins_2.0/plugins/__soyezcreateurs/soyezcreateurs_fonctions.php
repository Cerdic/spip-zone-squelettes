<?php
/* -------------

Ces 2 balises permettent d'afficher dans une page :
 - le(s) saint(s) du jour
 - l'Evangile du jour

Le tout remis en forme correctement.

---------------*/
function balise_SAINT_DU_JOUR($p) {
	$saint_du_jour = str_replace('+','&dagger;',str_replace("\r",'',str_replace("\n",'',str_replace('&nbsp;',' ',supprimer_tags(recuperer_page('http://www.levangileauquotidien.org/ind-saints-d.php?language=FR', true))))));
	if ($p->param[0][1][0]->texte == -1) {
		if (($posvirg = strpos($saint_du_jour, ',')) > 0) $saint_du_jour = substr($saint_du_jour, 0, $posvirg);
	}
	$saint_du_jour = str_replace('ème','<sup>e</sup>', $saint_du_jour);
	$p->code = "'$saint_du_jour'";
	return $p;
}

function balise_EVANGILE_DU_JOUR($p) {
	$evangile_du_jour = str_replace("'", '&#8217;', recuperer_page('http://www.levangileauquotidien.org/ind-gospel-d.php?language=FR', true));
	if ($evangile_du_jour) {
		$evangile_du_jour = ereg_replace("<script.*</script>", '', $evangile_du_jour); // Suppression du script
		$evangile_du_jour = ereg_replace("<center.*</form>", '', $evangile_du_jour); // Suppression des mentions d'abonnement
		$evangile_du_jour = ereg_replace("<p[^>]*>", '', $evangile_du_jour); // Suppression du debut de paragraphe inutile
		$evangile_du_jour = ereg_replace("<font[^>]*>", '', trim($evangile_du_jour)); // Suppression des font inutiles
		$evangile_du_jour = str_replace("</font>", '', $evangile_du_jour);
		$evangile_du_jour = str_replace("</a><br><br>", '</dt><dd>', '<dl><dt>'.$evangile_du_jour); // Titre
		$evangile_du_jour = str_replace("<br><br>E", '</dd><dt class="aelf">E', $evangile_du_jour); // Le copyright
		$evangile_du_jour = str_replace("<br><br>", '</dt></dl>', $evangile_du_jour); // La fin du copyright
		$evangile_du_jour = str_replace("<br>", '</dd><dd>', $evangile_du_jour); // Un dd par verset
	}
	$p->code = "'$evangile_du_jour'";
	return $p;
}
/*
 *   +----------------------------------+
 *    Nom du Filtre : Sommaire de l'article
 *   +----------------------------------+
 *    Date : dimanche 9 février 2003
 *    Auteur :  Noplay (noplay@altern.org)
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *      Cette modification permet d'afficher le sommaire de son article
 *      généré dynamiquement à partir du texte de l'article. Vous pouvez naviguer
 *      dans l'article en cliquant sur les titres du sommaire.
 *
 *      Tous ce qui ce trouve entre {{{ et }}} est considéré comme un titre à ajouter au sommaire de l'article.
 *   +-------------------------------------+
 *
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.spip-contrib.net/spip.php?article76
*/
function sc_sommaire_article($texte,$istxt=0)
{

	preg_match_all("|(\{[\{12345]\{)(.*)(\}[\}12345]\})|U", $texte, $regs);


	$nb=1;
	$lastniveau=0;
	if ($istxt==0) {
		$texte='';
		for($j=0;$j<count($regs[2]);$j++) {
			$niveau=substr($regs[1][$j], 1, 1);
			if ($niveau=='{') {$niveau=1;}
			if ($niveau==$lastniveau) {
				$texte.="</li>\n";
			}
			if ($niveau>$lastniveau) {
				$texte.="<ul>";
				$lastniveau=$niveau;
			}
			if ($niveau<$lastniveau) {
				$texte.="</li>\n";
				for($ulli=$niveau;$ulli<$lastniveau;$ulli++) {
					$texte.="</ul></li>\n";
				}
				$lastniveau=$niveau;
			}

			$texte.="<li><a href=\"#sommaire_".$nb."\">".$regs[2][$j]."</a>";
			$nb++;
		}
		for($j=0;$j<$niveau;$j++) {
			$texte.="</li></ul>\n";
		}
		
		if ($nb>1) {
			$texte="<a name='SommaireAutomatique'></a>".$texte;
		}
		
	} else {
		$texte="";
		for($j=0;$j<count($regs[2]);$j++)
		{
			$niveau=substr($regs[1][$j], 1, 1);
			if ($niveau=='{') { $puce="\n- ";}
			if ($niveau==2) { $puce=" · ";}
			if ($niveau==3) { $puce="  × ";}
			if ($niveau==4) { $puce="   ° ";}
			if ($niveau==5) { $puce="    ¤ ";}
			$texte.=$puce.$regs[2][$j]."\n";
		}

	}
	return $texte;
}

function sc_sommaire_ancre($texte)
{
	$texte = preg_replace("|(<h[23456][^>]*>)(.*)(<\/h[23456]>)|U","<p class='retoursommaire'><a href='#SommaireAutomatique'>Retour Sommaire</a></p><a name=\"sommaire_#NB_TITRE_DE_MON_ARTICLE#\"></a>$1$2$3", $texte);

	$array = explode("#NB_TITRE_DE_MON_ARTICLE#" , $texte);
	$res =count($array);
	$i =1;
	$texte=$array[0];
	while($i<$res)
	{
		$texte.=$i.$array[$i];
		$i++;
	}
	if ($i>1) {
		$texte.="<p class='retoursommaire'><a href='#SommaireAutomatique'>Retour Sommaire</a></p>";
	}
	return $texte;
}
//Fin filtre sommaire de l'article

function sc_prepareNLtexte($texte) {
	// Remplace tous les liens
	while (eregi("<a href=['\"]([^'\">]+)['\"][^>]*>([^<]+)</a>", $texte, $regs)) {
		$cleanReg1 = ereg_replace("\\?", "\?", $regs[1]);
		$cleanReg1 = ereg_replace("\\+", "\+", $cleanReg1);
		$cleanReg2 = ereg_replace("\\?", "\?", $regs[2]);
		$cleanReg2 = ereg_replace("\\+", "\+", $cleanReg2);
		if ($regs[1] == $regs[2]) {
		    $texte = eregi_replace("<a href=['\"]".$cleanReg1."['\"][^>]*>".$cleanReg1."</a>", $regs[1], $texte);
		} else {
		    if ($regs[1] == str_replace("&nbsp;?","?",$regs[2])) {
			    $texte = eregi_replace("<a href=['\"]".$cleanReg1."['\"][^>]*>".$cleanReg2."</a>", $regs[1], $texte);
		    } else {
			    $texte = eregi_replace("<a href=['\"]".$cleanReg1."['\"][^>]*>".$cleanReg2."</a>", str_replace("&nbsp;?","?",$regs[2])." (".$regs[1].")", $texte);
		    }
		}
	}
	$texte = preg_replace("|(<h[2]>)(.*)(<\/h[2]>)|U","<br /><br />----------------------------------------------------------------------<br />$1$2$3<br />----------------------------------------------------------------------<br />", $texte);
	$texte = preg_replace("|(<h[3456]>)(.*)(<\/h[3456]>)|U","<br />···· $1$2$3 ····", $texte);
	$texte = ereg_replace ('<li[^>]>', "\n".'-', $texte);
	$texte = ereg_replace ('&#8217;', '\'', $texte);
	$texte = ereg_replace ('&#171;', '"', $texte);
	$texte = ereg_replace ('&#187;', '"', $texte);
	$texte = ereg_replace ('&amp;', '&', $texte);
	$texte = textebrut($texte);
	$texte = wordwrap($texte, 70, "\n");
	return $texte;
}

function sc_nettoyer_marqueur($texte) {
	include_spip('inc/charsets');
	$texte=translitteration($texte);
	// Enlève la conversion caractères spéciaux HTML
	$trans_tbl = get_html_translation_table (HTML_ENTITIES);
	$trans_tbl = array_flip ($trans_tbl);
	$texte=strtr ($texte, $trans_tbl);
	$accents =
			/* A */ chr(192).chr(193).chr(194).chr(195).chr(196).chr(197).
			/* a */ chr(224).chr(225).chr(226).chr(227).chr(228).chr(229).
			/* O */ chr(210).chr(211).chr(212).chr(213).chr(214).chr(216).
			/* o */ chr(242).chr(243).chr(244).chr(245).chr(246).chr(248).
			/* E */ chr(200).chr(201).chr(202).chr(203).
			/* e */ chr(232).chr(233).chr(234).chr(235).
			/* Cc */ chr(199).chr(231).
			/* I */ chr(204).chr(205).chr(206).chr(207).
			/* i */ chr(236).chr(237).chr(238).chr(239).
			/* U */ chr(217).chr(218).chr(219).chr(220).
			/* u */ chr(249).chr(250).chr(251).chr(252).
			/* yNn */ chr(255).chr(209).chr(241);
	$texte = ereg_replace("<[^<]*>", "", $texte);
	$texte = ereg_replace("[^A-Za-z0-9]", "_", strtr($texte,$accents,"AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn"));
	$texte = ereg_replace(" ", "_", $texte);
	$texte = ereg_replace(" ", "_", $texte);
	$texte = ereg_replace("_+", "_", $texte);
	return strtolower($texte);
}

/* à appliquer au #TEXTE de forum */
function sc_anti_glouton($texte) {
  $regexp = '|<a href=["\x27]([^"\x27]+)["\x27][^>]*>([^<]+)</a>|i';
  $replace = "\${2} [\${1}]";
  $texte = preg_replace($regexp, $replace, $texte);
  return $texte;
}

function sc_replace($texte,$search,$replace) {
	return trim(str_replace($search,$replace,$texte));
}

function sc_NewLine2str($texte) {
	return str_replace('"','\"',str_replace("\r",'',str_replace("\n",'\n',$texte)));
}

function sc_DateAdd($d=null, $v, $f="Y-m-d"){
  return date($f,strtotime($v." days",strtotime($d)));
}

function sc_annee_scolaire($ladate) {
	if ($ladate=='') return '';
	$annee = annee($ladate);
	$mois = mois($ladate);
	if ($mois <= 8) $annee -= 1;
	return $annee;
}

function sc_garder_body($texte) {
	$texte = eregi_replace('^.*<body[^>]*>', '', $texte);
	$texte = eregi_replace('</body>.*$', '', $texte);
	$texte = eregi_replace('^.*<!-- CutHere -->', '', $texte);
	$texte = eregi_replace('<!-- /CutHere -->.*$', '', $texte);
	return $texte;
}

/* Transforme un texte en lien raccourcis SPIP et calcule le résultat */
function sc_texte2urlspip($url) {
	return expanser_liens('[->'.$url.']');
}

function sc_trouver_corr_un ($id_article) {
	$row = sql_fetsel('spip_articles.id_article, spip_articles.titre', 
		'spip_articles',
		"id_article=$id_article");
	return $row;
}
function sc_trouver_corr_pl ($id_article) {
	$row = sql_fetsel(
	'spip_articles.id_article, spip_rubriques.titre, spip_rubriques.id_rubrique, spip_rubriques.id_secteur', 
	'spip_articles LEFT JOIN spip_rubriques ON spip_rubriques.id_rubrique = spip_articles.id_rubrique', 
	"id_article=$id_article");
	return $row;
}
function sc_decoder_date ($date_d, $date_e, $mode=false, $court=false) {
	if($mode == 'skel') {
		$date_d = date_ical($date_d);
		$date_e = date_ical($date_e);
	}
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
		if ($court == 'oui') {
			$resultat = '<acronym title="'.$debut['jour_fr'].'" class="spip_acronym">'.substr($debut['jour_fr'],0,2).'</acronym>&nbsp;'.$debut['jour'].'&nbsp;';
		}
		else {
		if (intval($debut['jour']) < 10)
			$debut['jour'] = substr($debut['jour'], 1, 1);
		$resultat = _T('soyezcreateurs:agenda_sd', array(
			'djour_l' => $debut['jour_fr'],
			'djour' => $debut['jour'],
			'dmois_l' => $debut['mois_fr'],
			'dannee' => $debut['annee'],
			'dheure' => $debut['heure'],
			'dminutes' => $debut['minutes'],
			'fheure' => $fin['heure'],
			'fminutes' => $fin['minutes']
			)
		);
		}
	}
	else if (!$get_same) {
		if ($court == 'oui') {
			$resultat = '<acronym title="'.$debut['jour_fr'].'" class="spip_acronym">'.substr($debut['jour_fr'],0,2).'</acronym>&nbsp;'.$debut['jour'];
			$resultat .= ' &ndash; <acronym title="'.$fin['jour_fr'].'" class="spip_acronym">'.substr($fin['jour_fr'],0,2).'</acronym>&nbsp;'.$fin['jour'];
			$resultat .= '&nbsp;'.$fin['mois_fr'].'&nbsp;'.$fin['annee'].'&nbsp;';
		}
		else {
		if (intval($debut['jour']) < 10)
			$debut['jour'] = substr($debut['jour'], 1, 1);
		if (intval($fin['jour']) < 10)
			$fin['jour'] = substr($fin['jour'], 1, 1);
		$resultat = _T('soyezcreateurs:agenda_fsd', array(
			'djour_l' => $debut['jour_fr'],
			'djour' => $debut['jour'],
			'dmois_l' => $debut['mois_fr'],
			'dannee' => $debut['annee'],
			'dheure' => $debut['heure'],
			'dminutes' => $debut['minutes'],
			'fjour_l' => $fin['jour_fr'],
			'fjour' => $fin['jour'],
			'fmois_l' => $fin['mois_fr'],
			'fannee' => $fin['annee'],
			'fheure' => $fin['heure'],
			'fminutes' => $fin['minutes']
			)
		);
		}
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
function sc_agenda_grand($i) {
  $args = func_get_args();
  $une_date = array_shift($args); // une date comme balise
  $sinon = array_shift($args);
  if (!$une_date) return $sinon;
  $type = 'sc_grand';
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
function http_calendrier_sc_grand($annee, $mois, $jour, $echelle, $partie_cal, $script, $ancre, $evt) {
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
		$aff = '';
		if ($evts) {
			$nb_elmts= @count($evts);
			if ($nb_elmts>1){
				foreach($evts as $key => $ev) {
					if ($key == 0) {
						$aff .= intval($jour_mois_precedent);
						$aff .= '<div class="odd">';
						$row = sc_trouver_corr_pl($ev['ID']);
						$row2 = sc_trouver_corr_un($ev['ID']);
						$aff .= '<strong>'.supprimer_numero($row['titre']).'</strong>&nbsp;: ';
						$url = generer_url_entite($row2['id_article'], 'article');
						$aff .= "<a href='".$url."'>".$row2['titre']."&nbsp;: ".$ev['SUMMARY']."</a>";
						$aff .= '</div>';
					} else {
					$aff .= '<div>';
					$row = sc_trouver_corr_pl($ev['ID']);
					$row2 = sc_trouver_corr_un($ev['ID']);
					$aff .= "<strong>".supprimer_numero($row['titre'])."</strong>&nbsp;: ";
					$url = generer_url_entite($row2['id_article'], 'article');
					$aff .= "<a href='".$url."'>".$row2['titre']."&nbsp;: ".$ev['SUMMARY']."</a>";
					$aff .= '</div>';
					}
				$class='agendanotthismonth events';
			}
			}
			else{
				$aff .= intval($jour_mois_precedent);
				$aff .= '<div class="odd">';
				$row = sc_trouver_corr_pl($evts[0]['ID']);
				$row2 = sc_trouver_corr_un($evts[0]['ID']);
				$aff .= '<strong>'.supprimer_numero($row['titre']).'</strong>&nbsp;: ';
				$url = generer_url_entite($row2['id_article'], 'article');
				$aff .= "<a href='".$url."'>".$row2['titre']."&nbsp;: ".$evts[0]['SUMMARY']."</a>";
				$aff .= '</div>';
				$class='agendanotthismonth event';
			}
			
		}
		else {
			$evts = intval($jour_mois_precedent);
			$class = 'agendanotthismonth';
		}
		$ligne .= '<td valign="top" class="$class">'.$aff.'</td>';
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
		$aff = '';
		if ($evts) {
			$nb_elmts= @count($evts);
			if ($nb_elmts>1){
				foreach($evts as $key => $ev) {
					if ($key == 0) {
						$aff .= intval($jour);
						$aff .= '<div class="odd">';
						$row = sc_trouver_corr_pl($ev['ID']);
						$row2 = sc_trouver_corr_un($ev['ID']);
						$aff .= '<strong>'.supprimer_numero($row['titre']).'</strong>&nbsp;: ';
						$url = generer_url_entite($row2['id_article'], 'article');
						$aff .= "<a href='".$url."'>".$row2['titre']."&nbsp;: ".$ev['SUMMARY']."</a>";
						$aff .= '</div>';
					} else {
					$aff .= '<div>';
					$row = sc_trouver_corr_pl($ev['ID']);
					$row2 = sc_trouver_corr_un($ev['ID']);
					$aff .= "<strong>".supprimer_numero($row['titre'])."</strong>&nbsp;: ";
					$url = generer_url_entite($row2['id_article'], 'article');
					$aff .= "<a href='".$url."'>".$row2['titre']."&nbsp;: ".$ev['SUMMARY']."</a>";
					$aff .= '</div>';
					}
					$class = 'agendathismonth event';
				}
			}
			else{
				$aff .= intval($jour);
				$aff .= '<div class="odd">';
				$row = sc_trouver_corr_pl($evts[0]['ID']);
				$row2 = sc_trouver_corr_un($evts[0]['ID']);
				$aff .= '<strong>'.supprimer_numero($row['titre']).'</strong>&nbsp;: ';
				$url = generer_url_entite($row2['id_article'], 'article');
				$aff .= "<a href='".$url."'>".$row2['titre']."&nbsp;: ".$evts[0]['SUMMARY']."</a>";
				$aff .= '</div>';
				$class = 'agendathismonth event';
			}
		}
		else {
			$aff = intval($jour);
			$class='agendathismonth';
		}
		$ligne .= '<td valign="top" class="'.($amj == date("Ymd")?"agendathisday": $class).'">' . $aff . '</td>';
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
		$aff = '';
		if ($evts) {
			$nb_elmts= @count($evts);
			if ($nb_elmts>1){
				foreach($evts as $key => $ev) {
					if ($key == 0) {
						$aff .= intval($jour_mois_suivant++);
						$aff .= '<div class="odd">';
						$row = sc_trouver_corr_pl($ev['ID']);
						$row2 = sc_trouver_corr_un($ev['ID']);
						$aff .= '<strong>'.supprimer_numero($row['titre']).'</strong>&nbsp;: ';
						$url = generer_url_entite($row2['id_article'], 'article');
						$aff .= "<a href='".$url."'>".$row2['titre']."&nbsp;: ".$ev['SUMMARY']."</a>";
						$aff .= '</div>';
					} else {
					$aff .= '<div>';
					$row = sc_trouver_corr_pl($ev['ID']);
					$row2 = sc_trouver_corr_un($ev['ID']);
					$aff .= "<strong>".supprimer_numero($row['titre'])."</strong>&nbsp;: ";
					$url = generer_url_entite($row2['id_article'], 'article');
					$aff .= "<a href='".$url."'>".$row2['titre']."&nbsp;: ".$ev['SUMMARY']."</a>";
					$aff .= '</div>';
					}
					$class='agendanotthismonth events';
			}
			}
			else{
				$aff .= intval($jour_mois_suivant++);
				$aff .= '<div class="odd">';
				$row = sc_trouver_corr_pl($evts[0]['ID']);
				$row2 = sc_trouver_corr_un($evts[0]['ID']);
				$aff .= '<strong>'.supprimer_numero($row['titre']).'</strong>&nbsp;: ';
				$url = generer_url_entite($row2['id_article'], 'article');
				$aff .= "<a href='".$url."'>".$row2['titre']."&nbsp;: ".$evts[0]['SUMMARY']."</a>";
				$aff .= '</div>';
				$class='agendanotthismonth event';
			}
			
		}
		else {
			$evts = intval($jour_mois_suivant++);
			$class = 'agendanotthismonth';
		}
		$ligne .= "\n<td valign='top' class=\"$class\">".$aff."</td>";
	}

	return $total . ($ligne ? "\n<tr>$ligne\n</tr>" : '');
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
				$id_rub = intval($row['id_secteur']);
				$titre_rub = supprimer_numero($row['titre']);
				$url = generer_url_public('agenda', 'id_rubrique='.$id_rub.'');
				$evts = "<a href='".$url."' title='$titre_rub ("._T('agenda:voir_evenements_rubrique').")'>".intval($jour_mois_precedent)."</a>";
				$class='agendanotthismonth events';
			}
			else{
				$row = sc_trouver_corr_un($evts[0]['ID']);
				$url = generer_url_entite($row['id_article'], 'article');
				$info = sc_decoder_date($evts[0]['DTSTART'], $evts[0]['DTEND']);
				$title = $row['titre']." : ".$evts[0]['SUMMARY']." - ".$info;
				$evts = "<a href='".$url."' title='".$title.
				"'>".intval($jour_mois_precedent)."</a>";
				$class='agendanotthismonth event';
			}
			
		}
		else {
			$evts = intval($jour_mois_precedent);
			$class = 'agendanotthismonth';
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
				$id_rub = intval($row['id_secteur']);
				$titre_rub = supprimer_numero($row['titre']);
				$url = generer_url_public('agenda', 'id_rubrique='.$id_rub.'');
				$evts = "<a href='".$url."' title='$titre_rub ("._T('agenda:voir_evenements_rubrique').")'>".intval($jour)."</a>";
				$class = 'agendathismonth events';
			}
			else{
				$row = sc_trouver_corr_un($evts[0]['ID']);
				$url = generer_url_entite($row['id_article'], 'article');
				$info = sc_decoder_date($evts[0]['DTSTART'], $evts[0]['DTEND']);
				$title = $row['titre']." : ".$evts[0]['SUMMARY']." - ".$info;
				$evts = "<a href='".$url."' title='".$title.
				"'>".intval($jour)."</a>";
				$class = 'agendathismonth event';
			}
		}
		else {
			$evts = intval($jour);
			$class='agendathismonth';
		}
		$ligne .= "\n\t<td  class='".($amj == date("Ymd")?'agendathisday': $class)."'>" . $evts . "\n\t</td>";
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
				$id_rub = intval($row['id_secteur']);
				$titre_rub = supprimer_numero($row['titre']);
				$url = generer_url_public('agenda', 'id_rubrique='.$id_rub.'');
				$evts = "<a href='".$url."' title='$titre_rub ("._T('agenda:voir_evenements_rubrique').")'>".intval($jour_mois_suivant++)."</a>";
				$class='agendanotthismonth events';
			}
			else{
				$row = sc_trouver_corr_un($evts[0]['ID']);
				$url = generer_url_entite($row['id_article'], 'article');
				$info = sc_decoder_date($evts[0]['DTSTART'], $evts[0]['DTEND']);
				$title = $row['titre']." : ".$evts[0]['SUMMARY']." - ".$info;
				$evts = "<a href='".$url."' title='".$title.
				"'>".intval($jour_mois_suivant++)."</a>";
				$class='agendanotthismonth event';
			}
			
		}
		else {
			$evts = intval($jour_mois_suivant++);
			$class = 'agendanotthismonth';
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