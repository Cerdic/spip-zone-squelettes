<?php


if ($ce=="si") {  // comprueba que el esqueleto existe en la carpeta "esqueletos"

// Funci—n para purgar la cache y que todo el sitio funcione con el nuevo esqueleto 
// si se produce un cambio
// de 3615MARLENE (http://marlene.c3ew.com/article.php?id_article=18)

function purge($dir, $age='ignore', $regexp = '') { 
	$handle = @opendir($dir);
	if (!$handle) return;

	while (($fichier = @readdir($handle)) != '') {
 	// Eviter ".", "..", ".htaccess", etc.
		if ($fichier[0] == '.') continue;
		if ($regexp AND !ereg($regexp, $fichier)) continue;
		$chemin = "$dir/$fichier";
		if (is_file($chemin))
			@unlink($chemin);
		else if (is_dir($chemin))
			if ($fichier != 'CVS')
				purge($chemin);
	}
	closedir($handle);
}

// Guarda en una cookie el esqueleto seleccionado por un a–o o lo utiliza si existe
// Comprueba qu exista y si no deja el "por_defecto"

if (isset($esqueleto)) {
 	purge(CACHE, 0);     // vaciar la cache
	$dossier_squelettes = "esqueletos/".$esqueleto;
	setcookie("esqueleto_selec","$esqueleto",time()+365*24*3600);
}

}

elseif(isset($HTTP_COOKIE_VARS['esqueleto_selec'])) {
	$dossier_squelettes="esqueletos/".$HTTP_COOKIE_VARS['esqueleto_selec'];
}

else {
$dossier_squelettes = "esqueletos/por_defecto";
}

// Si sigue sin haber esqueleto seleccionado coge esqueletos/por_defecto como esqueleto

if ($dossier_squelettes=="" ) {
$dossier_squelettes = "esqueletos/por_defecto";
}

?>
