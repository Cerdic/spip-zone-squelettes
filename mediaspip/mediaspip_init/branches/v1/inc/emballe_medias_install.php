<?php
/**
 * Plugin MediaSPIP Init
 * © 2010 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Mets à jour la méta de configuration d'emballe medias
 */
function inc_emballe_medias_install_dist(){
	$ancienne_meta = lire_config('emballe_medias',array());
	$meta_config = array(
					'fichiers'=> array(
						'gerer_types' => 'on',
						'fichiers_videos' => array('flv','mp4','mov','ogv','avi','mpg','3gp'),
						'fichiers_audios' => array('mp3','ogg'),
						'fichiers_images' => array('jpg','png','gif'),
						'fichiers_textes' => array('doc','odt','pdf'),
						'file_size_limit' => @ini_get('upload_max_filesize') ? ((str_replace('M','',@ini_get('upload_max_filesize')) < str_replace('M','',@ini_get('post_max_size'))) ? str_replace('M','',@ini_get('upload_max_filesize')) : str_replace('M','',@ini_get('post_max_size'))) : '2',
						'file_upload_limit' => '1',
						'file_queue_limit' => '1',
						'largeur_img_previsu' => '450',
						'hauteur_img_previsu' => '450'
					),
					'types' => array(
						'types_dispos' => array('audio','video','image','texte')
					)
				);
	$meta_finale = array_merge($ancienne_meta,$meta_config);
	ecrire_meta('emballe_medias',serialize($meta_finale),'non');
}

?>