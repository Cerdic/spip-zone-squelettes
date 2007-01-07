<?php

// renseigner le compilateur sur la nouvelle table blip

global $tables_principales;
global $tables_auxiliaires;
global $table_blip;

$blip_champs = array(
	"id_config"    => "bigint(21) NOT NULL",
	"id_article"    => "bigint(21) DEFAULT '0' NOT NULL",
	"date_debut"    => "datetime DEFAULT '0000-00-00 00:00:00' NOT NULL",
	"date_fin"    => "datetime DEFAULT '0000-00-00 00:00:00' NOT NULL",
	"titre"    => "text NOT NULL",
	"descriptif"    => "text NOT NULL",
	"lieu"    => "text NOT NULL",
	"horaire" => "ENUM('oui','non') DEFAULT 'oui' NOT NULL",
	"id_evenement_source"    => "bigint(21) NOT NULL",
	"idx"        => "ENUM('', '1', 'non', 'oui', 'idx') DEFAULT '' NOT NULL",
	"maj"    => "TIMESTAMP"
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