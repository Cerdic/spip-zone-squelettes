<?php

# economiser du cache en n'acceptant qu'un HTTP_HOST
if ($_SERVER['REQUEST_METHOD'] == 'GET'
AND $_SERVER['HTTP_HOST'] == 'spip-contrib.net') {
	@header('Location: http://www.spip-contrib.net'.$_SERVER['REQUEST_URI']);
}

# faire comme si les brouteurs n'acceptaient pas l'ajax
# de maniere a debrayer le (trop lourd) selecteur de rubriques
if (!_DIR_RESTREINT) $_COOKIE['spip_accepte_ajax'] = -1;

//
// *** Parametrage par defaut de SPIP ***
//
// Ces parametres d'ordre technique peuvent etre modifies
// dans ecrire/mes_options (_FILE_OPTIONS) Les valeurs
// specifiees dans ce dernier fichier remplaceront automatiquement
// les valeurs ci-dessous.
//
// Pour creer ecrire/mes_options : recopier simplement
// les lignes ci-dessous, et ajouter le marquage de debut et
// de fin de fichier PHP ("< ?php" et "? >", sans les espaces)
//

// Prefixe des tables dans la base de donnees
// (a modifier pour avoir plusieurs sites SPIP dans une seule base)
$table_prefix = "spip";

// Prefixe et chemin des cookies
// (a modifier pour installer des sites SPIP dans des sous-repertoires)
$cookie_prefix = "contrib";
$cookie_path = "";

// Dossier des squelettes
// (a modifier si l'on veut passer rapidement d'un jeu de squelettes a un autre)
$dossier_squelettes = "squelettes";

// faut-il autoriser SPIP a compresser les pages a la volee quand le
// navigateur l'accepte (valable pour apache >= 1.3 seulement) ?
$auto_compress = true; // http://developer.yahoo.com/performance/rules.html#gzip

// Type d'URLs
// 'page': spip.php?article123 [c'est la valeur par defaut pour SPIP 1.9]
// 'html': article123.html
// 'propres': Titre-de-l-article <http://lab.spip.net/spikini/UrlsPropres>
// 'propres2' : Titre-de-l-article.html (base sur 'propres')
// 'standard': article.php3?id_article=123 [urls SPIP < 1.9]
// $type_urls = 'propres';

// creation des vignettes avec image magick en ligne de commande : mettre
// le chemin complet '/bin/convert' (Linux) ou '/sw/bin/convert' (fink/Mac OS X)
// Note : preferer GD2 ou le module php imagick s'ils sont disponibles
$convert_command = 'convert';

// creation des vignettes avec pnmscale
// Note: plus facile a installer par FTP,
// voir http://gallery.menalto.com/modules.php?op=modload&name=GalleryFAQ&file=index&myfaq=yes&id_cat=2#43
$pnmscale_command = 'pnmscale';

// faut-il passer les connexions MySQL en mode debug ?
$mysql_debug = false;

// faut-il chronometrer les requetes MySQL ?
$mysql_profile = false;

// faut-il faire des connexions completes rappelant le nom du serveur et/ou de
// la base MySQL ? (utile si vos squelettes appellent d'autres bases MySQL)
// (A desactiver en cas de soucis de connexion chez certains hebergeurs)
// Note: un test a l'installation peut aussi avoir desactive
// $mysql_rappel_nom_base directement dans le fichier inc_connect
$mysql_rappel_connexion = true;
$mysql_rappel_nom_base = true;

// faut-il afficher en rouge les chaines non traduites ?
$test_i18n = false;

// gestion des extras (voir inc_extra pour plus d'informations)
$champs_extra = false;
$champs_extra_proposes = false;

// faut-il ignorer l'authentification par auth http/remote_user ?
$ignore_auth_http = false;
$ignore_remote_user = true; # methode obsolete et risquee

// Faut-il "invalider" les caches quand on depublie ou modifie un article ?
# NB: cette option ne concerne pas les forums et petitions qui sont toujours
# invalidants. (fonctionnalite experimentale : decommenter ci-dessous)
#$invalider_caches = 'id_article,id_breve,id_rubrique,id_syndic';
$invalider_caches = '';

// Quota : la variable $quota_cache, si elle est > 0, indique la taille
// totale maximale desiree des fichiers contenus dans le CACHE/ ;
// ce quota n'est pas "dur", il ne s'applique qu'une fois par heure et
// fait redescendre le cache a la taille voulue ; valeur en Mo
// Si la variable vaut 0 aucun quota ne s'applique
$quota_cache = 150;

$table_des_traitements['TITRE'][]= 'typo(supprimer_numero(%s))';


// 	*** Fin du paramtrage ***

/***
 * limitations sauvegardes sur certaines tables
 * pour eviter blocage dump
 * patch rapide cedric 06-12-18 via irc et nicolasr
 ***/
$GLOBALS['EXPORT_tables_noexport']= array(
'spip_ajax_fonc',
'spip_caches',
'spip_meta',
'spip_index',
'spip_index_dico',
'spip_recherches',
'spip_referers',
'spip_referers_articles',
'spip_ortho_cache',
'spip_ortho_dico',
#'spip_versions',
#'spip_versions_fragments',
#'spip_visites',
#'spip_visites_articles',
);



// {doublons} ou {unique}
// attention: boucle->doublons designe une variable qu'on affecte
function critere_doublons_trad_dist($idb, &$boucles, $crit) {
	$boucle = &$boucles[$idb];
	$nom = !isset($crit->param[0]) ? "''" : calculer_liste($crit->param[0], array(), $boucles, $boucles[$idb]->id_parent);
	// mettre un tableau pour que ce ne soit pas vu comme une constante
	$boucle->where[]= array("sql_in('".$boucle->id_table . '.id_trad' .
	  "', " .
	  '"-1".$doublons[' .
	  "('" .
	  $boucle->type_requete . 
	  "'" .
	  ($nom == "''" ? '' : " . $nom") .
	  ')], \'' . 
	  ($crit->not ? '' : 'NOT') .
				"')");
}



###################
# Gestion du wiki #
###################
# avertit qu'on va retirer les articles de ce secteur des boucles standard
define('SECTEURS_WIKI', '607');
# la suite est geree par le plugin "Autorite"


###################
# parametrages pour "Autorité" #
###################
# defini les "webmestres" au sens de Autorite
define('_ID_WEBMESTRES', '1:4:198:589:5384');

###################
# parametrage pour "urls_libres" #
###################
# en association avec le htaccess adequat (cf les notes du plugin xml)
# choix de l'oprion sans le "?"
define ('_debut_urls_propres', '') ;

?>
