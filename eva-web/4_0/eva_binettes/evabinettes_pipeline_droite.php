<?php
$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__))));
define('_DIR_PLUGIN_EVABINETTES',(_DIR_PLUGINS.end($p)));

function evabinettes_AfficheDroite($flux) {
	$exec = $flux['args']['exec'];
	if ($exec=='articles_edit') {
	include_spip('inc/evabinettes_GestionArticle');
	$flux['data'] .= evabinettes_blocdroite_article();
        }
return $flux;
}

?>