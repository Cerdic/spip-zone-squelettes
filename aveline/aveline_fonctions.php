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


?>