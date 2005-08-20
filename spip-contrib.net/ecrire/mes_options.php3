<?php

# economiser du cache en n'acceptant qu'un HTTP_HOST
if ($_SERVER['REQUEST_METHOD'] == 'GET'
AND $_SERVER['HTTP_HOST'] == 'spip-contrib.net') {
	@header('Location: http://www.spip-contrib.net'.$_SERVER['REQUEST_URI']);
}

if( !@file_exists(_DIR_RESTREINT_ABS . 'inc_version.php3')) {
  include('../plug_smileys.php');
} else {
  include('plug_smileys.php');
}

// elle est deja déclarée dans spikini/formaters/waka.php il y a collision ...on se passe des smileys pour l'instant 
//function avant_propre($texte) {
//  $texte = smileys($texte);
//  return $texte;
//}

$type_urls = "propres";

//
// 	*** Parametrage par defaut de SPIP ***
//
// Ces parametres d'ordre technique peuvent etre modifies
// dans ecrire/mes_options.php3. Les valeurs specifiees
// dans ce dernier fichier remplaceront automatiquement
// les valeurs ci-dessous.
//
// Pour creer ecrire/mes_options.php3 : recopier simplement
// les lignes ci-dessous, et ajouter le marquage de debut et
// de fin de fichier PHP ("< ?php" et "? >", sans les espaces)
//

// Prefixe des tables dans la base de donnees
// (a modifier pour avoir plusieurs sites SPIP dans une seule base)
$table_prefix = "spip";

// Prefixe des cookies
// (a modifier pour installer des sites SPIP dans des sous-repertoires)
$cookie_prefix = "contrib";

// Dossier des squelettes
// (a modifier si l'on veut passer rapidement d'un jeu de squelettes a un autre)
$dossier_squelettes = "";

// faut-il autoriser SPIP a compresser les pages a la volee quand le
// navigateur l'accepte (valable pour apache 1.3 seulement) ?
$auto_compress = false; // bcp plus rapide sur ouvaton, et moins buggue

// faut-il loger les infos de debug dans data/spip.log ?  (peu utilise)
$debug = false;

// faut-il passer les connexions MySQL en mode debug ?
$mysql_debug = false;

// faut-il chronometrer les requetes MySQL ?
$mysql_profile = false;

// faut-il faire des connexions completes rappelant le nom du serveur et de
// la base MySQL ? (utile si vos squelettes appellent d'autres bases MySQL)
$mysql_rappel_connexion = false;

// faut-il afficher en rouge les chaines non traduites ?
$test_i18n = false;

// afficher les boutons de debug ?
$bouton_admin_debug = true;

$quota_cache=100 ; 
//
// Definition de tous les extras possibles
//


	$GLOBALS['champs_extra'] = Array (
		'auteurs' => Array (
				"avatar" =>"ligne|propre|Entrer l'URL de votre avatar",
				
			)

		);
		
		$GLOBALS['champs_extra_proposes'] = Array (
'auteurs' => Array (
		'tous' => '',
		'6forum' => 'avatar'
                )
);



$champs_extra = true;
// 	*** Fin du paramtrage ***
//

// Tidy
//define('_TIDY_COMMAND', '/data/www/s/p/ip-contrib.net/cgi-bin/tidy');
#define('_TIDY_COMMAND', 'tidy');
//$xhtml = true; /*seulement dans article.php3 pour le moment */


?>
