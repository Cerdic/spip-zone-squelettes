<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function action_telecharger() {
	$force_dl = false;

	if (isset($_SERVER['REDIRECT_url_fichier']))
		$url_fichier = $_SERVER['REDIRECT_url_fichier'];
	elseif (isset($_ENV['url_fichier']))
		$url_fichier = $_ENV['url_fichier'];

	$row = sql_fetsel(
		array('id_document', 'date'),
		array('spip_documents'),
		array('fichier="'.$url_fichier.'"')
	);
	if($row) {
		if($row['date']<date('Y-m-d H:i:s')) {
			//ajouter un dl au compteur
			//ici +1 pour l'article associe
			$GLOBALS['id_article'] = sql_getfetsel(
				'id_article',
				array('spip_documents_articles'),
				array('id_document='.$row['id_document'])
			);
			$stats = charger_fonction('stats', 'public');
			$stats();
			//telecharger
			$fichier_pdf = _DIR_IMG . $url_fichier;
			if($force_dl) {
				header("Content-type: application/force-download;");
				header("Content-Transfer-Encoding: application/pdf");
				header("Content-Disposition: attachment; filename=\"".basename($fichier_pdf)."\"");
				header("Pragma: no-cache");
				header("Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0, public");
				header("Expires: 0");
			} else {
				header("Content-Type: application/pdf");
			}
			header("Content-Length: ".filesize($fichier_pdf));
			readfile($fichier_pdf);
		}
		else {
			//Not Found
		}
	}
	exit;			
}

?>