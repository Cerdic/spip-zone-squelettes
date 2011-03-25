<?php

// Sécurité
if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/meta');

// Installation et mise à jour
function aveline_upgrade($nom_meta_version_base, $version_cible){
	$version_actuelle = '0.0';
	
	// Historiquement, la version 0.2.X correspondent au garde noisettes (< 1.0.0)
	if (isset($GLOBALS['meta']['gn_base_version'])) {
		$version_actuelle = $GLOBALS['meta']['gn_base_version'];
		effacer_meta('gn_base_version');
	}
	
	if (
		(!isset($GLOBALS['meta'][$nom_meta_version_base]))
		|| (($version_actuelle = $GLOBALS['meta'][$nom_meta_version_base]) != $version_cible)
	){
		// On calcule le tableau des noisettes
		include_spip('base/abstract_sql');
		$noisettes = sql_allfetsel('*','spip_noisettes','1');
		
		// On remet au propre les parametres
		foreach ($noisettes as $cle => $noisette)
			$noisettes[$cle]['parametres'] = unserialize($noisette['parametres']);
		
		// On applique les mises à jour
		$noisettes = aveline_maj_noisettes($noisettes,$version_actuelle);
		
		// Il faut serializer les paramètres avant mise en base
		foreach ($noisettes as $cle => $noisette)
			$noisettes[$cle]['parametres'] = serialize($noisette['parametres']);
		
		// On update la base
		sql_replace_multi('spip_noisettes',$noisettes);
		
		ecrire_meta($nom_meta_version_base, $version_actuelle=$version_cible, 'non');
	}

}

// Désinstallation
function aveline_vider_tables($nom_meta_version_base){
	// On efface la version enregistrée
	effacer_meta($nom_meta_version_base);
}

// Mise à jour des noisettes

function aveline_maj_noisettes($noisettes, $version_actuelle) {
	if (version_compare($current_version,'0.1','>') && version_compare($current_version,'0.3.0','<')){
		foreach ($noisettes as $cle => $noisette)
			$noisettes[$cle]['parametres'] = str_replace('gn_public:','avelinepublic:',$noisettes[$cle]['parametres']);
	}
	if (version_compare($current_version,'0.3.2','<')){
		foreach ($noisettes as $cle => $noisette) {
			if(in_array($noisette['noisette'],array(
				'auteur-articles',
				'liste_articles',
				'mot-articles',
				'page-recherche-articles',
				'liste_breves',
				'mot-breves',
				'page-recherche-breves',
				'liste_auteurs',
				'page-recherche-auteurs',
				'rubrique-sous_rubriques',
				'rubriques_secteur_langue',
				'rubriques_racine',
				'page-recherche-rubriques',
				'liste_forums',
				'mot-forums',
				'selecteur_archives'
			))){
				foreach($noisette['parametres'] as $param => $valeur) {
					if ($param == 'tri' and $valeur == 'nb_articles')
						$noisettes[$cle]['parametres'][$param] = 'compteur_articles';
					if ($param == 'senstri' and intval($valeur) == 0)
						$noisettes[$cle]['parametres'][$param] = '';
					if ($param == 'senstri' and intval($valeur) == 1)
						$noisettes[$cle]['parametres'][$param] = 'inverse';
					if ($param == 'tri' and $valeur == 'nbre_commentaires')
						$noisettes[$cle]['parametres'][$param] = 'compteur_forum';
					if ($param == 'tri' and $valeur == 'note')
						$noisettes[$cle]['parametres'][$param] = 'moyenne';
					if ($param == 'liste_articles') {
						$noisettes[$cle]['parametres']['branche'] = $noisettes[$cle]['parametres'][$param];
						unset($noisettes[$cle]['parametres'][$param]);
					}
					if ($param == 'exclure_article_en_cours') {
						$noisettes[$cle]['parametres']['exclure_objet_en_cours'] = $noisettes[$cle]['parametres'][$param];
						unset($noisettes[$cle]['parametres'][$param]);
					}
					if ($param == 'pas_selecteur_archives' and $valeur == 'annee_mois')
						$noisettes[$cle]['parametres'][$param] = 'mois';
					if ($param == 'liste_breves') {
						$noisettes[$cle]['parametres']['branche'] = $noisettes[$cle]['parametres'][$param];
						unset($noisettes[$cle]['parametres'][$param]);
					}
					if ($param == 'exclure_breve_en_cours') {
						$noisettes[$cle]['parametres']['exclure_objet_en_cours'] = $noisettes[$cle]['parametres'][$param];
						unset($noisettes[$cle]['parametres'][$param]);
					}
				}
			}
			if(in_array($noisette['noisette'],array('page-recherche-articles','page-recherche-auteurs','page-recherche-rubriques','page-recherche-breves'))){
				$noisettes[$cle]['parametres']['tri'] = 'points';
				$noisettes[$cle]['parametres']['senstri'] = 'inverse';
			}
			if(in_array($noisette['noisette'],array(
				'liste_documents',
				'article-documents',
				'rubrique-documents',
				'page-recherche-documents'
			))){
				foreach($noisette['parametres'] as $param => $valeur) {
					if ($param == 'senstri' and intval($valeur) == 0)
						$noisettes[$cle]['parametres'][$param] = '';
					if ($param == 'senstri' and intval($valeur) == 1)
						$noisettes[$cle]['parametres'][$param] = 'inverse';
				}
			}
		}
	}
	if (version_compare($current_version,'0.3.3','<')){
		foreach ($noisettes as $cle => $noisette) {
			if(in_array($noisette['noisette'],array(
				'liste_documents',
				'article-documents',
				'rubrique-documents',
				'page-recherche-documents'
			))){
				foreach($noisette['parametres'] as $param => $valeur) {
					if ($param == 'tri' and $valeur == 'multi titre')
						$noisettes[$cle]['parametres'][$param] = 'titre';
				}
			}
		}
	}
	if (version_compare($current_version,'0.3.4','<')){
		foreach ($noisettes as $cle => $noisette) {
			if(in_array($noisette['noisette'],array(
				'auteur-articles',
				'liste_articles',
				'mot-articles',
				'page-recherche-articles',
				'liste_breves',
				'mot-breves',
				'page-recherche-breves',
				'liste_auteurs',
				'page-recherche-auteurs',
				'rubrique-sous_rubriques',
				'rubriques_secteur_langue',
				'rubriques_racine',
				'page-recherche-rubriques',
				'liste_forums',
				'mot-forums',
				'selecteur_archives'
			))){
				foreach($noisette['parametres'] as $param => $valeur) {
					if ($param == 'tri' and $valeur == 'num titre')
						$noisettes[$cle]['parametres'][$param] = 'titre';
				}
			}
		}
	}
	return $noisettes;
}

?>
