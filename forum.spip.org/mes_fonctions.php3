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

function echaper_mot($titre, $type, $groupe_defaut) {
  	$groupe = '';
	if($groupe_defaut && $type != $groupe_defaut) {
	  $groupe = $groupe_defaut;
	  if(strpos($groupe,' ') || strpos($groupe,':')) {
		$groupe = "\"$groupe\"";
	  }
	}
	if(strpos($titre,' ') || strpos($titre,':')) {
	  $titre = "\"$titre\"";
	}
	return $groupe. (($groupe) ? ':' : '') .$titre;
}

function ajouter_mot($id_mot, $seul=false, $retour='') {
#  $url = $GLOBALS["clean_link"]->getUrl();
	$url = new Link($retour);


	list($titre,$type) = spip_fetch_array(spip_query("SELECT titre,type
		FROM spip_mots WHERE id_mot=$id_mot"));
	$groupe_defaut = 'FAQ';

	$tags = ((!$seul) ? $_GET['tags']." " : '').echaper_mot($titre, $type, $groupe_defaut);
	$url->addvar('tags', $tags);

	return quote_amp($url->geturl());
}

function retirer_mot($id_mot) {
## old style (id_mot[]=1)
#  $url = $GLOBALS["clean_link"]->getUrl();
#  $url = preg_replace("/([?&])id_mot\[\]=$id_mot&?/",'\\1',$url);
#  $url = preg_replace('/[?&]$/', '', $url);

## new style
  $url = new Link();
  list($titre,$type) = spip_fetch_array(spip_query("SELECT titre,type
	FROM spip_mots WHERE id_mot=$id_mot"));
  $groupe_defaut = 'FAQ';
  $tags = trim(preg_replace('/ '.preg_quote(echaper_mot($titre, $type, $groupe_defaut)).' /', ' ', ' '.$_GET['tags'].' '));
  $url->delvar('tags');
  if ($tags)
  	$url->addvar('tags', $tags);

  return quote_amp($url->geturl());
}

function critere_mots($idb, &$boucles, $param){
	$boucle = &$boucles[$idb];
	$id_table = $boucle->id_table;
	$type = $boucle->id_table;
	$primary = $boucle->primary;

	$id_mot = calculer_argument_precedent($idb, 'id_mot', $boucles);
	if($type == "mots") {
	  $boucle->where[] = 'id_mot IN (".((count('.$id_mot.') > 0)?addslashes(join(",",'.$id_mot.')):0).")';
	} else {
	  $boucle->group = $primary;
	  $boucle->from[] = "spip_mots_$type";
	  $boucle->where[] = '(id_mot = ".((count('.$id_mot.') > 0)?addslashes(join(\' OR id_mot = \','.$id_mot.')):0).")';
	  $boucle->where[] = "$id_table.$primary = spip_mots_$type.$primary";
	  $boucle->having = "'.(count($id_mot)-1).'";
	}
}

// {tags #ENV{tags}} retourne la liste des id_mot correspondant
// Attention le choix fait ici est incoherent : quand il y a plusieurs tags
// dans l'URL la boucle (MOTS) recoit {id_mot IN (....,....)}  [OU logique]
// alors que la boucle (FORUMS) recoit un {id_mot IN ...} HAVING COUNT()... [ET logique]
function critere_tags($idb, &$boucles, $crit){
	$boucle = &$boucles[$idb];
	$id_table = $boucle->id_table;
	$type = $boucle->id_table;
	$primary = $boucle->primary;

	$_mots = calculer_liste($crit->param[0], array(), $boucles, $boucles[$idb]->id_parent);
	if($type == "mots") {
	  $boucle->where[] = 'id_mot IN (".((count($array_mots = get_tags_ids('.$_mots.')) > 0)?addslashes(join(",",$array_mots)):0).")';
	} else {
	  $boucle->group = $primary;
	  $boucle->from[] = "spip_mots_$type";
	  $boucle->where[] = 'id_mot IN (".((count($array_mots = get_tags_ids('.$_mots.')) > 0)?addslashes(join(",",$array_mots)):0).")';
	  $boucle->where[] = "$id_table.$primary = spip_mots_$type.$primary";
# desactiver HAVING pour restaurer coherence (mais alors pas de tri croise !)
	  $boucle->having = "'.(count(\$array_mots)-1).'";
	}
}

// prend une liste de tags et retourne les id_mot reconnus (sans en creer)
function get_tags_ids($mots) {
	// Aller chercher les tags dans la boite
	### pour faire plus generique : se baser sur id_$objet et/ou url_propre
	include_ecrire('_libs_/tag-machine/inc_tag-machine.php');
	$mots = parser_liste(filtrer_entites($mots)); # car " dans l'url arrive ici sous la forme &quot; (#ENV{tags} et non #ENV*{tags})

	$id_mot = array();
	foreach ($mots as $mot) if (strlen($mot['tag'])) {
		$s = spip_query("SELECT id_mot FROM spip_mots
			WHERE titre='".addslashes($mot['tag'])."'"); # + groupe ? url_propre ? id_objet ?
		list($id) = spip_fetch_array($s);
		if ($id) $id_mot[] = $id;
	}

	return $id_mot;
}

/*
est ce que ce mot est dans cette liste
*/
function dansvariable($needle, $haystack) {
	return preg_match(", ".preg_quote($needle)." ,i"," $haystack ");
}

/*
génére une regexp OU pour la liste de mot
*/
function enregexp($liste) {
    include_ecrire('_libs_/tag-machine/inc_tag-machine.php');
	$mots = parser_liste(filtrer_entites($liste));
 $str = '^(';
 foreach ($mots as $mot) {
	 $str .= $mot['tag'].'|';
}
$str = substr($str,0,-1);
return $str.')$';
}

/*
combien il y a de mots dans le paramétre
*/
function compte_having($liste) {
    include_ecrire('_libs_/tag-machine/inc_tag-machine.php');
	$mots = parser_liste(filtrer_entites($liste));
 return count($mots)-1;
}

/*
un critére pour le HAVING sql
*/
function critere_having($idb, &$boucles, $crit){	
	$hav = calculer_liste($crit->param[0], array(), $boucles, $boucles[$idb]->id_parent);
 $boucles[$idb]->having = "'.$hav.'";
}

/*
un filtre pour émuler doublons... on peut empiler des ids (ou autre)
generer la variable pour faire un == 
*/
function tampons($valeur, $nom, $type, $action){
  static $tampons = array();
  if ($action == 'empile') {
	$tampons["$type:$nom"][] = $valeur;
	return ' ';
  } else if ($action == 'generein'){
	return '^('.join('|',$tampons["$type:$nom"]).')$';
  } else if ($action == 'existe' && count($tampons["$type:$nom"])) {
	return in_array($valeur,$tampons["$type:$nom"]);
  }
  return '';
}


?>
