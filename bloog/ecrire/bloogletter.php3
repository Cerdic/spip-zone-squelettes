<?php
/******************************************************************************************/
/* La bloOgletter est un système de gestion de listes d'information par email pour SPIP   */
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

init_config();
if ($changer_config == 'oui') {
	appliquer_modifs_config();
}


// Envoi des nouveautés sur demande
$quoi_de_neuf=lire_meta("quoi_de_neuf");
$jours_neuf = lire_meta('jours_neuf');
$now =  time();

// Envoyer les nouveautés sur demande

if ($envoi_now AND ($quoi_de_neuf == "oui") ) {

    $ext = get_extra(1, "auteur");
	$ext["majnouv"]= $now - 3600 * 24 * $jours_neuf ;
	set_extra(1,$ext,"auteur");

	}


// Admin bloogletter
debut_page(_T('titre_page_messagerie'), "redacteurs", "bloogletter");

if ($connect_statut != "0minirezo" OR !$connect_toutes_rubriques) {
	echo "<p><B>Vous n'avez pas acc&egrave;s &agrave; cette page.</B></p>";
	fin_page();
	exit;
}

debut_gauche();

// début des racourcis
debut_raccourcis("mailer_config.gif");
//


		
	if ($connect_statut == "0minirezo") {
	icone_horizontale(_T('bloog:bloogletter_suivi'), "bloogletter.php3?mode=statut", "addressbook-24.gif");
        icone_horizontale(_T('bloog:bloogletter_envoi_nouv'), "bloogletter.php3?mode=auto", "stock_timer.gif");
	icone_horizontale(_T('bloog:bloogletter_definir_squel'), "bloogletter.php3?mode=squelettes", "palette-24.gif");

        }




fin_raccourcis();
//

if($envoi_lot == "oui"){
echo"<iframe src='../inc-bloog-meleuse.php3' height='1' width='1' frameborder='0' >Désolé</iframe>";
}



global $table_prefix;
$query_message = "SELECT * FROM ".$table_prefix."_messages AS messages WHERE statut='encour'";

		$result_pile = spip_query($query_message);
		$message_pile = spip_num_rows($result_pile);
		

if ($message_pile > 0){

// Initialiser l'extra debut

$debut = get_extra(1,"auteur");

if(!$debut["debut"]){
$debut["debut"] = "0";
set_extra(1,$debut,"auteur");
}




// Compter les auteurs

global $table_prefix;
$query = "SELECT nom, id_auteur, email, extra FROM ".$table_prefix."_auteurs ORDER BY nom ASC ";


$result_inscrits = spip_query($query);
$nb_inscrits = spip_num_rows($result_inscrits);
	
debut_boite_info();

echo "<b> "._T('bloog:bloogletter_message_en_cours')."</b><br><p align='center'><b>".round($debut["debut"]/$nb_inscrits *100)." %</b></p>
<br>"._T('bloog:bloogletter_texte_boite_en_cours')."
<p align='center'><a href='".$PHP_SELF."'>["._T('bloog:bloogletter_actualiser')."]</a></p>
<p align='center'><a href='".$PHP_SELF."?envoi_lot=oui'><tt>["._T('bloog:bloogletter_lot_suivant')."]</a></tt></p>";



fin_boite_info();
}

	

if ($quoi_de_neuf == "oui") {
	$ext = get_extra(1, "auteur");
	
	if(!$ext['majnouv']) $ext['majnouv']=$now ;
       
	$proch = abs(round(($jours_neuf*3600*24 - (time()-$ext['majnouv']))/(24*3600)));

debut_boite_info();

echo "<b>"._T('bloog:bloogletter_info_nouv')."</b><br><p>"._T('bloog:bloogletter_info_nouv_texte', array('proch' => $proch))."</p>" ;

fin_boite_info();
echo "<br />";
}


debut_boite_info();

echo _T('bloog:bloogletter_aide');

fin_boite_info();


creer_colonne_droite();



debut_droite("messagerie");

if (($connect_statut == "0minirezo") OR ($connect_id_auteur == $id_auteur)) {
	$statut_auteur=$statut;
	bloog_onglets("messagerie", "bloogletter");
}

echo"<BR><BR>";

$email_envoi = lire_meta("email_envoi");
$email_webmaster = lire_meta("email_webmaster");

if( !$email_envoi && !$email_webmaster) echo "<h2>Erreur critique : Vous n'avez pas défini d'adresse d'envoi pour vos mails</h2>";

// Rédaction d'un courrier

if ($mode == "courrier_edit"){

if ($new == "oui") {
	$mydate = date("YmdHis", time() - 2 * 24 * 3600);
	$query = "DELETE FROM spip_messages WHERE (statut = 'redac') && (date_heure < $mydate)";
	$result = spip_query($query);

	
	$statut = 'redac';
	

	$query = "INSERT INTO spip_messages (titre, date_heure, statut, type, id_auteur) VALUES ('".addslashes(filtrer_entites(_T('texte_nouveau_message')))."', NOW(), '$statut', '$type', $connect_id_auteur)";
	$result = spip_query($query);
	$id_message = spip_insert_id();
	
	
	if ($type != "affich"){
		spip_query("INSERT INTO spip_auteurs_messages (id_auteur,id_message,vu) VALUES ('$connect_id_auteur','$id_message','oui')");
		if ($dest) {
			spip_query("INSERT INTO spip_auteurs_messages (id_auteur,id_message,vu) VALUES ('$dest','$id_message','non')");
		}
		
	}
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
		include 'inc_layer.php3';
		afficher_script_layer();
		
		// Titre du bloc
		echo bouton_block_invisible(md5(_T('bloog:bloogletter_charger_patron')));
			echo "<a href=\"javascript:swap_couche('$compteur_block', '$spip_lang_rtl');\">"._T('bloog:bloogletter_charger_patron')."</a>";
			
		// Bloc invisible
		echo debut_block_invisible(md5(_T('bloog:bloogletter_charger_patron')));
			
		 echo "<TABLE><tr><td>";				
	  
	  echo "<FORM ACTION='bloogletter.php3?mode=courrier&id_message=$id_message' METHOD='post'>";  
      $dir = "../squelettes_bloogletter/";

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
						echo "<OPTION VALUE='$titre_option'>$titre_option</OPTION>";
						}
					}
				echo "</SELECT>";
        		closedir($dh);
   		  		}
		}
	  		  
	echo "</td><td>";


	  echo "<INPUT TYPE='Hidden' NAME='inclure_patron' VALUE=\"oui\">";
	  echo "<INPUT TYPE='Hidden' NAME='id_message' VALUE=\"$id_message\">";
     
	

	echo "<P ALIGN='center'>"._T('bloog:bloogletter_alerte_modif')."<br><br><INPUT TYPE='submit' NAME='Valider' VALUE='"._T('bloog:bloogletter_charger_le_patron')."' CLASS='fondo'></P>";
	echo "</FORM>";

	echo "</td></tr></TABLE>";

			
		// Fin du bloc
		echo fin_block();

     fin_cadre_relief();

     //Ecrire dans le formulaire


	echo "<FORM ACTION='bloogletter.php3?mode=courrier&id_message=$id_message' METHOD='post'>";
	
	if ($type == 'nl') $le_type = "E-mail collectif";

	echo "<font face='Verdana,Arial,Sans,sans-serif' size=2 color='green'><b>$le_type</b></font><p>";
      echo "<font face='Verdana,Arial,Helvetica,sans-serif' size=1 color='red'>"._T('bloog:bloogletter_alerte_edit')."</font><p>";

	echo "<INPUT TYPE='Hidden' NAME='modifier_message' VALUE=\"oui\">";
	echo "<INPUT TYPE='Hidden' NAME='id_message' VALUE=\"$id_message\">";

	echo _T('texte_titre_obligatoire')."<BR>";
	echo "<INPUT TYPE='text' CLASS='formo' NAME='titre' VALUE=\"$titre\" SIZE='40'>";

		
	echo "<p><B>"._T('info_texte_message_02')."</B><BR>";
	echo "<TEXTAREA NAME='texte' ROWS='20' CLASS='formo' COLS='40' wrap=soft>";
	echo $texte;
	echo "</TEXTAREA><P>\n";

	echo "<P ALIGN='right'><INPUT TYPE='submit' NAME='Valider' VALUE='"._T('bouton_valider')."' CLASS='fondo'>";
	echo "</FORM>";
}


}

// fin du courrier edit


// Affichage d'un courrier

if ($mode=='courrier') {


$query = "SELECT COUNT(*) FROM spip_auteurs_messages WHERE id_auteur=$connect_id_auteur AND id_message=$id_message";
$result = spip_query($query);
list($n) = spip_fetch_array($result);
if (!$n) {

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
}



if ($ajout_forum AND strlen($texte) > 10 AND strlen($titre) > 2) {
	spip_query("UPDATE spip_auteurs_messages SET vu='non' WHERE id_message='$id_message'");
}

if ($inclure_patron == "oui"){

	  $nomsite=lire_meta("nom_site");
	  $urlsite=lire_meta("adresse_site");
      $url_patron=$urlsite."/patron.php3?patron=$patron" ;
      $titre_patron = "La lettre d'information du site ".$nomsite;
	  $tableau = file($url_patron); // lecture de la page
      $total = count($tableau);
      for ($i = 0 ; $i<$total  ; $i++) {$texte_patron .= $tableau[$i];}
	  
	  $titre = addslashes($titre_patron);
	  $texte = addslashes($texte_patron);
	  spip_query("UPDATE spip_messages SET titre='$titre', texte='$texte' WHERE id_message='$id_message'");
	

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



//
//

$query_message = "SELECT * FROM spip_messages WHERE id_message=$id_message ";
$result_message = spip_query($query_message);

while($row = spip_fetch_array($result_message)) {
	$id_message = $row['id_message'];
	$date_heure = $row["date_heure"];
	$date_fin = $row["date_fin"];
	$titre = typo($row["titre"]);
	$texte = propre($row["texte"]);
	$type = $row["type"];
	$statut = $row["statut"];
	$page = $row["page"];
	$rv = $row["rv"];
	$expediteur = $row['id_auteur'];

	$lejour=journum($row['date_heure']);
	$lemois = mois($row['date_heure']);		
	$lannee = annee($row['date_heure']);		

	
		$le_type = _T('bloog:bloogletter_message_type');
		$la_couleur = "red";	
	

	echo "<div style='border: 1px solid $la_couleur; background-color: $couleur_fond; padding: 5px;'>"; // debut cadre de couleur
		//debut_cadre_relief("messagerie-24.gif");
					//echo "<TABLE WIDTH=100% CELLPADDING=0 CELLSPACING=0 BORDER=0>";
					//echo "<TR><TD WIDTH=100%>";
			
					echo "<font face='Verdana,Arial,Sans,sans-serif' size=2 color='$la_couleur'><b>$le_type</b></font><br>";
					echo "<font face='Verdana,Arial,Sans,sans-serif' size=5><b>$titre</b></font>";
	
	
			if ($statut == 'redac') {
				
				if (!$envoi) echo "<br><font face='Verdana,Arial,Sans,sans-serif' size=2 color='red'><b>"._T('bloog:bloogletter_message_redac')."</b></font>";
				
				if ($expediteur == $connect_id_auteur OR (($type == 'nl' OR $type == 'auto') AND $connect_statut == '0minirezo')) {
					//echo "\n</TD> <TD align='right'>";
					if (!$envoi) icone (_T('icone_modifier_message'), "bloogletter.php3?mode=courrier_edit&id_message=$id_message", "messagerie-24.gif", "edit.gif");
					//echo "</TD><TR></table>";
				}
			}
		
	
			if ($envoi) { 
			echo "<br><font face='Verdana,Arial,Sans,sans-serif' size=2 color='red'><b>"._T('bloog:bloogletter_envoi_program')."</b></font>";
			echo "<p>";
			}
	
			if ($statut == 'encour') { echo "<br><font face='Verdana,Arial,Sans,sans-serif' size=2 color='red'><b>"._T('bloog:bloogletter_envoi_program')."</b></font>";
			//echo "<p>";
				}
	
			if ($statut == 'publie')  echo "<br><font face='Verdana,Arial,Sans,sans-serif' size=2 color='red'><b>"._T('bloog:bloogletter_message_arch')."</b></font>";
	echo "<p>";

//////////////////////////////////////////////////////
	// Le message lui-meme
	//


        // on nettoie pour la version html

    
  // filtres à la BoOz
      function propre_bloog($texte) {

        $texte = ereg_replace("<p class=\"spip\">(\r\n|\n|\r)?</p>",'',$texte);
        $texte = eregi_replace("\n{3}", "\n", $texte);

        // h3 imbrique dans un p
        $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<h3 class=\"spip\">" , "<h3 class=\"spip\">" , $texte);
        $texte = eregi_replace( "<\/h3>(\r\n|\n|\r| )*<\/p>" , "</h3>" , $texte);
        
        // h2 imbrique dans un p
        $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<h2>" , "<h2>" , $texte);
        $texte = eregi_replace( "<\/h2>(\r\n|\n|\r| )*<\/p>" , "</h2>" , $texte);

        // tableaux imbriques dans p
       $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<(table|TABLE)" , "<table" , $texte);
       $texte = eregi_replace( "<\/(table|TABLE)>(\r\n|\n|\r| )*<\/p>" , "</table>" , $texte);
	   
	   // TD imbriques dans p
       $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<(\/td|\/TD)" , "</td" , $texte);
       //$texte = eregi_replace( "<\/(td|TD)>(\r\n|\n|\r| )*<\/p>" , "</td>" , $texte);
	   
	   	   // p imbriques dans p
       $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<(p|P)" , "<p" , $texte);
       //$texte = eregi_replace( "<\/(td|TD)>(\r\n|\n|\r| )*<\/p>" , "</td>" , $texte);
         
         // DIV imbriques dans p
       $texte = eregi_replace( "<p class=\"spip\">(\r\n|\n|\r| )*<(div|DIV)" , "<div" , $texte);
       $texte = eregi_replace( "<\/(DIV|div)>(\r\n|\n|\r| )*<\/p>" , "</div>" , $texte);
  
 //$texte = PtoBR($texte);
  $texte = ereg_replace ("\.php3&nbsp;\?",".php3?", $texte);
  $texte = ereg_replace ("\.php&nbsp;\?",".php?", $texte);

  return $texte;
} 
       $texte = propre_bloog($texte);
	
	echo "<div align='left'>";
         echo "$texte";
	
	

	
    //////////////////////////////////////////////////////
	// Newsletter?
	//

	if ($statut == 'redac'AND $type =='nl' ) 
    {
            
        // Si on a demandé l'envoi du mail, on passe le relai à inc-bloog-global.php3

            if ($envoi) {
            spip_query("UPDATE spip_messages SET statut='encour' WHERE id_message='$id_message'");
            } // envoi
           else{
				echo "<form action='bloogletter.php3?mode=courrier&id_message=".$id_message."' method='post'>";
				debut_boite_info();
				echo "<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=3 WIDTH=100% BACKGROUND=''><TR><TD colspan=2>";
				echo "<FONT SIZE=2 FACE='Verdana,Garamond,Times,serif' color='#000000'><B>"._T('bloog:bloogletter_envoi')."</B></FONT><FONT SIZE=2 FACE='Georgia,Garamond,Times,serif' color='#000000'><p>"._T('bloog:bloogletter_envoi_texte')."</p></FONT>";
				echo "</td></tr></table>";
				
				echo "<div align='right'><INPUT TYPE='submit' NAME='envoi' VALUE='Envoyer le mail' CLASS='fondo'></div>";
				fin_boite_info();
				echo "</form>";
				}

	}// statut


	echo "</div>";// left
	//fin_cadre_relief();
	echo "</div>"; // fin du cadre de couleur
	
	echo "<table width='100%'><tr><td>";
		if ($expediteur == $connect_id_auteur  OR ($type == 'nl' AND $connect_statut == '0minirezo')) {
			echo "\n<table align='left'><tr><td>";
			icone (_T('icone_supprimer_message'), "bloogletter.php3?detruire_message=$id_message", "messagerie-24.gif", "supprimer.gif");
			echo "</td></tr></table>";
		}

		


		
	echo "</td></tr></table>";
		
	//////////////////////////////////////////////////////
	// Forums
	//

	echo "<BR><BR>";

	$forum_retour = urlencode("bloogletter.php3?mode=courrier&id_message=$id_message");


	echo "\n<div align='center'>";
		icone(_T('icone_poster_message'), "forum_envoi.php3?statut=perso&adresse_retour=".$forum_retour."&id_message=$id_message&titre_message=".urlencode($titre), "forum-interne-24.gif", "creer.gif");
	echo "</div>";


	echo "<P align='left'>";

	$query_forum = "SELECT * FROM spip_forum WHERE statut='perso' AND id_message='$id_message' AND id_parent=0 ORDER BY date_heure DESC LIMIT 0,20";
	$result_forum = spip_query($query_forum);
	afficher_forum($result_forum, $forum_retour);
}




}

// Suivi des abonnements


if ($mode=="statut") {

// auteur




$retour = "bloogletter.php3?mode=statut";
if ($tri) {
	$retour .= "tri=$tri";
	if ($tri=='nom' OR $tri=='statut')
		$partri = " "._T('info_par_tri', array('tri' => $tri));
	else if ($tri=='nombre')
		$partri = " "._T('info_par_nombre_article');
}


//
// Construire la requete
//


	$sql_statut_auteurs = " AND auteurs.statut IN ('0minirezo', '1comite', '5poubelle','6forum')";
	$sql_statut_articles = "";


// tri
switch ($tri) {
case 'nombre':
	$sql_order = ' ORDER BY extra["abo"] DESC, unom';
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

echo "<br>";
	gros_titre(_T('bloog:bloogletter_suivi'));
echo "<p>";

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
echo "<TABLE BORDER=0 CELLPADDING=3 CELLSPACING=0 WIDTH='100%' class='arial2'>\n";
echo "<tr bgcolor='#DBE1C5'>";
echo "<td width='20'>";
	$img = "<img src='img_pack/admin-12.gif' alt='' border='0'>";
	if ($tri=='statut')
		echo $img;
	else
		echo "<a href='bloogletter.php3?mode=statut&tri=statut' title='"._T('lien_trier_statut')."'>$img</a>";

echo "</td><td>";
	if ($tri == '' OR $tri=='nom')
		echo '<b>'._T('info_nom').'</b>';
	else
		echo "<a href='bloogletter.php3?mode=statut&tri=nom' title='"._T('lien_trier_nom')."'>"._T('info_nom')."</a>";

if ($options == 'avancees') echo "</td><td colspan='2'>"._T('info_contact');
echo "</td><td>";
	if ($visiteurs != 'oui') {
		if ($tri=='nombre')
			echo "<b>"._T('bloog:bloogletter_abonnement')."</b>";
		else
			echo _T('bloog:bloogletter_abonnement'); 
	}
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



while ($i++ <= $fin && (list(,$row) = each ($auteurs))) {
	// couleur de ligne
	$couleur = ($i % 2) ? '#FFFFFF' : $couleur_claire;
	echo "<tr bgcolor='$couleur'>";

	// statut auteur
	echo "<td>";
	echo bonhomme_statut($row);

	// nom
	echo '</td><td>';
	echo "<a href='auteurs_edit.php3?id_auteur=".$row['id_auteur']."'>".typo($row['nom']).'</a>';

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
				echo "<A HREF='mailto:".$row['email']."'>"._T('lien_email')."</A>";
			else
				echo "&nbsp;";

		if (strlen($row['url_site'])>3)
			echo "</td><td><A HREF='".$row['url_site']."'>"._T('lien_site')."</A>";
		else
			echo "</td><td>&nbsp;";
	}

	// Abonnés ou pas ?
	echo '</td><td>';
	
	
	if(!$extra = unserialize ($row["extra"])) $abo = "-";
	    else $abo = $extra["abo"];
		
		echo "&nbsp;".$abo;

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



// Historique des envois

if ($mode == historique OR !$mode){

if ($supp_dest) {
	spip_query("DELETE FROM spip_auteurs_messages WHERE id_message=$id_message AND id_auteur=$supp_dest");
}

if ($detruire_message) {
	spip_query("DELETE FROM spip_messages WHERE id_message=$detruire_message");
	spip_query("DELETE FROM spip_auteurs_messages WHERE id_message=$detruire_message");
	spip_query("DELETE FROM spip_forum WHERE id_message=$detruire_message");
}



function afficher_messages_bloog($titre_table, $query_message, $afficher_auteurs = true, $important = false, $boite_importante = true, $obligatoire = false) {
	global $messages_vus;
	global $connect_id_auteur;
	global $couleur_claire;
	global $spip_lang_rtl;

	// Interdire l'affichage de message en double
	if ($messages_vus) {
		$query_message .= ' AND messages.id_message NOT IN ('.join(',', $messages_vus).')';
	}


	$cols = 2;
	$query_message .= ' ORDER BY date_heure DESC';
	$tranches = afficher_tranches_requete($query_message, $cols);

	if ($tranches OR $obligatoire) {
		if ($important) debut_cadre_relief();

		
		echo "<TABLE WIDTH=100% CELLPADDING=0 CELLSPACING=0 BORDER=0><TR><TD WIDTH=100% BACKGROUND=''>";
		echo "<TABLE WIDTH=100% CELLPADDING=3 CELLSPACING=0 BORDER=0>";

		bandeau_titre_boite($titre_table, $afficher_auteurs, $boite_importante);

		echo $tranches;

		$result_message = spip_query($query_message);
		$num_rows = spip_num_rows($result_message);

		while($row = spip_fetch_array($result_message)) {
			$vals = '';

			$id_message = $row['id_message'];
			$date = $row["date_heure"];
			$titre = $row["titre"];
			$type = $row["type"];
			$statut = $row["statut"];
			$page = $row["page"];
			$rv = $row["rv"];
			$vu = $row["vu"];
			$messages_vus[$id_message] = $id_message;

			//
			// Titre
			//

			$s = "<A HREF='bloogletter.php3?mode=courrier&id_message=$id_message'>";

			
				$puce = "m_envoi$spip_lang_rtl.gif";
			
				
			$s .= "<img src='img_pack/$puce' width='14' height='7' border='0'>";
			$s .= "&nbsp;&nbsp;".typo($titre)."</A>";
			$vals[] = $s;

			
			
			//
			// Date
			//
			
			$s = affdate($date);
			
				$s = "<font color='#999999'>$s</font>";
			
			
			$vals[] = $s;

			$table[] = $vals;
		}

		
			$largeurs = array('', 90);
			$styles = array('arial2', 'arial1');
		
		afficher_liste($largeurs, $table, $styles);

		echo "</TABLE></TD></TR></TABLE>";
		spip_free_result($result_message);
		if ($important) fin_cadre_relief();
	}
}




$messages_vus = '';


$query_message = "SELECT * FROM spip_messages AS messages WHERE type='nl' AND statut='redac'";
afficher_messages_bloog(_T('bloog:bloogletter_aff_redac'), $query_message, false, true, false);

$query_message = "SELECT * FROM spip_messages AS messages WHERE statut='encour'";
afficher_messages_bloog(_T('bloog:bloogletter_aff_encours'), $query_message, false, true, false);

$query_message = "SELECT * FROM spip_messages AS messages WHERE statut='publie' AND type='nl' ";
afficher_messages_bloog(_T('bloog:bloogletter_aff_envoye'), $query_message, false,  true, false);

$query_message = "SELECT * FROM spip_messages AS messages WHERE statut='publie' AND type='auto' ";
afficher_messages_bloog(_T('bloog:bloogletter_aff_lettre_auto'), $query_message, false,  true, false);

}



if ($mode == "auto"){


//
// Activer/desactiver mails automatiques
//
if (tester_mail()) {
	debut_cadre_relief();

	$prevenir_auteurs=lire_meta("prevenir_auteurs");

echo "<FORM ACTION='bloogletter.php3' METHOD='post'>";
echo "<input type='hidden' name='changer_config' value='oui'>";

	echo "<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=3 WIDTH=\"100%\">";
	echo "<TR><TD BGCOLOR='$couleur_foncee' BACKGROUND='img_pack/rien.gif'><B><FONT FACE='Verdana,Arial,Sans,sans-serif' SIZE=3 COLOR='#FFFFFF'>"._T('info_envoi_email_automatique')."</FONT></B></TD></TR>";
	echo "<TR><TD BACKGROUND='img_pack/rien.gif' class='verdana2'>";
	echo "<blockquote><i>"._T('bloog:info_bloogletter_heberg')."</i></blockquote>";
	echo "</TD></TR>";


	//
	// Annonce des nouveautes
	//
	
	$adresse_neuf=lire_meta("adresse_neuf");
	$jours_neuf=lire_meta("jours_neuf");

	

	echo "<TR><TD>&nbsp;</TD></TR>";
	echo "<TR><TD BGCOLOR='#EEEECC' BACKGROUND='img_pack/rien.gif'><B><FONT FACE='Verdana,Arial,Sans,sans-serif' SIZE=3>";
	echo _T('info_annonce_nouveautes')."</FONT></B></TD></TR>";

	echo "<TR><TD BACKGROUND='img_pack/rien.gif' class='verdana2'>";
	echo _T('bloog:info_bloogletter_auto')."</TD></TR>";
	echo "</TD></TR>";

	echo "<TR><TD BACKGROUND='img_pack/rien.gif' ALIGN='$spip_lang_left' class='verdana2'>";
	if ($quoi_de_neuf != "oui") {
		echo "<INPUT TYPE='radio' NAME='quoi_de_neuf' VALUE='oui' id='quoi_de_neuf_on'>";
		echo " <label for='quoi_de_neuf_on'>"._T('bouton_radio_envoi_liste_nouveautes')."</label> ";
		echo "<BR><INPUT TYPE='radio' NAME='quoi_de_neuf' VALUE='non' CHECKED id='quoi_de_neuf_off'>";
		echo " <B><label for='quoi_de_neuf_off'>"._T('bouton_radio_non_envoi_liste_nouveautes')."</label></B> ";
	}
	else {
		echo "<INPUT TYPE='radio' NAME='quoi_de_neuf' VALUE='oui' id='quoi_de_neuf_on' CHECKED>";
		echo " <B><label for='quoi_de_neuf_on'>"._T('bouton_radio_envoi_liste_nouveautes')."</label></B> ";

		echo "<UL>";
		
		echo "<LI>"._T('info_tous_les')." <input type='text' name='jours_neuf' value='$jours_neuf' size='4' CLASS='fondl'> "._T('info_jours');
		echo " &nbsp;  &nbsp;  &nbsp; <INPUT TYPE='submit' NAME='envoi_now' VALUE='"._T('info_envoyer_maintenant')."' CLASS='fondl'>";
		echo "<br><br>";
		echo "</UL>";
		echo "<BR><INPUT TYPE='radio' NAME='quoi_de_neuf' VALUE='non' id='quoi_de_neuf_off'>";
		echo " <label for='quoi_de_neuf_off'>"._T('info_non_envoi_liste_nouveautes')."</label> ";
	}
	echo "</TD></TR>\n";

	if($options == "avancees") {
		$email_envoi = entites_html(lire_meta("email_envoi"));
		echo "<TR><TD>&nbsp;</TD></TR>";
		echo "<TR><TD BGCOLOR='#EEEECC' BACKGROUND='img_pack/rien.gif'><B><FONT FACE='Verdana,Arial,Sans,sans-serif' SIZE=3 COLOR='#000000'>";
		echo _T('info_email_envoi')."</FONT></B></TD></TR>";

		echo "<TR><TD BACKGROUND='img_pack/rien.gif' class='verdana2'>";
		echo _T('bloog:bloogletter_adresse');
		echo " <input type='text' name='email_envoi' value=\"$email_envoi\" size='20' CLASS='fondl'>";
		echo "</TD></TR>";
		echo "<TR><TD>&nbsp;</TD></TR>";
	}

	echo "<TR><td style='text-align:$spip_lang_right;'>";
	echo "<INPUT TYPE='submit' NAME='Valider' VALUE='"._T('bouton_valider')."' CLASS='fondo'>";
	echo "</TD></TR>";
	echo "</TABLE>\n";
	
	echo "</FORM>";

	fin_cadre_relief();
}



}


if ($mode == "squelettes"){


//
// Définir les squelettes
//

	debut_cadre_relief();

	

echo "<FORM ACTION='bloogletter.php3' METHOD='post'>";

	echo "<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=3 WIDTH=\"100%\">";
	echo "<TR><TD BGCOLOR='$couleur_foncee' BACKGROUND='img_pack/rien.gif'>
	<B><FONT FACE='Verdana,Arial,Sans,sans-serif' SIZE=3 COLOR='#FFFFFF'>"._T('bloog:bloogletter_definir_squel')."</FONT></B></TD></TR>";
	echo "<TR><TD BGCOLOR='#FFFFFF' BACKGROUND='img_pack/rien.gif' >";
     echo " </TD></TR>";
        echo "<TR><TD BGCOLOR='#EEEECC' BACKGROUND='img_pack/rien.gif' >";


        //un patron ?
            


	echo "<B><FONT FACE='Verdana,Arial,Sans,sans-serif' SIZE=3>";
	echo _T('bloog:bloogletter_patron_disponibles')."</FONT></B>";

    echo "</TD></TR>";
   
    echo "<TR><TD BGCOLOR='#FFFFFF' BACKGROUND='img_pack/rien.gif' >";
	
        
        	// Ouvre un dossier bien connu, et liste tous les fichiers
             
                $dir = "../squelettes_bloogletter/";
		if (is_dir($dir)) {

		 if ($dh = opendir($dir)) {
        		echo "<UL>";
	while (($file = readdir($dh)) !== false) {
          if($file != '..' && $file !='.' && $file !='')
		{
	$titre_option=ereg_replace('(\.html|\.HTML)','',$file);
	
	
echo "<LI>$titre_option <a href=\"../patron.php3?patron=$titre_option\">["._T('bloog:voir')."]</a> </LI>";
		}
					}
		echo "</UL>";
        closedir($dh);
   		  		}
		}


                echo "<blockquote><i>"._T('bloog:bloogletter_definir_squel_texte')."</i></blockquote>";


        echo "</TD></TR>";




	//
	// Annonce des nouveautes
	//
	


	echo "<TR><TD>&nbsp;</TD></TR>";
	echo "<TR><TD BGCOLOR='#EEEECC' BACKGROUND='img_pack/rien.gif'><B><FONT FACE='Verdana,Arial,Sans,sans-serif' SIZE=3>";
	echo _T('bloog:bloogletter_messages_auto')."</FONT></B></TD></TR>";

	echo "<TR><TD BACKGROUND='img_pack/rien.gif' class='verdana2'>";
	echo _T('bloog:bloogletter_messages_auto_texte')."</TD></TR>";
	echo "</TD></TR>";

	

	echo "<TR><td style='text-align:$spip_lang_right;'>";
	echo "<INPUT TYPE='submit' NAME='Valider' VALUE='"._T('bouton_valider')."' CLASS='fondo'>";
	echo "</TD></TR>";
	echo "</TABLE>\n";
	
	echo "</FORM>";

	fin_cadre_relief();

}

fin_page();

?>
