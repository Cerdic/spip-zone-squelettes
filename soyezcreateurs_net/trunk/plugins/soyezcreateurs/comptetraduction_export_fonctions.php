<?php

require_once find_in_path('lib/Spout/Autoloader/autoload.php');
	
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\Color;

function trad_export_csv($trads) {

	$entetes = array(
		'ID',
		'Nom',
		'URL',
		'Contenu'
	);
	
	$defaultStyle = (new StyleBuilder())
                ->setFontName('Arial')
                ->setFontSize(11)
                ->build();
	
	
	$writer = WriterEntityFactory::createXLSXWriter(); // for XLSX files

	$writer->openToBrowser('traduction.xlsx'); // stream data directly to the browser
	
	$writer->addRow(WriterEntityFactory::createRowFromArray($entetes, $defaultStyle)); // add a row at a time
	
	foreach ($trads as $trad) {
		$writer->addRow(WriterEntityFactory::createRowFromArray($trad, $defaultStyle));
	}

	$writer->close();
}