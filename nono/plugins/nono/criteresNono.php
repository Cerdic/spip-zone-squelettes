<?php

// {edito}



function critere_edito($idb, &$boucles) {
  $boucle = &$boucles[$idb];
  $table = $boucle->id_table;
  $not = $param->not;

  if ($not) 
	$boucle->where[] = $table.".hauteur <= ".$table.".largeur";
  else
	$boucle->where[] = $table.".hauteur > ".$table.".largeur";
}

?>