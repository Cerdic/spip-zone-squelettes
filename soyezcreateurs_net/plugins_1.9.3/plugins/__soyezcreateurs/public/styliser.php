<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2008                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/


if (!defined("_ECRIRE_INC_VERSION")) return;

// Ce fichier doit imperativement definir la fonction ci-dessous:

// Actuellement tous les squelettes se terminent par .html
// pour des raisons historiques, ce qui est trompeur

// http://doc.spip.org/@public_styliser_dist
function public_styliser_dist($fond, $id_rubrique, $lang='', $connect='', $ext='html') {
	
  // html est une extension permise pour gérer le cas fichier.css.html
  $extension_squelette_permises = array ('css', 'js', 'svg', 'xml', 'htc', 'html', 'spip'); 
  $extension_spip = $ext;
	// Si $fond a une extension parmi .css, .js .svg, .xml, .htc, .spip
	// la prendre dans $ext et ramener $fond au nom prive de l'extension
	// Sinon, considérer que l'extension est html

	$ext = substr(strrchr($fond, '.'), 1);
  	if (in_array ($ext, $extension_squelette_permises)) {
		$fond = substr($fond, 0, - strlen($ext) - 1); 
	} else {
		// Actuellement tous les squelettes se terminent par .html
		// pour des raisons historiques, ce qui est trompeur
		$ext = $extension_spip;
	}
	
	// Trouver un squelette de base dans le chemin
	// Commencer par chercher avec l'extension SPIP (au cas où un squelette .js.html inclue un .js placé au même endroit)
	if (!$base = find_in_path("$fond.$ext.$extension_spip")) {
		if (!$base = find_in_path("$fond.$ext")) {
		// Si pas de squelette regarder si c'est une table
		$trouver_table = charger_fonction('trouver_table', 'base');
		if (preg_match('/^table:(.*)$/', $fond, $r)
		AND $table = $trouver_table($r[1], $connect)
		AND include_spip('inc/autoriser')
		AND autoriser('webmestre')
		) {
				$fond = $r[1];
				$base = _DIR_TMP . 'table_'.$fond . ".$ext";
				if (!file_exists($base)
				OR  $GLOBALS['var_mode']) {
					$vertebrer = charger_fonction('vertebrer', 'public');
					ecrire_fichier($base, $vertebrer($table));
				}
		} else { // on est gentil, mais la ...
			include_spip('public/debug');
			erreur_squelette(_T('info_erreur_squelette2',
				array('fichier'=>"'$fond'")),
				$GLOBALS['dossier_squelettes']);
			$f = find_in_path(".$ext"); // on ne renvoie rien ici, c'est le resultat vide qui provoquere un 404 si necessaire
			return array(substr($f, 0, -strlen(".$extension_spip")),
					 $extension_spip,
					 $extension_spip,
					 $f);
		}
}
	} else {
		$ext = $extension_spip;
	}

	// supprimer l'extension pour pouvoir affiner par id_rubrique ou par langue
	$squelette = substr($base, 0, - strlen(".$ext"));

	// On selectionne, dans l'ordre :
	// fond=10
	if ($id_rubrique) {
		$f = "$squelette=$id_rubrique";
		if (@file_exists("$f.$ext"))
			$squelette = $f;
	else {
		// fond-10 fond-<rubriques parentes>
			do {
				$f = "$squelette-$id_rubrique";
				if (@file_exists("$f.$ext")) {
					$squelette = $f;
				break;
			}
			} while ($id_rubrique = quete_parent($id_rubrique));
		}
	}

	// Affiner par lang
	if ($lang) {
		$l = lang_select($lang);
		$f = "$squelette.".$GLOBALS['spip_lang'];
		if ($l) lang_select();
		if (@file_exists("$f.$ext"))
			$squelette = $f;
	}

	return array($squelette, $ext, $extension_spip, "$squelette.$ext");
}
?>
