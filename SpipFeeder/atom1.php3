<?php
$fond = "atom1";
$delais = 10 * 60;

// cette ligne empeche l'affichage des boutons d'administration  
$flag_preserver = true;  //inutile en 1.9 alpha depuis http://trac.rezo.net/trac/spip/changeset/476


// commentez cette ligne si vous preferez supprimer la production
// du texte complet (valable dans le fichier dist/backend.atom.html)
// $_GET['texte_complet'] = true;

include ("inc-public.php3");

?>
