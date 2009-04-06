<?php
	$GLOBALS['debut_intertitre'] = "<h2>";
	$GLOBALS['fin_intertitre'] = "</h2>";
	
	# suppression automatique de tous les numéros des titres
	$GLOBALS['table_des_traitements']['TITRE'][]= 'typo(supprimer_numero(%s))'; 
?>
