<?php 
/**
 * Plugin Mélusine
 * (c) 2012 Jean-Marc Labat
 * Licence GNU/GPL
 */

if (!defined('_ECRIRE_INC_VERSION')) return;

/**
 * Fonction d'installation du plugin et de mise à jour.
 * Vous pouvez :
 * - créer la structure SQL,
 * - insérer du pre-contenu,
 * - installer des valeurs de configuration,
 * - mettre à jour la structure SQL  
**/
function melusine_upgrade($nom_meta_base_version, $version_cible) {
	$maj = array();
	// On initialise le tableau des
	// opération d'installation
	$maj['create'] = array();

	// Idem pour le schéma 1.1.0
	$maj['1.1.0'] = array();
	

	// Mise en place des casiers dans la table meta

	// Récupération des données de l'ancien plugin DATICE
	// On commence par regarder si on a des metas datice_xxx
	// Si oui on recopie le contenu dans les metas melusine_xxx
	// Si on n'a pas de datice_XXX ni de melusine_XXX
	// On récupère les infos du fichier de config.
	$liste_des_types_meta = array('bandeau','blocs','boutons','couleurs','mentions','sommaire','squelettes','rubriques','chemin','footer','articles','mobil','images','rechavancee','nuage');
	$chemin = _DIR_PLUGIN_MELUSINE;	
	$chemin_conf = $chemin."config_melusine_par_defaut.txt";
	$file = file($chemin_conf);


	include_spip('inc/config');
	$compteur_lignes_fichier = 0;
	foreach($liste_des_types_meta as $value){
		$meta_datice = "datice_".$value;
		$meta_melusine = "melusine_".$value;
		// dérogation nécessaire car dans le plugin DATICE
		// deux metas étaient sans "s" final: article et rubrique
		if ($value == "articles" OR $value == "rubriques") $meta_datice = substr($meta_datice,0,-1);
		$contenu = lire_config($meta_datice);

		// Si le meta datice_XXX existe et pas melusine_XXX
		// on met la copie de l'un dans l'autre sur la pile
		if($contenu AND !lire_config($meta_melusine)){
			array_push(
				$maj['create'],array('ecrire_config', $meta_melusine, $contenu)
			);
		} else {
			// si le meta datice_XXX était vide et que
			// le meta melusine_XXX est vide aussi
			// on remplit avec le fichier de configuration
			if (!lire_config($meta_melusine)) {
				array_push(
					$maj['create'],array('ecrire_config',
						$meta_melusine,$file[$compteur_lignes_fichier]
					)
				);
			}
		}
		$compteur_lignes_fichier++;
	} // Fin de la mise en place des metas



	// Manipulations de fichiers
	array_push($maj['create'],array('melusine_preparation_fichiers',array()));

	// Mélusine 2 utilise des tables du noizetier
	// vérification de la présence du noizetier
	include_spip('inc/filtres');
	$f = chercher_filtre('info_plugin');
	$noiz_actif = $f("noizetier","est_actif");

	// Si pas noizetier, on vire la base...
	if (!$noiz_actif) {
		array_push($maj['create'],array('creer_base'));
		array_push($maj['1.1.0'],array('creer_base'));
	}

	// Migration vers la base de Mélusine 2 qui gère les
	// modules comme le noiztier gère les noisettes
	array_push($maj['1.1.0'],array('melusine_migration_version_2', array()));


	// en attendant une meilleure façon d'installer Mélusine 2
	// On utilise l'ancienne façon (Mélusine 1), et on migre ensuite
	// en Mélusine 2
	//array_push($maj['create'],array('melusine_migration_version_2', array()));
	array_push($maj['create'],array('melusine_installation_version_2', array()));


	// On lance les opérations...
	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);







}


/**
 * Fonction de désinstallation du plugin.
 * Vous devez :
 * - nettoyer toutes les données ajoutées par le plugin et son utilisation
 * - supprimer les tables et les champs créés par le plugin. 
**/
function melusine_vider_tables($nom_meta_base_version) {
	# quelques exemples
	# (que vous pouvez supprimer !)
	# sql_drop_table("spip_xx");
	# sql_drop_table("spip_xx_liens");

	// vérification de la présence du noizetier
	include_spip('inc/filtres');
	$f = chercher_filtre('info_plugin');
	$noiz_actif = $f("noizetier","est_actif");

	// Si pas noizetier, on vire la base...
	if (!$noiz_actif) {
		sql_drop_table("spip_noisettes");

		# Nettoyer les versionnages et forums
		sql_delete("spip_versions",              sql_in("objet", array('noisette')));
		sql_delete("spip_versions_fragments",    sql_in("objet", array('noisette')));
		sql_delete("spip_forum",                 sql_in("objet", array('noisette')));
	}


	effacer_meta($nom_meta_base_version);
}

/**
 * Fonction de recherche de l'ancien plugin DATICE
 * 
 * @param
 * 
 * @return text renvoie le chemin du plugin DATICE s'il est trouvé ou rien 
**/
function melusine_cherche_chemin_datice() {

	$plugin_datice = "datice3/"; //Nom supposé du répertoire du plugin

	//chemins supposés possibles
	$chemins_possibles_datice = array(_DIR_PLUGINS_AUTO.$plugin_datice,_DIR_PLUGINS.$plugin_datice);

	foreach ($chemins_possibles_datice as $chemin_plugin_datice) {
		if (file_exists($chemin_plugin_datice."balise/daticeaide.php")) return $chemin_plugin_datice;
	}
	return ""; // pas trouvé...
}
/**
 * Opérations sur les fichiers nécessaires à l'installation
 * de Mélusne
 * Notamment pour la MAJ depuis DATICE
 * 
 * @param
 * 
 * @return 
**/
function melusine_preparation_fichiers() {
	include_spip('inc/config');
	$images=array("g86.png","g286.png");
	//si les fichiers logos créteil n'existent pas (1ere install) => création
	foreach($images as $image){
		$chemin_IMG=_NOM_PERMANENTS_ACCESSIBLES; //chemin vers IMG (y compris en mutualisation)
		$logo_img=$chemin_IMG."config/boutons/".$image;
		$logo_plugin=_DIR_PLUGIN_MELUSINE."images/".$image;

		if (!file_exists($logo_img)){
			$config=$chemin_IMG."config";
			$boutons=$config."/boutons";
			mkdir($config, _SPIP_CHMOD);
			if(!is_dir($boutons)){mkdir($boutons, _SPIP_CHMOD);};
			if (!copy($logo_plugin,$logo_img)) echo "erreur de copie de l'image";
		}
	}
	


	// Récupération des noisettes déjà copiées dans Mélusine
	// lors d'une précédente install ou upgrade
	// On les place d'avance dans l'array qui ira dans les Meta

	$a_placer_dans_casier = array();
	$a_placer_dans_casier = lire_config("melusine_perso_a_deplacer");

	// Si un perso.css était défini dans le plugin DATICE
	// On le récupère dans Mélusine
	// idem pour perso-mobil.css

	$a_placer_dans_casier["css"] = array(); // on initialise le sous-casier pour les CSS

	$types_css_perso = array("perso.css","perso-mobil.css");

	foreach ($types_css_perso as $css_perso) {
		$nouvel_emplacement_css=_DIR_PLUGIN_MELUSINE."css/".$css_perso;
		if (!file_exists($nouvel_emplacement_css)) {
			$css_datice_perso = "datice3/styles/".$css_perso;
			$dans_plugins = _DIR_PLUGINS.$css_datice_perso;
			$dans_auto = _DIR_PLUGINS_AUTO.$css_datice_perso;
			if (file_exists($dans_auto)){
				copy($dans_auto,$nouvel_emplacement_css);
			} elseif (file_exists($dans_plugins)){
				copy($dans_plugins,$nouvel_emplacement_css);
			}
		}
		if (file_exists($nouvel_emplacement_css)) {
			$a_placer_dans_casier["css"][] = $nouvel_emplacement_css;
		}
	}



	// Détection et récupération des noisettes personalisées issues du plugin DATICE

	// des noisettes de DATICE qu'on a éliminé de Mélusine
	$noisettes_a_exclure = array(
		"bouton_forum.html",
		"bouton_blog.html",
		);

	$chemin_datice = melusine_cherche_chemin_datice();

	if ($chemin_datice) {
		$nom_rep_noisettes = "modules/";
		$liste_rep_noisettes = array(
			$nom_rep_noisettes,
			$nom_rep_noisettes.'articles',
			$nom_rep_noisettes.'chemin',
			$nom_rep_noisettes.'footer',
			$nom_rep_noisettes.'mobil',
			$nom_rep_noisettes.'rubriques'
			);

		foreach ($liste_rep_noisettes as $type_noisette) {

			// On regarde ce qu'il y a dans le plugin DATICE
			$slash = "/";
			if ($type_noisette == $nom_rep_noisettes) $slash = "";
			$chemin_type_noisette_datice = $chemin_datice.$type_noisette;
			$liste_noisettes_datice_type = array();
			if ($handle = opendir($chemin_type_noisette_datice)) {
				while (false !== ($file = readdir($handle))) {
					
					// On vérifie que c'est une noisette et qu'elle n'est pas exclue
					$match = "/[^-]*[.]html$/";
					if (preg_match($match,$file,$verif) AND !in_array($file,$noisettes_a_exclure)) {
						// un tableau des noisettes de la forme
						// "nom_noisette.html" => "chemin_noisette/nom_noisette.html"
						$liste_noisettes_datice_type[$file] = $chemin_type_noisette_datice.$slash.$file;
					}
				
				}
				
			}
			arsort($liste_noisettes_datice_type);



			// On regarde ce qu'il y a dans Mélusine
			$liste_noisettes_melusine_type = array();
			$match = "[^-]*[.]html$";
			$liste_noisettes_melusine_type = find_all_in_path($type_noisette.$slash, $match);
			arsort($liste_noisettes_melusine_type);


			// On compare: s'il y en a en plus dans dans DATICE
			// On les liste

			$difference = array();
			$difference = array_diff_key($liste_noisettes_datice_type,$liste_noisettes_melusine_type);
			arsort($difference);


			// Ensuite on fait une copie des noisettes perso de DATICE
			// dans Mélusine
			// Puis on les stocke dans le tableau temp des fichiers perso à déplacer

			$a_placer_dans_casier_type = array();
			$chemin_type_noisette_melusine = _DIR_PLUGIN_MELUSINE.$type_noisette.$slash;

			foreach($difference as $noisette_a_deplacer => $chemin_noisette_a_deplacer) {
				copy($chemin_noisette_a_deplacer,$chemin_type_noisette_melusine.$noisette_a_deplacer);
				$a_placer_dans_casier_type[] =  $chemin_type_noisette_melusine.$noisette_a_deplacer;
				
			}

			// On fusionne les fichiers déjà déclarés dans les metas
			// avec ceux qu'on vient de copier, et on les stocke dans
			// le tableau des fichiers perso à déplacer

			// on détermine le nom du casier (type de noisette)
			$nom_sous_casier = str_replace($nom_rep_noisettes,"",$type_noisette);
			if ($nom_sous_casier == "") $nom_sous_casier = "squelettes";


			$a_placer_dans_casier[$nom_sous_casier] = array_merge((array)$a_placer_dans_casier[$nom_sous_casier],$a_placer_dans_casier_type);

			$a_placer_dans_casier[$nom_sous_casier] = array_unique($a_placer_dans_casier[$nom_sous_casier]);
			arsort($a_placer_dans_casier[$nom_sous_casier]);



			

		}
	}
	ecrire_config("melusine_perso_a_deplacer",$a_placer_dans_casier);
}

/**
 * Migration de Mélusine 1 vers Mélusine 2
 * (c'est à dire passage d'un système de module centré sur les métas
 * à un système proche du noizetier, en base)
 * 
 * @param
 * 
 * @return 
**/
function melusine_migration_version_2() {
	include_spip('inc/config');

	// Liste des blocs => casiers dans Mélusine 1
	// en prenant en compte les colonnes
	// et les types de pages
	// modules[type_page][bloc(-col)?] = liste (array) de modules
	// le suffixe -col2 ou -col3 concerne les colonnes des content
	// pour une meilleure compat avec le noizetier la -col1 n'a pas
	// de suffixe

	// On différencie les casier du futur bloc content
	// (spécifiques d'un type de page)
	// de ceux qui constitueront les autres bocs
	// (qui devront être répercutés sur chaque type de page)
	$liste_casiers__de_content = array('articles','mobil','rubriques','sommaire');

	$correspondances_anciens_nouveaux_blocs = array (
			'chemin/effectifs' => 'breadcrumb',
			'footer/effectifs' => 'footer',
			'squelettes/g' => 'aside',
			'squelettes/d' => 'extra'
		);
	// Pour chaque type de page
	$liste_futurs_types_page = array('article','rubrique','sommaire','mobil');
	foreach($liste_futurs_types_page as $type_page) {
		// blocs génériques qui n'existent pas dans Mélusie 1
		$modules[$type_page]['nav']= array();
		$modules[$type_page]['header']= array();

		// On récupère les autres blocs génériques:
		foreach($correspondances_anciens_nouveaux_blocs as $anciens => $nouveau) {
			$modules[$type_page][$nouveau] = lire_config("melusine_".$anciens);
			
		}

		// Passons au bloc content qui peut
		// être découpé en colonnes
		$effectis = array('effectifs' => '');
		$nom_traitement = $type_page."s";


		// Mobil déroge à certaines règles:
		// pas de s final

		if ($type_page == "mobil")
			$nom_traitement = $type_page;

		// Sommaire déroge à certaines règles:
		// pas de s final
		// et éventuellement, deux colonnes
		if ($type_page == "sommaire") {
			$nom_traitement = $type_page;
			$effectis = array(
				'x' => "", //pas de suffixe pour la premiere colonne
				'y' => "-col2");
		}

		// Les modules du futur content
		foreach($effectis as $cases => $suffixe_bloc) {
			$modules[$type_page]['content'.$suffixe_bloc] = lire_config("melusine_".$nom_traitement."/".$cases);
		}
		
		
		
	} // Fin de chaque type de page
	

	// On va chercher dans chaque casier de bloc
	// les infos pour placer dans la BD
	// rang, type, bloc, noisette
	// et n place toutes les infos dans la BD
	include_spip('action/editer_objet');

	$tableau_chemins_modules_content = array(
		"article" => "modules/articles/",
		"rubrique" => "modules/rubriques/",
		"mobil" => "modules/mobil/",
		"sommaire" => "modules/"
		);
	// Pour chaque type de page...
	foreach($modules as $type_page => $blocs) {
		// Pour chaque typppe de bloc...
		foreach($blocs as $bloc => $liste_modules) {
			// description des noisettes de ce bloc
			$set = array(
				"rang" => 0,
				"type" => $type_page,
				"bloc" => $bloc,
				"noisette" => ""
			);
			//pour chaque noisette...
			foreach($liste_modules as $module) {

				// gestions des différents cas particuliers
				// des sous-répertoires de Mélusine 1 et DATICE
				$nom_module = "modules/".$module;
				if ($bloc == "content")
					$nom_module = $tableau_chemins_modules_content[$type_page].$module;
				if ($bloc == "breadcrumb")
					$nom_module = "modules/chemin/".$module;
				if ($bloc == "footer")
					$nom_module = "modules/footer/".$module;
				if ($module == "aucun")
					$nom_module ="";
				echo "$nom_module - ";
				// Si le module n'est pas vide:
				if ($nom_module) {
					$set['noisette'] = $nom_module;
					$set['rang']++;

					// insertion
					$id_noisette = objet_inserer("noisette", $id_parent="",$set);
					if (!$id_noisette)
						spip_log("Impossible d'insérer le module ".$module." dans le bloc ".$bloc." de la page ".$type_page. "au rang ".$rang);
				}
			}
		}

		
	}
	return true;
	
	
}

function melusine_installation_version_2(){
	include_spip('action/editer_objet');
	include_spip('ecrire/inc/xml');
	spip_log("config");
	$xml=spip_file_get_contents( _DIR_PLUGIN_MELUSINE."/base/melusine.xml" );
	
	$arbre=spip_xml_parse( $xml);
	
	foreach ($arbre['configuration'][0]['noisettes'][0]['item'] as $feuille){
		
		$noeuds=array("rang","noisette","type","bloc");
		
		foreach($noeuds as $noeud){
			$item[$noeud]=$feuille[$noeud][0];
		}
			
			
			$id_noisette = objet_inserer("noisette", $id_parent="",$item);

	}
	
	if( $config=$arbre['configuration'][0]["config"][0]){
		spip_log("config");
	}
	$config=unserialize($config);

	$pages=$config['pages'];
	$width=$config['width'];
	$gabarits=$config['gabarits'];
	$types=array("sommaire","categorie","contenu");
	foreach($types as $type){
		$untype=$config[$type];
		foreach ($untype as $bloc=>$largeur){
			
			ecrire_config("melusine_data/".$type."/".$bloc,$largeur);
		}
		
	}
	
	ecrire_config("melusine_data/width/",$width);
	foreach($pages as $cle=>$page){
		ecrire_config("melusine_data/pages/".$cle,$page);
		
	}
	foreach($gabarits as $cle=>$gabarit){
		ecrire_config("melusine_data/gabarits/".$cle,$gabarit);
		
	}
}


?>