<?php
// fonctions spécifiques squelette median-web

  // retourne un array à partir d'une liste 
    function make_array($liste, $separ = ',') {
        return explode($separ, $liste);
    }
    
  // divise par
    function pourcentage($diviseur) {
        return floor(100 / $diviseur);
    }
    
  // calcule le restant nécessaire pour arriver pile à 100% dans la barre de nav $pourcentage est le % arrondi utilisé par chaque item, $nb_elems est le nb d'items - 1
    function restant_pourcentage($pourcentage, $nb_elems) {
//echo '%: '.$pourcentage.' nb: '.$nb_elems.' res: '.(100 - ($pourcentage * $nb_elems));
        return (99 - ($pourcentage * $nb_elems));
    }
    
  // retourne le résultat arrondi sans virgule d'une division
    function divise_arrondi($a_diviser, $diviseur) {
        return floor($a_diviser / $diviseur);
    }

  // trie un array par ordre alphabétique de ses éléments
    function trier_alphabetique($tab) {
        asort($tab);
        return $tab;
    }

  // faire un implode sur un array
    function imploser($tab, $sep) {
        if ($tab AND is_array($tab)) return implode($sep, $tab);
    }
    
  // supprimer le # dans une chaîne (cf couleurs our image_typo
    function suprime_diese($txt) {
        return str_replace('#', '', $txt);
    }
    
  // faire la redirection par en-tete vers url
    function redirige_page($url){
        include_spip('inc/headers');
        redirige_par_entete($url);
    }
    
/* balises pour doublons entre #inclure (idee _renato_)
 *  code de Matthieu Marcillaud (squelette multiflex3)
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
 *  [(#INCLURE{B}{_unique = #HASH_DOUBLONS})] // affiche la mÃªme chose car doublon aleatoire
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
	  $p->code = "md5(serialize(\$GLOBALS['recherche_doublons']))";

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
