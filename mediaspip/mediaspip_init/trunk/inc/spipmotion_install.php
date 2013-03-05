<?php
/**
 * Plugin MediaSPIP Init
 * © 2010-2012 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Install les templates par défaut de SPIPmotion
 *
 * @return array
 */
function inc_spipmotion_install_dist(){
	if(defined('_DIR_PLUGIN_SPIPMOTION')){
		$config = array(
			'encodage_auto' => 'on',
			'fichiers_audios' => array('3ga','aac','ac3','aifc','aiff','flac','m4a','mka','mp3','oga','ogg','wav','wma'),
			'fichiers_videos' => array('3gp','avi','dv','f4v','flv','m2p','m2ts','m4v','mkv','mpg','mov','mp4','mts','ogv','qt','ts','webm'),
			'fichiers_audios_encodage' => array('3ga','aac','ac3','aifc','aiff','flac','m4a','mka','mp3','oga','ogg','wav','wma'),
			'fichiers_videos_encodage' => array('3gp','avi','dv','f4v','flv','m2p','m2ts','m4v','mkv','mpg','mov','mp4','mts','ogv','qt','ts','webm'),
			'fichiers_audios_sortie' => array('mp3','ogg'),
			'fichiers_videos_sortie' => array('mp4','ogv'),
			'frequence_audio_ogg' => '44100',
			'frequence_audio_ogv' => '44100',
			'frequence_audio_mp3' => '44100',
			'frequence_audio_mp4' => '44100',
			'bitrate_audio_mp3' => '128',
			'bitrate_audio_mp4' => '128',
			'bitrate_ogv' => '600',
			'bitrate_mp4' => '660',
			'width_ogv' => '640',
			'width_mp4' => '640',
			'height_mp4' => '480',
			'height_ogv' => '480',
			'qualite_audio_ogg' => '5',
			'qualite_audio_ogv' => '5',
			'acodec_mp3' => 'libmp3lame',
			'acodec_ogg' => 'libvorbis',
			'acodec_ogv' => 'libvorbis',
			'acodec_mp4' => 'libfaac',
			'vcodec_ogv' => 'libtheora',
			'vcodec_mp4' => 'libx264',
			'format_mp4' => 'ipod',
			'vpreset_mp4' => 'slow',
			'passes_ogv' => '2',
			'passes_mp4' => '2'
		);

		ecrire_meta('spipmotion',serialize($config));
	}
}
?>