<?php

if (!defined("_ECRIRE_INC_VERSION")) return;
	include_spip('inc/presentation');

function exec_eva_habillage_sauvegarde() {

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
	echo eva_habillage_boutons('sauvegarde');

	include_spip("inc/eva_habillage_definition_themes");
	$def_themes = eva_habillage_definition_themes ();

	if (isset($_POST['restauration_habillage'])) {
		$recherche_habillage_restaure = sql_select('habillage','spip_eva_habillage',"sauvegarde='".mysql_escape_string($_POST['restauration_habillage'])."'");
		$tab__habillage_restaure = sql_fetch($recherche_habillage_restaure);
		sql_updateq('spip_eva_habillage',array('habillage' => $tab__habillage_restaure['habillage']),"sauvegarde='Defaut'");

		sql_delete('spip_eva_habillage_images',"nom_habillage='Defaut'");
		$recherche_images_restaure=sql_select('type,nom_div,nom_image,pos_x,pos_y,repetition,attach','spip_eva_habillage_images',"nom_habillage='".mysql_escape_string($_POST['restauration_habillage'])."'");
		while ($tab=sql_fetch($recherche_images_restaure)) {
			sql_insertq('spip_eva_habillage_images',array('type' => $tab['type'],'nom_habillage' => 'Defaut','nom_div' => $tab['nom_div'],'nom_image' => $tab['nom_image'],'pos_x' => $tab['pos_x'],'pos_y' => $tab['pos_y'],'repetition' => $tab['repetition'],'attach' => $tab['attach']));
		}

		$result_restaure=sql_select('*','spip_eva_habillage_themes',"nom='".mysql_escape_string($_POST['restauration_habillage'])."'");
		$tab_restaure=sql_fetch($result_restaure);
		foreach($def_themes as $habillage_cles => $habillage_inutile) {
			if (isset($tab_restaure[$habillage_cles])) {sql_updateq('spip_eva_habillage_themes',array($habillage_cles => $tab_restaure[$habillage_cles]),"nom='Defaut'");}
			else {sql_updateq('spip_eva_habillage_themes',array($habillage_cles => ''),"nom='Defaut'");}
		}
		include_spip('inc/eva_habillage_transition_module');
		eva_habillage_transition_module();
	}

	if (isset($_POST['integrer_theme_externe'])) {

		include_spip('inc/eva_habillage_themes_externes');
		$tab_externe = eva_charger_themes();
		$theme_externe = $tab_externe[$_POST['integrer_theme_externe'.$_POST['integrer_theme_externe']]];
		sql_delete('spip_eva_habillage_themes',"nom = 'Defaut'");
		sql_delete('spip_eva_habillage_images',"nom_habillage = 'Defaut'");
		sql_updateq('spip_eva_habillage',array('habillage' => $theme_externe['habillage']),"sauvegarde = 'Defaut'");
		spip_query("INSERT INTO spip_eva_habillage_themes VALUES ".$theme_externe['theme']);
		$tab = $theme_externe['images'];
		sql_insertq('spip_eva_habillage_images',array('type'=>'theme','nom_habillage'=>'Defaut','nom_div'=>$_POST['integrer_theme_externe']));
		foreach ($tab as $val) {spip_query("INSERT INTO spip_eva_habillage_images VALUES ".$val);}
		include_spip('inc/eva_habillage_transition_module');
		eva_habillage_transition_module();
	}

	//Module 5 - Module de sauvegarde
	echo '<br />&nbsp;<br />';
	echo debut_cadre_trait_couleur(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/disk.png", true, '', _T('evahabillage:EVA_etape4'));

	if (isset($_POST['supprimer_habillage'])) {
		sql_delete("spip_eva_habillage","sauvegarde='".mysql_escape_string($_POST['supprimer_habillage'])."'");
		sql_delete("spip_eva_habillage_themes","nom='".mysql_escape_string($_POST['supprimer_habillage'])."'");
		sql_delete("spip_eva_habillage_images","nom_habillage='".mysql_escape_string($_POST['supprimer_habillage'])."'");
	}

	if ((isset($_POST['nouvelle_sauvegarde'])) AND ($_POST['nouvelle_sauvegarde']!='Defaut')) {
		$nom_habillage_defaut=sql_select("habillage","spip_eva_habillage","sauvegarde = 'Defaut'");
		$tab_habillage_defaut=sql_fetch($nom_habillage_defaut);
		sql_delete("spip_eva_habillage","sauvegarde='".mysql_escape_string($_POST['nouvelle_sauvegarde'])."'");
		sql_insertq("spip_eva_habillage",array('habillage' => $tab_habillage_defaut['habillage'],'sauvegarde' => mysql_escape_string($_POST['nouvelle_sauvegarde'])));
		sql_delete("spip_eva_habillage_themes","nom='".mysql_escape_string($_POST['nouvelle_sauvegarde'])."'");
		sql_insertq("spip_eva_habillage_themes",array('nom' => mysql_escape_string($_POST['nouvelle_sauvegarde'])));
		$result_valeurs=sql_select("*","spip_eva_habillage_themes","nom='Defaut'");
		$tab_valeurs=sql_fetch($result_valeurs);
		foreach($def_themes as $habillage_cles => $habillage_inutile) {sql_updateq('spip_eva_habillage_themes',array($habillage_cles => $tab_valeurs[$habillage_cles]),"nom='".mysql_escape_string($_POST['nouvelle_sauvegarde'])."'");}
		sql_delete("spip_eva_habillage_images","nom_habillage='".mysql_escape_string($_POST['nouvelle_sauvegarde'])."'");
		$result_images_sauve=sql_select('type,nom_div,nom_image,pos_x,pos_y,repetition,attach','spip_eva_habillage_images',"nom_habillage='Defaut'");
		while ($tab=sql_fetch($result_images_sauve)) {
			sql_insertq("spip_eva_habillage_images",array('type' => $tab['type'],'nom_habillage' => mysql_escape_string($_POST['nouvelle_sauvegarde']),'nom_div' => $tab['nom_div'], 'nom_image' => $tab['nom_image'], 'pos_x' => $tab['pos_x'],'pos_y' => $tab['pos_y'],'repetition' => $tab['repetition'], 'attach' => $tab['attach']));
		}
	}
	elseif($_POST['nouvelle_sauvegarde']=='Defaut') {
		debut_cadre_relief('', false, '', _T('evahabillage:EVA_erreur_sauvegarde'));
		echo _T('evahabillage:EVA_erreur_sauvegarde2');
		fin_cadre_relief();
	}

	$resultat_sauvegarde1 = sql_select('nom','spip_eva_habillage_themes',"nom != 'Defaut'",'','nom');
	$resultat_sauvegarde2 = sql_select('nom','spip_eva_habillage_themes',"nom != 'Defaut'",'','nom');
	$test_presence = sql_select('nom','spip_eva_habillage_themes',"nom != 'Defaut'",'','nom');
	$tab_presence = sql_fetch($test_presence);

	echo '<div style="text-align:center;">'._T('evahabillage:EVA_etape4_sauvegarder').'<br />&nbsp;<br /><form method="POST" action="'.generer_url_ecrire("eva_habillage_sauvegarde").'">';
	echo '<input type="text" name="nouvelle_sauvegarde" size="40">&nbsp;&nbsp;<input type="submit" value="'._T('evahabillage:EVA_sauvegarder').'"></div></form>';

	if ($tab_presence!='') {
		echo '<br /><hr /><div style="text-align:center;">'._T('evahabillage:EVA_etape4_restaurer').'<br />&nbsp;<br /><form method="POST" action="'.generer_url_ecrire("eva_habillage_sauvegarde").'"><select name="restauration_habillage">';
		while ($tab = sql_fetch($resultat_sauvegarde1)) {
		echo '<option value="'.$tab['nom'].'">'.$tab['nom'].'</option>'; }
		echo '</select><br />&nbsp;<br /><input type="submit" value="'._T('evahabillage:EVA_restaurer').'"></form></div><br /><hr />';

		echo '<div style="text-align:center;">'._T('evahabillage:EVA_etape4_supprimer').'<br />&nbsp;<br /><form method="POST" action="'.generer_url_ecrire("eva_habillage_sauvegarde").'"><select name="supprimer_habillage">';
		while ($tab = sql_fetch($resultat_sauvegarde2)) {
		echo '<option value="'.$tab['nom'].'">'.$tab['nom'].'</option>'; }
		echo '</select><br />&nbsp;<br /><input type="submit" value="'._T('evahabillage:EVA_suppression').'"></form></div>';
	}
	echo fin_cadre_trait_couleur(true);	
	echo '<br />&nbsp;<br />';
	echo debut_cadre_trait_couleur(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/plume.png", true, '', "<div style='text-align:center;'>"._T('evahabillage:EVA_restauration_externe')."</div>");
	$chemin_themes = _DIR_PLUGIN_EVA_HABILLAGE."inc/eva_habillage_themes_externes.php";
	if (file_exists($chemin_themes)) {
		include_spip('inc/eva_habillage_themes_externes');
		$tab_externe = eva_charger_themes();
		if (isset($tab_externe)) {
			echo _T('evahabillage:EVA_restauration_externe_choix').'<br />&nbsp;<br />';?>
			<script type="text/javascript">
			<!--
			if(document.images){
				newvign = new Array()
				for(i=1;i<<?php echo count($tab_externe);?>;i++){
					newvign[i] = new Image()
					newvign[i].src = i + ".png"
				}
			}

				function affvign(){
				chemin = "<?php echo _DIR_PLUGIN_EVA_HABILLAGE.'img_pack/vignettes/'; ?>"
				if(document.images){
					validevign=document.formvignette.integrer_theme_externe.options[document.formvignette.integrer_theme_externe.selectedIndex].value
					document.vignetteaff.src = chemin+validevign+".png"
				}
			}
			window.onerror = null;
			//-->
			</script>
			<?php
			$test_theme_present=sql_select('nom_div','spip_eva_habillage_images',"nom_habillage='Defaut' AND type='theme'");
			$tab_theme_present=sql_fetch($test_theme_present);
			$test_theme_actif=$tab_theme_present['nom_div'];
			echo '<form method="POST"  name ="formvignette" action="'.generer_url_ecrire("eva_habillage_sauvegarde").'"><table><tr><th><select name="integrer_theme_externe" onChange = "affvign()">';
			$i=1;
			foreach ($tab_externe as $cle => $inutile) {
				echo '<option value="'.$i.'" ';
				if ($test_theme_actif==$i) {echo 'selected';}
				echo '>'.$cle.'</option>'; $i++;
			}
			echo '</select>&nbsp;&nbsp;&nbsp;<input type="submit" value="'._T('evahabillage:EVA_valider').'">';
			$i=1;
			foreach ($tab_externe as $cle => $inutile) {echo '<input type="hidden" name ="integrer_theme_externe'.$i.'" value="'.$cle.'">'; $i++;}
			if (!$test_theme_actif) {$test_theme_actif=1;}
		echo '</th><th>&nbsp;&nbsp;&nbsp;<img name = "vignetteaff" src= "'._DIR_PLUGIN_EVA_HABILLAGE.'img_pack/vignettes/'.$test_theme_actif.'.png" style="border:#AAA solid 5px;"></th></tr></table></form>';}
		else {echo _T('evahabillage:EVA_restauration_externe_aucun');}
	}
	else {echo _T('evahabillage:EVA_restauration_externe_aucun');}
	echo '<hr />'._T('evahabillage:eva_habillage_CC');
	echo fin_cadre_trait_couleur(true);
	echo fin_gauche(), fin_page();
}
?>