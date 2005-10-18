<?php

include("inc.php3");
include_ecrire("inc_trackback.php");
include("../inc-calcul-outils.php3"); //pour calcul_introduction()

debut_page(_T('titre_page_forum_envoi'), "redacteurs");
debut_gauche();
debut_boite_info();

echo _L('laius sur les trackbacks');

fin_boite_info();
debut_droite();

if(!$id_article) {
	echo _L('il faut selectionner un article');
	fin_page();
	exit;
}

	$query = "SELECT * FROM spip_articles WHERE id_article=$id_article";
	$result = spip_query($query);
	if ($row = spip_fetch_array($result)) {
		$id_article = $row['id_article'];
		$statut = $row['statut'];
		$titre = $row['titre'];
		$texte = $row['texte'];
		$descriptif = $row['descriptif'];
		$chapo = $row['chapo'];
		$ps = $row['ps'];
		$introduction = calcul_introduction('articles', $texte, $chapo, $descriptif);
		$excerpt = strlen($introduction)>255 ? couper($introduction, 252).'...' : $introduction;
	}

if($list_url) {
	$resultats = array();
	$list_url = explode("\r", $list_url);
	$list_url = array_unique($list_url);
	foreach($list_url as $url) {
		$resultats[$url] = postTbPingURL($id_article, $url, lire_meta('nom_site'), $excerpt);
	}
}


		$uriArray = recuperer_liens_a_pinguer($descriptif."\n".$chapo."\n".$texte."\n".$ps);
		$res = array();
		
		for ($i=0;$i<count($uriArray);$i++)
		{
			if (($tburi = auto_decouverte_trackback_rdf($uriArray[$i])) !== false)
			{
				$res[] = $tburi;
			}
		}
		
echo "<FORM ACTION='trackback_envoi.php?id_article=$id_article' name='formulaire' METHOD='post'>";
echo _L('Liste des pings a faire')."<br /><TEXTAREA NAME='list_url' ROWS='15' CLASS='formo' COLS='40' wrap=soft>";

echo implode("\n", $res);

echo "</TEXTAREA><P>\n";

echo _L('extrait a envoyer')."<br /><TEXTAREA NAME='content' ROWS='15' CLASS='formo' COLS='40' wrap=soft>";

echo $excerpt;

echo "</TEXTAREA><P>\n";

echo "<INPUT CLASS='fondo' TYPE='submit' NAME='envoyer_trackback' VALUE='Envoyer'>";

echo "</FORM>";

//resultats
if($resultats) {
	echo "<div>";
	echo _L('ici les resultats');
	foreach($resultats as $res => $ok) {
		echo "<br />".$res.":".($ok?"OK":"KO");
	}
	echo "</div>";
}

fin_page();
fin_cadre_formulaire();

?>
