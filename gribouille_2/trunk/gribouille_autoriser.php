<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
/* pour que le pipeline ne rale pas ! */
function gribouille_autoriser(){}

/**
 * Modification de l'autorisation de modifier un article
 * - On se base d'abord sur l'autorisation de base de SPIP
 * - Sinon on se base sur la configuration du cfg que nous avons faite
 * 
 * @param object $faire
 * @param object $quoi
 * @param object $id
 * @param object $qui
 * @param object $opts
 * @return 
 */
function autoriser_article_modifier($faire,$quoi,$id,$qui,$opts){
	$autorise = false;
	if(autoriser_article_modifier_dist($faire,$quoi,$id,$qui,$opts)){
		return autoriser_article_modifier_dist($faire,$quoi,$id,$qui,$opts);
	}
	if(function_exists('lire_config')){
		$secteurs_wiki = lire_config('gribouille/secteurs_wiki', array());
		$id_secteur = sql_getfetsel('id_secteur','spip_articles','id_article='.intval($id));
		if(in_array($id_secteur,$secteurs_wiki)){
			$type = lire_config('gribouille/autorisations/ecrire_type', 'webmestre');
			switch($type) {
				case 'webmestre':
					// Webmestres uniquement
					$autorise = tickets_verifier_webmestre($qui);
					break;
				case 'par_statut':
					// Traitement spécifique pour la valeur 'tous'
					if(in_array('tous',lire_config('gribouille/autorisations/ecrire_statuts',array()))){
						return true;
					}
					// Autorisation par statut
					$autorise = in_array($qui['statut'], lire_config('gribouille/autorisations/ecrire_statuts',array('0minirezo')));
					break;
				case 'par_auteur':
					// Autorisation par id d'auteurs
					$autorise = in_array($qui['id_auteur'], lire_config('gribouille/autorisations/ecrire_auteurs',array()));
					break;
			}
		}
	}else{
		return autoriser('modifier','article',$id,$qui,$opts);
	}
	return $autorise;
}

/**
 * Modification de l'autorisation de publier un article ou une rubrique dans une autre
 * - On se base d'abord sur l'autorisation de base de SPIP
 * - Sinon on se base sur la configuration du cfg que nous avons faite
 * 
 * @param object $faire
 * @param object $quoi
 * @param object $id
 * @param object $qui
 * @param object $opts
 * @return 
 */
function autoriser_rubrique_publierdans($faire,$quoi,$id,$qui,$opts){
	$autorise = false;
	if(autoriser_rubrique_publierdans_dist($faire,$quoi,$id,$qui,$opts)){
		return autoriser_rubrique_publierdans_dist($faire,$quoi,$id,$qui,$opts);
	}
	if(function_exists('lire_config')){
		$secteurs_wiki = lire_config('gribouille/secteurs_wiki', array());
		$id_secteur = sql_getfetsel('id_secteur','spip_rubriques','id_rubrique='.intval($id));
		if(in_array($id_secteur,$secteurs_wiki)){
			$type = lire_config('gribouille/autorisations/ecrire_type', 'webmestre');
			switch($type) {
				case 'webmestre':
					// Webmestres uniquement
					$autorise = tickets_verifier_webmestre($qui);
					break;
				case 'par_statut':
					// Traitement spécifique pour la valeur 'tous'
					if(in_array('tous',lire_config('gribouille/autorisations/ecrire_statuts',array()))){
						return true;
					}
					// Autorisation par statut
					$autorise = in_array($qui['statut'], lire_config('gribouille/autorisations/ecrire_statuts',array('0minirezo')));
					break;
				case 'par_auteur':
					// Autorisation par id d'auteurs
					$autorise = in_array($qui['id_auteur'], lire_config('gribouille/autorisations/ecrire_auteurs',array()));
					break;
			}
		}
	}else{
		return autoriser('publier_dans','rubrique',$id,$qui,$opts);
	}
	return $autorise;
}

/**
 * Modification de l'autorisation de voir les rubriques (utilisées dans le privé)
 * Nous l'utilisons au moment du choix du squelette dans le pipeline styliser
 * On renvoie une erreur 404 si nous ne sommes pas autorisé.
 * - On vérifie tout d'abord si nous sommes autorisé à plublier dans cette rubrique
 * Si oui, on passe outre la configuration
 * - On vérifie ensuite si on est autorisé dans le CFG
 * 
 * @param string $faire L'action à réaliser
 * @param string $quoi L'objet sur lequel on réalise cette action
 * @param int $id L'id de l'objet en question
 * @param array $qui L'array des infos de session de l'auteur connecté
 * @param object $opts
 * @return true ou false
 */
function autoriser_rubrique_voir($faire,$quoi,$id,$qui,$opts){
	$autorise = false;
	if(autoriser('publierdans','rubrique',$id,$qui,$opts)){
		return autoriser('publierdans','rubrique',$id,$qui,$opts);
	}
	if(function_exists('lire_config')){
		$secteurs_wiki = lire_config('gribouille/secteurs_wiki', array());
		$id_secteur = sql_getfetsel('id_secteur','spip_rubriques','id_rubrique='.intval($id));
		if(in_array($id_secteur,$secteurs_wiki)){
			$type = lire_config('gribouille/autorisations/voir_type', 'webmestre');
			switch($type) {
				case 'webmestre':
					// Webmestres uniquement
					$autorise = tickets_verifier_webmestre($qui);
					break;
				case 'par_statut':
					// Traitement spécifique pour la valeur 'tous'
					if(in_array('tous',lire_config('gribouille/autorisations/voir_statuts',array()))){
						return true;
					}
					// Autorisation par statut
					$autorise = in_array($qui['statut'], lire_config('gribouille/autorisations/voir_statuts',array('0minirezo')));
					break;
				case 'par_auteur':
					// Autorisation par id d'auteurs
					$autorise = in_array($qui['id_auteur'], lire_config('gribouille/autorisations/voir_auteurs',array()));
					break;
			}
		}
	}else{
		return autoriser('voir','rubrique',$id,$qui,$opts);
	}
	return $autorise;
}
function gribouille_verifier_webmestre($qui){
	$webmestre =  false;
	$webmestre = in_array($qui['id_auteur'],explode(':', _ID_WEBMESTRES));
	if(!$webmestre && ($qui['webmestre']=='oui')){
		$webmestre =  true;
	}
	return $webmestres;
}
?>