<?php

if (!defined("_ECRIRE_INC_VERSION")) return;
	include_spip('inc/presentation');

function exec_eva_habillage(){

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
	include_spip('inc/evabonus_habillage');
	echo debut_droite("",true);
	include_spip('inc/eva_habillage_boutons');
	echo eva_habillage_boutons('structure');

	if (isset($_POST['changement_habillage'])) {
		sql_updateq('spip_eva_habillage',array('habillage' => $_POST['changement_habillage']),"sauvegarde = 'Defaut'");
		if (!strpos($_POST['changement_habillage'],'3colonnes')){
			$test_quitte_3colonnes=sql_select('id','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND nom_image='droite'");
			while ($tab_quitte_3colonnes=sql_fetch($test_quitte_3colonnes)) {
				sql_updateq('spip_eva_habillage_images',array('nom_image'=>'gauche'),"id='".$tab_quitte_3colonnes['id']."'");
			}
		}
	}

	include_spip("inc/eva_habillage_definition_themes");
	$def_themes = eva_habillage_definition_themes ();

	$test_fri=sql_select('id_habillage','spip_eva_habillage',"sauvegarde='Defaut'");
	$tab_fri=sql_fetch($test_fri);
	if (!isset($tab_fri['id_habillage'])) {sql_insertq('spip_eva_habillage',array('habillage' => '0','sauvegarde' => 'Defaut'));}

	$resultat1 = sql_select('habillage','spip_eva_habillage',"sauvegarde = 'Defaut'");
	$resultat1_tableau = sql_fetch($resultat1);
	$mon_habillage = $resultat1_tableau['habillage'];

// Premier Module - Choix de l'habillage de base
?>
<script type="text/javascript">
<!--
if(document.images){
	newvign = new Array()
	newvign["eva_style.png"] = new Image()
	newvign["eva_style.png"].src = "eva_style.png"
	newvign[0] = new Image()
	newvign[0].src = "eva_style.png"
}

function affvign(){
	chemin = "<?php echo _DIR_PLUGIN_EVASQUELETTES.'images/vignettes_styles/'; ?>"
	if(document.images){
		validevign=document.formvignette.changement_habillage.options[document.formvignette.changement_habillage.selectedIndex].value
		document.vignetteaff.src = chemin+validevign+".png"
	}
}
window.onerror = null;
//-->
</script>
<?php
	echo debut_cadre_trait_couleur(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/image_pinceaux.png", true, '', _T('evahabillage:EVA_etape1'));
	echo _T('evahabillage:EVA_a_penser').'<br />';
	echo '<div style="text-align:center;"><p>'. _T('evahabillage:EVA_actif');
	if ($mon_habillage=='0'){echo _T('evahabillage:EVA_style_defaut');} else {echo "<strong>".$mon_habillage."</strong>";}
	echo '</p><br />';    
	$image_habillage = preg_replace('/.css/','.png',$mon_habillage);
	if ($image_habillage=='0') {$image_habillage='eva_style.png';}
	if (file_exists($path.$image_habillage)) {
		echo '<img  name = "vignetteaff" src="'.$path.$image_habillage.'"  style="border:#AAA solid 5px;" alt=""/><br />';
	}
	else {
		echo '<img  name = "vignetteaff" src="'.$path.'eva_style.png"  style="border:#AAA solid 5px;" alt=""/><br />';
	}

	echo '<br />'._T('evahabillage:EVA_choix').'<br />&nbsp;<br />';
	echo '<form method="POST"  name ="formvignette" action="'.generer_url_ecrire("eva_habillage").'">';?>
	<select name="changement_habillage" onChange = "affvign()"><option value="0" <?php if ($mon_habillage=='0') {echo "selected";}?> >
	<?php echo _T('evahabillage:EVA_style_defaut')."</option>";
	if (defined("_DIR_PLUGIN_EVASQUELETTES")) {
		$dir = opendir($path_evastyle);
	}
	else {
		$dir = opendir('../squelettes/eva_styles/');
	}
	while ($nom_fichier = readdir($dir)) {
		if (($nom_fichier!='.') AND ($nom_fichier!='..') AND ($nom_fichier!='.png') AND (strpos($nom_fichier,'.css'))) {
			echo '<option value="'.$nom_fichier.'"';
			if ($mon_habillage==$nom_fichier) {echo ' selected ';}
			echo '>'.$nom_fichier.'</option>';
		}
	}
	closedir($dir);
	echo '</select><br />&nbsp;<br /><input type="submit" value="'._T('evahabillage:EVA_choisir').'" >';
	echo "</form></div><br />";
	echo fin_cadre_trait_couleur(true);

// Choix des noisettes dans les colonnes
	echo debut_cadre_trait_couleur(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/blocs.png", true, '', _T('evahabillage:EVA_choix_bloc'));

	$test_3cols=sql_select('habillage','spip_eva_habillage',"sauvegarde='Defaut'");
	$tab_3cols=sql_fetch($test_3cols);
	if (strpos($tab_3cols['habillage'],'3colonnes')) {
		$test_3_colonnes=true;
		$eva_gauche=120;
		$eva_centre=249;
		$eva_droite=120;
	}
	else {
		$test_3_colonnes=false;
		if (strpos($mon_habillage,'droite')) {
			$test_droite=true;
			$eva_gauche=false;
			$eva_centre=309;
			$eva_droite=180;
		}
		else {
			$eva_centre=309;
			$eva_gauche=180;
			$eva_droite=false;
		}
	}

	$verif_post_bloc=sql_select('*','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut'");
	while ($tab_eva_bloc = sql_fetch($verif_post_bloc)) {
		if (isset($tab_eva_bloc['nom_div'])) {
			sql_updateq('spip_eva_habillage_images',array('nom_image' => $_POST[$tab_eva_bloc['nom_div']],'pos_x' =>$_POST[$tab_eva_bloc['nom_div'].'_pos_x']),"nom_habillage = 'Defaut' AND type = 'bloc' AND nom_div = '".$_POST[$tab_eva_bloc['nom_div'].'_nom_bloc']."'");
		}
	}

	if ($_POST['eva_mon_bloc_perso_nom']) {
		sql_insertq('spip_eva_habillage_images',array(
			'type' => 'bloc',
			'nom_habillage' => 'Defaut',
			'nom_div' => $_POST['eva_mon_bloc_perso_nom'],
			'nom_image' => $_POST['eva_mon_bloc_perso_nom_image'],
			'pos_x' => $_POST['eva_mon_bloc_perso_pos_x'],
			'repetition' => 'perso',
			'attach' => $_POST['eva_mon_bloc_perso_skel']
		));
	}

	if ($_POST['EVA_suppr_skel_perso']) {
		sql_delete('spip_eva_habillage_images',"id='".$_POST['EVA_suppr_skel_perso']."'");
	}

	$les_blocs_array = EVA_les_blocs();
	foreach ($les_blocs_array as $les_blocs=>$les_noisettes) {

		echo bouton_block_depliable(_T('evahabillage:EVA_choix_bloc_'.$les_blocs),false,'');
		echo debut_block_depliable(false);
		
		echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';
		echo '<table><tr valign="top">';
		if ($eva_gauche) {
			echo "<th width=$eva_gauche>";
			echo debut_cadre_trait_couleur('', true, '', 'Colonne de gauche');
			$test_noisettes=sql_select('*','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND attach='$les_blocs' AND nom_image='gauche'",'','pos_x');
			while ($tab_noisettes=sql_fetch($test_noisettes)) {
				if ($tab_noisettes['repetition']=='perso') {$eva_nom_du_bloc='Squelette '.$tab_noisettes['nom_div'].'.html';}
				else {$eva_nom_du_bloc=_T('evahabillage:'.$tab_noisettes['nom_div']);}
				echo debut_cadre_enfonce('',true,'',$eva_nom_du_bloc);
				echo 'Passer &agrave;<br />';
				echo '<input type="hidden" name="'.$tab_noisettes['nom_div'].'_nom_bloc'.'" value="'.$tab_noisettes['nom_div'].'">';
				echo "<select name='".$tab_noisettes['nom_div']."'>
				<option value='gauche' selected>gauche</option>
				<option value='centre'>centre</option>";
				if ($eva_droite) {echo "<option value='droite'>droite</option>";}
				echo "<option value='non'>Non affich&eacute;</option>";
				echo '</select><br />&nbsp;<br />';
				echo 'Ordre';
				echo "<select name='".$tab_noisettes['nom_div']."_pos_x'>";
				for ($i=1;$i<=9;$i++) {
					echo '<option value="'.$i.'" ';
					if ($i==$tab_noisettes['pos_x']) {echo 'selected';}
					echo '>'.$i.'</option>';
				}
				echo '</select>';
				echo fin_cadre_enfonce(true);
			}
			echo fin_cadre_trait_couleur(true);
			echo '</th>';
		}
		if ($eva_centre) {
			echo "<th width=$eva_centre>";
			echo debut_cadre_trait_couleur('', true, '', 'Colonne centrale');
			$test_noisettes=sql_select('*','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND attach='$les_blocs' AND nom_image='centre'",'','pos_x ASC');
			while ($tab_noisettes=sql_fetch($test_noisettes)) {
				if ($tab_noisettes['repetition']=='perso') {$eva_nom_du_bloc='Squelette '.$tab_noisettes['nom_div'].'.html';}
				else {$eva_nom_du_bloc=_T('evahabillage:'.$tab_noisettes['nom_div']);}
				echo debut_cadre_enfonce('',true,'',$eva_nom_du_bloc);
				echo 'Passer &agrave;<br />';
				echo '<input type="hidden" name="'.$tab_noisettes['nom_div'].'_nom_bloc'.'" value="'.$tab_noisettes['nom_div'].'">';
				echo "<select name='".$tab_noisettes['nom_div']."'>";
				if ($eva_gauche) {echo "<option value='gauche'>gauche</option>";}
				echo "<option value='centre' selected>centre</option>";
				if (($eva_droite) AND (!$eva_gauche)) {echo "<option value='gauche'>droite</option>";}
				elseif ($eva_droite) {echo "<option value='droite'>droite</option>";}
				echo "<option value='non'>Non affich&eacute;</option>";
				echo '</select><br />&nbsp;<br />';
				echo 'Ordre';
				echo "<select name='".$tab_noisettes['nom_div']."_pos_x'>";
				for ($i=1;$i<=9;$i++) {
					echo '<option value="'.$i.'" ';
					if ($i==$tab_noisettes['pos_x']) {echo 'selected';}
					echo '>'.$i.'</option>';
				}
				echo '</select>';
				echo fin_cadre_enfonce(true);
			}
			echo fin_cadre_trait_couleur(true);
			echo '</th>';
		}
		if ($eva_droite) {
			echo "<th width=$eva_droite>";
			echo debut_cadre_trait_couleur('', true, '', 'Colonne de droite');
			if (!$eva_gauche) {$eva_colonne_test='gauche';} else {$eva_colonne_test='droite';}
			$test_noisettes=sql_select('*','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND attach='$les_blocs' AND nom_image='$eva_colonne_test'",'','pos_x ASC');
			while ($tab_noisettes=sql_fetch($test_noisettes)) {
				if ($tab_noisettes['repetition']=='perso') {$eva_nom_du_bloc='Squelette '.$tab_noisettes['nom_div'].'.html';}
				else {$eva_nom_du_bloc=_T('evahabillage:'.$tab_noisettes['nom_div']);}
				echo debut_cadre_enfonce('',true,'',$eva_nom_du_bloc);
				echo 'Passer &agrave;<br />';
				echo '<input type="hidden" name="'.$tab_noisettes['nom_div'].'_nom_bloc'.'" value="'.$tab_noisettes['nom_div'].'">';
				echo "<select name='".$tab_noisettes['nom_div']."'>";
				if ($eva_gauche) {echo "<option value='gauche'>gauche</option>";}
				echo "<option value='centre'>centre</option>";
				echo "<option value='".$eva_colonne_test."' selected>droite</option>";
				echo "<option value='non'>Non affich&eacute;</option>";
				echo '</select><br />&nbsp;<br />';
				echo 'Ordre';
				echo "<select name='".$tab_noisettes['nom_div']."_pos_x'>";
				for ($i=1;$i<=9;$i++) {
					echo '<option value="'.$i.'" ';
					if ($i==$tab_noisettes['pos_x']) {echo 'selected';}
					echo '>'.$i.'</option>';
				}
				echo '</select>';
				echo fin_cadre_enfonce(true);
			}
			echo fin_cadre_trait_couleur(true);
			echo '</th>';
		}
		echo '</tr></table>';

		$texte_eva='<table><tr><th width=489>';
		$texte_eva.= debut_cadre_trait_couleur('', true, '', 'Squelettes actuellement non affich&eacute;s');
		$texte_eva.= "<table class='spip'><tr class='row_even'>";
		$texte_eva.= "<th>Squelette</th><th>Colonne</th><th>Ordre</th>";
		$texte_eva.= '</tr>';
		$test_affichage_eva=false;

		$test_noisettes=sql_select('*','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND attach='".$les_blocs."'",'','pos_x ASC');
		while ($tab_noisettes=sql_fetch($test_noisettes)) {
			if ((!$eva_droite) AND ($tab_noisettes['nom_image']=='droite')) {
				echo '<input type="hidden" name="'.$tab_noisettes['nom_div'].'_nom_bloc'.'" value="'.$tab_noisettes['nom_div'].'">';
				$test_affichage_eva=true;
				$texte_eva.="<tr class='row_odd'><th>";
				if ($tab_noisettes['repetition']) {
					$texte_eva.= 'Squelette '.$tab_noisettes['nom_div'].'.html';
				}
				else {
					$texte_eva.= _T('evahabillage:'.$tab_noisettes['nom_div']);
				}
				$texte_eva.= "</th><th><select name='".$tab_noisettes['nom_div']."'>";
				$texte_eva.= "<option value='gauche'>gauche</option>";
				$texte_eva.= "<option value='centre'>centre</option>";
				$texte_eva.= "<option value='droite' selected>droite</option>";
				$texte_eva.= "<option value='non'>Non affich&eacute;</option>";
				$texte_eva.= '</select></th><th>';
				$texte_eva.= "<select name='".$tab_noisettes['nom_div']."_pos_x'>";
				for ($i=1;$i<=9;$i++) {
					$texte_eva.= '<option value="'.$i.'" ';
					if ($i==$tab_noisettes['pos_x']) {$texte_eva.= 'selected';}
					$texte_eva.= '>'.$i.'</option>';
				}
				$texte_eva.= '</select></th>';
				$texte_eva.= '</tr>';
			}
			elseif ((!$eva_gauche) AND ($tab_noisettes['nom_image']=='droite')) {
				echo '<input type="hidden" name="'.$tab_noisettes['nom_div'].'_nom_bloc'.'" value="'.$tab_noisettes['nom_div'].'">';
				$test_affichage_eva=true;
				$texte_eva.="<tr class='row_odd'><th>";
				if ($tab_noisettes['repetition']) {
					$texte_eva.= 'Squelette '.$tab_noisettes['nom_div'].'.html';
				}
				else {
					$texte_eva.= _T('evahabillage:'.$tab_noisettes['nom_div']);
				}
				$texte_eva.= "</th><th><select name='".$tab_noisettes['nom_div']."'>";
				$texte_eva.= "<option value='gauche'>droite</option>";
				$texte_eva.= "<option value='centre'>centre</option>";
				$texte_eva.= "<option value='droite' selected>gauche</option>";
				$texte_eva.= "<option value='non'>Non affich&eacute;</option>";
				$texte_eva.= '</select></th><th>';
				$texte_eva.= "<select name='".$tab_noisettes['nom_div']."_pos_x'>";
				for ($i=1;$i<=9;$i++) {
					$texte_eva.= '<option value="'.$i.'" ';
					if ($i==$tab_noisettes['pos_x']) {$texte_eva.= 'selected';}
					$texte_eva.= '>'.$i.'</option>';
				}
				$texte_eva.= '</select></th>';
				$texte_eva.= '</tr>';
			}
			elseif (($tab_noisettes['nom_image']=='non')) {
				echo '<input type="hidden" name="'.$tab_noisettes['nom_div'].'_nom_bloc'.'" value="'.$tab_noisettes['nom_div'].'">';
				$test_affichage_eva=true;
				$texte_eva.="<tr class='row_odd'><th>";
				if ($tab_noisettes['repetition']) {
					$texte_eva.= 'Squelette '.$tab_noisettes['nom_div'].'.html';
				}
				else {
					$texte_eva.= _T('evahabillage:'.$tab_noisettes['nom_div']);
				}
				$texte_eva.= "</th><th><select name='".$tab_noisettes['nom_div']."'>";
				$texte_eva.= "<option value='non' selected='selected'>Non affich&eacute;</option>";
				$texte_eva.= "<option value='gauche'>";
				if (!$eva_gauche) {$texte_eva.='droite';} else  {$texte_eva.='gauche';}
				$texte_eva.="</option>";
				$texte_eva.= "<option value='centre'>centre</option>";
				if (($tab_3cols['habillage']=='eva4_3colonnes.css') OR ($tab_3cols['habillage']=='eva4_basic_3colonnes.css')){
					$texte_eva.= "<option value='droite'>droite</option>";
				}
				$texte_eva.= '</select></th><th>';
				$texte_eva.= "<select name='".$tab_noisettes['nom_div']."_pos_x'>";
				for ($i=1;$i<=9;$i++) {
					$texte_eva.= '<option value="'.$i.'" ';
					if ($i==$tab_noisettes['pos_x']) {$texte_eva.= 'selected';}
					$texte_eva.= '>'.$i.'</option>';
				}
				$texte_eva.= '</select></th>';
				$texte_eva.= '</tr>';
			}
		}
		$texte_eva.= '</table>';
		$texte_eva.= fin_cadre_trait_couleur(true);
		if  ($test_affichage_eva) { echo $texte_eva;}
		echo '</th></tr></table>';
		echo '<div style="text-align:center;"><input type="submit" value="'._T('evahabillage:EVA_valider').'"></div><br />';
		echo '</form>';
		echo fin_block();
	}
	echo '<hr />';
	echo bouton_block_depliable(_T('evahabillage:EVA_choisir_squelette'),false,'');
	echo debut_block_depliable(false);
	echo '<br />'._T('evahabillage:EVA_choisir_squelette1').'<br />&nbsp;<br />';
	echo _T('evahabillage:EVA_choisir_squelette2').'<br />&nbsp;<br />';
	echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';
	echo '<table class="spip"><tr class="row_odd"><th>Nom du squelette</th><th>A ins&eacute;rer dans</th><th>Dans la colonne</th><th>Ordre</th></tr>';
	echo '<tr class="row_even"><th><input type="text" name="eva_mon_bloc_perso_nom" size="30" /></th>';
	echo '<th><select name="eva_mon_bloc_perso_skel">';
	foreach (EVA_les_blocs() as $bloc=>$inutile) {
		echo '<option value="'.$bloc.'">'.$bloc.'</option>';
	}
	echo '</select></th>';
	echo '<th><select name="eva_mon_bloc_perso_nom_image">';
	echo '<option value="gauche">gauche</option><option value="centre">centre</option><option value="droite">droite</option>';
	echo '</select></th>';
	echo '<th><select name="eva_mon_bloc_perso_pos_x">';
	for ($i=1;$i<=9;$i++) {
		echo '<option value="'.$i.'" >'.$i.'</option>';
	}
	echo '</th>';
	echo '</tr>';
	echo '</table>';
	echo '<div style="text-align:center;"><input type="submit" value="'._T('evahabillage:EVA_valider').'"></div><br /></form>';
	echo fin_block();

	$test_suppr=false;
	$texte_suppr=bouton_block_depliable(_T('evahabillage:EVA_supprimer_squelette'),false,'');
	$texte_suppr.= debut_block_depliable(false);
	$texte_suppr.= '<form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';
	$texte_suppr.= "<div style='text-align:center;'><select name='EVA_suppr_skel_perso'>";
	$supp_skel_perso=sql_select('*','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND repetition='perso'");
	while ($tab_supp_skel_perso=sql_fetch($supp_skel_perso)) {
		$test_suppr=true;
		$texte_suppr.= '<option value="'.$tab_supp_skel_perso['id'].'">'.$tab_supp_skel_perso['nom_div'].'.html ('.$tab_supp_skel_perso['attach'].')</option>';
	}
	$texte_suppr.= "</select></div>";
	$texte_suppr.= '<div style="text-align:center;"><input type="submit" value="'._T('evahabillage:EVA_suppression').'"></div><br /></form>';
	$texte_suppr.= fin_block();
	if ($test_suppr) {echo $texte_suppr;}

	echo fin_cadre_trait_couleur(true).'<br />';


	echo debut_cadre_trait_couleur(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/blocs.png", true, '', _T('evahabillage:EVA_choix_entete_pied'));

	echo bouton_block_depliable(_T('evahabillage:EVA_choix_entete'),false,'');
	echo debut_block_depliable(false);
	echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';
	$test_entete=false;
	$req_entete1=sql_select('*','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND nom_image='oui' AND attach='entete'",'','pos_x ASC');
	$texte_entete=debut_cadre_trait_couleur('', true, '', '<div style="text-align:center;">&Eacute;l&eacute;ments actuellement affich&eacute;s</div>');
	while ($tab_entete1=sql_fetch($req_entete1)) {
		$test_entete=true;
		$texte_entete.="<table class='spip'><tr class='row_even'><th><div style='text-align:center;'>";
		if ($tab_entete1['repetition']=='perso') {$texte_entete.="Squelette ".$tab_entete1['nom_div'].".html";}
		else {$texte_entete.=_T('evahabillage:EVA_bloc_'.$tab_entete1['nom_div']);}
		$texte_entete.="<tr class='row_odd'><th><div style='text-align:center;'>Ordre : ";
		$texte_entete.='<input type="hidden" name="'.$tab_entete1['nom_div'].'_nom_bloc'.'" value="'.$tab_entete1['nom_div'].'">';
		$texte_entete.="<select name='".$tab_entete1['nom_div']."_pos_x'>";
		for ($i=1;$i<=9;$i++) {
			$texte_entete.= '<option value="'.$i.'" ';
			if ($i==$tab_entete1['pos_x']) {$texte_entete.= 'selected';}
			$texte_entete.= '>'.$i.'</option>';
		}
		$texte_entete.= '</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Statut : ';
		$texte_entete.="<select name='".$tab_entete1['nom_div']."'>";
		$texte_entete.="<option value='non'>Non affich&eacute;</option>";
		$texte_entete.="<option value='oui' selected>Affich&eacute;</option>";
		$texte_entete.="</select></div></th></tr>";
		$texte_entete.='</table>';
	}
	$texte_entete.=fin_cadre_trait_couleur(true);
	if ($test_entete) {echo $texte_entete;}

	$test_entete=false;
	$req_entete1=sql_select('*','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND nom_image='non' AND attach='entete'",'','pos_x ASC');
	$texte_entete=debut_cadre_trait_couleur('', true, '', '<div style="text-align:center;">&Eacute;l&eacute;ments actuellement non affich&eacute;s</div>');
	while ($tab_entete1=sql_fetch($req_entete1)) {
		$test_entete=true;
		$texte_entete.="<table class='spip'><tr class='row_even'><th><div style='text-align:center;'>";
		if ($tab_entete1['repetition']=='perso') {$texte_entete.="Squelette ".$tab_entete1['nom_div'].".html";}
		else {$texte_entete.=_T('evahabillage:EVA_bloc_'.$tab_entete1['nom_div']);}
		$texte_entete.="</div></th></tr>";
		$texte_entete.="<tr class='row_odd'><th><div style='text-align:center;'>Ordre : ";
		$texte_entete.='<input type="hidden" name="'.$tab_entete1['nom_div'].'_nom_bloc'.'" value="'.$tab_entete1['nom_div'].'">';
		$texte_entete.="<select name='".$tab_entete1['nom_div']."_pos_x'>";
		for ($i=1;$i<=9;$i++) {
			$texte_entete.= '<option value="'.$i.'" ';
			if ($i==$tab_entete1['pos_x']) {$texte_entete.= 'selected';}
			$texte_entete.= '>'.$i.'</option>';
		}
		$texte_entete.= '</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Statut : ';
		$texte_entete.="<select name='".$tab_entete1['nom_div']."'>";
		$texte_entete.="<option value='non' selected>Non affich&eacute;</option>";
		$texte_entete.="<option value='oui'>Affich&eacute;</option>";
		$texte_entete.="</select></div></th></tr>";
		$texte_entete.='</table>';
	}
	$texte_entete.=fin_cadre_trait_couleur(true);
	if ($test_entete) {echo $texte_entete;}
	echo '<div style="text-align:center;"><input type="submit" value="'._T('evahabillage:EVA_valider').'"></div>';
	echo '</form>';
	echo fin_block();

	echo bouton_block_depliable(_T('evahabillage:EVA_choix_pied'),false,'');
	echo debut_block_depliable(false);
		echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';
	$test_entete=false;
	$req_entete1=sql_select('*','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND nom_image='oui' AND attach='pied'",'','pos_x ASC');
	$texte_entete=debut_cadre_trait_couleur('', true, '', '<div style="text-align:center;">&Eacute;l&eacute;ments actuellement affich&eacute;s</div>');
	while ($tab_entete1=sql_fetch($req_entete1)) {
		$test_entete=true;
		$texte_entete.="<table class='spip'><tr class='row_even'><th><div style='text-align:center;'>";
		if ($tab_entete1['repetition']=='perso') {$texte_entete.="Squelette ".$tab_entete1['nom_div'].".html";}
		else {$texte_entete.=_T('evahabillage:EVA_bloc_'.$tab_entete1['nom_div']);}
		$texte_entete.="</div></th></tr>";
		$texte_entete.="<tr class='row_odd'><th><div style='text-align:center;'>Ordre : ";
		$texte_entete.='<input type="hidden" name="'.$tab_entete1['nom_div'].'_nom_bloc'.'" value="'.$tab_entete1['nom_div'].'">';
		$texte_entete.="<select name='".$tab_entete1['nom_div']."_pos_x'>";
		for ($i=1;$i<=9;$i++) {
			$texte_entete.= '<option value="'.$i.'" ';
			if ($i==$tab_entete1['pos_x']) {$texte_entete.= 'selected';}
			$texte_entete.= '>'.$i.'</option>';
		}
		$texte_entete.= '</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Statut : ';
		$texte_entete.="<select name='".$tab_entete1['nom_div']."'>";
		$texte_entete.="<option value='non'>Non affich&eacute;</option>";
		$texte_entete.="<option value='oui' selected>Affich&eacute;</option>";
		$texte_entete.="</select></div></th></tr>";
		$texte_entete.='</table>';
	}
	$texte_entete.=fin_cadre_trait_couleur(true);
	if ($test_entete) {echo $texte_entete;}

	$test_entete=false;
	$req_entete1=sql_select('*','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND nom_image='non' AND attach='pied'",'','pos_x ASC');
	$texte_entete=debut_cadre_trait_couleur('', true, '', '<div style="text-align:center;">&Eacute;l&eacute;ments actuellement non affich&eacute;s</div>');
	while ($tab_entete1=sql_fetch($req_entete1)) {
		$test_entete=true;
		$texte_entete.="<table class='spip'><tr class='row_even'><th><div style='text-align:center;'>";
		if ($tab_entete1['repetition']=='perso') {$texte_entete.="Squelette ".$tab_entete1['nom_div'].".html";}
		else {$texte_entete.=_T('evahabillage:EVA_bloc_'.$tab_entete1['nom_div']);}
		$texte_entete.="</div></th></tr>";
		$texte_entete.="<tr class='row_odd'><th><div style='text-align:center;'>Ordre : ";
		$texte_entete.='<input type="hidden" name="'.$tab_entete1['nom_div'].'_nom_bloc'.'" value="'.$tab_entete1['nom_div'].'">';
		$texte_entete.="<select name='".$tab_entete1['nom_div']."_pos_x'>";
		for ($i=1;$i<=9;$i++) {
			$texte_entete.= '<option value="'.$i.'" ';
			if ($i==$tab_entete1['pos_x']) {$texte_entete.= 'selected';}
			$texte_entete.= '>'.$i.'</option>';
		}
		$texte_entete.= '</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Statut : ';
		$texte_entete.="<select name='".$tab_entete1['nom_div']."'>";
		$texte_entete.="<option value='non' selected>Non affich&eacute;</option>";
		$texte_entete.="<option value='oui'>Affich&eacute;</option>";
		$texte_entete.="</select></div></th></tr>";
		$texte_entete.='</table>';
	}
	$texte_entete.=fin_cadre_trait_couleur(true);
	if ($test_entete) {echo $texte_entete;}
	echo '<div style="text-align:center;"><input type="submit" value="'._T('evahabillage:EVA_valider').'"></div>';
	echo '</form>';
	echo fin_block();

	echo bouton_block_depliable(_T('evahabillage:EVA_choix_headers'),false,'');
	echo debut_block_depliable(false);
	echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';
	$test_entete=false;
	$req_entete1=sql_select('*','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND nom_image='oui' AND attach='headers'",'','pos_x ASC');
	$texte_entete=debut_cadre_trait_couleur('', true, '', '<div style="text-align:center;">&Eacute;l&eacute;ments actuellement affich&eacute;s</div>');
	while ($tab_entete1=sql_fetch($req_entete1)) {
		$test_entete=true;
		$texte_entete.="<table class='spip'><tr class='row_even'><th><div style='text-align:center;'>";
		if ($tab_entete1['repetition']=='perso') {$texte_entete.="Squelette ".$tab_entete1['nom_div'].".html";}
		else {$texte_entete.=_T('evahabillage:EVA_bloc_'.$tab_entete1['nom_div']);}
		$texte_entete.="</div></th></tr>";
		$texte_entete.="<tr class='row_odd'><th><div style='text-align:center;'>Ordre : ";
		$texte_entete.='<input type="hidden" name="'.$tab_entete1['nom_div'].'_nom_bloc'.'" value="'.$tab_entete1['nom_div'].'">';
		$texte_entete.="<select name='".$tab_entete1['nom_div']."_pos_x'>";
		for ($i=1;$i<=9;$i++) {
			$texte_entete.= '<option value="'.$i.'" ';
			if ($i==$tab_entete1['pos_x']) {$texte_entete.= 'selected';}
			$texte_entete.= '>'.$i.'</option>';
		}
		$texte_entete.= '</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Statut : ';
		$texte_entete.="<select name='".$tab_entete1['nom_div']."'>";
		$texte_entete.="<option value='non'>Non affich&eacute;</option>";
		$texte_entete.="<option value='oui' selected>Affich&eacute;</option>";
		$texte_entete.="</select></div></th></tr>";
		$texte_entete.='</table>';
	}
	$texte_entete.=fin_cadre_trait_couleur(true);
	if ($test_entete) {echo $texte_entete;}

	$test_entete=false;
	$req_entete1=sql_select('*','spip_eva_habillage_images',"type='bloc' AND nom_habillage='Defaut' AND nom_image='non' AND attach='headers'",'','pos_x ASC');
	$texte_entete=debut_cadre_trait_couleur('', true, '', '<div style="text-align:center;">&Eacute;l&eacute;ments actuellement non affich&eacute;s</div>');
	while ($tab_entete1=sql_fetch($req_entete1)) {
		$test_entete=true;
		$texte_entete.="<table class='spip'><tr class='row_even'><th><div style='text-align:center;'>";
		if ($tab_entete1['repetition']=='perso') {$texte_entete.="Squelette ".$tab_entete1['nom_div'].".html";}
		else {$texte_entete.=_T('evahabillage:EVA_bloc_'.$tab_entete1['nom_div']);}
		$texte_entete.="</div></th></tr>";
		$texte_entete.="<tr class='row_odd'><th><div style='text-align:center;'>Ordre : ";
		$texte_entete.='<input type="hidden" name="'.$tab_entete1['nom_div'].'_nom_bloc'.'" value="'.$tab_entete1['nom_div'].'">';
		$texte_entete.="<select name='".$tab_entete1['nom_div']."_pos_x'>";
		for ($i=1;$i<=9;$i++) {
			$texte_entete.= '<option value="'.$i.'" ';
			if ($i==$tab_entete1['pos_x']) {$texte_entete.= 'selected';}
			$texte_entete.= '>'.$i.'</option>';
		}
		$texte_entete.= '</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Statut : ';
		$texte_entete.="<select name='".$tab_entete1['nom_div']."'>";
		$texte_entete.="<option value='non' selected>Non affich&eacute;</option>";
		$texte_entete.="<option value='oui'>Affich&eacute;</option>";
		$texte_entete.="</select></div></th></tr>";
		$texte_entete.='</table>';
	}
	$texte_entete.=fin_cadre_trait_couleur(true);
	if ($test_entete) {echo $texte_entete;}
	echo '<div style="text-align:center;"><input type="submit" value="'._T('evahabillage:EVA_valider').'"></div>';
	echo '</form>';
	echo fin_block();

	echo '<hr />';
	echo bouton_block_depliable(_T('evahabillage:EVA_inserer_squel_entete_pied'),false,'');
	echo debut_block_depliable(false);

	echo '<br />'._T('evahabillage:EVA_choisir_squelette1bis').'<br />&nbsp;<br />';
	echo _T('evahabillage:EVA_choisir_squelette2').'<br />&nbsp;<br />';
	echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';
	echo '<table class="spip"><tr class="row_odd"><th>Nom du squelette</th><th>A ins&eacute;rer dans</th><th>Ordre</th></tr>';
	echo '<tr class="row_even"><th><input type="text" name="eva_mon_bloc_perso_nom" size="40" /></th>';
	echo '<input type="hidden" name="eva_mon_bloc_perso_nom_image" value="oui">';
	echo '<th><select name="eva_mon_bloc_perso_skel">';
	echo '<option value="entete">Ent&ecirc;te</option>';
	echo '<option value="pied">Pied de page</option>';
	echo '<option value="headers">Headers</option>';
	echo '</select></th>';
	echo '<th><select name="eva_mon_bloc_perso_pos_x">';
	for ($i=1;$i<=9;$i++) {
		echo '<option value="'.$i.'" >'.$i.'</option>';
	}
	echo '</th>';
	echo '</tr>';
	echo '</table>';
	echo '<div style="text-align:center;"><input type="submit" value="'._T('evahabillage:EVA_valider').'"></div><br /></form>';


	echo fin_block();
    echo fin_cadre_trait_couleur(true).'<br />';

	include_spip('inc/evabonus_menu_horizontal_structure');

	echo debut_cadre_trait_couleur(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/nbre.png", true, '', _T('evahabillage:EVA_choix_nbre'));

	$nbre = EVA_mes_nbres();
	foreach($nbre as $cle_nbre => $val_nbre) {
		foreach($val_nbre as $val) {
			if (isset($_POST[$val])) {
				sql_delete('spip_eva_habillage_images',"nom_habillage='Defaut' AND nom_div='".$val."'");
				sql_insertq('spip_eva_habillage_images',array('type' => 'nbre','nom_habillage' => 'Defaut','nom_div' => $val,'nom_image' => $_POST[$val]));
			}
		}
		echo bouton_block_depliable(_T('evahabillage:'.$cle_nbre),false,'');
		echo debut_block_depliable(false);

		echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';
		foreach ($val_nbre as $val) {
			$test_pres=sql_select('nom_image','spip_eva_habillage_images',"nom_habillage='Defaut' AND nom_div='$val'");
			$test_tab=sql_fetch($test_pres);
			$test=$test_tab['nom_image'];
			echo '<br /><span style="text-decoration:underline;">'._T('evahabillage:'.$val).'</span>';
			echo '&nbsp;&nbsp;&nbsp;&nbsp;<select name="'.$val.'">';
			for ($i=0;$i<=20;$i++) {
				echo '<option value="'.$i.'" ';
				if ($i==$test) {echo 'selected';}
				elseif (($i==5) AND (!isset($test))) {echo 'selected';}
				echo '>'.$i.'</option>';
			}
			echo '</select><br />';
		}
		echo '<br /><div style="text-align:center;"><input type="submit" value="'._T('evahabillage:EVA_valider').'"></div></form>';
		echo fin_block();
	}
	echo fin_cadre_trait_couleur(true);

	global  $spip_lang;
	echo debut_cadre_trait_couleur(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/titrebloc.png", true, '', "<center><span style='text-decoration:underline;'>"._T('evahabillage:titrebloc_titre').traduire_nom_langue($spip_lang)."</span></center>");
	if (file_exists(_DIR_PLUGIN_EVASQUELETTES.'lang/local_'.$spip_lang.'.php')) {
		echo _T('evahabillage:titrebloc_debut');
		echo '<br />';

		echo bouton_block_depliable(_T('evahabillage:titrebloc_entites_html'),false,'');
		echo debut_block_depliable(false);
		echo _T('evahabillage:titrebloc_detail');
		echo fin_block();

		echo bouton_block_depliable(_T('evahabillage:titrebloc_go'),false,'');
		echo debut_block_depliable(false);

		include(_DIR_PLUGIN_EVASQUELETTES.'lang/local_'.$spip_lang.'.php');
			if ($_POST['evalangtest']) {
				foreach ($langue_fichier_initial as $cle => $val) {
					$val=mysql_escape_string($_POST[$cle]);
					sql_delete('spip_eva_habillage_images',"type = 'fichier_lang' AND attach='".$spip_lang."' AND nom_habillage = 'Defaut' AND nom_div = '".$cle."'");
					if ($val!='') {
						sql_insertq('spip_eva_habillage_images',array('type' => 'fichier_lang','nom_habillage' => 'Defaut','nom_div' => $cle,'nom_image' => $val,'attach' => $spip_lang));
					}

				}
			}
			$couleur_table = 0;
			echo '<br /><form method="POST" action="'.generer_url_ecrire("eva_habillage").'"><table align="center" class="spip">';
			echo '<tr align="center" class="row_even"><td align="center">'._T('evahabillage:titrebloc_tab1').'</td>';
			echo '<td align="center">'._T('evahabillage:titrebloc_tab2').'</td></tr>';
			$couleur_table++;
			foreach ($langue_fichier_initial as $cle => $val) {
				$test_langue=sql_select('nom_image','spip_eva_habillage_images',"type = 'fichier_lang' AND nom_habillage = 'Defaut' AND attach='".$spip_lang."' AND nom_div = '$cle'");
				$result_langue=sql_fetch($test_langue);
				$resultat=$result_langue['nom_image'];
				echo '<tr align="center" ';
				if (($couleur_table%2)==0) {echo 'class="row_even"';} else {echo 'class="row_odd"';}
				$couleur_table++;
				echo '><td align="center">'.$val.'</td>';
				echo '<td align="center"><input type="text" name="'.$cle.'" value="'.htmlentities($resultat).'" size="25" /></td>';
				echo '</tr>';
			}
			echo '</table><br />';
			echo '<input type="hidden" name="evalangtest" value="2" />';
			echo '<div style="text-align:center;"><input type="submit" value="'._T('evahabillage:EVA_valider').'"></div></form>';
			echo fin_block();
		}
		else {
			echo _T('evahabillage:eva_langue_absente1').traduire_nom_langue($spip_lang)._T('evahabillage:eva_langue_absente2');
		}
		echo fin_cadre_trait_couleur(true);

		echo fin_gauche(), fin_page();
}
?>