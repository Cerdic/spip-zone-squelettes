<?php

if (!defined("_ECRIRE_INC_VERSION")) return;	#securite

// Le contexte indique dans quelle rubrique le visiteur peut proposer le site
global $balise_FORMULAIRE_ECRIRE_BREVE_collecte;
$balise_FORMULAIRE_ECRIRE_BREVE_collecte = array('id_secteur', 'lang');

function balise_FORMULAIRE_ECRIRE_BREVE_stat($args, $filtres) {
	if (!$args[0]) $args[0]=2;
	if (!$args[1]) $args[2]='fr';
	if ($GLOBALS["auteur_session"]) $args[3]=$GLOBALS["auteur_session"]["statut"];
	else $args[2]='5public';
	return $args;
	
}

function balise_FORMULAIRE_ECRIRE_BREVE_dyn($id_secteur,$lang,$statut) {

	// Verifier que les visisteurs sont autorises a proposer un site
	if ((((lire_meta("proposer_sites")== 2) && ($GLOBALS["auteur_session"]))||
		((lire_meta("proposer_sites")== 1) && ($GLOBALS["auteur_session"]["statut"]=="1comite"))||
		($GLOBALS["auteur_session"]["statut"]=="0minirezo"))) 
		//return array('formulaire_login', 0);
	{
		$auteur_statut=$GLOBALS["auteur_session"]["statut"];
		if (!_request('titre')) return array('formulaire_ecrire_breve', 0, array('message' => '' , 'auteur_statut' => $auteur_statut));
	 
		// Tester le nom du site
		if (strlen (_request('titre')) > 0){
		
		// Tester l'URL du site
		 	if ((strlen (_request('nom_site')) > 0)&&(strlen (_request('url_site')) > 0)){
		 		include_ecrire("inc_sites.php3");
				if (!recuperer_page(_request('url_site')))
					return _T('form_pet_url_invalide');
			}
		
			$id_auteur=$GLOBALS['auteur_session']['id_auteur'];
			if ($GLOBALS["auteur_session"]["statut"]=="0minirezo") $statut=addslashes(_request('statut'));
			else $statut='';
			$titre = addslashes(_request('titre'));
			$texte = addslashes(_request('texte'));
			$nom_site = addslashes(_request('nom_site'));
			$url_site = addslashes(_request('url_site'));
			$accepter_forum=lire_meta('forums_publics');
			if (!$accepter_forum) $accepter_forum='abo';
			$query="INSERT INTO spip_breves (titre, texte, nom_site, url_site,statut, id_rubrique, date_heure, lang, maj) " .
									"VALUES ('$titre','$texte', '$nom_site', '$url_site','$statut', $id_secteur,  NOW(), '$lang', NOW())";
			spip_query($query);
			$mId=mysql_insert_id();
			if ($mId>0){ 
				suivre_invalideur("id='id_rubrique/$id_rubrique'");
				$message='<div class="spip_encadrer">'._T('form_prop_enregistre').'</div>';
				//return  "<script type=\"text/javascript\">window.onload = function(){/*window.close();*/}</script>";
			}
			else { 
				$message='<div class="spip_encadrer">'._T('erreur').'</div>';
			}
		}
	}
	else {
		//$auteur_statut='5public';
		return array('formulaire_login_forum', 0);
	}
	return array('formulaire_ecrire_breve', 0, array('message' => $message, 'auteur_statut' => $auteur_statut));
}

?>
