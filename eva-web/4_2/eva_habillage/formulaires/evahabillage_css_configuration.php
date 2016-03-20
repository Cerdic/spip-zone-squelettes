<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_evahabillage_css_configuration_charger_dist(){
	$valeurs=array();
	$valeurs['truc'] = '';
	return $valeurs;
}

function formulaires_evahabillage_css_configuration_traiter_dist(){
	$res = array('editable'=>true);
	$res['message_ok'] = 'Aucune modification effectu&eacute;e';
	//On traite le cas d'un enregistrement de règle CSS
	if ((_request('enregistrer_css')) AND (_request('nouvelle_regle_css')!='')) {
		sql_insertq('spip_eva_habillage_images',array("type" => "perso", "nom_habillage" => "Defaut", "nom_div" => _request('nouvelle_regle_css')));
		$res['message_ok'] = 'R&egrave;gle CSS enregistr&eacute;e';
	}
	//On traite le cas d'injection prédéfinie
	$css_defs =array(
		'css_supprime_titre' => "#entete h1 {display:none;}",
		'css_supprime_pied' => "ul#logo-pied, ul#pied {display:none;}",
		'css_supprime_mentions_pied' => "ul#pied .supprimer_le_pied {display:none;}",
		'css_supprime_bordure_tableau' => "table.spip tr.row_odd , table.spip tr.row_even , table.spip tr.row_odd td , table.spip tr.row_even td {border-width:0;}",
		'css_augmente_police_10' => "body {font-size: 110%;}",
		'css_augmente_police_20' => "body {font-size: 120%;}",
		'css_diminue_police_10' => "body {font-size: 90%;}",
		'css_diminue_police_20' => "body {font-size: 80%;}",
		'css_doubler_taille_titre_50' => "div#entete h1 {font-size:200%;}",
		'css_deplace_titre_50px_bas' => "div#entete h1 {top:50px;}",
		'css_deplace_titre_50px_gauche' => "div#entete h1 {left:50px;}",
		'css_augmente_titres_blocs_20' => "h3 , div#contenu h3 , legend , #forum .bouton a , .bloc .titre , .divers h4 , table.spip tr.row_first th , div#contenu div.ps h4 , div#menu h3.titre , div#menudroit h3.titre , table.spip tr.row_first , div#contenu div.lien , .contenu .lien , div#contenu div.notes h4 , div#contenu h4.titre , div#contenu h3.titre , #forum ul.forum div.titre h4{font-size: 120%;}",
	);
	foreach($css_defs as $css_cle => $css_val) {
		if (_request($css_cle)) {sql_insertq('spip_eva_habillage_images',array("type" => "perso", "nom_habillage" => "Defaut", "nom_div" => $css_defs[$css_cle]));
			$res['message_ok'] = 'R&egrave;gle pr&eacute;d&eacute;finie CSS enregistr&eacute;e';
		}
	}
	//On traite le cas de la suppression et la mise à jour d'une règle CSS déjà enregistrée
	$recherche_perso = sql_select("id,nom_div","spip_eva_habillage_images","type='perso' AND nom_habillage='Defaut'");
	while ($tab = sql_fetch($recherche_perso)) {
		//Cas de la suppression
		if (_request('supprime_perso'.$tab['id'])) {
			sql_delete('spip_eva_habillage_images',"id=".$tab['id']);
			$res['message_ok'] = 'R&egrave;gle CSS supprim&eacute;e';
		}
		//Cas de la mise à jour
		if ((_request('submit_perso'.$tab['id'])) AND (_request('regle'.$tab['id'])!='')) {
			sql_updateq('spip_eva_habillage_images',array("type" => "perso", "nom_habillage" => "Defaut", "nom_div" => mysql_escape_string(_request('regle'.$tab['id']))),"id=".$tab['id']);
			$res['message_ok'] = 'R&egrave;gle CSS mise &agrave; jour';
		}
	}
	return $res;
}
?>