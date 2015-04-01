<?php 
include_spip('inc/config');
function formulaires_melusine_boutons_charger($id_noisette)
{
	$valeurs=array();
	$valeurs['id_noisette'] = $id_noisette;
    return $valeurs;
}


function formulaires_melusine_boutons_verifier()
{
	$erreurs = array();
	// verifier que les champs obligatoires sont bien la :
	//foreach(array('pos1','pos2','pos3','pos4','pos5') as $obligatoire)
	//	if (!_request($obligatoire)) $erreurs[$obligatoire] = 'Ce champ est obligatoire';
	
	// verifier que si un email a été saisi, il est bien valide :
	//include_spip('inc/filtres');
	//if (_request('email') AND !email_valide(_request('email')))
	//	$erreurs['email'] = 'Cet email n\'est pas valide';

	if (count($erreurs))
		$erreurs['message_erreur'] = 'Votre saisie contient des erreurs !';
	return $erreurs;
}

function melusine_rassembler_boutons($i)
{
	$tab=array(intit,add,blanck,emplacement,boutonimage);

	foreach($tab as $value)
	{
		$chemin='melusine_boutons/'.$i.'/'.$value;
		$j=$i+1;
		$chemin_bas='melusine_boutons/'.$j.'/'.$value;		
		$pos_bas=lire_config($chemin_bas);
		ecrire_config($chemin,$pos_bas);
	}
	$chemin_old='melusine_boutons/'.$j;
	effacer_config($chemin_old);
	$k=$j+1;
	$test='melusine_boutons/'.$k;
	if(lire_config($test))
	{
		melusine_rassembler_boutons($j);
	};
}


function formulaires_melusine_boutons_traiter()
{
	include_spip('action/editer_objet');
	$id_noisette=_request('id_noisette');
	$params=unserialize(_request('parametres'));
	$boutons=_request('bouton');
	$action=_request('ok2');
	$position=_request('position');
	if (isset($_POST['reset'])) 
	{	/* On initialise les valeurs du formulaire */
		$params['style']="multibloc";
		$params['voir_images']="oui";
		$params['voir_intitule']="oui";
		$params['col']="col-md-12";
	}
	else  
	{	/* On récupère les valeurs du formulaire */
		$params['style']=_request('style');
		$params['voir_images']=_request('voir_images');
		$params['voir_intitule']=_request('voir_intitule');
		$params['col']=_request('col');
	}
	

	$params['boutons']=$boutons;

	if(strpos($position, "d")!== false )
	{
		$cle=intval(str_replace("d","",$position));
		$suivant=$cle+1;
		$bouton_suivant=$boutons[$suivant];
		$bouton_actif=$boutons[$cle];
		$boutons[$cle]=$bouton_suivant;
		$boutons[$suivant]=$bouton_actif;
		$params['boutons']=$boutons;	
	}
	if(strpos($position, "m")!== false )
	{
		$cle=intval(str_replace("m","",$position));
		$precedent=$cle-1;
		$bouton_precedent=$boutons[$precedent];
		$bouton_actif=$boutons[$cle];
		$boutons[$cle]=$bouton_precedent;
		$boutons[$precedent]=$bouton_actif;
		$params['boutons']=$boutons;
	}
	if(strpos($action, "update")!== false )
	{
		$cle=str_replace("update","",$action);
		$nf="image".$cle;	
		if(!empty($_FILES[$nf]['tmp_name']))
		{
			$chemin='melusine_data/boutons/b'.$id_noisette.'/image';
			$nom_fichier= $_FILES[$nf]['tmp_name'];
			$chemin_destination_boutons="IMG/config/boutons";
			$chemin_destination_config="IMG/config";
			$nom_destination='IMG/config/boutons/'.$_FILES[$nf]['name'];
			$nom_destination0='IMG/config/boutons/'.$_FILES[$nf]['name'];
			if(!is_dir("$chemin_destination_boutons"))
			{
				if(!is_dir($chemin_destination_config))
				{
					mkdir($chemin_destination_config,0777);
				}
				mkdir($chemin_destination_boutons,0777);
			};
			move_uploaded_file($nom_fichier, $nom_destination);
			$boutons[$cle]['image'] =$nom_destination0;
			$params['boutons']=$boutons;
		}
	}
	if(strpos($position, "s")!== false )
	{
		$cle=intval(str_replace("s","",$position));
		unset($boutons[$cle]);
		$boutons=array_values($boutons);
		$params['boutons']=$boutons;
	}
	if($action=="create")
	{
		$casiers=array('intitule','url','blanck','alt','class');
		foreach($casiers as $casier)
		{
			$param[$casier]='';
		}
		$param[intitule]='+++ nouveau bouton';
		$params['boutons'][]=$param;			
	}
	$set=array('parametres'=>serialize($params));
	objet_modifier("noisette", $id_noisette, $set);	
	if (isset($_POST['ok']) 
		&& $params['voir_images']=="non"  
		&& $params['voir_intitule']=="non") 
	{
		return array('message_erreur'=>'Image et intitul&eacute; ne peuvent pas 
			&ecirc;tre masqu&eacute;s en m&ecirc;me temps');
	}
	elseif (isset($_POST['ok'])) 
	{
		return array('message_ok'=>'Saisie enregistr&eacute;e');
	}
	elseif (isset($_POST['reset'])) 
		{	
			return array
			('message_ok'=>'R&eacute;glages r&eacute;initialis&eacute;s
			 et enregistr&eacute;s','id_noisette'=>$id);
		}
}
?>