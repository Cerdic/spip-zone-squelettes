<?php 
include_spip('inc/config');

function formulaires_melusine_page_rubrique_charger($id_noisette)
{
	$valeurs=array();
	$valeurs['id_noisette'] = $id_noisette;
  	return $valeurs;
}

function formulaires_melusine_page_rubrique_verifier()
{
}


function formulaires_melusine_page_rubrique_traiter()
{
	include_spip('action/editer_objet');
	$id_noisette=_request('id_noisette');

	if (isset($_POST['ok'])) 
	{	/* On récupère les valeurs du formulaire */
		$casiers=array('style','disposition','puce','descriptif'
			,'taille','logo','articles_ssrub','edito_rub');
	}
	elseif (isset($_POST['ok2'])) 
	{	/* On récupère les valeurs du formulaire */
		$casiers=array('style','disposition','puce','descriptif'
			,'taille','logo','articles_ssrub','edito_rub');
	}
	elseif (isset($_POST['reset'])) 
	{	/* On initialise les valeurs de la partie 1 du formulaire */
		$casiers=array('bloc_visible','col-md-12','aucune','','','','','');
	}
	elseif (isset($_POST['reset2'])) 
	{	/* On initialise les valeurs de la partie 2 du formulaire */
		$casiers=array('','','','oui','200','oui','oui','oui');
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

/* Si un des boutons Enreg a été sélectionné ... */	
	if (isset($_POST['ok']) || isset($_POST['ok2'])) 
		{	/* ... mais que la taille n'est pas un nombre */
			if (!is_numeric($params['taille']))
			{
				return array('message_erreur'=>'Il faut un nombre pour
				la taille du descriptif.','id_noisette'=>$id);
			}
			/* ... mais que la taille n'est pas un entier */
			elseif ( $params['taille'] != (int)$params['taille']) 
			{
				return array('message_erreur'=>'Il faut un nombre entier pour
				la taille du descriptif.','id_noisette'=>$id);
			}
			/* sans erreur */
			else
			{	
				return array('message_ok'=>'Saisie enregistr&eacute;e'
				,'id_noisette'=>$id);
			}	
		}
/* Si un des boutons Annuler a été sélectionné */
	elseif (isset($_POST['reset']) || isset($_POST['reset2'])) 
		{	
			return array('message_ok'=>'R&eacute;glages 
				r&eacute;initialis&eacute;s et enregistr&eacute;s'
			,'id_noisette'=>$id);
		}
}
?>