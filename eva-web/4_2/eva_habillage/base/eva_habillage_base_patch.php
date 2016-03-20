<?php
function eva_habillage_patch_table() {
	$Table1 = 'spip_eva_habillage';
	$Table2 = 'spip_eva_habillage_themes';
	$Table3 = 'spip_eva_habillage_images';
	$test=sql_showtable('eva_habillage',true);
	if ($test['field']) {
		$eva_verif_ancien = sql_select('id_habillage','eva_habillage',"sauvegarde = 'Defaut'");
		$eva_ver_tab_ancien = sql_fetch($eva_verif_ancien);
		$id_habillage_ancien = $eva_ver_tab_ancien['id_habillage'];
			if (isset($id_habillage_ancien)) {
				$eva_verif_nouveau = sql_select('id_habillage','spip_eva_habillage',"sauvegarde = 'Defaut'");
				$eva_ver_tab_nouveau = sql_fetch($eva_verif_nouveau);
				$id_habillage_nouveau = $eva_ver_tab_nouveau['id_habillage'];
				if (!isset($id_habillage_nouveau)) {
					sql_query('RENAME TABLE eva_habillage TO '.$Table1);
					sql_query('RENAME TABLE eva_habillage_themes TO '.$Table2);
					sql_query('RENAME TABLE eva_habillage_images TO '.$Table3);
				}
			}
	}
}
?>