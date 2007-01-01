<?php

include ("ecrire/inc_version.php");
include_ecrire("inc_presentation");
include_ecrire("inc_minipres");
include_ecrire("inc_filtres");
include_ecrire("inc_layer");
include_ecrire("inc_texte");
include_ecrire("inc_connect");

install_debut_html("Suivi des traductions", "documents", "articles");

echo "<P align=left>";
echo "Cette page pr&eacute;sente le bilan des traductions de ce site. Les articles de r&eacute;f&eacute;rence
	sont affich&eacute;s en gras. La couleur de l'article correspond &agrave; son statut. La couleur
	<span style='background-color: purple; color:white;'>violette</span> signale les articles publi&eacute;s qui sont
	&agrave; v&eacute;rifier, l'original ayant une date de modification plus r&eacute;cente qu'eux.";
echo "</p>\n";
	

function icone_statut($statut_article, $source='puces') {
	static $couleurs = array(
		'publie'=>'green',
		'prepa'=>'grey',
		'prop'=>'orange',
		'refuse'=>'red',
		'poubelle'=>'black');
	static $puces = array(
		'publie'=>'verte',
		'prepa'=>'blanche',
		'prop'=>'orange',
		'refuse'=>'rouge',
		'poubelle'=>'poubelle');

	return ${$source}[$statut_article];
}

function rub($lang) {
	if ($lang == 'fr')
		return 91;  // cas particulier du francaoui qui

	$s = spip_query("SELECT id_secteur
		FROM spip_rubriques WHERE id_parent=0 AND
		lang = '$lang' AND id_secteur<>4");

	$t = spip_fetch_array($s);

	return $t['id_secteur'];		
}

echo "<table border='0' style='font-family: Verdana,Arial,Helvetica,sans-serif; font-size:10px;'><tr><td></td>\n";

$langues = explode(',', lire_meta('langues_utilisees'));

foreach ($langues as $langue) {
	$rub[$langue] = rub($langue);
	echo "<td bgcolor='orange'><i>". substr($langue." * ",0,3) ."</i></td>";
}

$limito = ($afficher_non_traduits == 'oui') ? "WHERE id_trad = 0" : "WHERE id_trad > 0";

$s = spip_query("SELECT * FROM spip_articles $limito AND statut<>'poubelle' ORDER BY id_trad DESC,id_article<>id_trad,lang");

while ($a = spip_fetch_array($s)) {

	if (($a['id_trad'] <> $id_trad) OR ($a['id_trad']==0)) {
		if ($visible) $affiche[$num][] = $tt.@join('', $tdd);

		$num=0;
		$tt = "</tr>\n<tr><td>\n";
		if ($no_url)
			$tt .= substr(supprimer_numero($a['titre']),0,14);
		else
			$tt .= substr(supprimer_numero($a['titre']),0,25);
		$id_trad = $a['id_trad'];

		$date_modif = $a['date_modif'];

		if (!$id = $id_trad) $id=$a['id_article'];

		foreach ($langues as $langue) {
			$url_creer = "ecrire/?exec=articles_edit&new=oui&lier_trad=$id&id_rubrique=".$rub[$langue];
			$tdd[$langue] = "<td><a href='$url_creer' title='$langue'>+</a></td>";
			if ($no_url) $tdd[$langue] = "<td>+</td>";
		}
		$tdd[''] = "<td></td>\n";

		$visible = false;
	}

	if ($a['statut'] == 'publie') $visible = true;

	$titre = entites_html(supprimer_numero($a['titre']));
	$couleur = icone_statut($a['statut'],'couleurs');
	$num ++;

	if (($a['date_modif'] < $date_modif) AND ($a['statut']='publie')) $couleur = 'purple';

	$url = 'ecrire/?exec=articles&id_article='.$a['id_article'];
	$td = "<td bgcolor='$couleur'>";
	$td .= "<a href='$url' title=\"$titre\">";
	$td .= "<font color='white'>";

	$la_langue = substr($a['lang']." * ",0,3);
	if ($a['id_trad'] == $a['id_article']) $la_langue = "<b>$la_langue</b>";
	$td .= $la_langue;

	$td .= "</font></a></td>\n";

	if ($no_url) $td="<td>$la_langue</td>";

	$tdd[$a['lang']] = $td;
}

if ($visible) $affiche[$num][] = $tt.@join('', $tdd);

$keys = array_keys($affiche);
rsort($keys);
foreach ($keys as $nombre) {
	echo join ('', $affiche[$nombre]);
}

echo "</tr></table>";

if ($afficher_non_traduits == 'oui')
	echo "<br /><a href='trad.php3'><font face='arial,helvetica,sans-serif' size='2' color='black'><u>Afficher les articles traduits</u></font></a>\n";
else
	echo "<br /><a href='trad.php3?afficher_non_traduits=oui'><font face='arial,helvetica,sans-serif' size='2' color='black'><u>Afficher les articles non traduits</u></font></a>\n";

install_fin_html();

?>

