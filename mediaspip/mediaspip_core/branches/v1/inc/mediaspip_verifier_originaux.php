<?php
/**
 * Plugin Mediaspip Core
 * 
 * © 2010-2011 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 * Fonction de vérification de la présence des fichiers originaux
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

/**
 * Vérifie qu'il n'y a pas de documents originaux qui ont été perdus
 * 
 * @return
 */
function inc_mediaspip_verifier_originaux(){
	include_spip('inc/documents');
	include_spip('inc/metas');
	$documents_perdus = array();
	$documents = sql_select('*','spip_documents','id_orig=0 AND mode !='.sql_quote('vignette').'AND distant !="oui"');
	while($document = sql_fetch($documents)){
		if(!file_exists(get_spip_doc($document['fichier']))){
			$objets_lies = sql_select('id_objet,objet','spip_documents_liens','id_document='.intval($document['id_document']));
			while($objet_lie = sql_fetch($objets_lies)){
				$statut = sql_getfetsel('statut',table_objet_sql($objet_lie['objet']),id_table_objet($objet_lie['objet']).'='.intval($objet_lie['id_objet']));
				if(($objet_lie['objet'] == 'article') && $statut && ($statut != 'poubelle')){
					$documents_perdus[] = $document['id_document'];		
				}
				else if($objet_lie['objet'] != 'article'){
					$documents_perdus[] = $document['id_document'];
				}
			}
		}
	}
	
	if(count($documents_perdus) > 0){
		ecrire_meta('mediaspip_docs_perdus',serialize($documents_perdus));
	}
	else{
		effacer_meta('mediaspip_docs_perdus');
	}
	include_spip('inc/invalideur');
	suivre_invalideur('1');
}

?>