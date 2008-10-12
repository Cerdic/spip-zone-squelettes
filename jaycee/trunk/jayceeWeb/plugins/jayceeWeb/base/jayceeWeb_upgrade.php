<?php
/*
 * jayceeWeb 2008
 * Auteurs :
 * Stéphane Gautreau (c) 2007
 *   
 * Antoine Pitrou, Cedric Morin, Renato
 * (c) 2005,2006 - Distribue sous licence GNU/GPL
 *
 *Configurateur Squelette Epona - 2004 Nov 10 - Marc Lebas.
 *RealET : real3t@gmail.com  
 *
 */
	
	$GLOBALS['jaycee_base_version'] = 0.9;
	
//
// Fonctions pour mot-clés
//

function id_groupe($titre) {
	if (version_compare($GLOBALS['spip_version_code'],'1.9300','<')) { // SPIP <= 1.9.2x 
		$result = spip_query("SELECT id_groupe FROM spip_groupes_mots WHERE titre='$titre'");
		if ($row = spip_fetch_array($result)) return $row['id_groupe'];

	} elseif (version_compare($GLOBALS['spip_version_code'],'1.9300','>=')) { 
		$result= sql_select( 'id_groupe', 'spip_groupes_mots', "titre='$titre'");
		if ($row = sql_fetch($result)) return $row['id_groupe'];
	};
		
	return 0;
}

function id_mot($titre) {
	if (version_compare($GLOBALS['spip_version_code'],'1.9300','<')) { // SPIP <= 1.9.2x 
		$result = spip_query("SELECT id_mot FROM spip_mots WHERE titre='$titre'");
		if ($row = spip_fetch_array($result)) return $row['id_mot'];

	} elseif (version_compare($GLOBALS['spip_version_code'],'1.9300','>=')) { 
		$result = sql_select( 'id_mot', 'spip_mots', "titre='$titre'");
		if ($row = sql_fetch($result)) return $row['id_mot'];
	}
	
	return 0;
}


function id_rubrique($titre, $id_parent = 0) {
	if (version_compare($GLOBALS['spip_version_code'],'1.9300','<')) { // SPIP <= 1.9.2x 
		$result = spip_query("SELECT id_rubrique FROM spip_rubriques WHERE titre='$titre'".(id_parent==0 ? '' : " AND id_parent = $id_parent"));
		if ($row = spip_fetch_array($result)) return $row['id_rubrique'];
	
	} else if (version_compare($GLOBALS['spip_version_code'],'1.9300','>=')) { 
		$result = sql_select( 'id_rubrique', 'spip_rubriques', "titre='$titre'".(id_parent==0 ? '' : " AND id_parent = $id_parent"));
		if ($row = sql_fetch($result)) return $row['id_rubrique'];
	}
	
	return 0;
}


function id_article($titre, $id_parent = 0, $id_article= 0) {
	if (version_compare($GLOBALS['spip_version_code'],'1.9300','<')) { // SPIP <= 1.9.2x 
		$result = spip_query(
			"SELECT id_article FROM spip_articles WHERE true "
			.(id_parent==0 ? '' : " AND id_parent = $id_parent")
			.(id_article==0 ? " AND titre='$titre'" : " AND id_article = $id_article")
			);
		if ($row = spip_fetch_array($result)) return $row['id_article'];
	
	} elseif (version_compare($GLOBALS['spip_version_code'],'1.9300','>=')) {	
		$result = sql_select( 'id_article', 'spip_articles', "true "
			.(id_parent==0 ? '' : " AND id_parent = $id_parent")
			.(id_article==0 ? " AND titre='$titre'" : " AND id_article = $id_article")
			);
		if ($row = sql_fetch($result)) return $row['id_article'];
	}
	return 0;
}


function create_groupe( $groupe, $descriptif='', $texte='', $unseul='non', $obligatoire='non', $tables_liees='articles', $minirezo='oui', $comite='oui', $forum='non') {
	$groupe = importer_charset($groupe);
	$id_groupe = id_groupe($groupe);
	$texte = importer_charset($texte);
	$descriptif = importer_charset($descriptif);
	if ($id_groupe == 0) {
		//Création groupe + mots clé
		if (version_compare($GLOBALS['spip_version_code'],'1.9300','<')) { // SPIP <= 1.9.2x 
			$query = "INSERT INTO spip_groupes_mots SET titre='$groupe', descriptif='$descriptif', texte='$texte', unseul='$unseul', obligatoire='$obligatoire',
				articles='$articles', breves='$breves', rubriques='$rubriques', syndic='$syndic',
				minirezo='$minirezo', comite='$comite', forum='$forum'";
			spip_query($query);
			$id_groupe = spip_insert_id(); 

		} elseif (version_compare($GLOBALS['spip_version_code'],'1.9300','>=')) {	
			$id_groupe = sql_insertq( 'spip_groupes_mots', array( 
				'titre'=>$groupe, 'descriptif'=>$descriptif, 'texte'=>$texte, 
				'unseul'=>$unseul, 'obligatoire'=>$obligatoire, 'tables_liees'=>$tables_liees,		
				'minirezo'=>$minirezo, 'comite'=>$comite, 'forum'=>$forum));
		}
	} else {
		if (version_compare($GLOBALS['spip_version_code'],'1.9300','<')) { // SPIP <= 1.9.2x 
			spip_query("UPDATE spip_groupes_mots SET descriptif='$descriptif', texte='$texte', unseul='$unseul', obligatoire='$obligatoire',
				articles='$articles', breves='$breves', rubriques='$rubriques', syndic='$syndic', 
				minirezo='$minirezo', comite='$comite', forum='$forum' WHERE id_groupe=$id_groupe"); 
				
		} elseif (version_compare($GLOBALS['spip_version_code'],'1.9300','>=')) {	
				sql_update( 'spip_groupes_mots', array( 
				'descriptif'=>$descriptif, 'texte'=>$texte, 
				'unseul'=>$unseul, 'obligatoire'=>$obligatoire, 'tables_liees'=>$tables_liees, 
				'minirezo'=>$minirezo, 'comite'=>$comite, 'forum'=>$forum),
				'WHERE id_groupe='.sql_quote($id_groupe));
		}				
	}
	$groupe = stripslashes($groupe);
	echo "<h4><a href='?exec=mots_type&id_groupe=$id_groupe'>Grp&nbsp;$id_groupe:</a> $groupe</h4>";
	return $id_groupe;
}

function create_mot($groupe, $mot, $descriptif='', $texte='') {
	$groupe = importer_charset($groupe);
	$id_groupe=id_groupe($groupe);
	$mot = importer_charset($mot);
	$texte = importer_charset($texte);
	$descriptif = importer_charset($descriptif);
	if ($id_groupe != 0) {
		$id_mot=id_mot($mot);
		if ($id_mot == 0 ) {
			if (version_compare($GLOBALS['spip_version_code'],'1.9300','<')) { // SPIP <= 1.9.2x 
				spip_query("INSERT INTO spip_mots (type, titre, id_groupe, descriptif, texte) VALUES ('$groupe', '$mot', '$id_groupe', '$descriptif', '$texte')");
				$id_mot = spip_insert_id();
				
			} elseif (version_compare($GLOBALS['spip_version_code'],'1.9300','>=')) {	
			$id_mot = sql_insertq( 'spip_mots', array( 
				'type'=>$groupe, 'titre'=>$mot, 'id_groupe'=>$id_groupe, 'descriptif'=>$descriptif, 'texte'=>$texte));
			}
		} else {
			// Mise à jour
			if (version_compare($GLOBALS['spip_version_code'],'1.9300','<')) { // SPIP <= 1.9.2x 
				spip_query("UPDATE spip_mots SET type='$groupe', id_groupe='$id_groupe', descriptif='$descriptif', texte='$texte' WHERE id_mot=$id_mot");
			
			} elseif (version_compare($GLOBALS['spip_version_code'],'1.9300','>=')) {	
				sql_update( 'spip_mots', array(
					'type'=>$groupe, 'id_groupe'=>$id_groupe, 'descriptif'=>$descriptif, 'texte'=>$texte),
					"WHERE id_mot=$id_mot");
			}
		}
	}
	$mot = stripslashes($mot);
	echo "<p><a href='?exec=mots_edit&id_mot=$id_mot&redirect=%3Fexec%3Dmots_tous'>Mot&nbsp;$id_mot:</a> $mot</p>";
	return $id_mot;
}


function create_rubrique($titre, $id_parent='0', $descriptif='') {
	$id_rubrique = id_rubrique($titre, $id_parent);
	if ($id_rubrique==0) {
		$titre = importer_charset($titre);
		$descriptif = importer_charset($descriptif);
		if (version_compare($GLOBALS['spip_version_code'],'1.9300','<')) { // SPIP <= 1.9.2x 
			$query="INSERT INTO spip_rubriques (titre, id_parent, descriptif) VALUES ('$titre', '$id_parent', '$descriptif')";
			spip_query($query);
			$id_rubrique = spip_insert_id();
				
		} elseif (version_compare($GLOBALS['spip_version_code'],'1.9300','>=')) {	
			$id_rubrique = sql_insertq( 'spip_rubriques', array(
				'titre'=>$titre, 'id_parent'=>$id_parent, 'descriptif'=>$descriptif));
		}
	} else {
		if (version_compare($GLOBALS['spip_version_code'],'1.9300','<')) { // SPIP <= 1.9.2x 
			// Pas implémenté... à faire !
		
		} elseif (version_compare($GLOBALS['spip_version_code'],'1.9300','>=')) {	
			sql_update( 'spip_rubriques', array(
				'titre'=>$titre, 'id_parent'=>$id_parent, 'descriptif'=>$descriptif),
				"WHERE id_rubrique=$id_rubrique");
		}
	}
	$titre = stripslashes($titre);
	echo "<p><a href='?exec=naviguer&id_rubrique=$id_rubrique'>Rub&nbsp;$id_rubrique:</a> $titre</p>";

	return $id_rubrique;
}

function create_rubrique_mot( $id_rubrique=0, $id_mot=0) {
	if ($id_rubrique!=0 && $id_mot!=0) {
		if (version_compare($GLOBALS['spip_version_code'],'1.9300','<')) { // SPIP <= 1.9.2x 
			// Pas implémenté... à faire !
		
		} elseif (version_compare($GLOBALS['spip_version_code'],'1.9300','>=')) {	
			if (sql_countsel( 'spip_mots_rubriques', "(id_rubrique = '$id_rubrique') AND (id_mot = '$id_mot')") == 0) {
				$lbInsert = sql_insertq( 'spip_mots_rubriques', array(
					'id_mot'=>$id_mot, 'id_rubrique'=>$id_rubrique));
			}
		}
	}
	
	if ($lbInsert) echo "<p>Mot <a href='?exec=mots_edit&id_mot=$id_mot&redirect=%3Fexec%3Dmots_tous'>$id_mot</a> sur&nbsp;Rub <a href='?exec=naviguer&id_rubrique=$id_rubrique'>$id_rubrique</a></p>";
	return TRUE;
}


function create_article($titre, $id_rubrique='0', $id_secteur='0', $texte='', $id_article= 0, $lang= 'fr') {
	$id_article = id_article($titre, $id_rubrique, $id_article);
	if ($id_article==0) {
		$titre = importer_charset($titre);
		$texte = importer_charset($texte);
		
		if (version_compare($GLOBALS['spip_version_code'],'1.9300','<')) { // SPIP <= 1.9.2x 
			// Pas implémenté... à faire !
		
		} elseif (version_compare($GLOBALS['spip_version_code'],'1.9300','>=')) {	
			$id_article = sql_insertq( 'spip_articles', array(
				'titre'=>$titre, 'id_rubrique'=>$id_rubrique, 
				'texte'=>$texte, 'statut'=>'publie', 'id_secteur'=>$id_secteur, 
				'date'=> date('Y-m-d H:i:s'), 'accepter_forum'=>'non', 'lang'=>$lang));
		}		
		$titre = stripslashes($titre);
		echo "<p><a href='?exec=naviguer&id_article=$id_article'>Art&nbsp;$id_article:</a> $titre</p>";
	}
	return $id_article;
}

function create_article_mot( $id_article=0, $id_mot=0) {
	if ($id_article!=0 && $id_mot!=0) {
		if (version_compare($GLOBALS['spip_version_code'],'1.9300','<')) { // SPIP <= 1.9.2x 
			// Pas implémenté... à faire !
		
		} elseif (version_compare($GLOBALS['spip_version_code'],'1.9300','>=')) {	
			if (sql_countsel( 'spip_mots_articles', "(id_article = '$id_article') AND (id_mot = '$id_mot')") == 0) {
				$lbInsert = sql_insertq( 'spip_mots_articles', array(
					'id_mot'=>$id_mot, 'id_article'=>$id_article));
			}
		}
	}

	if ($lbInsert) echo "<p>Mot <a href='?exec=mots_edit&id_mot=$id_mot&redirect=%3Fexec%3Dmots_tous'>$id_mot</a> sur&nbsp;Art <a href='?exec=naviguer&id_rubrique=$id_article'>$id_article</a></p>";
	return TRUE;
}

 
function jayceeWeb_upgrade(){

		$version_base = $GLOBALS['jaycee_base_version'];
		$current_version = 0.0;

		if (   (isset($GLOBALS['meta']['jaycee_base_version']) )
				&& (($current_version = $GLOBALS['meta']['jaycee_base_version'])==$version_base))
			return;

		echo "<div class='cadre-info verdana1'>";
		
		if ($current_version<0.6){
		
		// !!!! 	PAS d'apostrophes dans les descriptifs cause SQL
		
		// ************* Création du groupe et mots-clés
			create_groupe( $groupe='_SYSTEME_RUBRIQUES', 
				$descriptif="Mots clés attachés aux rubriques pour la gestion du site",
				$texte="", $unseul='non', $obligatoire='non', $tables_liees='rubriques', 
				$minirezo='oui', $comite='oui', $forum='non'
				);
				
			$liMotMasquerRubrique =
				create_mot( $groupe='_SYSTEME_RUBRIQUES',	$mot="_MASQUER_RUBRIQUE", 
					$descriptif='Rubrique non visible sur site public', 
					$texte='');
			$liMotRubAnnonces =							
				create_mot( $groupe='_SYSTEME_RUBRIQUES',	$mot="_RUB_ANNONCES", 
					$descriptif='Identifie la rubrique source des annonces (brèves)', 
					$texte='');							
					
		// ************* Création du groupe et mots-clés
			create_groupe( $groupe='_SYSTEME_ARTICLES', 
				$descriptif="Mots clés attachés aux articles pour la gestion du site",
				$texte="", $unseul='non', $obligatoire='non', $tables_liees='articles', 
				$minirezo='oui', $comite='oui', $forum='non'
				);
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_AFFICHER_ABONNEMENT', 
					$descriptif="Affiche un bulletin d’abonnement à SPIP-Listes", 
					$texte="");							
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_AFFICHER_ACTUALITES', 
					$descriptif="Affiche ’à la une’ les Chapos des articles _source_Actualite", 
					$texte="");							
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_AFFICHER_ACTUALITES_SYNDICATION', 
					$descriptif="Affiche les résumés des sites _source_Actualite_Externe", 
					$texte="");							
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_AFFICHER_AGENDA_LOCAL', 
					$descriptif="Affiche les annonces futures toutes rubriques confondues", 
					$texte="");							
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_AFFICHER_AGENDA_SYNDICATION', 
					$descriptif="Affiche l’agenda des sites _source_Agenda", 
					$texte="");							
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_AFFICHER_ANNONCES_PASSE', 
					$descriptif="Affiche les annonces passées, classées par rubrique", 
					$texte="");							
			$liMotEcrire = 
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_AFFICHER_ECRIRE_AUTEURS', 
					$descriptif="Affiche un formulaire pour envoi de mail aux auteurs", 
					$texte="");							
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_AFFICHER_EDITOS', 
					$descriptif="Affiche l’intro des éditos définis par _source_Edito", 
					$texte="");							
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_AFFICHER_MINI_CALENDRIER', 
					$descriptif="Affiche le mini calendrier du Plugin Agenda", 
					$texte="");							
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_AFFICHER_PARTENAIRES', 
					$descriptif="Affiche le corps des articles définis par _source_Partenaire", 
					$texte="");							
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_MASQUER_ARTICLE', 
					$descriptif="Masque l’article dans le site public", 
					$texte="Normalement, inutile. Masquer un article en commençant le titre par un point");							
			$liMotMasquerMenuRub =
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_MASQUER_MENU_RUBRIQUE', 
					$descriptif="Masque le sous-menu de la rubrique", 
					$texte="Typiquement sur la page d'accueil");							
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_META_DATAS', 
					$descriptif="Utilise les infos de l'article (à masquer) pour mettre à jour les meta-data HTML", 
					$texte="");							
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_source_Actualite', 
					$descriptif="Utilise cet article pour le mettre à la une par _AFFICHER_ACTUALITES", 
					$texte="");							
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_source_Contact', 
					$descriptif="Utilise cet article pour le menu CONTACT du menu déroulant", 
					$texte="");							
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_source_Edito', 
					$descriptif="Utilise cet article pour l'afficher en édito par _AFFICHER_EDITOS", 
					$texte="");							
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_source_Partenaire', 
					$descriptif="Utilise cet article pour afficher les partenaires par _AFFICHER_PARTENAIRES", 
					$texte="Typiquement, contient des logos et des liens");							

		// ************* Création du groupe et mots-clés
			create_groupe( $groupe='_SYSTEME_SITES', 
				$descriptif="Mots clés attachés aux Sites pour la gestion du site",
				$texte="", $unseul='non', $obligatoire='non', $tables_liees='syndic,sites', 
				$minirezo='oui', $comite='oui', $forum='non'
				);
				create_mot( $groupe='_SYSTEME_SITES',	$mot='_source_Actualite_externe', 
					$descriptif="Utilise ce site pour afficher ses annonces RSS par _AFFICHER_ACTUALITE_SYNDICATION", 
					$texte="");							
				create_mot( $groupe='_SYSTEME_SITES',	$mot='_source_Agenda', 
					$descriptif="Utilise ce site pour afficher son agenda en local par _AFFICHER_AGENDA_SYNDICATION", 
					$texte="");							
				create_mot( $groupe='_SYSTEME_SITES',	$mot='_source_Menus', 
					$descriptif="Utilise ce site pour intégrer son menu déroulant dans le site local", 
					$texte="");							

		// ************* Création du groupe et mots-clés
			create_groupe( $groupe='_SYSTEME_META', 
				$descriptif="Mots clés attachés aux objets pour la gestion des entêtes HTML",
				$texte="", $unseul='non', $obligatoire='non', $tables_liees='articles,rubriques',
				$minirezo='oui', $comite='oui', $forum='non'
				);
				create_mot( $groupe='_SYSTEME_META',	$mot="_MaJ-1_Heure", 
					$descriptif='Période de visite par robot demandée',	$texte='');							
				create_mot( $groupe='_SYSTEME_META',	$mot="_MaJ-3_Jour", 
					$descriptif='Période de visite par robot demandée',	$texte='');							
				create_mot( $groupe='_SYSTEME_META',	$mot="_MaJ-4_qqJours", 
					$descriptif='Période de visite par robot demandée',	$texte='');							
				create_mot( $groupe='_SYSTEME_META',	$mot="_MaJ-5_Semaine", 
					$descriptif='Période de visite par robot demandée',	$texte='');		
			$liMotMaJ6 = 					
				create_mot( $groupe='_SYSTEME_META',	$mot="_MaJ-6_Quinzaine", 
					$descriptif='Période de visite par robot demandée',	$texte='');							
			$liMotMaJ7 = 					
				create_mot( $groupe='_SYSTEME_META',	$mot="_MaJ-7_Mois", 
					$descriptif='Période de visite par robot demandée',	$texte='');							
				create_mot( $groupe='_SYSTEME_META',	$mot="_MaJ-8_Trimestre", 
					$descriptif='Période de visite par robot demandée',	$texte='');							
				create_mot( $groupe='_SYSTEME_META',	$mot="_MaJ-9_Annee", 
					$descriptif='Période de visite par robot demandée',	$texte='');							

		// ************* Création des rubriques de base
			echo "<h4>Rubriques :</h4>";
			$liRubFr = create_rubrique( $titre='fr', $id_parent='0', 
				$descriptif="Articles francophones"); 
				create_rubrique_mot( $liRubFr, $liMotMaJ6); 
			$liRubEn = create_rubrique( $titre='en', $id_parent='0', 
				$descriptif="Articles in english");
				create_rubrique_mot( $liRubEn, $liMotMaJ7); 
			$liRubEs = create_rubrique( $titre='es', $id_parent='0', 
				$descriptif="Articulos en castellano");
				create_rubrique_mot( $liRubEs, $liMotMaJ7); 

				$liRubFrAsso = 
					create_rubrique( $titre='Association', $id_parent=$liRubFr, 
						$descriptif="Association");

				$liRubFrAnnonces = 
					create_rubrique( $titre='_ANNONCES', $id_parent=$liRubFr, 
						$descriptif="Annonces pour agenda");
					create_rubrique_mot( $liRubFrAnnonces, $liMotRubAnnonces); 
					create_rubrique( $titre='Commissions', $id_parent=$liRubFrAnnonces, 
						$descriptif="Réunions de Commission"); 
					create_rubrique( $titre='Actions', $id_parent=$liRubFrAnnonces, 
						$descriptif="Invitations aux Actions publiques "); 
					create_rubrique( $titre='Formations', $id_parent=$liRubFrAnnonces, 
						$descriptif="Formations diverses"); 
					create_rubrique( $titre='Rencontres', $id_parent=$liRubFrAnnonces, 
						$descriptif="Invitations aux congrès"); 
					create_rubrique( $titre='Assemblées', $id_parent=$liRubFrAnnonces, 
						$descriptif="Invitations aux Assemblées Générales et diverses"); 



			echo "<h4>Articles :</h4>";
		$liArtAccueil =
			create_article( $titre='Accueil', 
				$id_rubrique=$liRubFr, $id_secteur=$liRubFr, 
				$texte='Bienvenue sur le nouveau site', 
				$id_article = 1);
			create_article_mot( $liArtAccueil, $liMotMasquerMenuRub);				

		$liArtContact =
			create_article( $titre='Nous contacter', 
				$id_rubrique=$liRubFrAsso, $id_secteur=$liRubFr, 
				$texte='Formulaire de contact :');

			create_article_mot( $liArtContact, $liMotEcrire);

			echo "<h4>Activation des fonctionnalités SPIP 2</h4>";
			echo '<ul>';
			ecrire_meta('articles_mots', 'oui'); echo "<li>Mots-clés sur articles</li>"; 
			ecrire_meta('articles_mots', 'oui');
			echo '</ul>';

			echo "<h4>jaycee  update @ 0.9 / Octobre 2008</h4>";
			ecrire_meta('jaycee_base_version',$current_version=0.9);
		}

		echo "</div>";

		ecrire_metas();
	}
	
function jayceeWeb_disable(){
		effacer_meta('jaycee_base_version');
		ecrire_metas();
	}
		
function jayceeWeb_install($action){
		global $jaycee_base_version;
		switch ($action){
			case 'test':
				//echo "*TEST*";
				return (isset($GLOBALS['meta']['jaycee_base_version']) AND ($GLOBALS['meta']['jaycee_base_version']>=$jaycee_base_version));
				break;
			case 'install':
				jayceeWeb_upgrade();
				break;
			case 'uninstall':
				jayceeWeb_disable();
				break;
		}
	}	
?>
