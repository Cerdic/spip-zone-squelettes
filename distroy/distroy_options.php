<?php

// Masquer les numeros de titre
$GLOBALS['table_des_traitements']['TITRE'][] = 'typo(supprimer_numero(%s))';
$table_des_traitements['NOM'][]= 'supprimer_numero(typo(%s))';

?>