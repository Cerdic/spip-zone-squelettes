<?php

//hack pour ne pas charger les fonctions generer_url_* de ecrire/inc_urls.php3
include("inc_version.php3");
define("_ECRIRE_INC_URLS", "1"); 
if(@file_exists("../inc-urls.php3"))
	include_local("../inc-urls.php3");
else
	include_local("../inc-urls-".$GLOBALS['type_urls'].".php3"); //pour generer_url_article|breve()
//FIN du hack
include("inc.php3");
include_ecrire("inc_trackback.php");


if(!empty($id_article)) {
	$type='article';
	$id = $id_article;
}
if(!empty($id_breve)) {
	$type='breve';
	$id = $id_breve;
}



debut_page(_L('titre_page_trackback_envoi'), "redacteurs");

echo "<br><br><br>";
gros_titre(_T('trackbacks:icone_envoi'));


debut_gauche();
debut_boite_info();

echo _L('laius sur les trackbacks');

if($_GET['id_article'])
	icone_horizontale(_T('icone_retour_article'), "articles.php3?id_article=$id_article", "article-24.gif", "rien.gif");
else {
	if($_GET['id_breve'])
		icone_horizontale(_T('icone_retour_breve'), "breves_voir.php3?id_breve=$id_breve", "breve-24.gif", "rien.gif");
}

if($_GET['id_article'])
icone_horizontale(_T('trackbacks:icone_suivi_cet_article'),
	"controle_forum.php3?mode=trackbacks&amp;id_article=".$_GET['id_article']."", "trackback-24.png", "");

icone_horizontale(_T('trackbacks:icone_suivi_general'),
	"controle_forum.php3?mode=trackbacks", "trackback-24.png", "");


fin_boite_info();
debut_droite();

if(!$id_article && !$id_breve) {
echo _L('il faut selectionner un article ou une breve');
fin_page();
exit;
}


$table = 'spip_'.table_objet($type);
$col_id = id_table_objet($type);

list($id_rubrique) = spip_fetch_array(spip_query("SELECT id_rubrique FROM $table WHERE $col_id='$id'"));
if(!($connect_statut=='0minirezo' AND acces_rubrique($id_rubrique))) { //secu
	echo "<H3>"._T('info_acces_interdit')."</H3>";
	fin_page();
	exit;
}

if($list_url) { //Si c'est un POST, je fais les POSTs
	if(strlen($excerpt)>255) $excerpt = couper($excerpt,244);
	$donnees = array(
		'url' => $url,
		'title' => $title,
		'blog_name' => $blog_name,
		'excerpt' => $excerpt,
		'charset' => $charset,
		'utf8' => $utf8
	);
	$resultats = array();
	$liste_urls = explode("\r", $list_url);
	$liste_urls = array_unique($liste_urls);
	foreach($liste_urls as $ping) {
		$resultats[$ping] = envoi_trackback(trim($ping), $donnees);
	}
}
else { //Sinon, je fais des GETs
	$donnees = prepare_trackback($type, $id);
	if(empty($donnees)) {
		echo _L('il faut selectionner un article ou une breve publie(e) et correctement date(e)');
		fin_page();
		exit;
	}
	$list_url = implode("\n", $donnees['liste_urls']);
	$excerpt = $donnees['excerpt'];
}

if ($type=='article') icone(_T('icone_retour'), "articles.php3?id_article=$id_article", "article-24.gif", "rien.gif");
else {
if($type='breve') icone(_T('icone_retour'), "breves_voir.php3?id_breve=$id_breve", "breve-24.gif", "rien.gif");
}

$action = 'envoi_trackback.php?'.$col_id.'='.$id;
echo "<FORM ACTION='$action' name='formulaire' METHOD='post'>";
echo _L('Liste des pings a faire')."<br /><TEXTAREA NAME='list_url' ROWS='15' CLASS='formo' COLS='40' wrap=soft>";

echo $list_url;

echo "</TEXTAREA><P>\n";

echo _L('Extrait a envoyer')."<br /><TEXTAREA NAME='excerpt' ROWS='15' CLASS='formo' COLS='40' wrap=soft>";

echo $excerpt;

echo "</TEXTAREA><P>\n";

foreach ($donnees as $name => $value) {
	if($name!='liste_urls' AND $name!='excerpt')
		echo "<input type='hidden' name='".$name."' value='".$value."' />";
}

echo "<INPUT CLASS='fondo' TYPE='submit' NAME='envoyer_trackback' VALUE='Envoyer'>";

echo "</FORM>";

//resultats
if(!empty($resultats)) {
	echo "<div>";
	echo _L('ici les resultats');
	echo "<ul>";
	foreach($resultats as $res => $ok) {
		echo "<li><small>".($ok[0]?"OK":"KO")." </small><tt>".$res."</tt> : ".$ok[1]."</li>";
	}
	echo "</ul>";
	echo "</div>";
}

//historique
//TODO
/*
$histo = array();
$query = "SELECT url, date FROM spip_histo_trackback WHERE etat='reussi' AND $col_id=$id";
$result = spip_query($query);
while($row = spip_fetch_array($result)) {
	$histo[] = $row;
}
if(!empty($histo)) {
	echo "<div>";
	echo _L('historique des pings');
	echo "<ul>";
	foreach($histo as $info) {
		echo "<li>[".date("d/m/Y @ H:i:s", $info['date'])."] <b>".$info['url']."</b></li>";
	}
	echo "</ul>";
	echo "</div>";
}
*/

fin_page();
fin_cadre_formulaire();

?>
