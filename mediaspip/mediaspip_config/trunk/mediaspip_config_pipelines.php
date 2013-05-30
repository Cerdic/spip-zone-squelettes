<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Insertion dans le pipeline d'activation de thème
 * On vire le cookie de l'aperçu ou du switcher si présent
 *
 * @param $flux
 */
function mediaspip_config_zengarden_activer_theme($flux){
	if (isset($_COOKIE['spip_zengarden_theme'])){
		include_spip('inc/cookie');
		spip_setcookie('spip_zengarden_theme',$_COOKIE['spip_zengarden_theme']='',-1);
	}
	return $flux;
}

/**
 * Insertion dans le pipeline editer_contenu_objet
 * On enlève certains champs de formulaires pour éviter toute mauvaise manip
 *
 * @param array $flux
 * @return array
 */
function mediaspip_config_editer_contenu_objet($flux){
	$args = $flux['args'];
	$type = $args['type'];

	/**
	 * On ne modifie les formulaires que dans l'espace public
	 */
	if(!test_espace_prive()){
		/**
		 * On vire les champs que l'on ne souhaite pas
		 */
		
		$champs = array();
		
		/**
		 * Si c'est un menu créé à l'initialisation, on enlève la possibilité de modifier l'identifiant
		 */
		if(($type == 'menu') && in_array($args['contexte']['identifiant'],array('barrenav','barrelaterale','barrepied'))){
			$champs[] = 'identifiant';
			$champs[] = 'menu';
		}
		if(($args['contexte']['form'] == 'editer_diogene') && is_numeric($args['contexte']['id_diogene'])){
			$champs[] = 'type';
		}
		if(($args['contexte']['form'] == 'editer_rubrique') && preg_match(",secteur_seulement,Uims",$flux['data'],$secteur_seulement)){
			$flux['data'] = preg_replace(",(<li [^>]*class=[\"'][^>]*editer_parent.*<\/li>),Uims","",$flux['data'],1);
			$flux['data'] = preg_replace(",(<li [^>]*class=[\"'][^>]*editer_parents.*<\/li>),Uims","",$flux['data'],1);
		}
		foreach($champs as $champ){
			if (preg_match(",<li [^>]*class=[\"'][^>]*editer_($champ).*<\/li>,Uims",$flux['data'],$regs)){
				$flux['data'] = preg_replace(",(<li [^>]*class=[\"'][^>]*editer_($champ).*<\/li>),Uims","",$flux['data'],1);
			}
		}
	}
	return $flux;
}

/**
 * Insertion dans le pipeline formulaire_charger, au moment du chargement d'un CVT (SPIP)
 * On ajoute en hidden les champs obligatoires que l'on a enlevé du formulaire
 *
 * @param array $flux Le contexte du formulaire
 */
function mediaspip_config_formulaire_charger($flux){
	if(!test_espace_prive()){
		if($flux['args']['form'] == 'editer_menu'){
			if(in_array($flux['data']['identifiant'],array('barrepied','barrelaterale','barrenav'))){
				$flux['data']['_hidden'] .= '<input type="hidden" name="identifiant" value="'.$flux['data']['identifiant'].'" />';
			}
		}
		if($flux['args']['form'] == 'editer_diogene'){
			$flux['data']['_hidden'] .= '<input type="hidden" name="type" value="'.$flux['data']['type'].'" />';
		}
	}
	return $flux;
}

/**
 * Insertion dans le pipeline formulaire_verifier, au moment de la vérification d'un CVT (SPIP)
 * A la création d'un auteur ou sa modification, on force l'email et le nom si on ne le met pas à la poubelle
 *
 * @param array $flux Le contexte du formulaire
 */
function mediaspip_config_formulaire_verifier($flux){
	if($flux['args']['form'] == 'editer_auteur'){
		if(_request('statut') != '5poubelle'){
			if(!_request('email')){
				$flux['data']['email'] = _T('info_obligatoire');
			}
			if (!_request('nom') OR (_request('nom') == _T('ecrire:item_nouvel_auteur'))){
				$flux['data']['nom'] = _T('info_obligatoire');
			}
		}
	}
	return $flux;
}

/**
 * Insertion dans le pipeline formulaire_traiter, au moment du traitement d'un CVT (SPIP)
 * 
 * À la création d'un menu, on redirige sur sa page d'édition
 * Lors de la validation d'un formulaire de configuration ou d'édition de logo,
 * on purge le cache pour bien valider les changements 
 *
 * @param array $flux 
 * 		Le contexte du formulaire
 * @return array $flux 
 * 		Le contexte du formulaire modifié
 */
function mediaspip_config_formulaire_traiter($flux){
	if(!test_espace_prive() && ($flux['args']['form'] == 'editer_menu')){
		if(($flux['args']['args'][1] == 'oui') && is_numeric($flux['data']['id_menu'])){
			$flux['data']['redirect'] = parametre_url(parametre_url(self(),'nouveau','','&'),'id_config_menu',intval($flux['data']['id_menu']));
			$flux['data']['editable'] = false;
		}
	}
	/**
	 * Purge des caches lors de la validation d'un formulaire de configuration ou d'édition de logo
	 */
	if(	$flux['args']['form'] == 'editer_logo'
		OR (substr($flux['args']['form'],0,10) == 'configurer')){
		include_spip('inc/invalideur');
		suivre_invalideur('1');
	}
	return $flux;
}

/**
 * Insertion dans le pipeline objets_extensibles (du plugin champs extras)
 * On lui enlève (si on est dans l'espace public) les objets que l'on ne gère pas
 * 
 * @param array $flux Un tableau de la liste des objets extensibles
 */
function mediaspip_config_objets_extensibles($flux){
	if(!test_espace_prive()){
		foreach(array('breve','groupes_mot','mot') as $key){
			if(isset($flux[$key]))
				unset($flux[$key]);
		}
	}
	return $flux;
}

/**
 * Insertion dans le pipeline post_edition (SPIP)
 * 
 * A l'insertion d'une page unique, on crée une entrée dans le menu de pied
 * 
 * @param array $flux Le contexte du pipeline
 */
function mediaspip_config_post_edition($flux){
	if(($flux['args']['table'] == 'spip_articles') && ($flux['args']['action'] == 'instituer')){
		$article = sql_fetsel('*','spip_articles','id_article='.intval($flux['args']['id_objet']));
		if(($article['statut'] == 'publie') && ($article['statut'] != $flux['args']['statut_ancien']) && ($article['id_secteur'] == 0) && (($article['id_trad'] == 0) OR ($article['id_article'] == $article['id_trad']))){
			if($id_barre_pied= sql_getfetsel('id_menu','spip_menus','identifiant="barrepied"')){
				$menu_objets = sql_select('*','spip_menus_entrees','type_entree="objet"');
				$present = false;
				while($menu_objet = sql_fetch($menu_objets)){
					$params = unserialize($menu_objet['parametres']);
					if(($params['id_objet'] == $article['id_article']) && ($params['type_objet'] == 'article')){
						$present = true;
						break;
					}
				}
				if(!$present){
					include_spip('action/editer_menu');
					include_spip('action/editer_menus_entree');
					$entree = insert_menus_entree($id_barre_pied);
					$infos_entree = array(
						'rang' => 100,
						'type_entree' => 'objet',
						'parametres' => array(
											'type_objet' => 'article',
											'id_objet' => $article['id_article']
										)
					);
					menus_entree_set($entree, $infos_entree);
				}
			}
		}
	}
	return $flux;
}

/**
 * Insertion dans le pipeline menus_lister_disponibles (Plugin Menu)
 * 
 * On enlève de la liste des menus ceux que l'on ne souhaite pas voir affichés
 * 
 *  @param array $flux Le contexte d'environnement du pipeline
 */
function mediaspip_config_menus_lister_disponibles($flux){
	unset($flux['data']['page_speciale_zajax']);
	unset($flux['data']['groupe_mots']);
	unset($flux['data']['mots']);
	unset($flux['data']['secteurlangue']);
	unset($flux['data']['espace_prive']);
	return $flux;
}

/**
 * Insertion dans le pipeline formulaire_admin (SPIP)
 * 
 * Si on est en prévisualisation de zen-garden, on affiche un bouton supplémentaire 
 * dans le formulaire d'admin
 * 
 *  @param array $flux Le contexte d'environnement du pipeline
 */
function mediaspip_config_formulaire_admin($flux){
	if($_COOKIE['spip_zengarden_theme']){
		$desactive_previsu = '<a href="'.generer_action_auteur(zengarden_desactiver_previsu,$_COOKIE['spip_zengarden_theme'],self()).'" class="spip-admin-boutons" id="theme_previsu">'._T('mediaspip_config:theme_desactiver_previsu').'</a>';
		$pos_div = strpos($flux['data'], '</div>');
		$flux['data'] = substr_replace($flux['data'], $desactive_previsu, $pos_div, 0);
	}
	return $flux;
}


/**
 * Insertion dans le pipeline recuperer_fond (SPIP)
 * Modifie les labels du formulaire d'édition d'auteur
 *
 * @param array $flux
 * @return array
 */
function mediaspip_config_recuperer_fond($flux){
	global $visiteur_session;
	if ($flux['args']['fond']=='formulaires/editer_auteur'){
		if($flux['args']['contexte']['id_auteur'] != $visiteur_session['id_auteur']){
			$flux['data']['texte'] = preg_replace(",(<li.*class=\"editer_nom.*>.*<p class=\'explication.*>)(.*)(<\/p>.*<\/li>),Uims","\\1"._T('mediaspip_config:explication_form_signature_auteur')."\\3",$flux['data']['texte'],1);
			$flux['data']['texte'] = preg_replace(",(<li.*class=\'editer_identification.*\'>.*<h3.*class=\"legend.*>)(.*)(<\/h3>.*<\/li>),Uims","\\1"._T('mediaspip_config:legend_form_identification_auteur')."\\3",$flux['data']['texte'],1);
			$flux['data']['texte'] = preg_replace(",(<label.*for=\"email\">)(.*)(<\/label>),Uims","\\1"._T('mediaspip_config:label_form_email_auteur')."\\3",$flux['data']['texte'],1);
			$flux['data']['texte'] = preg_replace(",(<label.*for=\"bio\">)(.*)(<\/label>),Uims","\\1"._T('mediaspip_config:label_form_bio_auteur')."\\3",$flux['data']['texte'],1);
			$flux['data']['texte'] = preg_replace(",(<label.*for=\"nom_site\">)(.*)(<\/label>),Uims","\\1"._T('mediaspip_config:label_form_nom_site_auteur')."\\3",$flux['data']['texte'],1);
			$flux['data']['texte'] = preg_replace(",(<label.*for=\"url_site\">)(.*)(<\/label>),Uims","\\1"._T('mediaspip_config:label_form_url_site_auteur')."\\3",$flux['data']['texte'],1);
		}
	}
	return $flux;
}
?>