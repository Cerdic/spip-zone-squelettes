<?php

#
# Ce fichier mes_fonctions.php3 peut être laissé dans le repertoire bones/ ;
# il s'appliquera alors a la place de celui qui est a la racine.
#
# N'oubliez pas d'indiquer dans 'ecrire/mes_options.php3' la ligne :
# $GLOBALS[ 'dossier_squelettes' ] = "bones" ;
#

# titre homogene http://www.spip-contrib.net/article46.html
function titre_homogene($titre) {
  $titre = tronquer_titre($titre);
  return casse_titre($titre);
}

// tronque un titre à 60 caractères, sans coupure de mot
function tronquer_titre($texte) {
  return couper_texte($texte, 60);
}

// coupe une chaîne à $limite caractères, sans coupure de mot
// (un mot est considéré comme un groupe de caractères séparé par des espaces)
function couper_texte($texte, $limite) {
  // la longueur du texte est <= $limite, on retourne le texte entier
  if (strlen($texte) <= $limite) return $texte;
  // on fait la coupure avant le 1e espace après $limite caractères
  $texte = nl2br($texte);
  $pos = strpos(substr($texte, $limite), " ");
  // s'il y a un espace après $limite caractères ou juste après $limite caractères
  // on retourne la partie de $texte jusqu'avant cet espace
  if (is_integer($pos) && $pos) return substr($texte, 0, $limite+$pos) . " (...)";
  // sinon (pas d'espace après $limite caractères ou juste après $limite caractères) on retourne le texte
  else return $texte;
}

// vérifie la casse du titre afin de le mettre en minuscules
// s'il est tout en majuscules et de forcer la 1ère lettre en majuscule
function casse_titre($titre) {
  if (!ereg("([a-z|\.]+)", $titre)) $titre = strtolower($titre);
  // si le titre commence par un numéro (1. ), 
  // il faut mettre le 1er car qui suit en majuscules
  if (ereg("^[0-9]+\. ", $titre)) {
    $pos = strpos($titre, " ");
    if (is_integer($pos) && $pos) 
      return substr($titre, 0, $pos) . " " . ucfirst(substr($titre, $pos+1));
    else return $titre;
  }
  else return ucfirst($titre);
}


?>