<?php

$GLOBALS['toujours_paragrapher'] = true;
// $GLOBALS['debut_intertitre'] = "\n<h2 class=\"spip\">\n";
// $GLOBALS['fin_intertitre'] = "</h2>\n";
// $GLOBALS['puce'] = '- ';
$GLOBALS['table_des_traitements']['TITRE'][]= 'supprimer_numero(typo(%s))';

// Gravatar
function gravatar_url($email = '')
{
   if ($email != '') {
       return 'http://www.gravatar.com/avatar.php?gravatar_id='.md5($email).'&amp;size=42&amp;rating=PG';
   } else {
       return '';
   }
}

// ajouter un <title> si la page n'en a pas
function titrer_page($page) {
  if (!strpos('<title', $page)) {
    $title = supprimer_tags(
      (preg_match(',<(h1).*</\1>,Ums', $page, $r)
        ? $r[0].' | ' : '')
        . $GLOBALS['meta']['nom_site']
      );
    $page = str_replace('</head>', '<title>'.$title.'</title></head>', $page);
  }
  return $page;
}

?>