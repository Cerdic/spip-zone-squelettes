<?php 
// voir si 
if (strstr($contexte_inclus['bloc'], '..')) {
		die ("bloc = .. ?");
}
//TODO : placer ca ailleurs ...
$rep_fond="blocs";
//  valeurs par defaut
//TODO : verifier que c'est bien le delai du 
//squelette incluant qui est pris par defaut
$delais=3600;
$fond = $rep_fond."/_";
if ($contexte_inclus['bloc']) $fond = $rep_fond."/".$contexte_inclus['bloc'];
if ($contexte_inclus['bloc_delais']) $delais = $contexte_inclus['bloc_delais'];

include ("inc-public.php3");



?>