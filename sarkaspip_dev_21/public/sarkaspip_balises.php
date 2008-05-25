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
	$p->interdire_scripts = false;
	return $p;
}

function calcul_version_squelette() {

	$version = NULL;
	
	if (lire_fichier(_DIR_PLUGIN_SARKASPIP.'/plugin.xml', $contenu)
	&& preg_match('/<version>([0-9.]+)<\/version>/', $contenu, $match))
		$version .= trim($match[1]);

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

	$jour = interprete_argument_balise(1,$p);
	$jour = isset($jour) ? str_replace('\'', '"', $jour) : '"depuis_debut"';

	$p->code = 'calcul_visites_site('.$jour.')';
	$p->statut = 'php';
	return $p;
}

function calcul_visites_site($j) {

	$visites = 0;
	
	if ( $j == 'aujourdhui' ) {
		$auj = date('Y-m-d',strtotime(date('Y-m-d')));
		$select = array('visites');
		$from = array('spip_visites');
		$where = array("date=".sql_quote($auj));
		$result = sql_select($select, $from, $where);
		if ($row = sql_fetch($result)) {
			$visites = $row['visites'];
		}
	}
	else if ( $j == 'hier' ) {
		$hier = date('Y-m-d',strtotime(date('Y-m-d')) - 3600*24);
		$select = array('visites');
		$from = array('spip_visites');
		$where = array("date=".sql_quote($hier));
		$result = sql_select($select, $from, $where);
		if ($row = sql_fetch($result)) {
			$visites = $row['visites'];
		}
	}
	else {
		$select = array('SUM(visites) AS total_absolu');
		$from = array('spip_visites');
		$result = sql_select($select, $from);
		if ($row = sql_fetch($result)) {
			$visites = $row['total_absolu'];
		}
	}
	return $visites;
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
// Fonction : retourne la valeur de l'ID de la rubrique demandee ou de toutes les rubriques specialisees sous forme de regex
//            Pour creer une nouvelle rubrique specialisee il suffit de rajouter un mot dans le tableau des mots reserves ($mots_reserves)
// =======================================================================================================================================
//
function balise_RUBRIQUE_SPECIALISEE($p) {

	$mot_rubrique = interprete_argument_balise(1,$p);
	$mot_rubrique = isset($mot_rubrique) ? str_replace('\'', '"', $mot_rubrique) : '""';

	$p->code = 'calcul_rubrique_specialisee('.strtolower($mot_rubrique).')';
	$p->interdire_scripts = false;
	return $p;
}

function calcul_rubrique_specialisee($mot) {

	$mots_reserves = explode(':', _SARKASPIP_MOT_RUBRIQUES_SPE);
    if (defined(_PERSO_MOT_RUBRIQUES_SPE))
    	if (_PERSO_MOT_RUBRIQUES_SPE != '')
	    	$mots_reserves = array_merge($mots_reserves, explode(':', _PERSO_MOT_RUBRIQUES_SPE));
	$types_reserves = explode(':', _SARKASPIP_TYPE_RUBRIQUES_SPE);
    if (defined(_PERSO_TYPE_RUBRIQUES_SPE))
    	if (_PERSO_TYPE_RUBRIQUES_SPE != '')
	    	$types_reserves = array_merge($types_reserves, explode(':', _PERSO_TYPE_RUBRIQUES_SPE));
	$fonds_reserves = explode(':', _SARKASPIP_FOND_RUBRIQUES_SPE);
    if (defined(_PERSO_FOND_RUBRIQUES_SPE))
    	if (_PERSO_FOND_RUBRIQUES_SPE != '')
	    	$fonds_reserves = array_merge($fonds_reserves, explode(':', _PERSO_FOND_RUBRIQUES_SPE));
	
	$id = NULL;
	if (in_array($mot, $mots_reserves)) {
		$cle = array_search($mot, $mots_reserves);
	    $id = calcul_rubrique($mot, $types_reserves[$cle], $fonds_reserves[$cle]);
	}
	else {
		$id .= '^(';
		reset($mots_reserves);
		while (list($cle, $valeur) = each($mots_reserves)) {
			$id .= (($cle != 0) ? '|' : '').calcul_rubrique($valeur, $types_reserves[$cle], $fonds_reserves[$cle]); 
		}
		$id .= ')$';
	}

	return $id;
}

function calcul_rubrique($mot, $type, $fond) {

	$id_rubrique = 0;
	if (!$mot)
		return $id_rubrique;

	if ($type == 'motcle') {
		$select = array('id_rubrique');
		$from = array('spip_mots_rubriques AS t1', 'spip_mots AS t2', 'spip_groupes_mots AS t3');
		$where = array('t3.titre='.sql_quote('squelette_habillage'),
					   't3.id_groupe=t2.id_groupe',
					   't2.titre='.sql_quote($mot),
					   't2.id_mot=t1.id_mot');
		$result = sql_select($select, $from, $where);
		if ($row = sql_fetch($result)) {
			$id_rubrique = $row['id_rubrique'];
		}
	}
	else if ($type == 'config') {
		if (function_exists('lire_config')) {
			$valeur = lire_config($fond.'/rubrique_'.$mot);
			if ($valeur != NULL) $id_rubrique = $valeur;
		}
	}
	
	return $id_rubrique;
}

?>