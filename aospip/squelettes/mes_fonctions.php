<?php
function textarea($texte, $rows, $cols, $lang='') {
static $num_textarea = 0;

$texte = entites_html($texte);
return "<textarea name=\"texte\" rows=\"$rows\" class=\"forml\" cols=\"$cols\" id=\"textarea\">$texte</textarea>";
}
function proteger_adresse($chaine)
{
$ret_string="";
$len=strlen($chaine);
for($x=0;$x<$len;$x++)
{
$ord=ord(substr($chaine,$x,1));
$ret_string.="&#$ord;";
}
return $ret_string;
}
function typo_comments($chaine) {
$chaine = preg_replace(",\+\+(.*?)\+\+,","<ins>\\1</ins>",$chaine);
$chaine = preg_replace(",__(.*?)__,","<del>\\1</del>",$chaine);
$chaine = preg_replace(",&#8217;&#8217;(.*?)&#8217;&#8217;,s","<blockquote>\\1</blockquote>",$chaine);
$chaine = preg_replace(",@@(.*?)@@,s","<code>\\1</code>",$chaine);
$chaine = preg_replace(",&lt;&lt; (.*?) >>,s","<pre>\\1</pre>",$chaine);
return $chaine;
}
function nom_musique($url) {
$nom = explode("/", $url);
$nom = end($nom);
$nom = substr($nom, 0, -4);
$nom = pas_trop($nom, 25);
return $nom;
}
function nom_fichier($url) {
$nom = explode("/", $url);
$nom = end($nom);
$position = strpos($nom, ".");
$nom = substr($nom, 0, $position);
$nom = pas_trop($nom, 25);
return $nom;
}
function pas_trop($nom, $limite) {
if (strlen($nom) > $limite) {
$nom = substr($nom, 0, $limite);
$nom = $nom."...";
}
return $nom;
}
function vrai_id($id) {
$id = substr($id, 1);
return $id;
}
?>