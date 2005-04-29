<?php
//////////////////////////////////////////////////////
// Logos de l'auteur
//
//include ("ecrire/inc.php3");
 
include ("ecrire/inc_acces.php3");
include ("ecrire/inc_layer.php3");
include ("ecrire/inc_logos.php3");

// Uploader un document, une image ou un logo,
// supprimer cet element, creer les vignettes, etc.

include ("ecrire/inc_version.php3");
include_ecrire('inc_presentation.php3');	# regler la langue en cas d'erreur
include_ecrire('inc_getdocument.php3');		# diverses fonctions de ce fichier
include_ecrire("inc_charsets.php3");		# pour le nom de fichier
include_ecrire("inc_meta.php3");			# ne pas faire confiance au cache
											# (alea_ephemere a peut-etre change)
include_ecrire("inc_admin.php3");			# verifier_action_auteur
include_ecrire("inc_abstract_sql.php3");	# spip_insert
include_ecrire('inc_documents.php3');		# fichiers_upload()

$id_auteur_session=$auteur_session['id_auteur'];

// Recuperer les variables d'upload
if (!$_FILES)
	$_FILES = &$HTTP_POST_FILES;
if (!is_array($_FILES))
	$_FILES = array();
foreach ($_FILES as $id => $file) {
	if ($file['error'] == 4 /* UPLOAD_ERR_NO_FILE */)
		unset ($_FILES[$id]);
}


//
// Le switch principal : quelle est l'action demandee
//


// appel de config-fonction
if ($test_vignette)
	$retour_image = tester_vignette($test_vignette);

// Creation de vignette depuis le portfolio (ou autre)
else if ($vignette) {
	if ($creer_vignette == 'oui' AND
	verifier_action_auteur("vign $vignette",
	$hash, $hash_id_auteur))
		creer_fichier_vignette($vignette);
	else
		$retour_image = creer_fichier_vignette($vignette, true); # obsolete
}



// Ajout d'un logo
else if ($ajout_logo == "oui" and $logo) {
	if ($desc = array_pop($_FILES)
	AND verifier_action_auteur("ajout_logo $logo",
	$hash, $hash_id_auteur))
		ajout_logo($desc, $logo);
redirige_par_entete($PHP_SELF);
}

// Suppression d'un logo
else if ($image_supp) {
	if (verifier_action_auteur("supp_logo $image_supp",
	$hash, $hash_id_auteur))
		effacer_logo($image_supp);
		redirige_par_entete($PHP_SELF);
}




function decrire_logo_bloog($racine) {
	global $connect_id_auteur;
		
	if ($img = cherche_image_nommee($racine)) {
		list($dir, $racine, $fmt) = $img;
		$fid = $dir . "$racine.".$fmt; 
			// contrer le cache du navigateur
		$contre = @filesize($fid) . @filemtime($fid);
		if ($taille = @getimagesize($fid)) {
				list($x, $y, $w, $h) = resize_logo($taille);
				$xy = _T('info_largeur_vignette', array('largeur_vignette' => $x, 'hauteur_vignette' => $y));
				$taille = " width='$w' height='$h'";
			} else { $xy =''; $w = 0; $h = 0;}
		include("ecrire/inc_admin.php3");
		return array("$racine.".$fmt, 
			     $xy, 
			     "<img src='./spip_image_reduite.php3?img=" .
			     $fid . "&taille_x=$w&taille_y=$h&hash=" .
			     calculer_action_auteur ("reduire $w $h") .
			     "&hash_id_auteur=$connect_id_auteur" .
			     (!$contre ? '' : ("&".md5($contre))) .
			     "'$taille style='border-width: 0px' alt='$racine' />",
			     $x, $y);
	}
	return '';
}

function afficher_boite_logo_bloog($type, $id_objet, $id, $texteon, $texteoff) {
	global $options, $spip_display;

	$logon = $type.'on'.$id;
	$logoff = $type.'off'.$id;

	if ($spip_display != 4) {
	
		echo "<p>";
		
		echo "<div class='verdana1' style='text-align: center;'>";
		$desc = decrire_logo_bloog($logon);
		afficher_logo_bloog($logon, $texteon, $desc, $id_objet, $id);

		/*if ($desc AND $texteoff) {
			echo "<br /><br />";
			$desc = decrire_logo_bloog($logoff);
			afficher_logo_bloog($logoff, $texteoff, $desc, $id_objet, $id);
		}*/
	
		echo "</div>";
		
		echo "</p>";
	}
}

function afficher_logo_bloog($racine, $titre, $logo, $id_objet, $id) {
	global $connect_id_auteur;
	global $couleur_foncee, $couleur_claire;
	global $clean_link;

	include('ecrire/inc_admin.php3');
 
	$redirect = $clean_link->getUrl();

	echo "<b>";
	echo bouton_block_invisible(md5($titre));
	echo $titre;
	echo "</b>";
	echo "<font size=1>";

	if ($logo) {
		list($fichier, $taille, $img) =  $logo;
		$hash = calculer_action_auteur("supp_logo $fichier");

		echo "<p><center><div>$img</div>";
		echo debut_block_invisible(md5($titre));
		echo $taille;
		echo "\n<br />[<a href='$PHP_SELF?";
		echo "$id_objet=$id&";
		echo "image_supp=$fichier&hash_id_auteur=$connect_id_auteur&hash=$hash'>"._T('lien_supprimer')."</A>]";
		echo fin_block();
		echo "</center></p>";
	}
	else {
		$hash = calculer_action_auteur("ajout_logo $racine");
		echo debut_block_invisible(md5($titre));

		echo "\n\n<FORM ACTION='$PHP_SELF' METHOD='POST'
			ENCTYPE='multipart/form-data'>";
		echo "\n<INPUT NAME='redirect' TYPE=Hidden VALUE='$redirect'>";
		echo "\n<INPUT NAME='$id_objet' TYPE=Hidden VALUE='$id'>";
		echo "\n<INPUT NAME='hash_id_auteur' TYPE=Hidden VALUE='$connect_id_auteur'>";
		echo "\n<INPUT NAME='hash' TYPE=Hidden VALUE='$hash'>";
		echo "\n<INPUT NAME='ajout_logo' TYPE=Hidden VALUE='oui'>";
		echo "\n<INPUT NAME='logo' TYPE=Hidden VALUE='$racine'>";
		if (tester_upload()){
			echo "\n"._T('info_telecharger_nouveau_logo')."<BR>";
			echo "\n<INPUT NAME='image' TYPE=File CLASS='forml' style='font-size:9px;' SIZE=15>";
			echo "\n <div align='right'><INPUT NAME='ok' TYPE=Submit VALUE='"._T('bouton_telecharger')."' CLASS='fondo' style='font-size:9px;'></div>";
		} else {

			$myDir = opendir(_DIR_TRANSFERT);
			while($entryName = readdir($myDir)){
				if (!ereg("^\.",$entryName) AND eregi("(gif|jpg|png)$",$entryName)){
					$entryName = addslashes($entryName);
					$afficher .= "\n<OPTION VALUE='" .
						_DIR_TRANSFERT .
						"$entryName'>$entryName";
				}
			}
			closedir($myDir);

			if (strlen($afficher) > 10){
				echo "\n"._T('info_selectionner_fichier_2');
				echo "\n<SELECT NAME='image' CLASS='forml' SIZE=1>";
				echo $afficher;
				echo "\n</SELECT>";
				echo "\n  <INPUT NAME='ok' TYPE=Submit VALUE='"._T('bouton_choisir')."' CLASS='fondo'>";
			} else {
				echo _T('info_installer_images_dossier');
			}

		}
		echo fin_block();
		echo "</FORM>\n";
	}

	echo "</font>";
}	
	
	
	afficher_boite_logo_bloog('aut', 'id_auteur', $id_auteur_session,
	'Logo','' );

?>
		