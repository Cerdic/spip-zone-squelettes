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

?>