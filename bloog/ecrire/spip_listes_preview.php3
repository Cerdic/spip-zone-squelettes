<?php

/******************************************************************************************/
/* SPIP-listes est un système de gestion de listes d'information par email pour SPIP      */
/* Copyright (C) 2004 Vincent CARON  v.caron<at>laposte.net , http://bloog.net            */
/*                                                                                        */
/* Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes */
/* de la Licence Publique Générale GNU publiée par la Free Software Foundation            */
/* (version 2).                                                                           */
/*                                                                                        */
/* Ce programme est distribué car potentiellement utile, mais SANS AUCUNE GARANTIE,       */
/* ni explicite ni implicite, y compris les garanties de commercialisation ou             */
/* d'adaptation dans un but spécifique. Reportez-vous à la Licence Publique Générale GNU  */
/* pour plus de détails.                                                                  */
/*                                                                                        */
/* Vous devez avoir reçu une copie de la Licence Publique Générale GNU                    */
/* en même temps que ce programme ; si ce n'est pas le cas, écrivez à la                  */
/* Free Software Foundation,                                                              */
/* Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, États-Unis.                   */
/******************************************************************************************/

include ("inc.php3");
include_ecrire ("inc_acces.php3");
include_ecrire ("inc_filtres.php3");
include_ecrire ("inc_config.php3");
include_ecrire ("inc_barre.php3");

include_ecrire ("inc_logos.php3");
include_ecrire ("inc_mots.php3");
include_ecrire ("inc_documents.php3");


init_config();
$nomsite=lire_meta("nom_site"); 
$urlsite=lire_meta("adresse_site"); 
 

// Admin SPIP-Listes
if ($connect_statut != "0minirezo" ) {
	echo "<p><b>"._T('spiplistes:acces_a_la_page')."</b></p>";
	fin_page();
	exit;
}


// Affichage d'un courrier ("brut" sans interface spip)
if (!$connect_statut == "0minirezo"){
	     echo "<b>"._T('avis_non_acces_message')._T('info_acces_refuse')."</b><p>";
	     exit;
}
 
$query_m = "SELECT * FROM spip_messages WHERE id_message=$id_message";
$result_m = spip_query($query_m);

while($row = spip_fetch_array($result_m)) {
    $texte = $row["texte"];
    $texte = eregi_replace("__bLg__[0-9@\.A-Z_-]+__bLg__","",$texte);
  	$texte = stripslashes($texte);
  	$temp_style = ereg("<style[^>]*>[^<]*</style>", $texte, $style_reg);
  	if (isset($style_reg[0])) $style_str = $style_reg[0]; 
                         else $style_str = "";
  	$texte = ereg_replace("<style[^>]*>[^<]*</style>", "__STYLE__", $texte);
    $texte = propre($texte); // pb: enleve aussi <style>...
    $texte = propre_bloog($texte);
    $texte = ereg_replace("__STYLE__", $style_str, $texte);
    echo "$texte";
}

?>
