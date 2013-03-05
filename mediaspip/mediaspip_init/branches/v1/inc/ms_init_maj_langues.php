<?php
/**
 * Plugin MediaSPIP Init
 * © 2010-2011 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Modification des titres et contenus de certains objets créés par MediaSPIP
 * au changement de langue
 */
function inc_ms_init_maj_langues_dist(){
	/**
	 * La langue avec laquelle on arrive ici
	 */
	$langue_depart = $GLOBALS['spip_lang'];
	
	/**
	 * On crée un array des langues activées
	 */
	$langues_possibles = explode(',',$GLOBALS['meta']['langues_multilingue']);
	
	/**
	 * On ne fait quelque chose que si plusieurs langues sont activées
	 */
	if(count($langues_possibles) > 1){
		/**
		 * On place la langue par défaut du site en premier
		 */
		unset($langues_possibles[$GLOBALS['meta']['langue_site']]);
		array_unshift($langues_possibles,$GLOBALS['meta']['langue_site']);
		
		/**
		 * On s'occupe de la rubrique media
		 */
		$config_medias = lire_config('mediaspip/rubriques/medias',null);
		$rubrique_medias = sql_fetsel('*','spip_rubriques','id_rubrique = '.intval($config_medias));

		if(intval($rubrique_medias['id_rubrique']) > 0){
			/**
			 * On ne se permet de modfifier que si le titre dans la langue principale du site n'a pas changé 
			 */
			changer_langue($GLOBALS['meta']['langue_site']);
			if(extraire_multi($rubrique_medias['titre'], $GLOBALS['meta']['langue_site']) == _T('mediaspip_init:titre_rubrique_medias')){
				$titres = $changes = $nouveaux = array();
				foreach($langues_possibles as $lang){
					changer_langue($lang);
					if($lang == $GLOBALS['meta']['langue_site']){
						$nouveaux[$lang] = _T('mediaspip_init:titre_rubrique_medias');
					}else{
						$titres[$lang] = extraire_multi($rubrique_medias['titre'], $lang);
						if($titres[$lang] != _T('mediaspip_init:titre_rubrique_medias')){
							$nouveaux[$lang] = _T('mediaspip_init:titre_rubrique_medias');
						}
					}
				}
				if(count($nouveaux) > 0){
					$titre = ms_init_creer_multi($nouveaux);
				}else{
					$titre = $nouveaux[0];
				}
				if($titre != $rubrique_medias['titre']){
					sql_updateq('spip_rubriques',array('titre'=>$titre),'id_rubrique='.intval($rubrique_medias['id_rubrique']));
				}
			}
		}
		
		/**
		 * On s'occupe de la rubrique editos
		 */
		$config_editos = lire_config('mediaspip/rubriques/editos',null);
		$rubrique_editos = sql_fetsel('*','spip_rubriques','id_rubrique = '.intval($config_editos));

		if(intval($rubrique_editos['id_rubrique']) > 0){
			/**
			 * On ne se permet de modfifier que si le titre dans la langue principale du site n'a pas changé 
			 */
			changer_langue($GLOBALS['meta']['langue_site']);
			if(extraire_multi($rubrique_editos['titre'], $GLOBALS['meta']['langue_site']) == _T('mediaspip_init:titre_rubrique_editos')){
				$titres = $changes = $nouveaux = array();
				foreach($langues_possibles as $lang){
					changer_langue($lang);
					if($lang == $GLOBALS['meta']['langue_site']){
						$nouveaux[$lang] = _T('mediaspip_init:titre_rubrique_editos');
					}else{
						$titres[$lang] = extraire_multi($rubrique_editos['titre'], $lang);
						if($titres[$lang] != _T('mediaspip_init:titre_rubrique_editos')){
							$nouveaux[$lang] = _T('mediaspip_init:titre_rubrique_editos');
						}
					}
				}
				if(count($nouveaux) > 0){
					$titre = ms_init_creer_multi($nouveaux);
				}else{
					$titre = $nouveaux[0];
				}
				if($titre != $rubrique_editos['titre']){
					sql_updateq('spip_rubriques',array('titre'=>$titre),'id_rubrique='.intval($rubrique_editos['id_rubrique']));
				}
			}
		}
		
		/**
		 * On s'occupe de la rubrique actus
		 */
		$config_actus = lire_config('mediaspip/rubriques/actus',null);
		$rubrique_actus = sql_fetsel('*','spip_rubriques','id_rubrique = '.intval($config_actus));

		if(intval($rubrique_actus['id_rubrique']) > 0){
			/**
			 * On ne se permet de modfifier que si le titre dans la langue principale du site n'a pas changé 
			 */
			changer_langue($GLOBALS['meta']['langue_site']);
			if(extraire_multi($rubrique_actus['titre'], $GLOBALS['meta']['langue_site']) == _T('mediaspip_init:titre_rubrique_actus')){
				$titres = $changes = $nouveaux = array();
				foreach($langues_possibles as $lang){
					changer_langue($lang);
					if($lang == $GLOBALS['meta']['langue_site']){
						$nouveaux[$lang] = _T('mediaspip_init:titre_rubrique_actus');
					}else{
						$titres[$lang] = extraire_multi($rubrique_actus['titre'], $lang);
						if($titres[$lang] != _T('mediaspip_init:titre_rubrique_actus')){
							$nouveaux[$lang] = _T('mediaspip_init:titre_rubrique_actus');
						}
					}
				}
				if(count($nouveaux) > 0){
					$titre = ms_init_creer_multi($nouveaux);
				}else{
					$titre = $nouveaux[0];
				}
				if($titre != $rubrique_actus['titre']){
					sql_updateq('spip_rubriques',array('titre'=>$titre),'id_rubrique='.intval($rubrique_actus['id_rubrique']));
				}
			}
		}
		
		/**
		 * On s'occupe de la rubrique sites
		 */
		$config_sites = lire_config('mediaspip/rubriques/sites',null);
		$rubrique_sites = sql_fetsel('*','spip_rubriques','id_rubrique = '.intval($config_sites));

		if(intval($rubrique_sites['id_rubrique']) > 0){
			/**
			 * On ne se permet de modfifier que si le titre dans la langue principale du site n'a pas changé 
			 */
			changer_langue($GLOBALS['meta']['langue_site']);
			if(extraire_multi($rubrique_sites['titre'], $GLOBALS['meta']['langue_site']) == _T('mediaspip_init:titre_rubrique_sites')){
				$titres = $changes = $nouveaux = array();
				foreach($langues_possibles as $lang){
					changer_langue($lang);
					if($lang == $GLOBALS['meta']['langue_site']){
						$nouveaux[$lang] = _T('mediaspip_init:titre_rubrique_sites');
					}else{
						$titres[$lang] = extraire_multi($rubrique_sites['titre'], $lang);
						if($titres[$lang] != _T('mediaspip_init:titre_rubrique_sites')){
							$nouveaux[$lang] = _T('mediaspip_init:titre_rubrique_sites');
						}
					}
				}
				if(count($nouveaux) > 0){
					$titre = ms_init_creer_multi($nouveaux);
				}else{
					$titre = $nouveaux[0];
				}
				if($titre != $rubrique_sites['titre']){
					sql_updateq('spip_rubriques',array('titre'=>$titre),'id_rubrique='.intval($rubrique_sites['id_rubrique']));
				}
			}
		}
		
		/**
		 * On s'occupe de la rubrique mag
		 */
		$config_mag = lire_config('mediaspip/rubriques/mag',null);
		$rubrique_mag = sql_fetsel('*','spip_rubriques','id_rubrique = '.intval($config_mag));

		if(intval($rubrique_mag['id_rubrique']) > 0){
			/**
			 * On ne se permet de modfifier que si le titre dans la langue principale du site n'a pas changé 
			 */
			changer_langue($GLOBALS['meta']['langue_site']);
			if(extraire_multi($rubrique_mag['titre'], $GLOBALS['meta']['langue_site']) == _T('mediaspip_init:titre_rubrique_mag')){
				$titres = $changes = $nouveaux = array();
				foreach($langues_possibles as $lang){
					changer_langue($lang);
					if($lang == $GLOBALS['meta']['langue_site']){
						$nouveaux[$lang] = _T('mediaspip_init:titre_rubrique_mag');
					}else{
						$titres[$lang] = extraire_multi($rubrique_mag['titre'], $lang);
						if($titres[$lang] != _T('mediaspip_init:titre_rubrique_mag')){
							$nouveaux[$lang] = _T('mediaspip_init:titre_rubrique_mag');
						}
					}
				}
				if(count($nouveaux) > 0){
					$titre = ms_init_creer_multi($nouveaux);
				}else{
					$titre = $nouveaux[0];
				}
				if($titre != $rubrique_mag['titre']){
					sql_updateq('spip_rubriques',array('titre'=>$titre),'id_rubrique='.intval($rubrique_mag['id_rubrique']));
				}
			}
		}
		/**
		 * On restaure la langue de départ
		 */
		changer_langue($langue_depart);
	}
	return true;
}

function ms_init_creer_multi($titres=array()){
	$titre_final = '<multi>';
	foreach($titres as $lang=>$titre){
		$titre_final .= "[$lang]$titre";
	}
	$titre_final .= '</multi>';
	return $titre_final;
}
?>