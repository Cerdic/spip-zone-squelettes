<?php

$fond = "sidebar";
$delai = 2 * 3600;

$contexte_inclus['annee'] = annee($contexte_inclus['date']);
$contexte_inclus['mois'] = mois($contexte_inclus['date']);

include('inc-public.php3');

?>
