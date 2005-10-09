<?php

// DEBUT ajout de tables
global $tables_principales;
global $table_date;
$table_date['readings']='date';

$tables_principales['readings']= array(
 'field' => array(
 "id_reading" => "bigint(21) NOT NULL",
 "lang" => "char(2) NOT NULL",
 "date" => "datetime NOT NULL",
 "langdate" => "varchar(30)",
 "feast" => "varchar(40)",
 "bibletext" => "blob",
 "reference" => "varchar(40)"
 ),
 'key' => array("PRIMARY KEY" => "date, lang")
);
// FIN ajout de tables

function url_filename($urlin) {
// strips	a URL to leave just the filename at the end
	if (strrpos($urlin,"/")) {
		$urlin = substr ($urlin, strrpos( $urlin,"/")+1);
	}
return $urlin;
}


function utf8convert($texte, $enc) {
// used for the tz_updates JavaScript feed
   if ($enc != "utf-8") {
	$texte = iconv('UTF-8',$_GET['enc'].'//TRANSLIT',$texte);
   }
return $texte;
}

function idart($myurl) {
// takes xx_article199.html from an url and changes it to id_article=199
// used to call printable version
$myurl = str_replace("?", "&amp;", $myurl);
$cherche="/\w\w_article(\d+)\.html/";
$remplace = "id_article=" . "$1";
return preg_replace( $cherche, $remplace , $myurl, 1);
}

// ****  Date functions

function last_sunday($mydate) {
$mydate = strtotime($mydate);
$mydate = strtotime("last Sunday", $mydate);
return date('Y-m-d', $mydate);
}
function next_sunday($mydate) {
$mydate = strtotime($mydate) + (86400);
$mydate = strtotime("this Sunday", $mydate);
// "next Sunday" jumps more than a week ahead
return date('Y-m-d', $mydate);
}
function diffdays($mydate) {
// gives difference in days from present time
// positive result means date in future & vice-versa
	//	$mydate = strtotime($mydate);
	//	$now = strtotime(date('Y-m-d', time()));
	//	return round(($mydate-$now)/86400);
return datediff('d', date('Y-m-d'), $mydate);
}

function last_month($mydate) {
$mydate = strtotime($mydate);
$mydate = strtotime("-1 Month", $mydate);
return date('Y-m-', $mydate) . "01";
}
function next_month($mydate) {
$mydate = strtotime($mydate);
$mydate = strtotime("+1 Month", $mydate);
return date('Y-m', $mydate) . "-01";
}

function diffmonths($mydate) {
// gives difference in months from present time
// positive result means date in future & vice-versa
return datediff('m', date('Y-m-d'), $mydate);
}

// See: http://www.ilovejackdaniels.com/php/php-datediff-function/
function datediff($interval, $datefrom, $dateto, $using_timestamps = false) {
  /*
    $interval can be:
    yyyy - Number of full years
    q - Number of full quarters
    m - Number of full months
    y - Difference between day numbers
      (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
    d - Number of full days
    w - Number of full weekdays
    ww - Number of full weeks
    h - Number of full hours
    n - Number of full minutes
    s - Number of full seconds (default)
  */

  if (!$using_timestamps) {
    $datefrom = strtotime($datefrom, 0);
    $dateto = strtotime($dateto, 0);
  }
  $difference = $dateto - $datefrom; // Difference in seconds

  switch($interval) {

    case 'yyyy': // Number of full years

      $years_difference = floor($difference / 31536000);
      if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
        $years_difference--;
      }
      if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
        $years_difference++;
      }
      $datediff = $years_difference;
      break;

    case "q": // Number of full quarters

      $quarters_difference = floor($difference / 8035200);
      while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
        $months_difference++;
      }
      $quarters_difference--;
      $datediff = $quarters_difference;
      break;

    case "m": // Number of full months

      $months_difference = floor($difference / 2678400);
      while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
        $months_difference++;
      }
      $months_difference--;
      $datediff = $months_difference;
      break;

    case 'y': // Difference between day numbers

      $datediff = date("z", $dateto) - date("z", $datefrom);
      break;

    case "d": // Number of full days

      $datediff = floor($difference / 86400);
      break;

    case "w": // Number of full weekdays

      $days_difference = floor($difference / 86400);
      $weeks_difference = floor($days_difference / 7); // Complete weeks
      $first_day = date("w", $datefrom);
      $days_remainder = floor($days_difference % 7);
      $odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
      if ($odd_days > 7) { // Sunday
        $days_remainder--;
      }
      if ($odd_days > 6) { // Saturday
        $days_remainder--;
      }
      $datediff = ($weeks_difference * 5) + $days_remainder;
      break;

    case "ww": // Number of full weeks

      $datediff = floor($difference / 604800);
      break;

    case "h": // Number of full hours

      $datediff = floor($difference / 3600);
      break;

    case "n": // Number of full minutes

      $datediff = floor($difference / 60);
      break;

    default: // Number of full seconds (default)

      $datediff = $difference;
      break;
  }
  return $datediff;
}

// Tag for making comments (this function coule be deleted...)
function balise_REM($params) {
  $params->code = "''";
  return $params;
}

$GLOBALS['ouvre_ref'] = '<span class="noteref">';
$GLOBALS['ferme_ref'] = '</span>';
$GLOBALS['ouvre_note'] = '(';
$GLOBALS['ferme_note'] = ') ';
$GLOBALS['espace_logos'] = 0;

// Ajout de raccourcis typographiques
// On reprend les deux variables de personnalisation déjà existantes :
$GLOBALS['debut_intertitre'] = "\n".'<h3 class="spip">';
$GLOBALS['fin_intertitre'] = "</h3>\n";
//  Et on y ajoute six nouvelles pour les intertitre :
$GLOBALS['debut_intertitre_0'] = "\n".'<h2 class="spip">';
$GLOBALS['fin_intertitre_0'] = "</h2>\n";
$GLOBALS['debut_intertitre_2'] = "\n".'<h4 class="spip">';
$GLOBALS['fin_intertitre_2'] = "</h4>\n";
$GLOBALS['debut_intertitre_3'] = "\n".'<h5 class="spip">';
$GLOBALS['fin_intertitre_3'] = "</h5>\n";

function lang2($texte) {
	// used for adding suffixes in the language selector
	// when article's description has "lang2: (xxx)" ;
	if (preg_match('/lang2:\s(.*?);/', $texte, $found)) {
		return "($found[1])";
	} else {
		return '';
	}
}

/*****************************************************************************/
/**  Cette fonction permet de lancer un script PHP dans un article SPIP
/**
/**  La syntaxe est la suivante :
/**    #INCLURE ( nom_fichier )
/**
/**  Auteur  : F. Quointeau
/**  Version : 0.0.2
/**  Date    : 16 Mai 2004
/*****************************************************************************/
function autoriser_php( $texte) {

    // Dossier où sont stockés les scripts
    $dossier_inclus = 'ext/';

    // Liste des scripts autorisés
    $scripts_autorises = Array(
        'ts_readings.php3',
        'ts_pdc.php3',
        'ts_download.php3',
        'ts_monthlyprayer.php3',
        'ts_jh.php3',
        'ts_midi.php3',
        'ts_apt.php3',
        'ts_apthelp.php3',
        'ts_time.php3',
        'ts_parish_query_po.php3'
    );

    // Les fichiers inclus autorises sont : *.php, *.php3, *.php4, *.phtml, *.htm, *.html, *.inc
    $chaine_recherche = '/#INCLU[R|D]E( *)\(( *)([^\)]*\.(php|php3|php4|phtml|htm|html|inc))( *)\)/i';

    // Recherche la chaine #INCLURE(script)
    while( preg_match( $chaine_recherche, $texte, $resultats)) {
        // Verifie le droit d'inclure ce fichier script !
        $autorise = false;
        reset( $scripts_autorises);
        while( $script = each( $scripts_autorises)) {
            if( strcasecmp( $script[value], $resultats[3]) == 0) $autorise = true;
        }
        if( $autorise == true) {
            // Verifie que le fichier existe
            if( file_exists ( $dossier_inclus . $resultats[3])) {
                // Vide le buffer de sortie
                $affichage_php = '';
                // Et lance le fichier inclu !!!
                include( $dossier_inclus . $resultats[3]);
            } else {
                $affichage_php = "<b>#INCLURE: Le fichier de script n'existe pas !</b>";
            }
        } else {
            $affichage_php = "<b>#INCLURE: Script NON autoris&eacute; !</b>";
        }
        // Attention, n'effectue qu'un seul remplacement à la fois !
        $texte = preg_replace( $chaine_recherche, $affichage_php, $texte, 1);
    }
    return( $texte);
}

function antispamtz($texte) {
// copy of the antispam script, for use
// in included .php files (ts_apt.php3,...)
preg_match_all("/mailto:[^\"]*/",$texte,$found);
$total = count($found[0]);
for($i=0; $i < $total; $i++) {
	$comat = strpos($found[0][$i],"@");
	$part1 = substr($found[0][$i],7,($comat-7));
	$part2 = substr($found[0][$i],($comat+1));
// 	$newstr ='#" name="'. $part2 . '" title="' . $part1 . '" onClick="location.href = dolink(this.title, this.name); return false;';
	$newstr ='#" title="' . $part1 . '..&aring;t..' . $part2 . '" onClick="location.href = dolink(this.title); return false;';
	$texte = str_replace($found[0][$i], $newstr, $texte);
        }
// if an email address is given as the text of a link, change it
preg_match_all("/>\S+@{1}\S+\s?<\/a/",$texte,$found);
$total = count($found[0]);
for($i=0; $i < $total; $i++) {
      $texte = str_replace($found[0][$i],">[Email]</a",$texte);
//    $texte = str_replace($found[0][$i],str_replace("@", "###", $found[0][$i]),$texte);
      }
return $texte;
}

// - - -
// voir: inc-balises.php3 et inc-calcul-outils.php3
// fonction standard de calcul de la balise #INTRODUCTION
// on peut la surcharger en definissant dans mes_fonctions.php3 :
// function introduction($type,$texte,$descriptif) {...}
// (original lines commented out)
function introduction($type, $texte, $chapo='', $descriptif='') {
	switch ($type) {
		case 'articles':
		//	if ($descriptif)
		//		return propre($descriptif);
		 //	else
				if (substr($chapo, 0, 1) == '=')	// article virtuel
				return '';
			else
			//	return PtoBR(propre(supprimer_tags(couper_intro($chapo."\n\n\n".$texte, 500))));
				return PtoBR(propre(supprimer_tags(couper_intro(strip_intertitres($chapo."\n\n\n".$texte), 500))));
			break;
		case 'breves':
			return PtoBR(propre(supprimer_tags(couper_intro($texte, 300))));
			break;
		case 'forums':
			return PtoBR(propre(supprimer_tags(couper_intro($texte, 600))));
			break;
		case 'rubriques':
			if ($descriptif)
				return propre($descriptif);
			else
				return PtoBR(propre(supprimer_tags(couper_intro($texte, 600))));
			break;
	}
}

function strip_intertitres($texte) {
// use this to take away the extra subtitles from #INTRODUCTION
$chercher_raccourcis = array(
		/*  1 */	"/\{0\{/",
		/*  2 */	"/\}0\}/",
		/*  3 */	"/\{1\{/",
		/*  4 */	"/\}1\}/",
		/*  5 */	"/\{2\{/",
		/*  6 */	"/\}2\}/",
		/*  7 */	"/\{3\{/",
		/*  8 */	"/\}3\}/");

return preg_replace($chercher_raccourcis, "", $texte);
}

/*
*   +----------------------------------+
 *    Nom du Filtre :    pagination
 *   +----------------------------------+
 *    Date : dimanche 22 août 2004 (updated to use parmetre_url)
 *    Auteur :  James (klike<at>free.fr)
 *   +-------------------------------------+
 *    Fonctions de ce filtre :
 *     affiche la liste des pages d'une boucle contenant
 *     un critère de limite du type {debut_xxx, yyy}
 *   +-------------------------------------+
 *
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.uzine.net/spip_contrib/article.php3?id_article=663
*/

function pagination($total, $position=0, $pas=1, $fonction='') {
  global $clean_link;
  global $pagination_item_avant, $pagination_item_apres, $pagination_separateur;
  tester_variable('pagination_separateur', '&nbsp;| ');
  if (ereg('^debut([-_a-zA-Z0-9]+)$', $position, $match)) {
    $debut_lim = "debut".$match[1];
    $position = intval($GLOBALS['HTTP_GET_VARS'][$debut_lim]);
  }
  $nombre_pages = floor(($total-1)/$pas)+1;
  $texte = '';
  if($nombre_pages>1) {
    $i = 0;
    while($i<$nombre_pages) {
//      $clean_link->delVar($debut_lim);
//      $clean_link->addVar($debut_lim, strval($i*$pas));
//      $url = $clean_link->getUrl();
$url = parametre_url($clean_link->getUrl(), $debut_lim, strval($i*$pas));
      if(function_exists($fonction)) $item = call_user_func($fonction, $i+1);
      else $item = strval($i+1);
      if(($i*$pas) != $position) {
        if(function_exists('lien_pagination')) $item = lien_pagination($url, $item, $i+1);
        else $item = "<a href=\"".$url."\">".$item."</a>";
      }
      $texte .= $pagination_item_avant.$item.$pagination_item_apres;
      if($i<($nombre_pages-1)) $texte .= $pagination_separateur;
      $i++;
    }
    //Correction bug: $clean_link doit revenir à son état initial
    $clean_link->delVar($debut_lim);
    if($position) $clean_link->addVar($debut_lim, $position);
	  $clean_link->delVar('id_document');
     return $texte;
  }
  return '';
}
// FIN du Filtre pagination

?>