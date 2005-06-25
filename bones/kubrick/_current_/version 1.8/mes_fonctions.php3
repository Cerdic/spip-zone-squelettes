<?php

$GLOBALS[ 'dossier_squelettes' ] = "bones" ;

# titre homogene http://www.spip-contrib.net/article46.html
function titre_homogene($titre) {
  $titre = tronquer_titre($titre);
  return casse_titre($titre);
}

// tronque un titre � 60 caract�res, sans coupure de mot
function tronquer_titre($texte) {
  return couper_texte($texte, 60);
}

// coupe une cha�ne � $limite caract�res, sans coupure de mot
// (un mot est consid�r� comme un groupe de caract�res s�par� par des espaces)
function couper_texte($texte, $limite) {
  // la longueur du texte est <= $limite, on retourne le texte entier
  if (strlen($texte) <= $limite) return $texte;
  // on fait la coupure avant le 1e espace apr�s $limite caract�res
  $texte = nl2br($texte);
  $pos = strpos(substr($texte, $limite), " ");
  // s'il y a un espace apr�s $limite caract�res ou juste apr�s $limite caract�res
  // on retourne la partie de $texte jusqu'avant cet espace
  if (is_integer($pos) && $pos) return substr($texte, 0, $limite+$pos) . " (...)";
  // sinon (pas d'espace apr�s $limite caract�res ou juste apr�s $limite caract�res) on retourne le texte
  else return $texte;
}

// v�rifie la casse du titre afin de le mettre en minuscules
// s'il est tout en majuscules et de forcer la 1�re lettre en majuscule
function casse_titre($titre) {
  if (!ereg("([a-z|\.]+)", $titre)) $titre = strtolower($titre);
  // si le titre commence par un num�ro (1. ), 
  // il faut mettre le 1er car qui suit en majuscules
  if (ereg("^[0-9]+\. ", $titre)) {
    $pos = strpos($titre, " ");
    if (is_integer($pos) && $pos) 
      return substr($titre, 0, $pos) . " " . ucfirst(substr($titre, $pos+1));
    else return $titre;
  }
  else return ucfirst($titre);
}

function critere_portrait($idb, &$boucles, $param, $not) {
  $boucle = &$boucles[$idb];
  $table = $boucle->id_table;

  if ($not) 
	$boucle->where[] = $table.".hauteur <= ".$table.".largeur";
  else
	$boucle->where[] = $table.".hauteur > ".$table.".largeur";
}


function critere_paysage($idb, &$boucles, $param, $not) {
  $boucle = &$boucles[$idb];
  $table = $boucle->id_table;

  if ($not) 
	$boucle->where[] = $table.".largeur <= ".$table.".hauteur";
  else 
	$boucle->where[] = $table.".largeur > ".$table.".hauteur";
}

function critere_carre($idb, &$boucles, $param, $not) {
  $boucle = &$boucles[$idb];
  $table = $boucle->id_table;

  if ($not) 
	$boucle->where[] = $table.".largeur != ".$table.".hauteur";
  else
	$boucle->where[] = $table.".largeur = ".$table.".hauteur";
}

//trackback
    include_local("inc-trackback.php");

?>