<?php
// permettre la personalisation dans mes_options.php
if (!isset($GLOBALS['z_blocs']) OR !$GLOBALS['z_blocs']) {
	$GLOBALS['z_blocs'] = array('content','extra1','extra2','head','head_js','header','footer');
}

