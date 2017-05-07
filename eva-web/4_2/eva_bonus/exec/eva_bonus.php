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
	echo '</table><br style="height:40px;" />';

	/** Gestion des noisettes meteo **/
	$req_meteo=sql_select('nom_image','spip_eva_habillage_images',"type='evabonus' AND nom_habillage='Defaut' AND nom_div='code_commune'");
	$tab_meteo=sql_fetch($req_meteo);
	$code_commune=$tab_meteo['nom_image'];
	if ($_POST['code_commune']) {
		sql_delete('spip_eva_habillage_images',"nom_habillage = 'Defaut' AND type='evabonus' AND nom_div='code_commune'");
		sql_insertq('spip_eva_habillage_images',array('nom_habillage' => 'Defaut','type' => 'evabonus','nom_div' => 'code_commune','nom_image' => $_POST['code_commune']));
		$code_commune=$_POST['code_commune'];
	}
	$req_meteo=sql_select('nom_image','spip_eva_habillage_images',"type='evabonus' AND nom_habillage='Defaut' AND nom_div='jours_prevision'");
	$tab_meteo=sql_fetch($req_meteo);
	$jours_prevision=$tab_meteo['nom_image'];
	if ($_POST['jours_prevision']) {
		sql_delete('spip_eva_habillage_images',"nom_habillage = 'Defaut' AND type='evabonus' AND nom_div='jours_prevision'");
		sql_insertq('spip_eva_habillage_images',array('nom_habillage' => 'Defaut','type' => 'evabonus','nom_div' => 'jours_prevision','nom_image' => $_POST['jours_prevision']));
		$jours_prevision=$_POST['jours_prevision'];
	}

	echo debut_cadre_trait_couleur('../'._DIR_PLUGIN_EVABONUS.'img_pack/rainette.png', true,'','<div style="text-align:center;">Utilisation des noisettes de m&eacute;t&eacute;o</div>');
	echo "<form method='post' action='".generer_url_ecrire("eva_bonus")."'>Afin d'utiliser les noisettes de m&eacute;t&eacute;o, il vous faut :
	<ul><li> installer et activer le plugin <a href='https://plugins.spip.net//rainette'>Rainette</a></li>
	<li> indiquer ici le code commune concern&eacute;.</li></ul>";
	echo "Pour obtenir le code commune correspondant &agrave; votre commune (la grande ville la plus proche), entrez l'URL suivante dans votre navigateur : http://xoap.weather.com/search/search?where=ma_ville";
	echo "<br />&nbsp;<br /><center>Code commune : ";
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="code_commune" value="'.$code_commune.'" size="8"><br />&nbsp;<br />';
	echo 'Concernant la noisette de pr&eacute;vision sur plusieurs jours, combien de jours faut-il afficher ? ';
	echo "<select name='jours_prevision'>";
		for ($i=1;$i<=14;$i++) {
			echo '<option value="'.$i.'" ';
			if ($i==$jours_prevision) {echo 'selected';}
			echo '>'.$i.'</option>';
		}
	echo '</select>';
	echo "<br />&nbsp;<br />";
	echo "<input type='submit' value='Valider' /></center>";
	echo "</form>";
	echo fin_cadre_trait_couleur(true);
	/** Fin meteo **/

	echo fin_gauche(), fin_page();
}
?>