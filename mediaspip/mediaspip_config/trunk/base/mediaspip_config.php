<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Insertion dans le pipeline declarer_tables_principales (SPIP)
 * 
 * On ajoute un champs "notices" à la table spip_auteurs
 * 
 * @param array $tables_principales Un array de description des tables
 * @return array $tables_principales L'array de description des tables modifié
 */
function mediaspip_config_declarer_tables_principales($tables_principales){
	$tables_principales['spip_auteurs']['field']['notices'] = "text DEFAULT '' NOT NULL";

	return $tables_principales;
}

?>