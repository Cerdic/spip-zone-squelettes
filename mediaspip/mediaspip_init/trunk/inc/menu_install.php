<?php
/**
 * Plugin MediaSPIP Init
 * © 2010-2012 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Install les menu
 */
function inc_menu_install_dist(){
	if(defined('_DIR_PLUGIN_MENUS')){
		include_spip('action/editer_menu');
		include_spip('action/editer_menus_entree');
		include_spip('inc/filtres');

		/**
		 * Définition du menu barrenav
		 */
		$barre_nav = sql_getfetsel('id_menu','spip_menus','identifiant="barrenav"');
		if(!intval($barre_nav))
			$barre_nav = insert_menu();

		if(intval($barre_nav)){
			$infos_menu = array('id_menus_entree' => 0, 'titre' => filtrer_entites(_T('mediaspip_init:menu_principal')),'identifiant' => 'barrenav');
			$err = menu_set($barre_nav, $infos_menu);
			
			$home_entree = sql_getfetsel('id_menus_entree','spip_menus_entrees','type_entree="accueil" AND id_menu='.intval($barre_nav));
			if(!intval($home_entree)){
				$entree = insert_menus_entree($barre_nav);
				$infos_entree = array(
					'rang' => 1,
					'type_entree' => 'accueil'
				);
				menus_entree_set($entree, $infos_entree);
			}
			
			$mapage_entree = sql_getfetsel('id_menus_entree','spip_menus_entrees','type_entree="mapage" AND id_menu='.intval($barre_nav));
			if(!intval($mapage_entree)){
				$entree = insert_menus_entree($barre_nav);
				$infos_entree = array(
					'rang' => 2,
					'type_entree' => 'mapage'
				);
				menus_entree_set($entree, $infos_entree);
			}

			$deconnecter_entree = sql_getfetsel('id_menus_entree','spip_menus_entrees','type_entree="deconnecter" AND id_menu='.intval($barre_nav));
			if(!intval($deconnecter_entree)){
				$entree = insert_menus_entree($barre_nav);
				$infos_entree = array(
					'rang' => 3,
					'type_entree' => 'deconnecter'
				);
				menus_entree_set($entree, $infos_entree);
			}

			$inscription_entree = sql_getfetsel('id_menus_entree','spip_menus_entrees','type_entree="inscription" AND id_menu='.intval($barre_nav));
			if(!intval($inscription_entree)){
				$entree = insert_menus_entree($barre_nav);
				$infos_entree = array(
					'rang' => 4,
					'type_entree' => 'inscription'
				);
				menus_entree_set($entree, $infos_entree);
			}

			$configurer_entree = sql_getfetsel('id_menus_entree','spip_menus_entrees','type_entree="ms_configurer" AND id_menu='.intval($barre_nav));
			if(!intval($configurer_entree)){
				$entree = insert_menus_entree($barre_nav);
				$infos_entree = array(
					'rang' => 5,
					'type_entree' => 'ms_configurer'
				);
				menus_entree_set($entree, $infos_entree);
			}

			$publier_entree = sql_getfetsel('id_menus_entree','spip_menus_entrees','type_entree="publier" AND id_menu='.intval($barre_nav));
			if(!intval($publier_entree)){
				$entree = insert_menus_entree($barre_nav);
				$infos_entree = array(
					'rang' => 6,
					'type_entree' => 'publier'
				);
				menus_entree_set($entree, $infos_entree);
			}
		}

		/**
		 * Définition du menu barrelaterale
		 */
		$barre_menu_nav = sql_getfetsel('id_menu','spip_menus','identifiant="barrelaterale"');
		if(!intval($barre_menu_nav))
			$barre_menu_nav = insert_menu();

		if(intval($barre_menu_nav)){
			$infos_menu = array('id_menus_entree' => 0, 'titre' => filtrer_entites(_T('mediaspip_init:menu_lateral')),'identifiant' => 'barrelaterale');
			$err = menu_set($barre_menu_nav, $infos_menu);
		}

		/**
		 * Définition du menu barrepied
		 * 
		 * -* On y insère automatiquement un lien vers la page de contact s'il n'existe dans aucun autre menu
		 * -* On y ajoute un lien vers chaque page unique s'il y en a
		 */
		$barre_pied = sql_getfetsel('id_menu','spip_menus','identifiant="barrepied"');
		if(!intval($barre_pied))
			$barre_pied = insert_menu();

		if(intval($barre_pied)){
			$infos_menu = array('id_menus_entree' => 0, 'titre' => filtrer_entites(_T('mediaspip_init:menu_pied')),'identifiant' => 'barrepied');
			$err = menu_set($barre_pied, $infos_menu);
			$contact_entree = sql_getfetsel('id_menus_entree','spip_menus_entrees','type_entree="contact"');
			if(!intval($contact_entree)){
				$entree = insert_menus_entree($barre_pied);
				$infos_entree = array(
					'rang' => 1,
					'type_entree' => 'contact'
				);
				menus_entree_set($entree, $infos_entree);
			}
			$texte_libre_entree = sql_getfetsel('id_menus_entree','spip_menus_entrees','type_entree="texte_libre"');
			if(!intval($texte_libre_entree)){
				$entree = insert_menus_entree($barre_pied);
				$infos_entree = array(
					'rang' => 2,
					'type_entree' => 'texte_libre',
					'parametres' => array('contenu' => '<:mediaspip_init:entree_powered_mediaspip:>')
				);
				menus_entree_set($entree, $infos_entree);
			}
		}
		
	}
}

?>