<?php
function balise_SKELS($p) {
   return calculer_balise_dynamique($p,SKELS);       
}

function balise_SKELS_dyn($p) {
	$squel=array();
	$chemin=_DIR_PLUGIN_DATICE;
	$chemin=$chemin."inclusions";
	if ($handle = opendir($chemin)) {    		
    		while (false !== ($file = readdir($handle))) {
        	$squel[]=$file;
		
    		}	
	};
	$sk= substr($squel[$p],0,-5);
	return $sk;
}
?>
  




