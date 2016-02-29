<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
function escal_porte_plume_barre_pre_charger($barres){
	$barre = &$barres['edition'];

	$barre->cacher('stroke_through');

	$module_barre = "barre_outils";
	if (intval($GLOBALS['spip_version_branche'])>2)
		$module_barre = "barreoutils";
	

	// Ajouts Escal
	$barre->ajouterApres('grpCaracteres', array(
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
	
	
	return $barres;
}

function escal_porte_plume_lien_classe_vers_icone($flux){
	return array_merge($flux, array(
		'outil_ajouts_escal' => array('escal16.png','0'),
            'outil_escal_aide' => array('aide.png','0'),
    		'outil_escal_important' => array('important.png','0'),
            'outil_escal_avertissement' => array('avertissement.png','0'),
            'outil_escal_info' => array('info.png','0'),
            'outil_escal_centrer' => array('centrer.png','0'),

	));
}

?>