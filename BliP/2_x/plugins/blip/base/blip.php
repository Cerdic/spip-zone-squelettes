<?php

// renseigner le compilateur sur la nouvelle table blip

global $tables_principales;
global $tables_auxiliaires;
global $table_blip;

$blip_champs = array(
	"id_config"   	=> "bigint(21) NOT NULL",
	"position"    	=> "text NOT NULL",	
	"id_item"    	=> "bigint(21) NOT NULL",
	"ordre"    		=> "bigint(21) NOT NULL",
	"type"    		=> "text NOT NULL",	
	"titre"    		=> "text NOT NULL",
	"descriptif"    => "text NOT NULL",
	"texte"    		=> "text NOT NULL",
	"style"    		=> "text NOT NULL",
	"actif"    		=> "text NOT NULL"
	);

$blip_keys = array(
	"PRIMARY KEY"    => "id_config"
	);

$tables_principales[$table_blip] =
	array('field' => &$blip_champs, 'key' => &$blip_keys);

//-- Table des tables ----------------------------------------------------

global $table_des_tables;
$table_des_tables[$table_blip]=$table_blip;

?>