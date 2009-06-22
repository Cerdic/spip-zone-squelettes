<?php
// fonctions sp�cifiques squelette median-web

  // retourne un array � partir d'une liste 
    function make_array($liste, $separ = ',') {
        return explode($separ, $liste);
    }
    
  // divise par
    function pourcentage($diviseur) {
        return floor(100 / $diviseur);
    }
    
  // calcule le restant n�cessaire pour arriver pile � 100% dans la barre de nav $pourcentage est le % arrondi utilis� par chaque item, $nb_elems est le nb d'items - 1
    function restant_pourcentage($pourcentage, $nb_elems) {
//echo '%: '.$pourcentage.' nb: '.$nb_elems.' res: '.(100 - ($pourcentage * $nb_elems));
        return (99 - ($pourcentage * $nb_elems));
    }
    
  // retourne le r�sultat arrondi sans virgule d'une division
    function divise_arrondi($a_diviser, $diviseur) {
        return floor($a_diviser / $diviseur);
    }

  // trie un array par ordre alphab�tique de ses �l�ments
    function trier_alphabetique($tab) {
        asort($tab);
        return $tab;
    }

  // faire un implode sur un array
    function imploser($tab, $sep) {
        echo '<br>tab= ';
        var_dump($tab);
        echo '<br>sep= '.$sep;
        if ($tab) return implode($sep, $tab);
    }
    
  // supprimer le # dans une cha�ne (cf couleurs our image_typo
    function suprime_diese($txt) {
        return str_replace('#', '', $txt);
    }
    
?>
