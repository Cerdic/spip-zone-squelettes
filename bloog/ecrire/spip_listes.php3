<?php

/******************************************************************************************/
/* spip-listes est un système de gestion de listes d'abonnés et d'envoi d'information     */
/* par email  pour SPIP.                                                                  */
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

//include("ecrire/inc_version.php3") ;

init_config();
if ($changer_config == 'oui') {
	appliquer_modifs_config();
}
 
$nomsite=lire_meta("nom_site"); 
$urlsite=lire_meta("adresse_site"); 
 

 
 // Admin SPIP-Listes
debut_page("Spip listes", "redacteurs", "spiplistes");


if ($connect_statut != "0minirezo" ) {
	echo "<p><b>"._T('spiplistes:acces_a_la_page')."</b></p>";
	fin_page();
	exit;
}

if (($connect_statut == "0minirezo") OR ($connect_id_auteur == $id_auteur)) {
	$statut_auteur=$statut;
	spip_listes_onglets("messagerie", "Spip listes");
}

debut_gauche();

// debut des racourcis
debut_raccourcis("mailer_config.gif");
//


		
if ($connect_statut == "0minirezo") {
icone_horizontale(_T('spiplistes:Nouveau_courrier'), "spip_listes.php3?mode=courrier_edit&new=oui&type=nl", "stock_mail_send.gif");
icone_horizontale(_T('spiplistes:Nouvelle_liste_de_diffusion'), "spip_listes.php3?mode=creer_liste&new=oui", "reply-to-all-24.gif");
echo "<br />" ;
echo "<br />" ;
icone_horizontale(_T('spiplistes:Patrons'), "spip_listes.php3?mode=squelettes", "Palette-24.gif");
icone_horizontale(_T('spiplistes:Configuration'), "spip_listes.php3?mode=config", "mailer_config.gif");
	}
	



fin_raccourcis();
//



//Afficher la console d'envoi ?

global $table_prefix;
$qery_message = "SELECT * FROM ".$table_prefix."_messages AS messages WHERE statut='encour' AND (type='auto' OR type='nl') LIMIT 0,1";
$rsult_pile = spip_query($qery_message);
$mssage_pile = spip_num_rows($rsult_pile);
		

//initialiser le nombre total d'abonnes		
$extra_meta = get_extra(1,"auteur");

if(!$extra_meta["total_auteurs"]){
$extra_meta["total_auteurs"] = "0";
set_extra(1,$extra_meta,"auteur");
$extra_meta = get_extra(1,"auteur");
}


 if($mssage_pile > 0 ){
	// Les valeurs sont deja initialisées
	// Compter le nombre de mails à envoyer

	$nb_inscrits = $extra_meta["total_auteurs"];
	echo "<br />";
	debut_boite_info();

	echo "<div style='font-weight:bold;text-align:center'>"._T('spiplistes:message_en_cours')."</div>";
	echo "<div style='padding : 10px;text-align:center'><img src='img_pack/48_import.gif'></div>";
		if($nb_inscrits > 0){
		echo "<p align='center'><b>".round($extra_meta["debut"]/$nb_inscrits *100)." %</b></p>";
		}
	echo "<p>"._T('spiplistes:texte_boite_en_cours')."</p>" ;
	echo "<p align='center'><a href='../spip-meleuse.php3'>["._T('spiplistes:suivi_envois')."]</a></p>";
	
	echo "<p align='center'><a href='".$PHP_SELF."?envoi_lot=oui'><tt>["._T('spiplistes:lot_suivant')."]</tt></a></p>";
   echo "<p align='center'><a href='".$PHP_SELF."'><tt>["._T('spiplistes:actualiser')."]</tt></a></p>";
	if($envoi_lot == "oui"){
	// echo"<iframe src='../spip-meleuse.php3' height='1' width='1' frameborder='0' >"._T('spiplistes:desole')."</iframe>";

}
	
	
	fin_boite_info();
 }elseif($extra_meta["debut"] != 0){
	$extra_meta["debut"] = 0; // initialiser le compteur à zero pour etre sur
	set_extra(1,$extra_meta,"auteur");
 }



echo "<br />" ;

debut_boite_info();

echo _T('spiplistes:_aide');

fin_boite_info();


creer_colonne_droite();



debut_droite("messagerie");


// Rédaction d'un courrier

if ($mode == "courrier_edit"){

if ($new == "oui") {
	$statut = 'redac';
	$query = "INSERT INTO spip_messages (titre, date_heure, statut, type, id_auteur) VALUES ('".addslashes(filtrer_entites(_T('texte_nouveau_message')))."', NOW(), '$statut', '$type', $connect_id_auteur)";
	$result = spip_query($query);
	$id_message = spip_insert_id();
    spip_query("INSERT INTO spip_auteurs_messages (id_auteur,id_message,vu) VALUES ('$connect_id_auteur','$id_message','oui')");
}


$query = "SELECT * FROM spip_messages WHERE id_message=$id_message";
$result = spip_query($query);

if ($row = spip_fetch_array($result)) {
	$id_message = $row['id_message'];
	$date_heure = $row["date_heure"];
	$date_fin = $row["date_fin"];
	$titre = entites_html($row["titre"]);
	$texte = entites_html($row["texte"]);
	$type = $row["type"];
	$statut = $row["statut"];
	$page = $row["page"];
	$rv = $row["rv"];
	$expediteur = $row["id_auteur"];
	if (!($expediteur == $connect_id_auteur OR ($type == 'nl' AND $connect_statut == '0minirezo'))) die();

     debut_cadre_relief("stock_insert-slide.gif");
     //Charger un patron ?    
         
	  // inclusion du script de gestion des layers de SPIP
		
                if($spip_version < 1.8 ){
                include 'inc_layer.php3';
		 afficher_script_layer();
		              }
                else{
		echo $GLOBALS['browser_layer'];
                } 

		// Titre du bloc
		echo bouton_block_invisible(md5(_T('spiplistes:charger_patron')));
			echo "<a href=\"javascript:swap_couche('$compteur_block', '$spip_lang_rtl');\">"._T('spiplistes:charger_patron')."</a>";
			
		// Bloc invisible
		echo debut_block_invisible(md5(_T('spiplistes:charger_patron')));
			
		 echo "<table><tr><td>";				
	  
	  echo "<form action='inc_import_patron.php3?mode=courrier&id_message=$id_message' METHOD='post'>";  
      $dir = "../patrons/";

		// Ouvre un dossier bien connu, et liste tous les fichiers
		if (is_dir($dir)) {
    		if ($dh = opendir($dir)) {
        		$total_option=0;
				while (($file = readdir($dh)) !== false) {
                if($file != '..' && $file !='.' && $file !='') $total_option=$total_option+1;
        		}
        		closedir($dh);
			}
				if ($dh = opendir($dir)) {
        		echo "<SELECT name='patron' size='".$total_option."'>";
				
					while (($file = readdir($dh)) !== false) {
               		 if($file != '..' && $file !='.' && $file !='') 
						{
						$titre_option=ereg_replace('(\.html|\.HTML)','',$file);
						echo "<option value='$titre_option'>$titre_option</OPTION>";
						}
					}
				echo "</SELECT>";
        		closedir($dh);
   		  		}
		}
	  		  
	echo "</td><td>";


	  echo "<input type='Hidden' name='inclure_patron' value=\"oui\">";
	  echo "<input type='Hidden' name='id_message' value=\"$id_message\">";
	    echo "<input type='Hidden' name='nomsite' value=\"$nomsite\">";

    $auj = date('Y/m/d');
    echo "<p align='center'>"._T('spiplistes:date_ref')."<br /><input type='text' name='date' style='text-align:center' value=\"$auj\"></p>";
	echo "<p align='center' style='padding-left:20px'>"._T('spiplistes:alerte_modif')."<br /><br /><input type='submit' name='Valider' value='"._T('spiplistes:charger_le_patron')."' class='fondo'></p>";
	echo "</FORM>";

	echo "</td></tr></table>";


		// Fin du bloc
		echo fin_block();

     fin_cadre_relief();

     //Ecrire dans le formulaire


	echo "<form action='spip_listes.php3?mode=courrier&id_message=$id_message' METHOD='post' name='formulaire'>";

	if ($type == 'nl') $le_type = _T('spiplistes:email_collec');

	echo "<font face='Verdana,Arial,Sans,sans-serif' size=2 color='green'><b>$le_type</b></font><p>";
    echo "<font face='Verdana,Arial,Helvetica,sans-serif' size=1 color='red'>"._T('spiplistes:alerte_edit')."</font><p>";

	echo "<input type='Hidden' name='modifier_message' value=\"oui\">";
	echo "<input type='Hidden' name='id_message' value=\"$id_message\">";

	echo _T('texte_titre_obligatoire')."<br />";

	echo "<input type='text' class='formo' name='titre' value=\"$titre\" size='40'>";


	echo "<p><b>"._T('info_texte_message_02')."</b>";
    echo aide ("raccourcis");
    echo"<br />";
	echo afficher_barre('document.formulaire.texte');
	echo "<TEXTAREA id='text_area' name='texte' ".$GLOBALS['browser_caret']." class='formo' ROWS='20' COLS='40' wrap=soft>";
	echo $texte;
	echo "</TEXTAREA>\n";

	echo "<p align='right'><input type='submit' name='Valider' value='"._T('bouton_valider')."' class='fondo'>";
	echo "</FORM>";
}


}

// fin du courrier edit


// Affichage d'un courrier

if ($mode == 'courrier') {


$query_message = "SELECT * FROM spip_messages WHERE id_message=$id_message";
$result_message = spip_query($query_message);
        while($row = spip_fetch_array($result_message)) {
		$type = $row['type'];
		}
	if (!$connect_statut == "0minirezo"){
	echo "<b>"._T('avis_non_acces_message')._T('info_acces_refuse')."</b><p>";
	fin_page();
	exit;
	}



if ($modifier_message == "oui") {	
    $titre = addslashes($titre);
	$texte = addslashes($texte);
	spip_query("UPDATE spip_messages SET titre='$titre', texte='$texte' WHERE id_message='$id_message'");	
}



if ($change_statut) {
spip_query("UPDATE spip_messages SET statut='$change_statut' WHERE id_message='$id_message'");
}

if ($supp_dest) {
	spip_query("DELETE FROM spip_auteurs_messages WHERE id_message='$id_message' AND id_auteur='$supp_dest'");
}

// A sécuriser ?
if ($envoi) {
 spip_query("UPDATE spip_messages SET statut='encour' WHERE id_message='$id_message'");
}

//
//

$query_m = "SELECT * FROM spip_messages WHERE id_message=$id_message";
$result_m = spip_query($query_m);

while($row = spip_fetch_array($result_m)) {
	$id_message = $row['id_message'];
	$date_heure = $row["date_heure"];
	$date_fin = $row["date_fin"];
	$titre = typo($row["titre"]);
	$texte = $row["texte"];
	//$texte = propre($row["texte"]);
	$type = $row["type"];
	$statut = $row["statut"];
	$page = $row["page"];
	$rv = $row["rv"];
	$expediteur = $row['id_auteur'];

	$lejour=journum($row['date_heure']);
	$lemois = mois($row['date_heure']);		
	$lannee = annee($row['date_heure']);		

	
		$le_type = _T('spiplistes:message_type');
		$la_couleur = "red";	
	
    debut_cadre_relief("stock_mail_send.gif");

    if ($statut == 'redac') {
		if (!$envoi && $destinataire) 
		echo "<font face='Verdana,Arial,Sans,sans-serif' size=2 color='red'>
		<b>"._T('spiplistes:message_presque_envoye')."<br />"._T('spiplistes:confirme_envoi')."</b></font>";
		elseif (!$envoi) 
		echo "<br /><font face='Verdana,Arial,Sans,sans-serif' size=2 color='red'>
		<b>"._T('spiplistes:message_en_cours')." <br />"._T('spiplistes:modif_envoi')."</b></font>";
    }

    if ($statut == 'encour'){
        echo "<p><font face='Verdana,Arial,Sans,sans-serif' size=2 color='red'>
        <b>"._T('spiplistes:envoi_program')."</b><br />
        <a href='spip_listes.php3'>["._T('spiplistes:voir_historique')."]</a></font></p>";
			if ($expediteur == $connect_id_auteur  OR ($type == 'nl' AND $connect_statut == '0minirezo') OR ($type == 'auto' AND $connect_statut == '0minirezo')) {
			icone (_T('icone_supprimer_message'), "spip_listes.php3?detruire_message=$id_message", "messagerie-24.gif", "supprimer.gif");
			echo "<br />";
			}
	}

	if ($statut == 'publie')  
	echo "<font face='Verdana,Arial,Sans,sans-serif' size=2 color='red'>
	<b>"._T('spiplistes:message_arch')."</b></font>";

    fin_cadre_relief();

	echo "<div style='margin-top:20px;border: 1px solid $la_couleur; background-color: $couleur_fond; padding: 5px;'>"; // debut cadre de couleur
	//debut_cadre_relief("messagerie-24.gif");
	echo "<table width=100% cellpadding=0 cellspacing=0 border=0>";
	echo "<tr><td width=100%>";

	echo "<font face='Verdana,Arial,Sans,sans-serif' size=2 color='$la_couleur'><b>$le_type</b></font><br />";
	echo "<font face='Verdana,Arial,Sans,sans-serif' size=5><b>$titre</b></font>";
	

    if ($statut == 'redac') {
		if ($expediteur == $connect_id_auteur OR ($type == 'nl' AND $connect_statut == '0minirezo')) {
			echo "\n</td> <td align='right'>";
			if (!$envoi) icone (_T('icone_modifier_message'),"spip_listes.php3?mode=courrier_edit&id_message=$id_message", "messagerie-24.gif", "edit.gif");
			echo "</td><tr></table>";
		}
	}
	
	

	echo "<p>";

    //////////////////////////////////////////////////////
	// Le message lui-meme
	//
    $texte = eregi_replace("__bLg__[0-9@\.A-Z_-]+__bLg__","",$texte);
	$texte = stripslashes($texte);
	$texte = propre($texte); 

    echo "<div align='left'>";
	echo "<table width=100% cellpadding=0 cellspacing=0 border=0>";
	echo "<tr><td>";

	echo "<br /><font face='Georgia,Garamond,Times,serif' size=3>";
	debut_boite_info();
    echo "<h2> "._T('spiplistes:version')." HTML </h2>";
	echo "<p>$texte";
	fin_boite_info();
    
	echo "<p>";
    debut_boite_info();
	echo "<h2> "._T('spiplistes:version')." "._T('spiplistes:val_texte')." </h2>";
    echo "<textarea name='texte' rows='20' class='formo' cols='40' wrap=soft>";
	echo version_texte($texte);
	echo "</textarea><p>\n";

	fin_boite_info();
	echo "</font>";

	echo "</td></tr></table><p>";	
	
//////////////////////////////////////////////////////
	// Newsletter?
	//

// Ajouter si on le connait le destinataire
// on fait ca comme un sale directos dans le texte du message :))
	
if ($statut == 'redac' AND $type =='nl' ){     
	
	if(!$envoi && ($destinataire && $choisir_dest)){
	$texte = "__bLg__".$destinataire."__bLg__".$texte ;
	$texte = addslashes($texte);
	spip_query("UPDATE spip_messages SET texte='$texte' WHERE id_message='$id_message'");
	}

	// email de test
	elseif($envoi_test){
	//vérifier si l adresse est valide ?
	// si l'abonné est inscrit ?
     
     if(email_valide_bloog($adresse_test)){
		$query = "SELECT id_auteur FROM ".$table_prefix."_auteurs WHERE email = '$adresse_test' ORDER BY id_auteur ASC ";
		$result_in = spip_query($query);
		$is_inscrit = spip_num_rows($result_in);
			 if($is_inscrit > 0){
			 $texte = "__bLg__".$adresse_test."__bLg__".$texte ;
			 $texte = addslashes($texte);
			 spip_query("UPDATE spip_messages SET texte='$texte' WHERE id_message='$id_message'");
			 } else{$erreur_mail ='oui';}
     
     }  else{$erreur_mail = 'oui';}
 
	}


	if(!$envoi){
	
	//envoi de test ?
	echo "<form action='spip_listes.php3?mode=courrier&id_message=".$id_message."' method='post'>";
			debut_boite_info();
			echo "<div style='font-size:12px;font-familly:Verdana,Garamond,Times,serif;color:#000000;'>";
			echo "<b>"._T('spiplistes:envoi')."</b><p style='font-familly : Georgia,Garamond,Times,serif'>"._T('spiplistes:envoi_texte')."</p>";
			debut_cadre_enfonce();
			echo "<div style='font-size:12px;font-familly:Verdana,Garamond,Times,serif;color:#000000;'>";
			echo "<div style='float:right'><input type='submit' name='envoi_test' value='"._T('spiplistes:email_tester')."' class='fondo' /></div>";
			echo "<input type='text' name='adresse_test' value='"._T('spiplistes:email_adresse')."' class='fondo'>" ;
			echo "</div>" ;
			fin_cadre_enfonce() ;
			
			if($envoi_test){
			echo "<h2>"._T('spiplistes:email_test')."</h2>" ;
			}else{
			echo "<h2>"._T('spiplistes:email_test_liste')."</h2>" ;
			}
	
					
					//trouver un dest dans le texte
			
	$query_mess = "SELECT * FROM spip_messages WHERE id_message=$id_message";
	$result_mess = spip_query($query_mess);
	
		while($row4 = spip_fetch_array($result_mess)){
		$texte = $row4['texte'] ;
		$destinataires = ''; //secu
		eregi("^__bLg__[0-9@\.A-Z_-]+__bLg__", $texte, $res );
		$destinataires = str_replace("__bLg__","",$res[0]);
		 //echo"destinataire >> $destinataires ";
		// si pas de dest
		
			if($destinataires == ''){
			
				if($erreur_mail == 'oui'){
				echo "<br />"._T('spiplistes:sans_envoi');
				}else{
				$list = spip_query ("SELECT * FROM spip_articles WHERE statut = 'liste' OR statut = 'inact' ");
				echo "<div style='font-size:14px;font-weight:bold'>"._T('spiplistes:destinataires')."</div>";
				echo "<div style='float:right'><input type='submit' name='choisir_dest' value='"._T('spiplistes:choisir_cette')."' class='fondo'></div>";
				echo "<select name='destinataire' >";
				echo "<option value='tous'>"._T('spiplistes:toutes')."</option>" ;
					while($row = spip_fetch_array($list)) {
					$id_article = $row['id_article'] ;
					$titre = $row['titre'] ;
					echo "<option value='$id_article'>$titre</option>" ;
					}
				echo "</select>";
				echo "</div>";
				}
				
			}else{
		
			if($destinataires == 'tous'){
			$vers = _T('spiplistes:abonees');
			}else{
				if(email_valide_bloog($destinataires)){
				$vers = $destinataires ;
				//echo "<h1>$vers</h1>";
				}else{
				//echo "->$vers";
				$destinataires = intval($destinataires) ;
				$desti = spip_query ("SELECT * FROM spip_articles WHERE id_article = '$destinataires' ");
				$row = spip_fetch_array($desti);
				$vers = $row['titre'];
				}
			}
		
			if($erreur_mail != 'oui'){
			echo "<div style='float:right'><input type='submit' name='envoi' value='"._T('spiplistes:envoyer')."' class='fondo'></div>";
			}
			$envoyer_a= _T('spiplistes:envoyer_a');
			echo "<div style='font-size:14px;font-weight:bold'>".$envoyer_a." -> ".$vers."</div>";
			echo "<p>";
			echo "</div>";
			}
	  
		
		} //while
	
	fin_boite_info();
	echo "</form>";
	
	}// pas en mode envoyer
	
	if ($expediteur == $connect_id_auteur  OR ($type == 'nl' AND $connect_statut == '0minirezo')) {
	echo "<br /><table width='100%'><tr><td>";
	echo "\n<table align='left'><tr><td>";
	icone (_T('icone_supprimer_message'), "spip_listes.php3?detruire_message=$id_message", "messagerie-24.gif", "supprimer.gif");
	echo "</td></tr></table>";
	}

}// statut


	echo "</td></tr></table></div>";
	//fin_cadre_relief();
	echo "</div>"; // fin du cadre de couleur
	


	if ($statut == 'publie' AND  $type == 'nl' ) {
	echo "\n<table align='left'><tr><td>";
	icone (_T('icone_arret_discussion'), "spip_listes.php3?id_message=$id_message&supp_dest=$connect_id_auteur", "messagerie-24.gif", "supprimer.gif");
	echo "</td></tr></table>";
	}


		
	echo "</td></tr></table>";
		
	//////////////////////////////////////////////////////
	// Forums
	//

	echo "<br /><br />";

	$forum_retour = urlencode("spip_listes.php3?mode=courrier&id_message=$id_message");


	echo "\n<div align='center'>";
		icone(_T('icone_poster_message'), "forum_envoi.php3?statut=perso&adresse_retour=".$forum_retour."&id_message=$id_message&titre_message=".urlencode($titre), "forum-interne-24.gif", "creer.gif");
	echo "</div>";
    
	

	echo "<p align='left'>";

	$query_forum = "SELECT * FROM spip_forum WHERE statut='perso' AND id_message='$id_message' AND id_parent=0 ORDER BY date_heure DESC LIMIT 0,20";
	$result_forum = spip_query($query_forum);
	afficher_forum($result_forum, $forum_retour);

}//while

}

// Suivi des abonnements


if ($mode == "statut") {




//
// Recherche d'auteur
//

if ($cherche_auteur) {
	echo "<p align='left'>";
	$query = "SELECT id_auteur, nom, email FROM spip_auteurs";
	$result = spip_query($query);

       


        unset($table_auteurs);
	unset($table_ids);
	while ($row = spip_fetch_array($result)) {
	 
         if( email_valide_bloog($cherche_auteur) ){
                $table_auteurs[] = $row["email"] ; }
                else {
                $table_auteurs[] = $row["nom"];
                }
		$table_ids[] = $row["id_auteur"];
	}
	$resultat = mots_ressemblants($cherche_auteur, $table_auteurs, $table_ids);
	debut_boite_info();
	if (!$resultat) {
		echo "<b>"._T('texte_aucun_resultat_auteur', array('cherche_auteur' => $cherche_auteur)).".</b><br />";
	}
	else if (count($resultat) == 1) {

		list(, $nouv_auteur) = each($resultat);
		echo "<b>"._T('spiplistes:une_inscription')."</b><br />";
		$query = "SELECT * FROM spip_auteurs WHERE id_auteur=$nouv_auteur";
		$result = spip_query($query);
		echo "<ul>";
		while ($row = spip_fetch_array($result)) {
			$id_auteur = $row['id_auteur'];
			$nom_auteur = $row['nom'];
			$email_auteur = $row['email'];
			$bio_auteur = $row['bio'];

			echo "<li><font face='Verdana,Arial,Sans,sans-serif' size=2><b><font size=3><a href=\"spip_listes.php3?mode=abonne&id_auteur=$id_auteur\">".typo($nom_auteur)."</a></font></b>";
			echo " | $email_auteur";
                        echo "</font>\n";
		}
		echo "</ul>";
	}
	else if (count($resultat) < 16) {
		reset($resultat);
		unset($les_auteurs);
		while (list(, $id_auteur) = each($resultat)) $les_auteurs[] = $id_auteur;
		if ($les_auteurs) {
			$les_auteurs = join(',', $les_auteurs);
			echo "<b>"._T('texte_plusieurs_articles', array('cherche_auteur' => $cherche_auteur))."</b><br />";
			$query = "SELECT * FROM spip_auteurs WHERE id_auteur IN ($les_auteurs) ORDER BY nom";
			$result = spip_query($query);
			echo "<ul>";
			while ($row = spip_fetch_array($result)) {
				$id_auteur = $row['id_auteur'];
				$nom_auteur = $row['nom'];
				$email_auteur = $row['email'];
				$bio_auteur = $row['bio'];

				echo "<li><font face='Verdana,Arial,Sans,sans-serif' size=2><b><font size=3>".typo($nom_auteur)."</font></b>";

				if ($email_auteur) echo " ($email_auteur)";
				echo " | <a href=\"spip_listes.php3?mode=abonne&id_auteur=$id_auteur\">"._T('spiplistes:choisir')."</a>";

				if (trim($bio_auteur)) {
					echo "<br /><font size=1>".couper(propre($bio_auteur), 100)."</font>\n";
				}
				echo "</font><p>\n";
			}
			echo "</ul>";
		}
	}
	else {
		echo "<b>"._T('texte_trop_resultats_auteurs', array('cherche_auteur' => $cherche_auteur))."</b><br />";
	}
	fin_boite_info();
	echo "<p>";

}


global $table_prefix;
$query_message = "SELECT * FROM ".$table_prefix."_articles AS listes LEFT JOIN ".$table_prefix."_auteurs_articles AS abonnements USING (id_article) WHERE statut='liste'";
$result_pile = spip_query($query_message);
$nb_abonnes = spip_num_rows($result_pile);
		
$query = "SELECT id_auteur, nom, extra FROM spip_auteurs";
$result = spip_query($query);
$nb_inscrits = spip_num_rows($result);

	$cmpt_texte = 0;
	$cmpt_html = 0;
	$cmpt_non = 0;

	while ($row = spip_fetch_array($result)) {
	$abo = get_extra($row["id_auteur"],auteur);

	if ($abo['abo'] == "texte"){
	$cmpt_texte = $cmpt_texte + 1 ;
	}

	if ($abo['abo'] == "html"){
	$cmpt_html = $cmpt_html + 1 ;
	}

	if ($abo['abo'] == "non"){
	$cmpt_non = $cmpt_non + 1 ;
	}

	$total_abo = $cmpt_html + $cmpt_texte ;
	}


debut_cadre_relief('forum-interne-24.gif');


echo"<div>";
echo"<div style='float:right;width:150px'>";
echo "<b>"._T('spiplistes:repartition')."</b>  <br /><b>"._T('spiplistes:html')."</b> : $cmpt_html <br /><b>"._T('spiplistes:texte')."</b> : $cmpt_texte <br /><b>"._T('spiplistes:desabonnes')."</b> : $cmpt_non";
echo"</div>";
$total= $cmpt_html+$cmpt_texte+$cmpt_non;
echo "<p>"._T('spiplistes:nb_inscrits').$total."&nbsp;&nbsp;/&nbsp;&nbsp;"._T('spiplistes:nb_abonnes').$total_abo."<br />"._T('spiplistes:nb_listes').$nb_abonnes."</p>";
echo"</div>";


//echo debut_block_invisible("auteursarticle");

	$query = "SELECT * FROM spip_auteurs WHERE ";
	$query .= "statut!='5poubelle' AND statut!='nouveau' ORDER BY statut, nom";
	$result = spip_query($query);

	if (spip_num_rows($result) > 0) {
		echo "<form action='spip_listes.php3?mode=statut' METHOD='post'>";
        echo "<div align=center>\n";
		echo "<input type='text' name='cherche_auteur' class='fondl' value='' size='20'>";
		echo " <input type='submit' name='Chercher' value='"._T('bouton_chercher')."' class='fondo'>";
		echo "</div></FORM>";
	}
// echo fin_block();



fin_cadre_relief();

echo "<p>";

// auteur

$retour = "spip_listes.php3?mode=statut";

//changer de statut

if(!$statut) $statut=' ';

if( ($changer_statut=='oui') AND ( ($statut=='html') OR ($statut=='texte') OR ($statut=='non') ) ){
$extras = get_extra($id_auteur,"auteur") ;
$extras["abo"] = $statut ;
set_extra($id_auteur,$extras,"auteur");
}

if ($tri) {
	$retour .= "&tri=$tri";
	if ($tri=='nom' OR $tri=='statut')
		$partri = " "._T('info_par_tri', array('tri' => $tri));
	else if ($tri=='id')
		$partri = _T('spiplistes:par_date');
	
	}

//
// Construire la requete
//


	$sql_statut_auteurs = " AND auteurs.statut IN ('0minirezo', '1comite', '5poubelle','6forum')";
	$sql_statut_articles = "";


// tri
switch ($tri) {
//trier les extra ? pas simple..., trions par id
case 'id':
	$sql_order = ' ORDER BY auteurs.id_auteur DESC, unom';
	$type_requete = 'auteur';
	break;

case 'statut':
	$sql_order = ' ORDER BY auteurs.statut, login = "", unom';
	$type_requete = 'auteur';
	break;

case 'nom':
default:
	$sql_order = ' ORDER BY unom';
	$type_requete = 'auteur';
}


// si on doit afficher les auteurs par statut ou par nom,
// la requete principale est simple, et une autre requete
// vient calculer les nombres d'articles publies ;
// si en revanche on doit classer par nombre, la bonne requete
// est la concatenation de $query_nombres et de $query_auteurs

unset($nombre_auteurs);
$auteurs = Array();

if ($type_requete == 'auteur') {
	$result_auteurs = spip_query("SELECT id_auteur, extra, statut, source, pass, login, nom, email, url_site, UPPER(nom) AS unom
		FROM spip_auteurs AS auteurs
		WHERE 1 $sql_statut_auteurs
		$sql_order");
	while ($row = spip_fetch_array($result_auteurs)) {
		$auteurs[$row['id_auteur']] = $row;
		$nombre_auteurs ++;

		$nom_auteur = $row['nom'];
		$premiere_lettre = addslashes(strtoupper(substr($nom_auteur,0,1)));
		if ($premiere_lettre != $lettre_prec) {
			$lettre[$premiere_lettre] = $nombre_auteurs;
		}
		$lettre_prec = $premiere_lettre;
	}

	$result_nombres = spip_query("SELECT auteurs.id_auteur, UPPER(auteurs.nom) AS unom, COUNT(articles.id_article) AS compteur
		FROM spip_auteurs AS auteurs, spip_auteurs_articles AS lien, spip_articles AS articles
		WHERE auteurs.id_auteur=lien.id_auteur AND lien.id_article=articles.id_article
		$sql_statut_auteurs $sql_statut_articles
		GROUP BY auteurs.id_auteur
		$sql_order");
	while ($row = spip_fetch_array($result_nombres))
		$auteurs[$row['id_auteur']]['compteur'] = $row['compteur'];

	// si on n'est pas minirezo, supprimer les auteurs sans article publie
	// sauf les admins, toujours visibles.
	
	

} else { // tri par nombre
	$result_nombres = spip_query("SELECT auteurs.id_auteur, auteurs.statut, auteurs.source, auteurs.pass, auteurs.login, auteurs.nom, auteurs.email, auteurs.url_site, UPPER(nom) AS unom, COUNT(articles.id_article) AS compteur
		FROM spip_auteurs AS auteurs, spip_auteurs_articles AS lien, spip_articles AS articles
		WHERE auteurs.id_auteur=lien.id_auteur AND lien.id_article=articles.id_article
		$sql_statut_auteurs $sql_statut_articles
		GROUP BY auteurs.id_auteur
		$sql_order");
	unset($vus);
	while ($row = spip_fetch_array($result_nombres)) {
		$auteurs[$row['id_auteur']] = $row;
		$vus .= ','.$row['id_auteur'];
		$nombre_auteurs ++;
	}

	// si on est admin, ajouter tous les auteurs sans articles
	// sinon ajouter seulement les admins sans articles
	if ($connect_statut == '0minirezo')
		$sql_statut_auteurs_ajout = $sql_statut_auteurs;
	
	$result_auteurs = spip_query("SELECT auteurs.id_auteur, auteurs.statut, auteurs.source, auteurs.pass, auteurs.login, auteurs.nom, auteurs.email, auteurs.url_site, UPPER(nom) AS unom, 0 as compteur
		FROM spip_auteurs AS auteurs
		WHERE id_auteur NOT IN (0$vus)
		$sql_statut_auteurs_ajout
		$sql_order");
	while ($row = spip_fetch_array($result_auteurs)) {
		$auteurs[$row['id_auteur']] = $row;
		$nombre_auteurs ++;
	}
}


unset ($rub_restreinte);
if ($connect_statut == '0minirezo') { // recuperer les admins restreints
	$restreint = spip_query("SELECT * FROM spip_auteurs_rubriques");
	while ($row = spip_fetch_array($restreint))
		$rub_restreinte[$row['id_auteur']] .= ','.$row['id_rubrique'];
}

//
// Affichage
//


// reglage du debut
$max_par_page = 30;
if ($debut > $nombre_auteurs - $max_par_page)
	$debut = max(0,$nombre_auteurs - $max_par_page);
$fin = min($nombre_auteurs, $debut + $max_par_page);

// ignorer les $debut premiers
unset ($i);
reset ($auteurs);
while ($i++ < $debut AND each($auteurs));

// ici commence la vraie boucle
debut_cadre_relief('redacteurs-24.gif');
echo "<table border='0' cellpadding=3 cellspacing=0 width='100%' class='arial2'>\n";
echo "<tr bgcolor='#DBE1C5'>";
echo "<td width='20'>";
	$img = "<img src='img_pack/admin-12.gif' alt='' border='0'>";
	if ($tri=='statut')
		echo $img;
	else
		echo "<a href='spip_listes.php3?mode=statut&tri=statut' title='"._T('lien_trier_statut')."'>$img</a>";

echo "</td><td>";
	if ($tri == '' OR $tri=='nom')
		echo '<b>'._T('info_nom').'</b>';
	else
		echo "<a href='spip_listes.php3?mode=statut&tri=nom' title='"._T('lien_trier_nom')."'><b>"._T('info_nom')."</b></a>";

if ($options == 'avancees') echo "</td><td colspan='2'><b>"._T('info_contact')."</b>";
echo "</td><td>";
	if ($visiteurs != 'oui') {
		if ($tri=='nombre')
			echo "<b>"._T('spiplistes:format')."</b>";
		else
			echo "<b>"._T('spiplistes:format')."</b>"; 

	}
echo "</td><td>";
echo "<b>"._T('spiplistes:modifier')."</b>";

echo "</td></tr>\n";

if ($nombre_auteurs > $max_par_page) {
	echo "<tr bgcolor='white'><td colspan='".($options == 'avancees' ? 5 : 3)."'>";
	echo "<font face='Verdana,Arial,Sans,sans-serif' size='2'>";
	for ($j=0; $j < $nombre_auteurs; $j+=$max_par_page) {
		if ($j > 0) echo " | ";

		if ($j == $debut)
			echo "<b>$j</b>";
		else if ($j > 0)
			echo "<a href=$retour&debut=$j>$j</a>";
		else
			echo " <a href=$retour>0</a>";

		if ($debut > $j  AND $debut < $j+$max_par_page){
			echo " | <b>$debut</b>";
		}

	}
	echo "</font>";
	echo "</td></tr>\n";

	if (($tri == 'nom' OR !$tri) AND $options == 'avancees') {
		// affichage des lettres
		echo "<tr bgcolor='white'><td colspan='5'>";
		echo "<font face='Verdana,Arial,Sans,sans-serif' size=2>";
		while (list($key,$val) = each($lettre)) {
			if ($val == $debut)
				echo "<b>$key</b> ";
			else
				echo "<a href=$retour&debut=$val>$key</a> ";
		}
		echo "</font>";
		echo "</td></tr>\n";
	}
	echo "<tr height='5'></tr>";
}


 if($debut)$retour .="&debut=".$debut;
while ($i++ <= $fin && (list(,$row) = each ($auteurs))) {
	// couleur de ligne
	$couleur = ($i % 2) ? '#FFFFFF' : $couleur_claire;
	echo "<tr bgcolor='$couleur'>";

	// statut auteur
	echo "<td>";
	echo bonhomme_statut($row);

	// nom
	echo '</td><td>';
	echo "<a href='spip_listes.php3?mode=abonne&id_auteur=".$row['id_auteur']."'>".typo($row['nom']).'</a>';

	if ($connect_statut == '0minirezo' AND $row['statut']=='0minirezo' AND $rub_restreinte[$row['id_auteur']])
		echo " &nbsp;<small>"._T('statut_admin_restreint')."</small>";


	// contact
	if ($options == 'avancees') {
		echo '</td><td>';
		if ($row['messagerie'] == 'oui' AND $row['login']
		AND $activer_messagerie != "non" AND $connect_activer_messagerie != "non" AND $messagerie != "non")
			echo bouton_imessage($row['id_auteur'],"force")."&nbsp;";
		if ($connect_statut=="0minirezo")
			if (strlen($row['email'])>3)
				echo "<a href='mailto:".$row['email']."'>"._T('lien_email')."</a>";
			else
				echo "&nbsp;";

		if (strlen($row['url_site'])>3)
			echo "</td><td><a href='".$row['url_site']."'>"._T('lien_site')."</a>";
		else
			echo "</td><td>&nbsp;";
	}

	// Abonnés ou pas ?
	echo '</td><td>';
	
	$extra = unserialize ($row["extra"]);
	
        if( !is_array($extra) ){
        $extra = array();
        $extra["abo"] = "non";
        set_extra($row["id_auteur"],$extra,'auteur');
        get_extra($row["id_auteur"],'auteur');
        }
	
        $abo = $extra["abo"];

		if($abo == "non") echo "-";
		else echo "&nbsp;".$abo;
		
		
		// Modifier l'abonnement
	echo '</td><td>';
	
  if ($row["statut"] != '0minirezo') {
if($extra["abo"] == 'html') $option_abo = "<a href='$retour&id_auteur=".$row['id_auteur']."&changer_statut=oui&statut=non'>désabo</a> | <a href='$retour&id_auteur=".$row['id_auteur']."&changer_statut=oui&statut=texte'>texte</a>";
else if($extra["abo"] == 'texte') $option_abo = "<a href='$retour&id_auteur=".$row['id_auteur']."&changer_statut=oui&statut=non'>désabo</a> | <a href='$retour&id_auteur=".$row['id_auteur']."&changer_statut=oui&statut=html'>html</a>";
else  if(($extra["abo"] == 'non')OR (!$extra["abo"])) $option_abo = "<a href='$retour&id_auteur=".$row['id_auteur']."&changer_statut=oui&statut=texte'>texte</a> | <a href='$retour&id_auteur=".$row['id_auteur']."&changer_statut=oui&statut=html'>html</a>";
echo "&nbsp;".$option_abo;
  }
	echo "</td></tr>\n";
}

echo "</table>\n";


echo "<a name='bas'>";
echo "<table width='100%' border='0'>";

$debut_suivant = $debut + $max_par_page;
if ($debut_suivant < $nombre_auteurs OR $debut > 0) {
	echo "<tr height='10'></tr>";
	echo "<tr bgcolor='white'><td align='left'>";
	if ($debut > 0) {
		$debut_prec = strval(max($debut - $max_par_page, 0));
		$link = new Link;
		$link->addVar('debut', $debut_prec);
		echo $link->getForm('GET');
		echo "<input type='submit' name='submit' value='&lt;&lt;&lt;' class='fondo'>";
		echo "</form>";
		//echo "<a href='$retour&debut=$debut_prec'>&lt;&lt;&lt;</a>";
	}
	echo "</td><td align='right'>";
	if ($debut_suivant < $nombre_auteurs) {
		$link = new Link;
		$link->addVar('debut', $debut_suivant);
		echo $link->getForm('GET');
		echo "<input type='submit' name='submit' value='&gt;&gt;&gt;' class='fondo'>";
		echo "</form>";
		//echo "<a href='$retour&debut=$debut_suivant'>&gt;&gt;&gt;</a>";
	}
	echo "</td></tr>\n";
}

echo "</table>\n";

fin_cadre_relief();



//fin auteur

}


if ($mode == "abonne") {



if($effacer_definitif=$_POST['effacer_definitif']){
debut_cadre_relief("redacteurs-poubelle-24.gif");
spip_query("DELETE FROM spip_auteurs_articles WHERE id_auteur='$id_auteur'");
spip_query("DELETE FROM spip_auteurs WHERE id_auteur='$id_auteur'");

echo "$nom ($email) "._T('spiplistes:efface');
fin_cadre_relief();
}


if($champs_extra AND ($confirm == 'oui') ){
// prendre en compte les extras
$extras = bloog_extra_recup_saisie('auteurs');
spip_query("UPDATE spip_auteurs SET extra = '$extras' WHERE id_auteur ='$id_auteur'");
}


$query = "SELECT * FROM spip_auteurs WHERE id_auteur='$id_auteur'";
$result = spip_query($query);


if ($row = spip_fetch_array($result)) {
	$id_auteur=$row['id_auteur'];
	$nom=$row['nom'];
	$bio=$row['bio'];
	$email=$row['email'];
	$nom_site_auteur=$row['nom_site'];
	$url_site=$row['url_site'];
	$login=$row['login'];
	$pass=$row['pass'];
	$statut=$row['statut'];
	$pgp=$row["pgp"];
	$messagerie=$row["messagerie"];
	$imessage=$row["imessage"];
	$extra = $row["extra"];
	$low_sec = $row["low_sec"];


        

echo "<div align='center'>";
gros_titre($nom);
echo "</div>";

if ($suppr_auteur AND $id_article) {

        $query = spip_query("SELECT * FROM spip_articles WHERE id_article='$id_article'");
        $row = spip_fetch_array($query);
        $title = $row['titre'] ;
        echo "<h2> ".$nom." "._T('spiplistes:plus_abonne').$title." </h2>";
        $query="DELETE FROM spip_auteurs_articles WHERE id_auteur='$suppr_auteur' AND id_article='$id_article'";
	spip_query($query);
}


if ($statut == "0minirezo") $logo = "redacteurs-admin-24.gif";
else if ($statut == "5poubelle") $logo = "redacteurs-poubelle-24.gif";
else $logo = "redacteurs-24.gif";


if (strlen($email) > 2 OR strlen($bio) > 0 OR strlen($nom_site_auteur) > 0 OR ($champs_extra AND $extra)) {
	debut_cadre_relief("$logo");
	echo "<font face='Verdana,Arial,Sans,sans-serif'>";
	if (strlen($email) > 2) echo _T('email_2')." <b><a href='mailto:$email'>$email</a></b><br /> ";
	if (strlen($nom_site_auteur) > 2) echo _T('info_site_2')." <b><a href='$url_site'>$nom_site_auteur</a></b>";
	echo "<p>".propre($bio)."</p>";
        echo "</font>";
	fin_cadre_relief();

	if ($champs_extra AND $extra) {

	
        debut_cadre_relief("$logo");

        echo"<form action='spip_listes.php3?mode=abonne' method='post'>";
         echo"<p align='center'>";

         bloog_extra_saisie($extra, 'auteurs', 'inscription');
         echo"<input type='submit' name='Valider' value='"._T('spiplistes:modifier')."'>";
         echo"<input type='hidden' name='id_auteur'  value=$id_auteur >";
         echo"<input type='hidden' name='confirm'  value='oui' >";
         echo"</p>";
         echo"</form>";
        fin_cadre_relief();
         }

	
}


echo "<p>";
if ($connect_statut == "0minirezo") $aff_art = "'prepa','prop','publie','refuse'";
else if ($connect_id_auteur == $id_auteur) $aff_art = "'prepa','prop','publie'";
else $aff_art = "'prop','publie'";

afficher_articles_listes(_T('spiplistes:abonne_listes'),
	", spip_auteurs_articles AS lien WHERE lien.id_auteur='$id_auteur' ".
	"AND lien.id_article=articles.id_article AND (articles.statut ='liste' OR articles.statut ='inact') ".
	"ORDER BY articles.date DESC", true, $id_auteur);
}

if(!$effacer_definitif=$_POST['effacer_definitif']){
debut_cadre_relief("$logo");
echo "<h3>"._T('spiplistes:supprime_contact')."</h3>";
echo "<form action='spip_listes.php3?mode=abonne' method='post'>";
echo "<p align='center'>";

echo "<input type='submit' name='Valider' value='"._T('spiplistes:supprime_contact_base')."'>";
echo "<input type='hidden' name='id_auteur'  value=$id_auteur >";
echo "<input type='hidden' name='nom'  value=$nom >";
echo "<input type='hidden' name='email'  value=$email >";
echo "<input type='hidden' name='effacer_definitif'  value='oui' >";
echo "</p>";
echo "</form>";
fin_cadre_relief();
}


}
//fin abonne



// Historique des envois

if ($mode == "historique" OR !$mode){

if ($supp_dest) {
	spip_query("DELETE FROM spip_auteurs_messages WHERE id_message=$id_message AND id_auteur=$supp_dest");
}

if ($detruire_message) {
	spip_query("DELETE FROM spip_messages WHERE id_message=$detruire_message");
	spip_query("DELETE FROM spip_auteurs_messages WHERE id_message=$detruire_message");
	spip_query("DELETE FROM spip_forum WHERE id_message=$detruire_message");
}





/// afficher un tableau de messages



///

$messages_vus = '';

global $table_prefix;
$query_message = "SELECT * FROM ".$table_prefix."_messages AS messages WHERE statut='encour' AND (type='auto' OR type='nl')";
bloog_afficher_messages(_T('spiplistes:aff_encours'), $query_message, false, true, true, false ,'24_send-receive.gif');


echo "<p>" ;
$query_message = "SELECT * FROM spip_messages AS messages WHERE type='nl' AND statut='redac'";
bloog_afficher_messages(_T('spiplistes:aff_redac'), $query_message, false, true, false, false ,'stock_mail.gif');

echo "<p>" ;


// afficher les messages auto
$list = spip_query ("SELECT * FROM spip_articles WHERE statut = 'inact' OR statut = 'liste' ");
$message_pile = spip_num_rows($list);
if ($message_pile > 0){

$flag_auto = false ;
while($row = spip_fetch_array($list)) {
$extraa = unserialize($row['extra']);
if($extraa['auto'] == 'oui') $flag_auto = true ;
}

if($flag_auto){
debut_cadre_enfonce("stock_timer.gif");
			echo "<div  class='chapo' style='border-top:1px #cccccc;width:100%;font-weight:bold;font-size:14px'>"._T('spiplistes:Messages_automatiques')."</div>";
			echo "<p>" ;
			$i = 0 ;
			$list = spip_query ("SELECT * FROM spip_articles WHERE statut = 'inact' OR statut = 'liste' ");
                        $message_pile = spip_num_rows($list);
                        while($row = spip_fetch_array($list)) {
                        $id_article = $row['id_article'] ;
						$titre = $row['titre'] ;
                         
			// On récupère les extras
                        $extra = get_extra($id_article, 'article');
                        // Tient il n'y avait pas d'extra pour cette liste
                        if (!is_array($extra)) {
                        	$extra = array();
                        }

                        $sablier = time() - $extra['majnouv'] ;
                        $proch = round( ( (24*3600*$extra['periode']) - $sablier) / (3600*24) ) ;


			if($extra['auto'] == "oui"){
			if($i == 0){
			echo "<div style='padding:5px'>" ;
			$i = 1 ;
			}else {
			echo "<div style='padding:5px;background-color:#FFFFFF'>" ;
			$i = 0 ;
			}
			echo "<div style='float:right'>";
			if($proch != 0)echo "<br />"._T('spiplistes:prochain_envoi_prevu')."<b>$proch</b> "._T('spiplistes:jours')."</div>";
                        else echo "<br />"._T('spiplistes:prochain_envoi_aujd')."</div>";
                        $date_dernier = $extra['majnouv'] ;
                        $date_dernier = date(_T('spiplistes:format_date'),$date_dernier) ;

			echo "<a href='?mode=liste_edit&id_article=$id_article'>$titre</a> (".$extra['squelette'].")<br />
			<i>"._T('spiplistes:Tous_les')." ".$extra['periode']." "._T('spiplistes:jours')." [<a href='../patron.php3?patron=".$extra['squelette']."&date=".$date_dernier."'>"._T('spiplistes:voir')."</a>]</i>" ;
			echo "</div>" ;

                        }

			}


fin_cadre_enfonce();
}// flag_auto
   }// message pile

  echo "<p>" ;

$query_message = "SELECT * FROM spip_messages AS messages WHERE statut='publie' AND type='auto' ";
bloog_afficher_messages(_T('spiplistes:messages_auto_envoye'), $query_message, false,  false, false);


echo "<p>" ;
$query_message = "SELECT * FROM spip_messages AS messages WHERE statut='publie' AND type='nl' ";
bloog_afficher_messages(_T('spiplistes:aff_envoye'), $query_message, false,  false, false);

}





if ($mode == "squelettes"){


//
// Définir les squelettes
//

	debut_cadre_relief();








	echo "<table border=0 cellspacing=1 cellpadding=3 width=\"100%\">";
	echo "<tr><td bgcolor='$couleur_foncee' background='img_pack/rien.gif'>
	<b><font face='Verdana,Arial,Sans,sans-serif' size=3 COLOR='#FFFFFF'>"._T('spiplistes:definir_squel')."</font></b></td></tr>";
	echo "<tr><td bgcolor='#FFFFFF' background='img_pack/rien.gif' >";
	echo " </td></tr>";
	echo "<tr><td bgcolor='#EEEECC' background='img_pack/rien.gif' >";


        //un patron ?



	echo "<b><font face='Verdana,Arial,Sans,sans-serif' size=3>";
	echo _T('spiplistes:patron_disponibles')."</font></b>";

    echo "</td></tr>";

    echo "<tr><td bgcolor='#FFFFFF' background='img_pack/rien.gif' >";


        	echo "<form action='../patron.php3' METHOD='GET' TARGET='_blank'>";  
      echo "<div>";
	  echo "<div style='float:right;width:200px'>";


    $auj = date(_T('spiplistes:format_date'));
    echo "<p align='center'><b>"._T('spiplistes:date_ref')."</b><br /><input type='text' name='date' value=\"$auj\"></p>";
	echo " <input type='radio' name='format' value='HTML'> HTML<br />";
    echo "<input type='radio' name='format' value='texte'>"._T('spiplistes:val_texte')."<br />";
	echo "<p align='center'>"._T('spiplistes:alerte_modif')."<br /><br /><input type='submit' name='Valider' value='"._T('spiplistes:charger_le_patron')."' class='fondo'></p>";
	echo "</div>";
	  
	  
	  $dir = "../patrons/";

		// Ouvre un dossier bien connu, et liste tous les fichiers
		if (is_dir($dir)) {
    		if ($dh = opendir($dir)) {
        		$total_option=0;
				while (($file = readdir($dh)) !== false) {
                if($file != '..' && $file !='.' && $file !='') $total_option=$total_option+1;
        		}
        		closedir($dh);
			}
				if ($dh = opendir($dir)) {
        		echo "<SELECT name='patron' size='".$total_option."'>";
				
					while (($file = readdir($dh)) !== false) {
               		 if($file != '..' && $file !='.' && $file !='') 
						{
						$titre_option=ereg_replace('(\.html|\.HTML)','',$file);
						echo "<option value='$titre_option'>$titre_option</OPTION>";
						}
					}
				echo "</SELECT>";
        		closedir($dh);
   		  		}
		}
	  		  
	
	echo "</div>";
	echo "</FORM>";


                echo "<blockquote><i>"._T('spiplistes:definir_squel_texte')."</i></blockquote>";
				

        echo "</td></tr>";


	echo "</table>\n";

	echo "</FORM>";

	fin_cadre_relief();

}


if($mode == "creer_liste"){


$articles_surtitre = lire_meta("articles_surtitre");
$articles_soustitre = lire_meta("articles_soustitre");
$articles_descriptif = lire_meta("articles_descriptif");
$articles_urlref = lire_meta("articles_urlref");
$articles_chapeau = lire_meta("articles_chapeau");
$articles_ps = lire_meta("articles_ps");
$articles_redac = lire_meta("articles_redac");
$articles_mots = lire_meta("articles_mots");
$articles_modif = lire_meta("articles_modif");

// securite
$id_article = intval($id_article);
$id_rubrique = intval($id_rubrique);
$lier_trad = intval($lier_trad);
unset ($flag_editable);

//
// Creation de l'objet article
//

if ($id_article) {
	spip_query("UPDATE spip_articles SET date_modif=NOW(), auteur_modif=$connect_id_auteur WHERE id_article=$id_article");
	$id_article_bloque = $id_article;	// message pour inc_presentation

	// Recuperer les donnees de l'article
	$query = "SELECT * FROM spip_articles WHERE id_article=$id_article";
	$result = spip_query($query);

	if ($row = spip_fetch_array($result)) {
		$id_article = $row["id_article"];
		$surtitre = $row["surtitre"];
		$titre = $row["titre"];
		$soustitre = $row["soustitre"];
		$id_rubrique = $row["id_rubrique"];
		$id_secteur = $row['id_secteur'];
		$descriptif = $row["descriptif"];
		$nom_site = $row["nom_site"];
		$url_site = $row["url_site"];
		$chapo = $row["chapo"];
		$texte = $row["texte"];
		$ps = $row["ps"];
		$date = $row["date"];
		$statut = $row['statut'];
		$date_redac = $row['date_redac'];
	    	if (ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})",$date_redac,$regs)){
		        $mois_redac = $regs[2];
		        $jour_redac = $regs[3];
		        $annee_redac = $regs[1];
		        if ($annee_redac > 4000) $annee_redac -= 9000;
		}
		$extra=$row["extra"];

		$query = "SELECT * FROM spip_auteurs_articles WHERE id_article=$id_article AND id_auteur=$connect_id_auteur";
		$result_auteur = spip_query($query);
		$flag_auteur = (spip_num_rows($result_auteur) > 0);

		$flag_editable = (acces_rubrique($id_rubrique) OR ($flag_auteur > 0 AND ($statut == 'prepa' OR $statut == 'prop' OR $new == 'oui')));
	}
}
else if ($new=='oui') {
	if ($lier_trad) {
		// Pas de langue choisie par defaut
		$changer_lang = '';

		// Recuperer les donnees de la traduction
		$query = "SELECT * FROM spip_articles WHERE id_article=$lier_trad";
		$result = spip_query($query);

		if ($row = spip_fetch_array($result)) {
			$surtitre = $row["surtitre"];
			$titre = filtrer_entites(_T('info_nouvelle_traduction')).' '.$row["titre"];
			$soustitre = $row["soustitre"];
			$id_rubrique_trad = $row["id_rubrique"];
			$descriptif = $row["descriptif"];
			$nom_site = $row["nom_site"];
			$url_site = $row["url_site"];
			$chapo = $row["chapo"];
			$texte = $row["texte"];
			$ps = $row["ps"];
			$date = $row["date"];
			$date_redac = $row['date_redac'];
			if (ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})",$date_redac,$regs)) {
				$mois_redac = $regs[2];
				$jour_redac = $regs[3];
				$annee_redac = $regs[1];
				if ($annee_redac > 4000) $annee_redac -= 9000;
			}
			$extra = $row["extra"];
		}
		$langues_autorisees = lire_meta('langues_multilingue');

		// Regler la langue, si possible
		if (ereg(",$spip_lang,", ",$langues_autorisees,")) {
			if (lire_meta('multi_articles') == 'oui') {
				// Si le menu de langues est autorise sur les articles,
				// on peut changer la langue quelle que soit la rubrique
				$changer_lang = $spip_lang;
			}
			else if (lire_meta('multi_rubriques') == 'oui') {
				// Chercher la rubrique la plus adaptee pour accueillir l'article
				if (lire_meta('multi_secteurs') == 'oui')
					$id_parent = 0;
				else {
					$query = "SELECT id_parent FROM spip_rubriques WHERE id_rubrique=$id_rubrique";
					$row_rub = spip_fetch_array(spip_query($query));
					$id_parent = $row_rub['id_parent'];
				}
				$query = "SELECT id_rubrique FROM spip_rubriques WHERE lang='$spip_lang' AND id_parent=$id_parent";
				if ($row_rub = spip_fetch_array(spip_query($query))) {
					$id_rubrique = $id_secteur = $row_rub['id_rubrique'];
					$changer_lang = 'herit';
				}
			}
		}
	}
	else {
		// Nouvel article : titre par defaut
		$titre = filtrer_entites(_T('spiplistes:Nouvelle_liste_de_diffusion'));
		$onfocus = " onfocus=\"if(!antifocus){this.value='';antifocus=true;}\"";
	}
	if (!$id_secteur) {
		$row_rub = spip_fetch_array(spip_query("SELECT id_secteur FROM spip_rubriques WHERE id_rubrique=$id_rubrique"));
		$id_secteur = $row_rub['id_secteur'];
	}
	$flag_editable = true;
}



if ($id_article && $id_document) {
	$query_doc = "SELECT * FROM spip_documents_articles WHERE id_document=$id_document AND id_article=$id_article";
	$result_doc = spip_query($query_doc);
	$flag_document_editable = (spip_num_rows($result_doc) > 0);
} else {
	$flag_document_editable = false;
}

$modif_document = $GLOBALS['modif_document'];
if ($modif_document == 'oui' AND $flag_document_editable) {
	$titre_document = addslashes(corriger_caracteres($titre_document));
	$descriptif_document = addslashes(corriger_caracteres($descriptif_document));
	$query = "UPDATE spip_documents SET titre=\"$titre_document\", descriptif=\"$descriptif_document\"";
	if ($largeur_document AND $hauteur_document) $query .= ", largeur='$largeur_document', hauteur='$hauteur_document'";
	$query .= " WHERE id_document=$id_document";
	spip_query($query);
}




//
// Gestion des textes trop longs (limitation brouteurs)
//

function coupe_trop_long($texte){	// utile pour les textes > 32ko
	if (strlen($texte) > 28*1024) {
		$texte = str_replace("\r\n","\n",$texte);
		$pos = strpos($texte, "\n\n\n", 28*1024);	// coupe para > 28 ko
		if ($pos > 0 and $pos < 32 * 1024) {
			$debut = substr($texte, 0, $pos)."\n\n\n<!--SPIP-->\n";
			$suite = substr($texte, $pos + 3);
		} else {
			$pos = strpos($texte, " ", 28*1024);	// sinon coupe espace
			if (!($pos > 0 and $pos < 32 * 1024))
				$pos = 28*1024;	// au pire
			$debut = substr($texte,0,$pos);
			$suite = substr($texte,$pos + 1);
		}
		return (array($debut,$suite));
	}
	else
		return (array($texte,''));
}


debut_cadre_formulaire();
 /*

function mySel($varaut,$variable) {
	$retour= " value=\"$varaut\"";

	if ($variable==$varaut) {
		$retour.= " SELECTED";
	}

	return $retour;
}



function my_sel($num,$tex,$comp){
	if ($num==$comp){
		echo "<option value='$num' SELECTED>$tex\n";
	}else{
		echo "<option value='$num'>$tex\n";
	}

}

function afficher_mois($mois){
	my_sel("01",_T('date_mois_1'),$mois);
	my_sel("02",_T('date_mois_2'),$mois);
	my_sel("03",_T('date_mois_3'),$mois);
	my_sel("04",_T('date_mois_4'),$mois);
	my_sel("05",_T('date_mois_5'),$mois);
	my_sel("06",_T('date_mois_6'),$mois);
	my_sel("07",_T('date_mois_7'),$mois);
	my_sel("08",_T('date_mois_8'),$mois);
	my_sel("09",_T('date_mois_9'),$mois);
	my_sel("10",_T('date_mois_10'),$mois);
	my_sel("11",_T('date_mois_11'),$mois);
	my_sel("12",_T('date_mois_12'),$mois);
}

function afficher_jour($jour){
	for($i=1;$i<32;$i++){
		if ($i<10){$aff="&nbsp;".$i;}else{$aff=$i;}
		my_sel($i,$aff,$jour);
	}
}
  */



echo "\n<table cellpadding=0 cellspacing=0 border=0 width='100%'>";
echo "<tr width='100%'>";
echo "<td>";
	if ($lier_trad) icone(_T('icone_retour'), "spip_listes.php3?mode=liste_edit&id_article=$lier_trad", "article-24.gif", "rien.gif");
	else icone(_T('icone_retour'), "spip_listes.php3?mode=liste_edit&id_article=$id_article", "article-24.gif", "rien.gif");

echo "</td>";
	echo "<td><img src='img_pack/rien.gif' width=10></td>\n";
echo "<td width='100%'>";
echo _T('spiplistes:modifier_liste');
gros_titre($titre);
echo "</td></tr></table>";
echo "<p>";

echo "<p><HR><p>";

	$titre = entites_html($titre);
	$soustitre = entites_html($soustitre);
	$surtitre = entites_html($surtitre);

	$descriptif = entites_html($descriptif);
	$nom_site = entites_html($nom_site);
	$url_site = entites_html($url_site);
	$chapo = entites_html($chapo);
	$texte = entites_html($texte);
	$ps = entites_html($ps);

	$lien = 'spip_listes.php3?mode=liste_edit';
	if ($id_article) $lien .= "&id_article=$id_article";
	echo "<form action='$lien' METHOD='post' name='formulaire'>\n";

	if ($id_article)
		echo "<input type='Hidden' name='id_article' value='$id_article'>";
	else if ($new == 'oui')
		echo "<input type='Hidden' name='new' value='oui'>";

	if ($lier_trad) {
		echo "<input type='Hidden' name='lier_trad' value='$lier_trad'>";
		echo "<input type='Hidden' name='changer_lang' value='$spip_lang'>";
	}

	/*
	if (($options == "avancees" AND $articles_surtitre != "non") OR $surtitre) {
		echo "<b>"._T('texte_sur_titre')."</b>";
		echo "<br /><input type='text' name='surtitre' class='forml' value=\"$surtitre\" size='40'><p>";
	}
	else {
		echo "<input type='hidden' name='surtitre' value=\"$surtitre\" >";
	}
    */
	echo _T('texte_titre_obligatoire');
	echo "<br /><input type='text' name='titre' style='font-weight: bold; font-size: 13px;' class='formo' value=\"$titre\" size='40' $onfocus><p>";

	/*
	if (($articles_soustitre != "non") OR $soustitre) {
		echo "<b>"._T('texte_sous_titre')."</b>";
		echo "<br /><input type='text' name='soustitre' class='forml' value=\"$soustitre\" size='40'><br /><br />";
	}
	else {
		echo "<input type='hidden' name='soustitre' value=\"$soustitre\">";
	}
    */




	if ($new != 'oui') echo "<input type='hidden' name='id_rubrique_old' value=\"$id_rubrique\" >";


	if (($options == "avancees" AND $articles_descriptif != "non") OR $descriptif) {
		echo "<p><b>"._T('texte_descriptif_rapide')."</b>";
		echo aide ("artdesc");
		echo "<br />"._T('texte_contenu_article')."<br />";
		echo "<TEXTAREA name='descriptif' class='forml' ROWS='2' COLS='40' wrap=soft>";
		echo $descriptif;
		echo "</TEXTAREA><p>\n";
	}
	else {
		echo "<input type='hidden' name='descriptif' value=\"$descriptif\">";
	}

        /*

	if (($options == "avancees" AND $articles_urlref != "non") OR $nom_site OR $url_site) {
		echo _T('entree_liens_sites')."<br />\n";
		echo _T('info_titre')." ";
		echo "<input type='text' name='nom_site' class='forml' width='40' value=\"$nom_site\"/><br />\n";
		echo _T('info_url')." ";
		echo "<input type='text' name='url_site' class='forml' width='40' value=\"$url_site\"/>";
	}

	if (substr($chapo, 0, 1) == '=') {
		$virtuel = substr($chapo, 1);
		$chapo = "";
	}

	if ($connect_statut=="0minirezo" AND $virtuel){
		echo "<p><div style='border: 1px dashed #666666; background-color: #f0f0f0; padding: 5px;'>";
		echo "<table width=100% cellspacing=0 cellpadding=0 border=0>";
		echo "<tr><td valign='top'>";
		echo "<font face='Verdana,Arial,Sans,sans-serif' size=2>";
		echo "<b><label for='confirme-virtuel'>"._T('info_redirection')."&nbsp;:</label></b>";
		echo aide ("artvirt");
		echo "</font>";
		echo "</td>";
		echo "<td width=10>&nbsp;</td>";
		echo "<td valign='top' width='50%'>";
		if (!$virtuel) $virtuel = "http://";
		echo "<input type='text' name='virtuel' class='forml' style='font-size:9px;' value=\"$virtuel\" size='40'>";
		echo "<input type='hidden' name='changer_virtuel' value='oui'>";
		echo "</td></tr></table>\n";
		echo "<font face='Verdana,Arial,Sans,sans-serif' size=2>";
		echo _T('texte_article_virtuel_reference');
		echo "</font>";
		echo "</div><p>\n";
	}

	else {
		echo "<HR>";

		if (($articles_chapeau != "non") OR $chapo) {
			if ($spip_ecran == "large") $rows = 8;
			else $rows = 5;
			echo "<b>"._T('info_chapeau')."</b>";
			echo aide ("artchap");
			echo "<br />"._T('texte_introductif_article')."<br />";
			echo "<TEXTAREA name='chapo' class='forml' ROWS='$rows' COLS='40' wrap=soft>";
			echo $chapo;
			echo "</TEXTAREA><p>\n";
		}
		else {
			echo "<input type='hidden' name='chapo' value=\"$chapo\">";
		}

	}

	*/

	if ($spip_ecran == "large") $rows = 28;
	else $rows = 20;

	if (strlen($texte)>29*1024) // texte > 32 ko -> decouper en morceaux
	{
		$textes_supplement = "<br /><font color='red'>"._T('info_texte_long')."</font>\n";
		while (strlen($texte)>29*1024)
		{
			$nombre_textes ++;
			list($texte1,$texte) = coupe_trop_long($texte);

			$textes_supplement .= "<br />";
			$textes_supplement .= afficher_barre('formulaire', 'texte'.$nombre_textes);
			$textes_supplement .= "<textarea name='texte$nombre_textes'".
				" class='formo' ".afficher_claret()." rows='$rows' cols='40' wrap=soft>" .
				$texte1 . "</textarea><p>\n";
		}
	}
	echo "<b>"._T('spiplistes:txt_inscription')."</b>";
	echo "<br />"._T('spiplistes:txt_abonnement');
	echo "<br />"._T('texte_enrichir_mise_a_jour');
	echo aide("raccourcis");

	echo $textes_supplement;

	//echo "<br />";
	echo afficher_barre('formulaire', 'texte');
	echo "<textarea id='text_area' name='texte' ".afficher_claret()." class='formo' rows='$rows' cols='40' wrap=soft>";
	echo $texte;
	echo "</textarea>\n";

/* 	// traitement automatique des sauts de ligne : pas mur
	if ($proposer_autobr AND ($options == "avancees")) {
		echo '<div class="verdana2">';
		echo '<input type="checkbox" class="checkbox" name="post_autobr" id="autobr" value="1" />';
		echo '<label for="autobr">'._L("prendre en compte les sauts de ligne simples").'</label></div>';
	}


	if (($articles_ps != "non" AND $options == "avancees") OR $ps) {
		echo "<p><b>"._T('info_post_scriptum')."</b><br />";
		echo "<textarea name='ps' class='forml' rows='5' cols='40' wrap=soft>";
		echo $ps;
		echo "</textarea><p>\n";
	}
	else {
		echo "<input type='hidden' name='ps' value=\"$ps\">";
	}
 */
	if ($champs_extra) {
		include_ecrire("inc_extra.php3");
		extra_saisie($extra, 'articles', $id_secteur);
	}

	if ($date)
		echo "<input type='Hidden' name='date' value=\"$date\" size='40'><p>";

	if ($new == "oui")
		echo "<input type='Hidden' name='statut_nouv' value=\"inact\" size='40'><p>";

	echo "<div align='right'>";
	echo "<input class='fondo' type='submit' name='Valider' value='"._T('bouton_valider')."'>";
	echo "</div></form>";
	
	

fin_cadre_formulaire();





}

/// afficher une liste

if ($mode == "liste_edit"){
////

  //yoyo

if ($id_article==0) {
	if ($new=='oui') {
		$id_rubrique = intval($id_rubrique);
		if ($titre=='') $titre = _T('spiplistes:liste_sans_titre');

		$langue_new = '';
		$result_lang_rub = spip_query("SELECT lang FROM spip_rubriques WHERE id_rubrique=$id_rubrique");
		if ($row = spip_fetch_array($result_lang_rub))
			$langue_new = $row["lang"];

		if (!$langue_new) $langue_new = lire_meta('langue_site');
		$langue_choisie_new = 'non';

		$forums_publics = substr(lire_meta('forums_publics'),0,3);
		spip_query("INSERT INTO spip_articles (id_rubrique, statut, date, accepter_forum, lang, langue_choisie) VALUES ($id_rubrique, 'inact', NOW(), '$forums_publics', '$langue_new', '$langue_choisie_new')");
		$id_article = spip_insert_id();
		spip_query("DELETE FROM spip_auteurs_articles WHERE id_article = $id_article");
		spip_query("INSERT INTO spip_auteurs_articles (id_auteur, id_article) VALUES ($connect_id_auteur, $id_article)");
	} /*else {
		@header("Location: ./index.php3");
		exit;
	}*/
}


$clean_link = new Link("spip_listes.php3?mode=list_edit&id_article=$id_article");

// Initialiser doublons pour documents (completes par "propre($texte)")
$id_doublons['documents'] = "0";



//////////////////////////////////////////////////////
// Determiner les droits d'edition de l'article
//

$query = "SELECT statut, titre, id_rubrique FROM spip_articles WHERE id_article=$id_article";
$result = spip_query($query);
if ($row = spip_fetch_array($result)) {
	$statut_article = $row['statut'];
	$titre_article = $row['titre'];
	$rubrique_article = $row['id_rubrique'];
}
else {
	$statut_article = '';
}

$query = "SELECT * FROM spip_auteurs_articles WHERE id_article=$id_article AND id_auteur=$connect_id_auteur";
$result_auteur = spip_query($query);

//
// Droits mieux structurés que ca ?
//

$flag_auteur = (spip_num_rows($result_auteur) > 0);
$flag_editable = (acces_rubrique($rubrique_article)
	OR ($flag_auteur AND ($statut_article == 'inact' OR $statut_article == 'liste' OR $statut_article == 'poublist')));


//
// Appliquer les modifications
//




$suivi_edito = lire_meta("suivi_edito");
$reindexer = false;

$ok_nouveau_statut = false;

function terminer_changement_statut() {
	global $ok_nouveau_statut, $statut_nouv, $statut_ancien, $id_article, $reindexer;

	if ($ok_nouveau_statut) {
		calculer_rubriques();
		if ($statut_nouv == 'publie' AND $statut_ancien != $statut_nouv) {
			include_ecrire("inc_mail.php3");
			envoyer_mail_publication($id_article);
		}
		
	}

	
}



if ($statut_nouv) {
	if ($flag_auteur) {
	     //il faut etre admin et abonné pour modifer une liste
		if ($statut_nouv == 'liste' AND $statut_article == 'inact')
			$ok_nouveau_statut = true;
		else if ($statut_nouv == 'inact' AND $statut_article == 'poublist')
			$ok_nouveau_statut = true;
		else if ($statut_nouv == 'poublist' AND $statut_article == 'inact')
			$ok_nouveau_statut = true;
		else if ($statut_nouv == 'poublist' AND $statut_article == 'liste')
			$ok_nouveau_statut = true;
		else if ($statut_nouv == 'inact' AND $statut_article == 'liste')
			$ok_nouveau_statut = true;
		else if ($statut_nouv == 'liste' AND $statut_article == 'poublist')
			$ok_nouveau_statut = true;
	}
	if ($ok_nouveau_statut) {
		$query = "UPDATE spip_articles SET statut='$statut_nouv' WHERE id_article=$id_article";
		$result = spip_query($query);


	}
}

if ($jour && $flag_editable) {
	if ($annee == "0000") $mois = "00";
	if ($mois == "00") $jour = "00";
	$query = "UPDATE spip_articles SET date='$annee-$mois-$jour' WHERE id_article=$id_article";
	$result = spip_query($query);
	calculer_rubriques();
}

if ($jour_redac && $flag_editable) {
	if ($annee_redac<>'' AND $annee_redac < 1001) $annee_redac += 9000;

	if ($mois_redac == "00") $jour_redac = "00";

	if ($avec_redac=="non"){
		$annee_redac = '0000';
		$mois_redac = '00';
		$jour_redac = '00';
	}

	$query = "UPDATE spip_articles SET date_redac='$annee_redac-$mois_redac-$jour_redac' WHERE id_article=$id_article";
	$result = spip_query($query);
}


// Appliquer la modification de langue
if (lire_meta('multi_articles') == 'oui' AND $flag_editable) {
	$row = spip_fetch_array(spip_query("SELECT lang FROM spip_rubriques WHERE id_rubrique=$rubrique_article"));
	$langue_parent = $row['lang'];

	if ($changer_lang) {
		if ($changer_lang != "herit")
			spip_query("UPDATE spip_articles SET lang='".addslashes($changer_lang)."', langue_choisie='oui' WHERE id_article=$id_article");
		else
			spip_query("UPDATE spip_articles SET lang='".addslashes($langue_parent)."', langue_choisie='non' WHERE id_article=$id_article");
	}
}



//
// Reunit les textes decoupes parce que trop longs
//

$nb_texte = 0;
while ($nb_texte ++ < 100){		// 100 pour eviter une improbable boucle infinie
	$varname = "texte$nb_texte";
	$texte_plus = $$varname;	// double $ pour obtenir $texte1, $texte2...
	if ($texte_plus){
		$texte_plus = ereg_replace("<!--SPIP-->[\n\r]*","\n\n\n",$texte_plus);
		$texte_ajout .= " ".$texte_plus;
	} else {
		break;
	}
}
$texte = $texte_ajout . $texte;

//
// Traiter les fins de lignes
//
if ($post_autobr) {
	$chapo = post_autobr($chapo);
	$texte = post_autobr($texte);
}



if ($titre && !$ajout_forum && $flag_editable) {
	$surtitre = addslashes(corriger_caracteres($surtitre));
	$titre = addslashes(corriger_caracteres($titre));
	$soustitre = addslashes(corriger_caracteres($soustitre));
	$descriptif = addslashes(corriger_caracteres($descriptif));
	$nom_site = addslashes(corriger_caracteres($nom_site));
	$url_site = addslashes(corriger_caracteres($url_site));
	$chapo = addslashes(corriger_caracteres($chapo));
	$texte = addslashes(corriger_caracteres($texte));
	$ps = addslashes(corriger_caracteres($ps));


	// Verifier qu'on envoie bien dans une rubrique autorisee
	if ($flag_auteur OR acces_rubrique($id_rubrique)) {
		$change_rubrique = "id_rubrique=\"$id_rubrique\",";
	} else {
		$change_rubrique = "";
	}

	$query = "UPDATE spip_articles SET surtitre=\"$surtitre\", titre=\"$titre\", soustitre=\"$soustitre\", $change_rubrique descriptif=\"$descriptif\", chapo=\"$chapo\", texte=\"$texte\", ps=\"$ps\", url_site=\"$url_site\", nom_site=\"$nom_site\" $add_extra WHERE id_article=$id_article";
	$result = spip_query($query);
	calculer_rubriques();
	if ($statut_article == 'publie') $reindexer = true;
	
	

	// Changer la langue heritee
	if ($id_rubrique != $id_rubrique_old) {
		$row = spip_fetch_array(spip_query("SELECT lang, langue_choisie FROM spip_articles WHERE id_article=$id_article"));
		$langue_old = $row['lang'];
		$langue_choisie_old = $row['langue_choisie'];

		if ($langue_choisie_old != "oui") {
			$row = spip_fetch_array(spip_query("SELECT lang FROM spip_rubriques WHERE id_rubrique=$id_rubrique"));
			$langue_new = $row['lang'];
			if ($langue_new != $langue_old) spip_query("UPDATE spip_articles SET lang = '$langue_new' WHERE id_article = $id_article");
		}
	}

	// afficher le nouveau titre dans la barre de fenetre
	$titre_article = stripslashes($titre);

	// marquer l'article (important pour les articles nouvellement crees)
	spip_query("UPDATE spip_articles SET date_modif=NOW(), auteur_modif=$connect_id_auteur WHERE id_article=$id_article");
	$id_article_bloque = $id_article;   // message pour inc_presentation
}



//
// Suivi forums publics
//

if (!function_exists('get_forums_publics')) {

// fonction dupliquee dans inc-forum.php3
function get_forums_publics($id_article=0) {
	$forums_publics = lire_meta("forums_publics");
	if ($id_article) {
		$query = "SELECT accepter_forum FROM spip_articles WHERE id_article=$id_article";
		$res = spip_query($query);
		if ($obj = spip_fetch_object($res))
			$forums_publics = $obj->accepter_forum;
	} else { // dans ce contexte, inutile
		$forums_publics = substr(lire_meta("forums_publics"),0,3);
	}
	return $forums_publics;
}

}

//
// Lire l'article
//

$query = "SELECT * FROM spip_articles WHERE id_article='$id_article'";
$result = spip_query($query);

if ($row = spip_fetch_array($result)) {
	$id_article = $row["id_article"];
	$surtitre = $row["surtitre"];
	$titre = $row["titre"];
	$soustitre = $row["soustitre"];
	$id_rubrique = $row["id_rubrique"];
	$descriptif = $row["descriptif"];
	$nom_site = $row["nom_site"];
	$url_site = $row["url_site"];
	$chapo = $row["chapo"];
	$texte = $row["texte"];
	$ps = $row["ps"];
	$date = $row["date"];
	$statut_article = $row["statut"];
	$maj = $row["maj"];
	$date_redac = $row["date_redac"];
	$visites = $row["visites"];
	$referers = $row["referers"];
	$extra = $row["extra"];
	$id_trad = $row["id_trad"];
}



if (ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})", $date_redac, $regs)) {
        $mois_redac = $regs[2];
        $jour_redac = $regs[3];
        $annee_redac = $regs[1];
        if ($annee_redac > 4000) $annee_redac -= 9000;
}

if (ereg("([0-9]{4})-([0-9]{2})-([0-9]{2})", $date, $regs)) {
        $mois = $regs[2];
        $jour = $regs[3];
        $annee = $regs[1];
}





changer_typo('','article'.$id_article);


if (!function_exists('my_sel')) {

	function my_sel($num,$tex,$comp){
		if ($num==$comp){
			echo "<option value='$num' SELECTED>$tex\n";
		}else{
			echo "<option value='$num'>$tex\n";
		}
	
	}
	
	function afficher_mois($mois){
		my_sel("00",_T('mois_non_connu'),$mois);
		my_sel("01",_T('date_mois_1'),$mois);
		my_sel("02",_T('date_mois_2'),$mois);
		my_sel("03",_T('date_mois_3'),$mois);
		my_sel("04",_T('date_mois_4'),$mois);
		my_sel("05",_T('date_mois_5'),$mois);
		my_sel("06",_T('date_mois_6'),$mois);
		my_sel("07",_T('date_mois_7'),$mois);
		my_sel("08",_T('date_mois_8'),$mois);
		my_sel("09",_T('date_mois_9'),$mois);
		my_sel("10",_T('date_mois_10'),$mois);
		my_sel("11",_T('date_mois_11'),$mois);
		my_sel("12",_T('date_mois_12'),$mois);
	}
	
	function afficher_annee($annee){
		// Cette ligne permettrait de faire des articles sans date de publication
		// my_sel("0000","n.c.",$annee);
	
		if($annee<1996 AND $annee <> 0){
			echo "<option value='$annee' SELECTED>$annee\n";
		}
		for($i=1996;$i<date(Y)+2;$i++){
			my_sel($i,$i,$annee);
		}
	}
	
	function afficher_jour($jour){
		my_sel("00",_T('jour_non_connu_nc'),$jour);
		for($i=1;$i<32;$i++){
			if ($i<10){$aff="&nbsp;".$i;}else{$aff=$i;}
			my_sel($i,$aff,$jour);
		}
	}

}

// prendre en compte les modifs sur les extras
if($Valider_auto){

	// On récupère les extras
   $extra = get_extra($id_article, 'article');

          // Tient il n'y avait pas d'extra
          if (!is_array($extra)) {
          $extra = array();
          }

        if($auto == "oui"){
         $extra['auto'] = "oui" ;
         set_extra($id_article, $extra, 'article');
         }
         elseif($auto == "non"){
             $extra['auto'] = "non" ;
             set_extra($id_article, $extra, 'article');
             }

			 
		if($email_envoi){
         $extra = get_extra($id_article, 'article');
		 $extra['email_envoi'] = $email_envoi ;
         set_extra($id_article, $extra, 'article');
         }
         


   if(($changer_extra == "oui") AND ($auto == "oui") ){
	// On récupère les extras
        $extra = get_extra($id_article, 'article');

        // Tient il n'y avait pas d'extra
        if (!is_array($extra)) {
	$extra = array();
        }

      
      $extra['squelette'] = $patron ;
      $extra['periode'] = $periode ;
   
        
        if($envoyer_direct){
        $extra['majnouv'] = (time() - ($periode * 3600*24));
        //echo"<iframe src='../meleuse-cron.php3' height='1' width='1' frameborder='0' >Désolé</iframe>";
        }elseif(!$extra['majnouv']){
        $extra['majnouv'] = time();
        }
      set_extra($id_article, $extra, 'article');
      
      }
}
	include_ecrire("inc_extra.php3");
  /*echo "ap" ;
  $ex = get_extra($id_article, 'article');
  extra_affichage(serialize($ex), "articles"); */


debut_cadre_relief();
echo "<center>";

//
// Titre, surtitre, sous-titre
//

if($statut == 'liste') $couleur = 'publie';
if($statut == 'inact') $couleur = 'redac';
if($statut == 'poublist') $couleur = 'poubelle';

$logo_statut = "puce-".puce_statut("publie").".gif";

echo "\n<table cellpadding=0 cellspacing=0 border=0 width='100%'>";
echo "<tr width='100%'><td width='100%' valign='top'>";
if ($surtitre) {
	echo "<span $dir_lang><font face='arial,helvetica' size=3><b>";
	echo typo($surtitre);
	echo "</b></font></span>\n";
}
	gros_titre($titre, $logo_statut);

if ($soustitre) {
	echo "<span $dir_lang><font face='arial,helvetica' size=3><b>";
	echo typo($soustitre);
	echo "</b></font></span>\n";
}


if ($descriptif OR $url_site OR $nom_site) {
	echo "<p><div align='left' style='padding: 5px; border: 1px dashed #aaaaaa; background-color: #e4e4e4;' $dir_lang>";
	echo "<font size=2 face='Verdana,Arial,Sans,sans-serif'>";
	$texte_case = ($descriptif) ? "{{"._T('info_descriptif')."}} $descriptif\n\n" : '';
	$texte_case .= ($nom_site.$url_site) ? "{{"._T('info_urlref')."}} [".$nom_site."->".$url_site."]" : '';
	echo propre($texte_case);
	echo "</font>";
	echo "</div>";
}



echo "</td>";


if ($flag_editable) {
	echo "<td><img src='img_pack/rien.gif' width=5></td>\n";
	echo "<td align='center'>";
	$flag_modif = false;

	// Recuperer les donnees de l'article
	if (lire_meta('articles_modif') != 'non') {
		$query = "SELECT auteur_modif, UNIX_TIMESTAMP(date_modif) AS modification, UNIX_TIMESTAMP(NOW()) AS maintenant FROM spip_articles WHERE id_article='$id_article'";
		$result = spip_query($query);

		if ($row = spip_fetch_array($result)) {
			$auteur_modif = $row["auteur_modif"];
			$modification = $row["modification"];
			$maintenant = $row["maintenant"];

			$date_diff = floor(($maintenant - $modification)/60);

			if ($date_diff >= 0 AND $date_diff < 60 AND $auteur_modif > 0 AND $auteur_modif != $connect_id_auteur) {
				$flag_modif = true;
				$query_auteur = "SELECT nom FROM spip_auteurs WHERE id_auteur='$auteur_modif'";
				$result_auteur = spip_query($query_auteur);
				if ($row_auteur = spip_fetch_array($result_auteur)) {
					$nom_auteur_modif = typo($row_auteur["nom"]);
				}
			}
		}
	}
	if ($flag_modif) {
		icone(_T('spiplistes:modifier_liste'), "spip_listes.php3?mode=creer_liste&id_article=$id_article", "article-24.gif", "edit.gif");
		echo "<font face='arial,helvetica,sans-serif' size='2'>"._T('avis_article_modifie', array('nom_auteur_modif' => $nom_auteur_modif, 'date_diff' => $date_diff))."</font>";
		echo aide("artmodif");
	}
	else {
		icone(_T('spiplistes:modifier_liste'), "spip_listes.php3?mode=creer_liste&id_article=$id_article", "article-24.gif", "edit.gif");
	}

	echo "</td>";
}
echo "</tr></table>\n";



echo "<div class='serif' align='left'>";


//////////////////////////////////////////////////////
// Corps de l'article
//

echo "\n\n<div align='justify'>";

if ($virtuel) {
	debut_boite_info();
	echo _T('info_renvoi_article')." ".propre("<center>[->$virtuel]</center>");
	fin_boite_info();
}
else {
	echo "<div $dir_lang><b>";
	$revision_nbsp = $activer_revision_nbsp;
	echo justifier(propre($chapo));
	echo "</b></div>\n\n";

	echo "<div $dir_lang>";
	echo justifier(propre($texte));
	echo "</div>";

	if ($ps) {
		echo debut_cadre_enfonce();
		echo "<div $dir_lang><font size=2 face='Verdana,Arial,Sans,sans-serif'>";
		echo justifier("<b>"._T('info_ps')."</b> ".propre($ps));
		echo "</font></div>";
		echo fin_cadre_enfonce();
	}
	$revision_nbsp = false;

	if ($les_notes) {
		echo debut_cadre_relief();
		echo "<div $dir_lang><font size=2>";
		echo justifier("<b>"._T('info_notes')."&nbsp;:</b> ".$les_notes);
		echo "</font></div>";
		echo fin_cadre_relief();
	}

	if ($champs_extra AND $extra) {
		include_ecrire("inc_extra.php3");
		//extra_affichage($extra, "articles");
	}
}




//////////////////////////////////////////////////////
// Modifier le statut de l'article
//


?>
<script type='text/javascript'>
<!--
function change_bouton(selObj){

	var selection=selObj.options[selObj.selectedIndex].value;

	if (selection=="liste"){
		document.statut.src="img_pack/puce-verte.gif";
	}
	if (selection=="inact"){
		document.statut.src="img_pack/puce-blanche.gif";
	}

	if (selection=="poublist"){
		document.statut.src="img_pack/puce-poubelle.gif";
	}
}
// -->
</script>
<?php


if ($connect_statut == '0minirezo' ) {
	echo "<form action='spip_listes.php3' METHOD='get'>";
	debut_cadre_relief("racine-site-24.gif");
	echo "<CENTER>";
	
	echo "<input type='Hidden' name='mode' value='liste_edit'>";

        echo "<input type='Hidden' name='id_article' value=\"$id_article\">";

	echo "<b>"._T('spiplistes:Cette_liste_est').": </b> ";

	echo "<SELECT name='statut_nouv' size='1' class='fondl' onChange='change_bouton(this)'>";

	echo "<option" . mySel("inact", $statut_article) ." style='background-color: white'>"._T('spiplistes:statut_interne')."\n";
	echo "<option" . mySel("liste", $statut_article) . " style='background-color: #B4E8C5'>"._T('spiplistes:statut_publique')."\n";
	echo "<option" . mySel("poublist", $statut_article) . " style='background:url(img_pack/rayures-sup.gif)'>"._T('texte_statut_poubelle')."\n";

	echo "</SELECT>";

	echo " \n";

	if ($statut_article=='liste') {
		echo "<img src='img_pack/puce-verte.gif' alt='' width='13' height='14' border='0' name='statut'>";
	}
	else if ($statut_article=='inact') {
		echo "<img src='img_pack/puce-blanche.gif' alt='' width='13' height='14' border='0' name='statut'>";
	}

	else if ($statut_article == 'poublist') {
		echo "<img src='img_pack/puce-poubelle.gif' alt='' width='13' height='14' border='0' name='statut'>";
	}
	echo " \n";

	echo "<input type='submit' name='Modifier' value='"._T('bouton_modifier')."' class='fondo'>";
	echo aide ("artstatut");
	echo "</CENTER>";
	fin_cadre_relief();
	echo "</form>";
}

/*

//
// Langue de l'article
//
if ((lire_meta('multi_articles') == 'oui')
	OR ((lire_meta('multi_rubriques') == 'oui') AND (lire_meta('gerer_trad') == 'oui'))) {

	$row = spip_fetch_array(spip_query("SELECT lang, langue_choisie FROM spip_articles WHERE id_article=$id_article"));
	$langue_article = $row['lang'];
	$langue_choisie_article = $row['langue_choisie'];

	debut_cadre_enfonce('langues-24.gif');
	echo "<table border=0 cellspacing=0 cellpadding=3 width=100% background=''><tr><td bgcolor='#EEEECC' class='serif2'>";
	echo bouton_block_invisible('languesarticle,ne_plus_lier,lier_traductions');
	echo "<b>";
	if (lire_meta('gerer_trad') == 'oui')
		echo _T('titre_langue_trad_article');
	else
		echo "langue";

	echo "&nbsp; (".traduire_nom_langue($langue_article).")";

	echo "</b>";
	echo "</td></tr></table>";

	// Choix langue article
	if (lire_meta('multi_articles') == 'oui' AND $flag_editable) {
		echo debut_block_invisible('languesarticle');

		$row = spip_fetch_array(spip_query("SELECT lang FROM spip_rubriques WHERE id_rubrique=$id_rubrique"));
		$langue_parent = $row['lang'];

		if ($langue_choisie_article == 'oui') $herit = false;
		else $herit = true;

		//debut_cadre_enfonce();
		echo "<div style='padding: 5px; text-align: center;'><font face='Verdana,Arial,Sans,sans-serif' size='2'>";
		echo menu_langues('changer_lang', $langue_article, _T('info_multi_cet_article').' ', $langue_parent);
		echo "</font></div>\n";
		//fin_cadre_enfonce();

		echo fin_block();
	}


	fin_cadre_enfonce();
}

*/


echo "<p>" ;


/*  echo "av" ;
  $ex = get_extra($id_article, 'article');
  extra_affichage(serialize($ex), "articles"); */
//
// Activer/desactiver mails automatiques
//


debut_cadre_relief("reply-to-all-24.gif");
     
echo "<form action='spip_listes.php3?mode=liste_edit' METHOD='post'>";
		 
	// On récupère les extras
$extra = get_extra($id_article, 'article');

// Tient il n'y avait pas d'extra 
if (!is_array($extra)) {
	$extra = array();
}

$email_envoi = entites_html(lire_meta("email_envoi"));
$email_envoi = ($extra['email_envoi'] !='') ? $extra['email_envoi'] : $email_envoi ;
		
		echo "<b><font face='Verdana,Arial,Sans,sans-serif' size=3 COLOR='#000000'>";
		echo _T('spiplistes:retour')."</font></b><br />";

		echo "<p>"._T('spiplistes:adresse')."</p>";
		echo "<input type='text' name='email_envoi' value=\"".$email_envoi."\" size='20' class='fondl'>&nbsp;";
		
	
	if($id_article)
	echo "<input type='hidden' name='id_article' value='$id_article'>";
	if($new)
	echo "<input type='hidden' name='new' value='$new'>";
	echo "<input type='submit' name='Valider_auto' value='"._T('bouton_valider')."' class='fondo'>";
	
	
	echo "</form>";

fin_cadre_relief();

debut_cadre_relief("stock_timer.gif");
     
echo "<form action='spip_listes.php3?mode=liste_edit' METHOD='post'>";
		 
	// On récupère les extras
$extra = get_extra($id_article, 'article');

// Tient il n'y avait pas d'extra 
if (!is_array($extra)) {
	$extra = array();
}

echo "</h3>"._T('spiplistes:program')."<h3>";
   

echo "<table border=0 cellspacing=1 cellpadding=3 width=\"100%\">";
	
echo "<tr><td background='img_pack/rien.gif' align='$spip_lang_left' class='verdana2'>";
if ($extra['auto'] != "oui") {
echo _T('spiplistes:non_program');
}
else {
     if(($changer_extra == "oui") AND ($auto == "oui") )
     echo "<h2>"._T('spiplistes:date_act')."</h2>" ;
     echo _T('spiplistes:env_esquel')." <em>".$extra['squelette']."</em> " ;
	
				
    echo _T('spiplistes:Tous_les')."  <b>".$extra['periode']."</b>  "._T('info_jours') ;
	
    $dernier_envoi =  $extra['majnouv'];
                 $periode= $extra['periode'];

            $sablier = (time() - $dernier_envoi) ;
           $proch = round(  (( (24*3600*$periode) - $sablier) / (3600*24)) ) ;
            if($proch != 0) {
            echo "<br />"._T('spiplistes:prochain_envoi_prevu')."<b>$proch</b> "._T('spiplistes:jours')."<br />";
            }
            else {
                 	echo "<br />"._T('spiplistes:prochain_envoi_aujd')."<br />";
            }

}
		


  

echo "</td></tr>";


echo "<tr><td background='img_pack/rien.gif' align='$spip_lang_left' class='verdana2'>";
	
        
        if ($extra['auto'] != "oui") {
		echo "<input type='radio' name='auto' value='oui' id='auto_oui'>";
		echo " <label for='auto_oui'>"._T('spiplistes:prog_env')."</label> ";
		echo "<br /><input type='radio' name='auto' value='non' CHECKED id='auto_non'>";
		echo " <b><label for='auto_non'>"._T('spiplistes:prog_env_non')."</label></b> ";
		
	}
	else {
		echo "<input type='radio' name='auto' value='oui' id='auto_oui' CHECKED>";
		echo " <b><label for='auto_oui'>"._T('spiplistes:prog_env')."</label></b> ";
		echo "<input type='hidden' name='changer_extra' value='oui'>";
		echo "<p>";
		
		echo "<ul>";
                echo "<li>"._T('spiplistes:squel');
		
		$dir = "../patrons/";

		// Ouvre un dossier bien connu, et liste tous les fichiers
		if (is_dir($dir)) {
    		if ($dh = opendir($dir)) {
        		$total_option=0;
		while (($file = readdir($dh)) !== false) {
                if($file != '..' && $file !='.' && $file !='') $total_option=$total_option+1;
        	}
        	closedir($dh);
		}
				if ($dh = opendir($dir)) {
        		//echo "<SELECT name='patron' size='".$total_option."'>";
			echo "<SELECT name='patron'>";
			while (($file = readdir($dh)) !== false) {
               		 if($file != '..' && $file !='.' && $file !=''){
			$titre_option=ereg_replace('(\.html|\.HTML)','',$file);
			 ($extra['squelette'] == $titre_option) ? $selected = "SELECTED" : $selected ="" ;

                        echo "<option ".$selected." value='".$titre_option."'>".$titre_option."</OPTION>";
			}
					}
				echo "</SELECT>";
        		closedir($dh);
   		  		}
		}
		
		echo "</li>";
		
		

		echo "<li>"._T('spiplistes:Tous_les')." <input type='text' name='periode' value='".$extra['periode']."' size='4' class='fondl'> "._T('info_jours')."</li>" ;
	
        	if(!$envoyer_direct){
                echo " <li><input type='checkbox' class='checkbox' name='envoyer_direct' id='box' class='fondl' /><label for='box'>"._T('spiplistes:env_maint')."</label></li>";

                }

		echo "</ul><br />";
	
		
		echo "<br /><input type='radio' name='auto' value='non' id='auto_non'>";
		echo " <label for='auto_non'>"._T('spiplistes:prog_env_non')."</label> ";

	}
	echo "</td></tr>\n";
	
	echo "<tr><td style='text-align:$spip_lang_right;'>";
	if($id_article)
	echo "<input type='hidden' name='id_article' value='$id_article'>";
	if($new)
	echo "<input type='hidden' name='new' value='$new'>";
	echo "<input type='submit' name='Valider_auto' value='"._T('bouton_valider')."' class='fondo'>";
	echo "</td></tr>";
	echo "</table>\n";
	
	echo "</FORM>";
		


fin_cadre_relief();


 /*   $ex = get_extra($id_article, 'article');
 extra_affichage(serialize($ex), "articles");*/



//
// Liste des auteurs de l'article
//

echo "<a name='auteurs'></a>";


if ($flag_editable AND $options == 'avancees') {
	$bouton = bouton_block_invisible("auteursarticle");
}

debut_cadre_enfonce("auteur-24.gif", false, "", $bouton._T('spiplistes:abon').aide ("artauteurs"));



////////////////////////////////////////////////////
// Gestion des auteurs
//

// Creer un nouvel auteur et l'ajouter

if ($creer_auteur AND $connect_statut=='0minirezo'){
	$creer_auteur = addslashes($creer_auteur);
	$query_creer = "INSERT INTO spip_auteurs (nom, statut) VALUES (\"$creer_auteur\", '1comite')";
	$result_creer = spip_query($query_creer);

	$nouv_auteur = spip_insert_id();
	$ajout_auteur = true;
}


//
// Recherche d'auteur
//

if ($cherche_auteur) {
	echo "<p align='left'>";
	$query = "SELECT id_auteur, nom FROM spip_auteurs";
	$result = spip_query($query);
	unset($table_auteurs);
	unset($table_ids);
	while ($row = spip_fetch_array($result)) {
		$table_auteurs[] = $row["nom"];
		$table_ids[] = $row["id_auteur"];
	}
	$resultat = mots_ressemblants($cherche_auteur, $table_auteurs, $table_ids);
	debut_boite_info();
	if (!$resultat) {
		echo "<b>"._T('texte_aucun_resultat_auteur', array('cherche_auteur' => $cherche_auteur)).".</b><br />";
	}
	else if (count($resultat) == 1) {
		$ajout_auteur = 'oui';
		list(, $nouv_auteur) = each($resultat);
		echo "<b>"._T('spiplistes:nouvelle_abonne')."</b><br />";
		$query = "SELECT * FROM spip_auteurs WHERE id_auteur=$nouv_auteur";
		$result = spip_query($query);
		echo "<ul>";
		while ($row = spip_fetch_array($result)) {
			$id_auteur = $row['id_auteur'];
			$nom_auteur = $row['nom'];
			$email_auteur = $row['email'];
			$bio_auteur = $row['bio'];

			echo "<li><font face='Verdana,Arial,Sans,sans-serif' size=2><b><font size=3>".typo($nom_auteur)."</font></b>";
			echo "</font>\n";
		}
		echo "</ul>";
	}
	else if (count($resultat) < 16) {
		reset($resultat);
		unset($les_auteurs);
		while (list(, $id_auteur) = each($resultat)) $les_auteurs[] = $id_auteur;
		if ($les_auteurs) {
			$les_auteurs = join(',', $les_auteurs);
			echo "<b>"._T('texte_plusieurs_articles', array('cherche_auteur' => $cherche_auteur))."</b><br />";
			$query = "SELECT * FROM spip_auteurs WHERE id_auteur IN ($les_auteurs) ORDER BY nom";
			$result = spip_query($query);
			echo "<ul>";
			while ($row = spip_fetch_array($result)) {
				$id_auteur = $row['id_auteur'];
				$nom_auteur = $row['nom'];
				$email_auteur = $row['email'];
				$bio_auteur = $row['bio'];

				echo "<li><font face='Verdana,Arial,Sans,sans-serif' size=2><b><font size=3>".typo($nom_auteur)."</font></b>";

				if ($email_auteur) echo " ($email_auteur)";
				echo " | <a href=\"spip_listes.php3?mode=liste_edit&id_article=$id_article&ajout_auteur=oui&nouv_auteur=$id_auteur#auteurs\">"._T('lien_ajouter_auteur')."</a>";

				if (trim($bio_auteur)) {
					echo "<br /><font size=1>".couper(propre($bio_auteur), 100)."</font>\n";
				}
				echo "</font><p>\n";
			}
			echo "</ul>";
		}
	}
	else {
		echo "<b>"._T('texte_trop_resultats_auteurs', array('cherche_auteur' => $cherche_auteur))."</b><br />";
	}

	

	fin_boite_info();
	echo "<p>";

}



//
// Appliquer les modifications sur les auteurs
//

if ($ajout_auteur && $flag_editable) {
	if ($nouv_auteur > 0) {
		$query="DELETE FROM spip_auteurs_articles WHERE id_auteur='$nouv_auteur' AND id_article='$id_article'";
		$result=spip_query($query);
		$query="INSERT INTO spip_auteurs_articles (id_auteur,id_article) VALUES ('$nouv_auteur','$id_article')";
		$result=spip_query($query);
	}

	if (lire_meta('activer_moteur') == 'oui') {
		include_ecrire ("inc_index.php3");
		indexer_article($id_article);
	}
}

if ($supp_auteur && $flag_editable) {
	$query="DELETE FROM spip_auteurs_articles WHERE id_auteur='$supp_auteur' AND id_article='$id_article'";
	$result=spip_query($query);
	if (lire_meta('activer_moteur') == 'oui') {
		include_ecrire ("inc_index.php3");
		indexer_article($id_article);
	}
}


//
// Afficher les auteurs
//

unset($les_auteurs);

$query = "SELECT * FROM spip_auteurs AS auteurs, spip_auteurs_articles AS lien ".
	"WHERE auteurs.id_auteur=lien.id_auteur AND lien.id_article=$id_article ".
	"GROUP BY auteurs.id_auteur ORDER BY auteurs.nom";
$result = spip_query($query);

if (spip_num_rows($result)) {
	echo "<div class='liste'>";
	echo "<table width='100%' cellpadding='3' cellspacing='0' border='0' background=''>";
	$table = '';
	while ($row = spip_fetch_array($result)) {
		$vals = '';
		$id_auteur = $row["id_auteur"];
		$nom_auteur = $row["nom"];
		$email_auteur = $row["email"];
		if ($bio_auteur = attribut_html(propre(couper($row["bio"], 100))))
			$bio_auteur = " TITLE=\"$bio_auteur\"";
		$url_site_auteur = $row["url_site"];
		$statut_auteur = $row["statut"];
		if ($row['messagerie'] == 'non' OR $row['login'] == '') $messagerie = 'non';

		$les_auteurs[] = $id_auteur;

		if ($connect_statut == "0minirezo") $aff_articles = "('prepa', 'prop', 'publie', 'refuse')";
		else $aff_articles = "('prop', 'publie')";

		$query2 = "SELECT COUNT(articles.id_article) AS compteur ".
			"FROM spip_auteurs_articles AS lien, spip_articles AS articles ".
			"WHERE lien.id_auteur=$id_auteur AND articles.id_article=lien.id_article ".
			"AND articles.statut IN $aff_articles GROUP BY lien.id_auteur";
		$result2 = spip_query($query2);
		if ($result2) list($nombre_articles) = spip_fetch_array($result2);
		else $nombre_articles = 0;

		$url_auteur = "spip_listes.php3?mode=abonne&id_auteur=$id_auteur";

		$vals[] = bonhomme_statut($row);

		$vals[] = "<a href=\"$url_auteur\"$bio_auteur>".typo($nom_auteur)."</a>";

		$vals[] = bouton_imessage($id_auteur);

		
		
		if ($email_auteur) $vals[] =  "<a href='mailto:$email_auteur'>"._T('email')."</a>";
		else $vals[] =  "&nbsp;";

		if ($url_site_auteur) $vals[] =  "<a href='$url_site_auteur'>"._T('info_site_min')."</a>";
		else $vals[] =  "&nbsp;";

		if ($nombre_articles > 1) $vals[] =  $nombre_articles.' '._T('info_article_2');
		else if ($nombre_articles == 1) $vals[] =  _T('info_1_article');
		else $vals[] =  "&nbsp;";

		if ($flag_editable AND ($connect_id_auteur != $id_auteur OR $connect_statut == '0minirezo') AND $options == 'avancees') {
			$vals[] =  "<a href='spip_listes.php3?mode=liste_edit&id_article=$id_article&supp_auteur=$id_auteur#auteurs'>Désabonnement&nbsp;<img src='img_pack/croix-rouge.gif' alt='X' width='7' height='7' border='0' align='middle'></a>";
		} else {
			$vals[] = "";
		}
		
		$table[] = $vals;
	}
	
	
	$largeurs = array('14', '', '', '', '', '', '');
	$styles = array('arial11', 'arial2', 'arial11', 'arial11', 'arial11', 'arial11', 'arial1');
	afficher_liste($largeurs, $table, $styles);

	
	echo "</table></div>\n";

	$les_auteurs = join(',', $les_auteurs);
}


//
// Ajouter un auteur
//

if ($flag_editable AND $options == 'avancees') {
	//echo debut_block_invisible("auteursarticle");

	$query = "SELECT * FROM spip_auteurs WHERE ";
	if ($les_auteurs) $query .= "id_auteur NOT IN ($les_auteurs) AND ";
	$query .= "statut!='5poubelle' AND statut!='nouveau' ORDER BY statut, nom";
	$result = spip_query($query);
	
	echo "<table width='100%'>";
	echo "<tr>";

	echo "<td>";
	
	
	if (spip_num_rows($result) > 0) {
		echo "<form action='spip_listes.php3?mode=liste_edit&id_article=$id_article#auteurs' METHOD='post'>";
		echo "<span class='verdana1'><b>"._T('spiplistes:abon_ajouter')."</b></span>\n";
		echo "<div><input type='Hidden' name='id_article' value=\"$id_article\">";

		if (spip_num_rows($result) > 80 AND $flag_mots_ressemblants) {
			echo "<input type='text' name='cherche_auteur' onClick=\"setvisibility('valider_ajouter_auteur','visible');\" class='fondl' value='' size='20'>";
			echo "<span  class='visible_au_chargement' id='valider_ajouter_auteur'>";
			echo " <input type='submit' name='Chercher' value='"._T('bouton_chercher')."' class='fondo'>";
			echo "</span>";
		}
		else {
			echo "<input type='Hidden' name='ajout_auteur' value='oui'>";
			echo "<SELECT name='nouv_auteur' size='1' STYLE='width:150px;' class='fondl' onChange=\"setvisibility('valider_ajouter_auteur','visible');\">";
			$group = false;
			$group2 = false;

			while ($row = spip_fetch_array($result)) {
				$id_auteur = $row["id_auteur"];
				$nom = $row["nom"];
				$email = $row["email"];
				$statut = $row["statut"];

				$statut=ereg_replace("0minirezo", _T('info_administrateurs'), $statut);
				$statut=ereg_replace("1comite", _T('info_redacteurs'), $statut);
				$statut=ereg_replace("2redac", _T('info_redacteurs'), $statut);

				$premiere = strtoupper(substr(trim($nom), 0, 1));

				if ($connect_statut != '0minirezo')
					if ($p = strpos($email, '@'))
						$email = substr($email, 0, $p).'@...';
				if ($email)
					$email = " ($email)";

				if ($statut != $statut_old) {
					echo "\n<option value=\"x\">";
					echo "\n<option value=\"x\"> $statut";
				}

				if ($premiere != $premiere_old AND ($statut != _T('info_administrateurs') OR !$premiere_old)) {
					echo "\n<option value=\"x\">";
				}

				$texte_option = supprimer_tags(couper("$nom$email", 40));
				echo "\n<option value=\"$id_auteur\">&nbsp;&nbsp;&nbsp;&nbsp;$texte_option";
				$statut_old = $statut;
				$premiere_old = $premiere;
			}

			echo "</SELECT>";
			echo "<span  class='visible_au_chargement' id='valider_ajouter_auteur'>";
			echo " <input type='submit' name='Ajouter' value="._T('bouton_ajouter')." class='fondo'>";
			echo "</span>";
		}
		echo "</div></FORM>";
	}
	
	echo "</td></tr></table>";


//	echo fin_block();
}

fin_cadre_enfonce(false);



//////////////////////////////////////////////////////
// Liste des mots-cles de l'article
//

if ($options == 'avancees' AND $articles_mots != 'non') {
	//formulaire_mots('articles', $id_article, '' , '' ,false,true);
}







//
// Bouton "modifier cet article"
//

if ($flag_editable) {
	echo "\n\n<div align=right><br />";
	
	if ($date_diff >= 0 AND $date_diff < 60 AND $auteur_modif > 0 AND $auteur_modif != $connect_id_auteur) {
		$query_auteur = "SELECT * FROM spip_auteurs WHERE id_auteur='$auteur_modif'";
		$result_auteur = spip_query($query_auteur);
		while ($row_auteur = spip_fetch_array($result_auteur)) {
			$nom_auteur_modif = typo($row_auteur["nom"]);
		}
		icone(_T('icone_modifier_article'), "spip_listes.php3?mode=creer_liste&id_article=$id_article", "warning-24.gif", "");
		echo "<font face='arial,helvetica,sans-serif' size=1>"._T('texte_travail_article', array('nom_auteur_modif' => $nom_auteur_modif, 'date_diff' => $date_diff))."</font>";
		echo aide("artmodif");
	}
	else {
		icone(_T('spiplistes:modifier_liste'), "spip_listes.php3?mode=creer_liste&id_article=$id_article", "article-24.gif", "edit.gif");
	}
	
	echo "</div>";
}


echo "</div>";


fin_cadre_relief();

//
// Forums
//

echo "<br /><br />";

$forum_retour = urlencode("articles.php3?id_article=$id_article");


echo "\n<div align='center'>";
	icone(_T('icone_poster_message'), "forum_envoi.php3?statut=prive&adresse_retour=".$forum_retour."&id_article=$id_article&titre_message=".urlencode($titre), "forum-interne-24.gif", "creer.gif");
echo "</div>";

echo "<p align='left'>";


$query_forum = "SELECT COUNT(*) AS cnt FROM spip_forum WHERE statut='prive' AND id_article='$id_article' AND id_parent=0";
$result_forum = spip_query($query_forum);
$total = 0;
if ($row = spip_fetch_array($result_forum)) $total = $row["cnt"];

if (!$debut) $debut = 0;
$total_afficher = 8;
if ($total > $total_afficher) {
	echo "<div class='serif2' align='center'>";
	for ($i = 0; $i < $total; $i = $i + $total_afficher){
		$y = $i + $total_afficher - 1;
		if ($i == $debut)
			echo "<font size=3><b>[$i-$y]</b></font> ";
		else
			echo "[<a href='articles.php3?id_article=$id_article&debut=$i'>$i-$y</a>] ";
	}
	echo "</div>";
}



$query_forum = "SELECT * FROM spip_forum WHERE statut='prive' AND id_article='$id_article' AND id_parent=0 ORDER BY date_heure DESC LIMIT $debut,$total_afficher";
$result_forum = spip_query($query_forum);
afficher_forum($result_forum, $forum_retour);


if (!$debut) $debut = 0;
$total_afficher = 8;
if ($total > $total_afficher) {
	echo "<div class='serif2' align='center'>";
	for ($i = 0; $i < $total; $i = $i + $total_afficher){
		$y = $i + $total_afficher - 1;
		if ($i == $debut)
			echo "<font size=3><b>[$i-$y]</b></font> ";
		else
			echo "[<a href='articles.php3?id_article=$id_article&debut=$i'>$i-$y</a>] ";
	}
	echo "</div>";
}


echo "</div>\n";




if ($ok_nouveau_statut || $reindexer) {
	@flush();
	terminer_changement_statut();
}






////
}


// afficher les listes

if ($mode == "listes"){


global $table_prefix;
$query_message = "SELECT * FROM ".$table_prefix."_articles AS listes LEFT JOIN ".$table_prefix."_auteurs_articles AS abonnements USING (id_article) WHERE statut='liste'";

$result_pile = spip_query($query_message);
$nb_abonnes = spip_num_rows($result_pile);
		
$query = "SELECT id_auteur, nom, extra FROM spip_auteurs";
$result = spip_query($query);
$nb_inscrits = spip_num_rows($result);

	$cmpt_texte = 0;
	$cmpt_html = 0;
	$cmpt_non = 0;
       
	   while ($row = spip_fetch_array($result)) {
		
                $abo = get_extra($row["id_auteur"],auteur);

                        if ($abo['abo'] == "texte"){
                        $cmpt_texte = $cmpt_texte + 1 ;
                        }

                        if ($abo['abo'] == "html"){
                        $cmpt_html = $cmpt_html + 1 ;
                        }
                        
                        if ($abo['abo'] == "non"){
                        $cmpt_non = $cmpt_non + 1 ;
                        }
                        
                        $total_abo = $cmpt_html + $cmpt_texte ;
	}


debut_cadre_relief('forum-interne-24.gif');

echo _T('spiplistes:nb_abonnes')."$nb_abonnes<p>";
echo "<p>";
fin_cadre_relief();

echo "<p>";

//
// Afficher tableau de listes
//


//
// lettres d'infos
//
 afficher_articles_listes(_T('spiplistes:listes_internes'),
        "WHERE articles.statut=\"inact\"  ORDER BY articles.date DESC");


echo "<p>";

afficher_articles_listes(_T('spiplistes:liste_diff_publiques'),
	"WHERE articles.statut=\"liste\"  ORDER BY articles.date DESC");

echo "<p>";
echo "<p>";

afficher_articles_listes(_T('spiplistes:listes_poubelle'),
	"WHERE articles.statut=\"poublist\"  ORDER BY articles.date DESC");
}




If ($mode == "config"){


$accepter_visiteurs = lire_meta('accepter_visiteurs');

if($accepter_visiteurs != 'oui'){
$accepter_visiteurs = 'oui';
ecrire_meta("accepter_visiteurs", $accepter_visiteurs);
ecrire_metas();
echo _T('spiplistes:autorisation_inscription');
}

$extra = get_extra(1,'auteur');
$deb = $extra['debut'] ;
//echo "<h1>$deb</h1>";
if( !is_array($extra) ){
        $extra = array();
        $extra["config"] = "simple";
        set_extra(1,$extra,'auteur');
        $extra = get_extra(1,'auteur');
        }
if( !$extra['config']) {
        $extra["config"] = "simple";
        set_extra(1,$extra,'auteur');
        $extra = get_extra(1,'auteur');
        }


if ($changer_config == 'oui') {
$extra['config'] = $statut_abo ;
set_extra(1,$extra,'auteur');
$extra = get_extra(1,'auteur');
}

$config = $extra['config'];



echo "<form action='spip_listes.php3?mode=config' method='post'>";
echo "<input type='hidden' name='changer_config' value='oui'>";
 
  debut_cadre_relief("redacteurs-24.gif", false, "", _T('spiplistes:mode_inscription'));

	echo "<table border=0 cellspacing=1 cellpadding=3 width=\"100%\">";

	echo "<tr><td background='img_pack/rien.gif' class='verdana2'>";
	  if($spip_version < 1.8 ){
                echo "<h3>"._T('spiplistes:mode_inscription')."</h3>" ;
          }
	 $texte1 = '' ;
	 $texte2 = '' ;
        ($config == 'simple' ) ? $texte1 = "checked"  : $texte2 = "checked" ;

    echo "<input type='radio' name='statut_abo' value='simple' $texte1 id='statut_simple'>";
	echo "<label for='statut_simple'>"._T('spiplistes:abonnement_simple')."</label> ";
	echo "<p><input type='radio' name='statut_abo' value='membre' $texte2 id='statut_membre'>";
	echo "<label for='statut_membre'>"._T('spiplistes:abonnement_code_acces')."</label></b> ";



	echo "</td></tr>";





	echo "<tr><td style='text-align:$spip_lang_right;'>";
	echo "<input type='submit' name='Valider' value='"._T('bouton_valider')."' class='fondo'>";
	echo "</td></tr>";
	echo "</table>\n";


         echo "</form>";
 	

	fin_cadre_relief();
	
	debut_cadre_relief("redacteurs-24.gif", false, "", _T('spiplistes:tableau_bord'));
	$meta = get_extra(1,"auteur");
	//print_r($meta);
	
	echo "<br />"._T('spiplistes:lock').$meta['locked'] ;
	echo "<br />"._T('spiplistes:mail_a_envoyer').$meta['total_auteurs'] ;
	echo "<br />"._T('spiplistes:mail_tache_courante'). $meta['debut'] ;
	

	
	fin_cadre_relief();


               ////////import



    function test_login2($mail) {
	if (strpos($mail, "@") > 0) $login_base = substr($mail, 0, strpos($mail, "@"));
	else $login_base = $mail;

	$login_base = strtolower($login_base);
	$login_base = ereg_replace("[^a-zA-Z0-9]", "", $login_base);
	if (!$login_base) $login_base = "user";

	for ($i = 0; ; $i++) {
		if ($i) $login = $login_base.$i;
		else $login = $login_base;
		$query = "SELECT id_auteur FROM spip_auteurs WHERE login='$login'";
		$result = spip_query($query);
		if (!spip_num_rows($result)) break;
	}

	return $login;
}






 $format = $GLOBALS['suppl_abo'];



//print_r($list_abo);
//echo $format."<br /><br /><br />";




         ////////// formulaire

         debut_cadre_relief("redacteurs-24.gif", false, "", _T('spiplistes:importer'));

	echo "<table border=0 cellspacing=1 cellpadding=3 width=\"100%\">";

	echo "<tr><td background='img_pack/rien.gif' class='verdana2'>";
	
	 switch ($etape) {
	    case "2" :
        {
			
			
			if (!$insert_file) $insert_file = $_FILES["insert_file"]["tmp_name"] ;
			
			if ($insert_file && $insert_file != "none") {
			if(!file_exists("./temp"))
			mkdir("./temp",0777);
			else 
			chmod("./temp",0777);

			$import_file = "./temp/import.txt";
				if(move_uploaded_file($insert_file,$import_file ))
				{
				//	   if(ereg("^php[0-9A-Za-z_.-]+$", basename($insert_file)))
				if(!empty($insert_file) && $insert_file != "none" && ereg("^php[0-9A-Za-z_.-]+$", basename($insert_file)))
				$liste = fread(fopen($import_file, "r"), filesize($import_file)); //pour NS et IE
		 
				$liste=ereg_replace("\n|\r|\n\r|\r\n|\n\n","\n",$liste);
				$liste = explode( "\n",$liste);
		 
					for($i=0;$i<sizeof($liste); $i++)
					{

					/* Ajouter un nouvel enregistrement dans la table */
					$liste[$i]=trim($liste[$i]);
						if(!empty($liste[$i])){
		       		     
						// Inscription
						// Ajouter un code pour retrouver l'abonné
                        
                        $mail_inscription = $liste[$i] ;
						$ligne_nb = ($i+1) ;

                           if(email_valide_bloog($mail_inscription)){
                           echo $mail_inscription."<br />" ;
                           $pass = creer_pass_aleatoire(8, $mail_inscription);
						   $nom_inscription = test_login2($mail_inscription);
                              
                           $login = test_login2($mail_inscription);
      		               $mdpass = md5($pass);
      		               $htpass = generer_htpass($pass);
                           $statut = "6forum" ;
                           $cookie = creer_uniqid();
      
                           $extras = bloog_extra_recup_saisie('auteurs');

                           $query = "SELECT * FROM spip_auteurs WHERE email='$mail_inscription'";
						   $resulta = spip_query($query);
                                
								if ($row = spip_fetch_array($resulta)) {
                                $nom = $row['nom'] ;
                                $mail = $row['email'] ;
                                //echo " Le fichier d'import présente une erreur à la ligne $ligne_nb <br />" ;
								echo _T('spiplistes:adresse_deja_inclus')."<br /><br />" ;
                                 } else {
                                 
								 // echo "$nom_inscription <br />$mail_inscription<br />$format";
                              	$query = "INSERT INTO spip_auteurs (nom, email, login, pass, statut, htpass, extra, cookie_oubli) ".
                        		"VALUES ('$nom_inscription', '$mail_inscription', '$login', '$mdpass', '$statut', '$htpass', '$extras', '$cookie')";
                        		spip_query($query);
								}
                                                       
                                // Inscription aux listes
                                // abonnement aux listes http://www.phpfrance.com/tutorials/index.php?page=2&id=13
                        
                                $query = "SELECT * FROM spip_auteurs WHERE email='$mail_inscription'";
                        		$resu = spip_query($query);
                        
									// l'abonne existe deja.
									if ($row = spip_fetch_array($resu)) {
									$id_auteur = $row['id_auteur'];
									$statut = $row['statut'];
									$nom = $row['nom'];
	
									// on abonne l'auteur aux listes
									
										if(is_array($list_abo)){
											reset($list_abo);
											while( list(,$val) = each($list_abo) ){
												 //echo "<h2>$nom :liste $val </h2>" ;
												 $query="DELETE FROM spip_auteurs_articles WHERE id_auteur='$id_auteur' AND id_article='$val'";
												 $result=spip_query($query);
												 $query="INSERT INTO spip_auteurs_articles (id_auteur,id_article) VALUES ('$id_auteur','$val')";
												 $result=spip_query($query);
											}
								  
										 }
									}
                        
								//
                        
						                             
                          
							}else{
                              	echo " "._T('spiplistes:erreur_import')." <br />" ;
                             echo $liste[$i]." : <br /><br /> ";
                            }//email valide


                        
                        }  //listei
                     
                     
                     }  // for


		 unlink($import_file);
		 echo "<br /><br /><center><b>"._T('spiplistes:adresses_importées')."</b></center>";
	       }// move et file

	   } // insert
	   else echo "<br /><br /><center><b>"._T('spiplistes:erreur')."</b></center>";





             	 echo  "<a href='spip_listes.php3?mode=config'>["._T('spiplistes:retour_link')."]</a>";

             }
            break ;
            
            default :
         if($spip_version < 1.8 ){
                echo "<h3>"._T('spiplistes:importer')."</h3>" ;
          }
         echo _T('spiplistes:importer_fichier_txt')."<center><div>";

  $list = spip_query ("SELECT * FROM spip_articles WHERE statut = 'liste' OR statut = 'inact' ");
  $nb_listes = spip_num_rows($list);
  if($nb_listes == 0){
	echo "<fieldset> ";
	echo "<legend>"._T('spiplistes:abonnement_newsletter')."</legend>";
 echo _T('spiplistes:importer_preciser');
	   echo "<form action='$PHP_SELF?etape=2' method='post'  enctype='multipart/form-data' name='importform'> ";
        echo  "<div style='float:right'>";
        //include('ecrire/inc_extra.php3');
	bloog_extra_saisie('', 'auteurs', 'inscription');
	echo  "</div>";
        }
  elseif($nb_listes == 1){
        echo "<fieldset> ";
	echo "<legend>"._T('spiplistes:abonnement_newsletter')."</legend>";
        echo _T('spiplistes:importer_preciser');
		echo "<form action='$PHP_SELF?etape=2' method='post'  enctype='multipart/form-data' name='importform'> ";
       	echo  "<div style='float:right'>";
	//include('ecrire/inc_extra.php3');
	bloog_extra_saisie('', 'auteurs', 'inscription');
	echo  "</div>";

        echo "<ul style='width:350px'>" ;
                	while($row = spip_fetch_array($list)) {
                
                	echo "<li>" ;
                	$id_article = $row['id_article'] ;
                	$titre = $row['titre'] ;
                	echo "<a href='?liste=$id_article' title='"._T('spiplistes:infos_liste')."'>$titre</a>&nbsp;&nbsp;&nbsp;<input type=\"checkbox\" name=\"list_abo[]\" CHECKED  value=\"".$id_article."\">" ;
                        echo "</li>" ;
                	}
	echo "</ul>" ;
        }
			
  else{
  
  echo "<fieldset> ";
  echo "<legend>"._T('spiplistes:abonnement_newsletter')."</legend>";
  echo _T('spiplistes:importer_preciser');
  echo "<div style='width:350px'>" ;
  echo "<form action='$PHP_SELF?etape=2' method='post' enctype='multipart/form-data'  name='importform'> ";
  echo  "<div style='float:right'>";
  //include('ecrire/inc_extra.php3');
  bloog_extra_saisie('', 'auteurs', 'inscription');
  echo  "</div>";

                        while($row = spip_fetch_array($list)) {
					
			echo "<div style='padding:0px 0px 6px 15px'>" ;
			$id_article = $row['id_article'] ;
			$titre = $row['titre'] ;
			echo "<div style='float:right'><input type=\"checkbox\" name=\"list_abo[]\"   value=\"".$id_article."\"></div>" ;
                        echo "<img src='./ecrire/img_pack/puceoff.gif' height='10px'>&nbsp;<a href='?liste=$id_article' title='informations sur cette liste'>$titre</a><br />" ;
			echo "</div>" ;

                        }


} // fin du test nb listes


   echo '<!--
  <script language=\"javascript\">
  function Soumettre()
			{
			//if  (document.importform.insert_file.value==\"\")
	        //alert(\"Tous les champs doivent être remplis\");  
			//else
  document.importform.fich.value=document.importform.insert_file.value;
  document.importform.submit();
			 }
  </script>
   --> ';

 echo "<h5>"._T('spiplistes:importer_fichier')."</h5>";
  echo "<input type=file name=\"insert_file\"><br /><br />";
  echo "<input type=\"hidden\" name=\"mode\" value=\"config\">";
  echo "<input type=\"hidden\" name=\"import\" value=\"oui\">";


   echo "</div>" ;
   echo "<input type='submit' name='Valider' value='"._T('bouton_valider')."' class='fondo' onclick='Soumettre()'>";
   echo "</form>" ;


   } // switch

               /**************/



                


                echo  "</fieldset></div>";





	echo "</td></tr>";

	echo "<tr><td style='text-align:$spip_lang_right;'>";
		echo "</td></tr>";
	echo "</table>\n";
       
	fin_cadre_relief();


} //// fin config

fin_page();
/******************************************************************************************/
/* SPIP-listes est un système de gestion de listes d'abonnés et d'envoi d'information     */
/* par email  pour SPIP.                                                                  */
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
?>
