<?php

// Ce fichier defini les classes CSS en tant que variable php, pour permettre une  surcharge de la feuille de style

$css_blip["body|background|color"] = ${$css_blip_couleur}['couleur|1|clair'];
$css_blip["#page|width"] = '900px';
$css_blip["#page|border|style"] = 'solid';
$css_blip["#page|border|width"] = '0 2px';
$css_blip["#page|border|color"] = ${$css_blip_couleur}['couleur|1'];
$css_blip["#page|background|color"] = ${$css_blip_couleur}['couleur|neutre'];
$css_blip[".titre_principal|width"] = '900px';
$css_blip[".titre_principal|margin"] = '0';
$css_blip[".titre_principal|padding"] = '0';
$css_blip[".sous_titre|width"] = '880px';
$css_blip[".sous_titre|margin"] = '0';
$css_blip[".sous_titre|padding"] = '10px 0 10px 20px';

?>
