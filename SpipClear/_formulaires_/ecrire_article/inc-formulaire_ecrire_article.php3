<?php

if (!defined("_ECRIRE_INC_VERSION")) return;	#securite

// Le contexte indique dans quelle rubrique le visiteur peut proposer le site
global $balise_FORMULAIRE_ECRIRE_ARTICLE_collecte;
$balise_FORMULAIRE_ECRIRE_ARTICLE_collecte = array('id_rubrique', 'id_secteur', 'lang');

function balise_FORMULAIRE_ECRIRE_ARTICLE_stat($args, $filtres) {

	// Pas d'id_rubrique ? Erreur de squelette
/*	if (!$args[0])
		return erreur_squelette(
			_T('zbug_champ_hors_motif',
				array ('champ' => '#FORMULAIRE_ECRIRE_ARTICLE',
					'motif' => 'RUBRIQUES')), '');
*/
	if (!$args[0]) $args[0]=2;
	if (!$args[1]) $args[1]=2;
	if (!$args[2]) $args[2]='fr';
	if ($GLOBALS["auteur_session"]) $args[3]=$GLOBALS["auteur_session"]["statut"];
	else $args[3]='5public';

	// Verifier que les visisteurs sont autorises a proposer un site
	/*
	//return (((lire_meta("proposer_sites")!= 2) || (!$GLOBALS["auteur_session"])) ? '' : $args);
	if (((lire_meta("proposer_sites")== 2) && ($GLOBALS["auteur_session"]))||
		((lire_meta("proposer_sites")== 1) && ($GLOBALS["auteur_session"]["statut"]=="1comite"))||
		($GLOBALS["auteur_session"]["statut"]=="0minirezo")) return $args;
	else return '';
	*/
	return $args;
	
}

function balise_FORMULAIRE_ECRIRE_ARTICLE_dyn($id_rubrique,$id_secteur,$lang,$statut) {

	// Verifier que les visisteurs sont autorises a proposer un site
	if ((((lire_meta("proposer_sites")== 2) && ($GLOBALS["auteur_session"]))||
		((lire_meta("proposer_sites")== 1) && ($GLOBALS["auteur_session"]["statut"]=="1comite"))||
		($GLOBALS["auteur_session"]["statut"]=="0minirezo"))) 
		//return array('formulaire_login', 0);
	{
		$auteur_statut=$GLOBALS["auteur_session"]["statut"];
		if (!_request('titre')) return array('formulaire_ecrire_article', 0, array('message' => '' , 'auteur_statut' => $auteur_statut));
	 
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
			$descriptif = addslashes(_request('descriptif'));
			$texte = addslashes(_request('texte'));
			$nom_site = addslashes(_request('nom_site'));
			$url_site = addslashes(_request('url_site'));
			$accepter_forum=lire_meta('forums_publics');
			if (!$accepter_forum) $accepter_forum='abo';
			$query="INSERT INTO spip_articles (titre, descriptif, texte, nom_site, url_site,statut, id_secteur, id_rubrique, date, lang, accepter_forum,date_modif,auteur_modif) " .
									"VALUES ('$titre','$descriptif','$texte', '$nom_site', '$url_site','$statut', $id_secteur, $id_rubrique,  NOW(), '$lang','$accepter_forum', NOW(), $id_auteur)";
			spip_query($query);
			$mId=mysql_insert_id();
			if ($mId>0){ 
				$id_auteur=$GLOBALS['auteur_session']['id_auteur'];
				spip_query("INSERT INTO spip_auteurs_articles(id_auteur,id_article) VALUES ($id_auteur,$mId)");
				
/*				$adresse_site = lire_meta("adresse_site");
				$query="SELECT id_syndic FROM spip_syndic WHERE url_syndic='".$adresse_site."/backend.php3?id_rubrique=".$id_rubrique."' AND syndication IN ('oui', 'sus', 'off')";
				$result = spip_query ($query);
				if ($result AND spip_num_rows($result)>0){
					//syndiquer
					$row_syndic=spip_fetch_array($result);
					$id_syndic=$row_syndic[0];
					include_ecrire ("inc_sites.php3");
					$erreur_syndic = syndic_a_jour ($id_syndic);
					include_ecrire ("inc_invalideur.php3");
					//invalider cache article
					suivre_invalideur("id='id_rubrique/$id_rubrique'");
				}
*/
				//invalider cache article
				//quand on fera les modifs
				//suivre_invalideur("id='id_article/mId'");
				//invalider cache rubrique
				suivre_invalideur("id='id_rubrique/$id_rubrique'");
				$message='<div class="spip_encadrer">'._T('form_prop_enregistre').'<br/><br/><form><input class="spip_bouton" type="submit" value="Fermer" onclick="window.close();"/></form></div>';
				//return  "<script type=\"text/javascript\">window.onload = function(){/*window.close();*/}</script>";
			}
			else { 
				$message='<div class="spip_encadrer">'._T('erreur').'<br/><br/><form><input class="spip_bouton" type="submit" value="Fermer" onclick="window.close();"/></form></div>';
			}
		}
	}
	else {
		//$auteur_statut='5public';
		return array('formulaire_login_forum', 0);
	}
	return array('formulaire_ecrire_article', 0, array('message' => $message, 'auteur_statut' => $auteur_statut));
}

?>
