<?php

$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__))));
define('_DIR_PLUGIN_EPONA',(_DIR_PLUGINS.end($p)));

$GLOBALS['dossier_squelettes'] = _DIR_PLUGIN_EPONA.'squelettes';

?>