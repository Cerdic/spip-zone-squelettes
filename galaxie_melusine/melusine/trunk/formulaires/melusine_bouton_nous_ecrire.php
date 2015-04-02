<?php 
include_spip('inc/config');

function formulaires_melusine_bouton_nous_ecrire_charger($id_noisette)
{
	$valeurs=array();
	$valeurs['id_noisette'] = $id_noisette;
  	return $valeurs;
}

function formulaires_melusine_bouton_nous_ecrire_verifier()
{
}


function formulaires_melusine_bouton_nous_ecrire_traiter()
{
	include_spip('action/editer_objet');
	$id_noisette=_request('id_noisette');

	if (isset($_POST['ok'])) 
	{	/* On récupère les valeurs du formulaire */
		$casiers=array('personneajoindre','textebouton','style','centrer'
			,'icone');
	}
	elseif (isset($_POST['reset'])) 
	{	/* On initialise les valeurs du formulaire */
		$casiers=array('','Nous écrire','bloc_visible','centre','envelope');
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

/* Si le bouton Enregistrer a été sélectionné sans destinataire ni texte */	
	if (isset($_POST['ok']) 
			&& $params['personneajoindre']=='' 
			&& $params['textebouton']=='') 
		{	
			return array('message_erreur'=>'Il faut un destinataire et un texte'
			,'id_noisette'=>$id);
		}
/* Si le bouton Enregistrer a été sélectionné sans destinataire */
	elseif (isset($_POST['ok']) && $params['personneajoindre']=='') 
		{	
			return array('message_erreur'=>'Il faut choisir un destinataire !'
			,'id_noisette'=>$id);
		}
/* Si le bouton Enregistrer a été sélectionné sans texte */
	elseif (isset($_POST['ok']) && $params['textebouton']=='') 
		{	
			return array('message_erreur'=>'Il faut un texte pour le bouton !'
			,'id_noisette'=>$id);
		}
/* Si le bouton Enregistrer a été sélectionné sans oubli de champs */
	elseif (isset($_POST['ok'])) 
		{	
			return array('message_ok'=>'Saisie enregistr&eacute;e'
			,'id_noisette'=>$id);
		}
	elseif (isset($_POST['reset'])) 
		{	
			return array('message_ok'=>'R&eacute;glages 
				r&eacute;initialis&eacute;s et enregistr&eacute;s'
			,'id_noisette'=>$id);
		}
}
?>