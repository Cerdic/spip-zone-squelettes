<?php


//
// Dans n'importe quel contexte (article, breve, etc)
// #MF_TAGS liste les mots-cles dans l'ordre ou ils ont
// ete poses, au microformat relTag
// <http://www.microformats.org/wiki/reltag>
//
function sql_tags($id, $type) {
	$tags = array();

	$s = spip_query("SELECT mots.id_mot, mots.titre, mots.descriptif
		FROM spip_mots AS mots, spip_mots_".table_objet($type)." AS lien
		WHERE lien.id_$type = $id
		AND mots.id_mot = lien.id_mot");
	while ($t = spip_fetch_array($s)) {
		$tag = "<a rel='tag' href='"
			.generer_url_mot($t['id_mot'])
			."'";
		if ($title = couper(textebrut(propre($t['descriptif'])), 36))
			$tag .= ' title="'.texte_backend($title).'"';
		$tag .= ">".typo($t['titre']).'</a>';
		
		$tags[] = $tag;
	}

	return join(', ',$tags);
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