<?php 
include_spip('inc/config');
function formulaires_melusine_liens_education_nationale_charger($id_noisette)
{
	$valeurs=array();
	$valeurs['id_noisette'] = $id_noisette;
    return $valeurs;
}


function formulaires_melusine_liens_education_nationale_verifier()
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


function formulaires_melusine_liens_education_nationale_traiter()
{
	include_spip('action/editer_objet');
	$id_noisette=_request('id_noisette');
	/*$resultats=unserialize(_request('parametres'));*/
	$params=array();
	/*$params=unserialize(_request('parametres'));*/

	/* Compteur pour le nombre de boutons à afficher */
	$compteur=0;
/*----------------------------------------------------------------------------*/
/* Liste des boutons disponibles ---------------------------------------------*/
/*----------------------------------------------------------------------------*/
	$boutons=array('annuaire','bo','calendrier','contact',
		'dailymotion','facebook','flickr','lettres','linkedin',
		'mobile','moteur','pinterest','rss',
		'storify','tumblr','twitter','viadeo','vine');
/*----------------------------------------------------------------------------*/
/* Adresse par défaut des boutons --------------------------------------------*/
/*----------------------------------------------------------------------------*/
	$adresses=array();
	$adresses['annuaire']=
"http://www.education.gouv.fr/pid24301/annuaire-de-l-education.html";
	$adresses['bo']=
"http://www.education.gouv.fr/pid285/le-bulletin-officiel.html";
	$adresses['calendrier']=
"http://www.education.gouv.fr/pid25058/le-calendrier-scolaire.html";
	$adresses['contact']=
"http://www.education.gouv.fr/cid2559/contacts.html";
	$adresses['dailymotion']=
"http://www.dailymotion.com/EducationFrance";
	$adresses['facebook']=
"http://www.facebook.com/EducationFrance";
	$adresses['flickr']=
"https://www.flickr.com/photos/educationfrance";
	$adresses['lettres']=
"http://www.education.gouv.fr/pid23920/kiosque-actu.html";
	$adresses['linkedin']=
"https://www.linkedin.com/company/education-nationale?trk=nmp_rec_act_company_photo";
	$adresses['mobile']=
"http://www.education.gouv.fr/cid49108/version-mobile.html";
	$adresses['moteur']=
"http://www.education.gouv.fr/cid50125/moteur-de-recherche.html";
	$adresses['pinterest']=
"http://pinterest.com/educationfrance";
	$adresses['rss']=
"http://www.education.gouv.fr/cid50705/les-flux-rss.html";
	$adresses['storify']=
"http://storify.com/EducationFrance";
	$adresses['tumblr']=
"http://educationfrance.tumblr.com/";
	$adresses['twitter']=
"http://twitter.com/EducationFrance";
	$adresses['viadeo']=
"http://fr.viadeo.com/fr/company/ministere-de-l-education-nationale";
	$adresses['vine']=
"http://vine.co/u/1148602960381878272";
/*----------------------------------------------------------------------------*/
/* Si un des deux boutons OK pour l'apparence ou pour les boutons ------------*/
/*----------------------------------------------------------------------------*/
	if (isset($_POST['ok']) || isset($_POST['ok2'])) 
	{	/* On récupère les valeurs du formulaire sur l'apparence */
		$params['style']=_request('style');
		$params['col']=_request('col');
		$params['titre']=_request('titre');
		/* On récupère les valeurs du formulaire sur les boutons */
		foreach($boutons as $boutons)
		{	$params[$boutons]=_request($boutons);
			$params[$boutons."_adr"]=_request($boutons."_adr");
			/* On compte le nombre de boutons cochés */
			if($params[$boutons]=='oui'){$compteur++;}
		}
		/* On ajoute aux paramètres le nombre de boutons cochés */
		/* car si il est égal à zéro on n'affichera pas le module */
		$params['cpt']=$compteur;		
		echo $_POST['ok'];	
	}
/*----------------------------------------------------------------------------*/
/* Si premier bouton RESET pour l'apparence ----------------------------------*/
/*----------------------------------------------------------------------------*/
	elseif (isset($_POST['reset'])) 
	{	/* On initialise les valeurs du formulaire sur l'apparence */
		$params['style']="multibloc";
		$params['col']="aucune";
		$params['titre']="Liens Education Nationale";
		/* mais on garde les choix sur les boutons */
		foreach($boutons as $boutons)
		{	$params[$boutons]=_request($boutons);
			$params[$boutons."_adr"]=_request($boutons."_adr");
		}	
	}
/*----------------------------------------------------------------------------*/
/* Si deuxième bouton RESET pour les boutons ---------------------------------*/
/*----------------------------------------------------------------------------*/
	elseif (isset($_POST['reset2']))
	{	/* On garde les choix sur l'apparence */
		$params['style']=_request('style');
		$params['col']=_request('col');
		$params['titre']=_request('titre');	
		/* mais on initialise tous les boutons à non ainis que leur URL */	
		foreach($boutons as $boutons)
		{	$params[$boutons]="non";
			$params[$boutons."_adr"]=$adresses[$boutons];
		}		
	}
/*----------------------------------------------------------------------------*/
/* Adresses officielles par défaut - flèche retour arrière -------------------*/
/* On remet le ***_adr par défaut et on garde les autres choix ---------------*/
/*----------------------------------------------------------------------------*/
	 else
	 	{	
	 		/* On récupère les valeurs du formulaire pour l'apparence */
	 		$params['style']=_request('style');
	 		$params['col']=_request('col');
	 		$params['titre']=_request('titre');
	 		/* On récupère les valeurs du formulaire sur les boutons */
	 		foreach($boutons as $boutons)
	 		{	$params[$boutons]=_request($boutons);
	 			if(isset($_POST[$boutons."_retour"]))
	 			{	/* On écrase la valeur de l'URL par sa valeur par défaut */
	 				$params['$boutons."_adr"']=$adresses['$boutons'];
	 			}
	 			else
	 			{	/* On récupère l'URL saisie */
	 				$params[$boutons."_adr"]=_request($boutons."_adr");		
	 			}
	 		}	
	 	}
	 	
/*----------------------------------------------------------------------------*/
/* Création du tableau des paramètres ----------------------------------------*/
/*----------------------------------------------------------------------------*/
	$set=array('parametres'=>serialize($params));
	objet_modifier("noisette", $id_noisette, $set);
	/*echo ($params['col']);*/
/*----------------------------------------------------------------------------*/
/* Message pour la validation ------------------------------------------------*/
/*----------------------------------------------------------------------------*/
	if (isset($_POST['ok']) 
		&& $params['titre']=="") 
		{
	return array('message_erreur'=>'Il faut un intitul&eacute;.');
		}
	elseif (isset($_POST['ok'])) 
		{
	return array('message_ok'=>'Saisie enregistr&eacute;e','id_noisette'=>$id);
		}
	elseif (isset($_POST['ok2'])) 
		{
	return array('message_ok'=>'Saisie enregistr&eacute;e','id_noisette'=>$id);	
		}
	elseif (isset($_POST['reset'])) 
		{	
	return array('message_ok'=>'R&eacute;glages r&eacute;initialis&eacute;s
			 et enregistr&eacute;s','id_noisette'=>$id);
		}
	elseif (isset($_POST['reset2'])) 
		{	
	return array('message_ok'=>'Adresses r&eacute;initialis&eacute;es
			 et enregistr&eacute;es','id_noisette'=>$id);
		}
}
?>