<?php
/**
 * Plugin Mediaspip Core
 * 
 * © 2010-2011 kent1 (kent1@arscenic.info)
 * Distribué sous licence GNU/GPL v3
 * 
 */
if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/headers');

/**
 * Forcer le téléchargement de documents
 * verifie soit que le demandeur est authentifie
 * soit que le document est publie, c'est-a-dire
 * joint a au moins 1 article, breve ou rubrique publie
 *
 * Action fortement pompée sur acceder_document du core
 * http://code.spip.net/@action_acceder_document_dist
 *
 * @return
 */
function action_ms_forcer_telecharger_dist() {
	include_spip('inc/documents');

	// $file exige pour eviter le scan id_document par id_document
	$f = rawurldecode(_request('file'));
	$f = str_replace('IMG/','',$f);
	$file = get_spip_doc($f);
	$arg = rawurldecode(_request('arg'));

	if(strpos($f,_DIR_SITE)!== false){
		$f_loc = str_replace(_DIR_SITE,'',$f);
		$file = get_spip_doc($f_loc);
	}

	$status = $dcc = false;
	if (strpos($f,'../') !== false
	OR preg_match(',^\w+://,', $f)) {
		$status = 403;
	}
	else if (!file_exists($file)
		OR !is_readable($file)
		OR (lire_config('mediaspip/squelettes/autoriser_telecharger','') != 'on')
		OR (!$GLOBALS['visiteur_session']['id_auteur']
			&& (lire_config('mediaspip/squelettes/autoriser_telecharger_que_logues','') == 'on'))
		) {
		$status = 404;
	} else {
		$where = "documents.fichier=".sql_quote(set_spip_doc($file))
		. ($arg ? " AND documents.id_document=".intval($arg): '');

		$doc = sql_fetsel("documents.id_document, documents.titre, documents.fichier, documents.id_orig, types.mime_type, types.inclus, documents.extension", "spip_documents AS documents LEFT JOIN spip_types_documents AS types ON documents.extension=types.extension",$where);
		if (!$doc
			OR ((lire_config('mediaspip/squelettes/autoriser_telecharger_original','off') != 'on')
				&& ($doc['id_orig'] == 0))
		){
			$where = "doc2img.fichier=".sql_quote(set_spip_doc($file))
			. ($arg ? " AND doc2img.id_doc2img=".intval($arg): '');
			
			$doc = sql_fetsel("doc2img.id_doc2img, doc2img.fichier", "spip_doc2img AS doc2img",$where);

			if (!$doc){
				$status = 404;
			}
		} else {

			// ETag pour gerer le status 304
			$ETag = md5($file . ': '. filemtime($file));
			if (isset($_SERVER['HTTP_IF_NONE_MATCH'])
			AND $_SERVER['HTTP_IF_NONE_MATCH'] == $ETag) {
				http_status(304); // Not modified
				exit;
			} else {
				header('ETag: '.$ETag);
			}
		}
	}

	switch($status) {

	case 403:
		include_spip('inc/minipres');
		echo minipres();
		break;

	case 404:
		http_status(404);
		include_spip('inc/minipres');
		echo minipres(_T('erreur').' 404',
			_T('info_document_indisponible'));
		break;

	default:
		$journal = charger_fonction('journal','inc',true);
		if($journal && is_numeric($arg)){
			$qui = $GLOBALS['visiteur_session']['nom'] ? $GLOBALS['visiteur_session']['nom'] : $GLOBALS['ip'];
			$qui_ou_ip = $GLOBALS['visiteur_session']['id_auteur'] ? $GLOBALS['visiteur_session']['id_auteur'] : $GLOBALS['ip'];
			$quoi = 'document';
			$faire = 'telecharger';
			$texte_infos = array('qui'=>$qui,'type'=> $quoi,'id'=>$arg);

			$journal(
				_T('mediaspip_core:journal_telecharger_document',$texte_infos),
				array('qui' => $qui_ou_ip,'faire' => $faire,'quoi' => $quoi,'id' => $arg)
			);
		}

		if($doc['mime_type'])
			header("Content-Type: ". $doc['mime_type']);

		$f = basename($file);
		// ce content-type est necessaire pour eviter des corruptions de zip dans ie6
		//header('Content-Type: application/octet-stream');

		header("Content-Disposition: attachment; filename=\"$f\";");
		//header("Content-Transfer-Encoding: binary");

		// fix for IE catching or PHP bug issue
		//header("Pragma: public");
		//header("Expires: 0"); // set expiration time
		//header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

		if ($cl = filesize($file)){
			header("Content-Length: ". $cl);
		}

		readfile($file);
		break;
	}

}

?>
