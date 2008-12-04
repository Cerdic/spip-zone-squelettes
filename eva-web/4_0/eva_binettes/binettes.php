<?php
$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__))));
define('_DIR_PLUGIN_EVA_BINETTES',(_DIR_PLUGINS.end($p)));

function evabinettes_pre_typo($chaine) {
	$chemin = '<img alt="binettes" src="'._DIR_PLUGIN_EVA_BINETTES.'/binettes/';
	$chaine = preg_replace('/:->+/m', $chemin.'diable.png" />',$chaine);
	$chaine = preg_replace('/:-\(\(+/m', $chemin.'en_colere.png" />', $chaine);
	$chaine = preg_replace('/:-\)\)+/m', $chemin."mort_de_rire.png\" />", $chaine);
	$chaine = preg_replace('/:-D+/m', $chemin."mort_de_rire.png\" />", $chaine);
	$chaine = preg_replace('/:-\)+/m', $chemin."sourire.png\" />", $chaine);
	$chaine = preg_replace('/;-\)+/m', $chemin."clin_d-oeil.png\" />", $chaine);
	$chaine = preg_replace("/:'-\)+/m", $chemin."pleure_de_rire.png\" />", $chaine);
	$chaine = preg_replace("/:'-D+/m", $chemin."pleure_de_rire.png\" />", $chaine);
	$chaine = preg_replace('/:o\)+/m', $chemin."rigolo.png\" />", $chaine);
	$chaine = preg_replace('/B-\)+/m', $chemin."lunettes.png\" />", $chaine);
	$chaine = preg_replace('/\s:-p/m', $chemin."tire_la_langue.png\" />", $chaine);
	$chaine = preg_replace('/:-\|+/m', $chemin."bof.png\" />", $chaine);
	$chaine = preg_replace('/:-\/+/m', $chemin."mouai.png\" />", $chaine);
	$chaine = preg_replace('/:-o+/m', $chemin."surpris.png\" />", $chaine);
	$chaine = preg_replace('/:-O+/m', $chemin."surpris.png\" />", $chaine);
	$chaine = preg_replace('/:-\(+/m', $chemin."pas_content.png\" />", $chaine);
	$chaine = preg_replace("/:'-\(+/m", $chemin."triste.png\" />", $chaine);
return $chaine;
}

?>