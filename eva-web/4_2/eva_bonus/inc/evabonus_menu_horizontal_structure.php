<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('inc/presentation');

$req_menu_horizontal_actif0=sql_select('nom_image','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND nom_div='menu_depliable_horizontal_articles' AND attach='entete'");
$req_menu_horizontal_actif1=sql_select('nom_image','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND nom_div='menu_depliable_horizontal' AND attach='entete'");
$req_menu_horizontal_actif2=sql_select('nom_image','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND nom_div='headers_menu_depliable_horiz' AND attach='headers'");
$tab_menu_horizontal_actif0=sql_fetch($req_menu_horizontal_actif0);
$tab_menu_horizontal_actif1=sql_fetch($req_menu_horizontal_actif1);
$tab_menu_horizontal_actif2=sql_fetch($req_menu_horizontal_actif2);
$req_menu_horizontal_actif0=$tab_menu_horizontal_actif0['nom_image'];
$req_menu_horizontal_actif1=$tab_menu_horizontal_actif1['nom_image'];
$req_menu_horizontal_actif2=$tab_menu_horizontal_actif2['nom_image'];
if (
	($req_menu_horizontal_actif0=='oui' OR $req_menu_horizontal_actif1=='oui')
	AND $req_menu_horizontal_actif2!='oui') {
		echo debut_cadre_enfonce(_DIR_PLUGIN_EVABONUS."img_pack/logo_eva_bonus.png", true, '', _T('evabonus:evabonus_menu_horizontal'));
		echo _T('evabonus:evabonus_menu_horizontal_non_headers');
		echo fin_cadre_enfonce(true);
	}
	elseif (
	($req_menu_horizontal_actif0!='oui' AND $req_menu_horizontal_actif1!='oui')
	AND $req_menu_horizontal_actif2=='oui') {
		echo debut_cadre_enfonce(_DIR_PLUGIN_EVABONUS."img_pack/logo_eva_bonus.png", true, '', _T('evabonus:evabonus_menu_horizontal'));
		echo _T('evabonus:evabonus_menu_horizontal_non_entete');
		echo fin_cadre_enfonce(true);
	}
?>