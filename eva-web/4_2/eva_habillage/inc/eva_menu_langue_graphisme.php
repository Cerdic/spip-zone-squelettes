<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('inc/presentation');
include_spip('inc/eva_habillage_definition_themes');
$tab_menu_lang=EVA_menu_langue();

$test=sql_select('nom_image','spip_eva_habillage_images',"type='multilinguisme' AND nom_habillage='Defaut' AND nom_div='menu_langue_actif'");
$tab=sql_fetch($test);
$envoi=$tab['nom_image'];
if ($envoi) {

	if ($_POST['test_menu_langue']==2) {
		foreach ($tab_menu_lang as $cle => $value) {
			sql_delete('spip_eva_habillage_images',"nom_habillage = 'Defaut' AND type='multilinguisme' AND nom_div='".$cle."'");
			sql_insertq('spip_eva_habillage_images',array('nom_habillage' => 'Defaut','type' => 'multilinguisme','nom_div' => $cle,'nom_image' => $_POST[$cle]));
		}
	}

	echo debut_cadre_enfonce(_DIR_PLUGIN_EVASQUELETTES.'images/eva3_favicon.png', true, '', _T('evahabillage:eva_menu_langue_graphisme'));
	echo _T('evahabillage:eva_menu_langue_graphisme_explication');
	echo '<hr class="spip" />';
	echo "<form method='post' action='".generer_url_ecrire("eva_habillage_graphisme")."'>";
	echo '<table class="spip">';
	foreach ($tab_menu_lang as $cle => $value) {
		$req=sql_select('nom_image','spip_eva_habillage_images',"type='multilinguisme' AND nom_habillage='Defaut' AND nom_div='".$cle."'");
		$tab=sql_fetch($req);
		$code_menu_lang=$tab['nom_image'];
		echo '<tr><td style="text-align:center;">';
		echo _T('evahabillage:'.$cle).'</td>';
		echo '<td><input ';
		if (($cle!='eva_menu_langue_bordure_style') AND ($cle!='eva_menu_langue_bordure_width'))
		{echo 'class="palette" ';}
		echo 'type="text" name="'.$cle.'" value="'.$code_menu_lang.'" size="12">';
		echo '</td></tr>';
	}
	echo '</table>';
	echo '<input type="hidden" name="test_menu_langue" value=2>';
	echo "<br /><div style='text-align:center;'><input type='submit' value='Valider' /></div>";
	echo '</form>';
	echo fin_cadre_enfonce(true);
}
?>