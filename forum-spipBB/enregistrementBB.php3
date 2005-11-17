<?php

/******************************************************************************************/  
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

$acces_membres = 'oui';



// code inscription au site  


/******************************************************************/
if (!defined("_ECRIRE_INC_VERSION"))
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
		echo "<div class='bloogletter-right'>";
		echo "<input type='text' class='fondo' name='email_oubli' value='' />";
		echo "<input type='hidden' name='oubli_pass' value='oui' />";
		echo "<input type='submit' class='fondl' name='oubli' value=_T('pass_ok') /></div></form>";
	}
	echo "</p>";
}


else if ($inscriptions_ecrire || (lire_meta('accepter_visiteurs') == 'oui') OR (lire_meta('forums_publics') == 'abo')) {
	// debut presentation

	

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
		
       if(isset($mail_inscription) AND isset($nom_inscription) ) $obli="ok" ;
		
		if ($mail_valide AND $nom_inscription AND $obli=="ok") {
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
			echo "<b>_T('form_forum_access_refuse')</b>";
			}elseif ($statut == 'nouveau') {
			spip_query ("DELETE FROM spip_auteurs WHERE id_auteur=$id_auteur");
			$continue = true;
			}else{
        	// envoyer le cookie de relance modif abonnement
        
        	$cookie = creer_uniqid();
        	spip_query("UPDATE spip_auteurs SET cookie_oubli = '$cookie' WHERE email ='$mail_inscription'");
        
        	echo _T('phpbb:deja_enregistree') ;
				
                                               
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
			$result_ok = spip_query($query);
			$id_auteur=spip_insert_id();
			if(!$result_ok){
				echo _T('phpbb:pb_mysql') ;
				}

// abo

            ecrire_acces();

			$nom_site_spip = lire_meta("nom_site");
			$adresse_site = lire_meta("adresse_site");

			$message = _T('form_forum_message_auto')."\n\n"._T('phpbb:bonjour')."\n";
                      
        if(($acces_membres == 'oui') && ($type == 'forum') ){
                          
			$message .="\n\n "._T('phpbb:identifiant')."$nom_site_spip ($adresse_site)\n\n";
            $message .= "- "._T('form_forum_login')." $login\n";
			$message .= "- "._T('form_forum_pass')." $pass\n\n";
			$message .= "\n\n"._T('phpbb:connecte')."$adresse_site/profile.php3?id_auteur=$id_auteur\n\n";
                        }
               

        }

                       
		
		if($abonne_existant != 'oui' AND $result_ok){

			if (envoyer_mail($mail_inscription, "[$nom_site_spip] identifiants de connexion", $message)) {
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
        echo _T('phpbb:non_valide');
        }
		
		
		
		if($acces_membres == 'oui'){
        echo _T('phpbb:courrier');
        }
	
	$self=quote_amp($GLOBALS["clean_link"]->getUrl()) ;
	
	echo "<form action='".$self."' method='post'>";	

			$nom_site_spip = lire_meta("nom_site");
			$adresse_site = lire_meta("adresse_site");
			
               /******
		
		
        echo  "<div style='clear:both;'>";
		bloog_extra_saisie('', 'auteurs', 'inscription');
		echo  "</div>";
        ********/        
      echo"<style><!-- .formlbb{width:300px;} 
	  table.enregistrement td {text-align:left}
	  
	  --></style>"; 


	  echo  "<table class='enregistrement'><tr>";
		if(($acces_membres == 'oui') OR ($type=='redac')) {
        echo  "<td>"._T('phpbb:entree_nom_pseudo2')."&nbsp;*</td>";
		echo  "<td><input type=\"text\" class=\"formlbb\" name=\"nom_inscription\" value=\"\" size=\"35\" /> </td></tr>";
		}
		

echo  "<tr><td><p><b>"._T('form_pet_votre_email')."</b> &nbsp;:&nbsp;*</td>";
echo  "<td><input type=\"text\" class=\"formlbb\" name=\"mail_inscription\" value=\"\" size=\"35\" /></td></tr>";

echo  "</table>";  

echo "<p>"._T('phpbb:reglement');
		echo "</p>";
		
        echo  "<div style=\"text-align:right\"><input type=\"submit\" name=\"Valider\" class=\"spip_bouton\" value=\""._T('bouton_valider')."\">";
		echo  "</div></fieldset></div></form>";
	}
}


/******************************************************************************************/
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