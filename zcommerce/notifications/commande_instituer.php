<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
/*
 * Plugin Notifications
 * (c) 2009 SPIP
 * Distribue sous licence GPL
 *
 */


// Fonction appelee par divers pipelines

function notifications_commande_instituer_dist($quoi, $id_commande, $options) {
	
	// ne devrait jamais se produire
	if ($options['statut'] == $options['statut_ancien']) {
		spip_log("statut inchange",'notifications');
		return;
	}
	// envoie une notification si la commande est en statut paye
	if($options['statut']!='paye') return;
		
	include_spip('inc/texte');
	$modele = "notifications/commande_vendeur";
	$destinataires = array();
	
	$query = sql_select("email","spip_auteurs","statut = '0minirezo'");

	// notifier uniquement les webmestres ?
	if ($GLOBALS['notifications']['inscription'] == 'webmestres') {
		$query = sql_select("email","spip_auteurs","statut = '0minirezo' AND webmestre = 'oui'");
	}

	while ($row = sql_fetch($query)) {
		$destinataires[] = $row["email"];
		//spip_log("notifications_commande_instituer_dist mailto webmasters ".$row["email"],'notifications');
	}
	
	$destinataires = pipeline('notifications_destinataires',
		array(
			'args'=>array('quoi'=>$quoi,'id'=>$id_commande,'options'=>$options),
			'data'=>$destinataires)
	);
		
	//
	// Envoyer les emails
	//
	foreach ($destinataires as $email) {
		$texte = email_notification_objet($id_commande, "commande", $modele);
		notifications_envoyer_mails($email, $texte);
		//spip_log("notifications_commande_instituer_dist mailto vendeur ".$email,'notifications');
	}

	// puis on recherche l'auteur de la commande
	$id_auteur=$options['id_auteur'];
	if(!$id_auteur)
		$id_auteur=sql_getfetsel("id_auteur","spip_commandes","id_commande=".$id_commande);
	
	//envoyer un mail different pour le client		
	$mailclient = sql_getfetsel("email","spip_auteurs","id_auteur=".$id_auteur);

	if ($mailclient!=''){
		$modele = "notifications/commande_client";

		$destinataires = pipeline('notifications_destinataires',
			array(
				'args'=>array('quoi'=>$quoi,'id'=>$id_commande,'options'=>$options),
				'data'=>$mailclient)
		);
		//spip_log("notifications_commande_instituer_dist mailto client ".$mailclient,'notifications');

		$texte = email_notification_objet($id_commande, "commande", $modele);
		notifications_envoyer_mails($destinataires, $texte);
	}
}

?>