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
	
	// verifier que si un email a �t� saisi, il est bien valide :
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

/*----------------------------------------------------------------------------*/
/* Adresses officielles par d�faut - fl�che retour arri�re -------------------*/
/*----------------------------------------------------------------------------*/
	if(isset($_POST['annuaire_retour']))
		{$params['annuaire_adr']=
"http://www.education.gouv.fr/pid24301/annuaire-de-l-education.html";}
	elseif(isset($POST['bo_retour']))
		{$params['bo_adr']=
"http://www.education.gouv.fr/pid285/le-bulletin-officiel.html";}
	elseif(isset($POST['calendrier_retour']))
		{$params['calendrier_adr']=
"http://www.education.gouv.fr/pid25058/le-calendrier-scolaire.html";}
	elseif(isset($POST['contact_retour']))
		{$params['contact_adr']=
"http://www.education.gouv.fr/cid2559/contacts.html";}
	elseif(isset($POST['dailymotion_retour']))
		{$params['dailymotion_adr']=
"http://www.dailymotion.com/EducationFrance";}
	elseif(isset($POST['facebook_retour']))
		{$params['facebook_adr']=
"http://www.facebook.com/EducationFrance";}
	elseif(isset($POST['flickr_retour']))
		{$params['flickr_adr']=
"https://www.flickr.com/photos/educationfrance";}
	elseif(isset($POST['lettres_retour']))
		{$params['lettres_adr']=
"http://www.education.gouv.fr/pid23920/kiosque-actu.html";}
	elseif(isset($POST['mobileretour']))
		{$params['mobile_adr']=
"http://www.education.gouv.fr/cid49108/version-mobile.html";}
	elseif(isset($POST['moteur_retour']))
		{$params['moteur_adr']=
"http://www.education.gouv.fr/cid50125/moteur-de-recherche.html";}
	elseif(isset($POST['pinterest_retour']))
		{$params['pinterest_adr']=
"http://pinterest.com/educationfrance";}
	elseif(isset($POST['rss_retour']))
		{$params['rss_adr']=
"http://www.education.gouv.fr/cid50705/les-flux-rss.html";}
	elseif(isset($POST['storify_retour']))
		{$params['storify_adr']=
"http://storify.com/EducationFrance";}
	elseif(isset($POST['tumblr_retour']))
		{$params['tumblr_adr']=
"http://educationfrance.tumblr.com/";}
	elseif(isset($POST['twitter_retour']))
		{$params['twitter_adr']=
"http://twitter.com/EducationFrance";}
/*----------------------------------------------------------------------------*/
/* Si un des deux boutons OK pour l'apparence ou pour les boutons ------------*/
/*----------------------------------------------------------------------------*/
	elseif (isset($_POST['ok']) || isset($_POST['ok2'])) 
	{	/* On r�cup�re les valeurs du formulaire sur l'apparence */
		/* On r�cup�re les valeurs du formulaire sur les boutons */
		$params['style']=_request('style');
		$params['col']=_request('col');
		$params['titre']=_request('titre');		
		$params['annuaire']=_request('annuaire');
		$params['bo']=_request('bo');
		$params['calendrier']=_request('calendrier');
		$params['contact']=_request('contact');
		$params['dailymotion']=_request('dailymotion');
		$params['facebook']=_request('facebook');
		$params['flickr']=_request('flickr');
		$params['lettres']=_request('lettres');
		$params['mobile']=_request('mobile');
		$params['moteur']=_request('moteur');
		$params['pinterest']=_request('pinterest');
		$params['rss']=_request('rss');
		$params['storify']=_request('storify');
		$params['tumblr']=_request('tumblr');
		$params['twitter']=_request('twitter');	
		$params['annuaire_adr']=_request('annuaire_adr');
		$params['bo_adr']=_request('bo_adr');
		$params['calendrier_adr']=_request('calendrier_adr');
		$params['contact_adr']=_request('contact_adr');
		$params['dailymotion_adr']=_request('dailymotion_adr');
		$params['facebook_adr']=_request('facebook_adr');
		$params['flickr_adr']=_request('flickr_adr');
		$params['lettres_adr']=_request('lettres_adr');
		$params['mobile_adr']=_request('mobile_adr');
		$params['moteur_adr']=_request('moteur_adr');
		$params['pinterest_adr']=_request('pinterest_adr');
		$params['rss_adr']=_request('rss_adr');
		$params['storify_adr']=_request('storify_adr');
		$params['tumblr_adr']=_request('tumblr_adr');
		$params['twitter_adr']=_request('twitter_adr');	
	}
/*----------------------------------------------------------------------------*/
/* Si premier bouton RESET pour l'apparence ----------------------------------*/
/*----------------------------------------------------------------------------*/
	elseif (isset($_POST['reset'])) 
	{	/* On initialise les valeurs du formulaire sur l'apparence */
		/* mais on garde les choix sur les boutons */
		$params['style']="multibloc";
		$params['col']="col-md-12";
		$params['titre']="Lien Education Nationale";
		$params['annuaire']=_request('annuaire');
		$params['bo']=_request('bo');
		$params['calendrier']=_request('calendrier');
		$params['contact']=_request('contact');
		$params['dailymotion']=_request('dailymotion');
		$params['facebook']=_request('facebook');
		$params['flickr']=_request('flickr');
		$params['lettres']=_request('lettres');
		$params['mobile']=_request('mobile');
		$params['moteur']=_request('moteur');
		$params['pinterest']=_request('pinterest');
		$params['rss']=_request('rss');
		$params['storify']=_request('storify');
		$params['tumblr']=_request('tumblr');
		$params['twitter']=_request('twitter');		
		$params['annuaire_adr']=_request('annuaire_adr');
		$params['bo_adr']=_request('bo_adr');
		$params['calendrier_adr']=_request('calendrier_adr');
		$params['contact_adr']=_request('contact_adr');
		$params['dailymotion_adr']=_request('dailymotion_adr');
		$params['facebook_adr']=_request('facebook_adr');
		$params['flickr_adr']=_request('flickr_adr');
		$params['lettres_adr']=_request('lettres_adr');
		$params['mobile_adr']=_request('mobile_adr');
		$params['moteur_adr']=_request('moteur_adr');
		$params['pinterest_adr']=_request('pinterest_adr');
		$params['rss_adr']=_request('rss_adr');
		$params['storify_adr']=_request('storify_adr');
		$params['tumblr_adr']=_request('tumblr_adr');
		$params['twitter_adr']=_request('twitter_adr');	
	}
/*----------------------------------------------------------------------------*/
/* Si deuxi�me bouton RESET pour les boutons ---------------------------------*/
/*----------------------------------------------------------------------------*/
	elseif (isset($_POST['reset2']))
	{	/* On initialise tous les boutons � non */
		/* mais on garde les choix sur l'apparence */
		$params['style']=_request('style');
		$params['col']=_request('col');
		$params['titre']=_request('titre');		
		$params['annuaire']="non";
		$params['bo']="non";
		$params['calendrier']="non";
		$params['contact']="non";
		$params['dailymotion']="non";
		$params['facebook']="non";
		$params['flickr']="non";
		$params['lettres']="non";
		$params['mobile']="non";
		$params['moteur']="non";
		$params['pinterest']="non";
		$params['rss']="non";
		$params['storify']="non";
		$params['tumblr']="non";
		$params['twitter']="non";	
		$params['annuaire_adr']=
		"http://www.education.gouv.fr/pid24301/annuaire-de-l-education.html";
		$params['bo_adr']=
		"http://www.education.gouv.fr/pid285/le-bulletin-officiel.html";
		$params['calendrier_adr']=
		"http://www.education.gouv.fr/pid25058/le-calendrier-scolaire.html";
		$params['contact_adr']=
		"http://www.education.gouv.fr/cid2559/contacts.html";
		$params['dailymotion_adr']=
		"http://www.dailymotion.com/EducationFrance";
		$params['facebook_adr']=
		"http://www.facebook.com/EducationFrance";
		$params['flickr_adr']=
		"https://www.flickr.com/photos/educationfrance";
		$params['lettres_adr']=
		"http://www.education.gouv.fr/pid23920/kiosque-actu.html";
		$params['mobile_adr']=
		"http://www.education.gouv.fr/cid49108/version-mobile.html";
		$params['moteur_adr']=
		"http://www.education.gouv.fr/cid50125/moteur-de-recherche.html";
		$params['pinterest_adr']=
		"http://pinterest.com/educationfrance";
		$params['rss_adr']=
		"http://www.education.gouv.fr/cid50705/les-flux-rss.html";
		$params['storify_adr']=
		"http://storify.com/EducationFrance";
		$params['tumblr_adr']=
		"http://educationfrance.tumblr.com/";
		$params['twitter_adr']=
		"http://twitter.com/EducationFrance";	
	}
/*----------------------------------------------------------------------------*/
/* Cr�ation du tableau des param�tres ----------------------------------------*/
/*----------------------------------------------------------------------------*/
	$set=array('parametres'=>serialize($params));
	objet_modifier("noisette", $id_noisette, $set);
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
}
?>