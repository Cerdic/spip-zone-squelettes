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
			}
	}

	// verifier que les champs obligatoires sont bien la :
	//foreach(array('pos1','pos2','pos3','pos4','pos5') as $obligatoire)
	//	if (_request($style)) $erreurs[$obligatoire] = 'Ce champ est obligatoire';
	
	// verifier que si un email a été saisi, il est bien valide :
	//include_spip('inc/filtres');
	//if (_request('email') AND !email_valide(_request('email')))
	//	$erreurs['email'] = 'Cet email n\'est pas valide';

	// $style=_request('style');
	// $gauche=lire_config("melusine_squelettes/g");
	
	
	// if($style=="layout2.css" and melusine_colonne_pasvide($droite) )
	//{$erreurs['style'] ="<span style='color:red'>La colonne droite  
	//doit &ecirc;tre vide</span>"	;};
	// if($style=="layout3.css" and melusine_colonne_pasvide($gauche) )
	//{$erreurs['style'] ="<span style='color:red'>La colonne gauche 
	//doit &ecirc;tre vide</span>"	;};

	if (count($erreurs)==0)
		{
			if($somme>12)
				{
					$erreurs[]=" somme > 12";
					$txt_erreur =" La somme des colonnes est égale à ".$somme;
					$txt_erreur.=" C'est supérieur au nombre autorisé : 12";
				}
			if($somme<12)
				{
					$erreurs[]=" somme > 12";
					$txt_erreur =" La somme des colonnes est égale à ".$somme;
					$txt_erreur.=" C'est inférieur au nombre autorisé : 12";
					
				}
		}
	$erreurs['message_erreur'] = utf8_encode($txt_erreur) ;
	return $erreurs;
	

	//if (count($erreurs))
	//	$erreurs['message_erreur'] = utf8_encode($txt_erreur) ;
	//return $erreurs;
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