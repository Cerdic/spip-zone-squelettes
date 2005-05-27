<?php
/******************************************************************************************/
/* La bloOgletter est un syst�me de gestion de listes d'information par email pour SPIP   */
/* Copyright (C) 2004 Vincent CARON  v.caron<at>laposte.net , http://bloog.net            */
/*                                                                                        */
/* Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes */
/* de la Licence Publique G�n�rale GNU publi�e par la Free Software Foundation            */
/* (version 2).                                                                           */
/*                                                                                        */
/* Ce programme est distribu� car potentiellement utile, mais SANS AUCUNE GARANTIE,       */
/* ni explicite ni implicite, y compris les garanties de commercialisation ou             */
/* d'adaptation dans un but sp�cifique. Reportez-vous � la Licence Publique G�n�rale GNU  */
/* pour plus de d�tails.                                                                  */
/*                                                                                        */
/* Vous devez avoir re�u une copie de la Licence Publique G�n�rale GNU                    */
/* en m�me temps que ce programme ; si ce n'est pas le cas, �crivez � la                  */
/* Free Software Foundation,                                                              */
/* Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, �tats-Unis.                   */
/******************************************************************************************/



include_ecrire('inc_filtres.php3');

// ---------------------------------------------------------------------------------------------
// Taches de fond

//
// Envoi du mail quoi de neuf
//
$jours_neuf = lire_meta('jours_neuf');
$urlsite=lire_meta("adresse_site");
$nomsite=lire_meta("nom_site");

$time = time();

$majnouv = get_extra(1,"auteur");

if(!$majnouv["majnouv"]){
$majnouv["majnouv"] = time();
set_extra(1,$majnouv,"auteur");
}

$last_maj = $majnouv["majnouv"];


$temps = $time - $last_maj;
$top = 3600 * 24 * $jours_neuf ;

if ( (lire_meta('quoi_de_neuf') == 'oui')  AND ($jours_neuf > 0) AND ( $temps > $top) ) {
	
	$id_au = 1 ;
	$ext = get_extra($id_au, "auteur");
	$maj = $ext["majnouv"];
	$date_dernier = date('Y/m/d',$maj) ;
	$ext["majnouv"]= $time;
	set_extra($id_au,$ext,"auteur");

		// preparation mail


      $url_patron_bg = $urlsite."/patron.php3?patron=nouveautes&date=".$date_dernier ;
      //echo $url_patron_bg ;
	  $titre_patron_bg = "Lettre d'information du site ".$nomsite;
      $tableau_bg = file($url_patron_bg); // lecture de la page
      $total = count($tableau_bg);
      for ($i = 0 ; $i<$total  ; $i++) {$texte_patron_bg .= $tableau_bg[$i];}
	  
	  $titre_bg = addslashes($titre_patron_bg);
	  // echo  $texte_patron_bg ;       
         // ne pas envoyer  des textes de moins de 10 caract�res
  if ( (strlen($texte_patron_bg) > 10) ) {

	
	// si un mail a pu etre g�n�r�, on l'ajoute � la pile d'envoi
	
	$type = 'auto';
	$statut = 'encour';
	
	
    include_ecrire('inc_connect.php3');  // connexion
    $titre = addslashes($titre_patron_bg);
	$texte = addslashes($texte_patron_bg);
	
	if ($db_ok == 1){
	
	$query = "INSERT INTO spip_messages (titre, texte, date_heure, statut, type, id_auteur) 
	VALUES ('$titre', '$texte', NOW(), '$statut', '$type', '1' )";
	$result = spip_query($query);
	$id_message = spip_insert_id();
	spip_query("INSERT INTO spip_auteurs_messages (id_auteur,id_message,vu) VALUES ('1','$id_message','non')");
    }
			
	} else {
			spip_log("envoi mail nouveautes : pas de nouveautes");
				
	$type = 'auto';
	$statut = 'publie';
  	include_ecrire('inc_connect.php3');  // connexion
	
	 if ($db_ok == 1) {
	 $query = "INSERT INTO spip_messages (titre, texte, date_heure, statut, type, id_auteur) 
	 VALUES ('Pas d\'envoi', 'aucune nouveaut�, le mail automatique n a pas �t� envoy�' , NOW(), '$statut', '$type', 1 )";
	 $result = spip_query($query);
	 $id_message = spip_insert_id();
	 spip_query("INSERT INTO spip_auteurs_messages (id_auteur,id_message,vu) VALUES ('1','$id_message','non')");
     }
	
	} // y'a du neuf
} // c'est l'heure


// Envoi d'un mail depuis la bloOgletter ou par les nouveaut�s, gr�ce � la m�leuse bloog

global $table_prefix;
$query_message = "SELECT * FROM ".$table_prefix."_messages AS messages WHERE statut='encour'";

		$result_pile = spip_query($query_message);
		$message_pile = spip_num_rows($result_pile);
			
		if ($message_pile > 0){
		echo"<iframe src='inc-bloog-meleuse.php3' height='1' width='1' frameborder='0' >D�sol�</iframe>";
		}

unset($titre);

/******************************************************************************************/
/* La bloOgletter est un syst�me de gestion de listes d'information par email pour SPIP   */
/* Copyright (C) 2004 Vincent CARON  v.caron<at>laposte.net , http://bloog.net            */
/*                                                                                        */
/* Ce programme est libre, vous pouvez le redistribuer et/ou le modifier selon les termes */
/* de la Licence Publique G�n�rale GNU publi�e par la Free Software Foundation            */
/* (version 2).                                                                           */
/*                                                                                        */
/* Ce programme est distribu� car potentiellement utile, mais SANS AUCUNE GARANTIE,       */
/* ni explicite ni implicite, y compris les garanties de commercialisation ou             */
/* d'adaptation dans un but sp�cifique. Reportez-vous � la Licence Publique G�n�rale GNU  */
/* pour plus de d�tails.                                                                  */
/*                                                                                        */
/* Vous devez avoir re�u une copie de la Licence Publique G�n�rale GNU                    */
/* en m�me temps que ce programme ; si ce n'est pas le cas, �crivez � la                  */
/* Free Software Foundation,                                                              */
/* Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307, �tats-Unis.                   */
/******************************************************************************************/



?>