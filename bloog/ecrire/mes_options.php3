<?php

$dossier_squelettes = "_template" ;

//$type_urls= 'propres2' ;

//
// Definition de tous les extras possibles
//

$champs_extra = true;

	$GLOBALS['champs_extra'] = Array (
		'auteurs' => Array (
			"abo" => "radio|brut|Format|Format Html,Format texte,se désabonner|html,texte,non"


			),
			
		'articles' => Array (
				"squelette" => "bloc|propre|Bibliographie",

			)

		);
		
		$GLOBALS['champs_extra_proposes'] = Array (
'auteurs' => Array (
		'tous' => 'abo',
		'inscription' => 'abo',
		'fiche_auteur' => 'abo'
                ),
'articles' => Array (
		'0' => 'squelette',
		'tous' => '',
		
                )
				
);


include('options_spip_listes.php3');

?>
