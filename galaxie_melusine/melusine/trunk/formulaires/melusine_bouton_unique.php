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
// if($style=="layout2.css" and melusine_colonne_pasvide($droite) )
// {$erreurs['style'] ="<span style='color:red'>
// La colonne droite  doit &ecirc;tre vide</span>"	;};

// if($style=="layout3.css" and melusine_colonne_pasvide($gauche) )
// {$erreurs['style'] ="<span style='color:red'>
// La colonne gauche doit &ecirc;tre vide</span>"	;};
	
	if (count($erreurs))
		$erreurs['message_erreur'] = 'Votre saisie contient des erreurs !';
	return $erreurs;
}


function formulaires_melusine_bouton_unique_traiter(){
include_spip('action/editer_objet');

	$id_noisette=_request('id_noisette');
	
	if (isset($_POST['ok'])) 
	{	/* On récupère les valeurs du formulaire */
		$casiers=array('intitule','url','onglet','style','image','class','alt','centrer');
	}
	elseif (isset($_POST['reset'])) 
	{	/* On initialise les valeurs du formulaire */
		$casiers=array('','','oui','visible','','','','centre');
	}

	$params=array();
	foreach($casiers as $casier){
		$data=_request($casier);
		if(!isset($data)){$data="none";};
		$params[$casier]=$data;
	}

	$nf="image";
	if(!empty($_FILES[$nf]['tmp_name'])){
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
		$params['image'] =$nom_destination0;
	}
	/* Le !isset est pour pouvoir effacer l'image quand on choisit Reset */
	elseif($image=_request('imageexiste' && !isset($_POST['reset']))){
		$params['image']=$image;
	}
	$set=array('parametres'=>serialize($params));
	objet_modifier("noisette", $id_noisette, $set);

	/* Si le bouton Enregistrer a été sélectionné sans URL */
	if(isset($_POST['ok']) && $params['url']=='')
	{	
	return array(	'message_erreur'=>
						'Veuillez saisir une URL !',
					'id_noisette'=>$id);	
	}
	/* Si le bouton Enregistrer a été sélectionné sans IMAGE et sans INTITULE */
	elseif(isset($_POST['ok']) 	&& $params['image']=='none' 
								&& $params['intitule']=='')
	{	
	return array(	'message_erreur'=>
						'Veuillez choisir une image  ou un intitul&eacute;',
					'id_noisette'=>$id);	
	}
	/* Si le bouton Enregistrer a été sélectionné sans erreur */
	elseif (isset($_POST['ok'])) 
	{	
	return array(	'message_ok'=>
						'Saisie enregistr&eacute;e',
					'id_noisette'=>$id);
	}
	/* Si le bouton Reset a été sélectionné */
	elseif (isset($_POST['reset'])) 
		{	
			return array
			('message_ok'=>'R&eacute;glages r&eacute;initialis&eacute;s
			 et enregistr&eacute;s','id_noisette'=>$id);
		}
}
?>