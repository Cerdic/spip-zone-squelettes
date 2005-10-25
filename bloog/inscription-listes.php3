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

// récupération de la config

$acces_abonne = get_extra(1,"auteur");
($acces_abonne['config'] == 'membre') ? $acces_membres = 'oui' : $acces_membres = 'non';



/* permet éventuellement d'afficher les liens vers les options

echo "<a href='".$PHP_SELF."'>"._T('spiplistes:abonner')."</a> | ";
if($inscriptions_ecrire) echo"<a href='".$PHP_SELF."?type=redac'>"._T('spiplistes:devenir_redac')."</a> | ";
echo "<a href='".$PHP_SELF."?oubli_pass=oui'>"._T('login_motpasseoublie')."</a>";
echo "<a href='abonnement.php3'>"._T('spiplistes:desabo')."</a>";
*/


// code inscription au site ou/et à la lettre d'info


/******************************************************************/

include ("ecrire/inc_version.php3");
include_ecrire ("inc_meta.php3");
include_ecrire ("inc_session.php3");
include_ecrire ("inc_filtres.php3");
include_ecrire ("inc_texte.php3");
include_ecrire ("inc_meta.php3");
include_ecrire ("inc_mail.php3");
include_ecrire ("inc_acces.php3");

//utiliser_langue_site();



$inscriptions_ecrire = (lire_meta("accepter_inscriptions") == "oui") ;
unset($erreur);


// envoyer le cookie de relance mot de passe
if ($email_oubli) {
	if (email_valide($email_oubli)) {
		$email = addslashes($email_oubli);
		$res = spip_query("SELECT * FROM spip_auteurs WHERE email ='$email'");
		if ($row = spip_fetch_array($res)) {
			if ($row['statut'] == '5poubelle')
				$erreur = _T('pass_erreur_acces_refuse');
			else {
				$cookie = creer_uniqid();
				spip_query("UPDATE spip_auteurs SET cookie_oubli = '$cookie' WHERE email ='$email'");

				$nom_site_spip = lire_meta("nom_site");
				$adresse_site = lire_meta("adresse_site");

				$message = _T('pass_mail_passcookie', array('nom_site_spip' => $nom_site_spip, 'adresse_site' => $adresse_site, 'cookie' => $cookie));
				if (envoyer_mail($email, "[$nom_site_spip] "._T('pass_oubli_mot'), $message))
					$erreur = _T('pass_recevoir_mail');
				else
					$erreur = _T('pass_erreur_probleme_technique');
			}
		}
		else
			$erreur = _T('pass_erreur_non_enregistre', array('email_oubli' => htmlspecialchars($email_oubli)));
	}
	else
		$erreur = _T('pass_erreur_non_valide', array('email_oubli' => htmlspecialchars($email_oubli)));
}

if ($oubli_pass == 'oui') {
	// debut presentation
	echo"<h2>"._T('pass_mot_oublie')."</h2><br />\n";
	
	echo "<p>";
	if ($erreur)
		echo $erreur;
	else {
		echo _T('pass_indiquez_cidessous');

		echo "<p>";
		echo "<form action='".$PHP_SELF."' method='post'>";
		echo "<div style='text-align:right'>";
		echo "<input type='text' class='fondo' name='email_oubli' value='' />";
		echo "<input type='hidden' name='oubli_pass' value='oui' />";
		echo "<input type='submit' class='fondl' name='oubli' value='OK' /></div></form>";
	}
	echo "</p>";
}


else if ($inscriptions_ecrire || (lire_meta('accepter_visiteurs') == 'oui') OR (lire_meta('forums_publics') == 'abo')) {
	// debut presentation

	if ($type=="redac" AND $inscriptions_ecrire){
		echo "<h2>"._T('spiplistes:devenir_redac')."</h2>";
        	echo "<p>"._T('spiplistes:inscription_redacteurs');
		echo "</p>";
	echo "\n<p>";
	}else{
		if($acces_membres == 'oui'){
		echo "<h2>"._T('spiplistes:devenir_abonne')."</h2>";
		echo "<p>"._T('spiplistes:inscription_visiteurs');
	echo "\n<p>";
        }

	}

    formulaire_inscription(($type=="redac")? 'redac' : 'forum',$acces_membres);
}
else {
	echo "<br />\n"._T('pass_erreur')."<br />\n";
	echo "<p>"._T('pass_rien_a_faire_ici');
}

////////

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



// inscrire les visiteurs dans l'espace public (statut 6forum) ou prive (statut nouveau->1comite)
function formulaire_inscription($type,$acces_membres) {
	$request_uri = $GLOBALS["REQUEST_URI"];
	global $mail_inscription;
	global $nom_inscription;
	global $list;
	global $liste;


	if ($type == 'redac') {
		if (lire_meta("accepter_inscriptions") != "oui") return;
		$statut = "nouveau";
	}
	else if ($type == 'forum') {
		$statut = "6forum";
	}
	else {
		return; // tentative de hack...?
	}


	
	if($acces_membres == 'non') $nom_inscription = test_login2($mail_inscription) ;

        //utiliser_langue_site();
		$nomsite=lire_meta("nom_site");
		$urlsite=lire_meta("adresse_site");

		if($mail_inscription){
		$mail_valide = email_valide_bloog($mail_inscription);
		}
		
        if ($mail_valide && $nom_inscription) {
		$query = "SELECT * FROM spip_auteurs WHERE email='".addslashes($mail_inscription)."'";
		$result = spip_query($query);

		echo "<div class='reponse_formulaire'>";

		// l'abonne existe deja.
	 	if ($row = spip_fetch_array($result)) {
			$id_auteur = $row['id_auteur'];
			$statut = $row['statut'];
			$abonne_existant = "oui" ;

			unset ($continue);
			if ($statut == '5poubelle') {
			echo "<b>Vous n'avez plus accès à ce site</b>";
			}elseif ($statut == 'nouveau') {
			spip_query ("DELETE FROM spip_auteurs WHERE id_auteur=$id_auteur");
			$continue = true;
			}else{
        	// envoyer le cookie de relance modif abonnement
        
        	$cookie = creer_uniqid();
        	spip_query("UPDATE spip_auteurs SET cookie_oubli = '$cookie' WHERE email ='$mail_inscription'");
        
        	$message = _T('spiplistes:abonnement_mail_passcookie', array('nom_site_spip' => $nomsite, 'adresse_site' => $urlsite, 'cookie' => $cookie));
				if (envoyer_mail($mail_inscription, "[$nomsite] "._T('spiplistes:abonnement_titre_mail'), $message)){
					echo _T('spiplistes:pass_recevoir_mail');
				}else{
					echo _T('pass_erreur_probleme_technique');
				}
                                               
            }
		} else {
			$continue = true;
		}
		
		// envoyer identifiants par mail
		if ($continue) {
		
         //ajouter un code pour retrouver l'abonné

			$pass = creer_pass_aleatoire(8, $mail_inscription);
			$login = test_login2($mail_inscription);
			$mdpass = md5($pass);
			$htpass = generer_htpass($pass);

            $cookie = creer_uniqid();

			$extras = bloog_extra_recup_saisie('auteurs');

			$query = "INSERT INTO spip_auteurs (nom, email, login, pass, statut, htpass, extra, cookie_oubli) ".
				"VALUES ('".addslashes($nom_inscription)."', '".addslashes($mail_inscription)."', '$login', '$mdpass', '$statut', '$htpass', '$extras', '$cookie')";
			$result = spip_query($query);
			
		// abonnement aux listes http://www.phpfrance.com/tutorials/index.php?page=2&id=13

        $query = "SELECT * FROM spip_auteurs WHERE email='".addslashes($mail_inscription)."'";
		$result = spip_query($query);

			// l'abonne existe deja.
	 	if ($row = spip_fetch_array($result)) {
		$id_auteur = $row['id_auteur'];
		$statut = $row['statut'];
               
               
                // on abonne l'auteur aux listes
                if(is_array($list)){
                    
                while( list(,$val) = each($list) ){

                $query="DELETE FROM spip_auteurs_articles WHERE id_auteur='$id_auteur' AND id_article='$val'";
        		$result=spip_query($query);
        		$query="INSERT INTO spip_auteurs_articles (id_auteur,id_article) VALUES ('$id_auteur','$val')";
        		$result=spip_query($query);
                    

                        }

                }
		}

// abo



            ecrire_acces();

			$nom_site_spip = lire_meta("nom_site");
			$adresse_site = lire_meta("adresse_site");

			$message = _T('form_forum_message_auto')."\n\n"._T('spiplistes:bonjour')."\n";
			
            if ($GLOBALS['suppl_abo']=="non"){
            $message .= _T('spiplistes:mail_non', array('nom_site_spip' => $nom_site_spip))."\n";
            }else {

            //SELECT des listes de l'abonné
            
						
		$query = "SELECT * FROM spip_auteurs_articles AS abonnements, spip_articles AS listes WHERE abonnements.id_auteur='$id_auteur' AND abonnements.id_article=listes.id_article AND listes.statut='liste'";
		$result_list = spip_query($query);

			//lister les listes
            $message_list = '' ;
            $i = 0 ;

            while($row = spip_fetch_array($result_list)) {
					
			$id_article = $row['id_article'] ;
			
			$query = "SELECT * FROM spip_articles WHERE id_article=$id_article";
		        $result = spip_query($query);
                        $row = spip_fetch_array($result);
                        $titre = $row['titre'] ;
                        $message_list .= "\n- ".$titre ;
                        $i++ ;
                }


        if($i>1){
        // $message .= _T('spiplistes:mail_format', array('nom_site_spip' => $nom_site_spip))." : ".$GLOBALS['suppl_abo']."\n";
        $message .= "\n"._T('spiplistes:inscription_responses').$nom_site_spip._T('spiplistes:inscription_format').$GLOBALS['suppl_abo']."." ;
        $message .= "\n"._T('spiplistes:inscription_listes').$message_list ;
        } 
        
        if($i==1){
        // $message .= _T('spiplistes:mail_format', array('nom_site_spip' => $nom_site_spip))." : ".$GLOBALS['suppl_abo']."\n";
        $message .= "\n"._T('spiplistes:inscription_response').$nom_site_spip._T('spiplistes:inscription_format').$GLOBALS['suppl_abo']."." ;
        $message .= "\n"._T('spiplistes:inscription_liste').$message_list ;
        } 
        if($i==0){
        $message .= "\n"._T('spiplistes:inscription_response').$nom_site_spip._T('spiplistes:inscription_format').$GLOBALS['suppl_abo']."." ;
        }
                        }
                        
        if(($acces_membres == 'oui') && ($type == 'forum') ){
                          
			$message .="\n\n"._T('spiplistes:inscription_mail_forum', array('nom_site_spip' => $nom_site_spip, 'adresse_site' => $adresse_site))."\n\n";
            $message .= "- "._T('form_forum_login')." $login\n";
			$message .= "- "._T('form_forum_pass')." $pass\n\n";
                        }
		 	
                         if($type == 'redac') {
			  $message .="\n\n"._T('spiplistes:inscription_mail_redac', array('nom_site_spip' => $nom_site_spip, 'adresse_site' => $adresse_site))."\n\n";
		          $message .= "- "._T('form_forum_login')." $login\n";
			$message .= "- "._T('form_forum_pass')." $pass\n\n";
                	}
                        

        }

                        $message .= "\n\n-----------------------------------------\n\n" ;
                        $message .= _T('spiplistes:abonnement_mail')." ".$adresse_site."/abonnement.php3?d=".$cookie;
                        $message .= "\n\n-----------------------------------------\n\n" ;
		
		if($abonne_existant != 'oui'){

			if (envoyer_mail($mail_inscription, "[$nom_site_spip] "._T('spiplistes:form_forum_identifiants'), $message)) {
				if($acces_membres == 'oui'){
                                echo _T('form_forum_identifiant_mail');
                                }else{
                                echo _T('spiplistes:form_forum_identifiant_confirm');
                                }
			}
			else {
				echo _T('form_forum_probleme_mail');
			}
		}	

		echo "</div>";
	}
	else {
		
		if($mail_inscription AND !$mail_valide){
        echo "<h2>"._T('spiplistes:erreur_adresse')."</h2>";
        }
		
		if($acces_membres == 'oui'){
        echo _T('form_forum_indiquer_nom_email');
        }



	

	
	$self=quote_amp($GLOBALS["clean_link"]->getUrl()) ;

	
	
	echo "<form action='".$self."' method='post'>";
		
	echo "<div style='width:430px'>";

	if(ereg("\?",$self)){
			$self=$self."&liste=";
			}
			else{
			$self=$self."?liste=";
			}
	
		/***********/
        
		//Infos sur la liste
		if(!$liste) $liste='';
		if($liste != '') {

		$res = spip_query ("SELECT * FROM spip_articles WHERE id_article='$liste' AND statut='liste'");
			if ($row = spip_fetch_array($res)) {
			$titre_liste = $row['titre'] ;
			$texte_liste = $row['texte'] ;
			echo "<p>";
			echo "<fieldset>";
			echo "<legend><b>$titre_liste</b></legend>";
			echo propre($texte_liste);
			echo "</fieldset>";
			echo "<p>";
			}
		}

			$nom_site_spip = lire_meta("nom_site");
			$adresse_site = lire_meta("adresse_site");
			
			$list = spip_query ("SELECT * FROM spip_articles WHERE statut = 'liste' ");
			$nb_listes = spip_num_rows($list);
			if($nb_listes == 0){
			echo "<fieldset> ";
			echo "<legend><b>"._T('spiplistes:abo_1_lettre')."<a href=\"".$adresse_site."\">".$nom_site_spip."</a></b></legend>";
			}
			elseif($nb_listes == 1){
			echo "<fieldset> ";
			echo "<legend><b>"._T('spiplistes:abo_1_lettre')."<a href=\"".$adresse_site."\">".$nom_site_spip."</a></b></legend>";
			echo "<ul style='width:350px'>" ;
			while($row = spip_fetch_array($list)) {
					
			echo "<li style='list-style-type:none'>" ;
			$id_liste = $row['id_article'] ;
			$titre_liste = $row['titre'] ;
			echo "<a href='".$self.$id_liste."' title='"._T('spiplistes:infos_liste')."'>$titre_liste</a>&nbsp;&nbsp;&nbsp;<input type=\"checkbox\" name=\"list[]\" checked=\"checked\"  value=\"".$id_liste."\" />" ;
            echo "</li>" ;
			}
			echo "</ul>" ;
			}
			else{
			echo "<fieldset> ";
			echo "<legend><b>"._T('spiplistes:abo_listes')."<a href=\"".$adresse_site."\">".$nom_site_spip."</a></b></legend>";
			echo "<div style='width:350px; padding-top:6px;'>" ;
			while($row = spip_fetch_array($list)) {
					
			echo "<div style='text-align:left; padding:0px 0px 4px 0px'>" ;
			$id_liste = $row['id_article'] ;
			$titre_liste = $row['titre'] ;
			echo "<div style='float:left'><input type=\"checkbox\" name=\"list[]\"   value=\"".$id_liste."\" />&nbsp;</div>" ;
            echo "<a href='".$self.$id_liste."' title='"._T('spiplistes:infos_liste')."'>$titre_liste</a><br />" ;
			echo "</div>" ;
			}
			echo "</div><br />" ;

		
		    } // fin du test nb listes



               /**************/
		
		
        echo  "<div style='clear:both; width:350px'>";
		bloog_extra_saisie('', 'auteurs', 'inscription');
		echo  "</div>";
                
        echo  "<div style='width:350px'>";
		if(($acces_membres == 'oui') OR ($type=='redac')) {
                echo  "<p><b>"._T('form_pet_votre_nom')."</b><br />";
		echo  "<input type=\"text\" class=\"forml\" name=\"nom_inscription\" value=\"\" size=\"35\" /> </p>";
		}
        echo  "<p><b>"._T('form_pet_votre_email')."</b><br />";
		echo  "<input type=\"text\" class=\"forml\" name=\"mail_inscription\" value=\"\" size=\"35\" />";
		echo  "</div>";   
        echo  "<div style=\"text-align:right\"><input type=\"submit\" name=\"Valider\" class=\"spip_bouton\" value=\""._T('bouton_valider')."\">";
		echo  "</div></fieldset></div></form>";
	}
}


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