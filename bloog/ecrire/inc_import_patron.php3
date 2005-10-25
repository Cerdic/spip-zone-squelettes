<?php


if (!$mode) $mode = $_GET['mode'] ;
if (!$inclure_patron) $inclure_patron = $_POST['inclure_patron'] ; 

if (($inclure_patron == "oui") AND ($mode == "courrier")) {
	if (!$patron) $patron = $_POST['patron'] ;
	if (!$date) $date = $_POST['date'] ; 
	
	//echo $patron." ".$date ;
	
	echo " " ; // bug de fou
	
	chdir('..');
	ob_start();
	include('patron.php3');
	// on recupère le buffer
	$texte_patron = ob_get_contents();
	// on vide et ferme le buffer
	ob_end_clean();  
	
	$titre_patron = _T('spiplistes:lettre_info')." ".$nomsite;
	
	//chdir('./ecrire/');
	//echo getcwd() . "\n";
	
	$titre = addslashes($titre_patron);
	$texte = addslashes($texte_patron);
	
	if((strlen($texte) > 10)){
	spip_query("UPDATE spip_messages SET titre='$titre', texte='$texte' WHERE id_message='$id_message'");
	}else{
	$message_erreur = _T('spiplistes:patron_erreur');
	}
	
	echo "<div style='width:600px'>";
	echo "<div style='float:right;'>";
	echo "<FORM ACTION='spip_listes.php3?mode=courrier&id_message=$id_message' METHOD='post'>";
	echo "<P ALIGN='center'><br><br><a href='spip_listes.php3?mode=courrier_edit&id_message=$id_message'>"._T('spiplistes:retour_link')."</a></P>";
	echo "<P ALIGN='center'><br><br><INPUT TYPE='submit' NAME='Valider' VALUE='"._T('spiplistes:confirmer')."' CLASS='fondo'></P>";
	echo "</FORM>";
	echo "</div>";
	echo $texte_patron.$message_erreur;
	echo "</div>";
		 
	}	
?>