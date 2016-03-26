<?php

if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_evainstall_charger_dist() {
	//Rien à retourner ici : tout est dans le formulaire html et en php
	$valeurs=array();
	return $valeurs;
}


function formulaires_evainstall_traiter_dist() {
	$grp2_activites = array (
		"jclic" => "Transforme un article en activit&eacute; jclic", 
		"livre" => "Transforme une rubrique en livre",
		"couverture-livre" => "Article servant de couverture au livre",	
		"geometrie" => "Transforme un article en activit&eacute; de g&eacute;om&eacute;trie dynamique",
		"album" => "Transforme une rubrique et tous les articles quelle contient en livre-album",
		"podcast" => "Permet de publier un fichier comme podcast"
	);

	$grp2_affichage = array (
		"agenda" => "Afficher une rubrique sous forme d'agenda",
		"article1" => "Afficher un article en haut de liste dans un cadre diff&eacute;rent en permanence dans une page rubrique",
		"calendrier" => "Afficher une rubrique sous forme de calendrier",
		"editorial" => "Afficher un article en haut de liste dans un cadre diff&eacute;rent en permanence dans la page d'accueil",
		"logo-bloc" => "Afficher le logo d'un site r&eacute;renc&eacute; dans un bloc dans la page d'accueil",
		"logo-pied" => "Afficher le logo d'un site r&eacute;renc&eacute; dans le pied de page de la page d'accueil",
		"portfolio" => "Transformer les images jointes à un article en portfolio",
		"diaporama" => "Pr&eacute;sente les documents joints aux rubriques et articles sous forme de diaporama avec pagination et m&eacute;thode AJAX",
		"mentions" => "Permet d'ajouter des mentions l&eacute;gales personnalis&eacute;es",	
		"lien-haut" => "Placer un lien dans la ligne de lien tout en haut de la page",
		"mini-calendrier" => "Ajoute un rep&egrave;re dans le mini-calendrier",
		"excluredusommaire" => "Supprime de la page de sommaire les &eacute;l&eacute;ments (articles, sites, ...) ayant ce mot cl&eacute;",
		"excluredumenu" => "Supprime du menu de navigation les rubriques concern&eacute;es par ce mot cl&eacute;",
		"exclureduplan" => "Supprime du plan du site les rubriques concern&eacute;es par ce mot cl&eacute;",
		"exclure_des_flux_rss" => "Supprime des flux RSS du site les articles et br&egrave;ves concern&eacute;es par ce mot cl&eacute;"
	);

	$nbrgrpact = count($grp2_activites);
	$nbrgrpaff = count($grp2_affichage);
	$resultat_act2 = sql_select('id_groupe','spip_groupes_mots',"titre='activites' LIMIT 1");
	while ($tab_act = sql_fetch($resultat_act2)) {
		$id_act = $tab_act['id_groupe'];	
	}
	$resultat_aff2 = sql_select('id_groupe','spip_groupes_mots',"titre='affichage' LIMIT 1");
	while ($tab_aff = sql_fetch($resultat_aff2)) {
		$id_aff = $tab_aff['id_groupe'];	
	}
	$res = array('editable'=>true);
	$res['message_ok'] = 'Aucune modification n\'a &eacute;t&eacute; enregistr&eacute;e';
	//On traite ici la creation des groupes
	if (_request('creeract')) {
		$resultatgrp = sql_insertq(
			'spip_groupes_mots',
			array(
				'titre'=>'activites',
				'tables_liees'=>'articles,breves,rubriques,syndic,',
				'descriptif'=>$descriptif,
				'unseul'=>'non',
				'obligatoire'=>'non',
				'minirezo'=>'oui',
				'comite'=>'oui',
				'forum'=>'non'
			)
		);
		$res['message_ok'] = 'Le groupe <b>activites</b> vient d\'&ecirc;tre cr&eacute;&eacute;';
	}
	if (_request('creeraff')) {
		$resultatgrp = sql_insertq(
			'spip_groupes_mots',
			array(
				'titre'=>'affichage',
				'tables_liees'=>'articles,breves,rubriques,syndic,',
				'descriptif'=>$descriptif,
				'unseul'=>'non',
				'obligatoire'=>'non',
				'minirezo'=>'oui',
				'comite'=>'oui',
				'forum'=>'non'
			)
		);
		$res['message_ok'] = 'Le groupe <b>affichage</b> vient d\'&ecirc;tre cr&eacute;&eacute;';
	}
	//On traite maintenant la creation des mots-cles
	if (_request('creermots')) {
		$res['message_ok'] = 'Cr&eacute;ation des mots-cl&eacute;s du groupe activites num&eacute;ro '.$id_act.'<br/>';
		$resultat_req = sql_select('titre','spip_mots',"id_groupe='".$id_act."'");
		$nb_req = sql_count($resultat_req);
		if ($nb_req <> $nbrgrpact) {
			$res['message_ok'] .="<br/>Nombre de mots-cl&eacute;s dans le groupe activites cr&eacute;es : ".$nbrgrpact."<br/>";
			foreach ($grp2_activites as $motcle => $descriptifmot) {
				$resultreq=sql_select('titre,id_groupe','spip_mots',"titre='".$motcle."'");
				$nbreq = sql_count($resultreq);
				$row= sql_fetch($resultreq);
				if ($nbreq == 0) {
					$ajout_mot = sql_insertq('spip_mots',array('titre'=>$motcle,'descriptif'=>$descriptifmot,'id_groupe'=>$id_act));
				}
				elseif ($row["id_groupe"]<>$id_act) {
					$res['message_ok'] .= $motcle.' existe d&eacute;j&agrave;<br/>';
					$res['message_ok'] .= 'Je le d&#233;place dans le groupe activites<br/>';
					sql_updateq('spip_mots',array('id_groupe'=>$id_act,'descriptif'=>$descriptifmot),"titre = '".$motcle."'");
				}
			}
		}
	}
	if (_request('creermotsaff')) {
		$res['message_ok'] = 'Cr&eacute;ation des mots-cl&eacute;s du groupe affichage num&eacute;ro '.$id_aff.'<br/>';
		$resultat_req = sql_select('titre','spip_mots',"id_groupe='".$id_aff."'");
		$nb_req = sql_count($resultat_req);
		if ($nb_req <> $nbrgrpaff) {
			$res['message_ok'] .="<br/>Nombre de mots-cl&eacute;s dans le groupe affichage cr&eacute;es : ".$nbrgrpaff."<br/>";
			foreach ($grp2_affichage as $motcle => $descriptifmot) {
				$resultreq=sql_select('titre,id_groupe','spip_mots',"titre='".$motcle."'");
				$nbreq = sql_count($resultreq);
				$row= sql_fetch($resultreq);
				if ($nbreq == 0) {
					$ajout_mot = sql_insertq('spip_mots',array('titre'=>$motcle,'descriptif'=>$descriptifmot,'id_groupe'=>$id_aff));
				}
				elseif ($row["id_groupe"]<>$id_aff) {
					$res['message_ok'] .= $motcle.' existe d&eacute;j&agrave;<br/>';
					$res['message_ok'] .= 'Je le d&#233;place dans le groupe activites<br/>';
					sql_updateq('spip_mots',array('id_groupe'=>$id_aff,'descriptif'=>$descriptifmot),"titre = '".$motcle."'");
				}
			}
		}
	}
	return $res;
}

