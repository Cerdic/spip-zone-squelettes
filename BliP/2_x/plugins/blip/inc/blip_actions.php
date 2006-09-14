<?php

	// Toutes les fonctions ont étés regroupées ici.

	function BliP_version_ftp() {
	    return (2.3);
		// METTRE EGALEMENT A JOUR LA VERSION DU FICHIER plugin.xml
	}


	// Script de verification de l'existance de la base de donnée. Utilisé sur diverses pages
	function BliP_verifier_base() {
	    global $table_blip;
	    return (spip_query("SELECT * FROM `".$table_blip."`"));
	}

	// Script  d'installation de la table spip_blip et configuration par défaut du squelette. Utilisé sur exce=blip
	function BliP_installer_blip() {
		include_spip('inc/meta');
		ecrire_meta('blip_version', 2.3);
		ecrire_metas();
		BliP_installer_table();
		BliP_installer_configuration();
	}

	function BliP_installer_table() {
		// Installe la structure de la table blip - Processus différentié de celui des tables, comme ça en cas de platage on aura au moins la base.
		global $table_blip;
		$req = "
		CREATE TABLE `".$table_blip."` (
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
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'menu_principal', 0, 20, 'dynamique', '<multi>[fr]Rubriques[en]Sections[it]Rubriche[ca]Secci&oacute;</multi>', '<multi>[fr]Parcourir les rubriques du site[en]To traverse the section of the site[it]Per attraversare le rubriche del sito[ca]Fullejar les seccions del web</multi>', 'rubrique', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'menu_principal', 0, 30, 'dynamique', '<multi>[fr]Articles[en]Articles[it]Articoli[ca]Articles</multi>', '<multi>[fr]Liste des articles du site[en]List articles of the site[it]Lista degli articoli del sito[ca]Llistat d''articles del web</multi>', 'article', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'menu_principal', 0, 10, 'dynamique', '<multi>[fr]Actualit&eacute;[en]News[it]Notizie[ca]Actualitat</multi>', '<multi>[fr]Suivre l''actualit&eacute; de ce site[en]News of this site[it]Seguire le novita &agrave; del sito[ca]Seguir l''actualitat del lloc</multi>', 'sommaire', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'menu_principal', 0, 50, 'dynamique', '<multi>[fr]Auteurs[en]Authors[it]Autore[ca]Autors</multi>', '<multi>[fr]Liste des auteurs du site[en]List authors of the site[it]Elenco degli autori del sito[ca]Llistat d''autors del lloc</multi>', 'auteur', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'menu_principal', 0, 40, 'dynamique', '<multi>[fr]Mots-cl&eacute;s[en]Tags[it]Parole chiave[ca]Paraules clau</multi>', '<multi>[fr]Liste des mots-cl&eacute;s du site[en]Tags of the site[it]Parole chiave del sito[ca]Llistat de paraules clau del lloc web</multi>', 'mot', '', 'non');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'barre_laterale', 0, 20, 'dynamique', '-', '-', 'mod_rubriques_rubriques_liste', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'barre_laterale-sommaire', 0, 60, 'dynamique', '', '', 'mod_articles_liste5_parpopularite', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'barre_laterale-sommaire', 0, 50, 'dynamique', '-', '-', 'mod_forums_liste8_pardate', '-', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'barre_laterale-sommaire', 0, 70, 'dynamique', '', '', 'mod_articles_liste5_parmiseajour', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'barre_laterale-article', 0, 10, 'dynamique', '', '', 'mod_article_apropos', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'barre_laterale-article', 0, 5, 'dynamique', '', '', 'mod_article_memerubrique', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'barre_laterale', 0, 90, 'dynamique', '', '', 'mod_recherche', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'barre_laterale-recherche', 0, 95, 'dynamique', '', '', 'mod_rechercheexterne', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'barre_laterale', 0, 2, 'statique', 'Bonjour,', '', 'Votre site utilise le squelette modulaire <a href=\"http://www.cent20.net/spip.php?article100\">BliP</a>, et il semblerait que l\'installation se soit bien d&eacute;roul&eacute;e ;-)\r\n\r\nMaintenant, il ne vous reste plus qu\'&agrave;   d&eacute;sactiver les diff&eacute;rents messages affich&eacute;s un peu de partout, et &agrave;  lire le <a href=\"http://www.cent20.net/spip.php?rubrique81\">Guide de l\'administrateur</a> pour apprendre &agrave;  personnaliser le squelette BliP.\r\n\r\nPS : Pensez aussi &agrave; &eacute;crire et &agrave;  publier des articles pour que les diff&eacute;rentes fonctions du squelette s\'activent.\r\n\r\nAmusez-vous bien,\r\n\r\ncent20', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'mentions_techniques', 0, 50, 'statique', '', '', '<a href=\"spip.php?page=switch\">Oseriez-vous changer de couleurs ?</a>', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'surtitre', 0, 5, 'statique', 'Surtitre du site', '/ceci est une zone personnalisable/', 'Vous pouvez y afficher du texte et/ou y inclure des modules.', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'sous_titre', 0, 5, 'statique', 'Sous titre', '/ceci est une zone personnalisable/', 'Vous pouvez y afficher du texte et/ou y inclure des modules.', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'titre_lateral', 0, 5, 'statique', 'Titre lat&eacute;ral', '/ceci est une zone personnalisable/', 'Vous pouvez y afficher du texte et/ou y inclure des modules.', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'barre_laterale', 0, 5, 'statique', 'Barre lat&eacute;rale', '/ceci est une zone personnalisable/', 'Vous pouvez y afficher du texte et/ou y inclure des modules.', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'mentions_techniques', 0, 5, 'statique', 'Mentions techniques', '/ceci est une zone personnalisable/', 'Vous pouvez y afficher du texte et/ou y inclure des modules.', '', 'oui');";
		spip_query($req);
		$req = "INSERT INTO `".$table_blip."` VALUES ('', 'barre_laterale-sommaire', 0, 1, 'dynamique', '-', '-', 'mod_langue_site', '', 'oui');";
		spip_query($req);
	}


	// Script  de suppression de la table spip_blip. Utilisé sur exec=blip_effacer
	function BliP_supprimer_blip() {
	    BliP_supprimer_table();
		BliP_supprimer_meta();
	}

	function BliP_supprimer_table() {
		global $table_blip;
		$req = "DROP table `".$table_blip."`";
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
			include_spip('inc/meta');
			ecrire_meta('blip_version', 2.3);
			ecrire_metas();
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
				<td class='verdana2' style='text-align:center;'><b>".'Ordre'."</b></td>
				<td class='verdana2' style='text-align:center;'><b>".'Texte affich&eacute; <br /> ou fichier inclu'."</b></td>
				<td class='verdana2' style='text-align:center;'><b>".'Restriction d\'affichage'."</b></td>
				<td class='verdana2' style='text-align:center;'><b>".'Actif'."</b></td>
				<td class='verdana2' style='text-align:center;'><b>".'Options'."</b></td>
			</tr>\n";
		while ($elements = spip_fetch_array($res, SPIP_ASSOC)) {
    		$bgcolor = alterner($i++, '#eeeeee','white');
    		$restriction = explode("-", $elements['position']);
    		echo "<tr bgcolor='$bgcolor'><td style='text-align:center;'><b>".$elements['ordre']."</b></td>";
			if ($elements['type'] == 'statique') {
				echo "<td><b>".$elements['titre']."</b><br /><i>".$elements['descriptif']."</i><br />".$elements['texte']."</td>";
			} else {
				if ( $elements['position'] == 'menu_principal') {
				    echo "<td><b>".$elements['titre']."</b><br /><i>".$elements['descriptif']."</i><br />".$elements['texte'].".html</td>";
				} else {
				    echo "<td>".$elements['texte'].".html</td>";
				}
			}
			if ( $restriction[1] =='') {
				echo "<td style='text-align:center;'>aucune</td>";
			} else  {
				if ( $elements['id_item'] !='0') {
				    echo "<td style='text-align:center;'>".$restriction[1]."<br /> n° ".$elements['id_item']."</td>";
				} else if ( $elements['id_item'] =='0') {
				    echo "<td style='text-align:center;'>".$restriction[1]."</td>";
				}
			}

		    echo "<td style='text-align:center;'>".$elements['actif']."</td><td style='text-align:center;'>";
			if ( $elements['actif'] =='oui') {
				echo "<a href='".generer_url_ecrire('blip',"action=desactiver&id=".$elements['id_config'])."'>d&eacute;sactiver</a>";
			}elseif ( $elements['actif'] =='non') {
				echo "<a href='".generer_url_ecrire('blip',"action=activer&id=".$elements['id_config'])."'>activer</a>";
			}
			echo "<br /><a href='".generer_url_ecrire('blip_modifier',"action=editer&id=".$elements['id_config'])."'>modifier</a>";
			echo "<br /><a href='".generer_url_ecrire('blip',"action=supprimer&id=".$elements['id_config'])."'>supprimer</a>";
			echo "</td></tr>\n";
		    $index++;
	    }
		echo "</table></div>";

	}

	// SCRIPTS GENERANT LA CONFIGURATION ACTUELLE PAR ZONE. Utilisé sur exec=blip
	// LIKE car en fait, on peut mettre différent codes : surtitre, surtitre-article etc ... Ceci est géré par le squelette lui même.
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
	function BliP_afficher_configuration () {
		if (BliP_verifier_base()) {
    		echo "<br />";
    		BliP_afficher_config_surtitre ();
    		BliP_afficher_config_titre_principal ();
    		BliP_afficher_config_titre_lateral ();
    		BliP_afficher_config_sous_titre ();
    		BliP_afficher_config_barre_laterale ();
    		BliP_afficher_config_menu_principal ();
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
	function BliP_generer_option_select($nom, $valeurs, $actif="") {
	    $s  = '<select name="'.$nom.'" id="'.$nom.'">';
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
    //Valeurs par défaut, je les ai complété je pense que c'est ce que tu voulais que je fasse.
    $blipconfig_item = array(
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
	function BliP_generer_formulaire($action) {
    $blipconfig_menutypes = array(
        'dynamique' => "Inclure un module",
        'statique' => "Afficher du texte"
    );

    $blipconfig_positions = array(
        'surtitre' => "Surtitre",
		'surtitre-sommaire' => "Surtitre - Restreindre aux pages 'sommaire'",
		'surtitre-recherche' => "Surtitre - Restreindre aux pages de recherche",
		'surtitre-article' => "Surtitre - Restreindre aux pages 'articles'",
		'surtitre-rubrique' => "Surtitre - Restreindre aux pages 'rubriques'",
		'surtitre-auteur' => "Surtitre - Restreindre aux pages 'auteurs'",
		'surtitre-mot' => "Surtitre - Restreindre aux pages 'mots cl&eacute;s'",
		'titre_principal' => "Titre du site",
		'titre_principal-sommaire' => "Titre - Restreindre aux pages 'sommaire'",
		'titre_principal-recherche' => "Titre - Restreindre aux pages de recherche",
		'titre_principal-article' => "Titre - Restreindre aux pages 'articles'",
		'titre_principal-rubrique' => "Titre - Restreindre aux pages 'rubriques'",
		'titre_principal-auteur' => "Titre - Restreindre aux pages 'auteurs'",
		'titre_principal-mot' => "Titre - Restreindre aux pages 'mots cl&eacute;s'",
		'sous_titre' => "Sous titre",
		'sous_titre-sommaire' => "Sous titre - Restreindre aux pages 'sommaire'",
		'sous_titre-recherche' => "Sous titre - Restreindre aux pages de recherche",
		'sous_titre-article' => "Sous titre - Restreindre aux pages 'articles'",
		'sous_titre-rubrique' => "Sous titre - Restreindre aux pages 'rubriques'",
		'sous_titre-auteur' => "Sous titre - Restreindre aux pages 'auteurs'",
		'sous_titre-mot' => "Sous titre - Restreindre aux pages 'mots cl&eacute;s'",
		'titre_lateral' => "Titre lat&eacute;ral",
		'titre_lateral-sommaire' => "Titre lat&eacute;ral - Restreindre aux pages 'sommaire'",
		'titre_lateral-recherche' => "Titre lat&eacute;ral - Restreindre aux pages de recherche",
		'titre_lateral-article' => "Titre lat&eacute;ral - Restreindre aux pages 'articles'",
		'titre_lateral-rubrique' => "Titre lat&eacute;ral - Restreindre aux pages 'rubriques'",
		'titre_lateral-auteur' => "Titre lat&eacute;ral - Restreindre aux pages 'auteurs'",
		'titre_lateral-mot' => "Titre lat&eacute;ral - Restreindre aux pages 'mots cl&eacute;s'",
		'menu_principal' => "Menu principal de navigation",
		'barre_laterale' => "Barre laterale",
		'barre_laterale-sommaire' => "Barre lat&eacute;rale - Restreindre aux pages 'sommaire'",
		'barre_laterale-recherche' => "Barre lat&eacute;rale - Restreindre aux pages de recherche",
		'barre_laterale-article' => "Barre lat&eacute;rale - Restreindre aux pages 'articles'",
		'barre_laterale-rubrique' => "Barre lat&eacute;rale - Restreindre aux pages 'rubriques'",
		'barre_laterale-auteur' => "Barre lat&eacute;rale - Restreindre aux pages 'auteurs'",
		'barre_laterale-mot' => "Barre lat&eacute;rale - Restreindre aux pages 'mots cl&eacute;s'",
		'mentions_techniques' => "Mentions techniques",
		'mentions_techniques-sommaire' => "Mentions techniques - Restreindre aux pages 'sommaire'",
		'mentions_techniques-recherche' => "Mentions techniques - Restreindre aux pages de recherche",
		'mentions_techniques-article' => "Mentions techniques - Restreindre aux pages 'articles'",
		'mentions_techniques-rubrique' => "Mentions techniques - Restreindre aux pages 'rubriques'",
		'mentions_techniques-auteur' => "Mentions techniques - Restreindre aux pages 'auteurs'",
		'mentions_techniques-mot' => "Mentions techniques - Restreindre aux pages 'mots cl&eacute;s'"

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
    );

    $formval = BliP_initialiser_valeurs_formulaire();

    echo '<form name="form1" id="form1" method="post" action="'.generer_url_ecrire('blip_modifier',"action=formulaire").'">';
	echo '<input name="id_config" type="hidden" id="id_config" value="'.$formval['id_config'].'" />';

	echo "<p>Cliquer sur les triangles pour d&eacute;velopper l'aide des formulaires <br />";
	echo "<b>i :</b> Information | <b>r :</b> Restrictions | <b>c :</b> Conseils</p>";

	debut_cadre_relief("", false, "", bouton_block_invisible('blip_position')._T('blipconfig:blip_position_info'));
    echo BliP_generer_option_select('type', $blipconfig_menutypes, $formval['type']);
	echo debut_block_invisible('blip_position');
	echo "<p><b>c : </b>L'option 'Afficher du texte' ne doit pas &ecirc;tre utilis&eacute; en remplacement des articles ou br&egrave;ves, mais pour des messages ponctuels et/ou cibl&eacute;</p>";
	echo fin_block();
	fin_cadre_relief();
	echo "<br />";

	debut_cadre_relief("", false, "", bouton_block_invisible('blip_restriction')._T('blipconfig:blip_restriction_info'));
    echo BliP_generer_option_select('position', $blipconfig_positions, $formval['position']);
	echo debut_block_invisible('blip_restriction');
	echo "<br />";
	echo '<b>2.1 Restreindre l\'affichage &agrave; l\'ID n&deg; </b><input size="6" maxlength="6" name="id_item" type="text" id="id_item" value="'.$formval['id_item'].'" /><br />';
	echo '<b>2.2 Ordre de positionnement dans le flux </b><input size="2" maxlength="2" name="ordre" type="text" id="ordre" value="'.$formval['ordre'].'" /> ';
	echo "<p><b>i : </b>Choisissez le positionnement de votre &eacute;l&egrave;ment de configuration. Pour plus d'information, reportez vous aux exemples de la documentation de BliP</p>";
	echo fin_block();
	fin_cadre_relief();
	echo "<br />";

	debut_cadre_relief("", false, "", bouton_block_invisible('blip_titre')._T('blipconfig:blip_titre_info'));
    echo '<input name="titre" type="text" id="titre" value="'.$formval['titre'].'" size="45" /> ';
	echo debut_block_invisible('blip_titre');
	echo "<p><b>i : </b>Si vous avez s&eacute;lectionn&eacute; 'Afficher du texte' au point 1. alors saisissez votre titre ici, il sera affich&eacute; en gras.</p>";
	echo "<p><b>i : </b>Si vous avez s&eacute;lectionn&eacute; 'Inclure un module' au point 1. et 'Menu principal de navigation' au point 2, alors saisissez ici le texte qui apparaitra dans le menu de navigation</p>";
	echo "<p><b>r : </b>Utilis&eacute; uniquement si l'un des deux cas ci-dessus est rempli.</p>";
	echo fin_block();
	fin_cadre_relief();
	echo "<br />";

	debut_cadre_relief("", false, "", bouton_block_invisible('blip_descriptif')._T('blipconfig:blip_descriptif_info'));
 	echo '<input name="descriptif" type="text" id="descriptif" value="'.$formval['descriptif'].'" size="45" />';
	echo debut_block_invisible('blip_descriptif');
	echo "<p><b>i : </b>Si vous avez s&eacute;lectionn&eacute; 'Afficher du texte' au point 1. alors saisissez votre descriptif ici, il sera affich&eacute; en italique.</p>";
	echo "<p><b>i : </b>Si vous avez s&eacute;lectionn&eacute; 'Inclure un module' au point 1. et 'Menu principal de navigation' au point 2, alors saisissez ici le texte qui apparaitra au survol du menu de navigation</p>";
	echo "<p><b>r : </b>Utilis&eacute; uniquement si l'un des deux cas ci-dessus est rempli.</p>";
	echo fin_block();
	fin_cadre_relief();
	echo "<br />";

	debut_cadre_relief("", false, "", bouton_block_invisible('blip_texte')._T('blipconfig:blip_texte_info'));
 	echo '<textarea name="texte" type="text" id="texte" cols="45" rows="5">'.$formval['texte'].'</textarea>';
	echo debut_block_invisible('blip_texte');
	echo "<p><b>i : </b>Si vous avez s&eacute;lectionn&eacute; 'Afficher du texte' au point 1. alors saisissez votre texte ici.</p>";
	echo "<p><b>i : </b>Si vous avez s&eacute;lectionn&eacute; 'Inclure un module' au point 1. alors saisissez le nom de votre fichier html, sans son extension.
			<br />Le fichier html en question doit se trouver dans le dossier 'blip'.";
	echo fin_block();
	fin_cadre_relief();
	echo "<br />";

	debut_cadre_relief("", false, "", bouton_block_invisible('blip_style')._T('blipconfig:blip_style_info'));
 	echo BliP_generer_option_select('style', $blipconfig_style, $formval['style']);
	echo debut_block_invisible('blip_style');
	echo "<p><b>i : </b>Applique un &eacute;l&egrave;ment de style.</p>";
	echo "<p><b>r : </b>Utilis&eacute; uniquement si le point 1. est 'Afficher du texte'.</p>";
	echo "<p><b>c : </b>N'abuser pas de styles (...)'</p>";
	echo fin_block();
	fin_cadre_relief();

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
                $req  = "INSERT INTO `".$table_blip."` ( ";
                $req .= implode(",", $preliste_c);
                $req .= " ) VALUES ( ";
                $req .= implode(",", $preliste_v);
                $req .= " );";
            break;
            case 'modifier' :
                $req  = "UPDATE `".$table_blip."` SET ";
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
?>
