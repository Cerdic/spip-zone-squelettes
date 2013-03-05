<?php
/**
 * Plugin MediaSPIP Init
 * © 2010-2012 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 * Notification lorsque l'on récupère un compte sur un site maitre de mutualisation
 */


/**
 * Fonction appelé pour notifier la récupération d'un utilisateur sur le site maitre de la mutualisation
 *
 * @param string $quoi L'action
 * @param int $id_auteur L'identifiant de l'auteur dans la table spip_auteurs
 * @param array $options
 */
function notifications_mediaspip_recuperation_compte_dist($quoi, $id_auteur, $options=array()) {
	include_spip('inc/texte');

	$modele = "notifications/mediaspip_recuperation_compte";

	if ($modele){
		$destinataires = array();

		$destinataires = pipeline('notifications_destinataires',
			array(
				'args'=>array('quoi'=>$quoi,'id'=>$id_auteur,'options'=>$options)
			,
				'data'=>$destinataires)
		);
		
		$envoyer_mail = charger_fonction('envoyer_mail','inc'); // pour nettoyer_titre_email
		
		$texte = recuperer_fond($modele,array('id_auteur'=>$id_auteur,'site_maitre'=>'http://'._SITES_ADMIN_MUTUALISATION));
		
		notifications_envoyer_mails($destinataires, $texte);
	}
}

?>