<?php

include ("inc.php3");
include_ecrire ("inc_index.php3");
include_ecrire ("inc_logos.php3");
include_ecrire ("inc_trackback.php");

// Modifs forum
if ($controle_trackback AND $id_controle_trackback) {
	controler_statut_trackback($controle_trackback, $id_controle_trackback);
	if ($redirect)
		redirige_par_entete($redirect);
}

$query = "SELECT titre, id_rubrique FROM spip_articles WHERE id_article='$id_article'";
$result = spip_query($query);

while($row = spip_fetch_array($result)) {
	$titre = $row["titre"];
	$id_rubrique = $row["id_rubrique"];
}


debut_page($titre, "documents", "articles");



debut_grand_cadre();

afficher_hierarchie($id_rubrique);

fin_grand_cadre();



debut_gauche();


debut_boite_info();

echo "<FONT FACE='Verdana,Arial,Sans,sans-serif' SIZE=2>";
echo "<P align=left>"._T('info_gauche_suivi_trackback');

echo aide ("suiviforum");
echo "</FONT>";

fin_boite_info();


debut_droite();


echo "\n<table cellpadding=0 cellspacing=0 border=0 width='100%'>";
echo "<tr width='100%'>";
echo "<td>";
	icone(_T('icone_retour'), "articles.php3?id_article=$id_article", "article-24.gif", "rien.gif");

echo "</td>";
echo "<td>" . http_img_pack('rien.gif', " ", "width='10'") ."</td>\n";
echo "<td width='100%'>";
echo _T('texte_messages_publics');
gros_titre($titre);
echo "</td></tr></table>";
echo "<p>";

// Ne pas donner les cles du forum a des non-admins
if (! ($connect_statut=='0minirezo' AND acces_rubrique($id_rubrique)))
	return;

echo "<div class='serif2'>";

// reglages
if (!$debut) $debut = 0;
$pack = 5;		// nb de forums affiches par page
$enplus = 200;	// intervalle affiche autour du debut
$limitdeb = ($debut > $enplus) ? $debut-$enplus : 0;
$limitnb = $debut + $enplus - $limitdeb;

$query_trackback = "SELECT id_forum FROM spip_forum WHERE id_article='$id_article' AND id_parent=0 AND statut IN ('tbpublie', 'tboff', 'tbprop') LIMIT $limitdeb, $limitnb";
$result_trackback = spip_query($query_trackback);


$i = $limitdeb;
if ($i>0)
	echo "<A HREF='articles_trackback.php?id_article=$id_article&page=$page'>0</A> ... | ";
while ($row = spip_fetch_array($result_trackback)) {

	// barre de navigation
	if ($i == $pack*floor($i/$pack)) {
		if ($i == $debut)
			echo "<FONT SIZE=3><B>$i</B></FONT>";
		else
			echo "<A HREF='articles_trackback.php?id_article=$id_article&debut=$i&page=$page'>$i</A>";
		echo " | ";
	}

	// elements a controler

	$i ++;
}
echo "<A HREF='articles_trackback.php?id_article=$id_article&debut=$i&page=$page'>...</A>";

echo "</div>";


$mots_cles_forums = lire_meta("mots_cles_forums");

if ($connect_statut == "0minirezo") {
	$query_trackback = "SELECT pied.*, max(thread.date_heure) AS date
		FROM spip_forum AS pied, spip_forum AS thread
		WHERE pied.id_article='$id_article'
		AND pied.id_parent=0
		AND pied.statut IN ('tbpublie', 'tboff', 'tbprop')
		AND thread.id_thread=pied.id_forum
		GROUP BY id_thread
		ORDER BY date DESC LIMIT $debut, $pack";
	$result_trackback = spip_query($query_trackback);
	afficher_trackback($result_trackback, $forum_retour, $id_article);
}

echo "</FONT>";

fin_page();

?>
