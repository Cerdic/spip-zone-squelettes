<?php
function autoriser_escal_menu_dist($faire, $type, $id, $qui, $opt) {
	return ($qui['webmestre'] == 'oui');
}
function autoriser_escal_configurer_dist($faire, $type, $id, $qui, $opt) {
    return ($qui['webmestre'] == 'oui');
}
