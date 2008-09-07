<?php
/*
 * jaycee 2007
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
	
	$GLOBALS['jaycee_base_version'] = 0.5;

//
// Fonctions pour mot-clés
//
function id_groupe($titre) {
	$result = spip_query("SELECT id_groupe FROM spip_groupes_mots WHERE titre='$titre'");
	if ($row = spip_fetch_array($result)) return $row['id_groupe'];
	return 0;
}

function id_mot($titre) {
	$result = spip_query("SELECT id_mot FROM spip_mots WHERE titre='$titre'");
	if ($row = spip_fetch_array($result)) return $row['id_mot'];
	return 0;
}

function id_rubrique($titre, $id_parent = 0) {
	$result = spip_query("SELECT id_rubrique FROM spip_rubriques WHERE titre='$titre'".(id_parent==0 ? '' : " AND id_parent = $id_parent"));
	if ($row = spip_fetch_array($result)) return $row['id_rubrique'];
	return 0;
}

/*
function id_article($titre, $id_parent = 0, $id_article= 0) {
	$result = spip_query(
		"SELECT id_rubrique FROM spip_rubriques WHERE true "
		.(id_parent==0 ? '' : " AND id_parent = $id_parent")
		.(id_article==0 ? " AND titre='$titre'" : " AND id_article = $id_article")
		);
	if ($row = spip_fetch_array($result)) return $row['id_rubrique'];
	return 0;
}
*/

function create_groupe($groupe, $descriptif='', $texte='', $unseul='non', $obligatoire='non', $articles='oui', $breves='non', $rubriques='non', $syndic='non', $minirezo='oui', $comite='oui', $forum='non') {
	$groupe = importer_charset($groupe);
	$id_groupe=id_groupe($groupe);
	$texte = importer_charset($texte);
	$descriptif = importer_charset($descriptif);
	if ($id_groupe == 0) {
		//Création groupe + mots clé
		$query = "INSERT INTO spip_groupes_mots SET titre='$groupe', descriptif='$descriptif', texte='$texte', unseul='$unseul', obligatoire='$obligatoire',
			articles='$articles', breves='$breves', rubriques='$rubriques', syndic='$syndic',
			minirezo='$minirezo', comite='$comite', forum='$forum'";
		//echo $query;
		spip_query($query);
		$id_groupe = spip_insert_id();
	} else {
		// Mise à jour
		spip_query("UPDATE spip_groupes_mots SET descriptif='$descriptif', texte='$texte', unseul='$unseul', obligatoire='$obligatoire',
			articles='$articles', breves='$breves', rubriques='$rubriques', syndic='$syndic', 
			minirezo='$minirezo', comite='$comite', forum='$forum' WHERE id_groupe=$id_groupe");
	}
	$groupe = stripslashes($groupe);
	echo "<h4>Groupe: $groupe (<a href='?exec=mots_type&id_groupe=$id_groupe'>$id_groupe</a>)</h4>";
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
			spip_query("INSERT INTO spip_mots (type, titre, id_groupe, descriptif, texte) VALUES ('$groupe', '$mot', '$id_groupe', '$descriptif', '$texte')");
			$id_mot = spip_insert_id();
		} else {
			// Mise à jour
			spip_query("UPDATE spip_mots SET type='$groupe', id_groupe='$id_groupe', descriptif='$descriptif', texte='$texte' WHERE id_mot=$id_mot");
		}
	}
	$mot = stripslashes($mot);
	echo "<p>Mot: $mot (<a href='?exec=mots_edit&id_mot=$id_mot&redirect=%3Fexec%3Dmots_tous'>$id_mot</a>)</p>";
	return $id_mot;
}

function create_rubrique($titre, $id_parent='0', $descriptif='') {
	$id_rubrique = id_rubrique($titre, $id_parent);
	if ($id_rubrique==0) {
		$titre = importer_charset($titre);
		$descriptif = importer_charset($descriptif);
		$query="INSERT INTO spip_rubriques (titre, id_parent, descriptif) VALUES ('$titre', '$id_parent', '$descriptif')";
		spip_query($query);
		$id_rubrique = spip_insert_id();
	}
	$titre = stripslashes($titre);
	echo "<p>Rubrique: $titre (<a href='?exec=naviguer&id_rubrique=$id_rubrique'>$id_rubrique</a>)</p>";
	return $id_rubrique;
}

/*
function create_article($titre, $id_rubrique='0', $id_secteur='0', $texte='', $id_article = 0) {
	$id_article = id_article($titre, $id_rubrique, $id_article);
	if ($id_article==0) {
		$titre = importer_charset($titre);
		$texte = importer_charset($texte);
		$query="INSERT INTO spip_articles "
			."(id_article, titre, id_rubrique, texte, statut, id_secteur, accepter_forum) " 
			." VALUES ('$id_article', '$titre', '$id_rubrique', '$texte', 'publie', '$id_secteur', 'abo')";
		echo $query;
		spip_query($query);
		$id_article = spip_insert_id();
	}
	$titre = stripslashes($titre);
	echo "<p>Article: $titre (<a href='?exec=naviguer&id_article=$id_article'>$id_article</a>)</p>";
	return $id_article;
}
*/

function create_rubrique_mot($rubrique, $mot) {
	$id_rubrique = id_rubrique($rubrique);
	$id_mot=id_mot($mot);
	if ($id_rubrique!=0 && $id_mot!=0) {
		$query="SELECT count(*) as nb_rub_mot FROM spip_mots_rubriques WHERE id_mot='$id_mot' AND id_rubrique='$id_rubrique'";
		$result=spip_query($query);
		if ($row = spip_fetch_array($result)) {
			if ($row['nb_rub_mot']==0) {
				$query="INSERT INTO spip_mots_rubriques (id_mot, id_rubrique) VALUES ('$id_mot', '$id_rubrique')";
				spip_query($query);
			}
		}
	}
	echo "<p>Liaison entre Rubrique (<a href='?exec=naviguer&id_rubrique=$id_rubrique'>$id_rubrique</a>) et Mot (<a href='?exec=mots_edit&id_mot=$id_mot&redirect=%3Fexec%3Dmots_tous'>$id_mot</a>)</p>";
	return TRUE;
}

	function jaycee_upgrade(){
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
				$texte="", $unseul='non', $obligatoire='non', 
				$articles='non', $breves='non', $rubriques='oui', $syndic='non', $minirezo='oui', $comite='oui', $forum='non'
				);
				
				create_mot( $groupe='_SYSTEME_RUBRIQUES',	$mot="_MASQUER_RUBRIQUE", 
					$descriptif='Rubrique non visible sur site public', 
					$texte='');							
				create_mot( $groupe='_SYSTEME_RUBRIQUES',	$mot="_RUB_ANNONCES", 
					$descriptif='Identifie la rubrique source des annonces (brèves)', 
					$texte='');							
					
		// ************* Création du groupe et mots-clés
			create_groupe( $groupe='_SYSTEME_ARTICLES', 
				$descriptif="Mots clés attachés aux articles pour la gestion du site",
				$texte="", $unseul='non', $obligatoire='non', 
				$articles='oui', $breves='non', $rubriques='non', $syndic='non', $minirezo='oui', $comite='oui', $forum='non'
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
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_MASQUER_MENU_RUBRIQUE', 
					$descriptif="Masque le sous-menu de la rubrique", 
					$texte="Typiquement sur la page d'accueil");							
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_META_DATAS', 
					$descriptif="Utilise les infos de l'article (à masquer) pour mettre à jour les meta-data HTML", 
					$texte="");							
				create_mot( $groupe='_SYSTEME_ARTICLES',	$mot='_source_Actualite', 
					$descriptif="Utilise cet article pour le mettre à la une par _AFFICHER_ACTUALITES", 
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
				$texte="", $unseul='non', $obligatoire='non', 
				$articles='non', $breves='non', $rubriques='non', $syndic='oui', $minirezo='oui', $comite='oui', $forum='non'
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
				$texte="", $unseul='non', $obligatoire='non', 
				$articles='oui', $breves='non', $rubriques='oui', $syndic='non', $minirezo='oui', $comite='oui', $forum='non'
				);
				create_mot( $groupe='_SYSTEME_META',	$mot="_MaJ-1_Heure", 
					$descriptif='Période de visite par robot demandée',	$texte='');							
				create_mot( $groupe='_SYSTEME_META',	$mot="_MaJ-3_Jour", 
					$descriptif='Période de visite par robot demandée',	$texte='');							
				create_mot( $groupe='_SYSTEME_META',	$mot="_MaJ-4_qqJours", 
					$descriptif='Période de visite par robot demandée',	$texte='');							
				create_mot( $groupe='_SYSTEME_META',	$mot="_MaJ-5_Semaine", 
					$descriptif='Période de visite par robot demandée',	$texte='');							
				create_mot( $groupe='_SYSTEME_META',	$mot="_MaJ-6_Quinzaine", 
					$descriptif='Période de visite par robot demandée',	$texte='');							
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
				create_rubrique_mot( 'fr', '_MaJ-6_Quinzaine'); 

				$liRubFrAnn = create_rubrique( $titre='_ANNONCES', $id_parent=$liRubFr, 
					$descriptif="Annonces pour agenda");
					create_rubrique_mot( '_ANNONCES', '_RUB_ANNONCES'); 
					create_rubrique( $titre='Commissions', $id_parent=$liRubFrAnn, 
						$descriptif="Réunions de Commission"); 
					create_rubrique( $titre='Actions', $id_parent=$liRubFrAnn, 
						$descriptif="Invitations aux Actions publiques "); 
					create_rubrique( $titre='Formations', $id_parent=$liRubFrAnn, 
						$descriptif="Formations diverses"); 
					create_rubrique( $titre='Rencontres', $id_parent=$liRubFrAnn, 
						$descriptif="Invitations aux congrès"); 
					create_rubrique( $titre='Assemblées', $id_parent=$liRubFrAnn, 
						$descriptif="Invitations aux Assemblées Générales et diverses"); 


			$liRubEn = create_rubrique( $titre='en', $id_parent='0', 
				$descriptif="Articles in english");
				create_rubrique_mot( 'en', '_MaJ-7_Mois'); 
			$liRubEs = create_rubrique( $titre='es', $id_parent='0', 
				$descriptif="Articulos en castellano");
				create_rubrique_mot( 'es', '_MaJ-7_Mois'); 

/*
			echo "<h4>Articles :</h4>";
			create_article( $titre='Accueil', 
				$id_rubrique=$liRubFr, $id_secteur=$liRubFr, 
				$texte='Bienvenue sur le nouveau site', 
				$id_article = 1);
*/
			echo "<h4>jaycee  update @ 0.5 / Novembre 2007</h4>";
			ecrire_meta('jaycee_base_version',$current_version=0.5);
		}

		echo "</div>";

		ecrire_metas();
	}
	
	function jaycee_disable(){
		effacer_meta('jaycee_base_version');
		ecrire_metas();
	}
		
	function jaycee_install($action){
		global $jaycee_base_version;
		switch ($action){
			case 'test':
				return (isset($GLOBALS['meta']['jaycee_base_version']) AND ($GLOBALS['meta']['jaycee_base_version']>=$jaycee_base_version));
				break;
			case 'install':
				jaycee_upgrade();
				break;
			case 'uninstall':
				jaycee_disable();
				break;
		}
	}	
?>
