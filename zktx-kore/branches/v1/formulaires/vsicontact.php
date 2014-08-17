<?php

function formulaires_vsicontact_charger_dist(){
	$valeurs = array(
	// demandeur	
		'votrenom'=>'', // *
		'votreprenom'=>'',
		'tel1'=>'', // *
		'tel2'=>'',
		'courriel'=>'', // *
	// Organisation
		'organom'=>'',
		'siretrcs'=>'',
		'orgadresse'=>'',
		'codepostal'=>'',
		'ville'=>'',
		'orgatel1'=>'',
		'orgatel2'=>'',
		'orgasite'=>'',
		'votrefonction'=>'',
	//Projet
		'typesite'=>'',
		'typepresta'=>'',
		'prodservices'=>'',
		'clients'=>'',
		'ressources'=>'',
		'deadline'=>'',
		'budget'=>'',
	// Message complementaire
		'message'=>'',
	);
	
	return $valeurs;
}

function formulaires_vsicontact_verifier_dist(){
	$erreurs = array();
	// verifier que les champs obligatoires sont bien la :
	foreach(array('votrenom','tel1','courriel') as $obligatoire)
		if (!_request($obligatoire)) $erreurs[$obligatoire] = 'Ce champ est obligatoire';
	
	// verifier que si un email a été saisi, il est bien valide :
	include_spip('inc/filtres');
	if (_request('courriel') AND !email_valide(_request('courriel')))
		$erreurs['courriel'] = 'Cet email n\'est pas valide';


	// verif en erreur sur les numeros internationnaux ou saisis avec des espaces !!!
	//$verifier = charger_fonction('verifier', 'inc');
	//if ($erreur = $verifier(_request('tel1'), 'telephone', array("pays"=>"FR"))) {
	//	$erreurs['tel1'] = $erreur;
	//}

	if (count($erreurs))
		$erreurs['message_erreur'] = 'Votre saisie semble contenir des erreurs. Merci de v&eacute;rifier les informations fournies !';
		
	return $erreurs;
}
		


function formulaires_vsicontact_traiter_dist(){
	$envoyer_mail = charger_fonction('envoyer_mail','inc');
	$email_to = $GLOBALS['meta']['email_webmaster'];
	$email_from = _request('courriel');
	$sujet = 'VotreSiteInter.net > Prise de contact';
	
	$nom = _request('votrenom');
	$prenom = _request('votreprenom');
	$tel1 = _request('tel1');
	$tel2 = _request('tel2');
	$courriel = _request('courriel');
	
	$organom = _request('organom');
	$siretrcs = _request('siretrcs');
	$adresse = _request('orgadresse');
	$codepostal = _request('codepostal');
	$ville = _request('ville');
	$orgatel1 = _request('orgatel1');
	$orgatel2 = _request('orgatel2');
	$orgasite = _request('orgasite');
	$votrefonction = _request('votrefonction');
	
	$typesite = _request('typesite');
	$typepresta = _request('typepresta');
	$prodservices = _request('prodservices');
	$clients = _request('clients');
	$ressources = _request('ressources');
	$deadline = _request('deadline');
	$budget = _request('budget');

	$msg = _request('message');
	
	
				$message = 'Nom : '.$nom."\n"
					.'Pr&eacute;nom : '.$prenom."\n"
					.'T&eacute;l&eacute;phone : '.$tel1.' '.$tel2."\n"
					.'Votre Organisation : '.$organom.' '.$siretrcs."\n"
					.'Votre fonction : '.$votrefonction."\n"
					.'Adresse : '.$adresse.' '.$codepostal.' '.$ville."\n"
					.'T&eacute;l&eacute;phone : '.$orgatel1.' '.$orgatel2."\n"
					.'Site web : '.$orgasite."\n"
					.'Type de site web : '.$typesite."\n"
					.'Type de prestation souhait&eacute;e : '.$typepresta."\n"
					.'Vos produits et services en quelques mots : '.$prodservices."\n"
					.'Vos clients en quelques mots : '.$clients."\n"
					.'Vos ressources internes : '.$ressources."\n"
					.'Vos &eacute;ch&eacute;ances : '.$deadline."\n"
					.'Votre budget : '.$budget."\n"
					.'Votre demande :'."\n".stripslashes($msg)."\n";	
												
	$envoyer_mail($email_to,$sujet,$message,$email_from);
	return array(
		'message_ok'=>'Merci pour votre message. Celui-ci a bien &eacute;t&eacute; pris en compte. Nous vous r&eacute;pondrons dans les meilleurs d&eacute;lais !'
		//'message_erreur'=>'Votre saisie semble contenir des erreurs. Merci de bien vouloir v&eacute;rifier les informations fournies !'
	);
}

?>
