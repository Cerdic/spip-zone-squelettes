<?php
// Pipeline insert_head public
function SarkaSpip_insert_head($flux){
	// Recuperation des parametres cfg sur le menu des rubriques
	$position = lire_config('sarkaspip_menus/position_rubriques', 1);
	$modele = lire_config('sarkaspip_menus/modele_rubriques', 1);
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

	// Insertion de la librairie jCarouselLite et des librairies connexes
	$flux .='<script src="'.url_absolue(find_in_path('scripts/jcarousellite_1.0.1.js')).'" type="text/javascript"></script>';
	$flux .='<script src="'.url_absolue(find_in_path('scripts/jquery.mousewheel.js')).'" type="text/javascript"></script>';

	// Insertion de la librairie Galleria et de ces css
// 	$flux .='<script src="'.url_absolue(find_in_path('scripts/jquery.galleria.js')).'" type="text/javascript"></script>';
// 	$flux .='<link rel="stylesheet" href="'.url_absolue(find_in_path('css/galleria.css')).'" type="text/css" />';

	// Insertion de la librairie Innerfade pour la noisette des sites favoris
	$position = lire_config('sarkaspip_noisettes/position_herbier', 0);
	$modele = lire_config('sarkaspip_noisettes/liste_herbier', 2);
	if (($position != 0) && ($modele == 2)) {
		$flux .='<script src="'.url_absolue(find_in_path('scripts/jquery.innerfade.js')).'" type="text/javascript"></script>';
	}
	
	return $flux;
}

// Pipeline "mes_fichiers_a_sauver" permettant de rajouter des fichiers ˆ sauvegarder dans le plugin Mes Fichiers 2
function SarkaSpip_mes_fichiers_a_sauver($flux){
	$tmp_fonds = defined('_DIR_TMP') ? _DIR_TMP.'fonds/': _DIR_RACINE.'tmp/fonds/';
	$tmp_styles = defined('_DIR_TMP') ? _DIR_TMP.'cfg/': _DIR_RACINE.'tmp/cfg/';

	// le repertoire des images de fonds pour les styles
	if (@is_dir($tmp_fonds))
		$flux[] = $tmp_fonds;
	// le repertoire sauvegardes du cfg des styles
	if (@is_dir($tmp_styles))
		$flux[] = $tmp_styles;

	spip_log('*** SarkaSpip_mes_fichiers_a_sauver ***');
	spip_log($flux);
	return $flux;
}
?>
