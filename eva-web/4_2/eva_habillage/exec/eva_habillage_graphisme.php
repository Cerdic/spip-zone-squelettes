<?php

if (!defined("_ECRIRE_INC_VERSION")) return;
	include_spip('inc/presentation');

function exec_eva_habillage_graphisme() {

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
	echo eva_habillage_boutons('graphisme');

	include_spip("inc/eva_habillage_definition_themes");
	$def_themes = EVA_def_themes_global();

	if ($_POST['modif_habillage']=='1') {
		foreach ($def_themes as $habillage_modif_cles => $habillage_modif_inutile) {
			$mes_modifs_tableau[$habillage_modif_cles] =$_POST[$habillage_modif_cles];
		}
		sql_updateq('spip_eva_habillage_themes',$mes_modifs_tableau,"nom='Defaut'");
	}

	if ($_POST['modif_habillage']=='2') {
		foreach (EVA_def_textes() as $habillage_modif_cles => $habillage_modif_inutile) {
			$mes_modifs_tableau[$habillage_modif_cles] =$_POST[$habillage_modif_cles];
		}
		sql_updateq('spip_eva_habillage_themes',$mes_modifs_tableau,"nom='Defaut'");
	}

	$test_fri=sql_select('id_habillage','spip_eva_habillage',"sauvegarde='Defaut'");
	$tab_fri=sql_fetch($test_fri);
	if (!isset($tab_fri['id_habillage'])) {sql_insertq('spip_eva_habillage',array('habillage' => '0','sauvegarde' =>'Defaut'));}

	$resultat1 = sql_select('habillage','spip_eva_habillage',"sauvegarde = 'Defaut'");
	$resultat1_tableau = sql_fetch($resultat1);
	$mon_habillage = $resultat1_tableau['habillage'];


//Ajustement de la police

	echo debut_cadre_trait_couleur(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/text.png", true, '', _T('evahabillage:EVA_def_police'));
	$resultat_themes_defini = sql_select('*','spip_eva_habillage_themes',"nom='Defaut'");
	$tableau_themes_defini = sql_fetch($resultat_themes_defini);
	echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage_graphisme").'">';
	echo '<div style="text-align:center;">';
		foreach(EVA_def_textes() as $habillage_cles => $habillage_inutile) {
			echo _T('evahabillage:'.$habillage_cles);
			echo '<input type="text" name="'.$habillage_cles.'" value="'.htmlentities($tableau_themes_defini[$habillage_cles]).'" size="50">';
		}
	echo '<input type="submit" value="'._T('evahabillage:EVA_valider').'"></div><input type="hidden" name="modif_habillage" value="2"></form>';

	echo fin_cadre_trait_couleur(true);


//Module 2 - Ajustements prédéfinis des paramètres d'habillage
	echo debut_cadre_trait_couleur(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/pinceau.png", true, '', _T('evahabillage:EVA_etape2'));
	echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage_graphisme").'">';
	echo '<div style="text-align:center;">'._T('evahabillage:EVA_etape2_detail').'</div>';
	$couleur_table = 0;
	$themes_principaux = EVA_def_themes();
	foreach ($themes_principaux as $mon_theme) {
		echo bouton_block_depliable(_T('evahabillage:'.$mon_theme),false,'');
		echo debut_block_depliable(false);
		echo '<br /><table align="center" class="spip">';
		foreach($def_themes as $habillage_cles => $habillage_inutile) {
			if (strpos($habillage_cles,$mon_theme)!==FALSE) {
				echo '<tr align="center" ';
				if (($couleur_table%2)==0) {echo 'class="row_even"';} else {echo 'class="row_odd"';}
				$couleur_table++;
				echo '><td align="center">';
				if ((strpos($mon_habillage,'droite')!=FALSE) AND ($habillage_cles=='taille_largeur_menu')) {echo _T('evahabillage:taille_largeur_menudroite');}
				elseif ((strpos($mon_habillage,'droite')!=FALSE) AND ($habillage_cles=='taille_largeur_menudroite')) {echo _T('evahabillage:taille_largeur_menu');}
				else {echo _T('evahabillage:'.$habillage_cles);}
				echo '</td><td align="center">'.'<input ';
				if ((strpos($habillage_cles,'bordure_style')===FALSE)
					AND (strpos($habillage_cles,'bordure_largeur')===FALSE)
					AND (strpos($habillage_cles,'taille_')===FALSE)
					AND (strpos($habillage_cles,'admin_deplacement')===FALSE)
				){echo 'class="palette" ';}
				echo 'type="text" name="'.$habillage_cles.'" value="'.$tableau_themes_defini[$habillage_cles].'" size="25"></td></tr>';
			}
		}
		echo '</table><div style="text-align:center;"><input type="submit" value="'._T('evahabillage:EVA_valider').'"></div>';
		echo fin_block();
	}
	echo'<input type="hidden" name="modif_habillage" value="1"></form>';

	echo fin_cadre_trait_couleur(true);

	include_spip('inc/evabonus_menu_horizontal');

	include_spip('inc/eva_menu_langue_graphisme');

//Module 3 - Ajout d'imges de fond dans les secteurs
	echo debut_cadre_trait_couleur(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/img_bloc.png", true, '', _T('evahabillage:EVA_etape3'));
	if(!empty($_FILES['image_eva_habillage_envoi']['tmp_name']) AND is_uploaded_file($_FILES['image_eva_habillage_envoi']['tmp_name']) AND filesize($_FILES['image_eva_habillage_envoi']['tmp_name'])<2000000){
		list($largeur, $hauteur, $type, $attr)=getimagesize($_FILES['image_eva_habillage_envoi']['tmp_name']);
		if (($type===1) OR ($type===2) OR ($type===3)){
			if(!move_uploaded_file($_FILES['image_eva_habillage_envoi']['tmp_name'], _DIR_IMG.'eva_habillage/'.$_FILES['image_eva_habillage_envoi']['name']))
			{echo 'Erreur lors de la copie du fichier';}
		}
    }

	if (isset($_POST['supprime_image']))  {
		sql_delete('spip_eva_habillage_images',"id=".$_POST['supprime_image']);
	}
	if (isset($_POST['secteur_image'])) {
		$recup_image_exists = sql_select('id','spip_eva_habillage_images',"nom_div = '".$_POST['secteur_image']."' AND nom_habillage = 'Defaut'");
		$tab_recup_image_exists = sql_fetch($recup_image_exists);
		$repeat = $_POST['repeat_x']+$_POST['repeat_y'];
		if ($repeat==0) {$rep='no-repeat';}
		elseif ($repeat==1) {$rep='repeat-x';}
		elseif ($repeat==2) {$rep='repeat-y';}
		elseif ($repeat==3) {$rep='repeat';}
		if ($_POST['pos_x']==4) {$Xpos=$_POST['position_x'];} else {$Xpos=$_POST['pos_x'];}
		if ($_POST['pos_y']==4) {$Ypos=$_POST['position_y'];} else {$Ypos=$_POST['pos_y'];}
		if (isset($tab_recup_image_exists['id'])) {            
			sql_updateq('spip_eva_habillage_images',array('nom_image' => $_POST['nom_image'], 'pos_x' => $Xpos, 'pos_y' => $Ypos , 'repetition' => $rep , 'attach' => $_POST['attach']),"id =".$tab_recup_image_exists['id']);
		}
		else {
			sql_insertq('spip_eva_habillage_images',array('type' =>'image','nom_habillage' => 'Defaut','nom_div' => $_POST['secteur_image'],'nom_image' =>$_POST['nom_image'],'pos_x' => $Xpos,'pos_y' => $Ypos,'repetition' => $rep,'attach' =>$_POST['attach']));
		}
	}

	echo bouton_block_depliable(_T('evahabillage:EVA_etape3_image_fond'),false,'');
	echo debut_block_depliable(false);
	echo '<br /><form method="POST" action="'.generer_url_ecrire("eva_habillage_graphisme").'">';
	echo _T('evahabillage:EVA_etape3_pour_secteur').'<br />';
	echo '<div style="text-align:center;"><select name="secteur_image">';
	$def_div = EVA_div_images();
	foreach ($def_div as $cle => $val) {
		if (strpos($cle,'image_')!==FALSE) {echo '<option value="'.$cle.'">'._T('evahabillage:'.$cle).'</option>';}
	}
	echo '</select></div><br />&nbsp;<br />';
	echo _T('evahabillage:EVA_etape3_pos_x');
	echo '<div style="text-align:center;">'._T('evahabillage:EVA_gauche');
	echo '<input type="radio" name="pos_x" value="left" checked />&nbsp;&nbsp;';
	echo _T('evahabillage:EVA_centre');
	echo '<input type="radio" name="pos_x" value="center" />&nbsp;&nbsp;';
	echo _T('evahabillage:EVA_droite');
	echo '<input type="radio" name="pos_x" value="right" /></div>';
	echo '<input type="radio" name="pos_x" value=4 />'._T('evahabillage:EVA_etape3_pos_choix');
	echo '<br /><div style="text-align:center;"><input type="text" name="position_x" /></div>';
	echo '<div style="text-align:center;">'._T('evahabillage:EVA_etape3_repeat_x')._T('evahabillage:EVA_non');
	echo '<input type="radio" name="repeat_x" value=0 checked />';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'._T('evahabillage:EVA_oui');
	echo '<input type="radio" name="repeat_x" value=1 /></div><br />&nbsp;<br />';

	echo _T('evahabillage:EVA_etape3_pos_y');
	echo '<div style="text-align:center;">'._T('evahabillage:EVA_haut');
	echo '<input type="radio" name="pos_y" value="top" checked />&nbsp;&nbsp;';
	echo _T('evahabillage:EVA_centre');
	echo '<input type="radio" name="pos_y" value="center" />&nbsp;&nbsp;';
	echo _T('evahabillage:EVA_bas');
	echo '<input type="radio" name="pos_y" value="bottom" /></div>';
	echo '<input type="radio" name="pos_y" value=4 />'._T('evahabillage:EVA_etape3_pos_choix');
	echo '<br /><div style="text-align:center;"><input type="text" name="position_y" /></div>';
	echo '<div style="text-align:center;">'._T('evahabillage:EVA_etape3_repeat_y')._T('evahabillage:EVA_non');
	echo '<input type="radio" name="repeat_y" value=0 checked />';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'._T('evahabillage:EVA_oui');
	echo '<input type="radio" name="repeat_y" value=2 /></div><br />&nbsp;<br />';

	echo '<div style="text-align:center;">'._T('evahabillage:EVA_etape3_attach');
	echo _T('evahabillage:EVA_normal');
	echo '<input type="radio" name="attach" value="scroll" checked/>&nbsp;&nbsp;&nbsp;&nbsp;';    
	echo _T('evahabillage:EVA_fixe');
	echo '<input type="radio" name="attach" value="fixed" /></div><br />&nbsp;<br />';

	echo '<div style="text-align:center;">'._T('evahabillage:EVA_etape3_choix_image').'<strong>'._DIR_PLUGIN_EVA_HABILLAGE."mon_image</strong> ou, notamment dans le cas d'un site mutualis&eacute;,
	dans le r&eacute;pertoire <strong>"._DIR_IMG."eva_habillage</strong>, ou utilisez le formulaire de chargement ci-dessous pour &eacute;viter le chargement par FTP<br />";
	echo '<select name="nom_image">';
	$dir = opendir(_DIR_PLUGIN_EVA_HABILLAGE."mon_image");
	while ($nom_fichier = readdir($dir)) {
		if (($nom_fichier!='.') AND ($nom_fichier!='..') AND ((strpos($nom_fichier,'.gif')) OR (strpos($nom_fichier,'.jpg')) OR (strpos($nom_fichier,'.png')) OR (strpos($nom_fichier,'.GIF')) OR (strpos($nom_fichier,'.JPG')) OR (strpos($nom_fichier,'.PNG')))) {
			echo '<option value="'.$nom_fichier.'">'.$nom_fichier.'</option>';
		}
	}
	closedir($dir);
	$dir = opendir(_DIR_IMG."eva_habillage");
	while ($nom_fichier = readdir($dir)) {
		if (($nom_fichier!='.') AND ($nom_fichier!='..') AND ((strpos($nom_fichier,'.gif')) OR (strpos($nom_fichier,'.jpg')) OR (strpos($nom_fichier,'.png')) OR (strpos($nom_fichier,'.GIF')) OR (strpos($nom_fichier,'.JPG')) OR (strpos($nom_fichier,'.PNG')))) {
			echo '<option value="'.$nom_fichier.'">'.$nom_fichier.'</option>';
		}
	}
	closedir($dir);
	echo '</select><br />&nbsp;<br /><input type="submit" value="'._T('evahabillage:EVA_valider').'"></div></form>';
	echo fin_block();

	echo bouton_block_depliable("Chargement d'images",false,'');
	echo debut_block_depliable(false);
	echo "<center>L'image sera t&eacute;l&eacute;charg&eacute;e dans le r&eacute;pertoire <strong>"._DIR_IMG."eva_habillage</strong><br />";
	echo "<span style='text-decoration:underline;'><strong>Attention :</strong></span> si une image portant le m&ecirc;me nom est d&eacute;j&agrave; pr&eacute;sente dans ce r&eacute;pertoire, elle sera alors &eacute;cras&eacute;e.";
	echo '<br />&nbsp;<br /><form action="'.generer_url_ecrire("eva_habillage_graphisme").'" method="post" enctype="multipart/form-data">';
	echo '<input type="file" name="image_eva_habillage_envoi" /><br />&nbsp;<br /><input type="submit" value="Envoyer" /></form></center>';
	echo fin_block();

	echo bouton_block_depliable(_T('evahabillage:EVA_etape3_liste_images_definies'),false,'');
	echo debut_block_depliable(false);
	$recup_exist_image = sql_select('id , nom_div , nom_image','spip_eva_habillage_images',"type = 'image' AND nom_habillage = 'Defaut'");
	$test_exist_image = sql_select('id','spip_eva_habillage_images',"type = 'image' AND nom_habillage = 'Defaut' LIMIT 1");
	$tab_test_exist_image = sql_fetch($test_exist_image);
	if ($tab_test_exist_image!='') {
		echo '<br /><table align="center" class="spip">';
		echo '<tr align="center" ';
		if (($couleur_table%2)==0) {echo 'class="row_even"';} else {echo 'class="row_odd"';}
		$couleur_table++;
		echo '>';
		echo '<td align="center"><div style="text-decoration:underline;">Secteur</div></td><td align="center"><div style="text-decoration:underline;">Image</div></td><td align="center"><div style="text-decoration:underline;">Supprimer ?</div></td></tr>';
		while ($tab_exist_image = sql_fetch($recup_exist_image)) {
			echo '<tr align="center" ';
			if (($couleur_table%2)==0) {echo 'class="row_even"';} else {echo 'class="row_odd"';}
			$couleur_table++;
			echo '><form method="POST" action="'.generer_url_ecrire("eva_habillage_graphisme").'"><td align="center">'._T('evahabillage:'.$tab_exist_image['nom_div']).'&nbsp;&nbsp;</td><td align="center"><strong>'.$tab_exist_image['nom_image'].'</strong></td><td align="center">';
			echo '<input type="hidden" name="supprime_image" value="'.$tab_exist_image['id'].'" />';
			echo '<input type="submit" value="'._T('evahabillage:EVA_supprimer').'" /></td></form></tr>';
		}
		echo '</table>';
	}
	else {
		echo '&nbsp;<br />'._T('evahabillage:EVA_aucune_image_fond');
	}


	//Choix de la puce
	if (isset($_POST['supprime_puce'])) {
		sql_delete('spip_eva_habillage_images',"type='puce_spip' AND nom_habillage='Defaut'");
	}
	if (isset($_POST['nom_puce'])) {
		sql_delete('spip_eva_habillage_images',"type='puce_spip' AND nom_habillage='Defaut'");
		sql_insertq('spip_eva_habillage_images',array('type'=>'puce_spip','nom_habillage'=>'Defaut','nom_image'=>$_POST['nom_puce']));
	}
	$test_puce=sql_select('nom_image','spip_eva_habillage_images',"type='puce_spip' AND nom_habillage='Defaut'");
	$tab_puce=sql_fetch($test_puce);
	$puce=$tab_puce['nom_image'];
	echo fin_block().'<br />';
	echo '<hr /><br />';
	echo bouton_block_depliable(_T('evahabillage:EVA_etape3_liste_puce'),false,'');
	echo debut_block_depliable(false);
	echo "<p>"._T('evahabillage:EVA_etape3_liste_puce_explication')."</p>";
	echo '<div style="text-align:center;"><form method="POST" action="'.generer_url_ecrire("eva_habillage_graphisme").'">';
	echo '<select name="nom_puce">';
	$dir = opendir(_DIR_PLUGIN_EVA_HABILLAGE."mon_image");
		while ($nom_fichier = readdir($dir)) {
			if (($nom_fichier!='.') AND ($nom_fichier!='..') AND ((strpos($nom_fichier,'.gif')) OR (strpos($nom_fichier,'.jpg')) OR (strpos($nom_fichier,'.png')) OR (strpos($nom_fichier,'.GIF')) OR (strpos($nom_fichier,'.JPG')) OR (strpos($nom_fichier,'.PNG')))) {
				echo '<option value="'.$nom_fichier.'">'.$nom_fichier.'</option>';
			}
		}
		closedir($dir);
		$dir = opendir(_DIR_IMG."eva_habillage");
		while ($nom_fichier = readdir($dir)) {
			if (($nom_fichier!='.') AND ($nom_fichier!='..') AND ((strpos($nom_fichier,'.gif')) OR (strpos($nom_fichier,'.jpg')) OR (strpos($nom_fichier,'.png')) OR (strpos($nom_fichier,'.GIF')) OR (strpos($nom_fichier,'.JPG')) OR (strpos($nom_fichier,'.PNG')))) {
				echo '<option value="'.$nom_fichier.'">'.$nom_fichier.'</option>';
			}
		}
		closedir($dir);
		echo '</select><br />&nbsp;<br /><input type="submit" value="'._T('evahabillage:EVA_valider').'"></form></div>';
		echo fin_block();
		if ($puce) {
			echo bouton_block_depliable(_T('evahabillage:EVA_etape3_definition_puce'),false,'');
			echo debut_block_depliable(false);
			echo "<div style='text-align:center;'>La puce actuelle est <img src='"._DIR_IMG."eva_habillage/".$puce."' />";
			echo "<br />La supprimer et revenir aux puces g&eacute;n&eacute;r&eacute;es par SPIP ?<br />";
			echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage_graphisme").'">';
			echo '<input type="hidden" name="supprime_puce" value="2" />';
			echo '<input type="submit" value="'._T('evahabillage:EVA_supprimer').'" /></td></form></tr>';
			echo "</form></div>";
			echo fin_block();
		}
		echo '<br />';
		echo fin_cadre_trait_couleur(true);

		//Aide graphiques (codes couleur et ColorSchemes)
		echo debut_cadre_trait_couleur(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/palette.png", true, '', _T('evahabillage:EVA_aide_graphisme'));
		include_spip("inc/eva_habillage_choix_couleur");
		eva_habillage_choix_couleur();
		echo '<hr /><p><a href="'._DIR_PLUGIN_EVA_HABILLAGE.'colorschemes2/index.html" target="_blank" title="Cliquez ici pour utiliser ColorSchemes2 !">'._T('evahabillage:colorschemes2').'</a></p><br />';
		echo fin_cadre_trait_couleur(true);

		//Taille des logos
		if ($_POST['test_logo']==2) {
			if (is_numeric($_POST['largeur_mini_logo'])) {$logo1l=$_POST['largeur_mini_logo'];} else {$logo1l='';}
			if (is_numeric($_POST['hauteur_mini_logo'])) {$logo1h=$_POST['hauteur_mini_logo'];} else {$logo1h='';}
			if (is_numeric($_POST['largeur_petit_logo'])) {$logo2l=$_POST['largeur_petit_logo'];} else {$logo2l='';};
			if (is_numeric($_POST['hauteur_petit_logo'])) {$logo2h=$_POST['hauteur_petit_logo'];} else {$logo2h='';}
			if (is_numeric($_POST['largeur_logo_moyen'])) {$logo3l=$_POST['largeur_logo_moyen'];} else {$logo3l='';}
			if (is_numeric($_POST['hauteur_logo_moyen'])) {$logo3h=$_POST['hauteur_logo_moyen'];} else {$logo3h='';}
			sql_delete('spip_eva_habillage_images',"type='logos' AND nom_habillage='Defaut'");
			sql_insertq('spip_eva_habillage_images',array('type'=>'logos','nom_habillage'=>'Defaut','nom_div'=>'largeur_mini_logo','nom_image'=>$logo1l));
			sql_insertq('spip_eva_habillage_images',array('type'=>'logos','nom_habillage'=>'Defaut','nom_div'=>'hauteur_mini_logo','nom_image'=>$logo1h));
			sql_insertq('spip_eva_habillage_images',array('type'=>'logos','nom_habillage'=>'Defaut','nom_div'=>'largeur_petit_logo','nom_image'=>$logo2l));
			sql_insertq('spip_eva_habillage_images',array('type'=>'logos','nom_habillage'=>'Defaut','nom_div'=>'hauteur_petit_logo','nom_image'=>$logo2h));
			sql_insertq('spip_eva_habillage_images',array('type'=>'logos','nom_habillage'=>'Defaut','nom_div'=>'largeur_logo_moyen','nom_image'=>$logo3l));
			sql_insertq('spip_eva_habillage_images',array('type'=>'logos','nom_habillage'=>'Defaut','nom_div'=>'hauteur_logo_moyen','nom_image'=>$logo3h));
		}
		$test_logo1l=sql_select('nom_image','spip_eva_habillage_images',"type='logos' AND nom_habillage='Defaut' AND nom_div='largeur_mini_logo'");
		$tab_logo1l=sql_fetch($test_logo1l);
		$logo1l=$tab_logo1l['nom_image'];
		$test_logo1h=sql_select('nom_image','spip_eva_habillage_images',"type='logos' AND nom_habillage='Defaut' AND nom_div='hauteur_mini_logo'");
		$tab_logo1h=sql_fetch($test_logo1h);
		$logo1h=$tab_logo1h['nom_image'];
		$test_logo2l=sql_select('nom_image','spip_eva_habillage_images',"type='logos' AND nom_habillage='Defaut' AND nom_div='largeur_petit_logo'");
		$tab_logo2l=sql_fetch($test_logo2l);
		$logo2l=$tab_logo2l['nom_image'];
		$test_logo2h=sql_select('nom_image','spip_eva_habillage_images',"type='logos' AND nom_habillage='Defaut' AND nom_div='hauteur_petit_logo'");
		$tab_logo2h=sql_fetch($test_logo2h);
		$logo2h=$tab_logo2h['nom_image'];
		$test_logo3l=sql_select('nom_image','spip_eva_habillage_images',"type='logos' AND nom_habillage='Defaut' AND nom_div='largeur_logo_moyen'");
		$tab_logo3l=sql_fetch($test_logo3l);
		$logo3l=$tab_logo3l['nom_image'];
		$test_logo3h=sql_select('nom_image','spip_eva_habillage_images',"type='logos' AND nom_habillage='Defaut' AND nom_div='hauteur_logo_moyen'");
		$tab_logo3h=sql_fetch($test_logo3h);
		$logo3h=$tab_logo3h['nom_image'];
		echo debut_cadre_trait_couleur(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/eva.gif", true, '', _T('evahabillage:logos_taille_def'));
		echo _T('evahabillage:logos_taille_detail');
		echo '<center><form method="POST" action="'.generer_url_ecrire("eva_habillage_graphisme").'">';
		echo '<br /><table align="center" class="spip">';
		echo '<tr align="center" class="row_even">';
		echo '<td  align="center">Type de logo</td><td  align="center">Largeur maximale</td><td  align="center">Hauteur maximale</td></tr>';
		echo '<tr align="center" class="row_odd">';
		echo '<td  align="center">Mini logos</td><td  align="center"><center><input type="text" name="largeur_mini_logo" value="'.$logo1l.'" size="10"></center></td><td  align="center"><center><input type="text" name="hauteur_mini_logo" value="'.$logo1h.'" size="10"></center></td></tr>';
		echo '<tr align="center" class="row_even">';
		echo '<td  align="center">Petits logos</td><td  align="center"><center><input type="text" name="largeur_petit_logo" value="'.$logo2l.'" size="10"></center></td><td  align="center"><center><input type="text" name="hauteur_petit_logo" value="'.$logo2h.'" size="10"></center></td></tr>';
		echo '<tr align="center" class="row_odd">';
		echo '<td  align="center">Logos moyens</td><td  align="center"><center><input type="text" name="largeur_logo_moyen" value="'.$logo3l.'" size="10"></center></td><td  align="center"><center><input type="text" name="hauteur_logo_moyen" value="'.$logo3h.'" size="10"></center></td></tr>'; 
		echo '</table><br /><input type="hidden" name="test_logo" value="2"><input type="submit" value="'._T('evahabillage:EVA_valider').'" /></form>';
		echo '<hr />';
		if ($_POST['test_image_article']==2) {
			sql_delete('spip_eva_habillage_images',"type='logos' AND nom_habillage='Defaut' AND nom_div='largeur_image_article'");
			if (is_numeric($_POST['largeur_image_article'])) {$image_article=$_POST['largeur_image_article'];} else {$image_article='';}
			sql_insertq('spip_eva_habillage_images',array('type'=>'logos','nom_habillage'=>'Defaut','nom_div'=>'largeur_image_article','nom_image'=>$image_article));
		}
		$test_image_article=sql_select('nom_image','spip_eva_habillage_images',"type='logos' AND nom_habillage='Defaut' AND nom_div='largeur_image_article'");
		$tab_image_article=sql_fetch($test_image_article);
		$image_article=$tab_image_article['nom_image'];

		echo _T('evahabillage:logos_taille_image_article');
		echo '<p><center><form method="POST" action="'.generer_url_ecrire("eva_habillage_graphisme").'">';
		echo '<input type="text" name="largeur_image_article" value="'.$image_article.'" size="10">';
		echo '&nbsp;&nbsp;<input type="submit" value="'._T('evahabillage:EVA_valider').'" />';
		echo '<input type="hidden" name="test_image_article" value="2">';
		echo '</form></center></p>';
		echo fin_cadre_trait_couleur(true);

		//Insertion de banières Flash (format swf)

		if(!empty($_FILES['flash_eva_habillage_envoi']['tmp_name']) AND is_uploaded_file($_FILES['flash_eva_habillage_envoi']['tmp_name']) AND (strpos($_FILES['flash_eva_habillage_envoi']['name'],'.swf'))){
			if(!move_uploaded_file($_FILES['flash_eva_habillage_envoi']['tmp_name'], _DIR_IMG.'eva_habillage/flash/'.$_FILES['flash_eva_habillage_envoi']['name']))
			{echo 'Erreur lors de la copie du fichier';}
		}

		if (isset($_POST['supprime_flash']))  {
			sql_delete('spip_eva_habillage_images',"id=".$_POST['supprime_flash']);
		}

		if (isset($_POST['secteur_flash'])) {
			$recup_flash_exists = sql_select('id','spip_eva_habillage_images',"nom_div = '".$_POST['secteur_flash']."' AND nom_habillage = 'Defaut'");
			$tab_recup_flash_exists = sql_fetch($recup_flash_exists);
		if (($_POST['secteur_flash']=='flash_secteur_pied') OR ($_POST['secteur_flash']=='flash_secteur_titre')) {
			if (isset($tab_recup_flash_exists['id'])) {            
				sql_updateq('spip_eva_habillage_images',array('nom_image' => $_POST['nom_flash'], 'pos_x' => $_POST['flash_horizontal'], 'pos_y' => $_POST['flash_vertical'],'repetition' => $_POST['flash_version']), "id =".$tab_recup_flash_exists['id']);
			}
			else {
				sql_insertq('spip_eva_habillage_images',array('type' =>'flash','nom_habillage' => 'Defaut','nom_div' => $_POST['secteur_flash'],'nom_image' =>$_POST['nom_flash'],'pos_x' => $_POST['flash_horizontal'], 'pos_y' => $_POST['flash_vertical'],'repetition' => $_POST['flash_version']));
			}
		}
		else {
			sql_insertq('spip_eva_habillage_images',array('type' =>'flash','nom_habillage' => 'Defaut','nom_div' => $_POST['secteur_flash'],'nom_image' =>$_POST['nom_flash'],'pos_x' => $_POST['flash_horizontal'], 'pos_y' => $_POST['flash_vertical'],'repetition' => $_POST['flash_version']));
		}
	}

	echo debut_cadre_trait_couleur(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/EVA_flash.png", true, '', _T('evahabillage:flash_titre'));

	echo bouton_block_depliable(_T('evahabillage:flash_inserer'),false,'');
	echo debut_block_depliable(false);
	echo debut_boite_info(true);
	echo '<br /><form method="POST" action="'.generer_url_ecrire("eva_habillage_graphisme").'">';
	echo _T('evahabillage:EVA_etape3_pour_secteur').'<br />';
	echo '<div style="text-align:center;"><select name="secteur_flash">';
	$def_div = EVA_secteurs_Flash();
	foreach ($def_div as $cle) {
		echo '<option value="'.$cle.'">'._T('evahabillage:'.$cle).'</option>';
	}
	echo '</select></div><br />&nbsp;<br />';
	echo '<div style="text-align:center; text-decoration:underline;">'._T('evahabillage:flash_taille_horizontale').'</div>';
	echo '<br /><div style="text-align:center;"><input type="text" name="flash_horizontal" /></div>';
	echo '<br />&nbsp;<br /><div style="text-align:center; text-decoration:underline;">'._T('evahabillage:flash_taille_verticale').'</div>';
	echo '<br /><div style="text-align:center;"><input type="text" name="flash_vertical" /></div>';

	echo '<div style="text-align:center;">'._T('evahabillage:flash_choisit_animation1').'<strong>'._DIR_IMG."eva_habillage/flash</strong>"._T('evahabillage:flash_choisit_animation2');
	echo '<br /><select name="nom_flash">';
	$dir_flash = opendir(_DIR_IMG."eva_habillage/flash");
	while ($nom_fichier = readdir($dir_flash)) {
		if (($nom_fichier!='.') AND ($nom_fichier!='..') AND (strpos($nom_fichier,'.swf'))) {
			echo '<option value="'.$nom_fichier.'">'.$nom_fichier.'</option>';
		}
	}
	closedir($dir_flash);
	echo '</select><br />&nbsp;<br />';
	echo '<hr />';
	echo _T('evahabillage:flash_facultatif1').'<br />';
	echo '<center><input type="text" name="flash_version" /></center><br />';
	echo '<hr />&nbsp;<br />';
	echo '<input type="submit" value="'._T('evahabillage:EVA_valider').'"></div></form>';
	echo fin_boite_info(true);
	echo fin_block();

	echo bouton_block_depliable(_T('evahabillage:flash_charger'),false,'');
	echo debut_block_depliable(false);
	echo "<center>L'animation au format SWF sera t&eacute;l&eacute;charg&eacute;e dans le r&eacute;pertoire <strong>"._DIR_IMG."eva_habillage/flash</strong><br />";
	echo "<span style='text-decoration:underline;'><strong>Attention :</strong></span> si une animation portant le m&ecirc;me nom est d&eacute;j&agrave; pr&eacute;sente dans ce r&eacute;pertoire, elle sera alors &eacute;cras&eacute;e.";
	echo '<br />&nbsp;<br /><form action="'.generer_url_ecrire("eva_habillage_graphisme").'" method="post" enctype="multipart/form-data">';
	echo '<input type="file" name="flash_eva_habillage_envoi" /><br />&nbsp;<br /><input type="submit" value="Envoyer" /></form></center>';
	echo fin_block();

	echo bouton_block_depliable(_T('evahabillage:flash_lister'),false,'');
	echo debut_block_depliable(false); 

	$recup_exist_flash = sql_select('id , nom_div , nom_image , pos_x , pos_y , repetition','spip_eva_habillage_images',"type = 'flash' AND nom_habillage = 'Defaut'");
	$test_exist_flash = sql_select('id','spip_eva_habillage_images',"type = 'flash' AND nom_habillage = 'Defaut' LIMIT 1");
	$tab_test_exist_flash = sql_fetch($test_exist_flash);
	if ($tab_test_exist_flash!='') {
		echo '<br /><table align="center" class="spip">';
		echo '<tr align="center" ';
		if (($couleur_table%2)==0) {echo 'class="row_even"';} else {echo 'class="row_odd"';}
		$couleur_table++;
		echo '>';
		echo '<td align="center"><div style="text-decoration:underline;">Secteur</div></td><td align="center"><div style="text-decoration:underline;">Fichier</div></td><td align="center"><div style="text-decoration:underline;">Largeur</div></td><td align="center"><div style="text-decoration:underline;">Hauteur</div></td><td align="center"><div style="text-decoration:underline;">Version</div></td><td align="center"><div style="text-decoration:underline;">Supprimer ?</div></td></tr>';
		while ($tab_exist_flash = sql_fetch($recup_exist_flash)) {
			echo '<tr align="center" ';
			if (($couleur_table%2)==0) {echo 'class="row_even"';} else {echo 'class="row_odd"';}
			$couleur_table++;
			echo '><form method="POST" action="'.generer_url_ecrire("eva_habillage_graphisme").'"><td align="center">'._T('evahabillage:'.$tab_exist_flash['nom_div']).'&nbsp;&nbsp;</td><td align="center"><strong>'.$tab_exist_flash['nom_image'].'</strong></td>';
			echo '<td align="center">'.$tab_exist_flash['pos_x'].'</td>';
			echo '<td align="center">'.$tab_exist_flash['pos_y'].'</td>';
			echo '<td align="center">'.$tab_exist_flash['repetition'].'</td>';
			echo '<td align="center"><input type="hidden" name="supprime_image" value="'.$tab_exist_flash['id'].'" />';
			echo '<input type="submit" value="'._T('evahabillage:EVA_supprimer').'" /></td></form></tr>';
		}
		echo '</table>';
	}
	else {
		echo '&nbsp;<br />'._T('evahabillage:EVA_aucune_image_fond');
	}

	echo fin_block().'<br />';
	echo fin_cadre_trait_couleur(true);


	//Choix du favicon
	if(!empty($_FILES['favicon_eva_habillage_envoi']['tmp_name']) AND is_uploaded_file($_FILES['favicon_eva_habillage_envoi']['tmp_name']) AND ((strpos($_FILES['favicon_eva_habillage_envoi']['name'],'.ico')) OR (strpos($_FILES['favicon_eva_habillage_envoi']['name'],'.png')) OR (strpos($_FILES['favicon_eva_habillage_envoi']['name'],'.gif')) OR (strpos($_FILES['favicon_eva_habillage_envoi']['name'],'.ICO')) OR (strpos($_FILES['favicon_eva_habillage_envoi']['name'],'.PNG')) OR (strpos($_FILES['favicon_eva_habillage_envoi']['name'],'.GIF')))){
		if(!move_uploaded_file($_FILES['favicon_eva_habillage_envoi']['tmp_name'], _DIR_IMG.'eva_habillage/favicon/'.$_FILES['favicon_eva_habillage_envoi']['name']))
		{echo 'Erreur lors de la copie du fichier';}
	}

	if (isset($_POST['nom_favicon'])) {
		$test_favicon=sql_select('id','spip_eva_habillage_images',"type = 'favicon'");
		$result_favicon=sql_fetch($test_favicon);
		if (isset($result_favicon['id'])) {
			sql_updateq('spip_eva_habillage_images',array('nom_image' => $_POST['nom_favicon'],'nom_habillage' => 'Defaut'),'id = '.$result_favicon['id']);
		}
		else {
			sql_insertq('spip_eva_habillage_images',array('type' => 'favicon','nom_image' => $_POST['nom_favicon'],'nom_habillage' => 'Defaut'));
		}
	}

	if (isset($_POST['supprim_favicon'])) {
		sql_delete('spip_eva_habillage_images',"id=".$_POST['supprim_favicon']);
	}

	echo debut_cadre_trait_couleur(_DIR_PLUGIN_EVA_HABILLAGE."img_pack/eva.gif", true, '', _T('evahabillage:favicon_titre'));
	echo bouton_block_depliable(_T('evahabillage:favicon_choisir'),false,'');
	echo debut_block_depliable(false);
	$test_favicon=sql_select('id , nom_image','spip_eva_habillage_images',"type = 'favicon' AND nom_habillage = 'Defaut'");
	$test_fav=sql_fetch($test_favicon);
	if (!isset($test_fav['id'])) {
		echo _T('evahabillage:favicon_a_choisir').'<img src="'._DIR_PLUGIN_EVASQUELETTES.'images/eva3_favicon.png"><br />&nbsp;<br />';
		echo _T('evahabillage:favicon_a_choisir2').'<br />&nbsp;<br />';
	}
	else {
		echo '<center>'._T('evahabillage:favicon_a_choisir3').'<img src="'._DIR_IMG.'eva_habillage/favicon/'.$test_fav['nom_image'].'"> nomm&eacute; <strong>'._DIR_IMG.'eva_habillage/favicon/'.$test_fav['nom_image'].'</strong><br />&nbsp;<br />';
		echo _T('evahabillage:favicon_a_supprimer');
		echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage_graphisme").'">';
		echo '<input type="hidden" name="supprim_favicon" value="'.$test_fav['id'].'">';
		echo '<input type="submit" value="'._T('evahabillage:EVA_supprimer').'" /></form><br /></center>';
	}

	echo debut_cadre_enfonce('', true, '', _T('evahabillage:favicon_choix1'));
	echo _T('evahabillage:favicon_choisir3').'<strong>'._DIR_IMG.'eva_habillage/favicon </strong> '._T('evahabillage:flash_choisit_animation2');
	echo '<br /><form method="POST" action="'.generer_url_ecrire("eva_habillage_graphisme").'">';
	echo '<br /><center><select name="nom_favicon">';
	$dir_favicon = opendir(_DIR_IMG."eva_habillage/favicon");
	while ($nom_fichier = readdir($dir_favicon)) {
		if (($nom_fichier!='.') AND ($nom_fichier!='..') AND ((strpos($nom_fichier,'.ico')) OR (strpos($nom_fichier,'.png')) OR (strpos($nom_fichier,'.gif')) OR (strpos($nom_fichier,'.ICO')) OR (strpos($nom_fichier,'.PNG')) OR (strpos($nom_fichier,'.GIF')))) {
			echo '<option value="'.$nom_fichier.'">'.$nom_fichier.'</option>';
		}
	}
	closedir($dir_favicon);
	echo '</select>';
	echo '<input type="submit" value="'._T('evahabillage:EVA_valider').'"></center></form>';
	echo fin_cadre_enfonce(true);
	echo fin_block();

	echo bouton_block_depliable(_T('evahabillage:favicon_charger'),false,'');
	echo debut_block_depliable(false);
	echo "<center>Le favicon (au format ICO, PNG ou GIF) sera t&eacute;l&eacute;charg&eacute;e dans le r&eacute;pertoire <strong>"._DIR_IMG."eva_habillage/favicon</strong><br />";
	echo "<span style='text-decoration:underline;'><strong>Attention :</strong></span> si un favicon portant le m&ecirc;me nom est d&eacute;j&agrave; pr&eacute;sent dans ce r&eacute;pertoire, il sera alors &eacute;cras&eacute;.";
	echo '<br />&nbsp;<br /><form action="'.generer_url_ecrire("eva_habillage_graphisme").'" method="post" enctype="multipart/form-data">';
	echo '<input type="file" name="favicon_eva_habillage_envoi" /><br />&nbsp;<br /><input type="submit" value="Envoyer" /></form></center>';
	echo fin_block().'<br />';

	echo fin_cadre_trait_couleur(true);

	echo fin_gauche(), fin_page();
}
?>