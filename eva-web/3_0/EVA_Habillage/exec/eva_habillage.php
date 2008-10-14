<?php
/******************************************************************
***  Ce plugin EVA_habillage, créé par Olivier Gautier, est mis ***
***      à disposition sous un contrat Creative Commons BY      *** 
***                 consultable à l'adresse                     ***
***      http://www.creativecommons.org/licenses/by/2.0/fr/     ***
******************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

function exec_eva_habillage(){
    include_spip('base/db_mysql');
    include_spip('base/abstract_sql');
    include_spip('inc/presentation');
    include_spip('base/eva_habillage');
    
    

    $evaTable = "eva_habillage";
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
	debut_page(_T('evahabillage:EVA_nom'));
    gros_titre(_T('evahabillage:EVA_nom'));

    global $connect_statut;
    if ($connect_statut != '0minirezo') {
	echo _T('avis_non_acces_page');
	echo fin_gauche(), fin_page();
	exit;
    }
    
    debut_gauche();

    debut_droite();
    
     if (isset($_POST['changement_habillage'])) {
        $requete_habillage = "UPDATE eva_habillage SET habillage = '".$_POST['changement_habillage']."' WHERE sauvegarde = 'Defaut'";
        spip_query($requete_habillage);
    }
    
    if ($_POST['drop_table_eva']==2) {
        eva_habillage_drop_table();
        debut_cadre_relief('', false, '', _T('evahabillage:EVA_suppr_table'));
        echo _T('evahabillage:EVA_suppr_table2');
        fin_cadre_relief();
    }
    if ($_POST['drop_table_eva']==1) {
        debut_cadre_relief('', false, '', _T('evahabillage:EVA_suppr_table_confirm'));
        echo '<div style="text-align:center;">'._T('evahabillage:EVA_suppr_table_confirm_explic');
        echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';
        echo '<input type="hidden" name="drop_table_eva" value="2">';
        echo '<br /><input type="submit" value="'._T('evahabillage:EVA_supprimer').'"></form>';
        echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage").'"><input type="submit" value="'._T('evahabillage:EVA_annuler').'"></div>';
        echo '</form>';
        fin_cadre_relief();
    }
    



if ($_POST['creer_table']==1) {
        $query_verif_table = 'SELECT * FROM '.$evaTable.' LIMIT 1';
        $res_verif_table = spip_query($query_verif_table);
        if ($res_verif_table == '') {eva_habillage_creer_tables($evaTable);}

        $query_verif_themes = 'SELECT * FROM '.$evaTable.'_themes LIMIT 1';
        $res_verif_themes = spip_query($query_verif_themes);
        if ($res_verif_themes == '') {eva_habillage_creer_tables_themes($evaTable);}
        
        $query_verif_images = 'SELECT * FROM '.$evaTable.'_images LIMIT 1';
        $res_verif_images = spip_query($query_verif_images);
        if ($res_verif_images == '') {eva_habillage_creer_tables_images($evaTable);}

    }

    include_spip("inc/eva_habillage_definition_themes");
    $def_themes = eva_habillage_definition_themes ();
    
    if (isset($_POST['restauration_habillage'])) {
        $recherche_habillage_restaure = spip_query("SELECT habillage FROM eva_habillage WHERE sauvegarde='".mysql_escape_string($_POST['restauration_habillage'])."'");
        $tab__habillage_restaure = spip_fetch_array($recherche_habillage_restaure);
        spip_query("UPDATE eva_habillage SET habillage='".$tab__habillage_restaure['habillage']."' WHERE sauvegarde='Defaut'");
        
        spip_query("DELETE FROM eva_habillage_images WHERE nom_habillage='Defaut'");
        $recherche_images_restaure=spip_query("SELECT type,nom_div,nom_image,pos_x,pos_y,repetition,attach FROM eva_habillage_images WHERE nom_habillage='".mysql_escape_string($_POST['restauration_habillage'])."'");
        while ($tab=spip_fetch_array($recherche_images_restaure)) {
            spip_query("INSERT INTO eva_habillage_images VALUES ('','".$tab['type']."','Defaut','".$tab['nom_div']."','".$tab['nom_image']."','".$tab['pos_x']."','".$tab['pos_y']."','".$tab['repetition']."','".$tab['attach']."')");
        }
        
        $recherche_themes_restaure="SELECT * FROM eva_habillage_themes WHERE nom='".mysql_escape_string($_POST['restauration_habillage'])."'";
        $result_restaure=spip_query($recherche_themes_restaure);
        $tab_restaure=spip_fetch_array($result_restaure);
        foreach($def_themes as $habillage_cles => $habillage_inutile) {
            if (isset($tab_restaure[$habillage_cles])) {spip_query("UPDATE eva_habillage_themes SET ".$habillage_cles."='".$tab_restaure[$habillage_cles]."' WHERE nom='Defaut'");}
            else {spip_query("UPDATE eva_habillage_themes SET ".$habillage_cles."='' WHERE nom='Defaut'");}
        }
    }

    if ($_POST['modif_habillage']==1) {
        $mes_modifs = "UPDATE eva_habillage_themes SET ";
        foreach ($def_themes as $habillage_modif_cles => $habillage_modif_inutile) {
            $mes_modifs_tableau [$habillage_modif_cles] =$habillage_modif_cles." = '".$_POST[$habillage_modif_cles]."'";
        }
        $mes_modifs_prov = implode(" , ",$mes_modifs_tableau);
        $mes_modifs .= $mes_modifs_prov." WHERE nom='Defaut'";
        spip_query($mes_modifs);
    }
    
    if (isset($_POST['integrer_theme_externe'])) {
        include_spip('inc/eva_habillage_themes_externes');
        $tab_externe = eva_charger_themes();
        $theme_externe = $tab_externe[$_POST['integrer_theme_externe']];
        spip_query("DELETE FROM eva_habillage_themes WHERE nom = 'Defaut'");
        spip_query("DELETE FROM eva_habillage_images WHERE nom_habillage = 'Defaut'");
        spip_query("UPDATE eva_habillage SET habillage = ".$theme_externe['habillage']." WHERE sauvegarde = 'Defaut'");
        spip_query("INSERT INTO eva_habillage_themes VALUES ".$theme_externe['theme']);
        $tab = $theme_externe['images'];
        foreach ($tab as $val) {spip_query("INSERT INTO eva_habillage_images VALUES ".$val);}
    }

$query_verif = 'SELECT * FROM '.$evaTable.' LIMIT 1';
$res_verif = spip_query($query_verif);
if ($res_verif == '') {
        debut_cadre_trait_couleur($icone, false, '', _T('evahabillage:EVA_creer_table'));
            echo '<div style="text-align:center;">'._T('evahabillage:EVA_creer_les_table').'<br />&nbsp;<br />';
            echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';
            echo '<input type="hidden" name="creer_table" value="1"><input type="submit" value="'._T('evahabillage:EVA_creer').'"></form></div>';
        fin_cadre_trait_couleur();
}

else {
    
    $test_fri=spip_query("SELECT id_habillage FROM eva_habillage WHERE sauvegarde='Defaut'");
    $tab_fri=spip_fetch_array($test_fri);
    if (!isset($tab_fri['id_habillage'])) {spip_query("INSERT INTO eva_habillage VALUES ('','0','Defaut')");}
    
    $requete1 = "SELECT habillage FROM eva_habillage WHERE sauvegarde = 'Defaut'";
    $resultat1 = spip_query($requete1);
    $resultat1_tableau = spip_fetch_array($resultat1);
    $mon_habillage = $resultat1_tableau['habillage'];

// Premier Module - Choix de l'habillage de base
    debut_cadre_couleur($icone, false, '', _T('evahabillage:EVA_etape1'));
    echo _T('evahabillage:EVA_a_penser').'<br />';
    echo '<div style="text-align:center;"><p>'. _T('evahabillage:EVA_actif');
    if ($mon_habillage=='0'){echo _T('evahabillage:EVA_style_defaut');} else {echo "<strong>".$mon_habillage."</strong>";}
    echo '</p><br />';    
    $image_habillage = ereg_replace(".css",".png",$mon_habillage);
    if ($image_habillage=='0') {$image_habillage='eva_style.png';}
	 if (file_exists($path.$image_habillage)) {
	 echo '<img src="'.$path.$image_habillage.'" alt=""/><br />';
    }else{
    echo '<img src="'.$path.'eva_style.png" alt=""/><br />';
    }
    
    echo '<br />'._T('evahabillage:EVA_choix').'<br />&nbsp;<br />';
    echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';?>
    <select name="changement_habillage"><option value="0" <?php if ($mon_habillage=='0') {echo "selected";}?> >
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
    echo "</form></div><br /><hr /><br />";
    if (!isset($compteur_block)) {$compteur_block=0;}
    $compteur_block++;
    echo bouton_block_invisible($compteur_block);
    echo _T('evahabillage:EVA_choix_bloc');
    echo debut_block_invisible($compteur_block);    
    
    $mes_blocs = EVA_mes_blocs();
    foreach ($mes_blocs as $cle_blocs => $val_blocs) {
        $compteur_block++;
        echo '<br />&nbsp;&nbsp;&nbsp;&nbsp;'.bouton_block_invisible($compteur_block);
        echo _T('evahabillage:'.$cle_blocs);
        
        echo debut_block_invisible($compteur_block);
            foreach($val_blocs as $val) {
                if (isset($_POST[$val])) {
                spip_query("DELETE FROM eva_habillage_images WHERE nom_habillage='Defaut' AND nom_div='".$val."'");
                spip_query("INSERT INTO eva_habillage_images SET type = 'bloc' , nom_habillage='Defaut' , nom_div='".$val."' , nom_image='".$_POST[$val]."'");
                }
            }
            echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';
            foreach ($val_blocs as $val) {
                $test_pres=spip_query("SELECT nom_image FROM eva_habillage_images WHERE nom_habillage='Defaut' AND nom_div='".$val."'");
                $test_tab=spip_fetch_array($test_pres);
                $test=$test_tab['nom_image'];
                echo '<div style="text-decoration:underline;">'._T('evahabillage:'.$val).'</div><br />';;
                echo '<div style="text-align:center;">';
		if (strpos($mon_habillage,'droite')!=FALSE) {echo 'Droite&nbsp;';}
                else {echo 'Gauche&nbsp;';}		
		echo '<input type="radio" name="'.$val.'" value="gauche" ';
                if (($test=='gauche') OR (!isset($test))) {echo 'checked ';}
                echo '/>&nbsp;&nbsp;&nbsp;&nbsp;';
                if (($val!='sommaire_navigation') AND ($val!='sommaire_connexion') AND ($val!='article_navigation') AND ($val!='rubrique_navigation') AND ($val!='breve_navigation') AND ($val!='auteur_navigation')){
                    echo 'Centre&nbsp;<input type="radio" name="'.$val.'" value="centre" ';
                    if ($test=='centre') {echo 'checked ';}
                    echo '/>&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
                $test_3cols=spip_query("SELECT habillage FROM eva_habillage WHERE sauvegarde='Defaut'");
                $tab_3cols=spip_fetch_array($test_3cols);
                if ($tab_3cols['habillage']=='eva_style_3_colonnes.css') {
                    echo 'Droite&nbsp;<input type="radio" name="'.$val.'" value="droite" ';
                    if ($test=='droite') {echo 'checked ';}
                    echo '/>&nbsp;&nbsp;&nbsp;&nbsp;';}
                    echo 'Non affich&eacute;&nbsp;<input type="radio" name="'.$val.'" value="non" ';
                    if ($test=='non') {echo 'checked ';}
                    echo '/>';
                echo '</div><br />';
            }
            echo '<div style="text-align:center;"><input type="submit" value="'._T('evahabillage:EVA_valider').'"></div><br />';
            echo '</form>';
        echo fin_block().'<br />';
    }
        
    echo fin_block().'<br />&nbsp;<br />';
    
    $compteur_block++;
    echo bouton_block_invisible($compteur_block);
    echo _T('evahabillage:EVA_choix_nbre');
    echo debut_block_invisible($compteur_block);
    
    $nbre = EVA_mes_nbres();
    foreach ($nbre as $cle_nbre => $val_nbre) {
        foreach($val_nbre as $val) {
            if (isset($_POST[$val])) {
                spip_query("DELETE FROM eva_habillage_images WHERE nom_habillage='Defaut' AND nom_div='".$val."'");
                spip_query("INSERT INTO eva_habillage_images SET type = 'nbre' , nom_habillage='Defaut' , nom_div='".$val."' , nom_image='".$_POST[$val]."'");
            }
        }
        $compteur_block++;
        echo '<br />&nbsp;&nbsp;&nbsp;&nbsp;'.bouton_block_invisible($compteur_block);
        echo _T('evahabillage:'.$cle_nbre);
        echo debut_block_invisible($compteur_block);
        
        echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';
        foreach ($val_nbre as $val) {
            
            $test_pres=spip_query("SELECT nom_image FROM eva_habillage_images WHERE nom_habillage='Defaut' AND nom_div='".$val."'");
            $test_tab=spip_fetch_array($test_pres);
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
        
        echo fin_block().'<br />';
    }
    
    echo fin_block().'<br />';
    
    
    fin_cadre_couleur();

//Module 2 - Ajustements prédéfinis des paramètres d'habillage
    debut_cadre_trait_couleur($icone, false, '', _T('evahabillage:EVA_etape2'));

    echo '<div style="text-align:center;">'._T('evahabillage:EVA_etape2_detail').'</div><br />&nbsp;<br /><form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';?>
    
    <?php 
    $recherche_themes_defini = "SELECT * FROM eva_habillage_themes WHERE nom='Defaut'";
    $resultat_themes_defini = spip_query($recherche_themes_defini);
    $tableau_themes_defini = spip_fetch_array($resultat_themes_defini);
    if (!isset($compteur_block)) {$compteur_block=0;}
    
    $couleur_table = 0;
    $themes_principaux = EVA_def_themes();
    foreach ($themes_principaux as $mon_theme) {
        $compteur_block++;
        echo bouton_block_invisible($compteur_block);
        echo _T('evahabillage:'.$mon_theme);
        echo debut_block_invisible($compteur_block);    
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
		echo '</td><td align="center">'.'<input type="text" name="'.$habillage_cles.'" value="'.$tableau_themes_defini[$habillage_cles].'" size="10">'.'</td></tr>';
            }
        }
    echo '</table><div style="text-align:center;"><input type="submit" value="'._T('evahabillage:EVA_valider').'"></div>';
    echo fin_block().'<br />&nbsp;<br />';
    }
    
    echo'<input type="hidden" name="modif_habillage" value="1"></form>';
    include_spip("inc/eva_habillage_choix_couleur");
    eva_habillage_choix_couleur();
    echo '<hr /><p><a href="'._DIR_PLUGIN_EVA_HABILLAGE.'colorschemes2" target="_blank" title="Cliquez ici pour utiliser ColorSchemes2 !" alt="Cliquez ici pour utiliser ColorSchemes2 !">'._T('evahabillage:colorschemes2').'</a></p><br />';
    fin_cadre_trait_couleur();
    

//Module 3 - Ajout d'imges de fond dans les secteurs
    debut_cadre_couleur($icone, false, '', _T('evahabillage:EVA_etape3'));
    
    if (isset($_POST['supprime_image']))  {
        spip_query("DELETE FROM eva_habillage_images WHERE id=".$_POST['supprime_image']);
    }   
    if (isset($_POST['supprime_liste']))  {
        spip_query("DELETE FROM eva_habillage_images WHERE id=".$_POST['supprime_liste']);
    }
    if (isset($_POST['secteur_image'])) {
        $recup_image_exists = spip_query("SELECT id FROM eva_habillage_images WHERE nom_div = '".$_POST['secteur_image']."' AND nom_habillage = 'Defaut'");
        $tab_recup_image_exists = spip_fetch_array($recup_image_exists);
        $repeat = $_POST['repeat_x']+$_POST['repeat_y'];
        if ($repeat==0) {$rep='no-repeat';}
        elseif ($repeat==1) {$rep='repeat-x';}
        elseif ($repeat==2) {$rep='repeat-y';}
        elseif ($repeat==3) {$rep='repeat';}
        if ($_POST['pos_x']==4) {$Xpos=$_POST['position_x'];} else {$Xpos=$_POST['pos_x'];}
        if ($_POST['pos_y']==4) {$Ypos=$_POST['position_y'];} else {$Ypos=$_POST['pos_y'];}
        if (isset($tab_recup_image_exists['id'])) {            
            $mise_a_jour_image = spip_query("UPDATE eva_habillage_images SET nom_image = '".$_POST['nom_image']."' , pos_x = '".$Xpos."' , pos_y = '".$Ypos."' , repetition = '".$rep."' , attach = '".$_POST['attach']."' WHERE id =".$tab_recup_image_exists['id']);
        }
        else {
            $new_image = spip_query("INSERT INTO eva_habillage_images VALUES ('','image','Defaut','".$_POST['secteur_image']."','".$_POST['nom_image']."','".$Xpos."','".$Ypos."','".$rep."','".$_POST['attach']."')");
        }
    }
    if (isset($_POST['secteur_liste'])) {
        $recup_liste_exists = spip_query("SELECT id FROM eva_habillage_images WHERE nom_div = '".$_POST['secteur_liste']."' AND nom_habillage = 'Defaut'");
        $tab_recup_liste_exists = spip_fetch_array($recup_liste_exists);
        
        if (isset($tab_recup_liste_exists['id'])) {
            $mise_a_jour_liste = spip_query("UPDATE eva_habillage_images SET nom_image = '".$_POST['nom_puce']."' , pos_x = '".$_POST['liste_position']."' WHERE id =".$tab_recup_liste_exists['id']);
        }
        else {
            $new_liste = spip_query("INSERT INTO eva_habillage_images VALUES ('','liste','Defaut','".$_POST['secteur_liste']."','".$_POST['nom_puce']."','".$_POST['liste_position']."','','','')");
        }
    }
    
    $compteur_block++;
    echo bouton_block_invisible($compteur_block);
    echo _T('evahabillage:EVA_etape3_image_fond');
    echo debut_block_invisible($compteur_block);
    echo '<br /><form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';
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
    
    echo '<div style="text-align:center;">'._T('evahabillage:EVA_etape3_choix_image').'<strong>'._DIR_PLUGIN_EVA_HABILLAGE.'mon_image</strong>&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<select name="nom_image">';
    $dir = opendir(_DIR_PLUGIN_EVA_HABILLAGE."mon_image");
    while ($nom_fichier = readdir($dir)) {
        if (($nom_fichier!='.') AND ($nom_fichier!='..') AND ((strpos($nom_fichier,'.gif')) OR (strpos($nom_fichier,'.jpg')) OR (strpos($nom_fichier,'.png')))) {
        echo '<option value="'.$nom_fichier.'">'.$nom_fichier.'</option>';
        }
    }
    closedir($dir);
    echo '</select><br />&nbsp;<br /><input type="submit" value="'._T('evahabillage:EVA_valider').'"></div></form>';
    echo fin_block().'<br />&nbsp;<br />';
    
    /*******************
    $compteur_block++;
    echo bouton_block_invisible($compteur_block);
    echo _T('evahabillage:EVA_etape3_liste_puce');
    echo debut_block_invisible($compteur_block);
    echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';
    echo _T('evahabillage:EVA_etape3_pour_liste').'<br />';
    echo '<div style="text-align:center;"><select name="secteur_liste">';
    $def_div = EVA_div_images();
    foreach ($def_div as $cle => $val) {
        if (strpos($cle,'liste_')!==FALSE) {echo '<option value="'.$cle.'">'._T('evahabillage:'.$cle).'</option>';}
    }
    echo '</select></div><br />&nbsp;<br />';
    echo '<div style="text-align:center;">'._T('evahabillage:EVA_etape3_position_puce');
    echo _T('evahabillage:EVA_interieur').'<input type="radio" name="liste_position" value="inside" checked />&nbsp;&nbsp;&nbsp;&nbsp;'._T('evahabillage:EVA_exterieur').'<input type="radio" name="liste_position" value="outside" />';
    echo '<br />&nbsp;<br />';
    echo _T('evahabillage:EVA_etape3_choix_image').'<strong>'._DIR_PLUGIN_EVA_HABILLAGE.'ma_puce</strong>&nbsp;&nbsp;&nbsp;&nbsp;';
    echo '<select name="nom_puce">';
    $dir = opendir(_DIR_PLUGIN_EVA_HABILLAGE."ma_puce");
    while ($nom_fichier = readdir($dir)) {
        if (($nom_fichier!='.') AND ($nom_fichier!='..') AND ((strpos($nom_fichier,'.gif')) OR (strpos($nom_fichier,'.jpg')) OR (strpos($nom_fichier,'.png')))) {
        echo '<option value="'.$nom_fichier.'">'.$nom_fichier.'</option>';
        }
    }
    closedir($dir);
    echo '</select><br />&nbsp;<br /><input type="submit" value="'._T('evahabillage:EVA_valider').'" /></div></form>';
    echo fin_block().'<br /><hr />';
    ********************/
    
    $compteur_block++;
    echo bouton_block_invisible($compteur_block);
    echo _T('evahabillage:EVA_etape3_liste_images_definies');
    echo debut_block_invisible($compteur_block);
    $recup_exist_image = spip_query("SELECT id , nom_div , nom_image FROM eva_habillage_images WHERE type = 'image' AND nom_habillage = 'Defaut'");
    $test_exist_image = spip_query("SELECT id FROM eva_habillage_images WHERE type = 'image' AND nom_habillage = 'Defaut' LIMIT 1");
    $tab_test_exist_image = spip_fetch_array($test_exist_image);
    if ($tab_test_exist_image!='') {
        echo '<br /><table align="center" class="spip">';
        echo '<tr align="center" ';
            if (($couleur_table%2)==0) {echo 'class="row_even"';} else {echo 'class="row_odd"';}
            $couleur_table++;
            echo '>';
            echo '<td align="center"><div style="text-decoration:underline;">Secteur</div></td><td align="center"><div style="text-decoration:underline;">Image</div></td><td align="center"><div style="text-decoration:underline;">Supprimer ?</div></td></tr>';
        while ($tab_exist_image = spip_fetch_array($recup_exist_image)) {
            echo '<tr align="center" ';
            if (($couleur_table%2)==0) {echo 'class="row_even"';} else {echo 'class="row_odd"';}
            $couleur_table++;
            echo '><form method="POST" action="'.generer_url_ecrire("eva_habillage").'"><td align="center">'._T('evahabillage:'.$tab_exist_image['nom_div']).'&nbsp;&nbsp;</td><td align="center"><strong>'.$tab_exist_image['nom_image'].'</strong></td><td align="center">';
            echo '<input type="hidden" name="supprime_image" value="'.$tab_exist_image['id'].'" />';
            echo '<input type="submit" value="'._T('evahabillage:EVA_supprimer').'" /></td></form></tr>';
        }
        echo '</table>';
    }
    else {
    echo '&nbsp;<br />'._T('evahabillage:EVA_aucune_image_fond');
    }
    echo fin_block().'<br />&nbsp;<br />';
    
    /*********************
    $compteur_block++;
    echo bouton_block_invisible($compteur_block);
    echo _T('evahabillage:EVA_etape3_liste_puces_definies');
    echo debut_block_invisible($compteur_block);
    $recup_exist_liste = spip_query("SELECT id , nom_div FROM eva_habillage_images WHERE type = 'liste' AND nom_habillage = 'Defaut'");
    $test_exist_liste = spip_query("SELECT id FROM eva_habillage_images WHERE type = 'liste' AND nom_habillage = 'Defaut' LIMIT 1");
    $tab_test_exist_liste = spip_fetch_array($test_exist_liste);
    if ($tab_test_exist_liste!='') {
        echo '<br /><table align="center" class="spip">';
        while ($tab_exist_liste = spip_fetch_array($recup_exist_liste)) {
            echo '<tr align="center" ';
            if (($couleur_table%2)==0) {echo 'class="row_even"';} else {echo 'class="row_odd"';}
            $couleur_table++;
            echo '><form method="POST" action="'.generer_url_ecrire("eva_habillage").'"><td align="center">'._T('evahabillage:'.$tab_exist_liste['nom_div']).'&nbsp;&nbsp;</td><td align="center">';
            echo '<input type="hidden" name="supprime_liste" value="'.$tab_exist_liste['id'].'" />';
            echo '<input type="submit" value="'._T('evahabillage:EVA_supprimer').'" /></td></tr></form>';
        }
        echo '</table>';
    }
    else {
    echo '&nbsp;<br />'._T('evahabillage:EVA_aucune_liste_fond');
    }
    echo fin_block();
    *********************/
    
    fin_cadre_couleur();

//Module 4 - Ajout de propriétés CSS personnelles
    debut_cadre_trait_couleur($icone, false, '', _T('evahabillage:EVA_etape5'));
    if (isset($_POST['nouvelle_regle'])) {spip_query("INSERT INTO eva_habillage_images VALUES ('','perso','Defaut','".mysql_escape_string($_POST['nouvelle_regle'])."','','','','','')");}
    if (isset($_POST['supprime_perso'])) {spip_query("DELETE FROM eva_habillage_images WHERE id=".$_POST['supprime_perso']);}
    
    echo '<div style="text-align:center;">'._T('evahabillage:EVA_etape5_detail').'<br />';
    echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';
    echo '<br /><input type="text" name="nouvelle_regle" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="'._T('evahabillage:EVA_valider').'" /></div></form><br />';
    $compteur_block++;
    echo bouton_block_invisible($compteur_block);
    echo _T('evahabillage:EVA_etape5_defini');
    echo debut_block_invisible($compteur_block);
    $recherche_perso_unique = spip_query("SELECT id FROM eva_habillage_images WHERE type='perso' AND nom_habillage='Defaut' LIMIT 1");
    $tab_perso_unique = spip_fetch_array($recherche_perso_unique);
    if (isset($tab_perso_unique['id'])) {    
    echo '<br /><table align="center" class="spip">';
    $recherche_perso = spip_query("SELECT id,nom_div FROM eva_habillage_images WHERE type='perso' AND nom_habillage='Defaut'");
    while ($tab = spip_fetch_array($recherche_perso)) {
        echo '<tr align="center" ';
        if (($couleur_table%2)==0) {echo 'class="row_even"';} else {echo 'class="row_odd"';}
        $couleur_table++;
        echo '><form method="POST" action="'.generer_url_ecrire("eva_habillage").'"><td align="center">';
        echo '<strong>'.mysql_escape_string($tab['nom_div']).'</strong></td><td align="center">';
        echo '<input type="hidden" name="supprime_perso" value="'.$tab['id'].'" />';
        echo '<input type="submit" value="'._T('evahabillage:EVA_supprimer').'" />';
        echo '</td></form></tr>';
    }
    echo '</table>';
    }
    else {
    echo '<br />'._T('evahabillage:EVA_etape5_rien_defini');
    }
    echo fin_block();
    
    fin_cadre_trait_couleur();

//Module 5 - Module de sauvegarde
    debut_cadre_couleur($icone, false, '', _T('evahabillage:EVA_etape4'));
    
    if (isset($_POST['supprimer_habillage'])) {
        spip_query("DELETE FROM eva_habillage WHERE sauvegarde = '".mysql_escape_string($_POST['supprimer_habillage'])."'");
        spip_query("DELETE FROM eva_habillage_themes WHERE nom='".mysql_escape_string($_POST['supprimer_habillage'])."'");
        spip_query("DELETE FROM eva_habillage_images WHERE nom_habillage='".mysql_escape_string($_POST['supprimer_habillage'])."'");
    }

    if ((isset($_POST['nouvelle_sauvegarde'])) AND ($_POST['nouvelle_sauvegarde']!='Defaut')) {
        $nom_habillage_defaut=spip_query("SELECT habillage FROM eva_habillage WHERE sauvegarde = 'Defaut'");
        $tab_habillage_defaut=spip_fetch_array($nom_habillage_defaut);
        spip_query("DELETE FROM eva_habillage WHERE sauvegarde='".mysql_escape_string($_POST['nouvelle_sauvegarde'])."'");
        spip_query("INSERT INTO eva_habillage VALUES ('','".$tab_habillage_defaut['habillage']."','".mysql_escape_string($_POST['nouvelle_sauvegarde'])."')");
        spip_query("DELETE FROM eva_habillage_themes WHERE nom='".mysql_escape_string($_POST['nouvelle_sauvegarde'])."'");
        spip_query("INSERT INTO eva_habillage_themes SET nom ='".mysql_escape_string($_POST['nouvelle_sauvegarde'])."'");
        $result_valeurs=spip_query($recherche_themes_defini);
        $tab_valeurs=spip_fetch_array($result_valeurs);
        foreach($def_themes as $habillage_cles => $habillage_inutile) {spip_query("UPDATE eva_habillage_themes SET ".$habillage_cles."='".$tab_valeurs[$habillage_cles]."' WHERE nom='".mysql_escape_string($_POST['nouvelle_sauvegarde'])."'");}
        spip_query("DELETE FROM eva_habillage_images WHERE nom_habillage='".mysql_escape_string($_POST['nouvelle_sauvegarde'])."'");
        $images_sauve = "SELECT type,nom_div,nom_image,pos_x,pos_y,repetition,attach FROM eva_habillage_images WHERE nom_habillage='Defaut'";
        $result_images_sauve=spip_query($images_sauve);
        while ($tab=spip_fetch_array($result_images_sauve)) {
            spip_query("INSERT INTO eva_habillage_images VALUES ('','".$tab['type']."','".mysql_escape_string($_POST['nouvelle_sauvegarde'])."','".$tab['nom_div']."','".$tab['nom_image']."','".$tab['pos_x']."','".$tab['pos_y']."','".$tab['repetition']."','".$tab['attach']."')");
        }
    }
    elseif($_POST['nouvelle_sauvegarde']=='Defaut') {
        debut_cadre_relief('', false, '', _T('evahabillage:EVA_erreur_sauvegarde'));
        echo _T('evahabillage:EVA_erreur_sauvegarde2');
        fin_cadre_relief();
    }
 
    $recherche_sauvegardes = "SELECT nom FROM eva_habillage_themes WHERE nom != 'Defaut' ORDER BY nom";
    $resultat_sauvegarde1 = spip_query($recherche_sauvegardes);
    $resultat_sauvegarde2 = spip_query($recherche_sauvegardes);
    $test_presence = spip_query($recherche_sauvegardes);
    $tab_presence = spip_fetch_array($test_presence);
    
    echo '<div style="text-align:center;">'._T('evahabillage:EVA_etape4_sauvegarder').'<br />&nbsp;<br /><form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';
    echo '<input type="text" name="nouvelle_sauvegarde">&nbsp;&nbsp;<input type="submit" value="'._T('evahabillage:EVA_sauvegarder').'"></div></form>';
    
if ($tab_presence!='') {
    echo '<br /><hr /><div style="text-align:center;">'._T('evahabillage:EVA_etape4_restaurer').'<br />&nbsp;<br /><form method="POST" action="'.generer_url_ecrire("eva_habillage").'"><select name="restauration_habillage">';
    while ($tab = spip_fetch_array($resultat_sauvegarde1)) {
        echo '<option value="'.$tab['nom'].'">'.$tab['nom'].'</option>'; }
    echo '</select><br />&nbsp;<br /><input type="submit" value="'._T('evahabillage:EVA_restaurer').'"></form></div><br /><hr />';
    
    echo '<div style="text-align:center;">'._T('evahabillage:EVA_etape4_supprimer').'<br />&nbsp;<br /><form method="POST" action="'.generer_url_ecrire("eva_habillage").'"><select name="supprimer_habillage">';
    while ($tab = spip_fetch_array($resultat_sauvegarde2)) {
        echo '<option value="'.$tab['nom'].'">'.$tab['nom'].'</option>'; }
    echo '</select><br />&nbsp;<br /><input type="submit" value="'._T('evahabillage:EVA_suppression').'"></form></div>';
}

    echo '<br /><hr /><br /><div style="text-align:center;">'._T('evahabillage:EVA_restauration_externe');
    $chemin_themes = _DIR_PLUGIN_EVA_HABILLAGE."inc/eva_habillage_themes_externes.php";
    if (file_exists($chemin_themes)) {
        include_spip('inc/eva_habillage_themes_externes');
        $tab_externe = eva_charger_themes();
        if (isset($tab_externe)) {
        echo _T('evahabillage:EVA_restauration_externe_choix').'<br />';
        echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage").'"><select name="integrer_theme_externe">';
        foreach ($tab_externe as $cle => $inutile) {echo '<option value="'.$cle.'">'.$cle.'</option>';}
        echo '</select><br />&nbsp;<br /><input type="submit" value="'._T('evahabillage:EVA_valider').'"></form>';}
        else {echo _T('evahabillage:EVA_restauration_externe_aucun');}
    }
    else {echo _T('evahabillage:EVA_restauration_externe_aucun');}
    echo '</div>';
    fin_cadre_couleur();
   
//Dernier cadre - Effacement des tables    
    debut_cadre_couleur_foncee($icone, false, '', _T('evahabillage:EVA_drop_table'));
    echo _T('evahabillage:EVA_drop_table_explication');
    echo '<form method="POST" action="'.generer_url_ecrire("eva_habillage").'">';
    echo '<input type="hidden" name="drop_table_eva" value="1">';
    echo '<div style="text-align:center;"><br /><input type="submit" value="'._T('evahabillage:EVA_supprimer').'"></div>';
    echo '</form>';
    fin_cadre_couleur_foncee();
}    
    echo fin_gauche(), fin_page();
}
?>