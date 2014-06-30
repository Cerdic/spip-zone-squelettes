<?php 
include_spip('inc/config');

function formulaires_melusine_edition_module_charger($id_noisette){
	$valeurs=array();
	$valeurs['id_noisette'] = $id_noisette;
	$entrees = sql_fetsel(
			'parametres',
			'spip_noisettes',
			'id_noisette = '.$id_noisette
		);
	if(!empty($entrees['parametres'])){
		$params=unserialize($entrees['parametres']);
	
  		foreach($params as $cle => $param){
  			$valeurs[$cle]=$param;
   		}
   }
   //print_r($valeurs);

  return $valeurs;
}

function formulaires_melusine_edition_module_verifier(){
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

function trouve_input_file_value($casier,$id_noisette){
		$valeurs=array();
	$valeurs['id_noisette'] = $id_noisette;
	$entrees = sql_fetsel(
			'parametres',
			'spip_noisettes',
			'id_noisette = '.$id_noisette
		);
	if(!empty($entrees['parametres'])){
		$params=unserialize($entrees['parametres']);
	
  		foreach($params as $cle => $param){ 
  			//echo $param;
  			if($cle==$casier) {return $param;};
  			
   		}
   }
   //print_r($valeurs);

  return "";
}


function formulaires_melusine_edition_module_traiter(){
include_spip('action/editer_objet');
	
	$id_noisette=_request('id_noisette');
	$param=_request('param');
	
	$casiers=array();
	$params=unserialize($param);
	//print_r($params);
	foreach($params as $p){
		
			// echo "<pre>";
			// print_r($options);
			// echo "</pre>";
		$casiers[]=$p['options']['nom'];
		
	}
	
	$params=array();
	foreach($casiers as $casier){
		$data=_request($casier);
		
		//if(isset($data)){
		 // if(strpos($casier, 'imge')==0){
			if(!empty($_FILES[$casier]['tmp_name']) ){
				
				
				$nom_fichier= $_FILES[$casier]['tmp_name'];
				$chemin_destination_boutons="IMG/config/boutons";
				$chemin_destination_config="IMG/config";
				$nom_destination='IMG/config/boutons/'.$_FILES[$casier]['name'];
				
				if(!is_dir("$chemin_destination_boutons")){
					if(!is_dir($chemin_destination_config)){
						mkdir($chemin_destination_config,0777);
					}
					mkdir($chemin_destination_boutons,0777);
				};
				move_uploaded_file($nom_fichier, $nom_destination);
				$data =$nom_destination;
				echo "aa".$casier."/".$data."<br>";
				$params[$casier]=$data;
			}
			elseif(isset($data)){
				echo "bb".$casier."/".$data."<br>";
				$params[$casier]=$data;
			}
			else{$data=trouve_input_file_value($casier,$id_noisette);
				echo $casier."/".$data."<br>";
				$params[$casier]=trouve_input_file_value($casier,$id_noisette);
			}
				
			

		//}
		
		
	}


		
		
		
		


	$set=array('parametres'=>serialize($params));
	objet_modifier("noisette", $id_noisette, $set);
	
	return array('message_ok'=>'enregistr&eacute;e', 'id_noisette'=>$id);
}



?>