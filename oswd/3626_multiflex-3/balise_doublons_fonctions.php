<?php
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
function balise_SAVE_DOUBLONS($p) {
  $p->code = "vide(\$GLOBALS['recherche_doublons'] = \$doublons)";

  return $p; 
}


/* 
 * Restaure la globale dans la table des doublons.
 */
function balise_LOAD_DOUBLONS($p) {
  if(!isset($GLOBALS['recherche_doublons'])) $GLOBALS['recherche_doublons'] = array();
  $p->code = "vide(\$doublons = \$GLOBALS['recherche_doublons'])";

  return $p; 
}


/*
 * Genere un id unique pour le tableau de doublons
 */ 
function balise_HASH_DOUBLONS($p) {
  #$p->code = "md5(serialize(\$GLOBALS['recherche_doublons'])) . vide(spip_log('#GET_DOUBLONS : ' . serialize(\$GLOBALS['recherche_doublons']) , 'spip_doublons'))";
  $p->code = "md5(serialize(\$GLOBALS['recherche_doublons']))";

  return $p; 
}


/*
 * Genere un id unique pour un doublon
 */ 
function balise_DOUBLON_ALEA($p) {
  $p->code = "calculer_balise_DOUBLON_ALEA()";
  return $p; 
}

function calculer_balise_DOUBLON_ALEA(){
  return substr(rand().rand(),0,8);
}

?>
