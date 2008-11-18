<?php

if (!defined("_ECRIRE_INC_VERSION")) return;
include_spip('inc/presentation');

function exec_eva_bonus(){
	$commencer_page = charger_fonction('commencer_page', 'inc');
	echo $commencer_page(_T('evabonus:nom_plugin_bonus') , '', '', '');
	echo gros_titre(_T('evabonus:nom_plugin_bonus'),'',false);

	global $connect_statut;
	if ($GLOBALS['connect_statut'] != "0minirezo" OR !$GLOBALS["connect_toutes_rubriques"]) {
		echo _T('avis_non_acces_page');
		echo fin_gauche(), fin_page();
		exit;
	}

	echo debut_gauche("",true);
	echo debut_cadre_relief('',true,'','');
	echo _T('evabonus:descriptif_plugin_bonus');
	echo fin_cadre_relief(true);
	echo debut_droite("",true);
	include_spip('inc/evabonus');
	echo '<table class="spip">';
	$couleur_table=0;
	echo '<tr><td style="text-align:center;"><strong>'._T('evabonus:nom').'</strong></td>
	<td style="text-align:center;"><strong>'._T('evabonus:lieu').'</strong></td>
	<td style="text-align:center;"><strong>'._T('evabonus:descriptif').'</strong></td>
	<td style="text-align:center;"><strong>'._T('evabonus:auteur').'</strong></td></tr>';
	foreach (eva_bonus_tab() as $tab) {
	echo '<tr ';
        if (($couleur_table%2)==0) {echo 'class="row_even"';} else {echo 'class="row_odd"';}
        $couleur_table++;
	echo '><td style="text-align:center;">'.$tab[0].'</td>
	<td style="text-align:center;">'.$tab[1].'</td>
	<td style="text-align:center;">'.$tab[2].'</td>
	<td style="text-align:center;">'.$tab[3].'</td></tr>';
	}
	echo '</table>';
	
	echo fin_gauche(), fin_page();
}
?>