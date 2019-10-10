<?php
function balise_ALIGNEMENTPAGINATION($p) {
	$test_align_pagin=sql_select('parametre4','spip_spipr_educ',"nom='graphisme_pagination' AND type='graphisme' AND nom_sauvegarde='en_cours_d_utilisation_SPIPr'");
	$tab_align_pagin=sql_fetch($test_align_pagin);
	$envoi='';
	$envoi.=$tab_align_pagin['parametre4'];
	$p->code = "'".$envoi."'";
	$p->interdire_scripts = false;
	return $p;
}
?>