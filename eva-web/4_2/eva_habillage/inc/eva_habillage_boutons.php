<?php

function eva_habillage_boutons($ongletCourant){
	$onglets=array();
	$onglets['structure']=
		new Bouton(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/blocs_mini.png", "Structure",
		generer_url_ecrire("eva_habillage"));
	$onglets['graphisme']=
		new Bouton(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/palette_mini.png", "Graphisme",
		generer_url_ecrire("eva_habillage_graphisme"));
	$onglets['css']=
		new Bouton(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/css_mini.png", "CSS",
		generer_url_ecrire("eva_habillage_css"));
	$onglets['sauvegarde']=
		new Bouton(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/disk_mini.png", "Sauvegarde Restauration",
		generer_url_ecrire("eva_habillage_sauvegarde"));
	$onglets['aide']=
		new Bouton('', "Aide","http://www.eva-web.edres74.ac-grenoble.fr/spip.php?rubrique7");
	$res_onglet = debut_onglet();

	foreach($onglets as $exec => $onglet) {
		$url= $onglet->url ? $onglet->url : generer_url_ecrire($exec);
		$res_onglet .= onglet(_T($onglet->libelle), $url,$exec, $ongletCourant, $onglet->icone);
	}
	$res_onglet .= fin_onglet();
	return $res_onglet;
}