<?php
function evasquelettes_AfficheGauche($flux) {
	$exec = $flux['args']['exec'];
	$icone = _DIR_PLUGIN_EVASQUELETTES.'images/eva3_favicon.png';
	if ($_POST['evamultilinguisme']=='oui') {
		sql_delete('spip_eva_habillage_images',"type='multilinguisme' AND nom_habillage='Defaut' AND nom_div='menu_langue_actif'");
		sql_insertq('spip_eva_habillage_images',array(
		'type' => 'multilinguisme',
		'nom_habillage' => 'Defaut',
		'nom_div' => 'menu_langue_actif',
		'nom_image' => 'oui'
	));
	}
	if ($_POST['evamultilinguisme']=='non') {
		sql_delete('spip_eva_habillage_images',"type='multilinguisme' AND nom_habillage='Defaut' AND nom_div='menu_langue_actif'");
	}
	$test=sql_select('nom_image','spip_eva_habillage_images',"type='multilinguisme' AND nom_habillage='Defaut' AND nom_div='menu_langue_actif'");
	$tab=sql_fetch($test);
	$go=$tab['nom_image'];	
	if (($exec == 'config_multilang') AND ($GLOBALS['connect_statut'] == "0minirezo")) {
		$retour .= debut_cadre_relief($icone,true,'', 'EVA-web : '._T("spip:info_multilinguisme"));
		$retour .= '<form method="POST" action="'.generer_url_ecrire($exec).'">';
		$retour .= '<div style="text-align:center;">';
		$retour .= '<p>';
		$retour .= _T('local:multilinguisme');
		$retour .= '</p>';
		$retour .= '<p>';
		$retour .= '<input name="evamultilinguisme" value="oui" ';
		if ($go) {$retour .= 'checked="checked" ';}
		$retour .= 'type="radio"> ';
		if ($go) {$retour .= '<b>';}
		$retour .= _T('ecrire:item_oui');
		if ($go) {$retour .= '</b>';}
		$retour .= '&nbsp; <input name="evamultilinguisme" value="non" ';
		if (!$go) {$retour .= 'checked="checked" ';}
		$retour .= 'type="radio"> ';
		if (!$go) {$retour .= '<b>';}
		$retour .= _T('ecrire:item_non');
		if (!$go) {$retour .= '</b>';}
		$retour .= '</p>';
		$retour .= '<input type="submit" value="'. _T('spip:bouton_valider').'">';
		$retour .= '</div>';
		$retour .= '</form>';
		$retour .= fin_cadre_relief(true);
		$flux['data'] .= $retour;
	}
	return $flux;
}
?>