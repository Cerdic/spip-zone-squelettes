<?php
// =======================================================================================================================================
// Balise : #VERSION_SQUELETTE
// =======================================================================================================================================
// Auteur: Smellup
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
// Auteur: Smellup
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

	if ( $j == 'aujourdhui' ) {
		$auj = date('Y-m-d',strtotime(date('Y-m-d')));
		$query = "SELECT visites AS visites FROM spip_visites WHERE date='$auj'";
		$result = spip_query($query);
		$visites_auj = 0;
		if ($row = @spip_fetch_array($result)) {
			$visites_auj = $row['visites'];
		}
		$r = $visites_auj;
	}
	else if ( $j == 'hier' ) {
		$hier = date('Y-m-d',strtotime(date('Y-m-d')) - 3600*24);
		$query = "SELECT visites AS visites FROM spip_visites WHERE date='$hier'";
		$result = spip_query($query);
		$visites_hier = 0;
		if ($row = @spip_fetch_array($result)) {
			$visites_hier = $row['visites'];
		}
		$r = $visites_hier;
	}
	else {
		$query = "SELECT SUM(visites) AS total_absolu FROM spip_visites";
		$result = spip_query($query);
		$visites_debut = 0;
		if ($row = @spip_fetch_array($result)) {
			$visites_debut = $row['total_absolu'];
		}
		$r = $visites_debut;
	}
	return $r;
}

// =======================================================================================================================================
// Balise : #INTRODUCTION (surcharge)
// =======================================================================================================================================
// Auteur: Smellup
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
// Auteur: Smellup
// Fonction : retourne la date du jour independamment du contexte d'appel
// =======================================================================================================================================
//
function balise_AUJOURDHUI($p) {

	$p->code = 'date("Y-m-d H:i")';
	$p->statut = 'php';
	return $p;
}

// =======================================================================================================================================
// Balise : #RUBRIQUE_AGENDA
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : retourne la valeur de l'ID de la rubrique faisant office d'agenda (associe au mot-cle agenda)
// =======================================================================================================================================
//
function balise_RUBRIQUE_AGENDA($p) {

	$p->code = 'calcul_rubrique_agenda()';
	$p->statut = 'php';
	return $p;
}

function calcul_rubrique_agenda() {

	$query = "SELECT id_rubrique AS id_rubrique FROM spip_mots_rubriques, spip_mots, spip_groupes_mots 
	WHERE spip_groupes_mots.titre='squelette_habillage' AND spip_groupes_mots.id_groupe=spip_mots.id_groupe AND spip_mots.titre='agenda' AND spip_mots.id_mot=spip_mots_rubriques.id_mot";
	$result = spip_query($query);
	$id_rubrique = 0;
	if ($row = @spip_fetch_array($result)) {
		$id_rubrique = $row['id_rubrique'];
	}
	return $id_rubrique;
}

// =======================================================================================================================================
// Balise : #RUBRIQUE_GALERIE
// =======================================================================================================================================
// Auteur: Smellup
// Fonction : retourne la valeur de l'ID de la rubrique faisant office de galerie (associee au mot-cle galerie)
// =======================================================================================================================================
//
function balise_RUBRIQUE_GALERIE($p) {

	$p->code = 'calcul_rubrique_galerie()';
	$p->statut = 'php';
	return $p;
}

function calcul_rubrique_galerie() {

	$query = "SELECT id_rubrique AS id_rubrique FROM spip_mots_rubriques, spip_mots, spip_groupes_mots 
	WHERE spip_groupes_mots.titre='squelette_habillage' AND spip_groupes_mots.id_groupe=spip_mots.id_groupe AND spip_mots.titre='galerie' AND spip_mots.id_mot=spip_mots_rubriques.id_mot";
	$result = spip_query($query);
	$id_rubrique = 0;
	if ($row = @spip_fetch_array($result)) {
		$id_rubrique = $row['id_rubrique'];
	}
	return $id_rubrique;
}
?>