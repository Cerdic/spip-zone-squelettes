<?php

// Sécurité
if (!defined('_ECRIRE_INC_VERSION')) return;

function photographe_squelettes_declarer_tables_objets_sql($tables){
	$tables['spip_documents']['page'] = 'document';
	return $tables;
}
