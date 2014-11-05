<?php 
include_spip('inc/config');

function formulaires_melusine_mentions_legales_charger($id_noisette)
{
	$valeurs=array();
	$valeurs['id_noisette'] = $id_noisette;
  	return $valeurs;
}

function formulaires_melusine_mentions_legales_verifier()
{
}


function formulaires_melusine_mentions_legales_traiter()
{
	include_spip('action/editer_objet');
	$id_noisette=_request('id_noisette');
	$casiers=array(	'style',
					'directeurdepublication',
					'secretairederedaction',
					'adresse',
					'hebergement');
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
	return array('message_ok'=>'Saisie enregistr&eacute;e','id_noisette'=>$id);
}
?>