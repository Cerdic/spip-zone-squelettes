<?php
function balise_VERSION_SPIP_AFFICHEE($p) {
        $p->code = "'".$GLOBALS['spip_version_affichee']."'";
        $p->statut = 'php';
        return $p;
}

?>