<?php 
include_spip('inc/config');

function formulaires_melusine_titre_rubrique_charger($id_noisette)
{
	$valeurs=array();
	$valeurs['id_noisette'] = $id_noisette;
  	return $valeurs;
}

function formulaires_melusine_titre_rubrique_verifier()
{
}


function formulaires_melusine_titre_rubrique_traiter()
{
	include_spip('action/editer_objet');
	$id_noisette=_request('id_noisette');

	if (isset($_POST['ok'])) 
	{	/* On récupère les valeurs du formulaire */
		$casiers=array('style','logo','descriptif','titre','hauteur','Llogo','Plogo');
	}
	elseif (isset($_POST['reset'])) 
	{	/* On initialise les valeurs du formulaire */
		$casiers=array('bloc_visible','oui','oui','alignecentre','200','5','gauche');
	}

	$params=array();
	foreach($casiers as $casier)
	{
		$data=_request($casier);
		if(!isset($data))
			{$data="none";};
		$params[$casier]=$data;
		$set=array('parametres'=>serialize($params));
	}
	objet_modifier("noisette", $id_noisette, $set);
	$nbsaisi=$params['Llogo'];
/* Si le bouton Enregistrer a été sélectionné sans hauteur pour l'image */	
	if (isset($_POST['ok']) 
			&& $params['hauteur']=='') 
		{	
			return array('message_erreur'=>'Il faut saisir une hauteur pour le logo'
			,'id_noisette'=>$id);
		}
/* Si le bouton Enregistrer a été sélectionné sans proportion pour le logo */	
	elseif (isset($_POST['ok']) 
			&& $params['Llogo']=='') 
		{	
			return array('message_erreur'=>'Il faut saisir une proportion pour le logo'
			,'id_noisette'=>$id);
		}
/* Si le bouton Enregistrer a été sélectionné avec une proportion trop grande */	
	elseif (isset($_POST['ok']) 
			&& $params['Llogo']>'12') 
		{	
			return array('message_erreur'=>'Il faut saisir une proportion inf&eacute;rieure &agrave; 12'
			,'id_noisette'=>$id);
		}
/* Si le bouton Enregistrer a été sélectionné avec une proportion trop petite */	
	elseif (isset($_POST['ok']) 
			&& $params['Llogo']<'0') 
		{	
			return array('message_erreur'=>'Il faut saisir une proportion positive'
			,'id_noisette'=>$id);
		}
/* Si le bouton Enregistrer a été sélectionné avec une proportion non entière */	
	elseif (isset($_POST['ok']) 
			&& is_numeric($nbsaisi) 
			&& $nbsaisi!=(int)$nbsaisi) 
		{	
			return array('message_erreur'=>'Il faut saisir une proportion enti&egrave;re'
			,'id_noisette'=>$id);
		}
/* Si le bouton Enregistrer a été sélectionné sans oubli de champs */
	elseif (isset($_POST['ok'])) 
		{	
			return array('message_ok'=>'Saisie enregistr&eacute;e','id_noisette'=>$id);
		}
}
?>