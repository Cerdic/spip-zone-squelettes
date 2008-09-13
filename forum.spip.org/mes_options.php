<?php

// Pour tester : envoi des mails sur les threads
// cf. inc/notifications.php
define('_SUIVI_FORUM_THREAD', true);

include _DIR_RACINE . 'forum.spip.org/urls/trad.php';
include( _DIR_RESTREINT . 'inc/vieilles_defs.php');

  // URLs de la forme /fr_article1.html (inspire de www.spip.net)
$type_urls='trad';

  // Dossier des squelettes (SVN)
$dossier_squelettes='forum.spip.org';

  // integrer le systeme de vote
$z = _DIR_RACINE.$dossier_squelettes.'/vote.php';

if (is_readable($z))  include_once($z);

  // Ajouter la barre typo speciale (<code> et <cadre>)
$barre_typo = 'forumspiporg';

// augmenter le cache
$quota_cache = 30;

?>
