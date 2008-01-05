<?php
// =======================================================================================================================================
// Balise : #VERSION_SQUELETTE
// =======================================================================================================================================
// Auteur: SarkASmeL
// Fonction : affiche la version utilise du squelette variable globale $version_squelette
// =======================================================================================================================================
//
function balise_VERSION_SQUELETTE($p) {
	$p->code = 'calcul_version_squelette()';
	$p->statut = 'php';
	return $p;
}

function calcul_version_squelette() {

	$version = NULL;
	
	$plugins_actifs = liste_plugin_actifs();
	$infos_plug = plugin_get_infos($plugins_actifs['SARKASPIP']['dir']);
	$version .= $infos_plug['version'];
	
	$revision = version_svn_courante(_DIR_PLUGIN_SARKASPIP);
	if ($revision > 0)
		$version .= ' ['.strval($revision).']';
	else if ($revision < 0)
		$version .= ' ['.strval(abs($revision)).'&nbsp;<strong>svn</strong>]';

	return $version;
}

// =======================================================================================================================================
// Balise : #VISITES_SITE
// =======================================================================================================================================
// Auteur: SarkASmeL
// Fonction : affiche le nombre de visites sur le site pour le jour courant, la veille ou depuis le debut
// Parametre: aujourdhui, hier, depuis_debut (ou vide)
// =======================================================================================================================================
//
function balise_VISITES_SITE($p) {

	if ($a = $p->param) {
		$sinon = array_shift($a);
		if  (!array_shift($sinon)) {
			$p->fonctions = $a;
			array_shift( $p->param );
			$jour = array_shift($sinon);
			$jour = ($jour[0]->type=='texte') ? $jour[0]->texte : '';
		}
	}
	else {
		$jour = 'depuis_debut';
	}

	$p->code = 'calcul_visites_site('.$jour.')';
	$p->statut = 'php';
	return $p;
}

function calcul_visites_site($j) {

	$visites = 0;
	
	if ( $j == 'aujourdhui' ) {
		$auj = date('Y-m-d',strtotime(date('Y-m-d')));
		$requete['SELECT'] = array('visites');
		$requete['FROM'] = array('spip_visites');
		$requete['WHERE'] = array("date=".sql_quote($auj));
		$result = sql_select($requete['SELECT'], $requete['FROM'], $requete['WHERE']);
		if ($row = sql_fetch($result)) {
			$visites = $row['visites'];
		}
	}
	else if ( $j == 'hier' ) {
		$hier = date('Y-m-d',strtotime(date('Y-m-d')) - 3600*24);
		$requete['SELECT'] = array('visites');
		$requete['FROM'] = array('spip_visites');
		$requete['WHERE'] = array("date=".sql_quote($hier));
		$result = sql_select($requete['SELECT'], $requete['FROM'], $requete['WHERE']);
		if ($row = sql_fetch($result)) {
			$visites = $row['visites'];
		}
	}
	else {
		$requete['SELECT'] = array('SUM(visites) AS total_absolu');
		$requete['FROM'] = array('spip_visites');
		$result = sql_select($requete['SELECT'], $requete['FROM']);
		if ($row = sql_fetch($result)) {
			$visites = $row['total_absolu'];
		}
	}
	return $visites;
}

// =======================================================================================================================================
// Balise : #INTRODUCTION (surcharge)
// =======================================================================================================================================
// Auteur: SarkASmeL
// Fonction : Surcharge de la fonction standard de calcul de la balise #INTRODUCTION. Permet de definir la taille en nombre de caracteres
// =======================================================================================================================================
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
			else if (substr($chapo, 0, 1) == '=')	// article virtuel
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

// =======================================================================================================================================
// Balise : #AUJOURDHUI
// =======================================================================================================================================
// Auteur: SarkASmeL
// Fonction : retourne la date du jour independamment du contexte d'appel
// =======================================================================================================================================
//
function balise_AUJOURDHUI($p) {

	$p->code = 'date("Y-m-d H:i")';
	$p->statut = 'php';
	return $p;
}

// =======================================================================================================================================
// Balise : #RUBRIQUE_SPECIALISEE
// =======================================================================================================================================
// Auteur: SarkASmeL
// Fonction : retourne la valeur de l'ID de la rubrique demandee ou de toutes les rubriques specialisees
// =======================================================================================================================================
//
function balise_RUBRIQUE_SPECIALISEE($p) {

	$mot_rubrique = interprete_argument_balise(1,$p);
	$mot_rubrique = isset($mot_rubrique) ? str_replace('\'', '"', $mot_rubrique) : '""';

	$p->code = 'calcul_rubrique_specialisee('.$mot_rubrique.')';
	$p->interdire_scripts = false;
	return $p;
}

function calcul_rubrique_specialisee($mot) {

	$ret = NULL;
	switch(strtolower($mot)) {
		case 'agenda':
		    $ret = calcul_rubrique_agenda();
		    break;
		case 'galerie':
		    $ret = calcul_rubrique_galerie();
		    break;
		case 'annonce':
		    $ret = calcul_rubrique_annonce();
		    break;
		default:
			$ret .= '^(';
			$ret .= calcul_rubrique_agenda();
			$ret .= '|'.calcul_rubrique_galerie();
			$ret .= '|'.calcul_rubrique_annonce();
			$ret .= ')$';
			break;
	}
	return $ret;
}

// =======================================================================================================================================
// Balise : #RUBRIQUE_AGENDA
// =======================================================================================================================================
// Auteur: SarkASmeL
// Fonction : retourne la valeur de l'ID de la rubrique faisant office d'agenda (associe au mot-cle agenda)
// =======================================================================================================================================
//
function balise_RUBRIQUE_AGENDA($p) {

	$p->code = 'calcul_rubrique_agenda()';
	$p->statut = 'php';
	return $p;
}

function calcul_rubrique_agenda() {

	$id_rubrique = 0;

	$requete['SELECT'] = array('id_rubrique');
	$requete['FROM'] = array('spip_mots_rubriques', 'spip_mots', 'spip_groupes_mots');
	$requete['WHERE'] = array("spip_groupes_mots.titre='squelette_habillage' AND spip_groupes_mots.id_groupe=spip_mots.id_groupe AND spip_mots.titre='agenda' AND spip_mots.id_mot=spip_mots_rubriques.id_mot");
	$result = sql_select($requete['SELECT'], $requete['FROM'], $requete['WHERE']);
	if ($row = sql_fetch($result)) {
		$id_rubrique = $row['id_rubrique'];
	}

	return $id_rubrique;
}

// =======================================================================================================================================
// Balise : #RUBRIQUE_GALERIE
// =======================================================================================================================================
// Auteur: SarkASmeL
// Fonction : retourne la valeur de l'ID de la rubrique faisant office de galerie (associee au mot-cle galerie)
// =======================================================================================================================================
//
function balise_RUBRIQUE_GALERIE($p) {

	$p->code = 'calcul_rubrique_galerie()';
	$p->statut = 'php';
	return $p;
}

function calcul_rubrique_galerie() {

	$id_rubrique = 0;

	$requete['SELECT'] = array('id_rubrique');
	$requete['FROM'] = array('spip_mots_rubriques', 'spip_mots', 'spip_groupes_mots');
	$requete['WHERE'] = array("spip_groupes_mots.titre='squelette_habillage' AND spip_groupes_mots.id_groupe=spip_mots.id_groupe AND spip_mots.titre='galerie' AND spip_mots.id_mot=spip_mots_rubriques.id_mot");
	$result = sql_select($requete['SELECT'], $requete['FROM'], $requete['WHERE']);
	if ($row = sql_fetch($result)) {
		$id_rubrique = $row['id_rubrique'];
	}

	return $id_rubrique;
}

// =======================================================================================================================================
// Balise : #RUBRIQUE_ANNONCE
// =======================================================================================================================================
// Auteur: SarkASmeL
// Fonction : retourne la valeur de l'ID de la rubrique faisant office de panneau annonceur (associee au mot-cle annonce)
// =======================================================================================================================================
//
function balise_RUBRIQUE_ANNONCE($p) {

	$p->code = 'calcul_rubrique_annonce()';
	$p->statut = 'php';
	return $p;
}

function calcul_rubrique_annonce() {

	$id_rubrique = 0;

	$requete['SELECT'] = array('id_rubrique');
	$requete['FROM'] = array('spip_mots_rubriques', 'spip_mots', 'spip_groupes_mots');
	$requete['WHERE'] = array("spip_groupes_mots.titre='squelette_habillage' AND spip_groupes_mots.id_groupe=spip_mots.id_groupe AND spip_mots.titre='annonce' AND spip_mots.id_mot=spip_mots_rubriques.id_mot");
	$result = sql_select($requete['SELECT'], $requete['FROM'], $requete['WHERE']);
	if ($row = sql_fetch($result)) {
		$id_rubrique = $row['id_rubrique'];
	}

	return $id_rubrique;
}
?>