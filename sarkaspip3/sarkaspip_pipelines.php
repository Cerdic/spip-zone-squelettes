<?php
// Pipeline insert_head public
function SarkaSpip_insert_head($flux){
	// Recuperation des parametres cfg sur le menu des rubriques
	$position = lire_config('sarkaspip_menus/position_rubriques');
	if (!$position) $position = 1;
	$modele = lire_config('sarkaspip_menus/modele_rubriques');
	if (!$modele) $modele = 1;

	// Si le menu des rubriques est deroulant dans le bandeau
	if (($position == 5) && ($modele == 1))
		$flux .='<script src="'.url_absolue(find_in_path('scripts/menu_deroulant.js')).'" type="text/javascript"></script>';

	// Si le menu des rubriques est deroulant dans la colonne navigation
	if (($position == 1) && ($modele == 1))
		$flux .= 
			'<script type="text/javascript">
				jQuery(document).ready(function() {
					setHover()
				});
			</script>';

	return $flux;
}
?>
