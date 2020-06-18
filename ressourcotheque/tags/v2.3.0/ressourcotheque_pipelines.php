<?php
if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/**
 * Pipeline pour choisir quels champs sont vérifier par linkcheck
 * @param array $flux paramètres d'entrée
 * @return array $flux
**/
function ressourcotheque_linkcheck_champs_a_traiter($flux) {
	if ($flux['args']['table'] == 'articles') {
		unset ($flux['data']['contenu_documents']);
	}
	return $flux;
}

/**
 * Pipeline pour afficher si le document est une source dans l'espace privé
 * @param array $flux
 * @return array $flux modifié
 **/
function ressourcotheque_afficher_metas_document($flux) {
	if ($flux['args']['quoi'] !== 'document_desc') {
		return $flux;
	}
	$source = sql_getfetsel('source', 'spip_documents', 'id_document='.$flux['args']['id_document']);
	if ($source) {
		$td = _T('ressourcotheque:document_source');
	} else {
		$td = _T('ressourcotheque:document_non_source');
	}
	$th = _T('ressourcotheque:source');
	$flux['data'] = str_replace('</table>',"<tr><th>$th</th><td>$td</td></tr></table>", $flux['data']);
	static $toggle;
	if (!$toggle) {
		$flux['data'] .= '<script type="text/javascript">$().ready(function() {
			$(".detaillees").toggle();
			});
		</script>';
		$toggle = true;
	}
	;
	return $flux;
}
