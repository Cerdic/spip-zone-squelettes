<?php
//modifiez ici les dossiers squelettes dans l'ordre souhaité
$dossier_squelettes="squelettes:squelettesforum";
//permet de se passer du filtre supprimer_numero ecriture des titres 22. untitre
$table_des_traitements['TITRE'][]= 'supprimer_numero(typo(%s))';
?>