<?php
/*
* Configuration de SPIP pour SoyezCreateurs
* Configurateur de mots clefs et de rubriques bas'e sur
* Configurateur Squelette Epona - 2004 Nov 10 - Marc Lebas.
* Realisation : RealET : real3t@gmail.com
* Attention, fichier en UTF-8 sans BOM
*/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip("inc/lang");
include_spip('inc/meta');

//fonction qui permet de créer les métas de config du site
function soyezcreateurs_config_site() {	
	ecrire_meta('activer_breves', 'non','non');
	ecrire_meta('activer_logos_survol', 'oui','non');
	ecrire_meta('config_precise_groupes', 'oui','non');
	ecrire_meta('articles_surtitre', 'oui','non');
	ecrire_meta('articles_soustitre', 'oui','non');
	ecrire_meta('articles_descriptif', 'oui','non');
	ecrire_meta('articles_chapeau', 'oui','non');
	ecrire_meta('articles_ps', 'oui','non');
	ecrire_meta('articles_mots', 'oui','non');
	ecrire_meta('articles_urlref', 'oui','non');
	ecrire_meta('articles_redirection', 'oui','non');
	ecrire_meta('creer_preview', 'oui','non');
	ecrire_meta('articles_modif', 'oui','non');
	ecrire_meta('rubriques_descriptif', 'oui','non');
	ecrire_meta('forums_urlref', 'oui','non');
	ecrire_meta('activer_sites', 'oui','non');
	ecrire_meta('forums_publics', 'non','non');
	ecrire_meta('accepter_inscriptions', 'oui','non');
	ecrire_meta('prevenir_auteurs', ',pos,pri,abo,','non');
	ecrire_meta('messagerie_agenda', 'non','non');
	ecrire_meta('articles_versions', 'oui','non');
	ecrire_meta('activer_statistiques', 'oui','non');
	ecrire_meta('documents_article', 'oui','non');
	ecrire_meta('documents_rubrique', 'oui','non');
	ecrire_meta('preview', ',0minirezo,1comite,','non');
	ecrire_meta('btv2', 'a:1:{s:7:\"avancee\";s:3:\"Oui\";}','non');
	ecrire_meta('barre_typo_generalisee', 'a:6:{s:38:\"rubriques_texte_barre_typo_generalisee\";s:2:\"on\";s:40:\"groupesmots_texte_barre_typo_generalisee\";s:2:\"on\";s:33:\"mots_texte_barre_typo_generalisee\";s:2:\"on\";s:40:\"sites_description_barre_typo_generalisee\";s:2:\"on\";s:48:\"configuration_description_barre_typo_generalisee\";s:2:\"on\";s:42:\"auteurs_quietesvous_barre_typo_generalisee\";s:2:\"on\";}','non');
	ecrire_meta('nom_site', 'Mon site SPIP <sub>Squelette SoyezCreateurs</sub>','non');
	spip_log("1. (soyezcreateurs_config_site) metas du plugins ecrite", "soyezcreateurs_install");
	return true;
}

// fonction qui permet de trouver si un groupe de mots clés existe à partir du titre
function find_groupe($titre) {
	$titre = addslashes($titre);
	spip_log("1. (find_groupe) recherche des occurences dans la table spip_groupes_mots de l'id de : $titre", "soyezcreateurs_install");
	$count = sql_countsel("spip_groupes_mots", "titre='$titre'");
	spip_log("2. (find_groupe) resultat de la recherche : $count occurences pour $titre", "soyezcreateurs_install");
	return $count;
}

// fonction pour trouver l'id du groupe de mots clés à partir du titre du groupe
function id_groupe($titre) {
	$titre = addslashes($titre);
	spip_log("1. (id_groupe) selection dans la table spip_groupes_mots de l'id de : $titre", "soyezcreateurs_install");
	$result = sql_fetsel("id_groupe", "spip_groupes_mots", "titre='$titre'");
	$resultat = $result['id_groupe'];
	spip_log("2. (id_groupe) selection = $resultat pour $titre", "soyezcreateurs_install");
	return $resultat;
}

//fonction qui permet de créer un groupe de mots clés
function create_groupe($groupe, $descriptif='', $texte='', $unseul='non', $obligatoire='non', $articles='oui', $breves='non', $rubriques='non', $syndic='non', $evenements='non', $minirezo='oui', $comite='oui', $forum='non') {
	$id_groupe = find_groupe($groupe);
	$tables_liees = '';
	if ($articles == 'oui') 
		$tables_liees.='articles,';
	if ($breves == 'oui') 
		$tables_liees.='breves,';
	if ($rubriques == 'oui') 
		$tables_liees.='rubriques,';
	if ($syndic == 'oui') 
		$tables_liees.='syndic,';
	if ($evenements == 'oui') 
		$tables_liees.='evenements,';
	spip_log("1. (create_groupe) pret a creer groupe : titre = $groupe. retour de find_groupe = $id_groupe", "soyezcreateurs_install");
	if ($id_groupe == 0) {
		$id_insert = sql_insertq(
			"spip_groupes_mots", array(
				"id_groupe" => '',
				"titre" => $groupe,
				"descriptif" => $descriptif,
				"texte" => $texte,
				"unseul" => $unseul,
				"obligatoire" => $obligatoire,
				"tables_liees" => $tables_liees,
				"minirezo" => $minirezo,
				"comite" => $comite,
				"forum" => $forum
			)
		);
		spip_log("2. (create_groupe) retour de find_groupe : $id_groupe, donc insertion avec id = $id__insert et titre = $groupe", "soyezcreateurs_install");
	} 
	else if ($id_groupe > 0) {
		$id_insert = remplacer_groupe($groupe, $descriptif, $texte, $unseul, $obligatoire, $tables_liees, $minirezo, $comite, $forum);
		spip_log("2. (create_groupe) retour de find_groupe : $id_groupe... passage a remplacer_groupe", "soyezcreateurs_install");
	}
	return $id_insert;
}

function supprimer_mot_groupe($nom_groupe,$nom_mot) {
	$id_groupe = id_groupe($nom_groupe);
	$id_mot = id_mot($nom_mot, $id_groupe);
	if ($id_mot>0) {
		sql_delete("spip_mots", "id_mot=$id_mot");
		sql_delete("spip_mots_articles", "id_mot=$id_mot");
		sql_delete("spip_mots_rubriques", "id_mot=$id_mot");
		sql_delete("spip_mots_syndic", "id_mot=$id_mot");
		sql_delete("spip_mots_forum", "id_mot=$id_mot");
	}
}

function vider_groupe($nom_groupe) {
	$id_groupe = id_groupe($nom_groupe);
	if ($id_groupe>0) {
		$id_mots = sql_select('id_mot',  'spip_mots',  'id_groupe='.sql_quote($id_groupe));
		while($id_mot = sql_fetch($id_mots)){
			sql_delete("spip_mots", "id_mot=".$id_mot['id_mot']);
			sql_delete("spip_mots_articles", "id_mot=".$id_mot['id_mot']);
			sql_delete("spip_mots_rubriques", "id_mot=".$id_mot['id_mot']);
			sql_delete("spip_mots_syndic", "id_mot=".$id_mot['id_mot']);
			sql_delete("spip_mots_forum", "id_mot=".$id_mot['id_mot']);
		}
		sql_delete("spip_groupes_mots", "id_groupe=$id_groupe");
	}
}

//fonction qui mets à jour un groupe de mots clés
function remplacer_groupe($titre, $descriptif, $texte, $unseul, $obligatoire, $tables_liees, $minirezo, $comite, $forum) {
	$id_groupe = id_groupe($titre);
	sql_updateq(
		"spip_groupes_mots", array(
			"descriptif" => $descriptif,
			"texte" => $texte,
			"unseul" => $unseul,
			"obligatoire" => $obligatoire,
			"tables_liees" => $tables_liees,
			"minirezo" => $minirezo,
			"comite" => $comite,
			"forum" => $forum
		), "id_groupe=$id_groupe"
	);
	return true;
}

// fonction qui permet de trouver si un mot clé existe à partir du titre et de l'id du groupe
function find_mot($titre, $id_groupe) {
	$titre = addslashes($titre);
	$count = sql_countsel(
		"spip_mots", 
		"titre = '$titre' AND id_groupe = $id_groupe"
	);
	return $count;
}

//fonction qui permet de trouver l'id du mot clé à partir du titre et de l'id du groupe
function id_mot($titre, $id_groupe) {
	spip_log("1. (id_mot) debut de recherche de l'id de $titre avec $id_groupe", "soyezcreateurs_install");
	$titre = addslashes($titre);
	$result = sql_fetsel(
		"id_mot", 
		"spip_mots", 
		"titre='$titre' AND id_groupe = $id_groupe"
	);
	$id_mot = $result['id_mot'];
	spip_log("2. (id_mot) retour de la fonction id_mot = $id_mot", "soyezcreateurs_install");
	return $id_mot;
}

//fonction qui permet de créer un mot clé
function create_mot($groupe, $mot, $descriptif='', $texte='') {
	$id_groupe = id_groupe($groupe);
	$find_mot = find_mot($mot, $id_groupe);
	if ($find_mot == 0) {
		spip_log("1. (create_mot) debut create_mot. mot inexistant donc creation : $id_groupe - $mot", "soyezcreateurs_install");
		$motcle = sql_insertq(
			"spip_mots", array(
				"id_mot" => '',
				"titre" => $mot,
				"descriptif" => $descriptif,
				"texte" => $texte,
				"id_groupe" => $id_groupe,
				"type" => $groupe
			)
		);
		spip_log("2. (create_mot) mot cle $mot insere sous l'id $motcle dans la table avec groupe = $id_groupe", "soyezcreateurs_install");
	}
	else if ($find_mot > 0) {
		$id_mot = id_mot($mot, $id_groupe);
		spip_log("1. (create_mot) mise a jour dans la table du mot cle : $mot", "soyezcreateurs_install");
		remplacer_mot($id_mot, $descriptif, $texte, $id_groupe, $groupe);
	}
	else {
		spip_log("insertion impossible ! debug : groupe = $groupe --- id_groupe = $id_groupe", "soyezcreateurs_install");
	}
}

//fonction qui permet de mettre à jour un mot clé 
function remplacer_mot($id_mot, $descriptif, $texte, $id_groupe, $groupe) {
	sql_updateq(
			"spip_mots", array(
				"descriptif" => $descriptif,
				"texte" => $texte,
				"id_groupe" => $id_groupe,
				"type" => $groupe
			), "id_mot=$id_mot"
		);
	return true;
}
// fonction qui permet de trouver si une rubrique existe à partir du titre
function find_rubrique($titre) {
	$titre = addslashes($titre);
	$count = sql_countsel(
		"spip_rubriques", 
		"titre = '$titre'"
	);
	return $count;
}

//fonction qui permet de trouver l'id d'une rubrique à partir du titre
function id_rubrique($titre) {
	$result = sql_fetsel(
		"id_rubrique", 
		"spip_rubriques", 
		"titre='$titre'"
	);
	$resultat = $result['id_rubrique'];
	spip_log("1. (id_rubrique) recherche de l'id_rubrique de $titre = $resultat", "soyezcreateurs_install");
	return $resultat;
}

// fonction qui permet de renommer une rubrique à partir du titre
function rename_rubrique($titre, $nouveau_titre) {
	$id_rubrique = id_rubrique($titre);
	if ($id_rubrique) {
		sql_updateq(
			"spip_rubriques", array(
				"titre" => $nouveau_titre
			), "id_rubrique=$id_rubrique"
		);
		spip_log("rename_rubrique) renommage de $titre en $nouveau_titre", "soyezcreateurs_install");
	}
	return true;
}
	

//fonction qui permet de créer une rubrique
function create_rubrique($titre, $id_parent='0', $descriptif='') {
	$id_rubrique = find_rubrique($titre);
	if ($id_rubrique == 0) {
		$id_rubrique = sql_insertq(
			"spip_rubriques", array(
				"titre" => $titre,
				"id_parent" => $id_parent,
				"descriptif" => $descriptif
			)
		);
		sql_updateq(
			"spip_rubriques", array(
				"id_secteur" => $id_rubrique
			), "id_rubrique=$id_rubrique"
		);
		spip_log("1. (create_rubrique) rubrique cree : id = $id_rubrique, titre = $titre", "soyezcreateurs_install");
	}
	else if ($id_rubrique > 0) {
		$id_rubrique = id_rubrique($titre);
		remplacer_rubrique($id_rubrique, $id_parent, $descriptif);
	}
	return $id_rubrique;
}

//fonction qui mets à jour une rubrique
function remplacer_rubrique($id_rubrique, $id_parent, $descriptif) {
	sql_updateq(
		"spip_rubriques", array(
			"id_parent" => $id_parent,
			"descriptif" => $descriptif
		), "id_rubrique=$id_rubrique"
	);
	return true;
}

// fonction qui permet de trouver si un article existe à partir du titre
function find_article($titre, $id_rubrique) {
	$titre = addslashes($titre);
	$count = sql_countsel(
		"spip_articles", 
		"titre='$titre' AND id_rubrique = $id_rubrique"
	);
	return $count;
}

//fonction qui permet de trouver l'id d'un article à partir du titre
function id_article($titre, $id_rubrique) {
	$titre = addslashes($titre);
	$result = sql_fetsel(
		"id_article", 
		"spip_articles", 
		"titre='$titre' AND id_rubrique = $id_rubrique"
	);
	$resultat = $result['id_article'];
	spip_log("1. (id_article) recherche de l'id_article de $titre = $resultat", "soyezcreateurs_install");
	return $resultat;
}

//fonction qui permet de créer un article
function create_article($texte, $rubrique, $lang='fr') {
	$id_rubrique = id_rubrique($rubrique);
	$count_articles = find_article($texte['titre'], $id_rubrique);
	if ($count_articles == 0) {
		spip_log("1. (create_article) insertion d'un article : ".$texte['titre'], "soyezcreateurs_install");
		$statut = 'publie';
		$date = date("Y-m-d H:i:s");
		$id_article = sql_insertq(
			"spip_articles", array(
				"id_article" => '',
				"surtitre" => $texte['surtitre'],
				"titre" => $texte['titre'],
				"soustitre" => $texte['soustitre'],
				"id_rubrique" => $id_rubrique,
				"descriptif" => $texte['descriptif'],
				"chapo" => $texte['chapo'],
				"texte" => $texte['texte'],
				"ps" => $texte['ps'],
				"date" => $date,
				"statut" => $statut,
				"id_secteur" => $id_rubrique,
				"maj" => $date,
				"export" => '',
				"date_redac" => '0000-00-00 00:00:00',
				"visites" => 0,
				"referers" => 0,
				"popularite" => 0,
				"accepter_forum" => '',
				"date_modif" => $date,
				"lang" => $lang,
				"langue_choisie" => 'non',
				"id_trad" => 0,
				"extra" => 'NULL',
				"id_version" => 0,
				"nom_site" => $texte['nom_site'],
				"url_site" => $texte['url_site']
			)
		);
		sql_insertq(
			"spip_auteurs_articles", array(
				"id_auteur" => 1,
				"id_article" => $id_article
			)
		);
		include_spip('inc/rubriques');
		calculer_rubriques();
		spip_log("2. (create_article) article insere : $id_article", "soyezcreateurs_install");
	}
	else if ($count_articles > 0) {
		$id_article = id_article($texte['titre'], $id_rubrique);
		spip_log("2. (create_article) maj de l'article : ".$texte['titre'], "soyezcreateurs_install");
		remplacer_article($id_article, $id_rubrique, $texte);
	}
}

//fonction qui permet de mettre à jour un article
function remplacer_article($id_article, $id_rubrique, $texte) {
	sql_updateq(
		"spip_articles", array(
			"surtitre" => $texte['surtitre'],
			"soustitre" => $texte['soustitre'],
			"descriptif" => $texte['descriptif'],
			"chapo" => $texte['chapo'],
			"texte" => $texte['texte'],
			"ps" => $texte['ps'],
			"nom_site" => $texte['nom_site'],
			"url_site" => $texte['url_site']
		), "id_article='$id_article' AND id_rubrique = $id_rubrique"
	);
	return true;
}

// fonction qui permet de trouver si une liaison entre un article et un mot clé existe
function find_article_mot($id_mot, $id_article) {
	$count = sql_countsel(
		"spip_mots_articles", 
		"id_mot = $id_mot AND id_article = $id_article"
	);
	return $count;
}

//fonction qui permet de créer une relation entre un article et un mot clé
function create_article_mot($article, $rubrique, $mot, $groupe) {
	spip_log("1. (create_article_mot) demande de creation de liaison : $article avec $mot", "soyezcreateurs_install");
	$id_rubrique = id_rubrique($rubrique);
	$id_groupe = id_groupe($groupe);
	$id_mot = id_mot($mot, $id_groupe);
	$id_article = id_article($article, $id_rubrique);
	$count = find_article_mot($id_mot, $id_article);
	if ($count == 0) {
		sql_insertq(
			"spip_mots_articles", 
			array(
				"id_mot"=> $id_mot, 
				"id_article" => $id_article
			)
		);
		spip_log("2. (create_article_mot) liaison mise en place (article = $id_article - mot = $id_mot)", "soyezcreateurs_install");
	}
	else {
		spip_log("2. (create_article_mot) liaison deja existante ! (article = $id_article - mot = $id_mot)", "soyezcreateurs_install");
	}
}

//fonction qui permet de trouver des liaisons entre rubrique et mot clé
function find_rubrique_mot($id_mot, $id_rubrique) {
	$count = sql_countsel(
		"spip_mots_rubriques", 
		"id_mot = $id_mot AND id_rubrique = $id_rubrique"
	);
	return $count;
}

//fonction qui permet de créer une relation entre une rubrique et un mot clé
function create_rubrique_mot($rubrique, $mot, $groupe) {
	$id_rubrique = id_rubrique($rubrique);
	$id_groupe = id_groupe($groupe);
	$id_mot = id_mot($mot, $id_groupe);
	spip_log("1. (create_rubrique_mot) creation : rubrique = $id_rubrique ($rubrique) - mot = $id_mot ($mot) - groupe = $id_groupe ($groupe)", "soyezcreateurs_install");
	$count = find_rubrique_mot($id_mot, $id_rubrique);
	if ($count == 0) {
		sql_insertq(
			"spip_mots_rubriques", array(
				"id_mot" => $id_mot,
				"id_rubrique" => $id_rubrique
			)
		);
	}
	return true;
}

//fonction qui permet de créer le tout
function soyezcreateurs_config_motsclefs() {
	//les rubriques
	create_rubrique('000. Fourre-tout', '0', "Vous trouverez dans cette rubrique:\n\n-* Les Éditos\n-* Des articles concernant le site lui-même\n");
	create_rubrique('900. Agenda', '0');
	create_rubrique('999. Citations', '0', "Mettre dans cette rubrique une citation par article");
	//les groupes puis mots
	create_groupe("Thèmes de l'Agenda", "Détermine la liste des éléments pouvant être présentés en liste déroulante dans l'Agenda du site", "Un événement de l'Agenda peut avoir un ou {{plusieurs}} mot clefs ratachés (les sélectionner avec maj-clic).", 'non', 'non', 'non', 'non', 'non', 'non', 'oui', 'oui', 'oui', 'non');
	create_groupe("_AgendaStatut", "Statut d'un événement dans l'Agenda", "Permet de spécifier un statut d'un événement dans l'Agenda.\n\nL'événement sera affiché dans la couleur spécifiée par le {Texte} du Mot Clef.\n\nLe {Descriptif rapide} sera quant à lui utilisé en bulle d'aide.", 'oui', 'oui', 'non', 'non', 'non', 'non', 'oui', 'oui', 'oui', 'non');
	create_groupe("_ClasseRubriqueMenu", "Pour affecter une classe spécifique aux éléments du menu", "", 'oui', 'non', 'non', 'non', 'oui', 'non', 'non', 'oui', 'non', 'non');
		create_mot("_ClasseRubriqueMenu", "separation", "Affecter ce mot clef aux rubriques qui doivent être affichée avec une séparation dans le menu.", "");
	create_groupe("_CouleurRubrique", "Permet de changer la couleur d'une Rubrique.", "Affecter un mot clef de ce groupe à une rubrique (et ses descendants) pour en changer la tonalité de couleur.\n\nPour chacun des mots clefs, mettre en titre quelque chose d'intelligible, un éventuel descriptif rapide sur l'usage à en faire et le code hexadecimal de la couleur dans le texte. \n\nExemple : \n-* Titre: Orange\n-* Texte : f78221", 'oui', 'non', 'non', 'non', 'oui', 'non', 'non', 'oui', 'non', 'non');
		create_mot("_CouleurRubrique", "Bleu", "", "6392A9");
		create_mot("_CouleurRubrique", "Marron clair", "", "9F7561");
		create_mot("_CouleurRubrique", "Turkoise pastel", "", "89A699");
	create_groupe("_HTTP-EQUIV", "Paramétrage du site", "Paramétrage des entêtes HTML HTTP-EQUIV.\n\nÀ utiliser en sachant pourquoi.", 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'oui', 'non', 'non');
		create_mot("_HTTP-EQUIV", "pics-label", "Mettre ci-dessous le contenu du label ICRA (XHTML) généré depuis [->http://www.icra.org/].\n\nIl s'agit d'une démarche volontaire du responsable du site visant à indiquer si le site peut ou non être visité sans dommage par des enfants.", "");
	create_groupe("_InformationsLegales", "Mention légales obligatoire ([CNIL|Commision Nationale Informatique et Liberté->http://www.cnil.fr/] et [LcEN|Loi sur la confiance en l'Économie Numérique->http://www.legifrance.gouv.fr/WAspad/UnTexteDeJorf?numjo=ECOX0200175L])", "[Décryptage des obligations légales->http://maitre.eolas.free.fr/journal/index.php?2005/05/27/135-responsabilite-du-blogueur].", 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'oui', 'non', 'non');
		create_mot("_InformationsLegales", "10. Propriétaire du site", "Mettre les coordonnées du propriétaire du site ci-dessous", "");
		create_mot("_InformationsLegales", "20. Hébergeur", "Mettre les coordonnées de l'hébergeur ci-dessous", "");
		create_mot("_InformationsLegales", "30. Liens vers ce site", "Mettre ci-dessous les conditions d'utilisation du contenu", "Le site autorise tout site Internet ou tout autre support à le citer ou à mettre en place un lien hypertexte pointant vers son contenu.\n\nL'autorisation de mise en place d'un lien est valable pour tout support, à l'exception de ceux diffusant des informations à caractère polémique, pornographique, xénophobe ou pouvant, dans une plus large mesure porter atteinte à la sensibilité du plus grand nombre.\n\nLa reprise intégrale du contenu d'une page est aussi autorisée, sous réserve d'établir un lien clair vers sa source. C'est la [licence CC-By-SA|Paternité-Partage des Conditions Initiales à l'Identique 2.0 France->http://creativecommons.org/licenses/by-sa/2.0/fr/] qui s'applique.");
		create_mot("_InformationsLegales", "35. Traitement automatisé d'informations nominatives", "", "Ce site ne collecte sur les visiteurs du site aucune autre information nominative ou personnelle que celles qui lui sont ouvertement et volontairement fournies en particulier par l'intermédiaire des adresses électroniques de ses correspondants.\n\nNous vous rappelons que vous disposez d'un droit d'accès, de modification, de rectification et de suppression des données vous concernant (article 34 de la loi \"Informatique et Libertés\" du 6 janvier 1978). \nPour exercer ce droit, contactez-nous.\n");
		create_mot("_InformationsLegales", "40. Réalisation", "Mettre ci-dessous les informations concernant la réalisation de ce site.", "Ce site a été réalisé par [PYRAT.net|Création de sites web->http://www.pyrat.net/] en utilisant l'outil [SPIP->https://www.spip.net/].\n\n[PYRAT.net|Création de sites web->http://www.pyrat.net/] a réalisé ce site dans les respect des [normes pour l'accessibilité->http://www.pyrat.net/Accessibilite-d-un-site-web,193.html] des sites web à tous.");
	create_groupe("_LayoutGala", "Permet de faire appel à l'une des 40 mises en page disponibles sur [Layout Gala->http://blog.html.it/layoutgala/]", "Mode d'emploi : affecter un des mots mots clefs de ce groupe à un objet de SPIP (Articles, Rubriques, Brèves, Sites) permet de lui affecter la mise en page associée", 'oui', 'non', 'oui', 'oui', 'oui', 'oui', 'non', 'oui', 'non', 'non');
		create_mot("_LayoutGala", "01. Three percentage columns", "", "");
		create_mot("_LayoutGala", "02. Three percentage columns (InverseColor)", "", "");
		create_mot("_LayoutGala", "03. Three percentage columns (Right)", "", "");
		create_mot("_LayoutGala", "04. Three percentage columns (Right InverseColor)", "", "");
		create_mot("_LayoutGala", "05. Three percentage columns (Left)", "", "");
		create_mot("_LayoutGala", "06. Three percentage columns (Left InverseColor)", "", "");
		create_mot("_LayoutGala", "07. Three fixed columns", "", "");
		create_mot("_LayoutGala", "08. Three fixed columns (InverseColor)", "", "");
		create_mot("_LayoutGala", "09. Three fixed columns (Right)", "", "");
		create_mot("_LayoutGala", "10. Three fixed columns (Right InverseColor)", "", "");
		create_mot("_LayoutGala", "11. Three fixed columns (Left)", "", "");
		create_mot("_LayoutGala", "12. Three fixed columns (Left InverseColor)", "", "");
		create_mot("_LayoutGala", "13. Liquid, secondary columns fixed-width", "", "");
		create_mot("_LayoutGala", "14. Liquid, secondary columns fixed-width (InverseColor)", "", "");
		create_mot("_LayoutGala", "15. Liquid, secondary columns fixed-width (Right)", "", "");
		create_mot("_LayoutGala", "16. Liquid, secondary columns fixed-width (Right InverseColor)", "", "");
		create_mot("_LayoutGala", "17. Liquid, secondary columns fixed-width (Left)", "", "");
		create_mot("_LayoutGala", "18. Liquid, secondary columns fixed-width (Left InverseColor)", "", "");
		create_mot("_LayoutGala", "19. Liquid, three columns, hybrid widths", "", "");
		create_mot("_LayoutGala", "20. Liquid, three columns, hybrid widths (InverseColor)", "", "");
		create_mot("_LayoutGala", "21. Liquid, three columns, hybrid widths (Right)", "", "");
		create_mot("_LayoutGala", "22. Liquid, three columns, hybrid widths (Right InverseColor)", "", "");
		create_mot("_LayoutGala", "23. Two columns liquid, side fixed", "", "");
		create_mot("_LayoutGala", "24. Two columns liquid, side fixed", "", "");
		create_mot("_LayoutGala", "25. Two percentage columns", "", "");
		create_mot("_LayoutGala", "26. Two percentage columns", "", "");
		create_mot("_LayoutGala", "27. One column liquid and two halves", "", "");
		create_mot("_LayoutGala", "28. One column liquid and two halves (InverseColor)", "", "");
		create_mot("_LayoutGala", "29. Two percentage columns and one larger", "", "");
		create_mot("_LayoutGala", "30. Two percentage columns and one larger (Right)", "", "");
		create_mot("_LayoutGala", "31. Two columns liquid, fixed side and large one", "", "");
		create_mot("_LayoutGala", "32. Two columns liquid, fixed side and large one (Right)", "", "");
		create_mot("_LayoutGala", "33. Two colums fixed (Right)", "", "");
		create_mot("_LayoutGala", "34. Two colums fixed", "", "");
		create_mot("_LayoutGala", "35. Two colums fixed (ShortLeft)", "", "");
		create_mot("_LayoutGala", "36. Two colums fixed (ShortRight)", "", "");
		create_mot("_LayoutGala", "37. Two colums fixed (Right)", "", "");
		create_mot("_LayoutGala", "38. Two colums fixed", "", "");
		create_mot("_LayoutGala", "39. One column fixed and two halves (Right)", "", "");
		create_mot("_LayoutGala", "40. One column fixed and two halves", "", "");
	create_groupe("_LogosExtra", "Permet de placer une image en fond de la colonne Extra (c'est-à-dire, soit la colonne secondaire qui peut être afichée soit de l'autre côté du menu, soit en dessous de celui-ci).", "{{Utilisation}} : affecter un ou plusieurs mots clefs de ce groupe aux rubriques (héritage automatique) qui doivent avoir une ou plusieurs image en fond. L'image est choisie aléatoirement parmis celles disponibles.\n\n{{Configuration}} : \n-* créer des mots clefs dans ce groupe et leur donner un logo de mot clef.\n-* il est possible de mettre un logo de survol qui sera alors utilisé en fond de texte (en plus de l'autre logo) et positionné en haut à droite sauf si le texte contient les ordres CSS de positionnement ({bottom left} par exemple)", 'non', 'non', 'non', 'non', 'oui', 'non', 'non', 'oui', 'non', 'non');
	create_groupe("_META", "Paramètrage du site", "Permet de spécifier des META pour le site.\n\nIl est possible de rajouter des METAs non encore présents, mais, comme d'habitude en la matière : sachez ce que vous faites !", 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'oui', 'non', 'non');
		create_mot("_META", "Description", "Mettre ci-dessous la description du site", "");
		create_mot("_META", "ICBM", "Mettre la latitude et la longitude du lieu sous la forme : XXX.XXXXX, XXX.XXXXX\n_ Pour trouver vos coordonnées : [Multimap->http://www.multimap.com/]\n_ Et [vous référencer sur GeoURL->http://geourl.org/ping/]", "");
		create_mot("_META", "Keywords", "Mettre ci-dessous les mots clef du site séparés par des virgules", "");
		create_mot("_META", "revisit-after", "Fréquence d'indexation du site", "3 days");
	create_groupe("_ModePortail", "Les mots clefs de ce groupe permettent de gérer les éléments qui s'affichent sur la page d'accueil du site si celui-ci est en mode portail.", "Les mots clefs numérotés dans leur titre de 0. à 9. verront leur logo utilisé dans les colonnes de gauche et de droite de la page d'accueil (respectivement pour les numéros impairs et pairs).", 'oui', 'non', 'oui', 'non', 'oui', 'non', 'non', 'oui', 'non', 'non');
		create_mot("_ModePortail", "1. Mot1", "", "");
		create_mot("_ModePortail", "2. Mot2", "", "");
		create_mot("_ModePortail", "Goodies", "Affecter ce mot clef aux objets SPIP devant apparaitre dans la zone des Goodies.", "Ne pas oublier de mettre un logo (120×30) aux objet concernés.");
		create_mot("_ModePortail", "ZoomSur", "Affecter ce mot clef à l'objet que vous voulez placer dans le cadre « Zoom sur » (facultatif).\n\nLe site prendra les 3 derniers articles ayant ce mot clef", "S'applique aux :\n-* articles\n-* rubriques");
	create_groupe("_Specialisation", "Spécialisation d'un article ", "Un mot clef pris dans ce groupe permettra de modifier\n\n-* le comportement d'un article particulier\n", 'non', 'non', 'oui', 'non', 'non', 'non', 'non', 'oui', 'oui', 'non');
		create_mot("_Specialisation", "AccesibiliteLien", "Affecter ce mot clef à l'article traitant de la politique d'accessibilité du site.", "Un fois l'article écrit, lui affecter ce mot clef pour qu'il soit disponible en lien en haut de la page (caché pour les voyants, sauf sur la page d'accueil).");
		create_mot("_Specialisation", "ALaUne", "Article qui doit rester à la une du site (soit dans quoi de neuf, soit dans la liste des articles en ModeNews, Soit dans le cartouche À la une en ModePortail)", "");
		create_mot("_Specialisation", "Courrier_libre", "Affecter ce mot clef à l'article utilisé comme courrier libre.", "Concerne les articles qui servent à l'envoi de courriers libres");
		create_mot("_Specialisation", "DevoilerDate", "Mettre ce mot clef à un article dont on veut afficher la date de publication.", "");
		create_mot("_Specialisation", "DevoilerIdentite", "Mettre ce mot clef à un article dont on veut afficher le nom du ou des auteurs (au sens de SPIP)", "");
		create_mot("_Specialisation", "EDITO", "Sert à dire que l'article est un éditorial.", "{{Attention}} : le site utilisera l'article le plus récent ayant ce mot clef pour l'afficher en tant qu'éditorial.\n\n[*Conséquence*] : ne changez pas le contenu d'un éditorial par le nouvel éditorial, créez un nouvel article éditorial!");
		create_mot("_Specialisation", "EDITO_Restreint", "Pour un article d'Edito ne s'affichant qu'en mode restreint", "Permet donc d'avoir un Edito pour le grand public et un Edito pour la zone restreinte.\n\nMieux encore, avec 2 EDITO_Restreint, un en libre accès et un en zone restreinte, on pourra avoir :\n-* un Edito d'accueil après inscription au site\n-* Un Edito d'accueil après rattachement à une zone restreinte.");
		create_mot("_Specialisation", "GraverSonNom", "Un article avec ce mot clef permettra aux visiteurs de laisser leur nom sur le site en tant que bulle d'aide sur l'image (Logo du mot) et de faire parvenir un texte aux administrateurs", "Il faut pour que ça fonctionne:\n\n-* un article\n-* un forum modéré a posteriori\n-* ce mot mot clef attaché à cet article\n-* un logo à ce mot clef\n\nÀ partir de là, l'article permet aux visiteurs de «graver leur nom» dans le site. Leur nom aparaitra en bulle d'aide sur une image (le logo de ce mot clef).");
		create_mot("_Specialisation", "Livre d'Or", "Pour empécher que l'on puisse répondre à un forum", "Ce mot clef appliqué à un article ayant un forum fait que ce forum n'a qu'un niveau (pas possible de répondre à une intervention, seulement d'en rajouter)");
		create_mot("_Specialisation", "MENURACINE", "Doit s'afficher en dessous de Accueil", "Pour dire que l'article s'affiche en dessous de Accueil dans le menu de gauche avant les rubriques du site");
		create_mot("_Specialisation", "MENURACINEBAS", "Pour dire que l'article s'affiche au dessus de Plan", "Permet de placer dans le menu de gauche un (ou plusieurs) article(s) en bas de menu, avant le plan du site.");
		create_mot("_Specialisation", "MENURACINEBAS_Systematique", "Affichage systématique dans le menu de gauche en bas", "Affecter ce mot clef à un article qui devra être présent dans le menu de gauche, en bas, que l'on soit dans un secteur avec MenuHaut ou non.");
		create_mot("_Specialisation", "MENURACINE_Systematique", "Affichage systématique dans le menu de gauche en haut", "Affecter ce mot clef à un article qui devra être présent dans le menu de gauche, en haut, que l'on soit dans un secteur avec MenuHaut ou non.");
		create_mot("_Specialisation", "PasDansRecherche", "Permet de masquer un article des résultats de la recherche", "À affecter aux articles qui ne doivent pas être affichées dans les résultats de la recherche");
		create_mot("_Specialisation", "PasdeSiteDansForums", "Pour que les sites référencés n'apparaissent pas dans un forum (mesure anti SPAM)", "Pour décourager ceux qui utiliseraient vos forums pour faire de la pub pour leurs site (généralement, des sonneries de téléphone)");
	create_groupe("_Specialisation_Rubrique", "Spécialisation d'une rubrique", "Un mot clef pris dans ce groupe permettra de modifier\n\n-* le comportement d'une rubrique et de ses articles\n", 'non', 'non', 'non', 'non', 'oui', 'non', 'non', 'oui', 'oui', 'non');
		create_mot("_Specialisation_Rubrique", "AfficherArticlesMenu", "Affichage des articles de la rubrique dans le menu de gauche", "Affecter ce mot clef aux rubriques dont la liste des articles doit être affichée dans le menu de gauche.");
		create_mot("_Specialisation_Rubrique", "Agenda", "Pour dire qu'une rubrique est dans l'Agenda", "Il est impératif de mettre ce mot clef pour la rubrique à la racine ayant cette caractéristique (inutile pour les sous rubriques de cette rubrique).");
		create_mot("_Specialisation_Rubrique", "agenda_principal", "", "");
		create_mot("_Specialisation_Rubrique", "Citations", "Rubrique destinée à recevoir de courtes citations (une par article) affichées en haut à droite des pages du site de manière alléatoire (une nouvelle citation toutes les heures)", "Créer un article par citation avec :\n\n-* La citation dans le corps du texte (entourée de guillemets si nécessaires)\n-* L'auteur dans le sous-titre\n-* Le titre de l'article sert d'accroche pour le lecteur\n");
		create_mot("_Specialisation_Rubrique", "DessousBreves", "Pour placer une rubrique et ses articles qui sont placés sous les brèves (dans la colonne de droite du site)", "[*Attention*] : une rubrique qui a ce mot clef ne doit pas avoir de sous-rubrique !\n\nLe titre de la rubrique sera affiché sur la droite et la liste de ses articles en dessous.\n\nSeuls les articles sont clicables pour accéder à leur contenu.");
		create_mot("_Specialisation_Rubrique", "Gribouille", "Affecter ce mot clef à la rubriques (ou aux rubriques) servant de Wiki dans le site.", "");
		create_mot("_Specialisation_Rubrique", "dossier_en_avant", "", "");
		create_mot("_Specialisation_Rubrique", "dossier_identite", "", "");
		create_mot("_Specialisation_Rubrique", "dossier_thematique", "", "");
		create_mot("_Specialisation_Rubrique", "info_pratique", "", "");
		create_mot("_Specialisation_Rubrique", "membres", "", "");
		create_mot("_Specialisation_Rubrique", "MenuHaut", "Pour qu'un secteur soit dans un menu horizontal en haut du site", "Affecter ce mot clef aux secteurs (rubriques rattachées à la racine du site) qui doivent être dans le menu horizontal en haut du site.");
		create_mot("_Specialisation_Rubrique", "PasDansMenu", "Pour interdire que la rubrique (et ses sous-rubriques) soi(en)t dans le menu de gauche", "");
		create_mot("_Specialisation_Rubrique", "PasDansPlan", "Permet de masquer une rubrique, et tout son contenu (y compris les sous-rubriques) du plan du site", "À affecter aux rubriques qui ne doivent pas être affichées dans le plan du site");
		create_mot("_Specialisation_Rubrique", "SecteurPasDansQuoiDeNeuf", "Pour interdire que les articles d'un secteur entier soit dans «Quoi de Neuf» sur la page d'accueil", "Un secteur, c'est une rubrique rattachée à la racine du site et toutes ses sous-rubriques");
	create_groupe("_Specialisation_Rubrique_ou_Article", "Spécialisation d'une rubrique ou d'un article", "Un mot clef pris dans ce groupe permettra de modifier\n\n-* le comportement d'une rubrique et de ses articles\n-* le comportement d'un article particulier", 'non', 'non', 'oui', 'non', 'oui', 'non', 'non', 'oui', 'oui', 'non');
		create_mot("_Specialisation_Rubrique_ou_Article", "PasDansQuoiDeNeuf", "Pour interdire que l'article ou la rubrique soit dans «Quoi de Neuf» sur la page d'accueil", "À mettre soit:\n\n-* pour un article précis\n-* pour une rubrique particulière\n\nRemarque : si elle a des sous rubriques, il faut aussi le faire pour chacunes de celles-ci si on veut les exclure aussi...");
		create_mot("_Specialisation_Rubrique_ou_Article", "Sommaire", "Pour dire que les articles de cette rubrique ont un sommaire ou que l'article a un sommaire", "Un sommaire automatique sera placé en début d'article.\n\nCe sommaire sera bati à partir des titres et sous-titres du texte de l'article.");
	// les liaisons entre rubriques et mot clé
	create_rubrique_mot('000. Fourre-tout', 'SecteurPasDansQuoiDeNeuf', "_Specialisation_Rubrique");
	create_rubrique_mot('000. Fourre-tout', 'PasDansMenu', "_Specialisation_Rubrique");
	create_rubrique_mot('000. Fourre-tout', 'PasDansPlan', "_Specialisation_Rubrique");
	create_rubrique_mot('900. Agenda', 'Agenda', "_Specialisation_Rubrique");
	create_rubrique_mot('900. Agenda', 'SecteurPasDansQuoiDeNeuf', "_Specialisation_Rubrique");
	create_rubrique_mot('900. Agenda', 'PasDansMenu', "_Specialisation_Rubrique");
	create_rubrique_mot('999. Citations', 'SecteurPasDansQuoiDeNeuf', "_Specialisation_Rubrique");
	create_rubrique_mot('999. Citations', 'PasDansMenu', "_Specialisation_Rubrique");
	create_rubrique_mot('999. Citations', 'PasDansPlan', "_Specialisation_Rubrique");
	create_rubrique_mot('999. Citations', 'Citations', "_Specialisation_Rubrique");
	
	include_spip('inc/sc_article');
	$article1 = trouve_article_sc("Premiers pas dans le squelette SoyezCreateurs");
		create_article($article1, "000. Fourre-tout");
		create_article_mot($article1['titre'], "000. Fourre-tout", "EDITO", "_Specialisation");
	$article2 = trouve_article_sc('Partage');
		create_article($article2, '999. Citations');
	$article3 = trouve_article_sc('Contact');
		create_article($article3, '000. Fourre-tout');
		create_article_mot($article3['titre'], '000. Fourre-tout', "MENURACINEBAS_Systematique", "_Specialisation");
	$article4 = trouve_article_sc('Économies');
		create_article($article4, '999. Citations');
	$article5 = trouve_article_sc('Concision');
		create_article($article5, '999. Citations');
	$article6 = trouve_article_sc("Raccourcis Typographiques de SPIP, mode d'emploi");
		create_article($article6, "000. Fourre-tout");
		create_article_mot($article6['titre'], "000. Fourre-tout", "ALaUne", "_Specialisation");
	
	return true;
}
?>