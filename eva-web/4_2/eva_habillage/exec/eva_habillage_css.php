<?php

if (!defined("_ECRIRE_INC_VERSION")) return;
	include_spip('inc/presentation');

function exec_eva_habillage_css(){

	$evaTable = "spip_eva_habillage";
	if (defined("_DIR_PLUGIN_EVASQUELETTES")) {
		$path = _DIR_PLUGIN_EVASQUELETTES."images/vignettes_styles/";
		$path_evastyle = _DIR_PLUGIN_EVASQUELETTES."eva_styles/";
	}
	else {
		$path = "../squelettes/images/vignettes_styles/";
		$path_evastyle = "../squelettes/eva_styles/";
	}
	$icone = _DIR_PLUGIN_EVA_HABILLAGE."img_pack/eva.gif";

	?><SCRIPT LANGUAGE="JavaScript">
	function showColor(val)  {
		document.colorform.hexval.value = val;
	}
	function toggleCSSEdit(id, edit) {
		var cssPerso = document.getElementById('css_perso_'+id);
		var cssPersoEdit = document.getElementById('css_perso_'+id+'_edition');
		if(edit) {
			cssPerso.style.display = 'none';
			cssPersoEdit.style.display = 'block';
		} else {
			cssPerso.style.display = 'block';
			cssPersoEdit.style.display = 'none';
		}
	}
	</script><?php
	$commencer_page = charger_fonction('commencer_page', 'inc');
	echo $commencer_page(_T('evahabillage:EVA_nom') , '', '', '');
	echo gros_titre(_T('evahabillage:EVA_nom'),'',false);

	global $connect_statut;
	if ($GLOBALS['connect_statut'] != "0minirezo" OR !$GLOBALS["connect_toutes_rubriques"]) {
		echo _T('avis_non_acces_page');
		echo fin_gauche(), fin_page();
		exit;
	}
	echo debut_gauche("",true);
	echo debut_droite("",true);
	include_spip('inc/eva_habillage_boutons');
	echo eva_habillage_boutons('css');

	$css_defs =array(
		'css_supprime_titre' => "#entete h1 {display:none;}",
		'css_supprime_pied' => "ul#logo-pied, ul#pied {display:none;}",
		'css_supprime_mentions_pied' => "ul#pied .supprimer_le_pied {display:none;}",
		'css_supprime_bordure_tableau' => "table.spip tr.row_odd , table.spip tr.row_even , table.spip tr.row_odd td , table.spip tr.row_even td {border-width:0;}",
		'css_augmente_police_10' => "body {font-size: 110%;}",
		'css_augmente_police_20' => "body {font-size: 120%;}",
		'css_diminue_police_10' => "body {font-size: 90%;}",
		'css_diminue_police_20' => "body {font-size: 80%;}",
		'css_doubler_taille_titre_50' => "div#entete h1 {font-size:200%;}",
		'css_deplace_titre_50px_bas' => "div#entete h1 {top:50px;}",
		'css_deplace_titre_50px_gauche' => "div#entete h1 {left:50px;}",
		'css_augmente_titres_blocs_20' => "h3 , div#contenu h3 , legend , #forum .bouton a , .bloc .titre , .divers h4 , table.spip tr.row_first th , div#contenu div.ps h4 , div#menu h3.titre , div#menudroit h3.titre , table.spip tr.row_first , div#contenu div.lien , .contenu .lien , div#contenu div.notes h4 , div#contenu h4.titre , div#contenu h3.titre , #forum ul.forum div.titre h4{font-size: 120%;}",
	);

	if (isset($_POST['injection_css'])) {sql_insertq('spip_eva_habillage_images',array("type" => "perso", "nom_habillage" => "Defaut", "nom_div" => $css_defs[$_POST['injection_css']]));}

//Module 4 - Ajout de propriétés CSS personnelles
	echo '<br />&nbsp;<br />'; 
	echo debut_cadre_trait_couleur(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/css.png", true, '', _T('evahabillage:EVA_etape5'));
	if (isset($_POST['nouvelle_regle'])) {sql_insertq('spip_eva_habillage_images',array("type" => "perso", "nom_habillage" => "Defaut", "nom_div" => mysql_escape_string($_POST['nouvelle_regle'])));}
	if (isset($_POST['modifie_perso'])) {sql_updateq('spip_eva_habillage_images',array("type" => "perso", "nom_habillage" => "Defaut", "nom_div" => mysql_escape_string($_POST['regle'])),"id=".$_POST['modifie_perso']);}
	if (isset($_POST['supprime_perso'])) {sql_delete('spip_eva_habillage_images',"id=".$_POST['supprime_perso']);}

	echo '<div style="text-align:center;">'._T('evahabillage:EVA_etape5_detail').'<br />';
	echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage_css").'">';
	echo '<br /><input type="text" name="nouvelle_regle" size="60" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="'._T('evahabillage:EVA_valider').'" /></div></form><br />';
	echo fin_cadre_trait_couleur(true);
	echo '<br />&nbsp;<br />';
	echo debut_cadre_trait_couleur(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/css.png", true, '', _T('evahabillage:EVA_etape5_defini'));
	$recherche_perso_unique = sql_select('id','spip_eva_habillage_images',"type='perso' AND nom_habillage='Defaut'",'','','1');
	$tab_perso_unique = sql_fetch($recherche_perso_unique);
	if (isset($tab_perso_unique['id'])) {    
		echo '<br /><table align="center" class="spip">';
		$recherche_perso = sql_select("id,nom_div","spip_eva_habillage_images","type='perso' AND nom_habillage='Defaut'");
		while ($tab = sql_fetch($recherche_perso)) {
			echo '<tr align="center" ';
			if (($couleur_table%2)==0) {echo 'class="row_even"';} else {echo 'class="row_odd"';}
			$couleur_table++;
			echo '><td align="center">';
			echo '<div id="css_perso_'.$tab['id'].'" style="display:block;">';
			echo '<strong>'.mysql_escape_string($tab['nom_div']).'</strong>';
			echo '</div>';
			echo '<div id="css_perso_'.$tab['id'].'_edition" style="display:none;">';
			echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage_css").'">';
			echo '<input type="hidden" name="modifie_perso" value="'.$tab['id'].'" />';
			echo '<input type="text" name="regle" value="'.mysql_escape_string($tab['nom_div']).'" style="width: 100%" />';
			echo '<input type="reset" value="'._T('evahabillage:EVA_annuler').'" onclick="toggleCSSEdit('.$tab['id'].', false);" />';
			echo '<input type="submit" value="'._T('evahabillage:EVA_valider').'" />';
			echo '</form>';
			echo '</div>';		
			echo '</td><td align="center">';
			echo '<input type="button" value="'._T('evahabillage:EVA_modifier').'" onclick="toggleCSSEdit('.$tab['id'].', true);" />';
			echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage_css").'">';
			echo '<input type="hidden" name="supprime_perso" value="'.$tab['id'].'" />';
			echo '<input type="submit" value="'._T('evahabillage:EVA_supprimer').'" />';
			echo '</form>';
			echo '</td></tr>';
		}
		echo '</table>';
	}
    else {
		echo '<br />'._T('evahabillage:EVA_etape5_rien_defini');
	}
	echo fin_cadre_trait_couleur(true);

//Intégration de règles prédéfinies

	echo '<br />&nbsp;<br />'; 
	echo debut_cadre_trait_couleur(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/css.png", true, '', _T('evahabillage:css_inserer'));
	$couleur_table=0;
	echo '<br /><table align="center" class="spip">';
	foreach ($css_defs as $css_cle => $css_val) {
		echo '<tr align="center" ';
		if (($couleur_table%2)==0) {echo 'class="row_even"';} else {echo 'class="row_odd"';}
		$couleur_table++;
		echo '><td align="center">';
		echo '<strong>'._T('evahabillage:'.$css_cle)."</strong><br />";
		echo $css_val.'</td>';
		echo '<td align="center"><form method="POST" action="'.generer_url_ecrire("eva_habillage_css").'">';
		echo '<input type="hidden" name="injection_css" value="'.$css_cle.'" />';
		echo '<input type="submit" value="'._T('evahabillage:css_ajouter').'" /></form></td>';
		echo '</tr>';
	}
	echo '</table>';
	echo fin_cadre_trait_couleur(true);
	echo fin_gauche(), fin_page();
}
?>