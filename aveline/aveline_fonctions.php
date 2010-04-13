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

?>