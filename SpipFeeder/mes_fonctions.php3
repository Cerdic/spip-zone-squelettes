<?php

function print_array($array) {
  echo "<pre>";
  print_r($array);
  echo "</pre>";
  exit();
}

function getInfosFromWeek($week, $year) { 
  $nb_weeks = intval(strftime("%V", mktime(0, 0, 0, 1, 1, $year)));
  if ($nb_weeks == 1)
    $week_mktime = mktime(0, 0, 0, 1, (1 + (($week - 1) * 7)), $year);
  elseif ($nb_weeks == 53)
    $week_mktime = mktime(0, 0, 0, 1, (1 + (($week + 1) * 7)), $year);
  else
    $week_mktime = mktime(0, 0, 0, 1, (1 + (($week) * 7)), $year);

  if (date("w", $week_mktime) > 1)
    $decalage = ((date("w", $week_mktime)) * 60 * 60 * 24);

  echo "<pre>";
  echo intval(strftime("%V", mktime(0, 0, 0, 1, 1, $year)))."<br />";
  echo "* ".date("Y-m-d", $week_mktime);
  echo "<br />";
  echo "* ".date("Y-m-d", $week_mktime - $decalage);
  echo "</pre>";

  $dimanche = $week_mktime - $decalage;
  $lundi = $dimanche - (6 * 60 * 60 * 24);

  $ret = array(
    'date_debut' => date("Y-m-d", $lundi),
    'date_fin' => date("Y-m-d", $dimanche),
    'mois_debut' => date("m", $lundi),
    'mois_fin' => date("m", $dimanche),
    'annee_debut' => date("Y", $lundi),
    'annee_fin' => date("Y", $dimanche),
    'numero' => $week
  );

  print_array($ret);

  return ($ret);
}

function monCalendrier($sortie) {

  // quelques variables à définir
  $onlydayofmonth = true;  // si true, on affiche que les jours de ce mois
  $displayweeknumber = false;  // affiche ou non le n° de la semaine à gauche // En cours d'amélioration ; laisser à false pour le moment
  $displayweekdays = true;  // affiche ou non L M M J V S D en haut
  $sortie = "";
  $filtre = "";

  $clicableformat = "%Y-%m-%d";  // format de la façon dont sont passés les arguments - NE PLUS TOUCHER SVP
  $clicable = $_SERVER['PHP_SELF'].'?';
  foreach ($_GET as $k => $v)
    if ($k != 'cal_date' && $k != 'debut_syndic')
      $clicable .= "$k=$v&amp;";
  $clicable .= "cal_date=";

  // on remplit $jActif[] de 1 pour chaque jour du mois courant ayant au moins un article publié
  // on remplit $sActif[] de 1 pour chaque semaine du mois courant ayant au moins un article publié
  $WeekInfos = false;
  $IdRubrique = $_GET['id_rubrique'];
  $IdSyndic = $_GET['id_syndic'];

  // Si on est sur une semaine
  if (ereg("^([0-9]{4})-([0-9]{2})$", $_GET['cal_date'])) {
    $dt = explode("-", $_GET['cal_date']); 
    $WeekInfos = getInfosFromWeek(intval($dt[1]), $dt[0]);
    $_GET['cal_date'] = $WeekInfos['date_debut'];
  }

  $date_req = ($_GET['cal_date'] ? substr($_GET['cal_date'], 0, 7)  : date("Y-m"));

  if ($IdRubrique)
    $filtre .= "AND ss.id_rubrique = $IdRubrique ";
  if ($IdSyndic)
    $filtre .= "AND ss.id_syndic = $IdSyndic ";

  $query =
    "SELECT ".
      "DISTINCT(DATE_FORMAT(ssa.date, '%d')) AS jour ".
      ($displayweeknumber === true ?
      ", DATE_FORMAT(ssa.date, '%v') AS semaine " : "").
    "FROM ".
      "spip_syndic_articles AS ssa, ".
      "spip_syndic AS ss ".
    "WHERE ss.id_syndic = ssa.id_syndic ".
    "AND ssa.statut = 'publie' ".
    "AND DATE_FORMAT(ssa.date, '%Y-%m') = '".$date_req."' ".
    $filtre.
    "ORDER BY ssa.date DESC";
  //$sortie .= "'$query'<br />";
  $result = spip_query($query);
  while($row = spip_fetch_array($result)) {
    $jActif[intval($row['jour'])] = 1;
    if ($displayweeknumber === true)
      $sActif[$row['semaine']] = 1;
  }

  // on affiche le calendrier
  $date = ($_GET['cal_date'] ? getdate(strtotime($_GET['cal_date'])) : getdate());

  //On recupere le premier du mois
  $pmtime = mktime(10, 0, 0, $date["mon"], 1, $date["year"]);
  $pm = getdate($pmtime);

  //Puis le numero du premier jour
  $nj = $pm["wday"];
  $mois = array(1 => 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
  //On affiche les titres
  $tomonth = intval(strftime("%m", $pmtime));

  $url_month_prev = $clicable.date("Y-m-d", mktime(0, 0, 0, $tomonth - 1, 1, $date["year"]));
  $url_month_next = $clicable.date("Y-m-d", mktime(0, 0, 0, $tomonth + 1, 1, $date["year"]));

  $sortie .= "<table border='0' cellspacing='1' cellpadding='0' width='130'>\n";
  $aff_mois = ($tomonth == date("n") ? "<span class='calendrier-ce-mois'>".$mois[$tomonth]."</span>" : $mois[$tomonth]);
  $sortie .= 
      "            <tr>\n".
      "              <td class='calendrier-mois'><a href='$url_month_prev'>&lt;</a></td>\n".
      "              <td class='calendrier-mois' colspan='".($displayweeknumber ? 6 : 5)."'>".$aff_mois."</td>\n".
      "              <td class='calendrier-mois'><a href='$url_month_next'>&gt;</a></td>\n".
      "            </tr>\n";
  if ($displayweekdays) {
    $sortie .= "            <tr>\n";
    if ($displayweeknumber)
      $sortie .= "              <td class='calendrier'><br /></td>\n";
    $daysinits = array('L', 'M', 'M', 'J', 'V', 'S', 'D');
    foreach ($daysinits as $da)
      $sortie .= "              <td class='calendrier-jour'>".$da."</td>\n";
    $sortie .= "            </tr>\n";
  }

  $today = date("Ynj");

  //Correction: Le mois peut s'etaler sur 6 semaines
  $end = false;
  $debut = 0;
  if ($nj < 1)
    $debut = -1;
  for ($sem = $debut; !$end && $sem <= 5; $sem++) {
    $sortie .= "            <tr>\n";
    for ($j = 1; $j <= 7; $j++) {
      $jjdate = @mktime(10, 0, 0, $date["mon"], 1 - $nj + $sem * 7 + $j, $date["year"]);
      $jj = @getdate($jjdate);

      if ($j == 1 && $displayweeknumber === true) {
        $a = strftime("%V", $jjdate);
        if ($a == '') {
          $a = strftime("%W", $jjdate);
        }
        if ($sActif[$a])
          $sortie .= "              <td class='calendrier-activesemaine'><a style='color:white;' href=\"$clicable".strftime("%Y-", $jjdate).$a."\">$a</a>";
        else
          $sortie .= "              <td class='calendrier-semaine'>$a";
      }

      $sortie .= "              <td ";
      if ($jj["mon"] != $date["mon"]) {
        $sortie .= "class='outday'";
      }
      else {
        if ($jj["yday"] == $date["yday"])
          $sortie .= "class='select-day'";
        else {
          if ($jActif[$jj['mday']]) {
            if ($j > 5)
              $sortie .= "class='activeweekendday'";
            else
              $sortie .= "class='activeday'";
          }
          else {
            if ($j > 5)
              $sortie .= "class='weekendday'";
            else
              $sortie .= "class='weekday'";
          }
        }
      }
      $sortie .= ">";

      if (!$onlydayofmonth || $jj["mon"] == $date["mon"]) {
        if (($jActif[$jj['mday']]) && ($jj["mon"] == $date["mon"]))
          $sortie .= "<a style='color:white;' href=\"$clicable".strftime($clicableformat, $jjdate)."\">";

        if ($jj['year'].$jj['mon'].$jj['mday'] == $today) {
          $sortie .= "<span class='today'>";
        }

        if ($jj["yday"] == $date["yday"])
          $sortie .= "<b>".$jj["mday"]."</b>";
        else
          $sortie .= $jj["mday"];

        if ($jj['year'].$jj['mon'].$jj['mday'] == $today) {
          $sortie .= "</span>";
        }

        if (($jActif[$jj['mday']]) && ($jj["mon"] == $date["mon"]))
          $sortie .= "</a>";
      }
      else
        $sortie.="<br />";

      $sortie.="</td>\n\r";
    }
    $sortie .= "            </tr>\n";

    //Cas des mois sur 5 semaines
    $jj = @getdate(@mktime(10, 0, 0, $date["mon"], 1 - $nj + $sem * 7 + 8, $date["year"]));
    if ($jj["mon"]>$date["mon"] && $jj["year"] == $date["year"] || $jj["year"] > $date["year"])
      $end = true;
  }
  $sortie .= "          </table>";

  return ($sortie);  
}

function monDrawSyndic() {
  $jours = array('Mon' => 'Lundi', 'Tue' => 'Mardi', 'Wed' => 'Mercredi', 'Thu' => 'Jeudi', 'Fri' => 'Vendredi', 'Sat' => 'Samedi', 'Sun' => 'Dimanche');
  $mois = array('Jan' => 'Janvier', 'Feb' => 'Février', 'Mar' => 'Mars', 'Apr' => 'Avril', 'May' => 'Mai', 'Jun' => 'Juin', 'Jul' => 'Juillet', 'Aug' => 'Août', 'Sep' => 'Septembre', 'Oct' => 'Octobre', 'Nov' => 'Novembre', 'Dec' => 'Décembre');

  $IdRubrique = $_GET['id_rubrique'];
  $IdSyndic = $_GET['id_syndic'];
  $CalDate = ($_GET['cal_date'] ? $_GET['cal_date'] : ($IdSyndic ? '' : date('Y-m-d')));
  $DebutSyndic = ($_GET['debut_syndic'] ? $_GET['debut_syndic'] : 0);
  $NbSyndic = 25;
  $ret = "";

  $filtre = "";
  if ($IdRubrique)
    $filtre .= "AND ss.id_rubrique = $IdRubrique ";
  if ($IdSyndic)
    $filtre .= "AND ss.id_syndic = $IdSyndic ";
  if ($CalDate) {
    if (ereg("^([0-9]{4})-([0-9]{2})-([0-9]{2})$", $CalDate)) {
      $DateType = "jour";
      $DateFormat = "%Y-%m-%d";
    }
    elseif (ereg("^([0-9]{4})-([0-9]{2})$", $CalDate)) {
      $DateType = "semaine";
      $DateFormat = "%Y-%v";
    }
    $filtre .= "AND DATE_FORMAT(ssa.date , '$DateFormat') = '$CalDate' ";
  }

  $ReqGlb = 
    "SELECT SQL_CALC_FOUND_ROWS ".
      "DISTINCT ( ssa.url) AS url_article, ".
      "ssa.titre AS titre, ".
      "ssa.lesauteurs AS auteurs, ".
      "ssa.descriptif AS descr, ".
      "ss.nom_site AS site, ".
      "ss.url_site AS url_site, ".
      "ss.url_syndic AS url_syndic, ".
      "DATE_FORMAT(ssa.date, '%a;%e;%b;%Y') AS date_format ".
    "FROM ".
      "spip_syndic_articles AS ssa, ".
      "spip_syndic AS ss ".
    "WHERE ss.id_syndic = ssa.id_syndic ".
    "AND ssa.statut = 'publie' ".
    $filtre.
    "ORDER BY ssa.date DESC ".
    "LIMIT $DebutSyndic, $NbSyndic";
  $ResGlb = spip_query($ReqGlb);

  $ReqFnd = "SELECT FOUND_ROWS()";
  $ResFnd = spip_query($ReqFnd);
  $NbFnd = mysql_result($ResFnd , 0);

  $url = $_SERVER['PHP_SELF'].'?';
  foreach ($_GET as $k => $v)
    if ($k != 'debut_syndic')
      $url .= "$k=$v&amp;";

  $pagination = "<p class='centre'>";
  for ($numero = 0; $numero < $NbFnd; $numero = $numero + $NbSyndic) {
    $NumFin = $numero + $NbSyndic;
    if ($NumFin > $NbFnd)
      $NumFin = $NbFnd;
    if ($numero == $DebutSyndic)
      $pagination .= " [".($numero+1)."-$NumFin] ";
    else
      $pagination .= "[<a href='$url"."debut_syndic=$numero'>".($numero+1)."-$NumFin</a>] ";
  }
  $pagination .= "</p>\n\r";

  $ret .= $pagination;

  while ($RowGlb = spip_fetch_array($ResGlb)) {
    $dt_expl = explode(';', $RowGlb['date_format']);
    $date_format = $jours[$dt_expl[0]].' '.$dt_expl[1].' '.$mois[$dt_expl[2]].' '.$dt_expl[3];
    $ret .= 
      "      <p class='contentTitle'>\n\r".
      "        <span class='header'><a href='".$RowGlb['url_article']."'>".$RowGlb['titre']."</a></span>\n\r".
      "        $date_format :: <a href='".$RowGlb['url_site']."'>".$RowGlb['site']."</a> :: <a href='".$RowGlb['url_syndic']."'>RSS</a>\n\r".
      "      </p>\n\r".
      "      <p class='contentTexte'>".$RowGlb['descr']." <a href='".$RowGlb['url_article']."'>(Lire la suite)</a> ".($RowGlb['auteurs'] ? "<a>".$RowGlb['auteurs']."</a>" : "")."</p>\n\r";
  }

  $ret .= $pagination;

  return ($ret);
}

?>
