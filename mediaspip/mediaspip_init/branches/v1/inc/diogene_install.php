<?php
/**
 * Plugin MediaSPIP Init
 * © 2010 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Installation des diogènes par défaut
 */
function inc_diogene_install_dist($rubriques){
	include_spip('action/editer_diogene');
	include_spip('inc/filtres');
	
	if(!$id_diogene_medias = sql_getfetsel('id_diogene','spip_diogenes','objet="emballe_media" AND id_secteur = '.intval($rubriques['medias']))){
		$id_diogene_medias = insert_diogene();
		$set_media = array(
			'titre' => filtrer_entites(_T('mediaspip_core:publier_un_media_titre')),
			'description' => filtrer_entites(_T('mediaspip_core:publier_un_media_desc')),
			'champs_caches' => array(
				'soustitre',
				'surtitre',
				'descriptif',
				'chapo',
				'ps',
				'urlref'
			),
			'champs_ajoutes' => array(
				'geo','auteurs','spipicious','licence','forum'
			),
			'menu'=> 'on',
			'statut_auteur' => '1comite',
			'statut_auteur_publier' => '0minirezo',
			'id_secteur' => $rubriques['medias'],
			'objet' => 'emballe_media',
			'type' => 'media'
		);
		$err = diogene_set($id_diogene_medias, $set_media);
	}

	if(!$id_diogene_edito = sql_getfetsel('id_diogene','spip_diogenes','objet="article" AND id_secteur = '.intval($rubriques['editos']))){
		$id_diogene_edito = insert_diogene();
		$set_edito = array(
			'titre' => filtrer_entites(_T('mediaspip_core:publier_un_edito_titre')),
			'description' => filtrer_entites(_T('mediaspip_core:publier_un_edito_desc')),
			'champs_caches' => array(
				'soustitre',
				'surtitre',
				'descriptif',
				'chapo',
				'ps',
				'urlref'
			),
			'champs_ajoutes' => array(
				'auteurs','date','forum'
			),
			'menu'=> 'on',
			'statut_auteur' => '0minirezo',
			'id_secteur' => $rubriques['editos'],
			'objet' => 'article',
			'type' => 'editorial',
			'options_complements' => array(
				'polyhier_desactiver' => 'on'
			)
		);
		$err = diogene_set($id_diogene_edito, $set_edito);
	}

	if(!$id_diogene_sites = sql_getfetsel('id_diogene','spip_diogenes','objet="site" AND id_secteur = '.intval($rubriques['sites']))){
		$id_diogene_sites = insert_diogene();
		$set_sites = array(
			'titre' => filtrer_entites(_T('mediaspip_core:publier_un_site_titre')),
			'description' => filtrer_entites(_T('mediaspip_core:publier_un_site_desc')),
			'champs_caches' => '',
			'champs_ajoutes' => array(),
			'menu'=> 'on',
			'statut_auteur' => '0minirezo',
			'id_secteur' => $rubriques['sites'],
			'objet' => 'site',
			'type' => 'sites',
			'options_complements' => array(
				'polyhier_desactiver' => 'on'
			)

		);
		$err = diogene_set($id_diogene_sites, $set_sites);
	}

	if(!$id_diogene_actu = sql_getfetsel('id_diogene','spip_diogenes','objet="article" AND id_secteur = '.intval($rubriques['actus']))){
		$id_diogene_actu = insert_diogene();
		$set_actu = array(
			'titre' => filtrer_entites(_T('mediaspip_core:publier_une_actu_titre')),
			'description' => filtrer_entites(_T('mediaspip_core:publier_une_actu_desc')),
			'champs_caches' => array(
				'soustitre',
				'surtitre',
				'descriptif',
				'chapo',
				'ps',
				'urlref'
			),
			'champs_ajoutes' => array(
				'date','geo','auteurs','forum'
			),
			'menu'=> 'on',
			'statut_auteur' => '0minirezo',
			'id_secteur' => $rubriques['actus'],
			'objet' => 'article',
			'type' => 'actu',
			'options_complements' => array(
				'polyhier_desactiver' => 'on'
			)
		);
		$err = diogene_set($id_diogene_actu, $set_actu);
	}
	if(!$id_diogene_categorie = sql_getfetsel('id_diogene','spip_diogenes','objet="rubrique" AND id_secteur = '.intval($rubriques['medias']))){
		$id_diogene_categorie = insert_diogene();
		$set_categorie = array(
			'titre' => filtrer_entites(_T('mediaspip_core:publier_une_categorie_titre')),
			'description' => filtrer_entites(_T('mediaspip_core:publier_une_categorie_desc')),
			'champs_caches' => array('descriptif'),
			'champs_ajoutes' => '',
			'menu'=> 'on',
			'statut_auteur' => '0minirezo',
			'id_secteur' => $rubriques['medias'],
			'objet' => 'rubrique',
			'type' => 'categorie',
			'options_complements' => array(
				'polyhier_desactiver' => 'on'
			)
		);
		$err = diogene_set($id_diogene_categorie, $set_categorie);
	}
}
?>