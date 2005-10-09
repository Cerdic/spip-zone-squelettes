<?php

// ******** functions for pages in other encodings

function iconvUTF8($texte) {
// for converting UTF-8 text to ISO
 $charcode = getcharcode($GLOBALS['spip_lang']);
 return iconv('UTF-8',$charcode.'//TRANSLIT',$texte);
}

function getcharcode($language) {
// for obtaining charcodes
switch($language) {
 case 'cs':
 case 'sl':
 case 'hu':
 case 'sk':
 case 'pl':
    $charcode  = "ISO-8859-2";
    break;
 case 'lt':
    $charcode  = "ISO-8859-13";
    break;
 case 'ru':
    $charcode  = "ISO-8859-5";
    break;
 case 'ja':
     $charcode  = "EUC-JP";
     break;
 case 'ko':
     $charcode  = "EUC-KR";
     break;
 case 'zh':
     $charcode  = "BIG5";
     break;
  default:
    $charcode  = "ISO-8859-1";
    break;
  }
return $charcode;
}

// ****************

function cryptenoms_txt($texte) {
	preg_match_all("/<masque>(.*?)<\/masque>/",$texte,$found);
	$total = count($found[0]);
	for($i=0; $i < $total; $i++) {
		$texte = str_replace($found[0][$i],cryptemail($found[1][$i]),$texte);
	}
return $texte;
}

function cryptemail($textemail)
{
        $s="";
        for ($i=0;$i<strlen($textemail);$i++) {
          $s.="&#".ord($textemail{$i}).";";
        }
      return $s;
}


/*
// This only needed if table is prefixed "spip_"
// <BOUCLE(READINGS)>
function boucle_READINGS($id_boucle, &$boucles) {
        $boucle = &$boucles[$id_boucle];
        $id_table = $boucle->id_table;
        $boucle->from[] =  "spip_readings AS $id_table";
        return calculer_boucle($id_boucle, $boucles);
}
*/


/*
** N.B. The following 2 functions have been superceded by parametre_url
** which is now available as a filter in the Spip distribution.
"urlpart" permet de supprimer ou de modifier une variable GET dans l'URL fourni
par #SELF.
	urlpart{xxx} ou   |urlpart{xxx,yyy}
Ainsi si #SELF = "article.php3?id_article=1&lang=fr&date=2005-04-24"
	[(#SELF|urlpart{lang})] donnera :
"article.php3?id_article=1&date=2005-04-24"
	[(#SELF|urlpart{lang,#LANG})] pourrait donner par exemple :
"article.php3?id_article=1&lang=es&date=2005-04-24"
*/

function urlpart($monurl,$part,$nouveau="") {
$cherche="/(\?|&amp;)" . $part . "=[^&]*/";
$remplace = $nouveau ? "&amp;" . $part . "=". $nouveau : "" ;
$monurl = preg_replace("$cherche",$remplace,$monurl,1);
	if (strpos($monurl, "&amp;") && !strpos($monurl, "?")) {
	     $monurl =  substr_replace($monurl, "?", strpos($monurl, "&"),5);
	}
return $monurl;
}

function urlpartadd($monurl,$part,$nouveau) {
// similar to urlart, but adds the variable $nouveau,
// even if it doesn't yet exist
$cherche="/(\?|&amp;)" . $part . "=[^&]*/";
$monurl = preg_replace("$cherche","",$monurl,1);
$monurl = $monurl . "&amp;" . $part . "=". $nouveau;
	if (strpos($monurl, "&amp;") && !strpos($monurl, "?")) {
	     $monurl =  substr_replace($monurl, "?", strpos($monurl, "&"),5);
	}
return $monurl;
}


// Date functions

function xnext_sunday($mydate) {
$mydate = strtotime($mydate);
$datearray = getdate($mydate);
$k = 7 - $datearray['wday'];
for ($i = 0; $i < $k; $i++) {
	$mydate = $mydate + (24 * 60 * 60);
}
return date('Y-m-d', $mydate);
}

$nextWeek = time() + (7 * 24 * 60 * 60);
                   // 7 days; 24 hours; 60 mins; 60secs
echo 'Now:      '. date('Y-m-d') ."\n";
echo 'Next Week: '. date('Y-m-d', $nextWeek) ."\n";

?>