<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

function urls_generer_url_forum($id_forum, $args='', $ancre='') {
	$url = '';

	if ($id_forum = intval($id_forum)) {
		if ($post = sql_fetsel('*', 'spip_forum', 'id_forum=' . sql_quote($id_forum))) {
			if ($post['objet'] == 'article') {
				include_spip('inc/config');
				$secteur_forum = lire_config('sarkaspip_forum/rubrique_forum');
				$secteur_galerie = lire_config('sarkaspip_galerie/rubrique_galerie');
				$id_secteur = sql_getfetsel('id_secteur', 'spip_articles', 'id_article=' . sql_quote($post['id_objet']));
				if ($secteur_forum	AND $id_secteur) {
					include_spip('inc/utils');
					$arguments = array();
					if ($id_secteur == $secteur_forum) {
						$page = 'forum';
						$arguments = array('id_article' => intval($post['id_objet']), 'id_forum' => intval($post['id_thread']));
					}
					elseif ($id_secteur == $secteur_galerie) {
						$page = 'album';
						$arguments = array('id_article' => intval($post['id_objet']));
					}
					if ($arguments) {
						if ($args)
							$arguments = is_array($args) ? array_merge($arguments, $args) : $arguments;
						$url = generer_url_public($page, $arguments)
							 . "#forum$id_forum";
					}
				}
			}
		}

		// Traitement standard des urls de forum
		if (!$url) {
			include_spip('inc/forum');
			list($type, $id,) = racine_forum($id_forum);
			if ($type) {
				if (!$ancre) $ancre = "forum$id_forum";
				$url = generer_url_entite($id, $type, $args, $ancre, true);
			}
		}
	}

	return $url;
}

?>