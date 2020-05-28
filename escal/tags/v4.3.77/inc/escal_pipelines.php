<?php
if (!defined("_ECRIRE_INC_VERSION")) return;


function escal_porte_plume_barre_pre_charger($barres){
	$barre_edition = &$barres['edition'];
	$barre_forum = &$barres['forum'];


	// Ajouts Escal
					
	$barre_edition->ajouterApres('grpCaracteres',
		array(
			"id"          => 'ajouts_escal',
			"name"        => 'utiliser un outil d\'Escal',
			"className"   => "outil_ajouts_escal",
			"display"     => true,
			"dropMenu"    => array(
				// aide
				array(
					"id"          => 'escal_aide',
					"name"        => 'apporter <aide>une aide</aide>',
					"className"   => "outil_escal_aide",
					"openWith"    => "\n<aide>",
					"closeWith"   => "</aide>\n",
					"display"     => true,
					"selectionType" => "line",
				),
				// important
				array(
					"id"          => 'escal_important',
					"name"        => 'une <important>remarque importante</important>',
					"className"   => "outil_escal_important",
					"openWith"    => "\n<important>",
					"closeWith"   => "</important>\n",
					"display"     => true,
					"selectionType" => "line",
				),
				// avertissement
				array(
					"id"          => 'escal_avertissement',
					"name"        => 'une <avertissement>remarque moyennement importante</avertissement>',
					"className"   => "outil_escal_avertissement",
					"openWith"    => "\n<avertissement>",
					"closeWith"   => "</avertissement>\n",
					"display"     => true,
					"selectionType" => "line",
				),
				// info
				array(
					"id"          => 'escal_info',
					"name"        => 'une <info>information</info>',
					"className"   => "outil_escal_info",
					"openWith"    => "\n<info>",
					"closeWith"   => "</info>\n",
					"display"     => true,
					"selectionType" => "line",
					),
				 // centrer
				array(
					"id"          => 'escal_centrer',
					"name"        => '<centrer>centrer le paragraphe</centrer>',
					"className"   => "outil_escal_centrer",
					"openWith"    => "\n<centrer>",
					"closeWith"   => "</centrer>\n",
					"display"     => true,
					"selectionType" => "line",
					),
		),
	));


	$barre_edition->ajouterApres('lowercase', array(
				// Fleche droite
					"id" => 'arrow',
					"name" => 'fleche',
					"className" => "outil_fleche",
					"replaceWith" => "&rarr;",
					"display" => true,
	));

	$barre_forum->ajouterApres('quote',
		array(
		// balise code
			'id'          => 'barre_code',
			'name' => _T('barreoutils:barre_code'),
			'className'   => 'outil_barre_code',
			'openWith'    => '&lt;code&gt;',
			'closeWith'   => '&lt;/code&gt;',
			'display'     => true,
			'selectionType' => 'word',
			'dropMenu'    => array(
				// balise cadre
					array(
					'id'          => 'barre_cadre',
					'name' => _T('barreoutils:barre_cadre'),
					'className'   => 'outil_barre_cadre',
					'openWith'    => "\n&lt;cadre&gt;",
					'closeWith'   => "&lt;/cadre&gt;\n",
					'display'     => true,
					'selectionType' => 'line',
					),
		),
	));

	return $barres;
}

function escal_porte_plume_lien_classe_vers_icone($flux){
	return array_merge($flux, array(
		'outil_ajouts_escal' => 'escal16.png',
		'outil_escal_aide' => 'aide.png',
		'outil_escal_important' => 'important.png',
		'outil_escal_avertissement' => 'avertissement.png',
		'outil_escal_info' => 'info.png',
		'outil_escal_centrer' => 'centrer.png',
		'outil_fleche' => 'fleche.png',
	));
}

function escal_ieconfig_metas($table){
	$table['escal']['titre'] = Escal;
	$table['escal']['icone'] = 'images/escal16.png';
	$table['escal']['metas_brutes'] = 'escal,escal_base_version';
	return $table;
}

