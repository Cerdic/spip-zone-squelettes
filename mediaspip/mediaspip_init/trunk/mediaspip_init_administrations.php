<?php
/**
 * Plugin MediaSPIP Init
 * © 2010-2012 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 * Fichier d'installation du plugin
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Installation du plugin MediaSPIP Initialisation
 */
include_spip('inc/meta');
function mediaspip_init_upgrade($nom_meta_base_version,$version_cible){
	$current_version = 0.0;
	if ((!isset($GLOBALS['meta'][$nom_meta_base_version]) )
			|| (($current_version = $GLOBALS['meta'][$nom_meta_base_version])!=$version_cible)){
		if (version_compare($current_version,'0.0','<=')){
			include_spip('inc/config');
			/**
			 * Activer tous les champs sur les articles
			 */
			ecrire_meta("articles_surtitre", "oui");
			ecrire_meta("articles_soustitre", "oui");
			ecrire_meta("articles_descriptif", "oui");
			ecrire_meta("articles_chapeau", "oui");
			ecrire_meta("articles_ps", "oui");
			ecrire_meta("articles_urlref", "oui");
			ecrire_meta("articles_redac", "oui");
			ecrire_meta("rubriques_descriptif", "oui");
			
			/**
			 * Configuration du réducteur d'images
			 */
			$image_process_install = charger_fonction('image_process_install','inc');
			$image_process_install();
			
			/**
			 * Activation des documents sur les articles
			 */
			ecrire_meta("documents_objets", implode(',',array('spip_articles')));

			/**
			 * Ne pas activer les inscriptions de rédacteurs
			 */
			ecrire_meta("accepter_inscriptions","non");

			/**
			 * Activation des statistiques
			 * et de leurs captures
			 */
			ecrire_meta("activer_statistiques", "oui");
			ecrire_meta("activer_captures_referers", "oui");

			/**
			 * Désactivation de fontionnalités du privé:
			 * -* la messagerie
			 * -* les forums
			 */
			ecrire_meta("messagerie_agenda", "non");
			ecrire_meta("forum_prive_admin","non");
			ecrire_meta("forum_prive_objets","non");
			ecrire_meta("forum_prive","non");

			/**
			 * Activer la gestion des sites
			 * et la possibilité d'en ajouter pour tout le monde
			 */
			ecrire_meta("activer_sites","oui");
			ecrire_meta("proposer_sites","2");

			/**
			 * Activer le suivi des révisions
			 */
			ecrire_meta("articles_versions","oui");

			/**
			 * Activer les notifications des auteurs sous tous les types de forums
			 */
			ecrire_meta("prevenir_auteurs",",pos,pri,abo,");

			/**
			 * Activer les urls arbos par défaut
			 */
			ecrire_meta("type_urls","arbo");

			/**
			 * On active la barre typo dans les crayons
			 */
			$config_crayons = lire_config('crayons',array());
			$config_crayons['barretypo'] = 'on';
			ecrire_meta("crayons",serialize($config_crayons));
			
			/**
			 * Activer le multilinguisme
			 * - Les articles sont traduisibles
			 * - Ne proposer que les langues réellement possibles
			 * - Créer une configuration du plugin multilang dans le cas de son utilisation
			 */
			ecrire_meta("multi_articles", "oui");
			ecrire_meta("gerer_trad", "oui");
			ecrire_meta("langues_proposees","fr,en,es");
			$config_multilang = lire_config('multilang',array(
									'siteconfig' => 'on',
									'rubrique' => 'on',
									'auteur' => 'on',
									'document' => 'on',
									'diogene' => 'on',
									'collection' => 'on',
									'site' => 'on',
									'multilang_public' => 'on',
									'multilang_crayons' => 'on')
								);
			$config_multilang['multilang_public'] = 'on';
			$config_multilang['multilang_crayons'] = 'on';
			ecrire_meta("multilang",serialize($config_multilang));

			/**
			 * Insertion d'une configuration de SocialTags qui pourra servir
			 */
			$config_socialtags = lire_config('socialtags',array(
									'tags' => array('delicious','digg','facebook','google','myspace','twitter'),
									'jsselector' => '.infos_statistiques > div:last')
								);
			ecrire_meta("socialtags",serialize($config_socialtags));

			/**
			 * Insertion d'une configuration de Google +1 qui pourra servir
			 */
			$config_googleplus1 = lire_config('googleplus1',array(
												'googleplus1_taille' => 'small',
												'jsselector' => '.infos_statistiques > div:last')
			);
			ecrire_meta("googleplus1",serialize($config_googleplus1));
			
			/**
			 * Insertion d'une configuration de doc2img qui pourra servir
			 * Dans le cas de l'activation future du plugin
			 */
			$formats = lire_config('doc2img_imagick_extensions',false);
			if(!is_array($formats) OR (count($formats) == 0) && class_exists('Imagick')){
				include_spip('inc/metas');
				$imagick = new Imagick();
				$formats = $imagick->queryFormats();
				ecrire_meta('doc2img_imagick_extensions',serialize($formats));
			}
			$config_doc2img = lire_config('doc2img',array());
			if(is_array($formats) && (count($formats) > 1)){
				$extensions = array();
				foreach(array('PDF','TIFF','BMP','AI','SVG','PSD','EPS','PS') as $extension){
					if(in_array($extension,$formats)){
						$extensions[] = $extension;
					}
				}
				$extensions = array_map('strtolower',$extensions);
				$config_doc2img['format_document'] = implode(',',$extensions);
			}else{
				$config_doc2img['format_document'] = 'pdf,tiff,bmp,ai,svg,psd,eps,ps';
			}
			$config_doc2img['resolution'] = '150';
			$config_doc2img['conversion_auto'] = 'on';
			$config_doc2img['logo_auto'] = 'on';
			$config_doc2img['format_cible'] = 'png';
			ecrire_meta("doc2img",serialize($config_doc2img));

			/**
			 * Insertion d'une configuration pour le plugin notation
			 */
			$config_notation = lire_config('notation',array());
			$config_notation['ponderation'] = 30;
			$config_notation['acces'] = 'ide';
			ecrire_meta("notation",serialize($config_notation));

			/**
			 * Préconfigurer le plugin de notifications
			 */
			$config_notifications = lire_config('notifications',array());
			$config_notifications['prevenir_auteurs_articles'] = 'on';
			$config_notifications['prevenir_admins_restreints'] = 'on';
			$config_notifications['prevenir_auteurs'] = 'on';
			$config_notifications['thread_forum'] = 'on';
			$email_auteur_1 = sql_getfetsel('email','spip_auteurs','id_auteur=1');
			$config_notifications['moderateurs_forum'] = $email_auteur_1;
			$config_notifications['inscription'] = 'webmestres';
			ecrire_meta("notifications",serialize($config_notifications));
			
			/**
			 * Insertion d'une configuration pour le plugin palette
			 */
			$config_palette = array('palette_ecrire' => 'on','palette_public' => 'on');
			ecrire_meta("palette",serialize($config_palette));

			/**
			 * Si compresseur et version finale
			 */
			ecrire_meta("auto_compress_js", "oui");
			ecrire_meta("auto_compress_css", "oui");

			/**
			 * Préconfiguration du plugin chosen
			 */
			$config_chosen = array('active' => 'on','selecteur_commun' => 'select\[multiple\]');
			ecrire_meta('chosen',serialize($config_chosen));
			
			/**
			 * Création du menu
			 * Nécessite le plugin Menu
			 */
			if(defined('_DIR_PLUGIN_MENUS')){
				$menu_install = charger_fonction('menu_install','inc');
				$menu_install();
			}

			/**
			 * Création des templates pour spipmotion
			 * Nécessite le plugin SPIPmotion
			 */
			$spipmotion_install = charger_fonction('spipmotion_install','inc');
			$spipmotion_install();

			/**
			 * Création des cinq rubriques principales de mediaspip
			 * puis création de la configuration en conséquence
			 */
			include_spip('action/editer_rubrique');
			$rubs_mediaspip = lire_config('mediaspip');
			if(!isset($rubs_mediaspip['rubriques']['editos']) OR
				($rubs_mediaspip['rubriques']['editos'] != sql_getfetsel('id_rubrique','spip_rubriques','id_parent=0 AND id_rubrique='.$rubs_mediaspip['rubriques']['editos']))){
				$rubs_mediaspip['rubriques']['editos'] = insert_rubrique(0);
				revisions_rubriques($rubs_mediaspip['rubriques']['editos'], array('titre' =>_T('mediaspip_init:titre_rubrique_editos')));
			}
			if(!isset($rubs_mediaspip['rubriques']['mag']) OR
				($rubs_mediaspip['rubriques']['mag'] != sql_getfetsel('id_rubrique','spip_rubriques','id_parent=0 AND id_rubrique='.$rubs_mediaspip['rubriques']['mag']))){
				$rubs_mediaspip['rubriques']['mag'] = insert_rubrique(0);
				revisions_rubriques($rubs_mediaspip['rubriques']['mag'], array('titre' =>_T('mediaspip_init:titre_rubrique_mag')));
			}
			if(!isset($rubs_mediaspip['rubriques']['medias']) OR
				($rubs_mediaspip['rubriques']['medias'] != sql_getfetsel('id_rubrique','spip_rubriques','id_parent=0 AND id_rubrique='.$rubs_mediaspip['rubriques']['medias']))){
				$rubs_mediaspip['rubriques']['medias'] = sql_getfetsel('id_rubrique','spip_rubriques','titre='.sql_quote('Medias'));
				if(!intval($rubs_mediaspip['rubriques']['medias'])){
					$rubs_mediaspip['rubriques']['medias'] = insert_rubrique(0);
				}
				revisions_rubriques($rubs_mediaspip['rubriques']['medias'], array('titre' =>_T('mediaspip_init:titre_rubrique_medias')));
			}
			if(!isset($rubs_mediaspip['rubriques']['actus']) OR
				($rubs_mediaspip['rubriques']['actus'] != sql_getfetsel('id_rubrique','spip_rubriques','id_parent=0 AND id_rubrique='.$rubs_mediaspip['rubriques']['actus']))){
				$rubs_mediaspip['rubriques']['actus'] = insert_rubrique(0);
				revisions_rubriques($rubs_mediaspip['rubriques']['actus'], array('titre' =>_T('mediaspip_init:titre_rubrique_actus')));
			}
			if(!isset($rubs_mediaspip['rubriques']['sites']) OR
				($rubs_mediaspip['rubriques']['sites'] != sql_getfetsel('id_rubrique','spip_rubriques','id_parent=0 AND id_rubrique='.$rubs_mediaspip['rubriques']['sites']))){
				$rubs_mediaspip['rubriques']['sites'] = insert_rubrique(0);
				revisions_rubriques($rubs_mediaspip['rubriques']['sites'], array('titre' =>_T('mediaspip_init:titre_rubrique_sites')));
			}
			$rubs_mediaspip['squelettes']['telecharger_types'] = array('copies','original');
			ecrire_meta('mediaspip',serialize($rubs_mediaspip));

			/**
			 * Création des templates pour spipmotion
			 * Nécessite le plugin SPIPmotion
			 */
			if(defined('_DIR_PLUGIN_DIOGENE')){
				$diogene_install = charger_fonction('diogene_install','inc');
				$diogene_install($rubs_mediaspip['rubriques']);
			}

			/**
			 * Modification de la config d'emballe medias
			 */
			$mutu_install = charger_fonction('mutu_install','inc');
			$mutu_install();

			/**
			 * Modification de la config d'emballe medias
			 */
			$emballe_media_install = charger_fonction('emballe_medias_install','inc');
			$emballe_media_install();
			
			/**
			 * On installe le sélecteur pour sparkstats
			 * Même s'il n'est pas installé, au moins elle sera bonne
			 */
			ecrire_meta('sparkstats',serialize(array('sparkstats_cible' => '.info-visites:eq(0)')));

			/**
			 * On active les tags de spip.icio.us pour tout le monde par défaut
			 */
			$config_spipicious = lire_config('spipicious',array());
			$config_spipicious['people'] = array('0minirezo','1comite','6forum');
			ecrire_meta('spipicious',serialize($config_spipicious),'oui');
			
			/**
			 * Préconfigurer Gis 4
			 */
			$config_gis = lire_config('gis',array());
			if(!$config_gis['lat'] OR !$config_gis['lon']){
				$config_gis['lat'] = '49';
				$config_gis['lon'] = '15';
			}
			$config_gis['geocoder'] = 'on';
			$config_gis['adresse'] = 'on';
			$config_gis['zoom'] = '1';
			$config_gis['gis_objets'] = array('spip_articles','spip_rubriques','spip_auteurs');
			$config_gis['layer_defaut'] = 'openstreetmap_blackandwhite';
			$config_gis['layers'] = array(
										'openstreetmap_mapnik',
										'openstreetmap_blackandwhite',
										'mapbox_streets',
										'mapbox_light',
										'mapbox_lacquer',
										'stamen_watercolor');
			ecrire_meta('gis',serialize($config_gis),'oui');
			
			include_spip('inc/invalideur');
			suivre_invalideur('meta');
			
			ecrire_meta($nom_meta_base_version,$current_version=$version_cible,'non');
		}if (version_compare($current_version,'0.1.1','<')){

			/**
			 * Insertion d'une configuration pour le plugin palette
			 */
			$config_palette = array('palette_ecrire' => 'on','palette_public' => 'on');
			ecrire_meta("palette",serialize($config_palette));
			ecrire_meta($nom_meta_base_version,$current_version='0.1.1','non');
		}if (version_compare($current_version,'0.1.2','<')){
			/**
			 * On ajoute la gestion des forums dans les diogènes d'articles
			 */
			$diogenes_articles = sql_select('*','spip_diogenes','objet IN ('.sql_quote('article').','.sql_quote('emballe_media').')');
			include_spip('action/editer_diogene');
			while($diogene = sql_fetch($diogenes_articles)){
				$champs_ajoutes = @unserialize($diogene['champs_ajoutes']);
				$champs_ajoutes[] = 'forum';
				$diogene['champs_ajoutes'] = $champs_ajoutes;
				diogene_modifier($diogene['id_diogene'], $diogene);
			}
			ecrire_meta($nom_meta_base_version,$current_version='0.1.2','non');
		}if (version_compare($current_version,'0.1.3','<')){
			/**
			 * On ajoute la gestion des forums dans les diogènes d'articles
			 */
			$diogenes = sql_select('*','spip_diogenes');
			include_spip('action/editer_diogene');
			while($diogene = sql_fetch($diogenes)){
				if($diogene['type'] != 'media'){
					$options_complements = is_array(@unserialize($diogene['options_complements'])) ? unserialize($diogene['options_complements']) : array();
					$options_complements['polyhier_desactiver'] = 'on';
					$diogene['options_complements'] = $options_complements;
					diogene_modifier($diogene['id_diogene'], $diogene);
				}
			}
			ecrire_meta($nom_meta_base_version,$current_version='0.1.3','non');
		}if (version_compare($current_version,'0.1.4','<')){
			/**
			 * On remplace les éléments de menus autrefois emballe_medias par publier (dans diogene)
			 */
			sql_updateq('spip_menus_entrees',array('type_entree'=>'publier'),'type_entree='.sql_quote('emballe_medias'));
			ecrire_meta($nom_meta_base_version,$current_version='0.1.4','non');
		}if(version_compare($current_version,'0.1.5','<')){
			/**
			 * On ajoute un élément dans le menu principal de type lien vers la page d'accueil
			 * (utile pour le blog)
			 */
			$barre_nav = sql_getfetsel('id_menu','spip_menus','identifiant="barrenav"');
			$home_entree = sql_getfetsel('id_menus_entree','spip_menus_entrees','type_entree="accueil" AND id_menu='.intval($barre_nav));
			if(!intval($home_entree)){
				include_spip('action/editer_menu');
				include_spip('action/editer_menus_entree');
				$entree = insert_menus_entree($barre_nav);
				$infos_entree = array(
					'rang' => 5,
					'type_entree' => 'accueil'
				);
				menus_entree_set($entree, $infos_entree);
			}
			ecrire_meta($nom_meta_base_version,$current_version='0.1.5','non');
		}if(version_compare($current_version,'0.1.6','<')){
			/**
			 * On ajoute multilang dans les crayons
			 */
			$config_multilang = lire_config('multilang',array(
									'siteconfig' => 'on',
									'article' => '',
									'breve' => '',
									'rubrique' => 'on',
									'auteur' => 'on',
									'document' => 'on',
									'motcle' => '',
									'site' => 'on',
									'multilang_public' => 'on',
									'multilang_crayons' => 'on')
								);
			$config_multilang['multilang_crayons'] = 'on';
			ecrire_meta("multilang",serialize($config_multilang));
			ecrire_meta($nom_meta_base_version,$current_version='0.1.6','non');
		}if(version_compare($current_version,'0.1.7','<')){
			/**
			 * On active la barre typo dans les crayons
			 */
			$config_crayons = lire_config('crayons',array());
			$config_crayons['barretypo'] = 'on';
			ecrire_meta("crayons",serialize($config_crayons));
			
			/**
			 * On vérifie qu'on a toutes les entrées de menus
			 */
			$menu_install = charger_fonction('menu_install','inc');
			$menu_install();
			
			ecrire_meta($nom_meta_base_version,$current_version='0.1.7','non');
		}if(version_compare($current_version,'0.1.8','<')){
			/**
			 * Insertion d'une configuration de SocialTags qui pourra servir
			 */
			$config_socialtags = lire_config('socialtags',array(
												'tags' => array('delicious','digg','facebook','google','myspace','twitter'),
												'jsselector' => '.infos_statistiques > div:last')
			);
			ecrire_meta("socialtags",serialize($config_socialtags));
			
			/**
			 * Insertion d'une configuration de doc2img qui pourra servir
			 * Dans le cas de l'activation future du plugin
			 */
			$formats = lire_config('doc2img_imagick_extensions',false);
			if(!is_array($formats) OR (count($formats) == 0)){
				include_spip('inc/metas');
				$imagick = new Imagick();
				$formats = $imagick->queryFormats();
				ecrire_meta('doc2img_imagick_extensions',serialize($formats));
			}
			$config_doc2img = lire_config('doc2img',array());
			if(is_array($formats) && (count($formats) > 1)){
				$extensions = array();
				foreach(array('PDF','TIFF','BMP','AI','SVG','PSD','EPS','PS') as $extension){
					if(in_array($extension,$formats)){
						$extensions[] = $extension;
					}
				}
				$extensions = array_map('strtolower',$extensions);
				$config_doc2img['format_document'] = implode(',',$extensions);
			}else{
				$config_doc2img['format_document'] = 'pdf,tiff,bmp,ai,svg,psd,eps,ps';
			}
			$config_doc2img['resolution'] = '150';
			$config_doc2img['format_cible'] = 'png';
			$config_doc2img['conversion_auto'] = 'on';
			$config_doc2img['logo_auto'] = 'on';
			ecrire_meta("doc2img",serialize($config_doc2img));
			
			/**
			 * On installe le sélecteur pour sparkstats
			 * Même s'il n'est pas installé, au moins elle sera bonne
			 */
			ecrire_meta('sparkstats',serialize(array('sparkstats_cible' => '.info-visites:eq(0)')));
			
			/**
			 * Insertion d'une configuration de Google +1 qui pourra servir
			 */
			$config_googleplus1 = lire_config('googleplus1',array(
															'googleplus1_taille' => 'small',
															'jsselector' => '.infos_statistiques > div:last')
			);
			ecrire_meta("googleplus1",serialize($config_googleplus1));
			
			include_spip('inc/invalideur');
			suivre_invalideur('meta');
			ecrire_meta($nom_meta_base_version,$current_version='0.1.8','non');
		}if(version_compare($current_version,'0.1.9','<')){
			/**
			 * Préconfigurer le plugin de notifications
			 */
			$config_notifications = lire_config('notifications',array());
			$config_notifications['prevenir_auteurs_articles'] = 'on';
			$config_notifications['prevenir_admins_restreints'] = 'on';
			$config_notifications['prevenir_auteurs'] = 'on';
			$config_notifications['thread_forum'] = 'on';
			$email_auteur_1 = sql_getfetsel('email','spip_auteurs','id_auteur=1');
			$config_notifications['moderateurs_forum'] = $email_auteur_1;
			$config_notifications['inscription'] = 'webmestres';
			ecrire_meta("notifications",serialize($config_notifications));
			
			include_spip('inc/invalideur');
			suivre_invalideur('meta');
			ecrire_meta($nom_meta_base_version,$current_version='0.1.9','non');
		}if(version_compare($current_version,'0.2.0','<')){
			/**
			 * Préconfigurer Gis 4
			 */
			$config_gis = lire_config('gis',array());
			if(!$config_gis['lat'] OR !$config_gis['lon']){
				$config_gis['lat'] = '49';
				$config_gis['lon'] = '15';
			}
			$config_gis['geocoder'] = 'on';
			$config_gis['adresse'] = 'on';
			$config_gis['zoom'] = '1';
			$config_gis['gis_objets'] = array('spip_articles','spip_rubriques','spip_auteurs');
			$config_gis['layer_defaut'] = 'openstreetmap_blackandwhite';
			$config_gis['layers'] = array(
										'openstreetmap_mapnik',
										'openstreetmap_blackandwhite',
										'mapbox_streets',
										'mapbox_light',
										'mapbox_lacquer',
										'stamen_watercolor');
			ecrire_meta('gis',serialize($config_gis),'oui');
			
			include_spip('inc/invalideur');
			suivre_invalideur('meta');
			ecrire_meta($nom_meta_base_version,$current_version='0.2.0','non');
		}
		if(version_compare($current_version,'0.2.1','<')){
			/**
			 * Insertion d'une configuration de doc2img qui pourra servir
			 * Dans le cas de l'activation future du plugin
			 */
			$formats = lire_config('doc2img_imagick_extensions',false);
			if(!is_array($formats) OR (count($formats) == 0)){
				include_spip('inc/metas');
				$imagick = new Imagick();
				$formats = $imagick->queryFormats();
				ecrire_meta('doc2img_imagick_extensions',serialize($formats));
			}
			$config_doc2img = lire_config('doc2img',array());
			if(is_array($formats) && (count($formats) > 1)){
				$extensions = array();
				foreach(array('PDF','TIFF','BMP','AI','SVG','PSD','EPS','PS') as $extension){
					if(in_array($extension,$formats)){
						$extensions[] = $extension;
					}
				}
				$extensions = array_map('strtolower',$extensions);
				$config_doc2img['format_document'] = implode(',',$extensions);
			}else{
				$config_doc2img['format_document'] = 'pdf,tiff,bmp,ai,svg,psd,eps,ps';
			}
			$config_doc2img['resolution'] = '150';
			$config_doc2img['format_cible'] = 'png';
			$config_doc2img['conversion_auto'] = 'on';
			$config_doc2img['logo_auto'] = 'on';
			ecrire_meta("doc2img",serialize($config_doc2img));
			ecrire_meta($nom_meta_base_version,$current_version='0.2.1','non');
		}
		if(version_compare($current_version,'0.2.2','<')){
			/**
			 * On reconfigure Gis v4
			 */
			$config_gis = lire_config('gis',array());
			if(!$config_gis['lat'] OR !$config_gis['lon']){
				$config_gis['lat'] = '49';
				$config_gis['lon'] = '15';
			}
			$config_gis['geocoder'] = 'on';
			$config_gis['adresse'] = 'on';
			$config_gis['zoom'] = '1';
			$config_gis['gis_objets'] = array('spip_articles','spip_rubriques','spip_auteurs');
			$config_gis['layer_defaut'] = 'openstreetmap_blackandwhite';
			$config_gis['layers'] = array(
										'openstreetmap_mapnik',
										'openstreetmap_blackandwhite',
										'mapbox_streets',
										'mapbox_light',
										'mapbox_lacquer',
										'stamen_watercolor');
			ecrire_meta('gis',serialize($config_gis),'oui');
			
			ecrire_meta($nom_meta_base_version,$current_version='0.2.2','non');
		}
		if(version_compare($current_version,'0.3.0','<')){
			/**
			 * On ajoute diogène et collection dans multilang
			 */
			$config_multilang = lire_config('multilang',array(
									'siteconfig' => 'on',
									'rubrique' => 'on',
									'auteur' => 'on',
									'document' => 'on',
									'diogene' => 'on',
									'collection' => 'on',
									'site' => 'on',
									'multilang_public' => 'on',
									'multilang_crayons' => 'on')
								);
			$config_multilang['diogene'] = 'on';
			$config_multilang['collection'] = 'on';
			ecrire_meta("multilang",serialize($config_multilang));
			
			/**
			 * Activation des documents sur les articles
			 */
			ecrire_meta("documents_objets", implode(',',array('spip_articles')));
			
			ecrire_meta($nom_meta_base_version,$current_version='0.3.0','non');
		}
		/**
		 * On ajoute la conf de base de téléchargement des documents de MediaSPIP
		 */
		if(version_compare($current_version,'0.3.1','<')){
			$conf_mediaspip = lire_config('mediaspip');
			$conf_mediaspip['squelettes']['telecharger_types'] = array('copies','original');
			ecrire_meta('mediaspip',serialize($conf_mediaspip));
			ecrire_meta($nom_meta_base_version,$current_version='0.3.1','non');
		}
		if(version_compare($current_version,'0.3.2','<')){
			/**
			 * Préconfiguration du plugin chosen
			 */
			$config_chosen = array('active' => 'on','selecteur_commun' => 'select[multiple]');
			ecrire_meta('chosen',serialize($config_chosen));
			ecrire_meta($nom_meta_base_version,$current_version='0.3.2','non');
		}
	}
}

/**
 * Désinstallation du plugin
 */
function mediaspip_init_vider_tables($nom_meta_version_base){
	// On efface la version enregistrée
	effacer_meta($nom_meta_version_base);
}
?>
