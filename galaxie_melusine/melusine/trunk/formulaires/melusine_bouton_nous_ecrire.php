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
		/* On r�cup�re l'auteur choisi dans la liste d�roulante 
		"personneajoindre" */
		$casiers=array('personneajoindre');
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
		return array('message_ok'=>'enregistr�', 'id_noisette'=>$id);
	}



?>