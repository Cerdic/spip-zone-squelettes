<?php 
include_spip('inc/config');

function formulaires_melusine_largeur_blocs_charger($bloc,$type){
	$valeurs['bloc'] = $bloc;
	$valeurs['type'] = $type;
  
  return $valeurs;
}

function formulaires_melusine_largeur_blocs_verifier(){
	$erreurs = array();
	
	$blocs=unserialize(_request('blocs'));
	
	$somme=0;

	foreach($blocs as $bloc){
		if(is_numeric(_request($bloc)) && _request($bloc)==(int)_request($bloc))
			{
				$somme+=_request($bloc);
			}
		else
			{	
				$erreurs[]="pas nombre entier";
				$txt_erreur ="Il faut des valeurs entières !";
				$erreurs['message_erreur'] = utf8_encode($txt_erreur) ;
			}
	}

	if (count($erreurs)==0)
		{
			if($somme>12)
				{
					$erreurs[]=" somme > 12";
					$txt_erreur =" La somme des colonnes est égale à ".$somme;
					$txt_erreur.=". C'est supérieur au nombre autorisé : 12";
					$erreurs['message_erreur'] = utf8_encode($txt_erreur) ;
				}
			elseif($somme<12)
				{
					$erreurs[]=" somme > 12";
					$txt_erreur =" La somme des colonnes est égale à ".$somme;
					$txt_erreur.=". C'est inférieur au nombre autorisé : 12";
					$erreurs['message_erreur'] = utf8_encode($txt_erreur) ;
				}
		}
	
	return $erreurs;

}


function formulaires_melusine_largeur_blocs_traiter(){
	
	$blocs=unserialize(_request('blocs'));
	$bloc_actif=_request('bloc');
	$type=_request('type');
	foreach($blocs as $bloc){

		$largeur=_request($bloc);
		$chemin_largeur="melusine_data/".$type."/".$bloc."/largeur";
		effacer_config($chemin_largeur);
		ecrire_config($chemin_largeur,$largeur);	
	}
	
	//$chemin_dispo="melusine_data/dispos/".$dispo;
	//ecrire_config($chemin_dispo,$style);	

	
	
	
	
return array('message_ok'=>utf8_encode('Configuration enregistrée'),'bloc'=>$bloc_actif);
}



?>