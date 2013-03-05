<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function lister_configs_cfg($path = 'configurer', $tous = false) {
	$crit_nom = $tous ? 'cfg_.' : '^[^_]';
	$configs =
		array_unique(
		array_values(
		array_flip(
		 find_all_in_path($path.'/', $crit_nom.'+\.html$'))));
	
	spip_log($path,'test');
	spip_log(find_all_in_path($path.'/', $crit_nom.'+\.html$'),'test');
	/**
	 * On enlève ceux que l'on a en dur dans la conf
	 */
	$suppressions = array(
		'cfg_mediaspip_home.html',
		'cfg_mediaspip_plugins.html',
		'cfg_mediaspip_secteurs.html',
		'cfg_mediaspip_squelettes.html',
		'cfg_mediaspip_medias.html',
		'cfg_jqueryui.html',
		'cfg_comments.html',
		'cfg_spipmotion.html',
		'cfg_doc2img.html',
		'cfg_getid3.html',
		'cfg_notation.html',
		'cfg_socialtags.html',
		'cfg_contact.html',
		'cfg_flattr.html',
		'cfg_googleplus1.html',
		'cfg_emballe_medias_fichiers.html',
		'cfg_emballe_medias_styles.html',
		'cfg_emballe_medias_types.html',
		'cfg_piwik.html',
		'cfg_bigbrother.html',
		'cfg_googleanalytics.html',
		'cfg_sparkstats.html',
		'cfg_gravatar.html',
		'cfg_microblog.html',
		'cfg_inscription3.html',
		'cfg_multilang.html',
		'cfg_saveauto.html',
		'cfg_mediabox.html',
		'cfg_mediaspip_player.html',
		'cfg_notifications.html',
		'cfg_legendes.html',
		'cfg_opensearch.html',
		'cfg_gestionmutu_skel.html',
		'cfg_tickets_general.html',
		'cfg_tickets_autorisations.html',
		'cfg_documentation.html',
		'cfg_podcast.html',
		'cfg_crayons.html',
		'cfg_facteur.html',
		'cfg_palette.html',
		'cfg_mes_fichiers.html',
		'cfg_licence.html',
		'cfg_spipicious.html',
		'cfg_compositions.html',
		'cfg_gis.html',
		'cfg_gestion_mutu.html',
		'cfg_theme.html',
		'cfg_memoization.html'
	);
	
	$configs = array_diff($configs,$suppressions);
	
	$configs = array_flip($configs);
	
	/**
	 * On enlève ensuite les plugins qui ne sont pas activés
	 */
	$verifs_manuelle = array(
		//array('cfg_facteur.html',defined('_DIR_PLUGIN_FACTEUR')),
	);
	
	foreach($verifs_manuelle as $verif_manuelle){
		if(!$verif_manuelle[1])
			unset($configs[$verif_manuelle[0]]);
	}
	
	$configs = array_flip($configs);
	
	$res = array();
	foreach ($configs as $i=>$o) {
		$res[$o] = $path;
	}
	return $res;
}

function calculer_cfg_trad($quoi, $nom, $onglet = '') {
	// on teste si une traduction existe
	static $traduire=false ;
 	if (!$traduire) {
		$traduire = charger_fonction('traduire', 'inc');
		include_spip('inc/lang');
	}

	$x = "$nom:$quoi"."_$nom";
	if ($onglet) { $x .= "_$onglet"; }

	$text = $traduire($x,$GLOBALS['spip_lang']);

	return ($text) ? _T($x) : '';
}
function ms_config_afficher_plugins(){
	$encours = _request('cfg');
	$configs = array();
	// restant de compat... a deplacer un jour comme il faut dans le plug cfg_compat.
	if (defined('_DIR_PLUGIN_CFG_COMPAT')) {
		$configs = array_merge($configs, lister_configs_cfg('fonds', true));
	}
	$configs = array_merge($configs, lister_configs_cfg());
	ksort($configs);
	spip_log(count($configs),'test');
	spip_log($configs,'test');
	if (count($configs) > 0) {
		$rendu = '<ul class="menu-liste liste-item autres_plugins">';
		include_spip('inc/cfg_formulaire');
		// pour chacun, on recupere les information les concernant
		// et on cree un bloc joli pour les presenter
		foreach ($configs as $o=>$rep) {
			$nom = $fonds = basename($o, '.html');
			if (defined('_DIR_PLUGIN_CFG_COMPAT')
			and (0 === strpos($fonds, 'cfg_'))) {
				$nom = substr($fonds, 4);
			}

			$tmp = new cfg_formulaire($rep.'/'.$fonds);
			if ($tmp->autoriser()){
				// restant de compat... a deplacer un jour comme il faut dans le plug cfg_compat.
				if (defined('_DIR_PLUGIN_CFG_COMPAT')) {
					$ong = $tmp->param["onglet"];
					if ($ong != 'oui' and $ong != $nom) {
						continue;
					}
				}
				$titre = $tmp->param["titre"] ? $tmp->param["titre"] : calculer_cfg_trad('titre',$nom);
				$descriptif = $tmp->param["descriptif"] ? $tmp->param["descriptif"] : calculer_cfg_trad('descriptif',$nom);
				if ($tmp->param["logo"]) {
					$logo = $tmp->param["logo"];
				} elseif ($tmp->param["icone"]) {
					$logo = $tmp->param["icone"];
				} else {
					$logo = '';
				}
				$rendu .= recuperer_fond('inclure/ms_config_presentation_config', array(
					'titre' => $titre,
					'descriptif' => $descriptif,
					'logo' => $logo,
					'lien' => generer_url_public('ms_config','cfg='.$nom),
					'cfg' => $nom,
					'en_cours' => $encours
				));
			}
		}
		$rendu .= "</ul>";
	}
	return $rendu;
}

?>