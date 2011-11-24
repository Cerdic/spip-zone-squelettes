<?php
function balise_EVAFLASHLOGOBASTEST($p) {
	$titre=sql_select('id','spip_eva_habillage_images',"nom_habillage = 'Defaut' AND type = 'flash' AND nom_div = 'flash_secteur_barre_logo'");
	$envoi=sql_count($titre);
	$p->code = "'".$envoi."'";
	$p->interdire_scripts = false;
	return $p;
}
?>