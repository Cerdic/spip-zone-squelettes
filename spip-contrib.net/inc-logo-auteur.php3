
                
				<?php 
				 
				 
			 			
			if (file_exists("IMG/auton$id_auteur.gif"))	$logo = "auton$id_auteur.gif"; 
			else if (file_exists("IMG/auton$id_auteur.jpg")) $logo = "auton$id_auteur.jpg"; 
			else if (file_exists("IMG/auton$id_auteur.png")) $logo = "auton$id_auteur.png";  

$racine = "auton$id_auteur";
			
$redirect = "" ;			
$redirect = $clean_link->getUrl();

if ($recalcul == 'oui' ) $redirect = "../$redirect" ; else $redirect = "../$redirect&recalcul=oui" ;



	if ($logo) {
		
		// contrer le cache du navigateur
		if ($fid = @filesize("IMG/$logo") . @filemtime("IMG/$logo")) {
			$fid = "?".md5($fid);
		}
		$result = array($fichier, $taille, $fid);
	}
	

					
			if ($logo) {
		$hash = calculer_action_auteur("supp_image $logo");



		echo "<P><CENTER><IMG SRC='IMG/$logo'>";

		
		echo "$taille_txt\n";
		echo "<BR>[<A HREF='spip_image.php3?";
		echo "id_auteur=$id_auteur&image_supp=$logo&hash_id_auteur=$connect_id_auteur&hash=$hash&redirect=$redirect'>"._T('lien_supprimer')."</A>]";
		
		echo "</CENTER>";
	}
	else {
		$hash = calculer_action_auteur("ajout_image $racine");
		

		
		echo "\n\n<FORM ACTION='spip_image.php3' METHOD='POST' ENCTYPE='multipart/form-data'>";
		echo "\n<INPUT NAME='redirect' TYPE=Hidden VALUE='$redirect'>";
		if ($id_auteur > 0) echo "\n<INPUT NAME='id_auteur' TYPE=Hidden VALUE='$id_auteur'>";
		
		echo "\n<INPUT NAME='hash_id_auteur' TYPE=Hidden VALUE='$connect_id_auteur'>";
		echo "\n<INPUT NAME='hash' TYPE=Hidden VALUE='$hash'>";
		echo "\n<INPUT NAME='ajout_logo' TYPE=Hidden VALUE='oui'>";
		echo "\n<INPUT NAME='logo' TYPE=Hidden VALUE='$racine'>";
		if (tester_upload()){
			echo "\n"._T('info_telecharger_nouveau_logo')."<BR>";
			echo "\n<INPUT NAME='image' TYPE=File CLASS='forml' style='font-size:9px;' SIZE=15>";
			echo "\n <div align='right'><INPUT NAME='ok' TYPE=Submit VALUE='"._T('bouton_telecharger')."' CLASS='fondo' style='font-size:9px;'></div>";
		} else {

			$myDir = opendir("upload");
			while($entryName = readdir($myDir)){
				if (!ereg("^\.",$entryName) AND eregi("(gif|jpg|png)$",$entryName)){
					$entryName = addslashes($entryName);
					$afficher .= "\n<OPTION VALUE='ecrire/upload/$entryName'>$entryName";
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
		
		echo "</FORM>\n";
    }
			?>
             
