<?php
/*
* Configuration de SPIP pour SoyezCreateurs
* Configurateur de mots clefs et de rubriques bas'e sur
* Configurateur Squelette Epona - 2004 Nov 10 - Marc Lebas.
* Realisation : RealET : real3t@gmail.com
* Attention, fichier en UTF-8 sans BOM
*/

if (!defined('_ECRIRE_INC_VERSION')) return;

include_spip("inc/lang");
include_spip('inc/meta');
define('_LOG_INSTALL', "soyezcreateurs_install");

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
	ecrire_meta('documents_date', 'non','non');
	ecrire_meta('documents_objets', 'spip_articles,spip_rubriques,','non');
	ecrire_meta('preview', ',0minirezo,1comite,','non');
	ecrire_meta('barre_typo_generalisee', 'a:6:{s:38:\"rubriques_texte_barre_typo_generalisee\";s:2:\"on\";s:40:\"groupesmots_texte_barre_typo_generalisee\";s:2:\"on\";s:33:\"mots_texte_barre_typo_generalisee\";s:2:\"on\";s:40:\"sites_description_barre_typo_generalisee\";s:2:\"on\";s:48:\"configuration_description_barre_typo_generalisee\";s:2:\"on\";s:42:\"auteurs_quietesvous_barre_typo_generalisee\";s:2:\"on\";}','non');
	ecrire_meta('image_process', 'gd2', 'non');
	ecrire_meta('max_taille_vignettes', '8100000', 'non');
	ecrire_meta('taille_preview', '150', 'non');
	ecrire_meta('gd_formats_read', 'gif,jpg,png', 'non');
	ecrire_meta('gd_formats', 'gif,jpg,png', 'non');
	ecrire_meta('formats_graphiques', 'gif,jpg,png', 'non');
	ecrire_meta('btv2', 'a:1:{s:7:"avancee";s:3:"Oui";}', 'non');
	ecrire_meta('bte', 'a:14:{s:5:"puces";s:3:"Oui";s:14:"titraille1open";s:17:"<h2 class="spip">";s:15:"titraille1close";s:5:"</h2>";s:14:"titraille2open";s:17:"<h3 class="spip">";s:15:"titraille2close";s:5:"</h3>";s:14:"titraille3open";s:17:"<h4 class="spip">";s:15:"titraille3close";s:5:"</h4>";s:14:"titraille4open";s:17:"<h5 class="spip">";s:15:"titraille4close";s:5:"</h5>";s:14:"titraille5open";s:17:"<h6 class="spip">";s:15:"titraille5close";s:5:"</h6>";s:9:"insertcss";s:3:"Non";s:17:"defaultbarrestyle";s:5:"close";s:14:"mode_titraille";N;}', 'non');
	ecrire_meta('ppp', 'a:5:{s:14:"descriptif_ppp";s:0:"";s:9:"chapo_ppp";s:2:"on";s:6:"ps_ppp";s:2:"on";s:29:"configuration_description_ppp";s:2:"on";s:23:"auteurs_quietesvous_ppp";s:2:"on";}', 'non');
	// Activer les crayons dans ecrire, et la barre typo sur les crayons, réduire les images à 400 px de large (au cas où)
	ecrire_config('crayons/barretypo','on');
	ecrire_config('crayons/reduire_logo',400);
	ecrire_config('crayons/espaceprive','on');
	ecrire_config('crayons/exec_autorise','*');
	// Permettre aux webmestres d'éditer les forums (dans le privé et le public, avec les crayons).
	ecrire_config('autorite/editer_forums',1);
	
	ecrire_config('boutonstexte/txtOnly','_');
	ecrire_meta('socialtags', 'a:5:{s:4:"tags";a:7:{i:0;s:0:"";i:1;s:9:"blogmarks";i:2;s:9:"delicious";i:3;s:4:"digg";i:4;s:6:"google";i:5;s:7:"twitter";i:6;s:6:"viadeo";}s:10:"jsselector";s:11:"#socialtags";s:5:"badge";s:0:"";s:7:"badgejs";s:0:"";s:9:"ifreferer";N;}','non');
	if ( $GLOBALS['meta']['nom_site'] == _T('info_mon_site_spip') )
		ecrire_meta('nom_site', 'Mon site SPIP <sub>Squelette SoyezCreateurs</sub>','non');
	spip_log("1. (soyezcreateurs_config_site) metas du plugins ecrite", _LOG_INSTALL);
	return true;
}

// fonction qui permet de trouver si un groupe de mots clés existe à partir du titre
function find_groupe($titre) {
	$titre = addslashes($titre);
	spip_log("1. (find_groupe) recherche des occurences dans la table spip_groupes_mots de l'id de : $titre", _LOG_INSTALL);
	$count = sql_countsel("spip_groupes_mots", "titre='$titre'");
	spip_log("2. (find_groupe) resultat de la recherche : $count occurences pour $titre", _LOG_INSTALL);
	return $count;
}

// fonction pour trouver l'id du groupe de mots clés à partir du titre du groupe
function id_groupe($titre) {
	$titre = addslashes($titre);
	spip_log("1. (id_groupe) selection dans la table spip_groupes_mots de l'id de : $titre", _LOG_INSTALL);
	$result = sql_fetsel("id_groupe", "spip_groupes_mots", "titre='$titre'");
	$resultat = $result['id_groupe'];
	spip_log("2. (id_groupe) selection = $resultat pour $titre", _LOG_INSTALL);
	return $resultat;
}

//fonction qui permet de créer un groupe de mots clés
function create_groupe($groupe, $descriptif='', $texte='', $unseul='non', $obligatoire='non', $tables_liees='', $minirezo='oui', $comite='oui', $forum='non') {
	$id_groupe = find_groupe($groupe);
	spip_log("1. (create_groupe) pret a creer groupe : titre = $groupe. retour de find_groupe = $id_groupe", _LOG_INSTALL);
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
		spip_log("2. (create_groupe) retour de find_groupe : $id_groupe, donc insertion avec id = $id__insert et titre = $groupe", _LOG_INSTALL);
	} 
	else if ($id_groupe > 0) {
		$id_insert = remplacer_groupe($groupe, $descriptif, $texte, $unseul, $obligatoire, $tables_liees, $minirezo, $comite, $forum);
		spip_log("2. (create_groupe) retour de find_groupe : $id_groupe... passage a remplacer_groupe", _LOG_INSTALL);
	}
	return $id_insert;
}

function supprimer_mot_groupe($nom_groupe,$nom_mot) {
	$id_groupe = id_groupe($nom_groupe);
	if ($id_groupe>0) {
		$id_mot = id_mot($nom_mot, $id_groupe);
		if ($id_mot>0) {
			sql_delete("spip_mots", "id_mot=$id_mot");
			sql_delete("spip_mots_liens", "id_mot=$id_mot");
		}
	}
}

function vider_groupe($nom_groupe) {
	$id_groupe = id_groupe($nom_groupe);
	if ($id_groupe>0) {
		$id_mots = sql_select('id_mot',  'spip_mots',  'id_groupe='.sql_quote($id_groupe));
		while($id_mot = sql_fetch($id_mots)){
			sql_delete("spip_mots", "id_mot=".$id_mot['id_mot']);
			sql_delete("spip_mots_liens", "id_mot=".$id_mot['id_mot']);
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
	spip_log("1. (id_mot) debut de recherche de l'id de $titre avec $id_groupe", _LOG_INSTALL);
	$titre = addslashes($titre);
	$result = sql_fetsel(
		"id_mot", 
		"spip_mots", 
		"titre='$titre' AND id_groupe = $id_groupe"
	);
	$id_mot = $result['id_mot'];
	spip_log("2. (id_mot) retour de la fonction id_mot = $id_mot", _LOG_INSTALL);
	return $id_mot;
}

//fonction qui permet de créer un mot clé
function create_mot($groupe, $mot, $descriptif='', $texte='') {
	$id_groupe = id_groupe($groupe);
	$find_mot = find_mot($mot, $id_groupe);
	if ($find_mot == 0) {
		spip_log("1. (create_mot) debut create_mot. mot inexistant donc creation : $id_groupe - $mot", _LOG_INSTALL);
		$id_mot = sql_insertq(
			"spip_mots", array(
				"id_mot" => '',
				"titre" => $mot,
				"descriptif" => $descriptif,
				"texte" => $texte,
				"id_groupe" => $id_groupe,
				"type" => $groupe
			)
		);
		spip_log("2. (create_mot) mot cle $mot insere sous l'id $id_mot dans la table avec groupe = $id_groupe", _LOG_INSTALL);
	}
	else if ($find_mot > 0) {
		$id_mot = id_mot($mot, $id_groupe);
		spip_log("1. (create_mot) mise a jour dans la table du mot cle : $mot", _LOG_INSTALL);
		remplacer_mot($id_mot, $mot, $descriptif, $texte, $id_groupe, $groupe);
	}
	else {
		spip_log("insertion impossible ! debug : groupe = $groupe --- id_groupe = $id_groupe", _LOG_INSTALL);
	}
	return $id_mot;
}

//fonction qui permet de mettre à jour un mot clé 
function remplacer_mot($id_mot, $mot, $descriptif, $texte, $id_groupe, $groupe) {
	sql_updateq(
			"spip_mots", array(
				"titre" => $mot,
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
	spip_log("1. (id_rubrique) recherche de l'id_rubrique de $titre = $resultat", _LOG_INSTALL);
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
		spip_log("rename_rubrique) renommage de $titre en $nouveau_titre", _LOG_INSTALL);
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
		spip_log("1. (create_rubrique) rubrique cree : id = $id_rubrique, titre = $titre", _LOG_INSTALL);
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
	spip_log("1. (id_article) recherche de l'id_article de $titre = $resultat", _LOG_INSTALL);
	return $resultat;
}

//fonction qui permet de créer un article
function create_article($texte, $rubrique, $lang='fr') {
	$id_rubrique = id_rubrique($rubrique);
	$count_articles = find_article($texte['titre'], $id_rubrique);
	if ($count_articles == 0) {
		spip_log("1. (create_article) insertion d'un article : ".$texte['titre'], _LOG_INSTALL);
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
				"nom_site" => $texte['nom_site'],
				"url_site" => $texte['url_site'],
				"virtuel" => $texte['virtuel']
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
		propager_les_secteurs();
		spip_log("2. (create_article) article insere : $id_article", _LOG_INSTALL);
	}
	else if ($count_articles > 0) {
		$id_article = id_article($texte['titre'], $id_rubrique);
		spip_log("2. (create_article) maj de l'article : ".$texte['titre'], _LOG_INSTALL);
		remplacer_article($id_article, $id_rubrique, $texte);
	}
	return $id_article;
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
			"url_site" => $texte['url_site'],
			"virtuel" => $texte['virtuel']
		), "id_article='$id_article' AND id_rubrique = $id_rubrique"
	);
	return true;
}

function poubelle_article($titre_article, $titre_rubrique) {
	$id_rubrique = id_rubrique($titre_rubrique);
	if ($id_rubrique) {
		$id_article = id_article($titre_article, $id_rubrique);
		if ($id_article) {
			sql_updateq("spip_articles", array("statut" => "poubelle"),"id_article=$id_article");
		}
	}
}

// fonction qui permet de trouver si une liaison entre un article et un mot clé existe
function find_article_mot($id_mot, $id_article) {
	$count = sql_countsel(
		"spip_mots_liens", 
		"id_mot = $id_mot AND id_objet = $id_article AND objet='article'"
	);
	return $count;
}

//fonction qui permet de créer une relation entre un article et un mot clé
function create_article_mot($article, $rubrique, $mot, $groupe) {
	spip_log("1. (create_article_mot) demande de creation de liaison : $article avec $mot", _LOG_INSTALL);
	$id_rubrique = id_rubrique($rubrique);
	$id_groupe = id_groupe($groupe);
	$id_mot = id_mot($mot, $id_groupe);
	$id_article = id_article($article, $id_rubrique);
	$count = find_article_mot($id_mot, $id_article);
	if ($count == 0) {
		sql_insertq(
			"spip_mots_liens", 
			array(
				"id_mot"=> $id_mot, 
				"id_objet" => $id_article,
				"objet" => 'article'
			)
		);
		spip_log("2. (create_article_mot) liaison mise en place (article = $id_article - mot = $id_mot)", _LOG_INSTALL);
	}
	else {
		spip_log("2. (create_article_mot) liaison deja existante ! (article = $id_article - mot = $id_mot)", _LOG_INSTALL);
	}
}

//fonction qui permet de trouver des liaisons entre rubrique et mot clé
function find_rubrique_mot($id_mot, $id_rubrique) {
	$count = sql_countsel(
		"spip_mots_liens", 
		"id_mot = $id_mot AND id_objet = $id_rubrique AND objet = 'rubrique'"
	);
	return $count;
}

//fonction qui permet de créer une relation entre une rubrique et un mot clé
function create_rubrique_mot($rubrique, $mot, $groupe) {
	$id_rubrique = id_rubrique($rubrique);
	$id_groupe = id_groupe($groupe);
	$id_mot = id_mot($mot, $id_groupe);
	spip_log("1. (create_rubrique_mot) creation : rubrique = $id_rubrique ($rubrique) - mot = $id_mot ($mot) - groupe = $id_groupe ($groupe)", _LOG_INSTALL);
	$count = find_rubrique_mot($id_mot, $id_rubrique);
	if ($count == 0) {
		sql_insertq(
			"spip_mots_liens", array(
				"id_mot" => $id_mot,
				"id_objet" => $id_rubrique,
				"objet" => 'rubrique'
			)
		);
	}
	return true;
}

function create_evenement($rubrique, $article, $titre_evenement, $debut, $fin, $descriptif = '',$lieu ='', $horaire='oui') {
	$id_rubrique = id_rubrique($rubrique);
	if ($id_rubrique > 0) {
		$id_article = id_article($article, $id_rubrique );
		if ($id_article > 0) {
			sql_insertq(
					"spip_evenements", array(
						"id_article" => $id_article,
						"titre" => $titre_evenement,
						"date_debut" => $debut,
						"date_fin" => $fin,
						"descriptif" => $descriptif,
						"lieu" => $lieu,
						"horaire" => $horaire,
					));
		}
	}
}

//fonction qui permet de trouver l'id d'un auteur à partir de son nom
function find_auteur($nom) {
	$result = sql_fetsel(
		"id_auteur", 
		"spip_auteurs", 
		"nom='$nom'"
	);
	$resultat = $result['id_auteur'];
	spip_log("1. (id_auteur) recherche de l'id_auteur de $nom = $resultat", _LOG_INSTALL);
	return $resultat;
}

//fonction qui permet de trouver l'email d'un auteur à partir de son id
function find_auteur_email($id_auteur) {
	$result = sql_fetsel(
		"email", 
		"spip_auteurs", 
		"id_auteur=$id_auteur"
	);
	$resultat = $result['email'];
	spip_log("1. (email) recherche de l'email de $id_auteur = $resultat", _LOG_INSTALL);
	return $resultat;
}

//fonction qui permet de créer un auteur (sans login ni mot de passe)
function create_auteur($nom, $email='', $bio='') {
	$id_auteur = find_auteur($nom);
	if ($id_auteur > 0) {
		sql_updateq(
			"spip_auteurs", array(
				"email" => $email,
				"bio" => $bio
			), "id_auteur=$id_auteur"
		);
	} else {
		$id_auteur = sql_insertq(
			"spip_auteurs", array(
				"nom" => $nom,
				"email" => $email,
				"bio" => $bio,
				"statut" => '1comite'
			)
		);
	}
	spip_log("1. (create_auteur) auteur cree : id = $id_auteur, nom = $nom", _LOG_INSTALL);
	return $id_auteur;
}


function create_document($chemin, $objet, $mode, $champs='non', $id_document='non') {
	include_spip('action/ajouter_documents');
	$chemin = find_in_path($chemin);
	$type = $objet['type'];
	$id_objet = $objet['id_objet'];
	spip_log(array('tmp_name' => $chemin, 'name' => basename($chemin)), 'docusc');
	if ($id_document = 'non' AND $chemin) {
		$id_document = action_ajouter_un_document_dist('non', array('tmp_name' => $chemin, 'name' => basename($chemin)), $type, $id_objet, $mode);
		if (is_array($champs))
		sql_updateq("spip_documents", $champs, "id_document=$id_document");
		return $id_document;
	}
	else
		return false;
}

function create_logo($chemin, $type='art', $id, $ext, $onoff='on') {
	include_spip('inc/getdocument');
	$file = deplacer_fichier_upload(find_in_path($chemin), _DIR_LOGOS . $type . $onoff . $id . '.' .$ext);
	return $file;
}

//fonction qui permet de trouver l'id d'un site à partir du titre
function id_site($titre, $id_rubrique) {
	$titre = addslashes($titre);
	$result = sql_fetsel(
		"id_syndic", 
		"spip_syndic", 
		"nom_site='$titre' AND id_rubrique = $id_rubrique"
	);
	$resultat = $result['id_syndic'];
	return $resultat;
}

function create_site($site, $rubrique) {
	$id_rubrique = id_rubrique($rubrique);
	$id_site = id_site($site['nom_site'], $id_rubrique);
	if ($id_site > 0) {
		sql_updateq(
			"spip_syndic", array(
				"url_site" => $site['url_site'],
				"url_syndic" => $site['url_syndic'],
				"descriptif" => $site['descriptif'],
				"statut" => $site['statut'] ? $site['statut']:'prop',
				"syndication" => $site['url_syndic'] ? 'oui':'non'
			), "id_syndic='$id_syndic'"
		);
	} else {
		$id_site = sql_insertq(
			"spip_syndic", array(
				"id_rubrique" => $id_rubrique,
				"nom_site" => $site['nom_site'],
				"url_site" => $site['url_site'],
				"url_syndic" => $site['url_syndic'],
				"descriptif" => $site['descriptif'],
				"statut" => $site['statut'] ? $site['statut']:'prop',
				"syndication" => $site['url_syndic'] ? 'oui':'non'
			)
		);
		include_spip('inc/rubriques');
		calculer_rubriques();
		propager_les_secteurs();
	}
	return $id_site;
}

//fonction qui permet de trouver l'id d'un formulaire à partir de l'id textuel
function id_formidable($identifiant) {
	$identifiant = addslashes($identifiant);
	$result = sql_fetsel(
		"id_formulaire", 
		"spip_formulaires", 
		"identifiant='$identifiant'"
	);
	$resultat = $result['id_formulaire'];
	return $resultat;
}

function create_formidable($formidable) {
	$id_formulaire = id_formidable($formidable['identifiant']);
	if ($id_formulaire > 0) {
		sql_updateq(
			"spip_formulaires", array(
				"titre" => $formidable['titre'],
				"descriptif" => $formidable['descriptif'],
				"message_retour" => $formidable['message_retour'],
				"saisies" => $formidable['saisies'],
				"traitements" => $formidable['traitements'],
				"public" => $formidable['public'],
				"statut" => $formidable['statut'],
				"apres" => $formidable['apres'],
				"url_redirect" => $formidable['url_redirect']
			), "id_formulaire='$id_formulaire'"
		);
	} else {
		$id_formulaire = sql_insertq(
			"spip_formulaires", array(
				"identifiant" => $formidable['identifiant'],
				"titre" => $formidable['titre'],
				"descriptif" => $formidable['descriptif'],
				"message_retour" => $formidable['message_retour'],
				"saisies" => $formidable['saisies'],
				"traitements" => $formidable['traitements'],
				"public" => $formidable['public'],
				"statut" => $formidable['statut'],
				"apres" => $formidable['apres'],
				"url_redirect" => $formidable['url_redirect']
			)
		);
		include_spip('inc/rubriques');
	}
	return $id_formulaire;
}

//fonction qui permet de trouver des liaisons entre site et mot clé
function find_site_mot($id_mot, $id_syndic) {
	$count = sql_countsel(
		"spip_mots_liens", 
		"id_mot = $id_mot AND id_objet = $id_syndic AND objet = 'site'"
	);
	return $count;
}
function create_site_mot($id_syndic, $mot, $groupe) {
	$id_groupe = id_groupe($groupe);
	$id_mot = id_mot($mot, $id_groupe);
	$count = find_site_mot($id_mot, $id_rubrique);
	if ($count == 0) {
		sql_insertq(
			"spip_mots_liens", array(
				"id_mot" => $id_mot,
				"id_objet" => $id_syndic,
				"objet" => 'site'
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
	create_groupe("Thèmes de l'Agenda", "Détermine la liste des éléments pouvant être présentés en liste déroulante dans l'Agenda du site", "Un événement de l'Agenda peut avoir un ou {{plusieurs}} mot clefs ratachés (les sélectionner avec maj-clic).", 'non', 'non', 'evenements', 'oui', 'oui', 'non');
	create_groupe("_AgendaStatut", "Statut d'un événement dans l'Agenda", "Permet de spécifier un statut d'un événement dans l'Agenda.\n\nL'événement sera affiché dans la couleur spécifiée par le {Texte} du Mot Clef.\n\nLe {Descriptif rapide} sera quant à lui utilisé en bulle d'aide.", 'oui', 'oui', 'evenements', 'oui', 'oui', 'non');
	create_groupe("_ClasseRubriqueMenu", "Pour affecter une classe spécifique aux éléments du menu", "", 'oui', 'non', 'rubriques', 'oui', 'non', 'non');
		create_mot("_ClasseRubriqueMenu", "separation", "Affecter ce mot clef aux rubriques qui doivent être affichée avec une séparation dans le menu.", "");
	create_groupe("_CouleurRubrique", "Permet de changer la couleur d'une Rubrique.", "Affecter un mot clef de ce groupe à une rubrique (et ses descendants) pour en changer la tonalité de couleur.\n\nPour chacun des mots clefs, mettre en titre quelque chose d'intelligible, un éventuel descriptif rapide sur l'usage à en faire et le code hexadecimal de la couleur dans le texte. \n\nExemple : \n-* Titre: Orange\n-* Texte : f78221", 'oui', 'non', 'rubriques', 'oui', 'non', 'non');
		create_mot("_CouleurRubrique", "Bleu", "", "6392A9");
		create_mot("_CouleurRubrique", "Marron clair", "", "9F7561");
		create_mot("_CouleurRubrique", "Turkoise pastel", "", "89A699");
	create_groupe("_HTTP-EQUIV", "Paramétrage du site", "Paramétrage des entêtes HTML HTTP-EQUIV.\n\nÀ utiliser en sachant pourquoi.", 'non', 'non', '', 'oui', 'non', 'non');
		create_mot("_HTTP-EQUIV", "pics-label", "Mettre ci-dessous le contenu du label ICRA (XHTML) généré depuis [->http://www.icra.org/].\n\nIl s'agit d'une démarche volontaire du responsable du site visant à indiquer si le site peut ou non être visité sans dommage par des enfants.", "");
	create_groupe("_InformationsLegales", "Mentions légales obligatoire ([CNIL|Commision Nationale Informatique et Liberté->http://www.cnil.fr/] et [LcEN|Loi sur la confiance en l'Économie Numérique->http://www.legifrance.gouv.fr/WAspad/UnTexteDeJorf?numjo=ECOX0200175L])", "[Décryptage des obligations légales->http://maitre.eolas.free.fr/journal/index.php?2005/05/27/135-responsabilite-du-blogueur].", 'non', 'non', 'non', 'non', 'non', 'non', 'non', 'oui', 'non', 'non');
		create_mot("_InformationsLegales", "10. Propriétaire du site", "Mettre les coordonnées du propriétaire du site ci-dessous", "");
		create_mot("_InformationsLegales", "20. Hébergeur", "Mettre les coordonnées de l'hébergeur ci-dessous", "[Siegler informatique->http://www.siegler-informatique.fr/], hébergeur SPIP + SoyezCreateurs");
		create_mot("_InformationsLegales", "30. Liens vers ce site", "Mettre ci-dessous les conditions d'utilisation du contenu", "Le site autorise tout site Internet ou tout autre support à le citer ou à mettre en place un lien hypertexte pointant vers son contenu.\n\nL'autorisation de mise en place d'un lien est valable pour tout support, à l'exception de ceux diffusant des informations à caractère polémique, pornographique, xénophobe ou pouvant, dans une plus large mesure porter atteinte à la sensibilité du plus grand nombre.\n\nLa reprise intégrale du contenu d'une page est aussi autorisée, sous réserve d'établir un lien clair vers sa source. C'est la [licence CC-By-SA|Paternité-Partage des Conditions Initiales à l'Identique 2.0 France->http://creativecommons.org/licenses/by-sa/2.0/fr/] qui s'applique.");
		create_mot("_InformationsLegales", "35. Traitement automatisé d'informations nominatives", "", "Ce site ne collecte sur les visiteurs du site aucune autre information nominative ou personnelle que celles qui lui sont ouvertement et volontairement fournies en particulier par l'intermédiaire des adresses électroniques de ses correspondants.\n\nNous vous rappelons que vous disposez d'un droit d'accès, de modification, de rectification et de suppression des données vous concernant (article 34 de la loi \"Informatique et Libertés\" du 6 janvier 1978). \nPour exercer ce droit, contactez-nous.\n");
		create_mot("_InformationsLegales", "40. Réalisation", "Mettre ci-dessous les informations concernant la réalisation de ce site.", "Ce site a été réalisé par [Mantalo.net|Création de sites web->http://www.mantalo-conseil.fr/] en utilisant l'outil [SPIP->http://www.spip.net/].\n\n[Mantalo.net|Création de sites web->http://www.mantalo-conseil.fr/] a réalisé ce site dans les respect des [normes pour l'accessibilité->http://www.pyrat.net/Accessibilite-d-un-site-web,193.html] des sites web à tous.");
	create_groupe("_LayoutGala", "Permet de faire appel à l'une des 40 mises en page disponibles sur [Layout Gala->http://blog.html.it/layoutgala/]", "Mode d'emploi : affecter un des mots mots clefs de ce groupe à un objet de SPIP (Articles, Rubriques, Brèves, Sites) permet de lui affecter la mise en page associée", 'oui', 'non', 'articles,breves,rubriques,syndic', 'oui', 'non', 'non');
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
	create_groupe("_LogosExtra", "Permet de placer une image en fond de la colonne Extra (c'est-à-dire, soit la colonne secondaire qui peut être afichée soit de l'autre côté du menu, soit en dessous de celui-ci).", "{{Utilisation}} : affecter un ou plusieurs mots clefs de ce groupe aux rubriques (héritage automatique) qui doivent avoir une ou plusieurs image en fond. L'image est choisie aléatoirement parmis celles disponibles.\n\n{{Configuration}} : \n-* créer des mots clefs dans ce groupe et leur donner un logo de mot clef.\n-* il est possible de mettre un logo de survol qui sera alors utilisé en fond de texte (en plus de l'autre logo) et positionné en haut à droite sauf si le texte contient les ordres CSS de positionnement ({bottom left} par exemple)", 'non', 'non', 'rubriques', 'oui', 'non', 'non');
	create_groupe("_META", "Paramètrage du site", "Permet de spécifier des META pour le site.\n\nIl est possible de rajouter des METAs non encore présents, mais, comme d'habitude en la matière : sachez ce que vous faites !", 'non', 'non', '', 'oui', 'non', 'non');
		create_mot("_META", "ICBM", "Mettre la latitude et la longitude du lieu sous la forme : XX.XXXXX,XX.XXXXX (ex: 45.3393,1.06292)\n_ Pour trouver vos coordonnées : [Multimap->http://www.multimap.com/]\n_ Et [vous référencer sur GeoURL->http://geourl.org/ping/]", "");
		create_mot("_META", "Keywords", "Mettre ci-dessous les mots clef du site séparés par des virgules", "");
	create_groupe("_ModePortail", "Les mots clefs de ce groupe permettent de gérer les éléments qui s'affichent sur la page d'accueil du site si celui-ci est en mode portail.", "Les mots clefs numérotés dans leur titre de 0. à 9. verront leur logo utilisé dans les colonnes de gauche et de droite de la page d'accueil (respectivement pour les numéros impairs et pairs).", 'oui', 'non', 'articles,rubriques', 'oui', 'non', 'non');
		create_mot("_ModePortail", "1. Mot1", "", "");
		create_mot("_ModePortail", "2. Mot2", "", "");
		create_mot("_ModePortail", "Goodies", "Affecter ce mot clef aux objets SPIP devant apparaitre dans la zone des Goodies.", "Ne pas oublier de mettre un logo (120×30) aux objet concernés.");
		create_mot("_ModePortail", "ZoomSur", "Affecter ce mot clef à l'objet que vous voulez placer dans le cadre « Zoom sur » (facultatif).\n\nLe site prendra les 3 derniers articles ayant ce mot clef", "S'applique aux :\n-* articles\n-* rubriques");
	create_groupe("_Specialisation", "Spécialisation d'un article ", "Un mot clef pris dans ce groupe permettra de modifier\n\n-* le comportement d'un article particulier\n", 'non', 'non', 'articles', 'oui', 'oui', 'non');
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
	create_groupe("_Specialisation_Rubrique", "Spécialisation d'une rubrique", "Un mot clef pris dans ce groupe permettra de modifier\n\n-* le comportement d'une rubrique et de ses articles\n", 'non', 'non', 'rubriques', 'oui', 'oui', 'non');
		create_mot("_Specialisation_Rubrique", "AfficherArticlesMenu", "Affichage des articles de la rubrique dans le menu de gauche", "Affecter ce mot clef aux rubriques dont la liste des articles doit être affichée dans le menu de gauche.");
		create_mot("_Specialisation_Rubrique", "Agenda", "Pour dire qu'une rubrique est dans l'Agenda", "Il est impératif de mettre ce mot clef pour la rubrique à la racine ayant cette caractéristique (inutile pour les sous rubriques de cette rubrique).");
		create_mot("_Specialisation_Rubrique", "Citations", "Rubrique destinée à recevoir de courtes citations (une par article) affichées en haut à droite des pages du site de manière alléatoire (une nouvelle citation toutes les heures)", "Créer un article par citation avec :\n\n-* La citation dans le corps du texte (entourée de guillemets si nécessaires)\n-* L'auteur dans le sous-titre\n-* Le titre de l'article sert d'accroche pour le lecteur\n");
		create_mot("_Specialisation_Rubrique", "DessousBreves", "Pour placer une rubrique et ses articles qui sont placés sous les brèves (dans la colonne de droite du site)", "[*Attention*] : une rubrique qui a ce mot clef ne doit pas avoir de sous-rubrique !\n\nLe titre de la rubrique sera affiché sur la droite et la liste de ses articles en dessous.\n\nSeuls les articles sont clicables pour accéder à leur contenu.");
		create_mot("_Specialisation_Rubrique", "MenuHaut", "Pour qu'un secteur soit dans un menu horizontal en haut du site", "Affecter ce mot clef aux secteurs (rubriques rattachées à la racine du site) qui doivent être dans le menu horizontal en haut du site.");
		create_mot("_Specialisation_Rubrique", "PasDansMenu", "Pour interdire que la rubrique (et ses sous-rubriques) soi(en)t dans le menu de gauche", "");
		create_mot("_Specialisation_Rubrique", "PasDansPlan", "Permet de masquer une rubrique, et tout son contenu (y compris les sous-rubriques) du plan du site", "À affecter aux rubriques qui ne doivent pas être affichées dans le plan du site");
		create_mot("_Specialisation_Rubrique", "SecteurPasDansQuoiDeNeuf", "Pour interdire que les articles d'un secteur entier soit dans «Quoi de Neuf» sur la page d'accueil", "Un secteur, c'est une rubrique rattachée à la racine du site et toutes ses sous-rubriques");
	create_groupe("_Specialisation_Rubrique_ou_Article", "Spécialisation d'une rubrique ou d'un article", "Un mot clef pris dans ce groupe permettra de modifier\n\n-* le comportement d'une rubrique et de ses articles\n-* le comportement d'un article particulier", 'non', 'non', 'articles,rubriques', 'oui', 'oui', 'non');
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
		$id_article3 = create_article($article3, '000. Fourre-tout');
		create_article_mot($article3['titre'], '000. Fourre-tout', "MENURACINEBAS_Systematique", "_Specialisation");
	$article4 = trouve_article_sc('Économies');
		create_article($article4, '999. Citations');
	$article5 = trouve_article_sc('Concision');
		create_article($article5, '999. Citations');
	$article5b = trouve_article_sc('Force');
		create_article($article5b, '999. Citations');
	$id_doc = create_document('documents/contact.jpg', 
		null, 
		'image',
		array('titre' => 'Contactez-nous', 'descriptif' => 'Clavier de téléphone...')); 
	$article6 = trouve_article_sc("Raccourcis Typographiques de SPIP, mode d'emploi");
		$article6['texte'] = str_replace('<img1', "<img$id_doc>", $article6['texte']);
		$article6['texte'] = str_replace('<doc1', "<doc$id_doc>", $article6['texte']);
		create_article($article6, "000. Fourre-tout");
		create_article_mot($article6['titre'], "000. Fourre-tout", "ALaUne", "_Specialisation");
	
	return true;
}
?>