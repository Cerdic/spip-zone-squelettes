<?php 
include_spip('inc/config');

function formulaires_melusine_position_charger($gabarit){
	$valeurs['gabarit'] = $gabarit;

  
  return $valeurs;
}

function formulaires_melusine_position_verifier(){
	$erreurs = array();
	// verifier que les champs obligatoires sont bien la :
	//foreach(array('pos1','pos2','pos3','pos4','pos5') as $obligatoire)
	//	if (_request($style)) $erreurs[$obligatoire] = 'Ce champ est obligatoire';
	
	// verifier que si un email a été saisi, il est bien valide :
	//include_spip('inc/filtres');
	//if (_request('email') AND !email_valide(_request('email')))
	//	$erreurs['email'] = 'Cet email n\'est pas valide';

	// $style=_request('style');
	// $gauche=lire_config("melusine_squelettes/g");
	
	//$droite=lire_config("melusine_squelettes/d");
	// if($style=="layout2.css" and melusine_colonne_pasvide($droite) ){$erreurs['style'] ="<span style='color:red'>La colonne droite  doit &ecirc;tre vide</span>"	;};
	// if($style=="layout3.css" and melusine_colonne_pasvide($gauche) ){$erreurs['style'] ="<span style='color:red'>La colonne gauche doit &ecirc;tre vide</span>"	;};
	if (count($erreurs))
		$erreurs['message_erreur'] = 'Votre saisie contient des erreurs !';
	return $erreurs;
}


function formulaires_melusine_position_traiter(){
	$style=_request('style');
	$gabarit=_request('gabarit');
	$width=_request('width');
	$chemin_gabarit="melusine_data/gabarits/".$gabarit;
	ecrire_config($chemin_gabarit,$style);	
	ecrire_config("melusine_data/width",$width);
	
	
	
	
	return array('message_ok'=>'enregistré');
}



?>