<?php

/******************************************************************************************/
/* SPIP-Listes est un système de gestion de listes d'abonnés et d'envoi d'information     */
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


include("ecrire/inc_version.php3");
include_ecrire("inc_connect.php3");
include_ecrire("inc_filtres.php3");
include_ecrire("inc_config.php3");
include_ecrire("inc_texte.php3");
include_ecrire ("inc_session.php3");
include_ecrire ("inc_meta.php3");

// Trouver un message à envoyer

global $table_prefix;
$query_message = "SELECT * FROM ".$table_prefix."_messages AS messages WHERE statut='encour' AND (TYPE='auto' OR TYPE='nl') ORDER BY date_heure ASC LIMIT 0,1";

$result_pile = spip_query($query_message);
$message_pile = spip_num_rows($result_pile);

if ($message_pile > 0){

	//locker
	$meta_liste = get_extra(1,"auteur");
	$meta_liste["locked"] = "oui" ;
	set_extra(1,$meta_liste,"auteur");

	$row = spip_fetch_array($result_pile);
    $texte = $row["texte"];
    $texte_original = $texte ; // pour les envois de test
	
	$texte = stripslashes($texte);
	$titre = typo($row["titre"]);

	bdebut_html("Envoi en cours");
	echo "<h4>"._T('spiplistes:envoi_en_cours')."</h4>"   ;

	echo"<DIV>";
	echo "<div style='float:left;padding:5px'><img src='ecrire/img_pack/mailer_casquette.gif'</div>";

	// Determiner le destinataire ou la liste destinataire

	eregi("^__bLg__[0-9@\.A-Z_-]+__bLg__", $texte, $res );
	$destinataires = str_replace("__bLg__","",$res[0]);
	//est-ce un mail de test ?
	
	if( eregi("^[_\.0-9a-z-]+@([0-9a-z-]+\.)+[a-z]{2,4}$",$destinataires) ){
		echo _T('spiplistes:email_test')." -> ".$destinataires."<br />";
		$test = 'oui';
		$mail_collectif = 'non' ;
	}
	else{
		if($destinataires == 'tous'){
			$mail_collectif = 'oui' ;
			echo _T('spiplistes:envoi_tous')."<BR />" ;
		} 
		else{
		$mail_collectif = 'non' ;
    
		$query_d = "SELECT * FROM spip_articles WHERE id_article=$destinataires";
		$result_d = spip_query($query_d);
		
			if(spip_num_rows($result_d)>0){
				while($ro = spip_fetch_array($result_d)) {
				$titre_liste = $ro["titre"];
				$id = $ro["id_article"];
				$mail_envoi = get_extra($id,"article") ;
				$email_liste = $mail_envoi['email_envoi'];
				echo _T('spiplistes:envoi_listes').$titre_liste." <br />" ;
				}
			}else{
			//erreur
			echo "<h1>"._T('spiplistes:envoi_erreur')."</h1>" ;
			}
		}
	}

    // Expéditeur :
	//trouver le mail d'envoi et de réponse pour les bounces.

	$email_webmaster = lire_meta("email_webmaster");
	$from = email_valide_bloog($email_liste) ? $email_liste : $email_webmaster;
	echo  _T('spiplistes:email_reponse').$from ." <br />" ;

	// virer les destinataires du texte du message

    /*   echo "<h2>Original issu de la base</h2>";
    echo "<TEXTAREA NAME='texte' ROWS='20' CLASS='formo' COLS='70' wrap=soft>";
	echo $texte;
	echo "</TEXTAREA><P>\n"; */

    $texte = eregi_replace("__bLg__[0-9@\.A-Z_-]+__bLg__","",$texte);
            
    // préparer le message pour l'envoi

    $texte = propre($texte);
    $texte = propre_bloog($texte);
	$type = $row["type"];
	$id_message = $row["id_message"];

	$nomsite=lire_meta("nom_site");
	$urlsite=lire_meta("adresse_site");
	srand((double)microtime()*1000000);
	$boundary = md5(uniqid(rand()));

	$objet= filtrer_entites($titre);
    if ($charset <> 'utf-8') {
	$objet = str_replace("&#8217;", "'", $objet);
	}

	$texte = absolute_url($texte);
	
	// on prépare la version texte
	
	if ($charset <> 'utf-8') $texte = str_replace("&#8217;", "'", $texte);
   
    $page = version_texte($texte);

	$page.="\n\n________________________________________________________________________"  ;
	$page.="\n\n"._T('spiplistes:editeur').$nomsite."\n"  ;
	$page.=$urlsite."\n";
	$page.="________________________________________________________________________"  ;

	// on prépare la version html

	$pageh = "This is a multi-part message in MIME format\n";
	$pageh .="--$boundary\nContent-Type: text/plain;charset=\"iso-8859-1\"\n";
	$pageh .="Content-Transfer-Encoding: quoted-printable\n\n";
	$pageh .=_T('spiplistes:non_html')."\n".$urlsite."\n".version_texte($texte)."\n";
	$pageh .="\n\n";
	$pageh .="--$boundary\nContent-Type: text/html;charset=\"iso-8859-1\"\n";
	$pageh .="Content-Transfer-Encoding: 7 BIT\n\n";
	$pageh .="<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
	$pageh .="<HTML><HEAD><BASE HREF=".$urlsite."></HEAD><BODY>";
	$pageh .= $texte;
	// la fin de la version html sera générée pour chaque destinataire

  
	// Envoi par lot
	// Compter les inscrits

	$query = ''; 
	
	if($test == 'oui'){
		global $table_prefix;
		$query = "SELECT id_auteur FROM ".$table_prefix."_auteurs WHERE email = '$destinataires' ORDER BY id_auteur ASC ";
	}
	else{
		if($mail_collectif == 'non'){
			global $table_prefix;
			$query = "SELECT id_auteur FROM ".$table_prefix."_auteurs_articles WHERE id_article = '$destinataires' ORDER BY id_auteur ASC ";
		}elseif($mail_collectif == 'oui'){
			// attention aux adresse à la poubelle
			global $table_prefix;
			$query = "SELECT nom FROM ".$table_prefix."_auteurs ORDER BY nom ASC";
		}
	}

	$result_inscrits = spip_query($query);
	$nb_inscrits = spip_num_rows($result_inscrits);

	$extra_meta = get_extra(1,"auteur");
	$extra_meta["total_auteurs"] = $nb_inscrits ;
	set_extra(1,$extra_meta,"auteur");
	echo _T('spiplistes:contacts')." -> ".$nb_inscrits."<p>" ;

	echo "</div>";

	if($test == 'oui' && $nb_inscrits == 0){
	// à tester dans la bloogletter
	echo "<h2>"._T('spiplistes:sans_envoi')."<h2>" ;
	}
	
	if($nb_inscrits > 0){
	
	// l' extra debut existe il ?
	
		$deb = get_extra(1,"auteur");
		if(!$deb["debut"]){
			$deb["debut"] = 0;
			set_extra(1,$deb,"auteur");
			$deb = get_extra(1,"auteur");
		}
	 
		echo "<h3>"._T('spiplistes:message'). $titre."</h3>" ;
	  
		echo"<DIV style='text-align:center;width:250px'>";
		echo"<DIV>";
		echo "<div style='float:right;padding:5px;'><img src='ecrire/img_pack/48_import.gif'</div>";
	
		//Envoi par lots
	
	
		$debut = $deb["debut"];
		$limit=20; // nombre de messages envoyés par boucles.
	
		if($test== 'oui'){
			global $table_prefix;
			$query = "SELECT id_auteur FROM ".$table_prefix."_auteurs WHERE email = '$destinataires' ORDER BY id_auteur ASC ";
		}
		else{
			if($mail_collectif == 'oui'){
				$query = "SELECT nom, id_auteur, email, extra FROM ".$table_prefix."_auteurs ORDER BY nom ASC LIMIT $debut,$limit";
			}elseif($mail_collectif == 'non'){
				$query = "SELECT id_auteur FROM ".$table_prefix."_auteurs_articles WHERE id_article = '$destinataires' ORDER BY id_auteur ASC LIMIT $debut,$limit";
			}else{$query='';}
		}
	
		$result_inscrits = spip_query($query);
		$liste_abonnes = spip_num_rows($result_inscrits);
	
		if($liste_abonnes > 0){
		// on modifie le cran du compteur avant d'envoyer les mails pour éviter les doublons en cas d'erreur pendant l'envoi.
		$debut = $debut+$limit;
	
			if ($debut>$nb_inscrits){
				if ($test== 'oui'){
				
				$texte_original = eregi_replace("__bLg__[0-9@\.A-Z_-]+__bLg__","",$texte_original);
				$texte_original = addslashes($texte_original);
				spip_query("UPDATE ".$table_prefix."_messages SET statut='redac', texte='$texte_original' WHERE id_message='$id_message'");
				$deb["debut"] = 0 ;
				$deb["total_auteurs"] = 0 ;
				}else{
				// archiver
				$texte = addslashes($texte) ;
				spip_query("UPDATE ".$table_prefix."_messages SET statut='publie' WHERE id_message='$id_message'");
				$deb["debut"] = 0 ;
				$deb["total_auteurs"] = 0 ;
				}
	
			//attention si on interrompt
			}else{
			$deb["debut"] = $debut ;
			}
	
		set_extra(1,$deb,"auteur");
	
		$addresse_desabo =  $urlsite."/abonnement.php3";
		echo "<br />"._T('spiplistes:contacts_lot');
	
			while ($row2 = spip_fetch_array($result_inscrits)) {
				$id_auteur = $row2['id_auteur'] ;
				$query = "SELECT nom, id_auteur, email, extra FROM ".$table_prefix."_auteurs WHERE id_auteur = $id_auteur ";
				$res = spip_query($query);
				$row3 = spip_fetch_array($res);
		
				$nom_auteur = $row3["nom"];
				echo "<br />->".$nom_auteur;
				$email = $row3["email"];
				$id = $row3["id_auteur"];
				$total=$total+1;
				unset ($cookie);
				
				$extra = unserialize ($row3["extra"]);
				if (($extra["abo"] == 'texte') OR ($extra["abo"] == 'html')) {$abo = true;}
				else {$abo = false;}
				
				if ($abo) {
					$cookie = creer_uniqid();
					spip_query("UPDATE spip_auteurs SET cookie_oubli = '$cookie' WHERE email ='$email'");
				
		
					if ($extra["abo"] == 'texte'){
					// entete texte	
		
					$headers = "From: $from\n";
					$headers .= "Reply-to: $from\n";
					$headers .= "Return-Path: $from\n";					 
					//$headers .= "cc:$from\n";
					//$headers .= "bcc:$from\n, $from\n";
					$headers .= "MIME-Version: 1.0\n";
					$headers  .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
					$headers  .= "Content-Transfer-Encoding:8bit\n";
					$headers  .= "\n";
		
					// pied de page texte	
		
					$pagem = $page."\n\n"  ;
					$pagem.= _T('spiplistes:abonnement_mail')."\n" ;
					$pagem.= $addresse_desabo."?d=".$cookie."\n\n"  ;
		
					// fin du pied de page texte
					
						if (email_valide_bloog($from)){
						$ok = mail($email,$objet,$pagem,$headers) ;
						echo " -> ok";
						} 
						else { 
						echo _T('spiplistes:sans_adresse') ; 
						}
		
					}   // fin  texte
		
						
					else if ($extra["abo"] == 'html'){
						//entete html
						$headersh = "From: $from\n";
						$headersh .= "Reply-to: $from\n";
						$headersh .= "Return-Path: $from\n";		
						//$headers .= "cc:$from\n"; // CC to
						//$headers .= "bcc:$from\n, $from\n"; // BCCs to
						$headersh .="MIME-Version: 1.0\n";
						$headersh  .="Content-Type: MULTIPART/ALTERNATIVE;BOUNDARY=\"$boundary\"\n\n";
		
						// pied de page HTML
		
						$pagehm = $pageh."<hr />"._T('spiplistes:editeur')."<a href=\"".$urlsite."\">".$nomsite."</a><br />
						<a href=\"".$urlsite."\">".$urlsite."</a><hr />
						<a href=\"".$addresse_desabo."?d=".$cookie."\">"._T('spiplistes:abonnement_mail')."</a></BODY></HTML>";
						$pagehm .="\n\n\n--$boundary--\n end of the multi-part";
		
						// fin du pied de page HTML
		
						if (email_valide_bloog($from)){
							$ok = mail($email,$objet,$pagehm,$headersh) ;
							echo " -> ok";
						} else { echo _T('spiplistes:sans_adresse'); }
		
					}    // fin  HTML
					
								
				$total_abo = $total_abo + 1;
				if($ok) $cmpt=$cmpt + 1 ;
				} /* fin abo*/
				   
		
			}      /* fin while */
		}      /* fin liste abonnées */
	
	
	}else{
	//aucun destinataire connu pour ce message
	echo "<h4>"._T('spiplistes:erreur_sans_destinataire')."</h4> <h4>"._T('spiplistes:envoi_annule')."</h4>";
		 
	spip_query("UPDATE ".$table_prefix."_messages SET titre='"._T('spiplistes:erreur_destinataire')."', statut='publie' WHERE id_message='$id_message'"); 
	$deb = get_extra(1,"auteur");
	$deb["debut"] = 0 ;
	$deb["total_auteurs"] = 0 ;
	set_extra(1,$deb,"auteur");
	}
	
	//delocker
	$meta_liste = get_extra(1,"auteur");
	$meta_liste["locked"] = "non" ;
	set_extra(1,$meta_liste,"auteur");
	
	echo "<p><a href='$PHP_SELF'>"._T('spiplistes:forcer_lot')."</a></p>";

	echo"</DIV>";
	echo"</DIV>";

	bfin_html();

}else{
bdebut_html("Envoi termine");
echo "<h4>"._T('spiplistes:envoi_fini')."</h4>"   ;
echo _T('spiplistes:non_courrier');
//delocker
	$meta_liste = get_extra(1,"auteur");
	$meta_liste["locked"] = "non" ;
	set_extra(1,$meta_liste,"auteur");
bfin_html();
}/* flag pile*/



          /////////////////////////////////////////



function bdebut_html($titre = "") {
	global $couleur_foncee, $couleur_claire, $couleur_lien, $couleur_lien_off;
	global $flag_ecrire;
	global $spip_lang_rtl;

	$nom_site_spip = entites_html(lire_meta("nom_site"));
	$titre = textebrut(typo($titre));

	if (!$nom_site_spip) $nom_site_spip="SPIP";
	if (!$charset = lire_meta('charset')) $charset = 'utf-8';

	@Header("Expires: 0");
	@Header("Cache-Control: no-cache,no-store");
	@Header("Pragma: no-cache");
	@Header("Content-Type: text/html; charset=$charset");

	echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>\n<head>\n<html>\n<title>[$nom_site_spip] $titre</title>\n";
	echo '<meta http-equiv="Content-Type" content="text/html; charset='.$charset.'">';
	echo '
	<style>
	<!--
	.cadre {
	/*border: 1px #000000 solid;*/
	background-color:#FFFFFF;
        text-align: justify;
        width:500px;
        padding: 10px;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 10px;
	-moz-border-radius: 6px;
	border-radius: 6px;
	}

	h1 {
	font-size: 150%;
	text-decoration: underline ;
	}

	.bloc {
	margin-top: 100px;
	padding: 10px;
	text-align: center;
	}

	.cdt{
	font-size:10px;
	}

	-->
	</style>
	';

	echo "</head><body text='#000000' bgcolor='#F5F5F5' ";
	if ($spip_lang_rtl)	echo " dir='rtl'";
	echo "><div class='bloc'><h1>".$nom_site_spip."</h1><div class='cadre' align='center' >";
}

function bfin_html() {
 $urlsite=lire_meta("adresse_site");
 echo "</div><p><a href='".$urlsite."/ecrire/spip_listes.php3'>"._T('spiplistes:retour_link')."</a></p><br /><div class='cdt'>"._T('spiplistes:abonnement_cdt')."</div></div></body></html>\n";
}

/******************************************************************************************/
/* SPIP-Listes est un système de gestion de listes d'information par email pour SPIP      */
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
