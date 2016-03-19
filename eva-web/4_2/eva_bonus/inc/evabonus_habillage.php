<?php
	if (!defined("_ECRIRE_INC_VERSION")) return;
	include_spip('inc/presentation');
	echo debut_cadre_enfonce(_DIR_PLUGIN_EVABONUS."img_pack/logo_eva_bonus.png", true, '', _T('evabonus:evabonus_nom'));
	echo '<div  style="text-align:center;"><p>'._T('evabonus:evahabillage_block_evabonus').'</p>';
	echo '<table class="spip">';
	$couleur_table=0;
	include_spip('inc/evabonus');
	foreach (eva_bonus_tab() as $tab) {
		echo '<tr ';
		if (($couleur_table%2)==0) {echo 'class="row_even"';} else {echo 'class="row_odd"';}
		$couleur_table++;
		echo ' style="font-size:0.5em;"><td style="text-align:center;" title="S\'applique sur : '.$tab[1].'">'.$tab[0].'</td></tr>';
	}
	echo '</table></div>';
	echo fin_cadre_enfonce(true);
?>