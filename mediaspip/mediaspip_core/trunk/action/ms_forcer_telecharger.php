<?php
/**
 * Plugin Mediaspip Core
 * 
 * Auteurs :
 * kent1 (http://www.kent1.info - kent1@arscenic.info)
 *
 * © 2010-2012 - Distribue sous licence GNU/GPL
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
 * http://doc.spip.org/@action_acceder_document_dist
 *
 * @return
 */
function action_ms_forcer_telecharger_dist() {
	include_spip('inc/documents');
	include_spip('inc/config');

	// $file exige pour eviter le scan id_document par id_document
	$f = rawurldecode(_request('file'));
	$f = str_replace('IMG/','',$f);
	if(!$f){
		$securiser_action = charger_fonction('securiser_action', 'inc');
		$arg = $securiser_action();
		$f = sql_getfetsel('fichier','spip_documents','id_document='.intval($arg));
	}
		
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
		OR (lire_config('mediaspip/squelettes/autoriser_telecharger') != 'on')
		OR (!isset($GLOBALS['visiteur_session']['id_auteur'])
			&& (lire_config('mediaspip/squelettes/autoriser_telecharger_que_logues','') == 'on'))
		)
	{
		$status = 404;
	} else {
		$where = "documents.fichier=".sql_quote(set_spip_doc($file))
		. ($arg ? " AND documents.id_document=".intval($arg): '');

		$doc = sql_fetsel("documents.id_document, documents.titre,documents.mode, documents.fichier, types.mime_type, types.inclus, documents.extension", "spip_documents AS documents LEFT JOIN spip_types_documents AS types ON documents.extension=types.extension",$where);
		if (!$doc
			OR (!in_array('original',lire_config('mediaspip/squelettes/telecharger_types',array()))
				&& (in_array($doc['mode'],array('document','image')) == 0))
		){
			$status = 404;
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
			_T('medias:info_document_indisponible'));
		break;

	default:
		$journal = charger_fonction('journal','inc',true);
		if($journal && is_numeric($arg)){
			$qui = isset($GLOBALS['visiteur_session']['nom']) ? $GLOBALS['visiteur_session']['nom'] : $GLOBALS['ip'];
			$qui_ou_ip = isset($GLOBALS['visiteur_session']['id_auteur']) ? $GLOBALS['visiteur_session']['id_auteur'] : $GLOBALS['ip'];
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