<?php
// Demande de déplacement d'un bloc vers le haut
function spipr_educ_bloc_vers_le_haut($page,$colonne) {
	// Tout d'abord récupérer l'id et la place du bloc ciblé
	$test_presence_deplacement_haut=false;
	$test_blocs=sql_select('*','spip_spipr_educ',"(type='bloc de base' OR type='bloc personnel') AND nom_sauvegarde='en_cours_d_utilisation_SPIPr' AND parametre1='$page' AND parametre2='$colonne'");
		while ($tab_blocs = sql_fetch($test_blocs)){
			if (is_numeric(_request($tab_blocs['nom'].'_haut_x'))) {
				$test_presence_deplacement_haut=true;
				$bloc_vers_le_haut['id']=$tab_blocs['id'];
				$bloc_vers_le_haut['parametre3']=$tab_blocs['parametre3'];
				$bloc_vers_le_bas['parametre3']=$bloc_vers_le_haut['parametre3']-1;
			}
		}
	// Inutile de poursuivre si aucun déplacement n'a été demandé...
	if ($test_presence_deplacement_haut) {
		// On cherche ensuite l'id du bloc à permuter
		$test_blocs_permuter=sql_select('id','spip_spipr_educ',"(type='bloc de base' OR type='bloc personnel') AND nom_sauvegarde='en_cours_d_utilisation_SPIPr' AND parametre1='$page' AND parametre2='$colonne' AND parametre3 = ".$bloc_vers_le_bas['parametre3']);
		$tab_blocs_permuter=sql_fetch($test_blocs_permuter);
		$bloc_vers_le_bas['id']=$tab_blocs_permuter['id'];
		//On permute les places des deux blocs
		sql_updateq('spip_spipr_educ',array('parametre3' => $bloc_vers_le_bas['parametre3']),"id = '".$bloc_vers_le_haut['id']."'");
		sql_updateq('spip_spipr_educ',array('parametre3' => $bloc_vers_le_haut['parametre3']),"id = '".$bloc_vers_le_bas['id']."'");
	}
}


// Demande de déplacement d'un bloc vers le bas
function spipr_educ_bloc_vers_le_bas($page,$colonne) {
	// Tout d'abord récupérer l'id et la place du bloc ciblé
	$test_presence_deplacement_bas=false;
	$test_blocs=sql_select('*','spip_spipr_educ',"(type='bloc de base' OR type='bloc personnel') AND nom_sauvegarde='en_cours_d_utilisation_SPIPr' AND parametre1='$page' AND parametre2='$colonne'");
	while ($tab_blocs = sql_fetch($test_blocs)){
		if (is_numeric(_request($tab_blocs['nom'].'_bas_x'))) {
			$test_presence_deplacement_bas=true;
			$bloc_vers_le_bas['id']=$tab_blocs['id'];
			$bloc_vers_le_bas['parametre3']=$tab_blocs['parametre3'];
			$bloc_vers_le_haut['parametre3']=$bloc_vers_le_bas['parametre3']+1;
		}
	}
	// Inutile de poursuivre si aucun déplacement n'a été demandé...
	if ($test_presence_deplacement_bas) {
		// On cherche ensuite l'id du bloc à permuter
		$test_blocs_permuter=sql_select('id','spip_spipr_educ',"(type='bloc de base' OR type='bloc personnel') AND nom_sauvegarde='en_cours_d_utilisation_SPIPr' AND parametre1='$page' AND parametre2='$colonne' AND parametre3 = ".$bloc_vers_le_haut['parametre3']);
		$tab_blocs_permuter=sql_fetch($test_blocs_permuter);
		$bloc_vers_le_haut['id']=$tab_blocs_permuter['id'];
		//On permute les places des deux blocs
		sql_updateq('spip_spipr_educ',array('parametre3' => $bloc_vers_le_bas['parametre3']),"id = '".$bloc_vers_le_haut['id']."'");
		sql_updateq('spip_spipr_educ',array('parametre3' => $bloc_vers_le_haut['parametre3']),"id = '".$bloc_vers_le_bas['id']."'");
	}
}


// Rangement des blocs pour conserver une bonne numérotation des ordres sans trou de numérotation, utile après ajout ou retrait d'un bloc
function spipr_educ_bloc_ranger($page,$colonne) {
	$test_blocs_ordre=sql_select('*','spip_spipr_educ',"(type='bloc de base' OR type='bloc personnel') AND nom_sauvegarde='en_cours_d_utilisation_SPIPr' AND parametre1='$page' AND parametre2='$colonne'",'','parametre3');
	$ordre=0;
	if (sql_count($test_blocs_ordre)>9) $ordre=10;
	while ($tab_blocs_ordre = sql_fetch($test_blocs_ordre)){
		$ordre++;
		sql_updateq('spip_spipr_educ',array('parametre3' => $ordre),'id = '.$tab_blocs_ordre['id']);
	}
}

// Cacher un bloc
function spipr_educ_bloc_cacher($page,$colonne) {
	$test_blocs_del=sql_select('*','spip_spipr_educ',"(type='bloc de base' OR type='bloc personnel') AND nom_sauvegarde='en_cours_d_utilisation_SPIPr' AND parametre1='$page' AND parametre2='$colonne'");
	while ($tab_blocs_del = sql_fetch($test_blocs_del)){
		if (is_numeric(_request($tab_blocs_del['nom'].'_supprimer_x'))) {
			sql_updateq('spip_spipr_educ',array('parametre2' => 'off'),'id = '.$tab_blocs_del['id']);
			spipr_educ_bloc_ranger($page,$colonne);
			echo "<script type='text/javascript'>if (window.jQuery) ajaxReload('".$page."_restaurer');</script>";
		}
	}
}

// Supprimer un bloc personnel
function spipr_educ_bloc_supprimer_definitivement($page,$colonne) {
	$test_blocs_del_def=sql_select('*','spip_spipr_educ',"type='bloc personnel' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr' AND parametre1='$page' AND parametre2='$colonne'");
	while ($tab_blocs_del_def = sql_fetch($test_blocs_del_def)){
		if (is_numeric(_request($tab_blocs_del_def['id'].'_suppression_definitive_x'))) {
			sql_delete('spip_spipr_educ', 'id = '. $tab_blocs_del_def['id']);
			spipr_educ_bloc_ranger($page,$colonne);
		}
	}
}

// Réintégrer un bloc qui avait été caché
function spipr_educ_bloc_reintegrer($id_bloc,$colonne) {
	sql_updateq(
		'spip_spipr_educ',
		array(
			'parametre2' => $colonne,
			'parametre3' => 999
		),
		"id=$id_bloc"
	);
	$test_bloc=sql_select('parametre1','spip_spipr_educ',"id=$id_bloc");
	while ($tab_bloc = sql_fetch($test_bloc)){
		spipr_educ_bloc_ranger($tab_bloc['parametre1'],$colonne);
	}
}

// Ajouter un bloc personnel
function spipr_educ_ajout_bloc_personnel($page,$colonne,$bloc) {
	sql_insert("spip_spipr_educ",
	"(nom, type, nom_sauvegarde, parametre1, parametre2, parametre3)",
	"('$bloc', 'bloc personnel', 'en_cours_d_utilisation_SPIPr', '$page', '$colonne', '999')");
	spipr_educ_bloc_ranger($page,$colonne);
}

// Le formulaire de base pour présenter les noisettes présentes dans la section $colonne de la page $page
function spipr_educ_presente_formulaire_deplacement($page,$colonne) {
	$test_blocs=sql_select('*','spip_spipr_educ',"(type='bloc de base' OR type='bloc personnel') AND nom_sauvegarde='en_cours_d_utilisation_SPIPr' AND parametre1='$page' AND parametre2='$colonne'",'','parametre3');
	$pos_bloc=0;
	$pos_fin=sql_count($test_blocs);
	while ($tab_blocs = sql_fetch($test_blocs)){
		$pos_bloc++;
		?>
		<div class='cadre' style='display:block; margin-bottom:10px; height:24px; line-height:24px; vertical-align:middle; padding:8px;' onmouseover="this.style.background='#eee';" onmouseout="this.style.background='';">
			<div style="width:58%; display:block; float:left;">
			<?php
				if ($tab_blocs['type']=='bloc de base') echo _T('spipr_educ:'.$tab_blocs['nom']);
				elseif ($tab_blocs['type']=='bloc personnel') echo "Bloc personnel : <b>".$tab_blocs['nom']."</b>";
			?>
			</div>
			<div style="width:40%; display:block; float:right; text-align:right;">
				<?php 
				if ($tab_blocs['parametre4']=='cfg') {
					?>
					<a href="<?php echo generer_url_ecrire("spipr_educ_configure_bloc","nom=".$tab_blocs['nom']."&page=".$page."&secteur=".$colonne."&id=".$tab_blocs['id']);?>" class="popin"><img src="<?php echo _DIR_PLUGIN_SPIPR_EDUC."img/cfg-24.png";?>" alt="Configurer ce bloc" title="Configurer ce bloc"/></a>
					<?php
				}
				if ($tab_blocs['type']=='bloc personnel') {
				?>
					<input type="image" src="<?php echo _DIR_PLUGIN_SPIPR_EDUC."img/suppression_bloc.png";?>" name="<?php echo $tab_blocs['id'];?>_suppression_definitive" alt="Supprimer définitivement ce bloc" title="Supprimer définitivement ce bloc" />
				<?php
				}
				if (($pos_bloc==1) AND ($pos_fin>2)) {?>
					<img src="<?php echo _DIR_PLUGIN_SPIPR_EDUC."img/spipr_edu_vide.png";?>" /><?php
				}
				if (($pos_bloc!=1) AND ($pos_fin>1)) {
				?>
					<input type="image" src="<?php echo _DIR_PLUGIN_SPIPR_EDUC."img/niveau_superieur_bloc.png";?>" name="<?php echo $tab_blocs['nom'];?>_haut" alt="Remonter ce bloc" title="Remonter ce bloc" />
				<?php }
				?>
				<?php
					if (($pos_bloc!=$pos_fin) AND ($pos_fin>1)) {
				?>
					<input type="image" src="<?php echo _DIR_PLUGIN_SPIPR_EDUC."img/niveau_inferieur_bloc.png";?>" name="<?php echo $tab_blocs['nom'];?>_bas" alt="Descendre ce bloc" title="Descendre ce bloc" />
				<?php }
					elseif ($pos_fin!=2) { ?>
					<img src="<?php echo _DIR_PLUGIN_SPIPR_EDUC."img/spipr_edu_vide.png";?>" />
					<?php }
				?>
				<input type="image" src="<?php echo _DIR_PLUGIN_SPIPR_EDUC."img/invisible.png";?>" name="<?php echo $tab_blocs['nom'];?>_supprimer" alt="Ne pas afficher ce bloc" title="Ne pas afficher ce bloc" />
			</div>
		</div>
		<?php
	}
}
function spipr_educ_presente_formulaire_ajout_bloc_replie($page,$colonne) { ?>
	<hr class='spip' />
	<div class='cadre' style='display:block; margin-bottom:10px; height:24px; line-height:24px; vertical-align:middle; padding:8px; border:none;' onmouseover="this.style.background='#eee';" onmouseout="this.style.background='';">
		<div style="float:right; text-align:right;"><input type="image" src="<?php echo _DIR_PLUGIN_SPIPR_EDUC."img/plus.png";?>" name="ajout_nouveau_bloc" alt="Ajouter un bloc" title="Ajouter un bloc" /></div>			
		<div style="float:right; text-align:right; margin-right:12px;">Ajouter un bloc supplémentaire</div>
	</div>
<?php
}
function spipr_educ_presente_formulaire_ajout_bloc_deplie($page,$colonne) {
	echo "<hr class='spip' />";
	$test_blocs=sql_select('*','spip_spipr_educ',"(type='bloc de base' OR type='bloc personnel') AND nom_sauvegarde='en_cours_d_utilisation_SPIPr' AND parametre1='$page' AND parametre2='off'",'','parametre3');
	$pos_fin=sql_count($test_blocs);
	if ($pos_fin>0) {
		?>
		<legend>Ajouter un bloc non actuellement affiché :</legend>
		<ul class="editer-groupe" style="margin:10px; margin-bottom:0;">
			<li class="choix">
				<label for="integration_bloc_spipr_educ">Choix du bloc à ajouter</label>
				<select name='integration_bloc_spipr_educ_choix'>
				<?php while ($tab_blocs = sql_fetch($test_blocs)){
					echo "<option value='".$tab_blocs['nom']."'>";
					if ($tab_blocs['type']=='bloc de base') echo _T('spipr_educ:'.$tab_blocs['nom']);
					else echo "Bloc personnel \"".$tab_blocs['nom']."\"";
					echo "</option>";
				} ?>
				</select>
			</li>
		</ul>
		<div class='cadre' style='display:block; margin-bottom:20px; margin-right:10px; height:24px; line-height:24px; vertical-align:middle; padding:8px; border:none; padding-top:0;' onmouseover="this.style.background='#eee';" onmouseout="this.style.background='';">
			<div style="float:right; text-align:right;"><input type="image" src="<?php echo _DIR_PLUGIN_SPIPR_EDUC."img/plus_g.png";?>" name="ajout_nouveau_bloc_spipr_educ" alt="Ajouter ce bloc" title="Ajouter ce bloc" /></div>			
			<div style="float:right; text-align:right; margin-right:12px;">Ajouter ce bloc</div>
		</div>
	<?php }	?>
	<legend>Ajouter un bloc personnel :</legend>
	<ul class="editer-groupe" style="margin:10px; margin-bottom:0;">
		<li class="choix">
			<label for="integration_bloc_personnel">Indiquez le nom du bloc (sans l'extension ".html"), le bloc ayant été préalablement placé dans le répertoire <b>noisettes/<?php echo $page; ?></b> situé à la racine de votre site ou dans le plugin SPIPr-éduc :</label>
			<input type='text' name='integration_bloc_personnel' id='integration_bloc_personnel' value="" class="text" />
		</li>
	</ul>
	<div class='cadre' style='display:block; margin-bottom:20px; margin-right:10px; height:24px; line-height:24px; vertical-align:middle; padding:8px; border:none; padding-top:0;' onmouseover="this.style.background='#eee';" onmouseout="this.style.background='';">
		<div style="float:right; text-align:right;"><input type="image" src="<?php echo _DIR_PLUGIN_SPIPR_EDUC."img/plus_g.png";?>" name="ajout_nouveau_bloc_personnel" alt="Ajouter ce bloc personnel" title="Ajouter ce bloc personnel" /></div>			
		<div style="float:right; text-align:right; margin-right:12px;">Ajouter ce bloc personnel</div>
	</div>
<?php
}
function spipr_educ_bloc_ajouter_distrib_spipr_edu($page,$colonne) {
	if (is_numeric(_request('ajout_nouveau_bloc_spipr_educ_x'))) {
		$noisette=_request('integration_bloc_spipr_educ_choix');
		$test_bloc=sql_select('*','spip_spipr_educ',"(type='bloc de base' OR type='bloc personnel') AND nom_sauvegarde='en_cours_d_utilisation_SPIPr' AND parametre1='$page' AND parametre2='off' AND nom='$noisette'");
		$tab_bloc=sql_fetch($test_bloc);
		$id_bloc=$tab_bloc['id'];
		spipr_educ_bloc_reintegrer($id_bloc,$colonne);
	}
}
function spipr_educ_bloc_ajouter_personnel($page,$colonne) {
	if (is_numeric(_request('ajout_nouveau_bloc_personnel_x'))) {
		sql_insert("spip_spipr_educ",
		"(nom, type, nom_sauvegarde, parametre1, parametre2, parametre3)",
		"('"._request('integration_bloc_personnel')."', 'bloc personnel', 'en_cours_d_utilisation_SPIPr', '$page', '$colonne', '999')");
		spipr_educ_bloc_ranger($page,$colonne);
	}
}

?>