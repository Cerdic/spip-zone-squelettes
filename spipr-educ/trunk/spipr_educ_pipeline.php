<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function spipr_educ_declarer_tables_interfaces($interface){
	$interface['table_des_tables']['spipr_educ'] = 'spipr_educ';
	return $interface;
}
function spipr_educ_affiche_milieu($flux){
	$exec = $flux["args"]["exec"];
	// On traite l'ajout des sites référencés dans les divers blocs de SPIPr-éduc
	$id_syndic = $flux["args"]["id_syndic"];
	if (($exec == "site") AND (is_numeric($id_syndic)) AND ($GLOBALS["visiteur_session"]['statut']=='0minirezo')) {
		$retour=recuperer_fond('prive/squelettes/ajax_formulaires/spipr_educ_configure_sites', array('id_syndic' => $id_syndic));
	}
	
	// Puis les options pour les rubriques (essentiellement pour retirer des contenus de certaines pages ou flux)
	$id_rubrique = $flux["args"]["id_rubrique"];
	if (($exec == "rubrique") AND (is_numeric($id_rubrique)) AND ($GLOBALS["visiteur_session"]['statut']=='0minirezo')) {
		$retour=recuperer_fond('prive/squelettes/ajax_formulaires/spipr_educ_configure_rubriques', array('id_rubrique' => $id_rubrique));
	}
	
	// Puis les options pour les articles (édito, Une, exclure du sommaire...)
	$id_article = $flux["args"]["id_article"];
	if (($exec == "article") AND (is_numeric($id_article)) AND ($GLOBALS["visiteur_session"]['statut']=='0minirezo')) {
		$retour=recuperer_fond('prive/squelettes/ajax_formulaires/spipr_educ_configure_articles', array('id_article' => $id_article));
	}
	
	$flux["data"] .= $retour;
	return $flux;
}
?>