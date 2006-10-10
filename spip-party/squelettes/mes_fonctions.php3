<?php

$GLOBALS['puce'] = '- ';
$GLOBALS['espace_logos'] = 0;

# titre homogene http://www.spip-contrib.net/article46.html
function titre_homogene($titre) {
  $titre = tronquer_titre($titre);
  return casse_titre($titre);
}

// tronque un titre a 60 caracteres, sans coupure de mot
function tronquer_titre($texte) {
  return couper_texte($texte, 60);
}

// coupe une chaine a $limite caracteres, sans coupure de mot
// (un mot est considee comme un groupe de caracteres separes par des espaces)
function couper_texte($texte, $limite) {
  // la longueur du texte est <= $limite, on retourne le texte entier
  if (strlen($texte) <= $limite) return $texte;
  // on fait la coupure avant le 1e espace apres $limite caracteres
  $texte = nl2br($texte);
  $pos = strpos(substr($texte, $limite), " ");
  // s'il y a un espace apres $limite caracteres ou juste apres $limite caracteres
  // on retourne la partie de $texte jusqu'avant cet espace
  if (is_integer($pos) && $pos) return substr($texte, 0, $limite+$pos) . " (...)";
  // sinon (pas d'espace apres $limite caracteres ou juste apres $limite caracteres) on retourne le texte
  else return $texte;
}

// verifie la casse du titre afin de le mettre en minuscules
// s'il est tout en majuscules et de forcer la 1ere lettre en majuscule
function casse_titre($titre) {
  if (!ereg("([a-z|\.]+)", $titre)) $titre = strtolower($titre);
  // si le titre commence par un numero (1. ), 
  // il faut mettre le 1er car qui suit en majuscules
  if (ereg("^[0-9]+\. ", $titre)) {
    $pos = strpos($titre, " ");
    if (is_integer($pos) && $pos) 
      return substr($titre, 0, $pos) . " " . ucfirst(substr($titre, $pos+1));
    else return $titre;
  }
  else return ucfirst($titre);
}


function compteur($truc='',$add=0) {
  static $compteur;
  if($add) {
	if($truc) $compteur+=$add;
	return $truc;
  } 
  return $compteur;
}



function listeDesListes($chaine){
	include_spip('inc/flock');
	//$contenu=file_get_contents("http://listes.rezo.net/listes.php");
	$tempfile = _DIR_SESSIONS.'/listes.rezo.net';
	if (!file_exists($tempfile)||(filemtime($tempfile)+24*3600)<time()){
		$temp=file_get_contents("http://listes.rezo.net/listes.php");
		ecrire_fichier ($tempfile, $temp);	
	}
	lire_fichier ($tempfile, $contenu);

	$contenu=preg_replace("/<[\/]*strong>/","",$contenu);
	$contenu=preg_replace("/\n/","",$contenu);
	$contenu=preg_replace("/\<font color=\"\#666666\" size=2\>/","",$contenu);
	$retour="<a href=\"<a href=\"http:\/\/listes.rezo.net\/mailman\/listinfo\/spip\ title=\"liste d\'entraide spip\">spip</a>&nbsp;";
	preg_match_all("/<a href=\"(http:\/\/listes.rezo.net\/mailman\/listinfo\/[s|S]pip-[a-zA-Z]*)\">[s|S]pip-([a-zA-Z]*)<\/a><br>([^<]*)\</ms",$contenu,$matches, PREG_SET_ORDER);
	foreach ($matches as $val )
	{
		$retour.= "<a href=\"".$val[1]."\" title=\"".$val[3]."\">".$val[2]."</a>&nbsp;";
	}
	return $retour;
}

?>