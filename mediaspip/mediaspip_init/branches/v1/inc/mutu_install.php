<?php
/**
 * Plugin MediaSPIP Init
 * © 2010 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Récupère des infos sur le site central de la mutu
 * - Titre du site
 * - Description du site
 * - Email du webmaster
 */
function inc_mutu_install_dist(){
	/**
	 * On vérifie tout d'abord que l'on est bien dans une mutualisation et que l'on n'a qu'un seul site maitre
	 */
	if(defined('_SITES_ADMIN_MUTUALISATION') && (count(explode(',',_SITES_ADMIN_MUTUALISATION)) == 1)){
		include_spip('inc/xml');
		include_spip('inc/distant');
		include_spip('action/iconifier');
		
		/**
		 * On utilisera notre adresse sans http pour fournir de quoi à la mutu pour nous reconnaitre
		 */
		$url_site = str_replace('http://','',$GLOBALS['meta']['adresse_site']);
		/**
		 * On génère l'URL à appeler sur la mutu
		 */
		$url_distant = 'http://'._SITES_ADMIN_MUTUALISATION.'/spip.php?page=mutu_infos_instances&url='.$url_site;
		/**
		 * On crée l'arbre xml de ce que l'on récupère sur le site principale de la mutualisation
		 */
		$infos_mutus = spip_xml_load($url_distant, true, true, $taille_max = 1048576, $datas='', $profondeur = -1);
		if(is_array($infos_mutus)){
			include_spip('inc/meta');
			include_spip('inc/actions');// pour determine_upload()
			/**
			 * Le nom du site
			 */
			if(isset($infos_mutus['infos'][0]['titre'])){
				ecrire_meta("nom_site", $infos_mutus['infos'][0]['titre'][0]);
			}
			/**
			 * Le descriptif du site
			 */
			if(isset($infos_mutus['infos'][0]['descriptif'][0])){
				ecrire_meta("descriptif_site", $infos_mutus['infos'][0]['descriptif'][0]);
			}
			/**
			 * L'email du webmaster
			 */
			if(isset($infos_mutus['infos'][0]['email_webmaster'][0])){
				ecrire_meta("email_webmaster", $infos_mutus['infos'][0]['email_webmaster'][0]);
			}
			/**
			 * Le logo du site
			 */
			if(isset($infos_mutus['infos'][0]['logo'])){
				$ajouter_image = charger_fonction('spip_image_ajouter','action');
				$source = copie_locale($infos_mutus['infos'][0]['logo'][0]);
				if (file_exists($source)) {
					$new_source = determine_upload().basename($source);
					@rename($source,$new_source);
					$chercher_logo = charger_fonction('chercher_logo','inc');
					$logo = $chercher_logo('', 'site', 'on');
					$type = type_du_logo('site');
					if ($logo)
						spip_unlink($logo[0]);
					$ajouter_image($type.'on0',true,basename($new_source));
				}
			}
			/**
			 * Les informations de l'id_admin qui doit être le premier auteur créé
			 */
			if(is_array($admin = $infos_mutus['infos'][0]['admin'][0])){
				foreach($admin as $info => $value){
					$admin_final[$info] = $value[0];
				}
				$admin_final['statut'] = '0minirezo';
				$admin_final['webmestre'] = 'oui';
				/**
				 * On enlève le logo_auteur si présent et on le stock dans une variable
				 */
				if(isset($admin_final['logo_auteur'])){
					$logo_auteur = $admin_final['logo_auteur'];
					unset($admin_final['logo_auteur']);
				}
				/**
				 * Si le même auteur avec la même adresse email a été créé à l'installation
				 * On met seulement à jour avec les informations récupérées 
				 */
				if($id_auteur = sql_getfetsel('id_auteur','spip_auteurs','email='.sql_quote($admin_final['email']))){
					$infos_actuelles = sql_fetsel('*','spip_auteurs','id_auteur='.intval($id_auteur));
					$infos_admin = array_merge($admin_final,$infos_actuelles);
					sql_updateq('spip_auteurs',$infos_admin,'id_auteur='.intval($id_auteur));
				}
				/**
				 * S'il n'y a pas eu de création d'auteur à l'installation,
				 * on en crée un depuis les informations récupérées
				 * Attention : cet auteur ne sera pas automatiquement fonctionnel, il devra demander un rappel de
				 * mot de passe avant de pouvoir se loguer sur le site 
				 */
				else{
					$id_auteur = sql_insertq('spip_auteurs',$admin_final);
					/**
					 * On notifie cet auteur qu'il va devoir récupérer son mot de passe via 
					 * "Mot de passe oublié" pour pouvoir se connecter 
					 */
					if ($notifications = charger_fonction('notifications', 'inc')) {
						$notifications('mediaspip_recuperation_compte', $id_auteur);
					}
				}
				/**
				 * Si on a un logo, on l'ajoute à l'auteur
				 */
				if($logo_auteur){
					$ajouter_image = charger_fonction('spip_image_ajouter','action');
					$source = copie_locale($logo_auteur);
					if (file_exists($source)) {
						$new_source = determine_upload().basename($source);
						@rename($source,$new_source);
						$chercher_logo = charger_fonction('chercher_logo','inc');
						$logo = $chercher_logo($id_auteur, 'auteur', 'on');
						$type = 'aut';
						if ($logo)
							spip_unlink($logo[0]);
						$ajouter_image($type.'on'.$id_auteur,true,basename($new_source));
					}
				}
			}
			if(is_array($piwik = $infos_mutus['infos'][0]['piwik'][0])){
				/**
				 * La configuration piwik fournie
				 */
				if(
					isset($piwik['piwik_server']) &&
					isset($piwik['piwik_id']) &&
					isset($piwik['piwik_user']) &&
					isset($piwik['piwik_token'])
				){
					$piwik_config = array(
						'urlpiwik' => $piwik['piwik_server'][0],
						'user' => $piwik['piwik_user'][0],
						'token' => $piwik['piwik_token'][0],
						'idpiwik' => $piwik['piwik_id'][0],
						'mode_insertion' => 'balise'
					);
					ecrire_meta('piwik',serialize($piwik_config));
				}
			}
		}
	}
}

?>