<?php
if (!defined("_ECRIRE_INC_VERSION")) {
	return;
}

function sendagi_declarer_champs_extras($champs = array()) {

	// Table spip_rubriques
	$champs['spip_rubriques']['sendagi_type_rubrique'] = array(
		'saisie' => 'radio',
		'options' => array(
			'nom' => 'sendagi_type_rubrique',
			'label' => _T('sendagi:sendagi_type_rubrique'),
			'sql' => "varchar(30) NOT NULL DEFAULT ''",
			'defaut' => 'tri_date',
			'datas' => array(
				'tri_date' => _T('sendagi:sendagi_type_rubrique_tri_date'),
 				'tri_num' => _T('sendagi:sendagi_type_rubrique_tri_num'),
				'tri_equipe' => _T('sendagi:sendagi_type_rubrique_tri_equipe'),
			),
			'restrictions'=>array('voir' => array('auteur' => ''),	//Tout le monde peut voir
							'modifier' => array('auteur' => 'webmestre')),	//Seuls les webmestres peuvent modifier
		),
	);

	return $champs;
}
