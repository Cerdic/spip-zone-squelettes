<?php

function is_date($date)
{
  $date_expl = explode('-', $date);
  if (count($date_expl) == 3)
    if (is_numeric($date_expl[0]) && strlen($date_expl[0]) == 4 &&
        is_numeric($date_expl[1]) && $date_expl[1] >= 1 && $date_expl[1] <= 12 &&
        is_numeric($date_expl[2]) && $date_expl[2] >= 1 && $date_expl[2] <= 31)
      return true;
  return false;
}

function monCalendrier($sortie) {

// quelques variables a definir
  $onlydayofmonth = true;  // si true, on affiche que les jours de ce mois
// url de votre page listant tous les articles d'un jour donné ex "http://www.angers.org/agenda.php3?cal_date="
  $clicable = $_SERVER['PHP_SELF'].'?';
  foreach ($_GET as $k => $v)
    if ($k != 'cal_date' && $k != 'debut_syndic')
      $clicable .= "$k=$v&amp;";
  $clicable .= "cal_date=";
  $clicableformat = "%Y-%m-%d";  // format de la facon dont sont passes les arguments
  $displayweeknumber = false;  // affiche ou non le no de la semaine a gauche
  $displayweekdays = true;  // affiche ou non L M M J V S D en haut
  $sortie = "";
  $filtre = "";
// on remplit $jActif[] de 1 pour chaque jour du mois courrant ayant un article publie

//  $IdRubrique = $_GET['id_rubrique'];
  $IdRubrique = $rubrique;
  if (!empty($IdRubrique) && !is_numeric($IdRubrique))
    die('Paramètre au mauvais format.');
  $IdSyndic = $_GET['id_syndic'];
  if (!empty($IdSyndic) && !is_numeric($IdSyndic))
    die('Paramètre au mauvais format.');
  $tmpdate = addslashes($_GET['cal_date']);
  if (!empty($tmpdate) && !is_date($tmpdate))
    die('Paramètre au mauvais format.');
  //$date_req = ($_GET['cal_date'] ? substr($_GET['cal_date'], 0, 7)  : date("Y-m"));
  $date_req = ($tmpdate ? substr($tmpdate, 0, 7)  : date("Y-m"));

  if ($IdRubrique)
    $filtre .= "AND ss.id_rubrique = $IdRubrique ";
  if ($IdSyndic)
    $filtre .= "AND ss.id_syndic = $IdSyndic ";

  $query =
    "SELECT DISTINCT(DATE_FORMAT(ssa.date, '%d')) AS jour ".
    "FROM ".
      "spip_syndic_articles AS ssa, ".
      "spip_syndic AS ss ".
    "WHERE ss.id_syndic = ssa.id_syndic ".
    "AND ssa.statut = 'publie' ".
    "AND DATE_FORMAT(ssa.date, '%Y-%m') = '".$date_req."' ".
    $filtre.
    "ORDER BY ssa.date DESC LIMIT 1000";
  $result = spip_query($query);
  while($row = spip_fetch_array($result))
    $jActif[intval($row['jour'])] = 1;

  // on affiche le calendrier
//echo $_GET['cal_date'];

    $date = ($_GET['cal_date'] ? getdate(strtotime($_GET['cal_date'])) : getdate());
  
    //On recupere le premier du mois
//var_dump( $date );
    $pmtime = mktime(10, 0, 0, $date["mon"], 1, $date["year"]);
    $pm = getdate($pmtime);
    
    //Puis le numero du premier jour
    $nj = $pm["wday"];
    $mois = array(1 => 'Janvier', 'F&eacute;vrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'D&eacute;cembre');
    //On affiche les titres
    $tomonth = intval(strftime("%m", $pmtime));

    $monthprevzero = ($tomonth - 1 < 10 ? '0' : '');
    $monthnextzero = ($tomonth + 1 < 10 ? '0' : '');
    $url_month_prev = $clicable.date("Y")."-$monthprevzero".($tomonth - 1)."-01";
    $url_month_next = $clicable.date("Y")."-$monthnextzero".($tomonth + 1)."-01";

    $sortie .= "<table summary='calendrier' border='0' cellspacing='1' cellpadding='0' width='130'>\n";
//var_dump( $mois);
// echo " - ".$tomonth;  echo " - ".$mois[$tomonth];

    $sortie .= 
        "            <tr>\n".
          "<td class='calendrier-mois'><a href='$url_month_prev'>&lt;</a></td>\n".
        "              <td class='calendrier-mois' colspan='".($displayweeknumber ? 6 : 5)."'>".$mois[$tomonth]."</td>\n".
          "<td class='calendrier-mois'><a href='$url_month_next'>&gt;</a></td>\n".
        "            </tr>\n";
    if ($displayweekdays) {
      $sortie .= "            <tr>\n";
      if ($displayweeknumber)
        $sortie .= "              <td class='calendrier'><br /></td>\n";
      $sortie .= "              <td class='calendrier-semaine'>L</td>\n";
      $sortie .= "              <td class='calendrier-semaine'>M</td>\n";
      $sortie .= "              <td class='calendrier-semaine'>M</td>\n";
      $sortie .= "              <td class='calendrier-semaine'>J</td>\n";
      $sortie .= "              <td class='calendrier-semaine'>V</td>\n";
      $sortie .= "              <td class='calendrier-semaine'>S</td>\n";
      $sortie .= "              <td class='calendrier-semaine'>D</td>\n";
      $sortie .= "            </tr>\n";
    }

    //Correction: Le mois peut s'etaler sur 6 semaines
    $end=false;
    $debut=0;
    if ($nj<1) $debut=-1;
    for ($sem=$debut; !$end && $sem<=5; $sem++) {
      $sortie .= "            <tr>\n";
      for ($j=1; $j<=7; $j++) {
        $jjdate=@mktime(10,0,0,$date["mon"],1-$nj+$sem*7+$j,$date["year"]);
        $jj=@getdate($jjdate);

        if ($j==1 && $displayweeknumber) {
          $a=strftime("%V", $jjdate);
          if ($a=='') {$a=strftime("%W", $jjdate);
          }
        $sortie.= "              <td><b>$a</b>";
        }

      $sortie.="              <td ";
      if ($jj["mon"]!=$date["mon"]) {
        $sortie .= "class='outday'";
        } else {
        if ($jj["yday"]==$date["yday"]) {
          $sortie .= "class='today'";
          } else {
          if ($jActif[$jj['mday']]) {
            if ($j>5) {
              $sortie .= "class='activeweekendday'";
              } else {
              $sortie .= "class='activeday'";
              }
            } else {
            if ($j>5) {
              $sortie .= "class='weekendday'";
              } else {
              $sortie .= "class='weekday'";
              }
            }
          }
        }
      $sortie .= ">";
      if (!$onlydayofmonth || $jj["mon"]==$date["mon"]) {
                if (($jActif[$jj['mday']]) && ($jj["mon"]==$date["mon"])) $sortie.="<a style='color:white;' href=\"$clicable".strftime($clicableformat, $jjdate)."\">";

        if ($jj["yday"]==$date["yday"]) $sortie.="<b>".$jj["mday"]."</b>";
          else $sortie.=$jj["mday"];
                
        if (($jActif[$jj['mday']]) && ($jj["mon"]==$date["mon"])) $sortie.="</a>";
              } else $sortie.="<br />";
              $sortie.="</td>\n\r";
        }
      $sortie.="            </tr>\n";

    //Cas des mois sur 5 semaines
    $jj=@getdate(@mktime(10,0,0,$date["mon"],1-$nj+$sem*7+8,$date["year"]));
    if($jj["mon"]>$date["mon"] && $jj["year"]==$date["year"] || $jj["year"]>$date["year"]) $end=true;

  }
  $sortie.="          </table>";

  return $sortie;  
}

function monDrawSyndic( $url, $rubrique, $syndic ) {
// global $rubrique;
// global $get_id_rub;

  $jours = array('Mon' => 'Lundi', 'Tue' => 'Mardi', 'Wed' => 'Mercredi', 'Thu' => 'Jeudi', 'Fri' => 'Vendredi', 'Sat' => 'Samedi', 'Sun' => 'Dimanche');
  $mois = array('Jan' => 'Janvier', 'Feb' => 'F&eacute;vrier', 'Mar' => 'Mars', 'Apr' => 'Avril', 'May' => 'Mai', 'Jun' => 'Juin', 'Jul' => 'Juillet', 'Aug' => 'Ao&ucirc;t', 'Sep' => 'Septembre', 'Oct' => 'Octobre', 'Nov' => 'Novembre', 'Dec' => 'D&eacute;cembre');

  $IdRubrique = $rubrique;
  if (!empty($IdRubrique) && !is_numeric($IdRubrique))
    die('Paramètre au mauvais format.');
  $IdSyndic = $syndic;
  if (!empty($IdSyndic) && !is_numeric($IdSyndic))
    die('Paramètre au mauvais format.');
//        $IdRubrique = $get_id_rub;
        //echo "id_rub = ".$rubrique;
        //echo "id_syndic = ".$syndic;

//  $CalDate = ($_GET['cal_date'] ? $_GET['cal_date'] : ($IdSyndic ? '' : date('Y-m-d')));
// date de la veille pour spanish :
  $CalDate = ($_GET['cal_date'] ? $_GET['cal_date'] : ($IdSyndic ? '' : date('Y-m-d', time() - 3600 * 24)));
  if (!empty($CalDate) && !is_date($CalDate))
    die('Paramètre au mauvais format.');
//echo $CalDate;
  $DebutSyndic = ($_GET['debut_syndic'] ? $_GET['debut_syndic'] : 0);
  if (!is_numeric($DebutSyndic))
    die('Paramètre au mauvais format.');
  $NbSyndic = 20;
  $ret = "";

  $filtre = "";
  if ($IdRubrique)
    $filtre .= "AND ss.id_rubrique = $IdRubrique ";
  if ($IdSyndic)
    $filtre .= "AND ss.id_syndic = $IdSyndic ";
  if ($CalDate)
    $filtre .= "AND DATE_FORMAT(ssa.date , '%Y-%m-%d') = '$CalDate' ";

  $ReqGlb = 
    "SELECT SQL_CALC_FOUND_ROWS ".
                        "DISTINCT ( ssa.url) AS url_article, ".
      "ssa.titre AS titre, ".
      "ssa.lesauteurs AS auteurs, ".
      "ssa.descriptif AS descr, ".
      "ss.nom_site AS site, ".
      "ss.id_syndic AS id_syndic, ".
      "ss.descriptif AS descriptif, ".
      "ss.url_site AS url_site, ".
      "ss.url_syndic AS url_syndic, ".
      "DATE_FORMAT(ssa.date, '%a;%e;%b;%Y') AS date_format ".
    "FROM ".
      "spip_syndic_articles AS ssa, ".
      "spip_syndic AS ss ".
    "WHERE ss.id_syndic = ssa.id_syndic ".
    "AND ssa.statut = 'publie' ".
                "AND ss.statut= 'publie'".
    $filtre.
    "ORDER BY ssa.date DESC ".
    "LIMIT $DebutSyndic, $NbSyndic";
//        var_dump( $ReqGlb );
  $ResGlb = spip_query($ReqGlb);

  $ReqFnd = "SELECT FOUND_ROWS()";
  $ResFnd = spip_query($ReqFnd);
  $NbFnd = mysql_result($ResFnd , 0);
  $MaxLinks = 1000; // nombre maximum de links a afficher
  $url = $_SERVER['PHP_SELF'].'?';
  foreach ($_GET as $k => $v)
    if ($k != 'debut_syndic')
      $url .= "$k=$v&amp;";
  $ret .= "<p class='centre'>";
        $ret.="<b style='text-decoration : blink'>Ce jour : $NbFnd informations libres :</b> ";
        $thelinks="";
  // on limite la pagination a $MaxLinks = 1000
  if ( $NbFnd > $MaxLinks ) $NbFnd = $MaxLinks;

  for ($numero = 0; $numero < $NbFnd; $numero = $numero + $NbSyndic) {
    $NumFin = $numero + $NbSyndic;
    if ($NumFin > $NbFnd)
      $NumFin = $NbFnd;
    if ($numero == $DebutSyndic) { $thelinks .= "[".($numero+1)."-$NumFin] "; }
    else { $thelinks .= " [<a href='$url"."debut_syndic=$numero'>".($numero+1)."-$NumFin</a>] "; }

  }
                $ret .= $thelinks;
  $ret .= "</p>\n\r";

  while($RowGlb = spip_fetch_array($ResGlb)) {
    $dt_expl = explode(';', $RowGlb['date_format']);
    $date_format = $jours[$dt_expl[0]].' '.$dt_expl[1].' '.$mois[$dt_expl[2]].' '.$dt_expl[3];
    $ret .= 
      "      <p class='contentTitle'>\n\r".
      "        <span class='header'><a href='".$RowGlb['url_article']."'>".safehtml($RowGlb['titre'])."</a>";
                if ( $RowGlb['auteurs'] != "" )
                {
                 $ret .= " par <b>".$RowGlb['auteurs']."</b></span>\n\r";
                }else { $ret .= "</span>\n\r"; }
                //var_dump( $RowGlb ); // BUG !!! TODO !!! on a pas l'url de l'article en page site !!!!
                $ret.="        $date_format :: <a href='spip.php?site".$RowGlb['id_syndic']."' title=\"".safehtml($RowGlb['descriptif'])."\">".$RowGlb['site']." </a> :: <a href='".htmlentities($RowGlb['url_syndic'])."'>RSS</a>\n\r".
      "      </p>\n\r".
//"<a href='spip.php?site".$RowGlb['id_syndic']."' title='".safehtml($RowGlb['descriptif'])."'>".$RowGlb['site']."</a>".
      "      <p class='contentTexte' />".safehtml($RowGlb['descr'])." <a href='".$RowGlb['url_article']."'>(Lire la suite)".$dump." </a> ".($RowGlb['auteurs'] ? "<a>".$RowGlb['auteurs']."</a>" : "")."\n\r";
  }

  $ret .= "      <p class='centre'>";
               $ret .= $thelinks;

/*  for ($numero = 0; $numero < $NbFnd; $numero = $numero + $NbSyndic) {
    $NumFin = $numero + $NbSyndic;
    if ($NumFin > $NbFnd)
      $NumFin = $NbFnd;
    if ($numero == $DebutSyndic)
      $ret .= " [".($numero+1)."-$NumFin] ";
    else
      $ret .= "[<a href='$url"."debut_syndic=$numero'>".($numero+1)."-$NumFin</a>] ";
  }*/
  $ret .= "</p>\n\r";

  return ($ret);
}

function pourcent($valeur) {
   return $valeur / 100;
}

function affdateYmd($date) {
  return date("Y-m-d", strtotime($date));
}

?>
