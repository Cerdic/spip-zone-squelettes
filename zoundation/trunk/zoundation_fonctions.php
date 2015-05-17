<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

// Balise spip pour lire les constantes PHP proprement
if (!function_exists('balise_LIRE_CONSTANTE_dist')) {
    function balise_LIRE_CONSTANTE_dist($p) {
        $constante = interprete_argument_balise(1,$p);

        $p->code = "constant($constante)";

        $p->interdire_scripts = false;

        return $p;
    }
}