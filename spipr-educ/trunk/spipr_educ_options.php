<?php
if (!isset($GLOBALS['z_blocs']))
	$GLOBALS['z_blocs'] = array('content','aside','extra','head','head_js','header','footer','breadcrumb');

define('_ZENGARDEN_FILTRE_THEMES','spipr');
define('_ALBUMS_INSERT_HEAD_CSS',false);

$GLOBALS['dossier_squelettes'] = _DIR_PLUGIN_SPIPR_EDUC;

$GLOBALS['oembed_providers'] = array(
    'https://www.audio-lingua.eu/*' => 'https://www.audio-lingua.eu/oembed.api',
    'https://scolawebtv.crdp-versailles.fr/*' => 'https://scolawebtv.crdp-versailles.fr/oembed.api/',
    'https://pod.ac-caen.fr/video*' => 'https://pod.ac-caen.fr/oembed/',
    'https://learningapps.org/*'=> 'https://learningapps.org/oembed.php',
);