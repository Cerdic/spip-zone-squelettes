<?php
# Voir doc sur http://www.spip-contrib.net/La-mutualisation-facile

require _DIR_RACINE.'mutualisation/mutualiser.php';

# Pouvoir travailler avec des url ayant www ou ww2
$site = str_replace('www.', '', $_SERVER['HTTP_HOST']);
$site = str_replace('ww2.', '', $site);

# Bien mettre les parametres de la base sur l'hebergement
define ('_INSTALL_HOST_DB', 'localhost');
define ('_INSTALL_USER_DB_ROOT', 'root');
define ('_INSTALL_PASS_DB_ROOT', '');
define ('_INSTALL_NAME_DB', 'mutu_'.prefixe_mutualisation($site));
define ('_INSTALL_USER_DB', prefixe_mutualisation($site));

demarrer_site($site,
	array(
		'creer_site' => true, 
		'cookie_prefix' => false, 
		'table_prefix' => false,
		'creer_base' => true,
		'creer_user_base' => true,
		'code' => 'ecureuil',
		'mail' => 'mutualisation@pyrat.net'
		)
	);

$quota_cache = 200;
$GLOBALS['type_urls'] = 'propres2';

#Pour compatibilite des vieux plugins avec SPIP (evite d'utiliser le plugin compat193 qui ne fait que ça)
include_spip('inc/vieilles_defs');
?>