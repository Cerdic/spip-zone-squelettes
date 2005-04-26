<?php
$fond = "benSousLeFeu";
$delais = 3600*24;

include ("inc-public.php3");
include("ecrire/inc_connect.php3");
  $id_mot=30;
	$sql= "SELECT article.titre,article.descriptif,article.id_article FROM spip_articles AS article, spip_mots_articles AS lien, spip_mots as mot ";
  $sql.=" WHERE lien.id_mot=$id_mot ";
  $sql.="       and lien.id_mot=mot.id_mot"; 
  $sql.="       and lien.id_article=article.id_article ";
  $sql.="       and   article.statut='prop'";
		$result = spip_query($sql);
echo "<ul>";
		while ($row = spip_fetch_array($result)) {
			echo "<li><a href='http://www.spip-contrib.net/ecrire/articles.php3?id_article=".$row['id_article']."'>".$row['titre']."</a></li>";
		}
echo "</ul>";

?>
