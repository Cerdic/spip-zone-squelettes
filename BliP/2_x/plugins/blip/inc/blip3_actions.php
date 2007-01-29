<?php
	if (!defined('_DIR_PLUGIN_BLIP')){ // definie automatiquement en 1.9.2
		$p=explode(basename(_DIR_PLUGINS)."/",str_replace('\\','/',realpath(dirname(__FILE__).'/..')));
		define('_DIR_PLUGIN_BLIP',(_DIR_PLUGINS.end($p)));
	}
	
//
// Toutes les fonctions de BliP3 ont étés regroupées ici. Les fonctions de BliP 2 seront transférées ultérieurement.	
//

// FONCTIONS LIEES AUX BOITES D'OPTIONS DE DROITES DANS LE PLUGIN DE CONFIGURATION	
	
	// Fonction qui crée les boîtes de droites permettant d'installer et régler la structure, le thème, les couleurs du site etc.
	function BliP_creer_boite_option($a) {
	debut_boite_info();
		echo bouton_block_invisible('blip_'.$a)._T('blipplugin:'.$a.'_du_site');
		
		echo debut_block_invisible('blip_'.$a);
		echo "<br/>"._T('blipplugin:aide_'.$a);
		echo "<br/><br/>".bouton_block_invisible('blip_'.$a.'_installer')._T('blipplugin:option_installer');
		echo debut_block_invisible('blip_'.$a.'_installer');
		echo _T('blipplugin:aide_'.$a.'_installer');
		BliP_creer_menu_déroulant($a);
		echo "<br/>";
		echo fin_block()."<br/>";
		
		echo "<br/>".bouton_block_invisible('blip_'.$a.'_personnaliser')._T('blipplugin:option_personnaliser');
		echo debut_block_invisible('blip_'.$a.'_personnaliser');
		echo _T('blipplugin:aide_'.$a.'_personnaliser');
		echo "<br/>";
		echo "<br/>";		
		echo fin_block();
		
		echo fin_block();
	fin_boite_info();
	echo "<br/>";
	}
	
	// Fonction qui crée le menu déroulant
	function BliP_creer_menu_déroulant($a) {
	echo generer_url_post_ecrire('blip3');
	echo "<input type='hidden' name='changer_config' value='oui'>";
	$blip_prefixe = entites_html($GLOBALS['meta']["blip_prefixe"]);
	$blipconfig_themes = BliP_generer_liste_fichiers('/^'.$a.'_.+\.php$/' ,_T('blipconfig:blip_theme_neutre'), '/^'.$a.'_(.+)\.php$/');
	echo BliP_generer_option_select('blip_prefixe', $blipconfig_themes, $blip_prefixe, "", "forml");
	echo "<div style='text-align:right;'><input type='submit' name='Valider' value='"._T('bouton_enregistrer')."' CLASS='fondo'></div>";
	}
	

	
/***************************************************/
/* Génération automatique d'éléments de formulaire */
/***************************************************/	
	function BliP_generer_option_select($nom, $valeurs, $actif="", $onchange="", $class="") {
		$s  = "\n".'<select name="'.$nom.'" id="'.$nom.'" onchange="'.$onchange.'" class="'.$class.'">'."\n";
		foreach ($valeurs as $valeur => $description) {
			$s .= '<option value="'.$valeur.'"';
			if ($actif == $valeur) {
				$s .= ' selected="selected"';
			}
			$s .= '>'.$description."</option>\n";
		}
		$s .= "</select>\n";
		return $s;
	}	
	
	// $pattern : expression régulière pour choisir les fichiers
	// $defaut  : valeur à placer en debut de tableau
	// $dossier : dossier relatif à celui du plugin
	// $filtre  : expression régulière à retirer des indexes
	// retourne un tableau associatif trié array[nomfichier_sans_suffixe]=nomfichier_propre
	function BliP_generer_liste_fichiers($pattern, $defaut='', $filtre='/(.+)\.html?$/', $dossier='.') {
		$liste = array();
		if (is_dir(_DIR_PLUGIN_BLIP."/".$dossier)) {
			if ($dh = opendir(_DIR_PLUGIN_BLIP."/".$dossier)) {
				while (($file = readdir($dh)) !== false) {
					if (!is_dir($file)) {
						if (preg_match($pattern, $file)) {
							$liste[preg_replace($filtre, '\1', $file)] = BliP_nom_module_lisible($file);
						}
					}
				}
				closedir($dh);
			}
		}
		ksort($liste);
		if ($defaut) array_unshift($liste, $defaut);
		return ($liste);	
	}
	
	
	
	// Fonction de nettoyage des '_' dans les noms de fichier.
	function BliP_nom_module_lisible($nomfichier) {
	return ucfirst(preg_replace('/_/', ' ', preg_replace('/(^mod_|^theme_|^structure_|^couleur_)?(.*)(\.[^\.]+)/', '$2', $nomfichier)));
	}
	

?>