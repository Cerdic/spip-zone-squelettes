<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function mediaspip_config_declarer_tables_principales($tables_principales){
	$tables_principales['spip_auteurs']['field']['notices'] = "text DEFAULT '' NOT NULL";

	return $tables_principales;
}

?>