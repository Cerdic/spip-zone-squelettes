<?php

if (!defined("_ECRIRE_INC_VERSION")) return;	#securite

include_local(find_in_path("inc-formulaire_inscription.php3"));

// Balise independante du contexte
global $balise_FORMULAIRE_PROFIL_collecte ;
$balise_FORMULAIRE_PROFIL_collecte = array();

// args[0] est le parametre 'focus' -- [(#FORMULAIRE_PROFIL{focus})]
function balise_FORMULAIRE_PROFIL_stat($args, $filtres) {
	return array('forum', ($args[0] == 'focus' ? 'nom_inscription' : ''));
}

function balise_FORMULAIRE_PROFIL_dyn($mode, $focus) {

	if (($GLOBALS['auteur_session']['statut']!="1comite")
	  &&($GLOBALS['auteur_session']['statut']!="0minirezo")
	  &&($GLOBALS['auteur_session']['statut']!="6forum")){
	  		// Si une inscription est autorisee, on enregistre le demandeur
		// comme 'nouveau' et on lui envoie ses codes par email ; lors de
		// sa premiere connexion il obtiendra son statut final (auth->activer())
		if (!(($mode == 'redac' AND lire_meta('accepter_inscriptions') == 'oui')
		OR ($mode == 'forum' AND (
			lire_meta('accepter_visiteurs') == 'oui'
			OR lire_meta('forums_publics') == 'abo'
			)
		    )))
			return _T('pass_rien_a_faire_ici');
	
		// recuperer les donnees envoyees
		$mail_inscription = trim(_request('mail_inscription'));
		$nom_inscription = _request('nom_inscription');
	
		if (!$nom_inscription) 
			$message = '';
		elseif (!test_mail_ins($mode, $mail_inscription))
			$message = _T('info_email_invalide');
		else	$message = message_inscription($mail_inscription,
						       $nom_inscription,
						       false,
						       ($mode == 'forum')  ?
						       'form_forum_voici1' :
						       'form_forum_voici2');
	
		return array("formulaire_profil_inscription", $GLOBALS['delais'],
				array('focus' => $focus,
					'target' => _request('target'),
					'message' => $message,
					'mode' => $mode,
					'self' => $GLOBALS["clean_link"]->getUrl()
					));
	}
	else {
		$table_pref = 'spip';
		if ($GLOBALS['table_prefix']) $table_pref = $GLOBALS['table_prefix'];
		
		$message='';
		if (_request("login")){
			$login =addslashes(_request("login"));
			$nom =addslashes(_request("nom"));
			$email =addslashes(_request("email"));
			$bio =addslashes(_request("bio"));
			$nom_site =addslashes(_request("nom_site"));
			$url_site =addslashes(_request("url_site"));
			include_ecrire("inc_extra.php3");
			$extra = extra_recup_saisie("auteurs");
			$add_extra = ", extra = '".addslashes($extra)."'";
			$query="update ".$table_pref."_auteurs set nom='$nom', email='$email', bio='$bio', nom_site='$nom_site', url_site='$url_site'$add_extra, maj=now() where id_auteur=".$GLOBALS['auteur_session']['id_auteur'];
			if ($result=spip_query($query)) $message="Modifications sauvegard&eacute;es";
			else $message="Erreur &agrave; l'enregistrement";
		}
		
		
		$result=spip_query("select * from ".$table_pref."_auteurs where id_auteur=".$GLOBALS['auteur_session']['id_auteur']);
		if ($r=spip_fetch_array($result))
			return array("formulaire_profil", $GLOBALS['delais'],
					array('login' => $r['login'],
						'nom' => $r['nom'],
						'email' => $r['email'],
						'bio' => $r['bio'],
						'nom_site' => $r['nom_site'],
						'url_site' => $r['url_site'],
						'extra' => $r['extra'],
						'message' => $message,
						'mode' => $mode,
						'self' => $GLOBALS["clean_link"]->getUrl()
					));
		else return "utilisateur inconnu";
	}
	
}

?>
