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
 $boucle->where[]= array("'='", "'".$id_table."'", "'compt.".$boucle->primary."'");
 $boucle->where[]= array("'='", "'compt.statut'" , "'\"publie\"'"); 
 $boucle->group[]=$id_table;
 if ($op)
     $boucle->having[]= array("'".$op."'", "'compteur_".$type."'",$op_val);
} 
function balise_COMPTEUR_FORUM_dist($p) {
   $p->code = '$Pile[$SP][\'compteur_forum\']';
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

// #GN_PAGINATION
// S'appelle dans une noisette ainsi [<p class="pagination">(#GN_PAGINATION{'debut'})</p>] ou [<p class="pagination">(#GN_PAGINATION{'fin'})</p>]
// Le YAML de la noisette doit contenir - 'inclure:inc-yaml/pagination.yaml'

function balise_GN_PAGINATION_dist($p) {
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

// Critère gn_pagination
// Le YAML de la noisette doit contenir - 'inclure:inc-yaml/pagination.yaml'
// Ajouter {gn_pagination} à la boucle

function critere_gn_pagination_dist($idb, &$boucles, $crit) {
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


?>