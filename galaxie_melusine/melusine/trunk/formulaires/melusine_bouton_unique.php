<?php 
include_spip('inc/config');

function formulaires_melusine_bouton_unique_charger($id_noisette){
	$valeurs=array();
	$valeurs['id_noisette'] = $id_noisette;
  
  return $valeurs;
}

function formulaires_melusine_bouton_unique_verifier(){
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


function formulaires_melusine_bouton_unique_traiter(){

	$id_noisette=_request('id_noisette');
	effacer_config($chemin_intitule,$intitule);
	$casiers=array('intitule','url','blanck','alt');
	foreach($casiers as $casier){

		$chemin="melusine_data/boutons/b".$id_noisette."/".$casier;
		$data=_request($casier);
		if(!isset($data)){$data="none";};
		ecrire_config($chemin,$data);
	}
	$nf="image";
	echo $nf;
	echo $_FILES[$nf]['tmp_name'];
		if($_FILES[$nf]['tmp_name']){
			
			$chemin='melusine_data/boutons/b'.$id_noisette.'/image';
			$nom_fichier= $_FILES[$nf]['tmp_name'];
			$chemin_destination_boutons="IMG/config/boutons";
			$chemin_destination_config="IMG/config";
			$nom_destination='IMG/config/boutons/'.$_FILES[$nf]['name'];
			$nom_destination0='IMG/config/boutons/'.$_FILES[$nf]['name'];
			if(!is_dir("$chemin_destination_boutons")){
				if(!is_dir($chemin_destination_config)){
					mkdir($chemin_destination_config,0777);
				}
				mkdir($chemin_destination_boutons,0777);
			};
			move_uploaded_file($nom_fichier, $nom_destination); 
			ecrire_config($chemin,$nom_destination0);
		}
	
	
	return array('message_ok'=>'enregistré', 'id_noisette'=>$id);
}



?>