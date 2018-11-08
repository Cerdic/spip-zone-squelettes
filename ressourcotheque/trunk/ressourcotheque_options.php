<?php
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

define ('_INDEXERDOC_OBJETS_LIES',1);

$GLOBALS['a2a_types_liaisons'] = array(
	'connexe' => _T('ressourcotheque:connexe')
);

if (isset($_REQUEST['recherche'])) {
  $_GET['var_recherche'] = $_REQUEST['recherche'];
}
