<?php
if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('base/eva_habillage_base');
include_spip('base/abstract_sql');
$test_puce=sql_select('nom_image','spip_eva_habillage_images',"type='puce_spip' AND nom_habillage='Defaut'");
$tab_puce=sql_fetch($test_puce);
$puce=$tab_puce['nom_image'];
if ($puce) {
$GLOBALS['puce']="<img src='"._DIR_IMG."eva_habillage/".$puce."' alt='-' align='top' border='0'>";
}
?>