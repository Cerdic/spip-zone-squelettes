<?php 
include_spip('inc/config');
function formulaires_melusine_rechavancee_charger($id_noisette){
	$valeurs=array();
	$valeurs['id_noisette'] = $id_noisette;
  
  return $valeurs;
}

function formulaires_melusine_rechavancee_verifier(){
	$erreurs = array();
	if (count($erreurs))
		$erreurs['message_erreur'] = 'Votre saisie contient des erreurs !';
	return $erreurs;
}





function formulaires_melusine_rechavancee_traiter(){
	include_spip('action/editer_objet');	
	$groupes=_request('groupes');
	$style=_request('style');
	$params=array('style'=>$style,'mots'=>$groupes);
	$id_noisette=_request('id_noisette');
	$set=array('parametres'=>serialize($params));
	objet_modifier("noisette", $id_noisette, $set);	
	
	return array('message_ok'=>'Saisie enregistr&eacute;e');
	
	
}



?>