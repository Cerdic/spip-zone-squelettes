<?php

if (!defined("_ECRIRE_INC_VERSION")) return;	#securite

global $balise_FORMULAIRE_PASS_collecte;
$balise_FORMULAIRE_PASS_collecte = array();

function balise_FORMULAIRE_PASS_stat ($args, $filtres) {
	
	return array($args,$filtres);
}

function balise_FORMULAIRE_PASS_dyn($args,$filtres)
{
	include_ecrire("inc_presentation.php3"); # pour install_debut
	include_ecrire("inc_session.php3"); # pour creer_uniq_id
	include_ecrire("inc_mail.php3"); # pour envoyer_mail
	include_ecrire("inc_acces.php3"); # pour generer_htpass
	include_local("inc-public-global.php3"); # pour calculer la page
	include_local ("inc-cache.php3"); # ici c'est pour tester la connexion SQL
	include_ecrire("inc_lang.php3");
	
	utiliser_langue_site();
	utiliser_langue_visiteur();
	
	$oubli=$_REQUEST['oubli'];
	$p=$_REQUEST['p'];
	
//	spip_log("???".$p."???".$oubli."???".serialize($GLOBALS['auteur_session']));
	
	$message = '';
	
	// au 3e appel la variable P est positionnee par le script lui-meme
	// et oubli = mot passe. Le choix du nom P est impose par pass_mail_passcookie
	if ($p = addslashes($p)) {
		$res = spip_query("SELECT * FROM spip_auteurs WHERE cookie_oubli='$p' AND statut<>'5poubelle' AND pass<>''");
		if (!$row = spip_fetch_array($res)) 
			$message = _T('pass_erreur_code_inconnu');
		else {
			if ($oubli) {
				$mdpass = md5($oubli);
				$htpass = generer_htpass($oubli);
				spip_query("UPDATE spip_auteurs SET htpass='$htpass', pass='$mdpass', alea_actuel='',
					cookie_oubli='' WHERE cookie_oubli='$p'");
	
				$login = $row['login'];
				$message = "<b>" . _T('pass_nouveau_enregistre') . "</b>".
				"<p>" . _T('pass_rappel_login', array('login' => $login));
			}
		}
	 } else { 
	  // si p absent, oubli vaut alors le mail au 2e appel, vide au 1e
	  if ($oubli) {
		if ( email_valide($oubli) ) {
			$email = addslashes($oubli);
			$res = spip_query("SELECT * FROM spip_auteurs WHERE email ='$email'");
			if ($row = spip_fetch_array($res)) {
				if ($row['statut'] == '5poubelle' OR $row['pass'] == '')
					$message = _T('pass_erreur_acces_refuse');
				else {
					$cookie = creer_uniqid();
					spip_query("UPDATE spip_auteurs SET cookie_oubli = '$cookie' WHERE email ='$email'");
	
					if ( envoyer_mail($email,
							 "[" . lire_meta("nom_site") .'] ' .  _T('pass_oubli_mot'),
							 _T('pass_mail_passcookie',
							    array('nom_site_spip' => lire_meta("nom_site"),
								  'adresse_site' => lire_meta("adresse_site"), 
								  'cookie' => $cookie))))
						$message = _T('pass_recevoir_mail');
					else
						$message = _T('pass_erreur_probleme_technique');
				}
			}
			else
				$message = _T('pass_erreur_non_enregistre', array('email_oubli' => htmlspecialchars($oubli)));
		} else {
			$message = _T('pass_erreur_non_valide', array('email_oubli' => htmlspecialchars($oubli)));
		}
	  }
	 }
	if (($GLOBALS['auteur_session']['statut']=='6forum')
		||($GLOBALS['auteur_session']['statut']=='1comite')
		||($GLOBALS['auteur_session']['statut']=='0minirezo'))
		$oubli=$GLOBALS['auteur_session']['email'];
	else $oubli=$_REQUEST['oubli'];
	return array('formulaire_pass', 0, array('p' => $p, 'oubli' => $oubli, 'message' => $message));
}

?>
