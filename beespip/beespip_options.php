<?php
//permet de se passer du filtre supprimer_numero ecriture des titres 22. untitre
$table_des_traitements['TITRE'][]= 'supprimer_numero(typo(%s))';

// Pour bénéficier de la mise en évidence des termes de la recherche dès la première page d’affichage
if (isset($_REQUEST['recherche'])) {
  $_GET['var_recherche'] = $_REQUEST['recherche'];
}
function beespip_info_version($var_plugin) {
	$get_infos = charger_fonction('get_infos','plugins');
	$info = $get_infos($var_plugin);
	return $info['version'];
}
?>
