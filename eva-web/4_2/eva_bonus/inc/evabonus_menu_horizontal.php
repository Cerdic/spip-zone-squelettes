<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('inc/presentation');

$tab_evabonus_menu=array(
	'evabonus_menu_horizontal_couleur_fond',
	'evabonus_menu_horizontal_couleur_fond_survol',
	'evabonus_menu_horizontal_couleur_fond_actif',
	'evabonus_menu_horizontal_couleur_texte',
	'evabonus_menu_horizontal_couleur_texte_survol',
	'evabonus_menu_horizontal_couleur_texte_actif',
	'evabonus_menu_horizontal_couleur_bordure_style',
	'evabonus_menu_horizontal_couleur_bordure_largeur',
	'evabonus_menu_horizontal_couleur_bordure_couleur'
);


if ($_POST['test_menu_depliable_horizontal']==2) {
	foreach ($tab_evabonus_menu as $cle_evabonus_menu) {
		sql_delete('spip_eva_habillage_images',"nom_habillage = 'Defaut' AND type='menu_depliable_horizontal' AND nom_div='".$cle_evabonus_menu."'");
		sql_insertq('spip_eva_habillage_images',array('nom_habillage' => 'Defaut','type' => 'menu_depliable_horizontal','nom_div' => $cle_evabonus_menu,'nom_image' => $_POST[$cle_evabonus_menu]));
	}
}

$req_menu_horizontal_actif0=sql_select('nom_image','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND nom_div='menu_depliable_horizontal_articles' AND attach='entete'");
$req_menu_horizontal_actif1=sql_select('nom_image','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND nom_div='menu_depliable_horizontal' AND attach='entete'");
$req_menu_horizontal_actif2=sql_select('nom_image','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND nom_div='headers_menu_depliable_horiz' AND attach='headers'");
//Requete speciale pour noisette de menu horizontale de sites references
$req_menu_horizontal_actif3=sql_select('nom_image','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND nom_div='menu_sites_horizontal' AND attach='entete'");
$tab_menu_horizontal_actif0=sql_fetch($req_menu_horizontal_actif0);
$tab_menu_horizontal_actif1=sql_fetch($req_menu_horizontal_actif1);
$tab_menu_horizontal_actif2=sql_fetch($req_menu_horizontal_actif2);
$tab_menu_horizontal_actif3=sql_fetch($req_menu_horizontal_actif3);
$req_menu_horizontal_actif0=$tab_menu_horizontal_actif0['nom_image'];
$req_menu_horizontal_actif1=$tab_menu_horizontal_actif1['nom_image'];
$req_menu_horizontal_actif2=$tab_menu_horizontal_actif2['nom_image'];
$req_menu_horizontal_actif3=$tab_menu_horizontal_actif3['nom_image'];
if (
	($req_menu_horizontal_actif0=='oui' OR $req_menu_horizontal_actif1=='oui' OR $req_menu_horizontal_actif3=='oui')
	AND $req_menu_horizontal_actif2=='oui') {
		echo debut_cadre_enfonce(_DIR_PLUGIN_EVABONUS."img_pack/logo_eva_bonus.png", true, '', _T('evabonus:evabonus_menu_horizontal'));
		echo _T('evabonus:evabonus_menu_horizontal_details');
		echo '<hr class="spip" />';
		echo "<form method='post' action='".generer_url_ecrire("eva_habillage_graphisme")."'>";
		echo '<table class="spip">';
		foreach ($tab_evabonus_menu as $cle_evabonus_menu) {
			$req_menu_depliable=sql_select('nom_image','spip_eva_habillage_images',"type='menu_depliable_horizontal' AND nom_habillage='Defaut' AND nom_div='".$cle_evabonus_menu."'");
			$tab_menu_depliable=sql_fetch($req_menu_depliable);
			$code_menu_depliable=$tab_menu_depliable['nom_image'];
			echo '<tr><td style="text-align:center;">';
			echo _T('evabonus:'.$cle_evabonus_menu).'</td>';
			echo '<td><input ';
			if (($cle_evabonus_menu!='evabonus_menu_horizontal_couleur_bordure_style') AND ($cle_evabonus_menu!='evabonus_menu_horizontal_couleur_bordure_largeur'))
			{echo 'class="palette" ';}
			echo 'type="text" name="'.$cle_evabonus_menu.'" value="'.$code_menu_depliable.'" size="12">';
			echo '</td></tr>';
		}
		echo '</table>';
		echo '<input type="hidden" name="test_menu_depliable_horizontal" value=2>';
		echo "<br /><div style='text-align:center;'><input type='submit' value='Valider' /></div>";
		echo '</form>';
		echo fin_cadre_enfonce(true);
	}
?>