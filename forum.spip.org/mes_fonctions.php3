<?php

// Ah et il manque un filtre pour appliquer cette loi :
# http://feedvalidator.org/docs/warning/ContainsRelRef.html

function liens_de_moderation($id_forum) {
	$a = '[<span style="font-size: 9px;"><a href="'.lire_meta('adresse_site').'/ecrire/controle_forum.php3?debut_id_forum=';
	$liens = "$a$id_forum\">moderer</a></span>]";
	return texte_backend($liens);
}

// Toute personne censee se detournerait de la rfc 822... et pourtant
function date_rfc822($date_heure) {
	list($annee, $mois, $jour) = recup_date($date_heure);
	list($heures, $minutes, $secondes) = recup_heure($date_heure);
	$time = mktime($heures, $minutes, $secondes, $mois, $jour, $annee);
	$timezone = sprintf('%+03d',intval(date('Z')/3600)).'00';
	return date("D, d M Y H:i:s", $time)." $timezone";
}

// renvoie une couleur fonction de l'age du forum
function dec2hex($v) {
	return substr('00'.dechex($v), -2);
}

function age_style($date) {

	// $decal en secondes
	$decal = date("U") - date("U", strtotime($date));

	// 3 jours = vieux
	$decal = min(1.0, sqrt($decal/(3*24*3600)));

	// Quand $decal = 0, c'est tout neuf : couleur vive
	// Quand $decal = 1, c'est vieux : bleu pale
	$red = ceil(128+127*(1-$decal));
	$blue = ceil(130+60*$decal);
	$green = ceil(200+55*(1-$decal));

	$couleur = dec2hex($red).dec2hex($green).dec2hex($blue);

	return 'background-color: #'.$couleur.';';
}

// corriger les URLs gmane (on syndique 'blog....' mais on ne veut pas lier la-dessus)
function gmane($url) {
	return $url;
	return str_replace('http://comments.gmane.', 'http://thread.gmane.', $url);
}

// pour les forums
function raccourcir_nom($nom) {
	if (strpos($nom, "@")) {
		$nom = substr($nom, 0, strpos($nom, "@"));	
	}
	return $nom;
}

// pour afficher proprement le nom des langues
function afficher_nom_langue ($lang) {
	if (ereg("^oc(_|$)", $lang))
		return "occitan";
	else
		return traduire_nom_langue($lang);
}

// pour rendre les dates insecables dans les pages forum
function insecable ($texte) {
	return ereg_replace("( |&nbsp;)+", "&nbsp;", $texte);
}

// supprimer les '> ' en début de titre de forum
function spip_preg_replace($a,$b,$c) {
	return preg_replace($b,$c,$a);
}

/************************************pour le tag cloud***********************************
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
  return 1+($nbr/$max*$nbrMax);
}

?>
