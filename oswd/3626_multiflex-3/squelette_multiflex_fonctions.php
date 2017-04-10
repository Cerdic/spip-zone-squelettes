<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

/*
 * #K_RVB{240,240,240,1,1,0.7}
 * renvoie : rvb{240,240,237}
 * Applique un coefficient 
 * sur une couleur rvb
 * 
 */ 
function balise_KRVB($p){
	$r = interprete_argument_balise(1, $p);
	$v = interprete_argument_balise(2, $p);
	$b = interprete_argument_balise(3, $p);
	$kr = interprete_argument_balise(4, $p);
	$kv = interprete_argument_balise(5, $p);
	$kb = interprete_argument_balise(6, $p);
	
	$p->code = "calculer_balise_KRVB($r, $v, $b, $kr, $kv, $kb)";
	return $p;
}

function calculer_balise_KRVB($r,$v,$b,$kr,$kv,$kb){
	include_spip('inc/filtres_images');
	
	if ($r == 255 && $v == 255 && $b == 255) return '#ffffff';
	if ($r == 0 && $v == 0 && $b == 0) return '#000000';
	
	if ($kr >  1) $kr =  1;
	if ($kr < -1) $kr = -1;
	if ($kv >  1) $kv =  1;
	if ($kv < -1) $kv = -1;
	if ($kb >  1) $kb =  1;
	if ($kb < -1) $kb = -1;
			
	$r = ($kr>=0) ? $r + $kr * (255-$r) : $r + $kr * $r;
	$v = ($kv>=0) ? $v + $kv * (255-$v) : $v + $kv * $v;
	$b = ($kv>=0) ? $b + $kb * (255-$b) : $b + $kb * $b;
	
	if ($r>255) $r=255;
	if ($v>255) $v=255;
	if ($b>255) $b=255;
	
	if ($r<0) $r=0;
	if ($v<0) $v=0;
	if ($b<0) $b=0;
	
	
	return '#'.couleur_dec_to_hex(round($r), round($v), round($b));
}



//https://contrib.spip.net/balise-TITRE-PARENT
include_spip('public/balises');

// Le filtre [(#ID_RUBRIQUE|titre_parent)]
if (!function_exists('calcul_titre_parent')){
	function calcul_titre_parent($id_rubrique) {
		if(!($id_rubrique = intval($id_rubrique))) return '';
		return sql_getfetsel('titre','spip_rubriques','id_rubrique='.$id_rubrique);
	}
}

// La balise
if (!function_exists('balise_TITRE_PARENT_dist')){
	function balise_TITRE_PARENT_dist($p) {
		$id_rubrique = champ_sql('id_rubrique', $p);
		$p->code = "calcul_titre_parent(".$id_rubrique.")";
		return $p;
	}
}

// Positionner les filtres standards en recopiant ceux de #TITRE
// attention, ca ne positionne pas la langue_typo (mais tant pis)
include_spip('public/interfaces');
global $table_des_traitements;
if (!isset($table_des_traitements['TITRE_PARENT'])) {
	$table_des_traitements['TITRE_PARENT'] = $table_des_traitements['TITRE'];
}




/* balises pour doublons entre #inclure (idee _renato_) */

/*
 *
 *  Gestion des doublons entre #inclure
 * 
 *  B.html , C.html :
 *  --------------
 *  #LOAD_DOUBLONS
 *  <BOUCLE />
 *  #SAVE DOUBLONS
 * 
 * 
 *  A.html :
 *  --------------
 *  [(#INCLURE{B}{_unique = #HASH_DOUBLONS})]
 *  [(#INCLURE{B}{_unique = #HASH_DOUBLONS})]
 *  [(#INCLURE{C}{_unique = #HASH_DOUBLONS})]
 * 
 * 
 * 
 *  Un peu plus complexe (plusieurs valeurs de doublons)
 * 
 *  B.html, C.html :
 *  ----------------
 *  [(#SET{doublons, [(#ENV{_doublons}|sinon{#DOUBLON_ALEA})]})]
 *  #LOAD_DOUBLONS
 *  <BOUCLE(){doublons = #GET{doublons}} />
 *  #SAVE DOUBLONS 
 * 
 *  A.html :
 *  ----------------
 *  [(#INCLURE{B}{_unique = #HASH_DOUBLONS})]
 *  [(#INCLURE{B}{_unique = #HASH_DOUBLONS})] // affiche la même chose car doublon aleatoire
 * 
 *  [(#INCLURE{B}{_unique = #HASH_DOUBLONS}{_doublons = toto})]
 *  [(#INCLURE{B}{_unique = #HASH_DOUBLONS}{_doublons = toto})] // suite
 *  [(#INCLURE{B}{_unique = #HASH_DOUBLONS}{_doublons = plouf})] 
 * 
 *  [(#INCLURE{C}{_unique = #HASH_DOUBLONS}{_doublons = plouf})]  // suite de plouf
 * 
 */


/* 
 * Sauvegarde la table des doublons dans une globale.
 */
if (!function_exists('balise_SAVE_DOUBLONS')){
	function balise_SAVE_DOUBLONS($p) {
	  $p->code = "vide(\$GLOBALS['recherche_doublons'] = \$doublons)";

	  return $p; 
	}
}

/* 
 * Restaure la globale dans la table des doublons.
 */
if (!function_exists('balise_LOAD_DOUBLONS')){
	function balise_LOAD_DOUBLONS($p) {
	  if(!isset($GLOBALS['recherche_doublons'])) $GLOBALS['recherche_doublons'] = array();
	  $p->code = "vide(\$doublons = \$GLOBALS['recherche_doublons'])";

	  return $p; 
	}
}


/*
 * Genere un id unique pour le tableau de doublons
 */ 
if (!function_exists('balise_HASH_DOUBLONS')){
	function balise_HASH_DOUBLONS($p) {
	  #$p->code = "md5(serialize(\$GLOBALS['recherche_doublons'])) . vide(spip_log('#GET_DOUBLONS : ' . serialize(\$GLOBALS['recherche_doublons']) , 'spip_doublons'))";
	  $p->code = "md5(serialize(isset(\$GLOBALS['recherche_doublons']) ? \$GLOBALS['recherche_doublons'] : array()))";

	  return $p; 
	}
}


/*
 * Genere un id unique pour un doublon
 */ 
if (!function_exists('balise_DOUBLON_ALEA')){
	function balise_DOUBLON_ALEA($p) {
	  $p->code = "calculer_balise_DOUBLON_ALEA()";
	  return $p; 
	}
}
if (!function_exists('calculer_balise_DOUBLON_ALEA')){
	function calculer_balise_DOUBLON_ALEA(){
	  return substr(rand().rand(),0,8);
	}
}

?>
