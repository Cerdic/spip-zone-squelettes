<?php

if ($ce=="si") {
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

if (isset($esqueleto) and ($esqueleto!=$dossier_squelettes)) {
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

// Si  no hay esqueleto seleccionado coge esqueletos/por_defecto como esqueleto

if ($dossier_squelettes=="" ) {
$dossier_squelettes = "esqueletos/por_defecto";
}

//
// Definition de tous les extras possibles
//

echo $comprobar_esqueleto;

$champs_extra = true;

	$GLOBALS['champs_extra'] = Array (
		'auteurs' => Array (
				"abo" => "radio|brut|Opciones|Html,Texto,Darse de baja|html,texte,non"

			),
			
		'articles' => Array (
				'squelette' => 'bloc|propre|Bibliographie'

			)

		);
		
		$GLOBALS['champs_extra_proposes'] = Array (
'auteurs' => Array (
		'tous' => 'abo',
		'inscription' => 'abo'
	        ),
'articles' => Array (
		'0' => 'squelette',
		'tous' => ''
		
                )
				
);


include('options_spip_listes.php3');


?>
