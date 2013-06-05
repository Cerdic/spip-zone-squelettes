<?php
/**
 * Plugin Mediaspip Core
 * 
 * Auteurs :
 * kent1 (http://www.kent1.info - kent1@arscenic.info)
 *
 * © 2010-2013 - Distribue sous licence GNU/GPL
 * 
 * Fichier des pipelines utilisés par le plugin
 * 
 * @package SPIP\Mediaspip_Core\Pipelines
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
		
	if(isset($flux['args']['id_rubrique']) && isset($flux['args']['contexte']['type-page'])
		&& ($flux['args']['id_rubrique'] > 0)
		&& in_array($flux['args']['contexte']['type-page'],array('article','rubrique'))){
		include_spip('inc/config');
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
	}else if(isset($flux['args']['contexte']['type-page'])
		&& ($flux['args']['contexte']['type-page'] == 'auteur')
		&& substr($squelette,-strlen($fond))==$fond
		&& isset($flux['args']['contexte']['id_auteur'])
		&& ($flux['args']['contexte']['id_auteur'] == $GLOBALS['visiteur_session']['id_auteur'])
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
 * Insertion dans le pipeline insert_head (SPIP)
 *
 * Insertion de librairies javascripts dans le head, au niveau des plugins jQuery
 * pour être compressés automatiquement
 * 
 * - jQuery equalheight permettant de mettre des éléments d'une page à la même taille
 * - easyslider
 * - mediaspip_base.js
 * - mediaspip_menu_categories 
 * (comme c'est le même que pour le plugin de documentation, si ce plugin est présent, 
 * on ne l'ajoute pas)
 * - jquery.svg.js permettant d'afficher les fichiers de type svg correctement
 *
 * @param array $plugins
 */
function mediaspip_core_jquery_plugins($plugins){
	if(!test_espace_prive()){
		$plugins[] = "javascript/jquery.equalheight.js";
		$plugins[] = "javascript/mediaspip_base.js";
		$plugins[] = "javascript/easySlider1.7.js";
		$plugins[] = _DIR_LIB_SVG."jquery.svg.js";
		if(!defined('_DIR_PLUGIN_DOCUMENTATION'))
			$plugins[] = "javascript/mediaspip_menu_categories.js";
	}
	
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
		if (preg_match(",<li [^>]*class=[\"']editer editer_pgp.*<\/li>,Uims",$flux['data'],$regs)){
			$flux['data'] = preg_replace(",(<li [^>]*class=[\"']editer_pgp.*<\/li>),Uims","",$flux['data'],1);
		}
		if (preg_match(",<div [^>]*class=[\"']editer instituer_auteur.*<\/div>,Uims",$flux['data'],$regs)){
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
		$flux['data']['_commentaire'] = '';
	}
	return $flux;
}

/**
 * Insertion dans le pipeline formulaire_verifier (SPIP)
 * 
 * Vérifier les formulaires de configuration
 * 
 * @param array $flux Le contexte d'environnement du pipeline
 * @return array $flux Le contexte d'environnement modifié
 */
function mediaspip_core_formulaire_verifier($flux){
	$form = $flux['args']['form'];
	if($form == 'configurer_mediaspip_home'){
		$numeriques = array('document_largeur_maximale_exergue','document_hauteur_maximale_exergue','nb_sites_nav','nb_syndics_nav');
		foreach($numeriques as $numerique){
			if(_request($numerique) && !ctype_digit(_request($numerique))){
				$flux['data'][$numerique] = _T('mediaspip_core:erreur_valeur_int');
			}
		}
		
		$inf_cents = array('nb_sites_nav','nb_syndics_nav');
		foreach($inf_cents as $inf_cent){
			if(!$flux['data'][$inf_cent] && _request($inf_cent) && (_request($inf_cent) > 100)){
				$flux['data'][$inf_cent] = _T('mediaspip_core:erreur_valeur_int_inf',array('nb'=>'100'));
			}
		}
		
		$inf_milles = array('document_largeur_maximale_exergue','document_hauteur_maximale_exergue');
		foreach($inf_milles as $inf_mille){
			if(!$flux['data'][$inf_mille] && _request($inf_mille) && (_request($inf_mille) > 1000)){
				$flux['data'][$inf_mille] = _T('mediaspip_core:erreur_valeur_int_inf',array('nb'=>'1000'));
			}
		}
	}
	else if($form == 'configurer_mediaspip_squelettes'){
		$numeriques = array(
					'logo_largeur',
					'logo_hauteur',
					'logo_objets_largeur',
					'nb_syndics_nav',
					'vignette_grande_largeur',
					'vignette_grande_hauteur',
					'vignettes_nav_largeur',
					'vignettes_nav_hauteur',
					'vignettes_nav_nb',
					'vignettes_download_largeur',
					'vignettes_download_hauteur'
		);
		
		foreach($numeriques as $numerique){
			if(_request($numerique) && !ctype_digit(_request($numerique))){
				$flux['data'][$numerique] = _T('mediaspip_core:erreur_valeur_int');
			}
		}
		
		$inf_30s = array('vignettes_nav_nb');
		foreach($inf_30s as $inf_30){
			if(!$flux['data'][$inf_30] && _request($inf_30) && (_request($inf_30) > 30)){
				$flux['data'][$inf_30] = _T('mediaspip_core:erreur_valeur_int_inf',array('nb'=>'30'));
			}
		}
		
		$inf_cents = array('nb_sites_nav','nb_syndics_nav');
		foreach($inf_cents as $inf_cent){
			if(!$flux['data'][$inf_cent] && _request($inf_cent) && (_request($inf_cent) > 100)){
				$flux['data'][$inf_cent] = _T('mediaspip_core:erreur_valeur_int_inf',array('nb'=>'100'));
			}
		}
		
		$inf_milles = array(
						'logo_hauteur',
						'logo_objets_largeur',
						'logo_objets_hauteur',
						'vignette_grande_largeur',
						'vignette_grande_hauteur',
						'vignettes_nav_largeur',
						'vignettes_nav_hauteur',
						'vignettes_download_largeur',
						'vignettes_download_hauteur'
		);
		foreach($inf_milles as $inf_mille){
			if(!$flux['data'][$inf_mille] && _request($inf_mille) && (_request($inf_mille) > 1000)){
				$flux['data'][$inf_mille] = _T('mediaspip_core:erreur_valeur_int_inf',array('nb'=>'1000'));
			}
		}
		
		$inf_2milles = array('logo_largeur');
		foreach($inf_2milles as $inf_2mille){
			if(!$flux['data'][$inf_2mille] && _request($inf_2mille) && (_request($inf_2mille) > 2000)){
				$flux['data'][$inf_2mille] = _T('mediaspip_core:erreur_valeur_int_inf',array('nb'=>'2000'));
			}
		}
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
 * Ce lien n'est ajouté que si un diogène lié existe
 * 
 * @param array $flux
 * 		Le contexte du pipeline
 * @return array $flux
 * 		Le contexte du pipeline modifié
 */
function mediaspip_core_recuperer_fond($flux){
	if(!test_espace_prive() && is_string($flux['args']['fond'])){
		if (preg_match(',inclure\/diogene_modifier_publication_,i',$flux['args']['fond'])){
			if(isset($GLOBALS['visiteur_session']['statut'])){
				$pos_ul = strripos($flux['data']['texte'], '</ul>');
				/**
				 * Si on n'a pas d'ul c'est que l'on n'est pas dans un diogène
				 */
				if($pos_ul){
					$insert = recuperer_fond('inclure/diogene_modifier_ajouts',$flux['args']['contexte']);
					$flux['data']['texte'] = substr_replace($flux['data']['texte'], $insert, $pos_ul, 0);
				}
			}
		}
	}
	return $flux;
}

/**
 * Insertion dans le pipeline insert_head_css (SPIP)
 * 
 * Ajout de 2 feuilles de styles :
 * -* Celle, facultative, pour les thèmes ayant une css css/mediaspip.css
 * -* Celle des styles par défaut des plugins que l'on utilise (mediaspip_core.css.html) :
 * -** Forum utilisé par la page de gestion de forum des utilisateurs
 * 
 * @param string $flux le contenu textuel du pipeline
 * @return string $flux le contenu textuel modifié du pipeline
 */
function mediaspip_core_insert_head_css($flux){
	if($css = find_in_path('css/mediaspip.css')){
		$flux .= '
<link rel="stylesheet" href="'.direction_css($css).'" type="text/css" media="all" />
';
	}
	$flux .= '
<link rel="stylesheet" href="'.direction_css(parametre_url(generer_url_public('mediaspip_core.css'),'ltr','left')).'" type="text/css" media="all" />
';
	return $flux;
}

/**
 * Insertion dans le pipeline mediaspip_player_flowjs (mediaspip_player)
 * Modifie le contenu du player lorsqu'il est embed
 * 
 * @param array $flux le contenu textuel du pipeline
 * @return array $flux le contenu textuel modifié du pipeline
 */
function mediaspip_core_mediaspip_player_flowjs($flux){
	if(isset($flux['args']['id_document']) && intval($flux['args']['id_document'])){
		if(isset($flux['data']['plugins']['title']['html'])){
			include_spip('inc/config');
			spip_log($flux['data']['plugins']['title']['html'],'test');
			$article = sql_fetsel('id_article,titre','spip_articles AS art left join spip_documents_liens AS doc_liens ON art.id_article = doc_liens.id_objet AND doc_liens.objet="article"','doc_liens.id_document='.intval($flux['args']['id_document']));
			if(count($article) == 2){
				$infos_titre['titre'] = $article['titre'];
				$infos_titre['url_article'] = url_absolue(generer_url_entite($article['id_article'],'article'));
				$infos_titre['url_site'] = $GLOBALS['meta']['adresse_site'];
				$infos_titre['nom_site'] = $GLOBALS['meta']['nom_site'];
				$infos_titre['noms'] = str_replace('<a ','<a target="_blank" ',str_replace("'",'"',liens_absolus(recuperer_fond('modeles/lesauteurs',array('id_article'=>intval($article['id_article']))))));
				$flux['data']['plugins']['title']['html'] = _T('mediaspip_core:titre_flow_js',$infos_titre);
				spip_log($flux['data']['plugins']['title']['html'],'test');
			}
		}
			
	}
	return $flux;
}

/**
 * Insertion dans le pipeline declarer_tables_objets_sql (SPIP)
 * 
 * On rend non éditables les tables que l'on ne souhaite pas voir dans champs extras
 * 
 * @param array $tables Un tableau de définition des tables
 * @return array $tables Le tableau de définition des tables modifié
 */
function mediaspip_core_declarer_tables_objets_sql($tables){
	if(!test_espace_prive()){
		$tables['spip_diogenes']['editable'] = 'non';
		$tables['spip_messages']['editable'] = 'non';
		$tables['spip_breves']['editable'] = 'non';
		$tables['spip_mots']['editable'] = 'non';
		$tables['spip_groupes_mots']['editable'] = 'non';
	}
	
	$tables['spip_articles']['field']['ms_auth_telecharger'] = "VARCHAR(15) DEFAULT 'defaut' NOT NULL";
	$tables['spip_articles']['field']['ms_auth_telecharger_loggues'] = "VARCHAR(15) DEFAULT '' NOT NULL";

	$tables['spip_articles']['champs_editables'][] = 'ms_auth_telecharger';
	$tables['spip_articles']['champs_editables'][] = 'ms_auth_telecharger_loggues';
	
	return $tables;
}

/**
 * Insertion dans le pipeline diogene_ajouter_saisies (plugin Diogene)
 * On ajoute simplement le selecteur d'autorisation à télécharger les documents
 * 
 * @param array $flux Le contexte d'environnement
 */
function mediaspip_core_diogene_ajouter_saisies($flux){
	if(is_array(unserialize($flux['args']['champs_ajoutes'])) && in_array('ms_auth_telecharger',unserialize($flux['args']['champs_ajoutes']))){
    	$flux['data'] .= recuperer_fond('formulaires/diogene_ajouter_medias_ms_auth_telecharger',$flux['args']['contexte']);
	}
    return $flux;
}

/**
 * Insertion dans le pipeline diogene_verifier (plugin Diogene)
 * On ajoute une vérification de la licence
 * 
 * @param array $flux Le contexte d'environnement
 */
function mediaspip_core_diogene_verifier($flux){
	$erreurs = &$flux['args']['erreurs'];

	return $flux;
}

/**
 * Insertion dans le pipeline diogene_traiter (plugin Diogene)
 * On ajoute la licence dans les champs à enregistrer
 * 
 * @param array $flux Le contexte d'environnement
 */
function mediaspip_core_diogene_traiter($flux){
	$id_objet = $flux['args']['id_objet'];
	if(intval($id_objet) && ($ms_auth_telecharger = _request('ms_auth_telecharger'))){
		$flux['data']['ms_auth_telecharger'] = $ms_auth_telecharger;
		$flux['data']['ms_auth_telecharger_loggues'] = _request('ms_auth_telecharger_loggues');
	}
	return $flux;
}

/**
 * Insertion dans le pipeline diogene_objets
 * On ajoute la possibilité de prise en compte des licences sur les articles
 * 
 * @param array $flux Un tableau des champs que l'on peut ajouter aux formulaires
 * @return array $flux Le tableau des champs complétés
 */
function mediaspip_core_diogene_objets($flux){
	$flux['emballe_media']['champs_sup']['ms_auth_telecharger'] = _T('mediaspip_core:select_ms_auth_telecharger');
	return $flux;
}
?>