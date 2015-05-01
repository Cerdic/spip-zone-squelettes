<?php
/**
 * Plugin Mediaspip Core
 * 
 * © 2010-2011 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 * Fichier des pipelines utilisés par le plugin
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

function mediaspip_core_mediaspip_extensions_lisibles($array){
	$array['mp3'] = array('son');
	$array['ogg'] = array('son,video');
	$array['ogv'] = array('video');
	$array['flv'] = array('son','video');
	$array['mov'] = array('video');
}

/**
 * On s'insère dans le pipeline styliser pour :
 *
 * -* Modifier la page auteur quand on est l'auteur en question
 * -** La page auteur classique reste basé sur le squelette contenu/auteur.html
 * -** La page auteur de la personne connectée est basé sur le squelette contenu/auteur-profil.html
 *
 * -* Modifier les squelettes des rubriques spécifiques à mediaspip
 *
 * @param array $flux le contexte donné à chaque page
 */
function mediaspip_core_styliser($flux){
	$squelette = $flux['data'];
	$fond = $flux['args']['fond'];
	$ext = $flux['args']['ext'];
	if(($flux['args']['id_rubrique'] > 0)
		&& in_array($flux['args']['contexte']['type'],array('article','rubrique'))){
		$rubriques_specifiques = lire_config('mediaspip/rubriques',array());
		$id_secteur = sql_getfetsel('id_secteur','spip_rubriques','id_rubrique='.$flux['args']['id_rubrique']);
		foreach($rubriques_specifiques as $type_rubrique => $id_rubrique){
			if($id_secteur == $id_rubrique){
				$flux['args']['contexte']['composition'] = $type_rubrique;
			}
		}
		if (isset($flux['args']['contexte']['composition'])
		  //AND substr($squelette,-strlen($fond))==$fond
		  AND $f=find_in_path($fond."-".$flux['args']['contexte']['composition'].".$ext")){
			$flux['data'] = substr($f,0,-strlen(".$ext"));
		}
	}else if(
		($flux['args']['contexte']['type'] == 'auteur')
		AND substr($squelette,-strlen($fond))==$fond
		&& (isset($GLOBALS['visiteur_session']['id_auteur']) && ($flux['args']['contexte']['id_auteur'] == $GLOBALS['visiteur_session']['id_auteur']))
		&& ($f=find_in_path($fond."-profil.".$ext))){
			$flux['data'] = substr($f,0,-strlen(".$ext"));
	}
	return $flux;
}

/**
 * Insertion dans le pipeline post_edition
 * - Invalide le cache lors de la modification d'objets
 * L'invalideur est passé par défaut sur les articles et forums
 * cf : ecrire/inc/modifier.php
 *
 * @param array $flux Le contexte du pipeline
 */
function mediaspip_core_post_edition($flux){
	if($flux['args']['action'] == 'modifier'){
		$id_table_objet = id_table_objet($flux['args']['type']);
		$id = $flux['args']['id_objet'];
		switch($flux['args']['type']){
			case 'auteur':
				$invalideur = "id='$id_table_objet/$id'";
		}
		if($invalideur){
			include_spip('inc/invalideur');
			suivre_invalideur($invalideur);
		}
	}
	if(in_array($flux['args']['operation'], array('ajouter_document','document_copier_local','supprimer_document'))){
		$id_document = $flux['args']['id_objet'];
		if(in_array($id_document,lire_config('mediaspip_docs_perdus',array()))){
			$verifier_originaux = charger_fonction('mediaspip_verifier_originaux','inc');
			$verifier_originaux();
		}
	}
	return $flux;
}

/**
 * Insertion dans le pipeline bigbrother_journaliser du plugin bigbrother
 * Ajoute la possibilité de journaliser les téléchargements de documents
 *
 * @param array $flux
 */
function mediaspip_core_bigbrother_journaliser($flux){
	$flux['telecharger'] = _T('mediaspip_core:bigbrother_texte_telecharger');
	return $flux;
}

/**
 * Insertion de javascripts dans le head
 *
 * @param array $plugins
 */
function mediaspip_core_jquery_plugins($plugins){
	$plugins[] = "javascript/jquery.equalheight.js";
	$plugins[] = "javascript/mediaspip_base.js";
	$plugins[] = "javascript/mediaspip_menu_categories.js";
	$plugins[] = _DIR_LIB_SLIDER."js/easySlider1.7.js";
	$plugins[] = _DIR_LIB_SVG."jquery.svg.js";
	
	return $plugins;
}

/**
 * Insertion dans le pipeline editer_contenu_objet
 * Enlève le champ de la clé PGP dans le formulaire de modification d'auteur
 *
 * @param array $flux
 * @return array
 */
function mediaspip_core_editer_contenu_objet($flux){
	$args = $flux['args'];
	$type = $args['type'];
	if (in_array($type,array('auteur')) && !test_espace_prive()){
		if (preg_match(",<li [^>]*class=[\"']editer_pgp.*<\/li>,Uims",$flux['data'],$regs)){
			$flux['data'] = preg_replace(",(<li [^>]*class=[\"']editer_pgp.*<\/li>),Uims","",$flux['data'],1);
		}
		if (preg_match(",<div [^>]*class=[\"']instituer_auteur.*<\/div>,Uims",$flux['data'],$regs)){
			$flux['data'] = preg_replace(",(<div [^>]*class=[\"']instituer_auteur).*</div>(<\/li>),Uims","\\2",$flux['data'],1);
		}
	}
	return $flux;
}

/**
 * Insertion dans le pipeline formulaire_charger (SPIP)
 * 
 * Vire le commentaire qui n'a pas de sens dans le formulaire d'inscription
 * 
 * @param array $flux Le contexte d'environnement du pipeline
 * @return array $flux Le contexte d'environnement modifié
 */
function mediaspip_core_formulaire_charger($flux){
	$form = $flux['args']['form'];
	if($form == 'inscription'){
		$valeurs['_commentaire'] = '';
		$flux['data'] = array_merge($flux['data'],$valeurs);
	}
	return $flux;
}


/**
 * Insertion dans le pipeline taches_generales_cron (SPIP)
 *
 * Lance la maintenance de mediaspip à intervalle régulier
 *
 * @return L'array des taches complété
 * @param array $taches_generales Un array des tâches du cron de SPIP
 */
function mediaspip_core_taches_generales_cron($taches_generales){
	$taches_generales['mediaspip_maintenance'] = 24*3600;
	return $taches_generales;
}

/**
 * Insertion dans le pipeline recuperer_fond (SPIP)
 * On ajoute des liens dans les fonds du type "inclure/diogene_modifier_publication_*"
 * - Un lien vers la gestion des forums des articles par exemple
 * 
 * @param array $flux
 */
function mediaspip_core_recuperer_fond($flux){
	if(!test_espace_prive() && is_string($flux['args']['fond'])){
		if (preg_match(',inclure\/diogene_modifier_publication_,i',$flux['args']['fond'])){
			global $visiteur_session;
			if(isset($visiteur_session['statut'])){
				$insert = recuperer_fond('inclure/diogene_modifier_ajouts',$flux['args']['contexte']);
				$pos_ul = strripos($flux['data']['texte'], '</ul>');
				$flux['data']['texte'] = substr_replace($flux['data']['texte'], $insert, $pos_ul, 0);
			}
		}
	}
	return $flux;
}

/**
 * Insertion dans le pipeline insert_head_css (SPIP)
 * Ajoute des styles par défaut des plugins que l'on utilise :
 * -* Forum
 * 
 * @param $flux
 */
function mediaspip_core_insert_head_css($flux){
	$flux .= '
<link rel="stylesheet" href="'.direction_css(parametre_url(generer_url_public('mediaspip_core.css'),'ltr', $GLOBALS['spip_lang_left'])).'" type="text/css" media="all" />
';
	return $flux;
}
?>