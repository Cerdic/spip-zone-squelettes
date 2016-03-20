<?php
function balise_EVAFLASHLOGOBLOCCODE($p) {
	$titre=sql_select('nom_image , pos_x , pos_y , repetition','spip_eva_habillage_images',"nom_habillage = 'Defaut' AND type = 'flash' AND nom_div = 'flash_secteur_sites_partenaires'");
	$envoi='';
	while ($row = sql_fetch($titre)) {
		$envoi.='<li><center>';
		$envoi.='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab';
		if (isset($row['repetition'])) {$envoi.='#version='.$row['repetition'];}
		$envoi.='" width="'.$row['pos_x'].'" height="'.$row['pos_y'].'" align="center">';
		$envoi.="\n";
		$envoi.='<param name="movie" value="'._DIR_IMG.'eva_habillage/flash/'.$row['nom_image'].'" align="center">';
		$envoi.="\n";
		$envoi.='<param name="quality" value="high">';
		$envoi.="\n";
		$envoi.='<embed src="'._DIR_IMG.'eva_habillage/flash/'.$row['nom_image'].'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"  width="'.$row['pos_x'].'" height="'.$row['pos_y'].'"></embed></object>';;
		$envoi.='</center></li>';
	}
	$p->code = "'".$envoi."'";
	$p->interdire_scripts = false;
	return $p;
}
?>