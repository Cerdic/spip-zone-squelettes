<?php
if (!defined('_ECRIRE_INC_VERSION')) return;

function formulaires_spipr_educ_envoi_fichier_fond_charger_dist($nom_dir) {
	$valeurs = array ();
	return $valeurs;
}

function formulaires_spipr_educ_envoi_fichier_fond_traiter_dist($nom_dir) {
	$nom = _request('envoifichier', $_FILES);
	if	(!empty(_request('envoifichier', $_FILES)['tmp_name'])
	AND is_uploaded_file(_request('envoifichier', $_FILES)['tmp_name']))
	{
		
		if (filesize(_request('envoifichier', $_FILES)['tmp_name'])>2000000) {
			$res['message_erreur'] = "Le poids du fichier est trop important pour une image de fond, il doit peser moins de 2 Mo. Il n'a pas été envoyé sur le serveur.";
		}
		else {
			$origine  = array(' ','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','¯','à','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','©','£','ò','ó','ô','õ','ö','ù','ú','û','ü','~','ÿ');
			$souhaite= array('_','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','O','O','O','O','O','U','U','U','U','Y','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o','o','o','u','u','u','u','y','y','y');
			$nom_fichier_propre = str_replace($origine, $souhaite, _request('envoifichier', $_FILES)['name']);
			list($largeur, $hauteur, $type, $attr)=getimagesize(_request('envoifichier', $_FILES)['tmp_name']);
			if (($type===1) OR ($type===2) OR ($type===3)) {
				if(!move_uploaded_file(_request('envoifichier', $_FILES)['tmp_name'], _DIR_IMG.$nom_dir.'/'.$nom_fichier_propre)) {
					$res['message_erreur'] = "Erreur lors de l'envoi du fichier. Il n'a pas été téléchargé sur le serveur.";
				}
				else {
					$res['message_ok'] = "Le fichier ".$nom_fichier_propre." a bien été envoyé sur le serveur.";
					echo "<script type='text/javascript'>if (window.jQuery) ajaxReload('config_fichier_fond');</script>";
				}
			}
			else {
				$res['message_erreur'] = "Seuls les fichiers au format png, jpg et gif sont acceptés.";
			}
		}
	}
	return $res;
}
?>