<?php

// Filtre pour afficher les statistiques d'un mot-clé
// Code inspiré de la fonction presenter_groupe_mots_boucle dans ecrire/inc/grouper_mots.php

function filtre_statistiques_mot_dist($id_mot){
	include_spip('base/abstract_sql');
	$texte_lie = array();
	$id_mot = intval($id_mot);
	
	$na = sql_countsel('spip_mots_articles',"id_mot=$id_mot");
	if ($na == 1)
		$texte_lie[] = _T('info_1_article');
	else if ($na > 1)
		$texte_lie[] = $na." "._T('info_articles_02');

	$nb = sql_countsel('spip_mots_breves',"id_mot=$id_mot");
	if ($nb == 1)
		$texte_lie[] = _T('info_1_breve');
	else if ($nb > 1)
		$texte_lie[] = $nb." "._T('info_breves_03');

	$ns = sql_countsel('spip_mots_syndic',"id_mot=$id_mot");
	if ($ns == 1)
		$texte_lie[] = _T('info_1_site');
	else if ($ns > 1)
		$texte_lie[] = $ns." "._T('info_sites');

	$nr = sql_countsel('spip_mots_rubriques',"id_mot=$id_mot");
	if ($nr == 1)
		$texte_lie[] = _T('info_une_rubrique_02');
	else if ($nr > 1)
		$texte_lie[] = $nr." "._T('info_rubriques_02');

	$texte_lie = pipeline('afficher_nombre_objets_associes_a',array('args'=>array('objet'=>'mot','id_objet'=>$id_mot),'data'=>$texte_lie));
	$texte_lie = join($texte_lie,", ");
	return $texte_lie;
}

// Critère compteur_publie
// Provient de http://www.spip-contrib.net/Classer-les-articles-par-nombre-de-commentaires

function critere_compteur_publie($idb, &$boucles, $crit){
 $op='';
 $boucle = &$boucles[$idb];
 $params = $crit->param;
 $type = array_shift($params);
 $type = $type[0]->texte;
 if(preg_match(',^(\w+)([<>=])([0-9]+)$,',$type,$r)){
     $type=$r[1];
     $op=$r[2];
     $op_val=$r[3];
 }
 $type_id = 'compt.id_'.$type;
 $type_requete = $boucle->type_requete;
 $id_table = $boucle->id_table . '.' . $boucle->primary;
 $boucle->select[]= 'COUNT('.$type_id.') AS compteur_'.$type;
 $boucle->from['compt']="spip_".$type;
 $boucle->from_type['compt']= "LEFT";
 // On passe par cette jointure pour que les articles avec 0 commentaires soient comptés
 // Merci notation !
 $boucle->join["compt"]= array("'$boucle->id_table'","'$boucle->primary'","'$boucle->primary'","'compt.statut='.sql_quote('publie')");
 $boucle->group[]=$id_table;
 if ($op)
     $boucle->having[]= array("'".$op."'", "'compteur_".$type."'",$op_val);
} 

// On préfixe avec AVELINE pour éviter conflit avec d'autres plugins
// comme afficher_objet qui définit sont propre #COMPTEUR_ARTICLES

function balise_AVELINE_COMPTEUR_FORUM_dist($p) {
	$p->code = '$Pile[$SP][\'compteur_forum\']';
	$p->interdire_scripts = false;
	return $p;
}

function balise_AVELINE_COMPTEUR_ARTICLES_dist($p) {
	$p->code = '$Pile[$SP][\'compteur_articles\']';
	$p->interdire_scripts = false;
	return $p;
}

// Critère archives pour afficher uniquement les objets d'une date donnée, par exemple en passant à l'URL ?archives=2010-02
// Repris du plugin minical
function critere_archives($idb, &$boucles, $crit, $var_date = 'archives') {
	$boucle = &$boucles[$idb];
	$champ_date = "'" . $boucle->id_table ."." .$GLOBALS['table_date'][$boucle->type_requete] . "'";
	$boucle->where[] = array(
		'REGEXP',
		$champ_date, 
		"sql_quote(('^' . interdire_scripts(entites_html(\$Pile[0]['".$var_date."']))))"
	);
}

// Balise #ME
// Source : http://www.spip-contrib.net/me-Moi-and-myself

/***
 * (c)James 2006, Licence GNU/GPL
 * |me compare un id_auteur, par exemple,
 * d'une boucle FORUMS avec les auteurs d'un article
 * et renvoie la valeur booleenne true (vrai) si on trouve
 *  une correspondance
 * utilisation: 
 * <div id="forum#ID_FORUM"[(#ID_ARTICLE|me{#ID_AUTEUR}|?{' ', ''})class="me"]>
 ***/
function me($id_article, $id_auteur, $sioui = true, $sinon = false) {
	static $deja = false;
	static $auteurs = array();
	if(!$deja) {
		$r = spip_query("SELECT id_auteur
			FROM spip_auteurs_articles
			WHERE id_article=$id_article");
		while($row = spip_fetch_array($r))
			$auteurs[] = intval($row['id_auteur']);
		$deja = true;
	}
	return in_array($id_auteur, $auteurs)?$sioui:$sinon;
}

function balise_ME($p){
	$p->code = "me(".
		champ_sql('id_article', $p).', '.
		champ_sql('id_auteur', $p).', '.
		"'me', '')";
	return $p;
}

// #AVELINE_PAGINATION
// S'appelle dans une noisette ainsi [<p class="pagination">(#AVELINE_PAGINATION{'debut'})</p>] ou [<p class="pagination">(#AVELINE_PAGINATION{'fin'})</p>]
// Le YAML de la noisette doit contenir - 'inclure:inc-yaml/pagination.yaml'

function balise_AVELINE_PAGINATION_dist($p) {
	$b = $p->nom_boucle ? $p->nom_boucle : $p->descr['id_mere'];

	$pos = interprete_argument_balise(1,$p);
	
	$connect = $p->boucles[$b]->sql_serveur;
	$pas = $p->boucles[$b]->total_parties;
	$f_pagination = chercher_filtre('pagination');
	$type = $p->boucles[$b]->modificateur['debut_nom'];
	$modif = ($type[0]!=="'") ? "'debut'.$type"
	  : ("'debut" .substr($type,1));
	
	if ($pos=="'debut'")
		$p->code = "(\$Pile[0]['selection']=='pagination' && (\$Pile[0]['position_pagination']=='debut' || \$Pile[0]['position_pagination']=='deux')) ? ".sprintf(CODE_PAGINATION, $f_pagination,$b, $type, $modif, $pas, true, "\$Pile[0]['style_pagination']", _q($connect), '')." : ''";
	else
		$p->code = "(\$Pile[0]['selection']=='pagination' && (\$Pile[0]['position_pagination']=='fin' || \$Pile[0]['position_pagination']=='deux')) ? ".sprintf(CODE_PAGINATION, $f_pagination,$b, $type, $modif, $pas, true, "\$Pile[0]['style_pagination']", _q($connect), '')." : ''";
	return $p;
}

// Critère aveline_pagination
// Le YAML de la noisette doit contenir - 'inclure:inc-yaml/pagination.yaml'
// Ajouter {aveline_pagination} à la boucle

function critere_aveline_pagination_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	// definition de la taille de la page
	$pas = "((\$Pile[0]['selection']=='pagination') ? \$Pile[0]['pas_pagination'] : ((\$Pile[0]['selection']=='limite') ? \$Pile[0]['limite'] : 1000000))";
	
	$type = !isset($crit->param[0][1]) ? "'$idb'" : calculer_liste(array($crit->param[0][1]), array(), $boucles, $boucle->id_parent);
	$debut = ($type[0]!=="'") ? "'debut'.$type" 
	  : ("'debut" .substr($type,1));

	$boucle->modificateur['debut_nom'] = $type;
	$partie =
		 // tester si le numero de page demande est de la forme '@yyy'
		 'isset($Pile[0]['.$debut.']) ? $Pile[0]['.$debut.'] : _request('.$debut.");\n"
		."\tif(substr(\$debut_boucle,0,1)=='@'){\n"
		."\t\t".'$debut_boucle = $Pile[0]['. $debut.'] = quete_debut_pagination(\''.$boucle->primary.'\',$Pile[0][\'@'.$boucle->primary.'\'] = substr($debut_boucle,1),'.$pas.',$result,'._q($boucle->sql_serveur).');'."\n"
		."\t\t".'if (!sql_seek($result,0,'._q($boucle->sql_serveur).")){\n"
		."\t\t\t".'@sql_free($result,'._q($boucle->sql_serveur).");\n"
		."\t\t\t".'$result = calculer_select($select, $from, $type, $where, $join, $groupby, $orderby, $limit, $having, $table, $id, $connect);'."\n"
		."\t\t}\n"
		."\t}\n"
		."\t".'$debut_boucle = intval($debut_boucle)';


	$boucle->total_parties = $pas;
	calculer_parties($boucles, $idb, $partie, 'p+');
	// ajouter la cle primaire dans le select pour pouvoir gerer la pagination referencee par @id
	// sauf si pas de primaire, ou si primaire composee
	// dans ce cas, on ne sait pas gerer une pagination indirecte
	$t = $boucle->id_table . '.' . $boucle->primary;
	if ($boucle->primary
		AND !preg_match('/[,\s]/',$boucle->primary)
		AND !in_array($t, $boucle->select))
	  $boucle->select[]= $t;
}

// Si le plugin notation n'est pas actif, on définit un critère {notation} ne faisant rien
// pour ne pas avoir d'erreur avec les boucles appelant ce critère
// on définit également moyenne (égal alors à id) 
if (!defined('_DIR_PLUGIN_NOTATION')) {
	function critere_notation_dist($idb, &$boucles, $crit){
		$boucle = &$boucles[$idb];
		$table = $boucle->id_table;
		$id = $boucle->primary;
		$boucle->select[]= "$table.$id AS moyenne";
	}
}


// #AVELINE_CHOIX_TRI
// Le YAML de la noisette doit contenir - 'inclure:inc-yaml/choix_tri-objet.yaml'
// Appel : #AVELINE_CHOIX_TRI{'objet','debut_ou_fin'}
// S'utilise en conjonction avec le critère tri de Bonux
// Les possibilités de tri pour chaque objet sont définis directement dans le code de la balise
// pour récupérer les variables d'environnement adéquates.

function balise_AVELINE_CHOIX_TRI_dist($p) {
	$b = $p->nom_boucle ? $p->nom_boucle : $p->descr['id_mere'];

	// s'il n'y a pas de nom de boucle, on ne peut pas trier
	if ($b === '') {
		erreur_squelette(
			_T('zbug_champ_hors_boucle',
				array('champ' => '#TRI')
			), $p->id_boucle);
		$p->code = "''";
		return $p;
	}
	$boucle = $p->boucles[$b];

	// s'il n'y a pas de tri_champ, c'est qu'on se trouve
	// dans un boucle recursive ou qu'on a oublie le critere {tri}
	if (!isset($boucle->modificateur['tri_champ'])) {
		erreur_squelette(
			_T('zbug_tri_sans_critere',
				array('champ' => '#TRI')
			), $p->id_boucle);
		$p->code = "''";
		return $p;
	}

	$suffixe = $boucle->modificateur['tri_nom'];
	$objet = interprete_argument_balise(1,$p);
	$pos = interprete_argument_balise(2,$p);
	$tri_actuel = $boucle->modificateur['tri_champ'];
	$sens_actuel = $boucle->modificateur['tri_sens'];
	
	// Définir les choix possibles
	$choix = "array()";
	if ($objet == "'article'")
		$choix = "array(
			array('affiche' => \$Pile['0']['choix_tri_titre'], 'tri' => 'num titre', 'sens' => 1, 'libelle' => _T('aveline_public:par_titre')),
			array('affiche' => \$Pile['0']['choix_tri_popularite'], 'tri' => 'popularite', 'sens' => -1, 'libelle' => _T('aveline_public:les_plus_populaires')),
			array('affiche' => \$Pile['0']['choix_tri_date'], 'tri' => 'date', 'sens' => -1, 'libelle' => _T('aveline_public:les_plus_recents')),
			array('affiche' => \$Pile['0']['choix_tri_anciens'], 'tri' => 'date', 'sens' => 1, 'libelle' => _T('aveline_public:les_plus_anciens')),
			array('affiche' => \$Pile['0']['choix_tri_date_modif'], 'tri' => 'date_modif', 'sens' => -1, 'libelle' => _T('aveline_public:modifies_recemment')),
			array('affiche' => \$Pile['0']['choix_tri_commentes'], 'tri' => 'compteur_forum', 'sens' => -1, 'libelle' => _T('aveline_public:les_plus_commentes')),
			array('affiche' => \$Pile['0']['choix_tri_visistes'], 'tri' => 'visites', 'sens' => -1, 'libelle' => _T('aveline_public:les_plus_visites')),
			array('affiche' => \$Pile['0']['choix_tri_note'], 'tri' => 'moyenne', 'sens' => -1, 'libelle' => _T('aveline_public:les_mieux_notes')),
			array('affiche' => \$Pile['0']['recherche'], 'tri' => 'points', 'sens' => -1, 'libelle' => _T('aveline_public:les_plus_pertinents'))
		)";
	if ($objet == "'breve'")
		$choix = "array(
			array('affiche' => \$Pile['0']['choix_tri_titre'], 'tri' => 'num titre', 'sens' => 1, 'libelle' => _T('aveline_public:par_titre')),
			array('affiche' => \$Pile['0']['choix_tri_date'], 'tri' => 'date_heure', 'sens' => -1, 'libelle' => _T('aveline_public:b_les_plus_recentes')),
			array('affiche' => \$Pile['0']['choix_tri_anciens'], 'tri' => 'date_heure', 'sens' => 1, 'libelle' => _T('aveline_public:b_les_plus_anciennes')),
			array('affiche' => \$Pile['0']['choix_tri_commentes'], 'tri' => 'compteur_forum', 'sens' => -1, 'libelle' => _T('aveline_public:b_les_plus_commentees')),
			array('affiche' => \$Pile['0']['recherche'], 'tri' => 'points', 'sens' => -1, 'libelle' => _T('aveline_public:b_les_plus_pertinents'))
		)";
	if ($objet == "'auteur'")
		$choix = "array(
			array('affiche' => \$Pile['0']['choix_tri_nom'], 'tri' => 'nom', 'sens' => 1, 'libelle' => _T('aveline_public:par_nom')),
			array('affiche' => \$Pile['0']['choix_tri_nb_articles'], 'tri' => 'compteur_articles', 'sens' => -1, 'libelle' => _T('aveline_public:par_nb_articles')),
			array('affiche' => \$Pile['0']['recherche'], 'tri' => 'points', 'sens' => -1, 'libelle' => _T('aveline_public:les_plus_pertinentes'))
		)";
	if ($objet == "'rubrique'")
		$choix = "array(
			array('affiche' => \$Pile['0']['choix_tri_titre'], 'tri' => 'num titre', 'sens' => 1, 'libelle' => _T('aveline_public:par_titre')),
			array('affiche' => \$Pile['0']['choix_tri_commentes'], 'tri' => 'compteur_forum', 'sens' => -1, 'libelle' => _T('aveline_public:les_plus_commentes')),
			array('affiche' => \$Pile['0']['choix_tri_date_heure'], 'tri' => 'date_heure', 'sens' => -1, 'libelle' => _T('aveline_public:modifiees_recemment')),
			array('affiche' => \$Pile['0']['choix_tri_note'], 'tri' => 'moyenne', 'sens' => -1, 'libelle' => _T('aveline_public:les_mieux_notes')),
			array('affiche' => \$Pile['0']['recherche'], 'tri' => 'points', 'sens' => -1, 'libelle' => _T('aveline_public:les_plus_pertinents'))
		)";
	
	$p->code = "calculer_balise_AVELINE_CHOIX_TRI($suffixe,$choix,$pos,$tri_actuel,$sens_actuel,\$Pile[0]['choix_tri'],\$Pile[0]['position_choix_tri'])";
	return $p;
}

function calculer_balise_AVELINE_CHOIX_TRI($suffixe,$choix,$pos,$tri_actuel,$sens_actuel,$choix_tri,$position_choix_tri) {
	// Doit-on afficher les tri perso ?
	if (!$choix_tri || ($pos == 'debut' && $position_choix_tri == 'fin') || ($pos == 'fin' && $position_choix_tri == 'debut'))
		return '';
	
	$retour = array();
	foreach($choix as $c) {
		// Cas où on demande la note moyenne et que notation n'est pas activé
		if ($c['tri'] == 'moyenne' && !defined('_DIR_PLUGIN_NOTATION'))
			$c['affiche'] = '';
		if ($c['affiche']) {
			$lien = parametre_url(self(),'tri'.$suffixe,$c['tri']);
			$lien = parametre_url($lien,'sens'.$suffixe,$c['sens']);
			$retour[] = lien_ou_expose($lien,$c['libelle'],$c['tri']==$tri_actuel && $c['sens']==$sens_actuel);
		}
	}
	return implode(' | ',$retour);
}

// Critère aveline_branche
// Le YAML de la noisette doit contenir - 'inclure:inc-yaml/branche-objet.yaml'
// Ajouter {aveline_branche} à la boucle
function critere_aveline_branche_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	
	$id_rubrique = calculer_argument_precedent($idb, 'id_rubrique', $boucles);
	$id_secteur = calculer_argument_precedent($idb, 'id_secteur', $boucles);

	//Trouver une jointure
	$desc = $boucle->show;
	//Seulement si necessaire
	if (!array_key_exists('id_rubrique', $desc['field'])) {
		$cle_rubrique = trouver_jointure_champ('id_rubrique', $boucle);
	} else $cle_rubrique = $boucle->id_table;
	
	$table = $boucle->id_table;
	
	$boucle->where[] = "aveline_calcul_branche($id_rubrique, $id_secteur, $cle_rubrique, $table, \$Pile[0]['branche'], \$Pile[0]['rubrique_specifique'], \$Pile[0]['branche_specifique'], \$Pile[0]['secteur_specifique'])";
	
}

function aveline_calcul_branche($id_rubrique,$id_secteur,$cle_rubrique,$table, $branche,$rubrique_specifique,$branche_specifique,$secteur_specifique) {
	switch ($table) {
		case 'articles':
			$cle_secteur = $table;
			$champ_secteur = 'id_secteur';
			break;
		case 'breves':
			$cle_secteur = $table;
			$champ_secteur = 'id_rubrique';
	}
	switch ($branche) {
		case 'meme_rubrique':
			return $id_rubrique ? array('=',"$cle_rubrique.id_rubrique",$id_rubrique) : array ();
			break;
		case 'rubrique_specifique':
			return $rubrique_specifique ? sql_in("$cle_rubrique.id_rubrique",picker_selected($rubrique_specifique,'rubrique')) : array();
			break;
		case 'branche_actuelle':
			return $id_rubrique ? sql_in("$cle_rubrique.id_rubrique",calcul_branche_in($id_rubrique)) : array();
			break;
		case 'branche_specifique':
			return $branche_specifique ? sql_in("$cle_rubrique.id_rubrique",calcul_branche_in(picker_selected($branche_specifique,'rubrique'))) : array();
			break;
		case 'meme_secteur':
			return $id_secteur ? array('=',"$cle_secteur.$champ_secteur",$id_secteur) : array();
			break;
		case 'secteur_specifique':
			return $secteur_specifique ? sql_in("$cle_secteur.$champ_secteur",$secteur_specifique) : array();
			break;
		default:
			return array();
	}
}

// Critère aveline_lang
// Le YAML de la noisette doit contenir - 'inclure:inc-yaml/restreindre_langue.yaml''
// Ajouter {aveline_lang} à la boucle
// N'appliquer qu'à des tables ayant un champ 'lang'
function critere_aveline_lang_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$id_table = $boucle->id_table;
	$boucle->where[] = "aveline_calcul_lang($id_table,\$Pile[0]['restreindre_langue'],\$Pile[0]['lang'])";
}

function aveline_calcul_lang($id_table,$restreindre_langue,$lang) {
	if ($restreindre_langue)
		return array('=',"$id_table.lang",sql_quote($lang));
	else
		return array();
}


// Critère aveline_exclure_objet_encours
// Le YAML de la noisette doit contenir - 'inclure:inc-yaml/exclure_objet_en_cours-objet.yaml''
// Ajouter {aveline_exclure_objet_encours} à la boucle
function critere_aveline_exclure_objet_encours_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$id_table = $boucle->id_table;
	$id_objet = $boucle->primary;
	
	$boucle->where[] = "aveline_calcul_exclure_objet($id_table,$id_objet,\$Pile[0][$id_objet],\$Pile[0]['exclure_objet_en_cours'])";
}

function aveline_calcul_exclure_objet($id_table,$id_objet,$id_en_cours,$exclure_objet_en_cours) {
	if ($exclure_objet_en_cours)
		return array('!=',"$id_table.$id_objet",intval($id_en_cours));
	else
		return array();
}

// Critère aveline_selecteurs_archives_mois et aveline_selecteurs_archives_annees
// Utilisée pour les sélecteurs d'archives
// Balise disponible #NB_ARCHIVES
function critere_aveline_selecteur_archives_mois_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$champ_date = $boucle->id_table ."." . $GLOBALS['table_date'][$boucle->type_requete];
	$id_objet = $boucle->id_table ."." . $boucle->primary;
	$boucle->select[] = "COUNT($id_objet) AS nb_archives";
	$boucle->group[] = "YEAR($champ_date)";
	$boucle->group[] = "MONTH($champ_date)";
}

function critere_aveline_selecteur_archives_annee_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$champ_date = $boucle->id_table ."." . $GLOBALS['table_date'][$boucle->type_requete];
	$id_objet = $boucle->id_table ."." . $boucle->primary;
	$boucle->select[] = "COUNT($id_objet) AS nb_archives";
	$boucle->group[] = "YEAR($champ_date)";
}

/** Balise #NB_ARCHIVES associee aux criteres aveline_selecteur_archives_mois et aveline_selecteur_archives_annees */
function balise_NB_ARCHIVES_dist($p) {
	$p->code = '$Pile[$SP][\'nb_archives\']';
	$p->interdire_scripts = false;
	return $p;
}

/**
 * Calculer l'initiale d'un nom ou d'un titre
 * 
 * @param <type> $nom
 * @return <type>
 */
function aveline_initiale($nom){
	return spip_substr(trim(strtoupper($nom)),0,1);
}


/**
 * Afficher l'initiale pour la navigation par lettres
 * adptée du plugin afficher_objets
 * 
 * @staticvar string $memo
 * @param <type> $url
 * @param <type> $initiale
 * @param <type> $compteur
 * @param <type> $debut
 * @param <type> $pas
 * @return <type>
 */
function aveline_afficher_initiale($url,$initiale,$compteur,$debut,$pas){
	static $memo = null;
	$res = '';
	if (!$memo 
		OR (!$initiale AND !$url)
		OR ($initiale!==$memo['initiale'])
		){
		$newcompt = intval(floor(($compteur-1)/$pas)*$pas);
		if ($memo){
			$on = (($memo['compteur']<=$debut)
				AND (
						$newcompt>$debut OR ($newcompt==$debut AND $newcompt==$memo['compteur'])
						));
			$res = lien_ou_expose($memo['url'],$memo['initiale'],$on,'lien_pagination');
		}
		if ($initiale)
			$memo = array('initiale'=>$initiale,'url'=>$url,'compteur'=>$newcompt);
	}
	return $res;
}


?>