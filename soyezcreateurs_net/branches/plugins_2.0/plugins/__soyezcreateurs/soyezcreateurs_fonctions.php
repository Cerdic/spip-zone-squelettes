<?php
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
 * https://contrib.spip.net/spip.php?article76
*/
function sc_sommaire_article($texte,$istxt=0)
{
	// Conversion des intertitres d'enluminures type {ß{titre}ß}
	// ou ß est un nombre en intertitres avec des étoiles type {{{* (avec ß étoiles)
	// {1{ sera converti en {{{* ; {2{ sera converti en {{{** ; etc.
	$texte=preg_replace_callback ("/(\{(\d)\{)(.*?)(\}\\2\})/",
					create_function (
						'$matches',
						'return "{{{".str_repeat("*",$matches[2]).$matches[3]."}}}";'
						),
					$texte);

	preg_match_all("|\{\{\{([*]*?)(.*)(\}\}\})|U", $texte, $regs);


	$nb=1;
	$lastniveau=0;
	if ($istxt==0) {
		$texte='';
		for($j=0;$j<count($regs[2]);$j++) {
			$niveau=strlen($regs[1][$j]);
			if ($niveau===0) {$niveau=1;}
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
			$niveau=strlen($regs[1][$j]);
			if ($niveau===0) {$niveau=1;}
			if ($niveau===1) { $puce="\n- ";}
			if ($niveau===2) { $puce=" · ";}
			if ($niveau===3) { $puce="  × ";}
			if ($niveau===4) { $puce="   ° ";}
			if ($niveau===5) { $puce="    ¤ ";}
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
	$texte = preg_replace("#<[^<]*>#", "", $texte);
	$texte = preg_replace("#[^A-Za-z0-9]#", "_", strtr($texte,$accents,"AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn"));
	$texte = preg_replace("#Â #", "_", $texte); 
	$texte = preg_replace("#\s#", "_", $texte);
	$texte = preg_replace("#_+#", "_", $texte);
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

/* Permet dans un texte de faire [->refsite12] qui fera un lien vers la page du site en cours décrivant ce site (et non pas un lien direct vers le site de destination) */
function generer_url_refsite($id, $args, $ancre) {
	return array('site', $id);
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
function sc_decoder_date ($date_d, $date_e, $horaire='oui', $mode=false, $court=false) {
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
	$debut['jour_fr'] = ucfirst(sc_get_jour(mktime($debut['heure'], $debut['minutes'], $debut['secondes'], $debut['mois'], $debut['jour'], $debut['annee'])));
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
			if ($horaire=='oui') {
				$comd = $debut['heure'].$debut['minutes'];
				$comf = $fin['heure'].$fin['minutes'];
				if ($comd == $comf) {
					$resultat = _T('soyezcreateurs:agenda_sd_h', array(
						'djour_l' => ucfirst($debut['jour_fr']),
						'djour' => $debut['jour'],
						'dmois_l' => $debut['mois_fr'],
						'dannee' => $debut['annee'],
						'dheure' => $debut['heure'],
						'dminutes' => $debut['minutes'],
						)
					);
				}
				else {
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
			} else {
				$resultat = _T('soyezcreateurs:agenda_sd_notime', array(
					'djour_l' => ucfirst($debut['jour_fr']),
					'djour' => $debut['jour'],
					'dmois_l' => $debut['mois_fr'],
					'dannee' => $debut['annee']
					)
				);
			}
		}
	}
	else if (!$get_same) {
		if ($court == 'oui') {
			$resultat = '<acronym title="'.$debut['jour_fr'].'" class="spip_acronym">'.substr($debut['jour_fr'],0,2).'</acronym>&nbsp;'.$debut['jour'];
			$resultat .= ' &ndash; <acronym title="'.$fin['jour_fr'].'" class="spip_acronym">'.substr($fin['jour_fr'],0,2).'</acronym>&nbsp;'.$fin['jour'];
			if ($fin['annee'] != $debut['annee']) {
				$resultat .= '&nbsp;'.$fin['mois_fr'].'&nbsp;'.$fin['annee'].'&nbsp;';
			} else if ($fin['mois'] != $debut['mois']) {
				$resultat .= '&nbsp;'.$fin['mois_fr'].'&nbsp;';
			} else {
				$resultat .= '&nbsp;';
			}
		}
		else {
			if (intval($debut['jour']) < 10)
				$debut['jour'] = substr($debut['jour'], 1, 1);
			if (intval($fin['jour']) < 10)
				$fin['jour'] = substr($fin['jour'], 1, 1);
			if ($horaire=='oui') {
				$resultat = _T('soyezcreateurs:agenda_fsd', array(
					'djour_l' => ucfirst($debut['jour_fr']),
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
			} else {
				$resultat = _T('soyezcreateurs:agenda_fsd_notime', array(
					'djour_l' => ucfirst($debut['jour_fr']),
					'djour' => $debut['jour'],
					'dmois_l' => $debut['mois_fr'],
					'dannee' => $debut['annee'],
					'fjour_l' => $fin['jour_fr'],
					'fjour' => $fin['jour'],
					'fmois_l' => $fin['mois_fr'],
					'fannee' => $fin['annee']
					)
				);
			}
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
function sc_generer_ligne_agenda($jour, $amj, $evts, $type, $agenda) {
	//definissons le retour en un tableau
	$aff = array();
	//s'il y a un/des evenement(s) 
	if ($evts) {
		$nb_elmts= @count($evts);
		//s'il y a plus d'un evenements
		if ($nb_elmts>1){
			if ($agenda == 'mini') {
				$row = sc_trouver_corr_pl($evts[0]['ID']);
				$id_rub = intval($row['id_secteur']);
				$titre_rub = supprimer_numero($row['titre']);
				$url = generer_url_public('agenda_calendrier', 'id_rubrique='.$id_rub.'');
				$aff['ligne'] = "<a href='".$url."' title='".supprimer_tags(typo($titre_rub))." ("._T('agenda:voir_evenements_rubrique').")'>".intval($jour)."</a>";
			}
			foreach($evts as $key => $ev) {
				if ($agenda == 'grand') {
					if ($key == 0) {
						$aff['ligne'] .= intval($jour);
						$aff['ligne'] .= '<div class="odd">';
						$row = sc_trouver_corr_pl($ev['ID']);
						$row2 = sc_trouver_corr_un($ev['ID']);
						$aff['ligne'] .= '<strong>'.supprimer_numero(typo($row['titre'])).'</strong>&nbsp;: ';
						$url = generer_url_entite($row2['id_article'], 'article');
						if (supprimer_tags(typo($ev['SUMMARY'])) == $row2['titre'])
							$aff['ligne'] .= "<a href='".$url."'>".$ev['SUMMARY']."</a>";
						else
							$aff['ligne'] .= "<a href='".$url."'>".$row2['titre']."&nbsp;: ".$ev['SUMMARY']."</a>";	
						$aff['ligne'] .= '</div>';
					}
					else {
						$aff['ligne'] .= '<div>';
						$row = sc_trouver_corr_pl($ev['ID']);
						$row2 = sc_trouver_corr_un($ev['ID']);
						$aff['ligne'] .= "<strong>".supprimer_numero(typo($row['titre']))."</strong>&nbsp;: ";
						$url = generer_url_entite($row2['id_article'], 'article');
						if (supprimer_tags(typo($ev['SUMMARY'])) == $row2['titre'])
							$aff['ligne'] .= "<a href='".$url."'>".$ev['SUMMARY']."</a>";
						else
							$aff['ligne'] .= "<a href='".$url."'>".$row2['titre']."&nbsp;: ".$ev['SUMMARY']."</a>";	
						$aff['ligne'] .= '</div>';
					}
				}
			}
		$aff['class']= $type.' events';
		}
		//s'il n'y a qu'un evenement
		else{
			if ($agenda == 'grand') {
				$aff['ligne'] .= intval($jour);
				$aff['ligne'] .= '<div class="odd">';
				$row = sc_trouver_corr_pl($evts[0]['ID']);
				$row2 = sc_trouver_corr_un($evts[0]['ID']);
				$aff['ligne'] .= '<strong>'.supprimer_numero(typo($row['titre'])).'</strong>&nbsp;: ';
					$url = generer_url_entite($row2['id_article'], 'article');
				if (supprimer_tags(typo($evts[0]['SUMMARY'])) == supprimer_tags(typo(supprimer_numero($row2['titre']))))
					$aff['ligne'] .= "<a href='".$url."'>".$evts[0]['SUMMARY']."</a>";
				else
					$aff['ligne'] .= "<a href='".$url."'>".$row2['titre']."&nbsp;: ".$evts[0]['SUMMARY']."</a>";
				$aff['ligne'] .= '</div>';
			}
			else if ($agenda == 'mini') {
				$row = sc_trouver_corr_un($evts[0]['ID']);
				$url = generer_url_entite($row['id_article'], 'article');
				$info = sc_decoder_date($evts[0]['DTSTART'], $evts[0]['DTEND'], $evts[0]['HORAIRE']);
				if (supprimer_tags(typo($evts[0]['SUMMARY'])) == supprimer_tags(typo(supprimer_numero($row['titre']))))
					$title = $row['titre']." - ".$info;
				else
					$title = $row['titre']." : ".$evts[0]['SUMMARY']." - ".$info;
				$aff['ligne'] = "<a href='".$url."' title='".supprimer_tags(typo($title))."'>".intval($jour)."</a>";
			}
		$aff['class']= $type.' event';
		}
	}
	//s'il n'y a rien
	else {
		$aff['ligne'] = intval($jour);
		$aff['class'] = $type;
	}
	return $aff;
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
		$aff = sc_generer_ligne_agenda($jour_mois_precedent, $amj, $evts, 'agendanotthismonth', 'grand');
		$ligne .= '<td valign="top" class="'.$aff['class'].'">'.$aff['ligne'].'</td>';
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
		$aff = sc_generer_ligne_agenda($jour, $amj, $evts, 'agendathismonth', 'grand');
		$ligne .= '<td valign="top" class="'.($amj == date("Ymd")?"agendathisday": $aff['class']).'">' . $aff['ligne'] . '</td>';
	}
	$jour_mois_suivant=0;
	// affichage de la fin de semaine hors periode
	for($j=$jour_semaine ? $jour_semaine : 7; $j<7; $j++) {
		$nom = mktime(1,1,1,$mois+1,$j,$annee);
		$jour = date("d",$nom);
		$jour_semaine = date("w",$nom);
		$mois_suivant = date("m",$nom);
		$annee_en_cours = date("Y",$nom);
		$amj = date("Y",$nom) . $mois_suivant . '0'.$jour_mois_suivant++;
		$evts = $evenements[$amj];
		$aff = sc_generer_ligne_agenda($jour_mois_suivant, $amj, $evts, 'agendanotthismonth', 'grand');
		$ligne .= '<td valign="top" class="'.$aff['class'].'">'.$aff['ligne'].'</td>';
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
		$aff = sc_generer_ligne_agenda($jour_mois_precedent, $amj, $evts, 'agendanotthismonth', 'mini');
		$ligne .= '<td class="'.$aff['class'].'">'.$aff['ligne'].'</td>';
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
		$aff = sc_generer_ligne_agenda($jour, $amj, $evts, 'agendathismonth', 'mini');
		$ligne .= '<td class="'.($amj == date("Ymd")?"agendathisday": $aff['class']).'">' . $aff['ligne'] . '</td>';
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
		$aff = sc_generer_ligne_agenda($jour_mois_suivant++, $amj, $evts, 'agendanotthismonth', 'mini');
		$ligne .= '<td class="'.$aff['class'].'">'.$aff['ligne'].'</td>';
	}

	return $total . ($ligne ? "\n<tr>$ligne\n</tr>" : '');
}
function sc_agenda_memo_full($date_deb=0, $date_fin=0 , $titre='', $descriptif='', $lieu='', $url='', $horaire='oui', $cal='')
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
			'HORAIRE' => $horaire,
			'LOCATION' => $lieu,
			'ID' => $url);
		$ts_startday1 += 26*3600; // le jour suivant : +26 h pour gerer les changements d'heure
		$ts_startday1 = mktime(0, 0, 0, date("m",$ts_startday1), 
		date("d",$ts_startday1), date("Y",$ts_startday1)); // et remise a zero de l'heure	
	}
	// toujours retourner vide pour qu'il ne se passe rien
	return "";
}

function direction_css_intelligente ($css, $voulue='') {
	// On teste si la css est distante
	// Si elle est distante, on commence a preparer le chemin de la css
	if (preg_match(",^http:,i",$css)){
		$distante = true;
		// en cas de sript php on prend ce qui est après le ?
		if ($n = strstr(basename($css), '?')) {
			$chemin = substr($n, 1);
		}
	}
	else {
		$distante = false;
		$chemin = $css;
	}
	
	// avant tout si on a precise le sens voulu en argument, le prendre en compte
	if ($voulue = strtolower($voulue)) {
		if ($voulue != 'rtl' AND $voulue != 'ltr')
			$voulue = lang_dir($voulue);
	}
	else
		$voulue =  lang_dir();

	$r = count($r) > 1;
	$right = $r ? 'left' : 'right'; // 'right' de la css lue en entree
	$dir = $r ? 'rtl' : 'ltr';
	$ndir = $r ? 'ltr' : 'rtl';

	if ($voulue == $dir)
		return $css;
	
	// construction du chemin
	$dir_var = sous_repertoire (_DIR_VAR, 'cache-css');
	// enlevons les caracteres exotiques
	$chemin = preg_replace(',[^\w-],', '', basename($chemin));
	$f = $dir_var
		. preg_replace(',.*/(.*?)(_rtl)?\.css,', '\1', $chemin)
		. '.' . substr(md5($chemin), 0,4) . '_' . $ndir . '.css';
		
	if (!$distante AND !preg_match(',(_rtl)?\.css$,i', $css, $r)) return $css;

	// on regarde si une css _rtl existe
	$cd = preg_replace(',(_rtl)?\.css$,i', '_'.$ndir.'.css', $css);
	if (@file_exists($cd)) {
		return $cd;
	}
	
	// Si le fichier est en cache depuis pas trop de temps
	// on le retourne
	if (@file_exists($f)) {
		if (@filemtime($f) > @filemtime($css))
			return $f;
	}
	
	if ($distante){
		include_spip('inc/distant');
		if ($headers = recuperer_page($css, false, true, $max, '', '', true)) {
			list($headers, $a['body']) = explode("\n\n", $headers, 2);
			if (preg_match(",\nContent-Type: *([^[:space:];]*),i", "\n$headers", $regs))
				$mime_type = (trim($regs[1]));
				$type = sql_getfetsel('extension', 'spip_types_documents', 'mime_type='.sql_quote($mime_type));
		}
		if ($type != 'css') return $css;
		$contenu = recuperer_page($css);
		if (!$contenu) return $css;
	}
	else {
		if ((@filemtime($f) > @filemtime($css))
			AND ($GLOBALS['var_mode'] != 'recalcul'))
			return $f;
		if (!lire_fichier($css, $contenu))
			return $css;
	}

	$contenu = str_replace(
		array('right', 'left', '@@@@L E F T@@@@'),
		array('@@@@L E F T@@@@', 'right', 'left'),
		$contenu);
	
	// reperer les @import auxquels il faut propager le direction_css
	preg_match_all(",\@import\s*url\s*\(\s*['\"]?([^'\"/][^:]*)['\"]?\s*\),Uims",$contenu,$regs);
	$src = array();$src_direction_css = array();$src_faux_abs=array();
	$d = dirname($css);
	foreach($regs[1] as $k=>$import_css){
		$css_direction = direction_css("$d/$import_css",$voulue);
		// si la css_direction est dans le meme path que la css d'origine, on tronque le path, elle sera passee en absolue
		if (substr($css_direction,0,strlen($d)+1)=="$d/") $css_direction = substr($css_direction,strlen($d)+1);
		// si la css_direction commence par $dir_var on la fait passer pour une absolue
		elseif (substr($css_direction,0,strlen($dir_var))==$dir_var) {
			$css_direction = substr($css_direction,strlen($dir_var));
			$src_faux_abs["/@@@@@@/".$css_direction] = $css_direction;
			$css_direction = "/@@@@@@/".$css_direction;
		}
		$src[] = $regs[0][$k];
		$src_direction_css[] = str_replace($import_css,$css_direction,$regs[0][$k]);
	}
	$contenu = str_replace($src,$src_direction_css,$contenu);

	$contenu = urls_absolues_css($contenu, $css);

	// virer les fausses url absolues que l'on a mis dans les import
	if (count($src_faux_abs))
		$contenu = str_replace(array_keys($src_faux_abs),$src_faux_abs,$contenu);

	if (!ecrire_fichier($f, $contenu))
		return $css;

	return $f;
}

?>