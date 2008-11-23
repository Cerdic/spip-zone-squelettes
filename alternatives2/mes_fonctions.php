<?php

// Balise pour afficher la version de SPIP en cours sur votre site
// Contrib de Scoty : http://www.koakidi.com/
// voir : http://www.spip-contrib.net/Collection-de-Balises
function balise_VERSION_SPIP_AFFICHEE($p) {
        $p->code = "'".$GLOBALS['spip_version_affichee']."'";
        $p->statut = 'php';
        return $p;
}



?>