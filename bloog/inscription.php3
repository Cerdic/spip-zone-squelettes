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



// Envoi d'un mail de confirmation :
// mettre "oui" si votre site propose un acces membres 
// et envoyer les login et pass à l'inscription,
// mettre "non" si votre site ne propose pas d'espace membre mais juste la lettre d'info.

$acces_membres = 'non';

$inscriptions_ecrire = (lire_meta("accepter_inscriptions") == "oui") ;

/* permet d'afficher les liens vers les options

echo "<a href='".$PHP_SELF."'>"._T('bloog:abonner')."</a> | ";
if($inscriptions_ecrire) echo"<a href='".$PHP_SELF."?type=redac'>"._T('bloog:devenir_redac')."</a> | ";
echo "<a href='".$PHP_SELF."?oubli_pass=oui'>"._T('login_motpasseoublie')."</a>";
echo "<a href='".$PHP_SELF."?desinscription=oui'>"._T('bloog:desabo')."</a>";
*/


// code inscription au site ou/et à la lettre d'info

include ("ecrire/inc_version.php3");
include_ecrire ("inc_meta.php3");
include_ecrire ("inc_session.php3");
include_ecrire ("inc_filtres.php3");
include_ecrire ("inc_texte.php3");
include_ecrire ("inc_meta.php3");
include_ecrire ("inc_mail.php3");
include_ecrire ("inc_acces.php3");

//utiliser_langue_site();





unset($erreur);



// recuperer le cookie de relance
if ($p = addslashes($p)) {
	$oubli_pass = 'oui';
	$res = spip_query ("SELECT * FROM spip_auteurs WHERE cookie_oubli='$p' AND statut<>'5poubelle' AND pass<>''");
	if ($row = spip_fetch_array($res)) {
		if ($pass) {
			$mdpass = md5($pass);
			$htpass = generer_htpass($pass);
			spip_query ("UPDATE spip_auteurs SET htpass='$htpass', pass='$mdpass', alea_actuel='',
				cookie_oubli='' WHERE cookie_oubli='$p'");

			$login = $row['login'];
			$erreur = "<b>"._T('pass_nouveau_enregistre')."</b>".
			"<p>"._T('pass_rappel_login', array('login' => $login));
		} else {
			echo _T('pass_nouveau_pass')."<br>\n";
			echo "<p><br>";
			echo "<form action='".$PHP_SELF."' method='post'>";
			echo "<input type='hidden' name='p' value='".htmlspecialchars($p)."'>";
			echo _T('pass_choix_pass')."<br>\n";
			echo "<input type='password' name='pass' value=''>";
			echo '  <input type=submit class="fondl" name="oubli" value="'._T('pass_ok').'"></div></form>';
			exit;
		}
	}
	else
		$erreur = _T('pass_erreur_code_inconnu');
}



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
	echo"<h2>"._T('pass_mot_oublie')."</h2><br>\n";
	
	echo "<p>";
	if ($erreur)
		echo $erreur;
	else {
		echo _T('pass_indiquez_cidessous');

		echo "<p>";
		echo "<form action='".$PHP_SELF."' method='post'>";
		echo "<div align='right'>";
		echo "<input type='text' class='fondo' name='email_oubli' value=''>";
		echo "<input type='hidden' name='oubli_pass' value='oui'>";
		echo "<input type=submit class='fondl' name='oubli' value='OK'></div></form>";
	}
}


else if ($inscriptions_ecrire || (lire_meta('accepter_visiteurs') == 'oui') OR (lire_meta('forums_publics') == 'abo')) {
	// debut presentation
		
	echo "<p>";

	if ($type=="redac" AND $inscriptions_ecrire){
		echo "<h2>"._T('bloog:devenir_redac')."</h2>";
                echo "<p>"._T('bloog:inscription_redacteurs');
         echo "\n<p>";
	}else{
		if($acces_membres == 'oui'){
	        echo "<h2>"._T('bloog:devenir_abonne')."</h2>";
                echo "<p>"._T('bloog:inscription_visiteurs');
                echo "\n<p>";
                }

	}

	formulaire_inscription(($type=="redac")? 'redac' : 'forum',$acces_membres);
}



function test_login_bloog($mail) {
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

        if($acces_membres == 'non') $nom_inscription = test_login_bloog($mail_inscription) ;
	
	//utiliser_langue_site();
$nomsite=lire_meta("nom_site");
$urlsite=lire_meta("adresse_site");

        if ($mail_inscription && $nom_inscription) {
		$query = "SELECT * FROM spip_auteurs WHERE email='".addslashes($mail_inscription)."'";
		$result = spip_query($query);

		echo "<div class='reponse_formulaire'>";

		// l'abonne existe deja.
	 	if ($row = spip_fetch_array($result)) {
			$id_auteur = $row['id_auteur'];
			$statut = $row['statut'];

			unset ($continue);
			if ($statut == '5poubelle')
				echo "<b>Vous n'avez plus accès à ce site</b>";
			else if ($statut == 'nouveau') {
				spip_query ("DELETE FROM spip_auteurs WHERE id_auteur=$id_auteur");
				$continue = true;
			} else {
        			       	    // envoyer le cookie de relance modif abonnement
        
        				$cookie = creer_uniqid();
        				spip_query("UPDATE spip_auteurs SET cookie_oubli = '$cookie' WHERE email ='$mail_inscription'");
        
        				$message = _T('bloog:abonnement_mail_passcookie', array('nom_site_spip' => $nomsite, 'adresse_site' => $urlsite, 'cookie' => $cookie));
        				if (envoyer_mail($mail_inscription, "[$nomsite] "._T('bloog:abonnement_titre_mail'), $message))
        					{echo _T('bloog:pass_recevoir_mail');}

                                        else
        					{echo _T('pass_erreur_probleme_technique');}
                                               
                                        }

		} else
			$continue = true;


		// envoyer identifiants par mail
		if ($continue) {
			//include_ecrire("inc_acces.php3");
			$pass = creer_pass_aleatoire(8, $mail_inscription);
			$login = test_login_bloog($mail_inscription);
			$mdpass = md5($pass);
			$htpass = generer_htpass($pass);
			

			$extras = bloog_extra_recup_saisie('auteurs');
			
			$query = "INSERT INTO spip_auteurs (nom, email, login, pass, statut, htpass, extra) ".
				"VALUES ('".addslashes($nom_inscription)."', '".addslashes($mail_inscription)."', '$login', '$mdpass', '$statut', '$htpass', '$extras')";
			$result = spip_query($query);
			ecrire_acces();

			$nom_site_spip = lire_meta("nom_site");
			$adresse_site = lire_meta("adresse_site");

			$message = _T('form_forum_message_auto')."\n\n"._T('bloog:form_forum_bonjour')."\n\n";
			
                        if ($GLOBALS['suppl_abo']=="non"){
                        $message .= _T('bloog:bloogletter_mail_non', array('nom_site_spip' => $nom_site_spip))."\n";
                        }else {
                        $message .= _T('bloog:bloogletter_mail_format', array('nom_site_spip' => $nom_site_spip))." : ".$GLOBALS['suppl_abo']."\n";
                        }
                        
                        if($acces_membres == 'oui'){
                          if ($type == 'forum') {
			  $message .="\n\n"._T('bloog:inscription_mail_forum', array('nom_site_spip' => $nom_site_spip, 'adresse_site' => $adresse_site))."\n\n";
                          }
		 	  else {
			  $message .="\n\n"._T('bloog:inscription_mail_redac', array('nom_site_spip' => $nom_site_spip, 'adresse_site' => $adresse_site))."\n\n";
			  }
                        
                        $message .= "- "._T('form_forum_login')." $login\n";
			$message .= "- "._T('form_forum_pass')." $pass\n\n";
                        }
                        else{
                        $message .= "\n\n"._T('bloog:abonnement_mail')." ".$adresse_site."/abonnement.php3";
                        }

			if (envoyer_mail($mail_inscription, "[$nom_site_spip] "._T('bloog:form_forum_identifiants'), $message)) {
				if($acces_membres == 'oui'){
                                echo _T('form_forum_identifiant_mail');
                                }else{
                                echo _T('bloog:form_forum_identifiant_confirm');
                                }
			}
			else {
				echo _T('form_forum_probleme_mail');
			}
		}
		echo "</div>";
	}
	else {
		if($acces_membres == 'oui'){
                echo _T('form_forum_indiquer_nom_email');
                }

		$link = $GLOBALS['clean_link'];
		echo $link->getForm('GET');
		
		//include('ecrire/inc_extra.php3');
		bloog_extra_saisie('', 'auteurs', 'inscription');
		
                if(($acces_membres == 'oui') OR ($type=='redac')) {
                echo  "<p><B>"._T('form_pet_votre_nom')."</B><BR>";
		echo  "<INPUT TYPE=\"text\" CLASS=\"forml\" NAME=\"nom_inscription\" VALUE=\"\" SIZE=\"35\">";
		}
		echo  "<P><B>"._T('form_pet_votre_email')."</B><BR>";
		echo  "<INPUT TYPE=\"text\" CLASS=\"forml\" NAME=\"mail_inscription\" VALUE=\"\" SIZE=\"30\">";
		echo  "<DIV ALIGN=\"right\"><INPUT TYPE=\"submit\" NAME=\"Valider\" CLASS=\"spip_bouton\" VALUE=\""._T('bouton_valider')."\">";
		echo  "</DIV></FORM>";
	}
}

?>
