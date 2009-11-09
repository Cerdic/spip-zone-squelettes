<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2008                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;


function formulaires_proposer_site_charger_dist($id_rubrique) {

	return array('nom_site'=>'','url_site'=>'http://','description_site'=>'','url_syndic_site'=>'');
}

function formulaires_proposer_site_verifier_dist($id_rubrique){

	$erreurs = array();
	if (!$nom = _request('nom_site'))
		$erreurs['nom_site'] = _T("info_obligatoire");
	else {
		if((strlen ($nom) < 2) OR (strlen(_request('nobot'))>0))
			$erreurs['email_message_auteur'] = _T('form_prop_indiquer_nom_site');
	}



	// verifier que si un email a été saisi, il est bien valide :
	include_spip('inc/filtres');


	if (!$url = _request('url_site'))
		$erreurs['url_site'] = _T("info_obligatoire");

	  $url_syndic = _request('url_syndic_site');

	// pas d'erreurs sur le remplissage des champs on continue (vérif urls site et syndic)
	if (!count($erreurs)) {
		// Tester l'URL du site
		include_spip('inc/distant');
		if (!recuperer_page($url))
			$erreurs['url_site'] = _T('form_pet_url_invalide');
		
		// Tester la présence du site => provoque une erreur "pb mysql"
		if (sql_countsel('spip_syndic',"url_site='$url'"))
			 //$erreurs['url_site'] = "Ce site est déjà présent dans l'annuaire. Si vous souhaitez modifier les infos, <a href=\"http://moto-sites.net/?page=contact\">utilisez le formulaire de contact</a>.";
		 return array('message_erreur' => "Ce site est déjà présent dans l'annuaire. Si vous souhaitez modifier les infos, <a href=\"/?page=contact\">utilisez le formulaire de contact</a>.");
			 
		// Tester l'URL du flux de syndication
		if ($url_syndic && !recuperer_page($url_syndic))
			$erreurs['url_syndic_site'] = _T('form_pet_url_invalide');
	}
	return $erreurs;
}

function formulaires_proposer_site_traiter_dist($id_rubrique){
include_spip('base/abstract_sql');
$res = array('message_erreur'=>_T('titre_probleme_technique'));
	$nom = _request('nom_site');
	$url = _request('url_site');
	$url_syndic = _request('url_syndic_site');
	$desc = _request('description_site');

      
	// Enregistrement dans la base : site en attente de validation
	if ($id_syndic = sql_insertq('spip_syndic', array(
		'nom_site' => $nom,
		'url_site' => $url,
		'url_syndic' => $url_syndic,
		'id_rubrique' => $id_rubrique,
		'id_secteur' => sql_getfetsel('id_secteur','spip_rubriques','id_rubrique='.sql_quote($id_rubrique)),
		'descriptif' => $desc,
		'date' => 'NOW()',
		'date_syndic' => 'NOW()',
		'statut' => 'prop',
		'syndication' => 'non')))
	  {
	      

	       
	       // Envoi du mail au visiteur qui vient de proposer le site
	       include_spip('inc/mail');
	       include_spip('inc/facteur_classes');

	       $sujet_email_vis = " Proposition de site dans l'annuaire";
	       $corps['html']    = recuperer_fond("notifications/proposer_site_html", array('id_syndic' => $id_syndic));
	       $corps['texte']    = recuperer_fond('notifications/proposer_site_txt', array('id_syndic'=>$id_syndic));
	      
	       
	       // Erreur en cas d'envoi du mail
	       if(!envoyer_mail($email_proprio, "  proposition de site", $corps)) {
	       //if (!$mail_proposer_site->Send()) {
		    echo $mail_proposer_site->ErrorInfo;
		    $res =  array('message_erreur' => "Votre site a été enregistré mais une erreur a eu lieu dans l'envoi de mail, merci de nous contacter", 'id_syndic'=>$id_syndic);
	       } else {
	       // le site est enregistré, le mail a été envoyé
		     $res = array('message_ok' => _T('form_prop_enregistre'), 'id_syndic'=>$id_syndic);
		     
		     // on averti le webmestre
		     $message_admin    = recuperer_fond('notifications/proposer_site_admin', array(
			 'url' => $url,
			 'desc' => $desc,
			 'url_syndic' => $url_syndic,
			 ));
	       }
	
	       // Est ce que le plugin facteur est configuré ?
		if ($GLOBALS['meta']['facteur_adresse_envoi'] == 'oui')
	                $destinataire = $GLOBALS['meta']['facteur_adresse_envoi_email'];
	            else
	                $destinataire = $GLOBALS['meta']['email_webmaster'];	
	      
	      $contenu_email_admin = "Le site $nom a été soumis dans l'annuaire par $nom_proprio ($email_proprio)
    
URL : $url
Description : $desc
Syndic $url_syndic


/ecrire/?exec=sites_edit&id_syndic=$id_syndic
 ";
	    envoyer_mail($destinataire, " proposition de site", $contenu_email_admin);
	  }

	  

	return $res;
}

?>
