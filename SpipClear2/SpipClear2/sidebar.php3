<?php

$fond = "sidebar";
$delai = 2 * 3600;

if(preg_match("/^([0-9]{4})-([0-9]{1,2})/", $contexte_inclus['date'], $matches)) {
	$contexte_inclus['annee'] = $matches[1];
	$contexte_inclus['mois'] = $matches[2];
}
else {
	$contexte_inclus['annee'] = date('Y');
	$contexte_inclus['mois'] = date('m');
}
include('inc-public.php3');

?>
