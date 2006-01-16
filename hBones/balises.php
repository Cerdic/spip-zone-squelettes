<?php

//
// Dans n'importe quel contexte (article, breve, etc)
// on liste les mots-cles dans l'ordre ou ils ont ete
// poses, au microformat relTag
// <http://www.microformats.org/wiki/reltag>
// On appelle le squelette mf_tags.html
//
function sql_tags($id, $type) {
	$page = cherche_page('' /* chemin_cache */,
		array('id_'.$type => $id) /* contexte_inclus */,
			'mf_tags' /* fond */,
			false);
	return $page['texte'];
}
function balise_MF_TAGS_dist($p) {
	$nom = $p->id_boucle;
	$type = preg_replace(',s$,','',
		$p->boucles[$nom]->type_requete);
	$_id = champ_sql(id_table_objet($type), $p);
	$p->code = 'sql_tags('.$_id.",'".$type."')";
	return $p;
}

?>