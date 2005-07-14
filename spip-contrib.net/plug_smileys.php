<?php


function liste_smileys() {
  
  /*Listes des images � associer aux smileys*/

  $les_smileys = array();
  $les_smileys[':-)*'] = 'face13.png';
  $les_smileys[':-)'] = 'face1.png'; 
  $les_smileys['o:)'] = 'face18.png'; 
  $les_smileys['O:)'] = 'face18.png'; 
  $les_smileys['0:)'] = 'face18.png'; 
  $les_smileys[':)'] = 'face1.png'; 
  $les_smileys['%-)'] = 'face2.png'; 
  $les_smileys[';-)'] = 'face3.png'; 
  $les_smileys[';)'] = 'face3.png'; 
  $les_smileys[':-('] = 'face4.png'; 
  $les_smileys[':('] = 'face4.png'; 
  $les_smileys[':-O'] = 'face5.png';
  $les_smileys[':O)'] = 'face7.png'; 
  $les_smileys[':O'] = 'face5.png';
  $les_smileys[':-D'] = 'face6.png'; 
  $les_smileys[':D'] = 'face6.png'; 
  $les_smileys[':o)'] = 'face7.png'; 
  $les_smileys[':0)'] = 'face7.png'; 
  $les_smileys[':0'] =  'face5.png';
  $les_smileys[':-|'] = 'face8.png'; 
  $les_smileys[':|'] = 'face8.png'; 
  $les_smileys[':-/'] = 'face9.png'; 
  $les_smileys[':/'] = 'face9.png'; 
  $les_smileys[':-p'] = 'face10.png'; 
  $les_smileys[':p'] = 'face10.png'; 
  $les_smileys[':\'-('] = 'face11.png'; 
  $les_smileys[':\'('] = 'face11.png'; 
  $les_smileys[':-...'] = 'face12.png'; 
  $les_smileys[':...'] = 'face12.png'; 
  $les_smileys[':-..'] = 'face12.png'; 
  $les_smileys[':..'] = 'face12.png'; 
  $les_smileys[':-.'] = 'face12.png'; 
  $les_smileys[':.'] = 'face12.png'; 
  $les_smileys[':-x'] = 'face14.png'; 
  $les_smileys[':x'] = 'face14.png'; 
  $les_smileys['B-)'] = 'face15.png'; 
  $les_smileys['B)'] = 'face15.png'; 
  $les_smileys[':-@'] = 'face16.png'; 
  $les_smileys[':@'] = 'face16.png'; 
  $les_smileys[':$'] = 'face17.png'; 
  $les_smileys[':-*'] = 'face19.png'; 
  $les_smileys[':*'] = 'face19.png'; 
  $les_smileys[':-!'] = 'face20.png'; 
  $les_smileys[':!'] = 'face20.png'; 
  $les_smileys['8-)'] = 'face21.png'; 
  $les_smileys['8)'] = 'face21.png'; 
  $les_smileys['MONK'] = 'face22.png'; 	 
  $les_smileys['|-)'] = 'face23.png'; 
  $les_smileys['|)'] = 'face23.png'; 
  $les_smileys['O-)'] = 'face24.png'; 
  $les_smileys['O)'] = 'face24.png'; 
  $les_smileys['ATTN'] = 'important.png'; 
  $les_smileys['SVNT'] = 'puce.png';  

  return $les_smileys;
}

// Filtre SMILEYS - 19 Dec. 2004
//
// pour toute suggestion, remarque, proposition d'ajout d'un
// smileys, etc ; reportez vous au forum de l'article :
// http://www.uzine.net/spip_contrib/article.php3?id_article=38

function smileys($chaine) {
  global $flag_ecrire;

  // On peut mettre les smileys-images o� l'on veut. Mais il faut
  // penser � modifier la variable $chemin de la fonction en cons�quence.

  if($flag_ecrire)
	//chemin vers les images depuis le repertoire ecrire
	$chemin = "../smileys/";
  else
	//chemin vers les images depuis la racine du site SPIP.
	$chemin = "smileys/";
  
  foreach(liste_smileys() as $smiley => $file) {
	$alt = _T($smiley);
	if(!$alt) {
	  $alt = htmlentities($smiley);
	}
	$smiley = preg_quote($smiley,'/');
	$chaine = preg_replace('/(^'.$smiley.'\s|\s'.$smiley.'\s|\s'.$smiley.'$)/', "<img src=\"".$chemin.$file.'" alt="'.$alt.'" class="smiley"/>', $chaine);
  }
  return $chaine;
}

//completer_fonction('propre','smileys','');

function balise_SMILEY_DISPO($p) {

  // On peut mettre les smileys-images o� l'on veut. Mais il faut
  // penser � modifier la variable $chemin de la fonction en cons�quence.
  //chemin vers les images depuis la racine du site SPIP.
  $chemin = "smileys/";

  $p->code = '"<ul class=\"listes_smileys\">';
  foreach(liste_smileys() as $smiley => $file) {
	$alt = _T($smiley);
	if(!$alt) {
	  $alt = htmlentities(texte_script($smiley),ENT_QUOTES);
	}
	$p->code .= "<li class=\\\"un_smiley\\\"><span class=\\\"smiley_nom\\\">$smiley</span><img  class=\\\"smiley_image\\\" src=\\\"$chemin/$file\\\"  alt=\\\"$alt\\\"/><span class=\\\"smiley_alt\\\">$alt</span></li>\n";
  }
  $p->code .= '</ul>"';
  $p->type = 'html';
  
  return $p;
}

?>
