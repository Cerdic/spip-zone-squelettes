<?php
chdir('../ecrire');
include('inc_version.php3');
include('inc_texte.php3');

$t = "
<form id='formulaireCommentaire' action='forum.php3?id_article=".intval($id_article)."'>

<div id='preview'></div>

<table cellpadding=2 border=0>
<tr><td colspan='2'>
<textarea name='commentaire' rows='10' class='forml' cols='39' id='commentaire'>
</textarea>
</td></tr>
<tr>
<td align='right'>
<b><label for='titre'>"._T('forum_titre')."</label> </b></td> 
<td><input type='text' id='titre' name='titre' class='forml' size='70' value='".propre($titre)."'/></td>
</tr>
<td align='right'><label for='auteur'>"._T('forum_votre_nom')."</label></td>
    <td><input type='text' name='auteur' id='auteur' value='".propre($auteur)."' class='forml' size='40' />
</td>
</tr>
<tr><td align='right'><label for='email_auteur'>"._T('forum_votre_email')."</label></td>
<td>
    <input type='text' name='email_auteur' id='email_auteur' value='".propre($email_auteur)."' class='forml' size='40' />
</td>
</tr>
<tr><td colspan='2' align='right'>
<input type='submit' value='"._T('forum_voir_avant')."' class='spip_bouton' onclick='return !launchPreview();'/>
</td></tr>
</table>

<div type='hidden' name='retour_forum' value='!' />
<div type='hidden' name='forum_id_article' value='".intval($id_article)."' />
<div type='hidden' name='alea' value='".$alea."' />
<div type='hidden' name='hash' value='".$hash."' />
</form>
";

echo($GLOBALS["auteur_session"]["hash_env"]);

echo ($t);

?>
