<?php

function modif_mentions($row_mentions){

$row_mentions["eva_dir_pub"] = "Samuel";

echo $row_mentions["eva_dir_pub"];

	$table_mentions = 'eva_mentions';
	$champ = 'id_mentions';
   
   $rq_modif_mentions = "UPDATE eva_mentions SET 
   	eva_dir_pub='samuel',
   	eva_resp_redac='".$row_mentions["eva_resp_redac"]."',
   	eva_heb_site='".$row_mentions["eva_heb_site"]."',   	
   	eva_edit_site='".$row_mentions["eva_edit_site"]."',
   	eva_ref_charte='".$row_mentions["eva_ref_charte"]."',
   	WHERE id_mentions='1'";
	$resultat_modif_mentions = spip_query($rq_modif_mentions);
		
while ($row_mentions= spip_fetch_array($resultat_modif_mentions)){

	echo '<p>';
	echo _T('evainstall:dir_pub').$row_mentions["eva_dir_pub"]."<br />";
	
	echo _T('evainstall:resp_redac').$row_mentions["eva_resp_redac"]."<br />";

	echo _T('evainstall:heb_site').$row_mentions["eva_heb_site"]."<br />";	

	echo _T('evainstall:edit_site').$row_mentions["eva_edit_site"]."<br />";
	
	echo _T('evainstall:ref_charte').$row_mentions["eva_ref_charte"]."<br /><br />";	
	
	echo '</p>';
}

	
echo '<br>Modification de la table termin&eacute;e 3';
#return (generer_url_ecrire("eva_install"));


}
?>