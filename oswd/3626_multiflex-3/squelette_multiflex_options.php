<?php
/*
 * Quelques notations que vous pouvez utiliser dans
 * votre fichier mes_options.php
 * 
 * Enlever le # pour decommenter la ligne
 */

// ID des webmasters, habilités à executer des taches administratives
// sans vérification de l'identité par FTP
// Ici, auteurs 1 et 2
# define('_ID_WEBMESTRES', '1:2');

// Supprimer les numeros sur les titres
# $GLOBALS['table_des_traitements']['TITRE'][]= 'typo(supprimer_numero(%s))';
?>
