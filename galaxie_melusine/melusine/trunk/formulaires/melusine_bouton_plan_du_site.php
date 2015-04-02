<?php 
include_spip('inc/config');

function formulaires_melusine_bouton_plan_du_site_charger($id_noisette)
{
	$valeurs=array();
	$valeurs['id_noisette'] = $id_noisette;
  	return $valeurs;
}

function formulaires_melusine_bouton_plan_du_site_verifier()
{
}


function formulaires_melusine_bouton_plan_du_site_traiter()
{
	include_spip('action/editer_objet');
	$id_noisette=_request('id_noisette');

	if (isset($_POST['ok'])) 
	{	/* On récupère les valeurs du formulaire */
		$casiers=array('textebouton','style','centrer','icone');
	}
	elseif (isset($_POST['reset'])) 
	{	/* On initialise les valeurs du formulaire */
		$casiers=array('Plan du site','bloc_visible','gauche','sitemap');
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

/* Si le bouton Enregistrer a été sélectionné sans texte à afficher */	
	if (isset($_POST['ok']) 
			&& $params['textebouton']=='') 
		{	
			return array('message_erreur'=>'Il faut un texte pour le bouton'
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