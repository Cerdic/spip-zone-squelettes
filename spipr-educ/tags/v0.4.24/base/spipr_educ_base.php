<?php
$SpiprEduckey = array("PRIMARY KEY" => "id");

$SpiprEducTable = array(
	"id" => "INTEGER NOT NULL AUTO_INCREMENT",
	"nom" => "TEXT NOT NULL",
	"type" => "TEXT NOT NULL",
	"nom_sauvegarde" => "TEXT NOT NULL",
	"parametre1" => "TEXT NOT NULL",
	"parametre2" => "TEXT NOT NULL",
	"parametre3" => "TEXT NOT NULL",
	"parametre4" => "TEXT NOT NULL",
	"parametre5" => "TEXT NOT NULL",
	"parametre6" => "TEXT NOT NULL",
	"parametre7" => "TEXT NOT NULL",
	"parametre8" => "TEXT NOT NULL",
	"parametre9" => "TEXT NOT NULL",
	"parametre10" => "TEXT NOT NULL"
);
$GLOBALS['tables_principales']['spip_spipr_educ'] = array('field' => &$SpiprEducTable, 'key' => &$SpiprEduckey);
?>