<?php

// Pour tester : envoi des mails sur les threads
// cf. inc/notifications.php
define('_SUIVI_FORUM_THREAD', true);

include_spip('inc/vieilles_defs');

  // URLs de la forme /fr_article1.html (inspire de www.spip.net)
  $type_urls='trad';

  // Dossier des squelettes (SVN)
  $dossier_squelettes='forum.spip.org';

  // integrer le systeme de vote
  include_once(_DIR_RACINE.$dossier_squelettes.'/vote.php');

  // Ajouter la barre typo speciale (<code> et <cadre>)
  $barre_typo = 'forumspiporg';

?>
