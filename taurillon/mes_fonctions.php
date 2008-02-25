<?php

/*
 *   +----------------------------------+
 *    Google Like
 *   +----------------------------------+
*/

function google_like($string){
	$query = rtrim(str_replace("+", " ", $_GET['recherche']));  
	$qt = explode(" ", $query);
	$num = count ($qt);
	$cc = ceil(200 / $num);
		for ($i = 0; $i < $num; $i++) {
			$tab[$i] = preg_split("/($qt[$i])/i",$string,2, PREG_SPLIT_DELIM_CAPTURE);
			if(count($tab[$i])>1){
				$avant[$i] = substr($tab[$i][0],-$cc,$cc);
	    	    	        $apres[$i] = substr($tab[$i][2],0,$cc);
		    	        $string_re .= "<i>[...]</i> $avant[$i]<b>".$tab[$i][1]."</b>$apres[$i] <i>[...]</i> ";
	       }
	 }
	 return $string_re;
}

/*
 *   +----------------------------------+
 *    Nom des Filtres :    noop, filtre_max, coef et repeat
 *   +----------------------------------+
 *    Date : 23 Mars 2005
 *    Auteur :  Pierre Andrews (mortimer.pa@free.fr)
 *   +-------------------------------------+
 *    Fonctions de ces filtres : ces filtres permettent
 *   de faire un affichage variant en fonction de l'importance
 *    de l'objet.  Vois la contrib pour plus d'informations.
 *   +-------------------------------------+
 *
 * Pour toute suggestion, remarque, proposition d'ajout
 * reportez-vous au forum de l'article :
 * http://www.spip_contrib.net/article.php3?id_article=879
*/

function noop($texte) {
  return '';
}

function filtre_max($texte, $id='tout') {
  static $max = array();
  if($max[$id] < $texte) {
    $max[$id] = $texte;
  }
  return $max[$id];
}

function coef($max,$nbr,$nbrMax=6) {
  return ceil(($nbr/$max*$nbrMax));
}

function repeat($nombre,$texte,$avant,$apres,$min = 0) {
  if($nombre > $min) {
    for($i=0;$i < $nombre;$i++) {
      $texte = $avant.$texte.$apres;
    }
    return $texte;
  } else
    return '';
}

/* Retourne l'URL du logo même après usage de filtresgraphiques */
function url_de_logo($texte) {
ereg("src=\"([^\"]*)\"", $texte, $regs);
return $regs[1];
}

/* Affiche le gravatar en focntion du mail */
function gravatar_url($email = '')
{
    if ($email != '') {
        return 'http://www.gravatar.com/avatar.php?gravatar_id='.md5($email).'&size=42&rating=PG';
    } else {
        return '';
    }
}


?>