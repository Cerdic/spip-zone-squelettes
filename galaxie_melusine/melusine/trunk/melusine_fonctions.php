<?php

/**
 * Plugin Mélusine
 * (c) 2012 Jean-Marc Labat
 * Licence GNU/GPL
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

// Les mêmes caches que pour le noizetier:

include_spip('inc/filtres');
$f = chercher_filtre('info_plugin');
$noiz_actif = $f("noizetier","est_actif");

// Si pas noizetier, on crée ls constantes
if (!$noiz_actif) {
	define('_CACHE_AJAX_NOISETTES', 'noisettes_ajax.php');
	define('_CACHE_CONTEXTE_NOISETTES', 'noisettes_contextes.php');
	define('_CACHE_DESCRIPTIONS_NOISETTES', 'noisettes_descriptions.php');
	define('_CACHE_INCLUSIONS_NOISETTES', 'noisettes_inclusions.php');
}


/*
 * Un fichier de fonctions permet de definir des elements
 * systematiquement charges lors du calcul des squelettes.
 *
 * Il peut par exemple définir des filtres, critères, balises, ?
 * 
 */






// ===================================================
// Filtre : hauteur_majoree
// ===================================================
// Auteur: S. Bellégo
// Fonction : Retourne la hauteur d'une image + 20. Sert pour
//                   afficher correctemnt le logo d'une rubrique
// ===================================================
//



function hauteur_majoree($img) {
    if (!$img) return;
    include_spip('logos.php');
    list ($h,$l) = taille_image($img);
    $h+=20;
    return $h;
}
// FIN du Filtre : hauteur_majoree

// ===================================================
// Filtre : typo_couleur
// ===================================================
// Auteur : Smellup, inspiré du filtre original de A. Piérard
// Fonction : permettant de modifier la couleur du texte ou 
//                   de l'introduction d'un article
// Utilisation :                  
//  - pour le rédacteur : [rouge]xxxxxx[/rouge]
//  - pour le webmaster : [(#TEXTE|couleur)]
// ===================================================
//
function typo_couleur($texte) {

    // Variables personnalisables par l'utilisateur
    $typo_couleur_active = 'oui';
    // --> Activation ou désactivation de la fonction
    // --> Nuances personnalisables par l'utilisateur
    $couleur = array(
        'noir' => "#000000",
        'blanc' => "#FFFFFF",
        'rouge' => "#FF0000",
        'vert' => "#00FF00",
        'bleu' => "#0000FF",
        'jaune' => "#FFFF00",
        'gris' => "#808080",
        'marron' => "#800000",
        'violet' => "#800080",
        'rose' => "#FFC0CB",
        'orange' => "#FFA500"
    );

    $recherche = array(
        'noir' => "/(\[noir\])(.*?)(\[\/noir\])/",
        'blanc' => "/(\[blanc\])(.*?)(\[\/blanc\])/",
        'rouge' => "/(\[rouge\])(.*?)(\[\/rouge\])/",
        'vert' => "/(\[vert\])(.*?)(\[\/vert\])/",
        'bleu' => "/(\[bleu\])(.*?)(\[\/bleu\])/",
        'jaune' => "/(\[jaune\])(.*?)(\[\/jaune\])/",
        'gris' => "/(\[gris\])(.*?)(\[\/gris\])/",
        'marron' => "/(\[marron\])(.*?)(\[\/marron\])/",
        'violet' => "/(\[violet\])(.*?)(\[\/violet\])/",
        'rose' => "/(\[rose\])(.*?)(\[\/rose\])/",
        'orange' => "/(\[orange\])(.*?)(\[\/orange\])/"
    );

    $remplace = array(
        'noir' => "<span style=\"color:".$couleur['noir'].";\">\\2</span>",
        'blanc' => "<span style=\"color:".$couleur['blanc'].";\">\\2</span>",
        'rouge' => "<span style=\"color:".$couleur['rouge'].";\">\\2</span>",
        'vert' => "<span style=\"color:".$couleur['vert'].";\">\\2</span>",
        'bleu' => "<span style=\"color:".$couleur['bleu'].";\">\\2</span>",
        'jaune' => "<span style=\"color:".$couleur['jaune'].";\">\\2</span>",
        'gris' => "<span style=\"color:".$couleur['gris'].";\">\\2</span>",
        'marron' => "<span style=\"color:".$couleur['marron'].";\">\\2</span>",
        'violet' => "<span style=\"color:".$couleur['violet'].";\">\\2</span>",
        'rose' => "<span style=\"color:".$couleur['rose'].";\">\\2</span>",
        'orange' => "<span style=\"color:".$couleur['orange'].";\">\\2</span>"
    );

    $supprime = "\\2";


    if ($typo_couleur_active == 'non') {
        $texte = preg_replace($recherche, $supprime, $texte);
    }
    else {
        $texte = preg_replace($recherche, $remplace, $texte);
    }
    return $texte;
}

// ===================================================
// Balise : #INTRODUCTION (surcharge)
// ===================================================
// Auteur: Smellup
// Fonction : Surcharge de la fonction standard de calcul de la 
//                   balise #INTRODUCTION. Permet d'en definir la
//                   taille en nombre de caractère
// ===================================================
//
function introduction ($type, $texte, $chapo='', $descriptif='') {

    // Personnalisable par l'utilisateur
    $taille_intro_article = 600;
    $taille_intro_breve = 300;
    $taille_intro_message = 600;
    $taille_intro_rubrique = 600;
    
    switch ($type) {
        case 'articles':
            if ($descriptif)
                return propre($descriptif);
            else if (substr($chapo, 0, 1) == '=')   // article virtuel
                return '';
            else
                return PtoBR(propre(supprimer_tags(couper_intro($chapo."\n\n\n".$texte, $taille_intro_article))));
            break;
        case 'breves':
            return PtoBR(propre(supprimer_tags(couper_intro($texte, $taille_intro_breve))));
            break;
        case 'forums':
            return PtoBR(propre(supprimer_tags(couper_intro($texte, $taille_intro_message))));
            break;
        case 'rubriques':
            if ($descriptif)
                return propre($descriptif);
            else
                return PtoBR(propre(supprimer_tags(couper_intro($texte, $taille_intro_rubrique))));
            break;
    }
}


/**
 * Obtenir la liste des noisettes disponibles correspondant au type
 * passé en paramètre
 *
 * @param text $type est le type de noisette (articles, rurbiques, mobil, etc.)
 * le type correspond aussi au sous répertoire de module dans
 * lequel sont rangées les noisettes
 * @return 
 *
 * TODO changer le nom du répertoire en noisettes (et réperctuer les changements)
**/
function melusine_liste_noisettes_dispo($type=""){
	$type_casier = $type ? $type : "squelettes";
	effacer_config("melusine_".$type_casier."/skel");
	$sous_rep = $type ? $type."/" : "";
	$chemin="modules/".$sous_rep;

	// Ce qui suit est très inspiré des fonctions du noizetier
	// par Joseph, Marcimat et Kent1 (GPL3)
	$match = "[^-]*[.]html$";
	$liste = find_all_in_path($chemin, $match);
	$i=1;
	foreach($liste as $squelette=>$chemin) {
		$noisette = preg_replace(',[.]html$,i', '', $squelette);
		$cheminskels="melusine_".$type_casier."/skel/skels".$i;
        	ecrire_config($cheminskels,$noisette);
		$i++;
		
	}
}


/**
 * Vérifier qu'une colonne du squelette n'est pas vide
 *
 * @param text $colonne issu du caser de config
 * 
 * @return bool true si c'est vide 
 *
**/

function melusine_colonne_pasvide($colonne){
	foreach($colonne as $value){
		if($value!=''and $value!='aucun'){return true;};
	}
	return false;
}

/**
 * Sert à rassembler (ou à ordonner) les noisettes dans le casier
 * Est utilisé dans les formulaires de config du squelette melusine
 *
 * @param num $i ???
 * @param text $objet est le type d'objet concerné
 * @param text $zone est le casier concerné
 * (et donc le suffixe de la table meta où seront stockées les données)
 * @param text $casier le chemin complet du casier dans le meta s'il est fourni
 * 	(supplante $objet et $zone)
 * 
 *
**/

function melusine_rassembler($i,$objet="squelettes",$zone="effectifs",$casier=""){
	$var=$i;
	if ($casier) {
		$base_chemin = $casier;
	} else {
		// TODO à retirer quand les zones ne seront plus
		// du tout utilisées (penser aussi à modifier l'arité)
		$base_chemin = 'melusine_'.$objet.'/'.$zone.'/';
	}
	$chemin=$base_chemin.$var;
	$j=$i+1;
	$varplus=$j;
	$chemin_bas=$base_chemin.$varplus;
	$pos_bas=lire_config($chemin_bas);
	ecrire_config($chemin,$pos_bas);
	ecrire_config($chemin_bas,'aucun');
	$i++;
	if($i<12){melusine_rassembler($i,$objet,$zone,$casier);};
}
/**
 * Retourne la liste des fichiers qui doivent être déplacés
 * à partir de la valeur des metas
 *
 * @param text $casier casier dans les meta qui contient les arrays
 * 
 * @return text la liste HTML des fichiers à déplacer.
 *
**/

function melusine_message_noisettes_a_deplacer($casier="melusine_perso_a_deplacer"){
	$return = "";

	// TODO à déplacer dans le fichier lang quand il y en aura un
	$message_info = "<p>Lors de son installation, M&eacute;lusine a r&eacute;cup&eacute;r&eacute; des fichiers de l'ancien plugin DATICE que vous aviez personnalis&eacute;s.</p>

<p>Pour que ces fichiers ne soient pas &eacute;cras&eacute;s lors de la prochaine mise &agrave; jour de M&eacute;lusine, il est n&eacute;cessaire que vous effectuiez par FTP les op&eacute;rations de copie ci-dessous&nbsp:</p>";

	// On détemine le dossier squelette
	$dossier_squelettes = $GLOBALS['dossier_squelettes'];
	if (!$dossier_squelettes) $dossier_squelettes = "squelettes";
	// On récupère les meta
	include_spip('inc/config');
	$tableaux = lire_config($casier);
	// Pour chaque URL
	if ($tableaux) {
		foreach($tableaux as $key1 => $sous_tableau) {
			foreach($sous_tableau as $value) {

				// Chemins pour le privé
				$chemin_fichier = substr($value,3);
				$chemin_copie = str_replace(_DIR_PLUGIN_MELUSINE,$dossier_squelettes."/",$value);
				$chemin_socialtags = str_replace(_DIR_PLUGIN_MELUSINE,_DIR_PLUGIN_MELUSINE_SOCIALTAGS,$value);

				$chemin_test_fichier = $value;
				$chemin_test_socialtags = $chemin_socialtags;
				$chemin_test_copie = "../".$chemin_copie;


				// Chemins pour le public
				if (!test_espace_prive()) {
					$chemin_test_fichier = $chemin_fichier;
					$chemin_copie = substr($chemin_copie,3);
					$chemin_test_copie = $chemin_copie;
					$chemin_test_socialtags = substr($chemin_socialtags,3);

				}

				// On vérifie que le fichier existe encore dans Mélusine
				// qu'il n'est pas vide
				// et qu'il n'existe pas encore dans le répertoire squelettes
				// et qu'il n'est pas non plus dans les socialtags...

				if (file_exists($chemin_test_fichier) AND filesize($chemin_test_fichier)>0 AND !file_exists($chemin_test_copie) AND !file_exists($chemin_test_socialtags)) {
					$return .= wrap("<strong>Copier</strong> ".wrap($chemin_fichier,"<code>")." dans ".wrap($chemin_copie,"<code>"),"<li class='liste-item'>");
				}
			}
		}
		
	}
	if ($return) $return = $message_info.wrap($return,"<ul class='liste'>");
	return $return;

}

// Reprises de plusieurs fonctions du noizetier
// TODO il faudra voir à converger vraiment
// éventuellement en modificant le noizetier
// pour que ses fonctions soient dist et
// surchageables

/**
 * Obtenir les infos de toutes les noisettes disponibles dans les dossiers noisettes/
 * C'est un GROS calcul lorsqu'il est a faire.
 *
 * Issu du Plugin noizetier et modifié pour Mélusine:
 * + Prise en compte du répertoire modules
 * 	et des éventuels sous répertoires
 * 	Bilan: le calcul est encore plus lourd !
 * + Prise en compte des noisettes sans yaml associé
 *
 * @return array
 */
function melusine_obtenir_infos_noisettes_direct(){

	$liste_noisettes = array();
	
	// répertoires possibles pour Mélusine
	// et necessité d'un examen récursif'
	$liste_rep = array(
			"noisettes/" => false,	// Compat noizetier
			"modules/" => true	// Compat Mélusine
		);
		
	$match = "[^-]*[.]html$";

	// diff avec noizetier: dans plusieurs répertoires
	// et récusrvivement
	$liste= array();
	foreach($liste_rep as $rep => $recurs) {
		$liste = array_merge(
				$liste,
				find_all_in_path(
					$rep,	// dans plusieurs rép
					$match,
					$recurs	// récusrvivement ou pas
				)
			);
	}

	if (count($liste)){
		foreach($liste as $squelette=>$chemin) {

			$noisette = preg_replace(',[.]html$,i', '', $squelette);
			$dossier = str_replace($squelette, '', $chemin);
			
			// Position du module dans les osu-rép de Mélusine
			$sous_rep_pos = strrpos($dossier,"modules/");
			if ($sous_rep_pos === false)
				$sous_rep_pos = 0; // compat noizetier: pas de chemin dans le nom de la noisette
			// On ne garde que les squelettes ayant un fichier YAML de config
			if (file_exists("$dossier$noisette.yaml")
				AND ($infos_noisette = melusine_charger_infos_noisette_yaml($dossier.$noisette))
			){
				// diff avec noizetier:
				// le sous-répertoire va être noté pour
				// les inclusions...
				$bloc = substr($dossier,$sous_rep_pos).$noisette;
				if ($sous_rep_pos === 0)
					$bloc = $noisette; //Compat: pour les noisettes pas de chemin
				$liste_noisettes[$bloc] = $infos_noisette;
			} else {
				// diff avec noizetier:
				// Sans YAML, on garde la noisette
				// avec des infos sommaires
				$bloc = substr($dossier,$sous_rep_pos+8,-1);
				$cle_bloc = substr($dossier,$sous_rep_pos).$noisette;
				if ($sous_rep_pos === 0) {
					//Compat: pour les noisettes pas de chemin
					$cle_bloc = $noisette;
					$bloc = "";
				}
				if ($bloc == "articles" OR $bloc == "rubriques")
					$bloc = substr($bloc,0,-1);
				if ($bloc) $bloc = array($bloc);
				$liste_noisettes[$cle_bloc] = array(
						"nom" => spip_ucfirst(str_replace("_"," ",$noisette)),
						"parametres" => array(),
						"contexte" => array(),
						"ajax" => "non",
						"inclusion" => "statique",
						"blocs_autorises" => $bloc,	// spécifique de Mélusine
					);
			}
		}
	}
	
	// supprimer de la liste les noisettes necissant un plugin qui n'est pas actif
	foreach ($liste_noisettes as $noisette => $infos_noisette)
		if (isset($infos_noisette['necessite']))
			foreach ($infos_noisette['necessite'] as $plugin)
				if (!defined('_DIR_PLUGIN_'.strtoupper($plugin)))
					unset($liste_noisettes[$noisette]);
	
	return $liste_noisettes;
}
/**
 * Charger les informations contenues dans le YAML d'une noisette
 * Issu du Plugin noizetier
 *
 * @param string $noisette
 * @param string $info
 * @return array
 */
function melusine_charger_infos_noisette_yaml($noisette, $info=""){
		// on peut appeler avec le nom du squelette
		$fichier = preg_replace(',[.]html$,i','',$noisette).".yaml";
		include_spip('inc/yaml');
		include_spip('inc/texte');
		$infos_noisette = array();
		if ($infos_noisette = yaml_charger_inclusions(yaml_decode_file($fichier))) {
			if (isset($infos_noisette['nom']))
				$infos_noisette['nom'] = _T_ou_typo($infos_noisette['nom']);
			if (isset($infos_noisette['description']))
				$infos_noisette['description'] = _T_ou_typo($infos_noisette['description']);
			if (isset($infos_noisette['icon']))
				$infos_noisette['icon'] = $infos_noisette['icon'];
				
			if (!isset($infos_noisette['parametres']))
				$infos_noisette['parametres'] = array();
				
			// contexte
			if (!isset($infos_noisette['contexte'])) {
				$infos_noisette['contexte'] = array();
			}
			if (is_string($infos_noisette['contexte'])) {
				$infos_noisette['contexte'] = array($infos_noisette['contexte']);
			}
			
			// ajax
			if (!isset($infos_noisette['ajax'])) {
				$infos_noisette['ajax'] = 'oui';
			}
			// inclusion
			if (!isset($infos_noisette['inclusion'])) {
				$infos_noisette['inclusion'] = 'statique';
			}
		}

		if (!$info)
			return $infos_noisette;
		else 
			return isset($infos_noisette[$info]) ? $infos_noisette[$info] : "";
}
/**
 * Lister les noisettes disponibles dans les dossiers noisettes/
 * Issu du Plugin noizetier
 *
 * @staticvar array $liste_noisettes
 * @param text $type renvoyer seulement un type de noisettes
 * @param text $noisette renvoyer spécifiquement une noisette données
 * @return array
 */
function melusine_lister_noisettes($type='tout'){
	static $liste_noisettes = array();
	if ($type == 'tout') {
		return melusine_obtenir_infos_noisettes();
	}
	if (isset($liste_noisettes[$type])) {
		return $liste_noisettes[$type];
	}
	
	$noisettes = melusine_obtenir_infos_noisettes();
	if ($type == '') {
		$match = "^[^-]*$";
	} else {
		$match = $type."-[^-]*$";
	}
	
	foreach($noisettes as $noisette => $description) {
		if (preg_match("/$match/", $noisette)) {
			$liste_noisettes[$type][$noisette] = $description;
		}
	}
	
	return $liste_noisettes[$type];
}


/**
 * Renvoie les info d'une seule noisette
 * Issu du Plugin noizetier
 *
 * @param text $noisette renvoyer spécifiquement une noisette données
 * @return array
 */
function melusine_info_noisette($noisette) {
	$noisettes = melusine_obtenir_infos_noisettes();
	return $noisettes[$noisette];
}

/**
 * Obtenir les infos de toutes les noisettes disponibles dans les dossiers noisettes/
 * On utilise un cache php pour alleger le calcul.
 * Issu du Plugin noizetier
 *
 * @param 
 * @return 
**/
function melusine_obtenir_infos_noisettes() {
	static $noisettes = false;
	
	// seulement 1 fois par appel, on lit ou calcule tous les contextes
	if ($noisettes === false) {
		// lire le cache des descriptions sauvees
		lire_fichier_securise(_DIR_CACHE . _CACHE_DESCRIPTIONS_NOISETTES, $noisettes);
		$noisettes = @unserialize($noisettes);
		// s'il en mode recalcul, on recalcule toutes les descriptions des noisettes trouvees.
		// ou si le cache est desactive
		if (!$noisettes or (_request('var_mode') == 'recalcul') or (defined('_NO_CACHE') and _NO_CACHE!=0)) {
			$noisettes = melusine_obtenir_infos_noisettes_direct();
			ecrire_fichier_securise(_DIR_CACHE . _CACHE_DESCRIPTIONS_NOISETTES, serialize($noisettes));
		}
	}
	
	return $noisettes;
}

/**
 * Fork du filtre table_valeur: pour pouvoir utiliser des clé avec des "/"
 * permet de recuperer la valeur d'une cle donnee
 * dans un tableau (ou un objet).
 * 
 * @param mixed $table
 * 		Tableau ou objet
 * 		(ou chaine serialisee de tableau, ce qui permet d'enchainer le filtre)
 * 		
 * @param string $cle
 * 		Cle du tableau (ou parametre public de l'objet)
 * 		Cette cle peut contenir des caracteres ! (et non /) pour selectionner
 * 		des sous elements dans le tableau, tel que "sous.element.ici"
 * 		pour obtenir la valeur de $tableau['sous']['element']['ici']
 *
 * @param mixed $defaut
 * 		Valeur par defaut retournee si la cle demandee n'existe pas
 * 
 * @return mixed Valeur trouvee ou valeur par defaut.
**/
function table_valeur_cleslash($table, $cle, $defaut='') {
	foreach (explode('!', $cle) as $k) {

		$table = is_string($table) ? @unserialize($table) : $table;

		if (is_object($table)) {
			$table =  (($k !== "") and isset($table->$k)) ? $table->$k : $defaut;
		} elseif (is_array($table)) {
			$table = isset($table[$k]) ? $table[$k] : $defaut;
		} else {
			$table = $defaut;
		}
	}
	return $table;
}

/**
 * Retourne le joli nom d'un bloc passé en argument
 *
 * @param text $bloc nom abrégé du bloc
 * 
 * @return text joli nom du bloc
 *
**/

function melusine_nombloc($bloc){
	$fin_nom_col = strrpos($bloc,"-col");
	if ($fin_nom_col === false)
		return $GLOBALS['noms_z_blocs'][$bloc];
	if (strripos($bloc,"3",$fin_nom_col))
		return $GLOBALS['noms_z_blocs'][substr($bloc,0,$fin_nom_col)]." colonne 3";
	if (strripos($bloc,"2",$fin_nom_col))
		return $GLOBALS['noms_z_blocs'][substr($bloc,0,$fin_nom_col)]." colonne 2";
	return "Pas de nom";
}
/**
 * Retourne la liste des modules qui sont autorisés pour un bloc donné
 *
 * @param text $bloc nom du bloc
 * @param text $type type de page (par défaut: rubrique)
 * 
 * @return array liste des modules avec les infos attenantes
 *
**/

function melusine_liste_modules_autorises($bloc,$type="rubrique"){
	$colonne=strpos($bloc,"-col");
	if($colonne>0)
		$bloc=substr($bloc,0,$colonne);
	$liste_finale = array();
	$liste_complete = melusine_lister_noisettes();

	// On nettoie bloc pour que ça marche quelle que
	// soit la colonne
	$colonne = strrpos($bloc,"-col");
	if ($colonne > 0)
		$bloc = substr($bloc,0,$colonne);

	// Pour chaque module...
	foreach($liste_complete as $module => $infos_module) {
		if (!is_array($infos_module))
			$infos_module = (array)$infos_module;
			
		// Si pas de bloc blocs_autorises
		// alors, c'est autorisé partout
		// (compat noizetier et Mélusine 1/DATICE)
		if (!$infos_module["blocs_autorises"]) {
			$liste_finale[$module] = $infos_module;
		} elseif (in_array($bloc,$infos_module["blocs_autorises"])){
			// Sinon on vérifie que le module est autorisé
			$liste_finale[$module] = $infos_module;
		} elseif (
			$bloc=="content"
			AND in_array($type,$infos_module["blocs_autorises"])
			) {
			// Cas des blocs "content" désignés directement par le type page
			$liste_finale[$module] = $infos_module;
		}
		
	}
	
	return $liste_finale;
}
/**
 * Retourne la liste des modules passé en param triée en séprant
 *  les modules "uniques" des autres
 *
 * @param text $liste_modules
 * 	(liste de modules issue de melusine_lister_noisettes ou
 * 	melusine_liste_modules_autorises)
 * 
 * @return array deux listes des modules (avec détails)
 *	uniques => une liste, multiples => l'autre
 *
**/

function melusine_trier_uniques($liste_modules){
	$liste_finale = array("uniques" => array(),"multiples" => array());

	// Pour chaque module...
	foreach($liste_modules as $module => $infos_module) {
			$unique_ou_non = "multiples";
		if ($infos_module["unique"] == "oui")
			$unique_ou_non = "uniques";
		$liste_finale[$unique_ou_non][$module] = $infos_module;
	}
	
	return $liste_finale;
}

?>