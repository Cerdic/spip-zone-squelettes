<?php
  if ($rss) {
    $fond = 'sedna-rss';
    $flag_preserver=true;
  } else
    $fond='sedna';

  // critere {contenu}
  function critere_contenu($idb, &$boucles, $crit) {
    $boucle = &$boucles[$idb];

    $boucle->hash =  '
    // RECHERCHE
    if ($r = addslashes($GLOBALS["recherche"])) $s="(syndic_articles.descriptif LIKE \'%$r%\'
      OR syndic_articles.titre LIKE \'%$r%\'
      OR syndic_articles.url LIKE \'%$r%\'
      OR syndic_articles.lesauteurs LIKE \'%$r%\')";
      else $s=1;
    
    ';

    // un peu trop rapide, ca... le compilateur exige mieux
    $boucle->where[] = '$s';
  }

  // unicode 24D0 = caractere de forme "(a)"
  function antispam2($texte) {
    return preg_replace(',(\w+)@(\w+\.\w+),','\\1&#x24d0;\\2', $texte);
  }
  
  include('ecrire/inc_version.php3');
  if ($id = intval($refresh)) {
    include_ecrire('inc_sites.php3');
    syndic_a_jour($id);
  }

  $delais=0;
  include('inc-public.php3');
?>