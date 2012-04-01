<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
// declarer la fonction du pipeline

function autoriser_scolaspip_menu_dist($faire, $type, $id, $qui, $opt) {
	return ($qui['statut'] == '0minirezo' AND !$qui['restreint']);
}
function autoriser_scolaspip_configurer_dist($faire, $type, $id, $qui, $opt) {
	return ($qui['statut'] == '0minirezo' AND !$qui['restreint']);
}

?>