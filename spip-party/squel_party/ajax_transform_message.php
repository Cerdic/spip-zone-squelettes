<?php
chdir('../ecrire');

include("inc_version.php3");
include("inc_texte.php3");
include("inc_filtres.php3");
include("inc_lang.php3");

echo('<div class="item" style="border:1px solid #999; padding:5px; margin-bottom:10px;">');
if ($auteur) {
	echo(' <a href="mailto:' . propre($email_auteur) . '">');
	echo(propre($auteur) . "</a>, ");
}
	echo(_T('le') . ' ' . affdate(date("Y-m-j")));
echo('<div class="itemtext"><p>');
echo propre($commentaire);
echo('</p></div>');
echo('<div style="text-align:right"><input name="confirmer_forum" type="submit" value="' . _T('forum_message_definitif') . '"></div></div>');

?>
