<?php

require_once find_in_path('lib/Spout/Autoloader/autoload.php');
	
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;

function trad_export_csv($trads) {

	$entetes = array(
		'ID',
		'Nom',
		'URL',
		'Contenu'
	);
	
	$writer = WriterFactory::create(Type::XLSX); // for XLSX files

	$writer->openToBrowser('traduction'); // stream data directly to the browser

	$writer->addRow($entetes); // add a row at a time
	$writer->addRows($trads); // add multiple rows at a time

	$writer->close();
}