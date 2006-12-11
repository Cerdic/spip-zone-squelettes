<?php

	// Toutes les fonctions ont étés regroupées ici.

	function BliP_version_ftp() {
		return (2.3);
		// METTRE EGALEMENT A JOUR LA VERSION DU FICHIER plugin.xml
	}
	
	// Script de verification de l'existance de la base de donnée. Utilisé sur diverses pages
	function BliP_verifier_base() {
		global $table_blip;
		return (spip_query("SELECT * FROM `spip_blip`"));
	}

	// Script  d'installation de la table spip_blip et configuration par défaut du squelette. Utilisé sur exce=blip
	function BliP_installer_blip() {
		include_spip('inc/meta');
		ecrire_meta('blip_version', 2.3);
		ecrire_metas();
		BliP_installer_table();
		BliP_installer_configuration();
		BliP_installer_blip_meta();
	}

	function BliP_installer_blip_meta() {
		include_spip('inc/meta');
		ecrire_meta('blip_menu_lateral', "oui");
		ecrire_meta('blip_accueil', "oui");
		ecrire_meta('blip_sommaire', "oui");
		ecrire_meta('blip_sommaire_afficher', "oui");
		ecrire_meta('blip_sommaire_articles', "oui");
		ecrire_meta('blip_sommaire_commentaires', "oui");
		ecrire_meta('blip_sommaire_documents', "oui");
		ecrire_meta('blip_rubriques', "oui");
		ecrire_meta('blip_articles', "oui");
		ecrire_meta('blip_articles_trier', "oui");
		ecrire_meta('blip_articles_datepub', "oui");
		ecrire_meta('blip_articles_datemaj', "oui");
		ecrire_meta('blip_articles_popularite', "oui");
		ecrire_meta('blip_articles_visiteurs', "oui");
		ecrire_meta('blip_mots', "oui");
		ecrire_meta('blip_mots_afficher', "oui");
		ecrire_meta('blip_mots_theme', "oui");
		ecrire_meta('blip_mots_popularite', "oui");
		ecrire_meta('blip_mots_alphabetique', "oui");
		ecrire_meta('blip_auteur', "oui");
		ecrire_meta('blip_espaceprive', "oui");
		ecrire_meta('blip_switch', "oui");
		ecrire_meta('blip_rechercher', "oui");		
		ecrire_meta('blip_prefixe', "neutre");
		ecrire_meta('blip_theme', "toto");
		ecrire_meta('blip_couleur', "1");	
		ecrire_metas();
	
	}
	
	
	function BliP_installer_table() {
		// Installe la structure de la table blip - Processus différentié de celui des tables, comme ça en cas de platage on aura au moins la base.
		global $table_blip;
		$req = "
		CREATE TABLE `spip_blip` (
		`id_config` bigint(21) NOT NULL auto_increment,
		`position` tinytext NOT NULL,
		`id_item` bigint(21) NOT NULL default '0',
		`ordre` bigint(21) NOT NULL default '0',
		`type` tinytext NOT NULL,
		`titre` text NOT NULL,
		`descriptif` text NOT NULL,
		`texte` text NOT NULL,
		`style` tinytext NOT NULL,
		`actif` char(3) NOT NULL default '',
		PRIMARY KEY  (`id_config`),
		KEY `actif` (`actif`)
		) ENGINE=MyISAM;
		";
		spip_query($req);
	}

	function BliP_installer_configuration() {
		global $table_blip;
		// Installe la configuration par défaut -- Une requête par ligne, car sinon cela bug et je ne sais pas pourquoi.
		$req = "INSERT INTO `spip_blip` VALUES ('', 'menu_principal', 0, 20, 'lienpage', '<multi>[fr]Rubriques [en]Sections [it]Rubriche [ca]Secci&oacute;</multi>', '<multi>[fr]Parcourir les rubriques du site[en]To traverse the section of the site[it]Per attraversare le rubriche del sito[ca]Fullejar les seccions del web</multi>', 'rubrique', '', 'non');";
		spip_query($req);
		$req = "INSERT INTO `spip_blip` VALUES ('', 'menu_principal', 0, 30, 'lienpage', '<multi>[fr]Articles [en]Articles [it]Articoli [ca]Articles</multi>', '<multi>[fr]Liste des articles du site[en]List articles of the site[it]Lista degli articoli del sito[ca]Llistat d''articles del web</multi>', 'article', '', 'non');";
		spip_query($req);
		$req = "INSERT INTO `spip_blip` VALUES ('', 'menu_principal', 0, 10, 'lienpage', '<multi>[fr]Actualit&eacute; [en]News [it]Notizie [ca]Actualitat</multi>', '<multi>[fr]Suivre l''actualit&eacute; de ce site[en]News of this site[it]Seguire le novita &agrave; del sito[ca]Seguir l''actualitat del lloc</multi>', 'sommaire', '', 'non');";
		spip_query($req);
		$req = "INSERT INTO `spip_blip` VALUES ('', 'menu_principal', 0, 50, 'lienpage', '<multi>[fr]Auteurs [en]Authors [it]Autore [ca]Autors</multi>', '<multi>[fr]Liste des auteurs du site[en]List authors of the site[it]Elenco degli autori del sito[ca]Llistat d''autors del lloc</multi>', 'auteur', '', 'non');";
		spip_query($req);
		$req = "INSERT INTO `spip_blip` VALUES ('', 'menu_principal', 0, 40, 'lienpage', '<multi>[fr]Mots-cl&eacute;s [en]Tags [it]Parole chiave [ca]Paraules clau</multi>', '<multi>[fr]Liste des mots-cl&eacute;s du site[en]Tags of the site[it]Parole chiave del sito[ca]Llistat de paraules clau del lloc web</multi>', 'mot', '', 'non');";
		spip_query($req);
		$req = "INSERT INTO `spip_blip` VALUES ('', 'barre_laterale', 0, 20, 'dynamique', '-', '-', 'mod_liste_des_rubriques_v2.2', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `spip_blip` VALUES ('', 'barre_laterale-sommaire', 0, 60, 'dynamique', '', '', 'mod_liste_des_articles_populaires_v2.2', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `spip_blip` VALUES ('', 'barre_laterale-sommaire', 0, 50, 'dynamique', '-', '-', 'mod_liste_des_derniers_commentaires_v2.2', '-', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `spip_blip` VALUES ('', 'barre_laterale-sommaire', 0, 70, 'dynamique', '', '', 'mod_liste_des_articles_maj_v2.2', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `spip_blip` VALUES ('', 'barre_laterale-article', 0, 10, 'dynamique', '', '', 'mod_a_propos_de_cet_article_v2.2', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `spip_blip` VALUES ('', 'barre_laterale-article', 0, 5, 'dynamique', '', '', 'mod_article_dans_la_meme_rubrique_v2.2', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `spip_blip` VALUES ('', 'barre_laterale', 0, 90, 'dynamique', '', '', 'mod_rechercher_sur_le_site_v2.2', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `spip_blip` VALUES ('', 'barre_laterale-recherche', 0, 95, 'dynamique', '', '', 'mod_recherche_externe_v2.2', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `spip_blip` VALUES ('', 'barre_laterale', 0, 2, 'statique', 'Bonjour,', '', 'Votre site utilise le squelette modulaire <a href=\"http://www.cent20.net/spip.php?article100\">BliP</a>, et il semblerait que l\'installation se soit bien d&eacute;roul&eacute;e ;-)\r\n\r\n V.R.', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `spip_blip` VALUES ('', 'mentions_techniques', 0, 50, 'lienpage', '', 'Oseriez-vous changer de couleurs ?', 'switch', '', 'non');";
		spip_query($req);	
		$req = "INSERT INTO `spip_blip` VALUES ('', 'barre_laterale-sommaire', 0, 1, 'dynamique', '-', '-', 'mod_selecteur_de_langue_v2.2', '', 'non');";
		spip_query($req);
		$req = "INSERT INTO `spip_blip` VALUES ('', 'barre_laterale', 0, 10, 'dynamique', '-', '-', 'mod_rubriques_et_navigation_laterale_v2.3', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `spip_blip` VALUES ('', 'barre_laterale', 0, 95, 'dynamique', '-', '-', 'mod_identification_des_visiteurs_v2.2', '', 'non');";
		spip_query($req);
		$req = "INSERT INTO `spip_blip` VALUES ('', 'barre_laterale', 0, 1, 'dynamique', '-', '-', 'mod_identification_se_deconnecter_v2.2', '', 'non');";
		spip_query($req);
	}

	// Script  de suppression de la table spip_blip. Utilisé sur exec=blip_effacer
	function BliP_supprimer_blip() {
		BliP_supprimer_table();
		BliP_supprimer_meta();
	}

	function BliP_supprimer_table() {
		global $table_blip;
		$req = "DROP table `spip_blip`";
		spip_query($req);
	}
	function BliP_supprimer_meta() {
		include_spip('inc/meta');
		ecrire_meta('blip_version', '');
		ecrire_metas();
	}

	function BliP_vider_table_blip () {
		BliP_supprimer_table();
		BliP_installer_table();
	}

	// MAJ du squelette BliP

	function BliP_maj_blip () {
		$v_instal = $GLOBALS['meta']["blip_version"];
		$v_ftp = BliP_version_ftp();

		if ($v_ftp < 2.4) {
			BliP_vider_table_blip ();
			include_spip('inc/meta');
			ecrire_meta('blip_version', 2.3);
			ecrire_metas();
			BliP_installer_blip_meta();
		}
	}

	// Génère un tableau dressant la configuration actuelle. Utilisé sur exec=blip
	function BliP_tableau_config ($res) {
		$compte = spip_num_rows($res);
		$index = 1;
		echo "<br />";
		echo "<div class='verdana1'>";
		echo "<table cellpadding='3' cellspacing='1' border='0'>";
		echo "<tr bgcolor='#aaaaaa' style='color:white; text-align:center;'>
				<td class='verdana2' style='text-align:center;'><b>".'Statut'."</b></td>
				<td class='verdana2' style='text-align:center;'><b>".'Ordre'."</b></td>
				<td class='verdana2' style='text-align:center;'><b>".'&nbsp;Options&nbsp;'."</b></td>
				<td class='verdana2' style='text-align:center;'><b>".'Restriction d\'affichage'."</b></td>
				<td class='verdana2' style='text-align:center;'><b>".'Texte affich&eacute; <br /> ou fichier inclu'."</b></td>
			</tr>\n";
		while ($elements = spip_fetch_array($res, SPIP_ASSOC)) {
			$bgcolor = alterner($i++, '#eeeeee','white');
			$restriction = explode("-", $elements['position']);
			echo "<tr bgcolor='$bgcolor'><td style='text-align:center;'>";
			if ( $elements['actif'] =='oui') {
				echo "<span style='margin:5px;'><a href='".generer_url_ecrire('blip',"action=desactiver&id=".$elements['id_config'])."'><img src='../plugins/blip/ecrire/img_pack/blipconfig-green.gif' title='D&eacute;sactiver cet &eacute;lement'/></a></span>";
			}
			elseif ( $elements['actif'] =='non') {
				echo "<a href='".generer_url_ecrire('blip',"action=activer&id=".$elements['id_config'])."'><img src='../plugins/blip/ecrire/img_pack/blipconfig-red.gif' title='Activer cet &eacute;lement'/></a>";
			}
			echo "</td>";
			echo "<td style='text-align:center;'>".$elements['ordre']."</td><td style='text-align:center;'>";
			echo "<span style='margin:2px;'><a href='".generer_url_ecrire('blip_modifier',"action=editer&id=".$elements['id_config'])."' title='Modifier cet &eacute;lement'><img src='../plugins/blip/ecrire/img_pack/blipconfig-modif.gif' /></a></span>";
			echo "<span style='margin:2px;'><a href='".generer_url_ecrire('blip',"action=supprimer&id=".$elements['id_config'])."' title='Suprimer cet &eacute;lement'><img src='../plugins/blip/ecrire/img_pack/blipconfig-delete.gif' /></a></span>";
			echo "</td>";
			if ( $restriction[1] =='') {
				echo "<td style='text-align:center;'>aucune</td>";
			} else  {
				if ( $elements['id_item'] !='0') {
					echo "<td style='text-align:center;'>".$restriction[1]."<br /> n° ".$elements['id_item']."</td>";
				} else if ( $elements['id_item'] =='0') {
					echo "<td style='text-align:center;'>".$restriction[1]."</td>";
				}
			}			
			if ($elements['type'] == 'statique') {
				echo "<td><b>".$elements['titre']."</b><br /><i>".$elements['descriptif']."</i><br />".$elements['texte']."</td>";
			} else {
				if ( $elements['position'] == 'menu_principal') {
					echo "<td><b>".$elements['titre']."</b><br /><i>".$elements['descriptif']."</i><br />".$elements['texte']."</td>";
				} else {
					echo "<td>".$elements['texte']."</td>";
				}
			}
			echo "</tr>\n";
			$index++;
		}
		echo "</table></div>";

	}

	// SCRIPTS GENERANT LA CONFIGURATION ACTUELLE PAR ZONE. Utilisé sur exec=blip
	// LIKE car en fait, on peut mettre différent codes : surtitre, surtitre-article etc ... Ceci est géré par le squelette lui même.
	
	// TODO : Ci-dessous, c'est pas évolutif. Si on rajoute des zones, il faut faire des copiés collés massif.
	// L'idéal serait de faire un tableau déclarant les zones possibles et une fonction qui croise le tout.
	// je fais le tableau php

	function BliP_zone_personnalisables() {
	$blipconfig_zone = array(
		"surtitre",
		"titre_principal",
		"sous_titre",
		"menu_principal",
		"sur_contenu",
		"barre_laterale",
		"sous_contenu",
		"mentions_techniques"
		);
	return blipconfig_zone;
	}

	
	function BliP_afficher_config_surtitre () {
		$result = spip_query("SELECT * FROM spip_blip where position LIKE 'surtitre%' ORDER BY ordre");
		$compte_result = spip_num_rows($result);
		if ($compte_result != '0') {
		debut_cadre_trait_couleur("breve-24.gif", false, "", _T('blipconfig:blip_configuration_surtitre'));
		BliP_tableau_config ($result);
		fin_cadre_trait_couleur();
		echo "<br />";
		}
	}

	function BliP_afficher_config_titre_principal () {
		$result = spip_query("SELECT * FROM spip_blip where position LIKE 'titre_principal%' ORDER BY ordre");
		$compte_result = spip_num_rows($result);
		if ($compte_result != '0') {
		debut_cadre_trait_couleur("breve-24.gif", false, "", _T('blipconfig:blip_configuration_titre_principal'));
		BliP_tableau_config ($result);
		fin_cadre_trait_couleur();
		echo "<br />";
		}
	}

	function BliP_afficher_config_titre_lateral () {
		$result = spip_query("SELECT * FROM spip_blip where position LIKE 'titre_lateral%' ORDER BY ordre");
		$compte_result = spip_num_rows($result);
		if ($compte_result != '0') {
		debut_cadre_trait_couleur("breve-24.gif", false, "", _T('blipconfig:blip_configuration_titre_lateral'));
		BliP_tableau_config ($result);
		fin_cadre_trait_couleur();
		echo "<br />";
		}
	}

	function BliP_afficher_config_sous_titre () {
		$result = spip_query("SELECT * FROM spip_blip where position LIKE 'sous_titre%' ORDER BY ordre");
		$compte_result = spip_num_rows($result);
		if ($compte_result != '0') {
		debut_cadre_trait_couleur("breve-24.gif", false, "", _T('blipconfig:blip_configuration_sous_titre'));
		BliP_tableau_config ($result);
		fin_cadre_trait_couleur();
		echo "<br />";
		}
	}
	
	function BliP_afficher_config_menu_principal () {
		$result = spip_query("SELECT * FROM spip_blip where position LIKE 'menu_principal%' ORDER BY ordre");
		$compte_result = spip_num_rows($result);
		if ($compte_result != '0') {
		debut_cadre_trait_couleur("breve-24.gif", false, "", _T('blipconfig:blip_configuration_menu_principal'));
		BliP_tableau_config ($result);
		fin_cadre_trait_couleur();
		echo "<br />";
		}
	}

	function BliP_afficher_config_sur_contenu () {
		$result = spip_query("SELECT * FROM spip_blip where position LIKE 'sur_contenu%' ORDER BY ordre");
		$compte_result = spip_num_rows($result);
		if ($compte_result != '0') {
		debut_cadre_trait_couleur("breve-24.gif", false, "", _T('blipconfig:blip_configuration_sur_contenu'));
		BliP_tableau_config ($result);
		fin_cadre_trait_couleur();
		echo "<br />";
		}
	}
	
	function BliP_afficher_config_sous_contenu () {
		$result = spip_query("SELECT * FROM spip_blip where position LIKE 'sous_contenu%' ORDER BY ordre");
		$compte_result = spip_num_rows($result);
		if ($compte_result != '0') {
		debut_cadre_trait_couleur("breve-24.gif", false, "", _T('blipconfig:blip_configuration_sous_contenu'));
		BliP_tableau_config ($result);
		fin_cadre_trait_couleur();
		echo "<br />";
		}
	}
	
	
	function BliP_afficher_config_barre_laterale () {
		$result = spip_query("SELECT * FROM spip_blip where position LIKE 'barre_laterale%' ORDER BY ordre");
		$compte_result = spip_num_rows($result);
		if ($compte_result != '0') {
		debut_cadre_trait_couleur("breve-24.gif", false, "", _T('blipconfig:blip_configuration_barre_laterale'));
		BliP_tableau_config ($result);
		fin_cadre_trait_couleur();
		echo "<br />";
		}
	}

	function BliP_afficher_config_menu_mentions_techniques () {
		$result = spip_query("SELECT * FROM spip_blip where position LIKE 'mentions_techniques%' ORDER BY ordre");
		$compte_result = spip_num_rows($result);
		if ($compte_result != '0') {
		debut_cadre_trait_couleur("breve-24.gif", false, "", _T('blipconfig:blip_configuration_mentions_techniques'));
		BliP_tableau_config ($result);
		fin_cadre_trait_couleur();
		echo "<br />";
		}
	}

	// Afficher toute la configuration ...
	
	//IDEM ICI : tout ceci est bien compliqué me semble t'il ...
	
	function BliP_afficher_configuration () {
		if (BliP_verifier_base()) {
			echo "<br />";
			BliP_afficher_config_surtitre ();
			BliP_afficher_config_titre_principal ();
			BliP_afficher_config_titre_lateral ();
			BliP_afficher_config_sous_titre ();
			BliP_afficher_config_menu_principal ();
			BliP_afficher_config_sur_contenu ();
			BliP_afficher_config_sous_contenu ();
			BliP_afficher_config_barre_laterale ();			
			BliP_afficher_config_menu_mentions_techniques ();
		}
	}

	// Script rapide d'activation d'une ligne
	function BliP_activer_ligne ($id_ligne) {
		$req = "UPDATE `spip_blip` SET `actif` = 'oui' WHERE `id_config` = ".$id_ligne." LIMIT 1 ;";
		spip_query($req);
	}

	// Script rapide de desactivation d'une ligne
	function BliP_desactiver_ligne ($id_ligne) {
		$req = "UPDATE `spip_blip` SET `actif` = 'non' WHERE `id_config` = ".$id_ligne." LIMIT 1 ;";
		spip_query($req);
	}

	// Script rapide de suppression d'une ligne
	function BliP_supprimer_ligne ($id_ligne) {
		$req = "UPDATE `spip_blip` SET `position` = 'aucune' WHERE `id_config` = ".$id_ligne." LIMIT 1 ;";
		spip_query($req);
	}


	/***************************************************/
	/* Génération automatique d'éléments de formulaire */
	/***************************************************/
	function BliP_generer_option_select($nom, $valeurs, $actif="", $onchange="") {
		$s  = '<select name="'.$nom.'" id="'.$nom.'" onchange="'.$onchange.'">';
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

	function BliP_generer_checkbox($nom, $valeur) {
		$r = '<input type="checkbox" name="'.$nom.'" value="'.$nom.'"';
		if ($valeur && ! preg_match("/non?/i", $valeur)) {
			$r .= ' checked="checked"';
		}
		$r .= ' />';
		return $r;
	}

	function BliP_initialiser_valeurs_formulaire() {
	$blipconfig_item = array(
	//Valeurs par défaut, je les ai complété je pense que c'est ce que tu voulais que je fasse.
		'id_config' => "",
		'position' => "barre_laterale",
		'id_item' => "0",
		'ordre' => "50", // Chiffre clefs pour mettre le module au milieu
		'type' => "statique",
		'titre' => "",
		'descriptif' => "",
		'texte' => "",
		'style' => "",
		'actif' => "oui"
		);
	// surcharge de ces valeurs le cas échéant par celles de la base si action sur un item a priori existant
	if (isset($_GET['action'])) {
		$action = $_GET['action'];
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
			$res = spip_query("SELECT * FROM spip_blip WHERE id_config='$id' LIMIT 1");
			$blipconfig_item = spip_fetch_array($res, SPIP_ASSOC);
		}
	}
	return $blipconfig_item;
	}

/* générer un formulaire prérempli pour l'item nouveau ou modifié */
/* ajout d'un type à part entière : pointer vers une page spécifique ?
  'page' => _T('blipconfig:blip_pointer_page') */
	function BliP_generer_formulaire($action) {
	$blipconfig_menutypes = array(
		'dynamique' => "Inclure un module",
		'statique' => "Afficher un texte",
		'lienpage' => "Afficher un lien vers une page du site"
	);

	//IDEM ICI : tout ceci est bien compliqué me semble t'il ...
	
	$blipconfig_positions = array(
		'surtitre' => "Surtitre",
		'titre_principal' => "Titre du site",
		'sous_titre' => "Sous titre",
		'titre_lateral' => "Titre lat&eacute;ral",
		'menu_principal' => "Menu principal de navigation",
		'sur_contenu' => "Au dessus du contenu principal",
		'sur_contenu-sommaire' => "Au dessus du contenu principal - Restreindre aux pages 'sommaire'",
		'sur_contenu-article' => "Au dessus du contenu principal - Restreindre aux pages 'articles'",
		'sur_contenu-recherche' => "Au dessus du contenu principal - Restreindre aux pages de recherche",
		'sur_contenu-auteur' => "Au dessus du contenu principal - Restreindre aux pages 'auteurs'",
		'sur_contenu-login' => "Au dessus du contenu principal - Restreindre aux pages 'login'",
		'sous_contenu' => "Au dessous du contenu principal",
		'sous_contenu-sommaire' => "Au dessous du contenu principal - Restreindre aux pages 'sommaire'",
		'sous_contenu-article' => "Au dessous du contenu principal - Restreindre aux pages 'articles'",
		'sous_contenu-recherche' => "Au dessous du contenu principal - Restreindre aux pages de recherche",
		'sous_contenu-auteur' => "Au dessous du contenu principal - Restreindre aux pages 'auteurs'",
		'sous_contenu-login' => "Au dessous du contenu principal - Restreindre aux pages 'login'",		
		'barre_laterale' => "Barre laterale",
		'barre_laterale-sommaire' => "Barre lat&eacute;rale - Restreindre aux pages 'sommaire'",
		'barre_laterale-recherche' => "Barre lat&eacute;rale - Restreindre aux pages de recherche",
		'barre_laterale-article' => "Barre lat&eacute;rale - Restreindre aux pages 'articles'",
		'barre_laterale-rubrique' => "Barre lat&eacute;rale - Restreindre aux pages 'rubriques'",
		'barre_laterale-auteur' => "Barre lat&eacute;rale - Restreindre aux pages 'auteurs'",
		'barre_laterale-mot' => "Barre lat&eacute;rale - Restreindre aux pages 'mots cl&eacute;s'",
		'barre_laterale-login' => "Barre lat&eacute;rale - Restreindre aux pages 'login'",
		'mentions_techniques' => "Mentions techniques"
	);
	$blipconfig_actif = array(
		'oui' => "Oui",
		'non' => "Non"
	);

	$blipconfig_style = array(
		'' => "Aucun",
		'couleur1' => "Couleur principale",
		'couleur1_clair' => "Couleur principale claire",
		'couleur2' => "Couleur secondaire",
		'couleur2_clair' => "Couleur secondaire claire",
		'gris_fonce' => "Gris fonc&eacute;",
		'gris_moyen' => "Gris moyen",
		'gris_clair' => "Gris clair",
		'neutre' => "Neutre",
	);

	$formval = BliP_initialiser_valeurs_formulaire();

	$blipconfig_modules['null']=_T('blipconfig:blip_choisir_module');
	if (is_dir("../")) {
		if ($dh = opendir("../plugins/blip/")) {
			while (($file = readdir($dh)) !== false) {
				if (!is_dir($file)) {
					if (preg_match("/(^mod)(-|_).+\.html$/", $file)) {
						$blipconfig_modules[preg_replace("/\.html$/", "", $file)] = BliP_nom_module_lisible($file);
					}
				}
			}
			closedir($dh);
		}
	}
	asort($blipconfig_modules);

	$blipconfig_pages[0]=_T('blipconfig:blip_choisir_page');
	if (is_dir("../")) {
		if ($dh = opendir("../plugins/blip/")) {
			while (($file = readdir($dh)) !== false) {
				if (!is_dir($file)) {
					if (preg_match("/^[^-_]+\.html$/", $file)) {
						$blipconfig_pages[preg_replace("/\.html$/", "", $file)] = BliP_nom_module_lisible($file);
					}
				}
			}
			closedir($dh);
		}
	}
	asort($blipconfig_pages);


echo <<<END1
<script language="JavaScript" type="text/JavaScript">
//<!--
END1;
echo "\nvar item_type = ".$formval['type'].";";
echo "\nvar item_pos  = ".$formval['position'].";\n";
echo <<<END
function blip_update_type(selObj) {
	item_type = selObj.options[selObj.selectedIndex].value;
	blip_update_layers();
}
function blip_update_pos(selObj) {
	item_pos = selObj.options[selObj.selectedIndex].value;
	blip_update_layers();
}
function blip_update_layers() {
	switch (item_type) {
		case "dynamique" :
			display_title   = "none";
			display_descr   = "none";
			display_text    = "none";
			display_style   = 'none';
			display_modules = "block";
			display_pages   = "none";
			break;
		case "lienpage" :
			display_title   = "block";
			display_descr   = "block";
			display_text    = "none";
			display_style   = 'none';
			display_modules = "none";
			display_pages   = "block";
			break;
		case "statique" :
			display_title   = "block";
			display_descr   = "none";
			display_text    = "block";
			display_style   = "block";
			display_modules = "none";
			display_pages   = "none";
			break;
	}

	if (!(layer = findObj('Layer_texte'))) return;
		layer.style.display = display_text;
	if (!(layer = findObj('Layer_style'))) return;
		layer.style.display = display_style;
	if (!(layer = findObj('Layer_modules'))) return;
		layer.style.display = display_modules;
	if (!(layer = findObj('Layer_titre'))) return;
		layer.style.display = display_title;
	if (!(layer = findObj('Layer_descr'))) return;
		layer.style.display = display_descr;
	if (!(layer = findObj('Layer_pages'))) return;
		layer.style.display = display_pages;
}
//-->
</script>
END;

	switch ($formval['type']) {
		case "dynamique" :
			$display_titre = "none";
			$display_descr = "none";
			$display_texte = "none";
			$display_style = "none";
			$display_modules = "block";
			$display_pages = "none";
		break;
		case "lienpage" :
			$display_titre = "none";
			$display_descr = "block";
			$display_texte = "none";
			$display_style = "none";
			$display_modules = "none";
			$display_pages = "block";
		break;
		case "statique" :
			$display_titre = "block";
			$display_descr = "none";
			$display_texte = "block";
			$display_style = "block";
			$display_modules = "none";
			$display_pages = "none";
		break;
		default :
			$display_titre = "none";
			$display_descr = "none";
			$display_texte = "none";
			$display_style = "none";
			$display_modules = "none";
			$display_pages = "none";
	}

	echo '<form name="form1" id="form1" method="post" action="'.generer_url_ecrire('blip_modifier',"action=formulaire").'">';
	echo '<input name="id_config" type="hidden" id="id_config" value="'.$formval['id_config'].'" />';

	echo "<p>Cliquer sur les triangles pour d&eacute;velopper l'aide des formulaires <br />";

	debut_cadre_relief("", false, "", bouton_block_invisible('blip_position')._T('blipconfig:blip_position_info'));
	echo BliP_generer_option_select('type', $blipconfig_menutypes, $formval['type'], "blip_update_type(this)");
	echo debut_block_invisible('blip_position');
	echo "<p>Le menu d&eacute;roulant ci-dessus vous permet de choisir le type de modification que vous voulez faire. Pour que les modifications soient visibles sur la partie publique du site, il est n&eacute;cessaire de <a href='http://www.cent20.net/spip.php?article90'>vider le cache de spip</a>.</p>";
	echo fin_block();
	fin_cadre_relief();
	echo "<br />";

	debut_cadre_relief("", false, "", _T('blipconfig:blip_restriction_info'));
	echo BliP_generer_option_select('position', $blipconfig_positions, $formval['position']);
	echo "<br />";
	echo '<br /><b>Ordre de positionnement dans le flux </b><input size="2" maxlength="2" name="ordre" type="text" id="ordre" value="'.$formval['ordre'].'" /> ';
	fin_cadre_relief();
	echo "<br />";

	echo '<div id="Layer_titre" style="display: '.$display_titre.'; margin-top: 1px;">';
	debut_cadre_relief("", false, "", _T('blipconfig:blip_titre_info'));
	echo '<input name="titre" type="text" id="titre" value="'.$formval['titre'].'" size="70" /> ';
	fin_cadre_relief();
	echo "<br />";
	echo "</div>\n";

	echo '<div id="Layer_descr" style="display: '.$display_descr.'; margin-top: 1px;">';
	debut_cadre_relief("", false, "", _T('blipconfig:blip_descriptif_info'));
	echo '<input name="descriptif" type="text" id="descriptif" value="'.$formval['descriptif'].'" size="70" />';
	fin_cadre_relief();
	echo "<br />";
	echo "</div>";	
	
	echo '<div id="Layer_texte" style="display: '.$display_texte.'; margin-top: 1px;">';
	debut_cadre_relief("", false, "", _T('blipconfig:blip_texte_info'));
	echo '<br /><textarea name="texte" type="text" id="texte" cols="50" rows="5">'.$formval['texte'].'</textarea>';
	fin_cadre_relief();
	echo "<br />";
	echo "</div>";


	echo '<div id="Layer_modules" style="display: '.$display_modules.'; margin-top: 1px;">';
	debut_cadre_relief("", false, "", _T('blipconfig:blip_modules_info'));
	echo BliP_generer_option_select('module', $blipconfig_modules, $formval['texte']);
	fin_cadre_relief();
	echo "<br />";
	echo "</div>";

	echo '<div id="Layer_pages" style="display: '.$display_pages.'; margin-top: 1px;">';
	debut_cadre_relief("", false, "", bouton_block_invisible('blip_pages')._T('blipconfig:blip_pages_info'));
	
	echo BliP_generer_option_select('page', $blipconfig_pages, $formval['texte']);
	echo '<b> n&deg; </b><input size="6" maxlength="6" name="id_item" type="text" id="id_item" value="'.$formval['id_item'].'" /><br />';
//    echo 'Parametre <input name="parametre" type="text" value="" size="5" />';
	echo debut_block_invisible('blip_pages');
	echo "<p>Exemple : Pour faire un lien vers l'article n°1, choisir 'article' dans le premier menu déroulant, et saisir '1' comme n&deg;.</p>";
	echo fin_block();
	fin_cadre_relief();
	echo "<br />";
	echo "</div>";

	echo '<div id="Layer_style" style="display: '.$display_style.'; margin-top: 1px;">';
	debut_cadre_relief("", false, "", _T('blipconfig:blip_style_info'));
	echo BliP_generer_option_select('style', $blipconfig_style, $formval['style']);
	fin_cadre_relief();
	echo "<br />";
	echo "</div>\n";

	echo "Actif : ";
	echo BliP_generer_option_select('actif', $blipconfig_actif, $formval['actif']);

	echo "<br /><div style='text-align:right;'>";

	if ($action=="editer") {
		echo '<input name="action" type="hidden" value="modifier" />';
		echo '<input type="submit" name="ajout" value="'._T('Appliquer les modifications').'" class="fondo">';
	} else { // Ajouter
		echo '<input name="action" type="hidden" value="ajouter" />';
		echo "<input type='submit' name='ajout' value='"._T('Ajouter ce nouvel element')."' class='fondo'>";
	}
	echo "</div><br /></form>";
}

function BliP_action_formulaire() {
	// TODO : vérifications d'usage de la validité des champs du formulaire
	// attention à ne par confondre les variables $_POST['action'] et $_GET['action']
	global $table_blip;
	if (isset($_POST['action'])) {
		$valeurs = BliP_initialiser_valeurs_formulaire();

		switch ($_POST['type']) {
			case 'lienpage' :
				$_POST['texte'] = $_POST['page'].$_POST['parametre'];
				break;
			case 'dynamique' :
				$_POST['texte'] = $_POST['module'];
				break;
			default :
		}

		// filtre antiparasite : ne retenir que les valeurs gérables par le système
		foreach ($_POST as $var => $val) {
			if (array_key_exists($var, $valeurs)) {
				$valeurs[$var] = spip_abstract_quote($val);
			}
		}
		// TODO : il doit exister une fonction dans spip ou ailleurs qui génère automatiquement une requète
		// en fonction d'un tableau d'association au lieu de faire ça manuellement comme ici
		$preliste_c = $preliste_v = array();
		foreach ($valeurs as $champ => $valeur) {
			if ($champ != 'id_config') {
				array_push($preliste_c, " `".$champ."`");
				array_push($preliste_v, $valeur);
			}
		}
		switch ($_POST['action']) {
			case 'ajouter' :
				$req  = "INSERT INTO `spip_blip` ( ";
				$req .= implode(",", $preliste_c);
				$req .= " ) VALUES ( ";
				$req .= implode(",", $preliste_v);
				$req .= " );";
			break;
			case 'modifier' :
				$req  = "UPDATE `spip_blip` SET ";
				$preliste = array();
				foreach ($preliste_c as $position => $champ) {
					array_push($preliste, $champ."=".$preliste_v[$position]);
				}
				$req .= implode(",", $preliste);
				$req .= " WHERE `id_config`=".$valeurs['id_config']." LIMIT 1;";
			break;
		}
		if (spip_query($req)) {
			echo "Modification effectu&eacute;e";
			echo "<br /><br /><a href='".generer_url_ecrire('blip')."'>Voir la configuration</a>";
			echo " | ";
			echo "<a href='".generer_url_ecrire('blip_modifier',"action=creer")."'>Ajouter un nouvel &eacute;l&egrave;ment</a>";
		} else {
			echo "ERREUR !!! La requete sql suivante a échoué:<br /><br />";
			echo $req;
		}
	}
}

function BliP_nom_module_lisible($nomfichier) {
	return ucfirst(preg_replace('/_/', ' ', preg_replace('/(^mod_)?(.*)\.html?/', '$2', $nomfichier)));
}

?>