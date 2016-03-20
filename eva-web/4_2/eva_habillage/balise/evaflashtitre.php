<?php
function balise_EVAFLASHTITRE($p) {
	$titre=sql_select('nom_image , pos_x , pos_y , repetition','spip_eva_habillage_images',"nom_habillage = 'Defaut' AND type = 'flash' AND nom_div = 'flash_secteur_titre'");
	$titre_result=sql_fetch($titre);
	if ($titre_result['nom_image']=='') {return;}
	else {
		$envoi='<div style="text-align:center;"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab';
		if (isset($titre_result['repetition'])) {$envoi.='#version='.$titre_result['repetition'];}
		$envoi.='" width="'.$titre_result['pos_x'].'" height="'.$titre_result['pos_y'].'">';
		$envoi.="\n";
		$envoi.='<param name="movie" value="'._DIR_IMG.'eva_habillage/flash/'.$titre_result['nom_image'].'" />';
		$envoi.="\n";
		$envoi.='<param name="quality" value="high" />';
		$envoi.="\n";
		$envoi.='<embed src="'._DIR_IMG.'eva_habillage/flash/'.$titre_result['nom_image'].'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash"  width="'.$titre_result['pos_x'].'" height="'.$titre_result['pos_y'].'"></embed></object></div>';
		$p->code = "'".$envoi."'";
		$p->interdire_scripts = false;
		return $p;
	}
}
?>