<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
// On regarde tout si on est dans une feuille de style a 2 colonnes, dans ce cas, on rapatrie les elements
// situes dans droit pour les placer dans gauche
$test_3cols=sql_select('habillage','spip_eva_habillage',"sauvegarde='Defaut'");
$tab_3cols=sql_fetch($test_3cols);
if (!strpos($tab_3cols['habillage'],'3colonnes')) {
	$test=sql_select('*','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut'");
	while ($eva_id_bloc=sql_fetch($test)) {
		if ($eva_id_bloc['nom_image']=='droite')
		{
			sql_updateq('spip_eva_habillage_images',array('nom_image' => 'gauche'),"id = '".$eva_id_bloc['id']."'");
		}
	}
}
?>