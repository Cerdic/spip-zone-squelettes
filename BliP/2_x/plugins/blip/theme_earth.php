<?php

// Ce fichier defini les classes CSS en tant que variable php, pour permettre une  surcharge de la feuille de style

$css_blip["body|background"] = ${$css_blip_couleur}['couleur|2'].' url(plugins/blip/theme_earth_fond.gif) repeat-y';
$css_blip["#page|border|style"] = 'solid';
$css_blip["#page|width"] = '950px';
$css_blip["#page|border|width"] = '2px';
$css_blip["#page|border|color"] = ${$css_blip_couleur}['couleur|1'];
$css_blip["#page|background"] = '#ffffff';
$css_blip["#tete|background"] = 'url(plugins/blip/theme_earth_bandeau.jpg) no-repeat';
$css_blip['#tete|height'] = '100px';
$css_blip[".titre_principal|margin"] = '0';
$css_blip[".titre_principal|padding"] = '20px 20px';
$css_blip[".sous_titre|margin"] = '0';
$css_blip[".sous_titre|padding"] = '0 0 10px 20px';

$css_blip["#pied|background"] = '#ffffff';
$css_blip["#pied|height"] = '20px';
$css_blip["#pied|border|width"] = '0px';

?>
