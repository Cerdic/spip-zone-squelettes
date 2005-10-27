<?php
/*
+-------------------------------------------+
| GAFoSPIP - popup de rédaction de message
+-------------------------------------------+
| Gestion Alternative des Forums SPIP
| v. 0.1 - 10/08/05
+-------------------------------------------+
| Hugues AROUX - SCOTY @ koakidi.com
+-------------------------------------------+
*/

include ("inc.php3");
include("gaf_inc.php");

?>
	<script language="JavaScript" type="text/javascript"> 
		function emoticon(text) { var txtarea =
		document.formulaire.texte; text = ' ' + text + ' '; if
		(txtarea.createTextRange && txtarea.caretPos) { var caretPos =
		txtarea.caretPos; caretPos.text =
		caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text +
		text + ' ' : caretPos.text + text; txtarea.focus(); } else {
		txtarea.value += text; txtarea.focus(); } } 
	</script>

	<script type="text/javascript">
		if (window.blur) window.focus();
	</script>
<?php


debut_html('redige_post : '.$forum);
		

if ($connect_statut != '0minirezo')
{
	echo _T('avis_non_acces_page');
	fin_page();
	exit;
}


if($valid_post)
	{
	// enregistrer le post (ah ouaih ?)
	enregistre_post_gaf();
		?> <script type="text/javascript"> self.close(); </script> <?php
	}
else
	// affiche formulaire
	{
	echo "<div style='padding:10px;'>";	
	debut_cadre_relief("");
	
	echo "<div style='float:right; padding:2px;'>\n";
	icone("Fermer", "javascript:window.close();", "rien.gif", "gaf_p_off.gif");
	echo "</div><br>\n";
	
	affiche_form_post();
	
	fin_cadre_relief();
	echo "</div>\n";
	}


//
echo "</body>\n</html>";
?>
