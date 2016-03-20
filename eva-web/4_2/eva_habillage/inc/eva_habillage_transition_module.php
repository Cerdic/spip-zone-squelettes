<?php
function eva_habillage_transition_module() {
	$Table1 = 'spip_eva_habillage';
	$Table2 = 'spip_eva_habillage_themes';
	$Table3 = 'spip_eva_habillage_images';

	//Page d'article
	$def_blocs ['sommaire_navigation']= array('gauche',1,'sommaire');
	$def_blocs ['sommaire_menu_depliable']= array('non',1,'sommaire');
	$def_blocs ['sommaire_edito']= array('centre',1,'sommaire');
	$def_blocs ['sommaire_articles']= array('centre',2,'sommaire');
	$def_blocs ['sommaire_ajax_articles']= array('non',2,'sommaire');
	$def_blocs ['sommaire_mini_calendrier']= array('gauche',2,'sommaire');
	$def_blocs ['sommaire_connexion']= array('gauche',3,'sommaire');
	$def_blocs ['sommaire_breve']= array('gauche',4,'sommaire');
	$def_blocs ['sommaire_site']= array('gauche',5,'sommaire');
	$def_blocs ['sommaire_podcast']= array('gauche',6,'sommaire');
	$def_blocs ['sommaire_logo']= array('gauche',7,'sommaire');
	$def_blocs ['sommaire_syndic']= array('gauche',8,'sommaire');
	$def_blocs ['sommaire_compteur']= array('gauche',9,'sommaire');

	//Page d'article
	$def_blocs ['article_navigation']= array('gauche',1,'article');
	$def_blocs ['article_menu_depliable']= array('non',1,'article');
	$def_blocs ['article_contenu']= array('centre',1,'article');
	$def_blocs ['article_forum']= array('centre',2,'article');
	$def_blocs ['article_signature']= array('centre',3,'article');
	$def_blocs ['article_petition']= array('gauche',2,'article');
	$def_blocs ['article_meme_rubrique']= array('gauche',3,'article');
	$def_blocs ['article_mot']= array('gauche',4,'article');
	$def_blocs ['article_compteur']= array('gauche',5,'article');

	//Page auteur
	$def_blocs ['auteur_navigation']= array('gauche',1,'auteur');
	$def_blocs ['auteur_menu_depliable']= array('non',1,'auteur');
	$def_blocs ['auteur_contenu']= array('centre',1,'auteur');
	$def_blocs ['auteur_auteurs']= array('gauche',2,'auteur');
	$def_blocs ['auteur_articles']= array('gauche',3,'auteur');

	//Page breve
	$def_blocs ['breve_navigation']= array('gauche',1,'breve');
	$def_blocs ['breve_menu_depliable']= array('non',1,'breve');
	$def_blocs ['breve_contenu']= array('centre',1,'breve');
	$def_blocs ['breve_breves']= array('gauche',2,'breve');

	//Page rubrique
	$def_blocs ['rubrique_navigation']= array('gauche',1,'rubrique');
	$def_blocs ['rubrique_menu_depliable']= array('non',1,'rubrique');
	$def_blocs ['rubrique_contenu']= array('centre',1,'rubrique');
	$def_blocs ['rubrique_sous_rubriques']= array('centre',2,'rubrique');
	$def_blocs ['rubrique_articles']= array('centre',3,'rubrique');
	$def_blocs ['rubrique_podcast']= array('centre',4,'rubrique');
	$def_blocs ['rubrique_documents']= array('centre',5,'rubrique');
	$def_blocs ['rubrique_breve']= array('gauche',2,'rubrique');
	$def_blocs ['rubrique_site']= array('gauche',3,'rubrique');
	$def_blocs ['rubrique_site_syndic']= array('gauche',4,'rubrique');
	$def_blocs ['rubrique_mot']= array('gauche',5,'rubrique');
	$def_blocs ['rubrique_syndic']= array('gauche',6,'rubrique');

	//Page site
	$def_blocs ['site_navigation']= array('gauche',1,'site');
	$def_blocs ['site_menu_depliable']= array('non',1,'site');
	$def_blocs ['site_contenu']= array('centre',1,'site');
	$def_blocs ['site_syndic']= array('centre',2,'site');
	$def_blocs ['site_podcast']= array('gauche',2,'site');
	$def_blocs ['site_sites']= array('gauche',3,'site');

	//Entete
	$def_blocs ['entete_classique']= array('oui',1,'entete');
	$def_blocs ['entete_arborescence']= array('oui',2,'entete');
	$def_blocs ['entete_sans_liens']= array('non',1,'entete');
	$def_blocs ['entete_sans_titre']= array('non',1,'entete');

	//Pied
	$def_blocs ['pied_logos']= array('oui',1,'pied');
	$def_blocs ['pied_classique']= array('oui',2,'pied');

	//Headers
	$def_blocs ['headers_classiques']= array('oui',1,'headers');
	$def_blocs ['headers_menu_dynamique']= array('non',2,'headers');

	foreach($def_blocs as $cle=>$val) {
		$eva_noms_habillages=sql_select('nom',$Table2,'');
		while ($eva_noms_tab=sql_fetch($eva_noms_habillages)) {
			$eva_verif_modularite=sql_select('*',$Table3,"type='bloc' AND nom_habillage='".$eva_noms_tab['nom']."' AND nom_div='".$cle."'");
			$tab=sql_fetch($eva_verif_modularite);
			if (!$tab['type']) {
				sql_insertq($Table3,array(
					'type'=>'bloc',
					'nom_habillage'=>$eva_noms_tab['nom'],
					'nom_div'=>$cle,
					'nom_image'=>$val[0],
					'pos_x'=>$val[1],
					'attach'=>$val[2]));
			}
			elseif (!$tab['attach']) {
				sql_updateq($Table3,array('pos_x'=>$val[1],'attach'=>$val[2]),"id=".$tab['id']);
			}
		}
	}
}
?>